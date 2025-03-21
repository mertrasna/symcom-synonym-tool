import unittest
import mysql.connector
import time
import random
import string
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.common.exceptions import ElementClickInterceptedException

DB_CONFIG = {
    "host": "localhost",
    "port": 6000,
    "user": "root",
    "password": "root",
    "database": "symcom_minified_db",
    "charset": "utf8mb4"
}

def clean_word(word):
    return word.translate(str.maketrans('', '', string.punctuation)).strip().lower()

class SynonymEnBlueWordTest(unittest.TestCase):

    @classmethod
    def setUpClass(cls):
        chrome_options = webdriver.ChromeOptions()
        chrome_options.set_capability("goog:loggingPrefs", {"browser": "ALL"})
        cls.driver = webdriver.Chrome(options=chrome_options)
        cls.driver.get("http://localhost:8080/synonym-tool/all-symptoms.php?mid=5075")
        cls.driver.maximize_window()

    def submit_form_and_handle_alert(self):
        driver = self.driver
        submit_button = WebDriverWait(driver, 10).until(
            EC.element_to_be_clickable((By.ID, "submitSynonyms"))
        )
        time.sleep(0.5)
        submit_button.click()
        WebDriverWait(driver, 10).until(EC.alert_is_present())
        alert = driver.switch_to.alert
        alert_text = alert.text
        alert.accept()
        time.sleep(2)
        return alert_text

    def test_blue_words_root_and_checkbox(self):
        driver = self.driver

        print("\n=== TEST: Multiple Blue Words - One Checkbox Each ===")

        non_green_words = WebDriverWait(driver, 10).until(
            EC.presence_of_all_elements_located((By.CSS_SELECTOR, ".synonym-word:not(.green)"))
        )

        random.shuffle(non_green_words)
        words_tested = 0
        tested_pairs = []

        for selected_elem in non_green_words:
            if words_tested >= 3:
                break

            try:
                raw_word = selected_elem.get_attribute("data-word").strip()
                cleaned_word = clean_word(raw_word)
                if cleaned_word.isnumeric():
                    print(f"Skipping numeric word: '{cleaned_word}'")
                    continue

                driver.execute_script("arguments[0].scrollIntoView(true);", selected_elem)
                time.sleep(0.5)
                selected_elem.click()
                time.sleep(0.8)
                selected_elem.click()
                print(f"Clicked blue word: '{raw_word}' → normalized: '{cleaned_word}'")
            except ElementClickInterceptedException:
                print(f"Skipping: Click intercepted for word: '{raw_word}'")
                continue

            try:
                WebDriverWait(driver, 3).until(
                    EC.presence_of_element_located((By.ID, "synonymTable"))
                )
                time.sleep(1.2)
            except:
                print(f"Skipping: No synonym table loaded for word: {cleaned_word}")
                continue

            toggle_button = WebDriverWait(driver, 5).until(
                EC.element_to_be_clickable((By.ID, "toggleAllSBtn"))
            )
            toggle_button.click()
            time.sleep(0.5)
            toggle_button.click()
            print("Clicked 'Toggle All S' twice.")

            all_rows = driver.find_elements(By.CSS_SELECTOR, "#synonymTable tbody tr")
            synonym_rows = [row for row in all_rows if "manualSynonym" not in row.get_attribute("innerHTML")]
            if not synonym_rows:
                print("Skipping: No synonym rows loaded.")
                continue

            selected_row = random.choice(synonym_rows)
            synonym_word = selected_row.find_elements(By.TAG_NAME, "td")[-1].text.strip()
            normalized_synonym = clean_word(synonym_word)
            print(f"Selected synonym: '{synonym_word}' → normalized: '{normalized_synonym}'")

            categories = ['S', 'Q', 'O', 'U']
            random_cat = random.choice(categories)

            s_checkbox = selected_row.find_element(By.CSS_SELECTOR, "input[name='S']")
            if not s_checkbox.is_selected():
                s_checkbox.click()

            checkbox = selected_row.find_element(By.CSS_SELECTOR, f"input[name='{random_cat}']")
            if checkbox.is_selected():
                checkbox.click()
            checkbox.click()
            print(f"Checked category '{random_cat}' for word '{normalized_synonym}' (S also checked to ensure root_word is saved)")

            new_root_word = f"root_{random.randint(1000,9999)}"
            root_input = driver.find_element(By.ID, "root-word")
            root_input.clear()
            root_input.send_keys(new_root_word)
            print(f"Entered new root word: {new_root_word}")

            time.sleep(0.5)
            alert_text = self.submit_form_and_handle_alert()
            print(f"Alert: {alert_text}")
            self.assertIn("updated successfully", alert_text.lower())

            tested_pairs.append((cleaned_word, new_root_word, normalized_synonym, random_cat))
            words_tested += 1

        if not tested_pairs:
            self.fail("No valid blue words with synonym tables were found.")

        for cleaned_word, expected_root, normalized_synonym, random_cat in tested_pairs:
            print(f"\nQuerying DB for: {cleaned_word}")
            try:
                connection = mysql.connector.connect(**DB_CONFIG)
                cursor = connection.cursor(dictionary=True)
                cursor.execute("""
                    SELECT root_word, synonym, cross_reference, generic_term, sub_term 
                    FROM synonym_en WHERE LOWER(word) = LOWER(%s)
                """, (cleaned_word,))
                result = cursor.fetchone()
                cursor.close()
                connection.close()
            except mysql.connector.Error as e:
                self.fail(f"Database Error: {e}")

            print("DB Result Row:", result)
            self.assertIsNotNone(result, f"No DB row found for word: {cleaned_word}")
            self.assertIsNotNone(result['root_word'], f"DB row found, but root_word is NULL for: {cleaned_word}")
            self.assertEqual(result['root_word'].lower(), expected_root.lower(),
                             f"Expected root word '{expected_root}', got '{result['root_word']}'")

            field_map = {
                'S': result['synonym'],
                'Q': result['cross_reference'],
                'O': result['generic_term'],
                'U': result['sub_term']
            }

            print("\nValidating checkbox state in DB:")
            field_value = field_map[random_cat] or ""
            tokens = [clean_word(w) for w in field_value.split(',') if w.strip()]
            in_db = normalized_synonym in tokens
            print(f"{random_cat}: '{field_value}' → tokens: {tokens}")
            self.assertTrue(in_db, f"Expected '{normalized_synonym}' in {random_cat}, but it was missing.")
            print(" DB assertion passed for blue word.")

    @classmethod
    def tearDownClass(cls):
        time.sleep(1)
        cls.driver.quit()

if __name__ == "__main__":
    unittest.main()
