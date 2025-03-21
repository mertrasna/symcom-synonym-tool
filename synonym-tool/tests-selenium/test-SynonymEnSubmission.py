import unittest
import mysql.connector
import time
import random
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC

DB_CONFIG = {
    "host": "localhost",
    "port": 6000,
    "user": "root",
    "password": "root",
    "database": "symcom_minified_db",
    "charset": "utf8mb4"
}

class SynonymEnSubmission(unittest.TestCase):

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
        submit_button.click()
        WebDriverWait(driver, 10).until(EC.alert_is_present())
        alert = driver.switch_to.alert
        alert_text = alert.text
        alert.accept()
        time.sleep(2)
        return alert_text

    def test_synonym_en_submission(self):
        driver = self.driver

        print("\n=== TEST: Synonym_EN Submission with Random Checkbox States ===")

        # Step 1: Click a green word
        green_words = WebDriverWait(driver, 10).until(
            EC.presence_of_all_elements_located((By.CSS_SELECTOR, ".synonym-word.green"))
        )
        self.assertTrue(green_words, "No green words found to select.")

        selected_elem = random.choice(green_words)
        green_word = selected_elem.get_attribute("data-word").strip()
        selected_elem.click()
        time.sleep(1)
        selected_elem.click()  # to fully load form

        print(f"Clicked green word: '{green_word}'")

        # Step 2: Wait for form to load
        WebDriverWait(driver, 10).until(
            EC.presence_of_element_located((By.ID, "root-word"))
        )
        time.sleep(1)

        # Step 3: Pick a random synonym from the table
        all_rows = driver.find_elements(By.CSS_SELECTOR, "#synonymTable tbody tr")
        synonym_rows = [row for row in all_rows if "manualSynonym" not in row.get_attribute("innerHTML")]
        self.assertTrue(synonym_rows, "No synonym rows found.")

        selected_row = random.choice(synonym_rows)
        synonym_word = selected_row.find_elements(By.TAG_NAME, "td")[-1].text.strip()
        normalized_word = synonym_word.strip().rstrip("),.").lower()

        print(f"Selected synonym: '{synonym_word}'")

        # Step 4: Randomly check/uncheck S, Q, O, U
        categories = ['S', 'Q', 'O', 'U']
        checked_categories = []

        for cat in categories:
            checkbox = selected_row.find_element(By.CSS_SELECTOR, f"input[name='{cat}']")
            should_check = random.choice([True, False])

            if checkbox.is_selected() and not should_check:
                checkbox.click()
            elif not checkbox.is_selected() and should_check:
                checkbox.click()

            if should_check:
                checked_categories.append(cat)

        print(f"Checked categories for '{synonym_word}': {checked_categories}")

        # Step 5: Enter a new root word
        new_root_word = f"root_{random.randint(1000,9999)}"
        root_input = driver.find_element(By.ID, "root-word")
        root_input.clear()
        root_input.send_keys(new_root_word)
        print(f"Entered root word: {new_root_word}")

        # Step 6: Submit
        alert_text = self.submit_form_and_handle_alert()
        print(f"Alert received: {alert_text}")
        self.assertIn("updated successfully", alert_text.lower())

        # Step 7: Query DB for the green word
        print(f"Querying DB for: '{green_word}'")
        try:
            connection = mysql.connector.connect(**DB_CONFIG)
            cursor = connection.cursor(dictionary=True)
            query = """
                SELECT root_word, synonym, cross_reference, generic_term, sub_term 
                FROM synonym_en WHERE LOWER(word) = LOWER(%s)
            """
            cursor.execute(query, (green_word,))
            result = cursor.fetchone()
            cursor.close()
            connection.close()
        except mysql.connector.Error as e:
            self.fail(f"Database Error: {e}")

        self.assertIsNotNone(result, f"No record found for word: {green_word}")
        print(f"DB row: {result}")

        self.assertEqual(result['root_word'].lower(), new_root_word.lower(),
                         f"Expected root word '{new_root_word}', got '{result['root_word']}'")

        field_map = {
            'S': result['synonym'],
            'Q': result['cross_reference'],
            'O': result['generic_term'],
            'U': result['sub_term']
        }

        for cat in categories:
            field_value = field_map[cat] or ""
            in_db = normalized_word in field_value.lower()
            should_be_present = cat in checked_categories

            print(f"{cat} field value: '{field_value}'")
            if should_be_present:
                self.assertTrue(in_db, f"Expected '{normalized_word}' in {cat}, but it was missing.")
            else:
                self.assertFalse(in_db, f"Did not expect '{normalized_word}' in {cat}, but it was present.")

        print("✅ All assertions passed.")

    @classmethod
    def tearDownClass(cls):
        time.sleep(1)
        cls.driver.quit()

if __name__ == "__main__":
    unittest.main()
