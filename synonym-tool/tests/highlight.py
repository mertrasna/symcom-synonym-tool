import unittest
from selenium import webdriver
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.common.by import By
from selenium.webdriver.common.action_chains import ActionChains
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
import mysql.connector
import time

# ---------------------------------------
# Configuration
# ---------------------------------------
DB_CONFIG = {
    "host": "localhost",
    "port": 6000,
    "user": "root",
    "password": "root",
    "database": "symcom_minified_db"
}

CHROME_DRIVER_PATH = "/usr/local/bin/chromedriver"
TARGET_URL = "http://localhost:8080/synonym-tool/all-symptoms.php?mid=5075"
TEST_TERMS = [
    {"word": "now and then", "synonym": "occasionally , every now and then , regularly", "expected_isyellow": 1, "expected_isgreen": 0},
    {"word": "powers", "synonym": "abilities", "expected_isyellow": 0, "expected_isgreen": 1}
]

# ---------------------------------------
# Utility Functions
# ---------------------------------------

def add_word_to_db(word, synonym=None, table="synonym_en"):
    word_count = len(word.strip().split())
    is_yellow = 1 if word_count > 1 else 0
    is_green = 1 if word_count == 1 else 0
    try:
        connection = mysql.connector.connect(**DB_CONFIG)
        cursor = connection.cursor()
        cursor.execute(f"SELECT synonym_id FROM {table} WHERE word = %s", (word,))
        if not cursor.fetchone():
            cursor.execute(
                f"INSERT INTO {table} (word, synonym, isyellow, isgreen) VALUES (%s, %s, %s, %s)",
                (word, synonym, is_yellow, is_green)
            )
            connection.commit()
            print(f"Inserted '{word}' with synonym '{synonym}', isyellow={is_yellow}, isgreen={is_green}")
        else:
            print(f"'{word}' already exists in the database.")
        cursor.close()
        connection.close()
    except Exception as e:
        raise Exception(f"Database error while inserting '{word}': {e}")

def get_word_flags(word, table="synonym_en"):
    connection = mysql.connector.connect(**DB_CONFIG)
    cursor = connection.cursor()
    cursor.execute(f"SELECT isyellow, isgreen FROM {table} WHERE word = %s", (word,))
    result = cursor.fetchone()
    cursor.close()
    connection.close()
    return result

def wait_for_term(driver, term, timeout=10):
    xpath = f"//span[contains(text(), '{term}')]"
    return WebDriverWait(driver, timeout).until(
        EC.presence_of_element_located((By.XPATH, xpath))
    )

def click_term_if_found(driver, term, wait_seconds=3):
    print(f"Searching for '{term}' on the page...")
    try:
        element = wait_for_term(driver, term)
        if element:
            print(f"Found '{term}'. Clicking...")
            ActionChains(driver).move_to_element(element).click().perform()
            time.sleep(wait_seconds)
            return True
        return False
    except Exception as e:
        print(f"Could not find '{term}': {e}")
        return False

# ---------------------------------------
# Test Case
# ---------------------------------------

class SynonymToolTest(unittest.TestCase):

    @classmethod
    def setUpClass(cls):
        print("Setting up test class...")
        for term in TEST_TERMS:
            add_word_to_db(term["word"], synonym=term["synonym"])
        cls.service = Service(CHROME_DRIVER_PATH)
        cls.driver = webdriver.Chrome(service=cls.service)
        cls.driver.get(TARGET_URL)
        cls.driver.maximize_window()
        WebDriverWait(cls.driver, 10).until(EC.presence_of_element_located((By.TAG_NAME, "body")))
        print("Page loaded.")

    @classmethod
    def tearDownClass(cls):
        print("Closing browser.")
        cls.driver.quit()

    def test_terms_highlight_and_flags(self):
        for term in TEST_TERMS:
            with self.subTest(term=term["word"]):
                print(f"Running test for: '{term['word']}'")
                found = click_term_if_found(self.driver, term["word"])
                self.assertTrue(found, f"Element for '{term['word']}' was not found on the page.")
                flags = get_word_flags(term["word"])
                self.assertIsNotNone(flags, f"'{term['word']}' not found in database.")
                self.assertEqual(flags[0], term["expected_isyellow"], f"{term['word']} isyellow mismatch")
                self.assertEqual(flags[1], term["expected_isgreen"], f"{term['word']} isgreen mismatch")
                print(f"Flag validation passed for '{term['word']}'\n")

# ---------------------------------------
# Run the test
# ---------------------------------------

if __name__ == "__main__":
    unittest.main(verbosity=2)
