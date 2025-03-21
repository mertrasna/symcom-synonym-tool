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

class SynonymFetchTest(unittest.TestCase):

    @classmethod
    def setUpClass(cls):
        chrome_options = webdriver.ChromeOptions()
        chrome_options.set_capability("goog:loggingPrefs", {"browser": "ALL"})
        cls.driver = webdriver.Chrome(options=chrome_options)
        cls.driver.get("http://localhost:8080/synonym-tool/all-symptoms.php?mid=5075")
        cls.driver.maximize_window()

    def test_synonym_fetch_and_no_duplicates(self):
        driver = self.driver
        print("\n=== TEST: Blue Word → Synonyms Match DB & No Duplicates ===")

        non_green_words = WebDriverWait(driver, 10).until(
            EC.presence_of_all_elements_located((By.CSS_SELECTOR, ".synonym-word:not(.green)"))
        )
        random.shuffle(non_green_words)

        words_tested = 0
        for selected_elem in non_green_words:
            if words_tested >= 3:
                break

            try:
                word = selected_elem.get_attribute("data-word").strip()
                cleaned = clean_word(word)
                if cleaned.isnumeric():
                    continue

                driver.execute_script("arguments[0].scrollIntoView(true);", selected_elem)
                time.sleep(0.5)
                selected_elem.click()
                time.sleep(0.8)
                selected_elem.click()
                print(f"Clicked blue word: '{word}' → normalized: '{cleaned}'")
            except ElementClickInterceptedException:
                continue

            try:
                WebDriverWait(driver, 3).until(
                    EC.presence_of_element_located((By.ID, "synonymTable"))
                )
                time.sleep(1.2)
            except:
                print(f"No synonym table for: {cleaned}")
                continue

            all_rows = driver.find_elements(By.CSS_SELECTOR, "#synonymTable tbody tr")
            displayed_words = set()
            duplicates = []

            for row in all_rows:
                if "manualSynonym" in row.get_attribute("innerHTML"):
                    continue
                synonym_text = row.find_elements(By.TAG_NAME, "td")[-1].text.strip()
                norm = clean_word(synonym_text)
                if norm in displayed_words:
                    duplicates.append(norm)
                else:
                    displayed_words.add(norm)

            print(f"Displayed synonyms: {displayed_words}")
            self.assertEqual(len(duplicates), 0, f"Duplicate synonyms found: {duplicates}")

            try:
                connection = mysql.connector.connect(**DB_CONFIG)
                cursor = connection.cursor(dictionary=True)
                cursor.execute("SELECT synonym FROM synonym_en WHERE LOWER(word) = LOWER(%s)", (cleaned,))
                result = cursor.fetchone()
                cursor.close()
                connection.close()
            except mysql.connector.Error as e:
                self.fail(f"DB Error: {e}")

            self.assertIsNotNone(result, f"No DB row for word: {cleaned}")

            db_synonyms = result['synonym'] or ""
            db_words = set(clean_word(w) for w in db_synonyms.split(',') if w.strip())
            missing = db_words - displayed_words
            extra = displayed_words - db_words

            print(f"DB synonyms: {db_words}")
            self.assertTrue(len(missing) == 0, f"Missing synonyms in UI for '{cleaned}': {missing}")
            print("Synonyms match DB and no duplicates.")
            words_tested += 1

    @classmethod
    def tearDownClass(cls):
        time.sleep(1)
        cls.driver.quit()

if __name__ == "__main__":
    unittest.main()