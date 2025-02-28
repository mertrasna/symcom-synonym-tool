import unittest
import mysql.connector
import time
import random
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.common.exceptions import StaleElementReferenceException

# MySQL Configuration
DB_CONFIG = {
    "host": "localhost",
    "port": 6000,  # Change if needed
    "user": "root",
    "password": "root",
    "database": "symcom_minified_db",
    "charset": "utf8mb4"  # Ensures special characters are handled
}

class RootWordUpdateTest(unittest.TestCase):

    @classmethod
    def setUpClass(cls):
        """Initialize WebDriver and navigate to the synonym tool page."""
        chrome_options = webdriver.ChromeOptions()
        chrome_options.set_capability("goog:loggingPrefs", {"browser": "ALL"})
        cls.driver = webdriver.Chrome(options=chrome_options)
        cls.driver.get("http://localhost:8080/synonym-tool/all-symptoms.php?mid=5072")
        cls.driver.maximize_window()

    def click_synonym(self, synonym_element, times=1):
        """Click a synonym element a specified number of times with a delay."""
        for i in range(times):
            synonym_element.click()
            print(f"Clicked synonym ({i+1}/{times}).")
            time.sleep(1)

    def submit_form_and_handle_alert(self):
        """Clicks the submit button and handles the alert."""
        driver = self.driver
        submit_button = WebDriverWait(driver, 10).until(
            EC.element_to_be_clickable((By.ID, "submitSynonyms"))
        )
        submit_button.click()
        print("Submit button clicked.")
        WebDriverWait(driver, 10).until(EC.alert_is_present())
        alert = driver.switch_to.alert
        alert_text = alert.text
        print(f"Alert text: '{alert_text}'")
        alert.accept()
        time.sleep(2)
        return alert_text

    def get_root_word_from_db(self, word):
        """Query the database for the root_word corresponding to the given word."""
        query = "SELECT root_word FROM synonym_de WHERE word = %s"
        try:
            connection = mysql.connector.connect(**DB_CONFIG)
            connection.autocommit = True
            cursor = connection.cursor()
            cursor.execute(query, (word,))
            result = cursor.fetchone()
            cursor.close()
            connection.close()
            if result:
                return result[0]
            return None
        except mysql.connector.Error as e:
            print(f"Database Error: {e}")
            return None

    def test_rootword_update(self):
        """
        Test steps:
        1. Randomly select one green word and submit its default root word.
        2. After submission, locate the previously selected word and reload its form.
        3. Update the root word input with a new value and submit again.
        4. Verify in the DB that the root_word was updated.
        """
        driver = self.driver

        print("\n=== Part 1: Submit Default Root Word ===\n")
        # Select a random green word.
        green_words = WebDriverWait(driver, 10).until(
            EC.presence_of_all_elements_located((By.CSS_SELECTOR, ".synonym-word.green"))
        )
        if not green_words:
            self.fail("No green synonyms found.")
        green_word = random.choice(green_words)
        selected_word = green_word.get_attribute("data-word").strip()
        print(f"Randomly selected Green Word: '{selected_word}'")

        # Ensure the selection event is triggered by clicking twice.
        self.click_synonym(green_word, times=2)

        # Submit the form and verify default value is saved.
        alert_text = self.submit_form_and_handle_alert()
        self.assertIn("updated successfully", alert_text.lower(), "Default submission did not succeed.")

        saved_root = self.get_root_word_from_db(selected_word)
        print(f"Default root word in DB for '{selected_word}': '{saved_root}'")
        self.assertEqual(saved_root.lower(), selected_word.lower(),
                         f"Expected default root word '{selected_word}', but got '{saved_root}'")
        print("Default root word saved correctly.\n")

        print("\n=== Part 2: Update Root Word ===\n")
        # Reload the previously selected word by locating it via its data-word attribute.
        prev_word_xpath = f"//span[@data-word='{selected_word}']"
        prev_word_elem = WebDriverWait(driver, 10).until(
            EC.presence_of_element_located((By.XPATH, prev_word_xpath))
        )
        prev_word_elem.click()
        print(f"Reloaded form for previously selected word '{selected_word}'.")
        time.sleep(1)

        # Update the root word input with a new value.
        new_root_value = "new_root_value"
        root_input = WebDriverWait(driver, 10).until(
            EC.presence_of_element_located((By.ID, "root-word"))
        )
        root_input.clear()
        root_input.send_keys(new_root_value)
        print(f"Entered new root word: '{new_root_value}'")

        # Submit the updated form.
        alert_text = self.submit_form_and_handle_alert()
        self.assertIn("updated successfully", alert_text.lower(), "Updated submission did not succeed.")

        updated_saved_root = self.get_root_word_from_db(selected_word)
        print(f"Updated root word in DB for '{selected_word}': '{updated_saved_root}'")
        self.assertEqual(updated_saved_root.lower(), new_root_value.lower(),
                         f"Expected updated root word '{new_root_value}', but got '{updated_saved_root}'")
        print("Root word updated correctly in the database.\n")

    @classmethod
    def tearDownClass(cls):
        """Close the WebDriver session."""
        time.sleep(1)
        cls.driver.quit()

if __name__ == "__main__":
    unittest.main()
