import unittest
import time
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC

class NoSynonymsFoundTest(unittest.TestCase):
    @classmethod
    def setUpClass(cls):
        """Set up WebDriver and navigate to the synonym tool page."""
        chrome_options = webdriver.ChromeOptions()
        chrome_options.set_capability("goog:loggingPrefs", {"browser": "ALL"})
        cls.driver = webdriver.Chrome(options=chrome_options)
        cls.driver.get("http://localhost:8080/synonym-tool/all-symptoms.php?mid=5072")
        cls.driver.maximize_window()

    def test_no_synonyms_found_buttons(self):
        """
        Force a word with no synonyms by modifying a synonym element's data-word to a test word.
        Then click that element, wait for an error message indicating no synonyms were found,
        and verify that:
          - The "korrekturen" button's href is set correctly.
          - The "woerterbuchnetz" button's href is set correctly.
        """
        driver = self.driver
        test_word = "nonexistentword"  # Test word expected to yield no synonyms

        # Locate any synonym element 
        synonym_elem = WebDriverWait(driver, 10).until(
            EC.presence_of_element_located((By.CSS_SELECTOR, ".synonym-word"))
        )

        # Force the element's data-word attribute to our test word.
        driver.execute_script("arguments[0].setAttribute('data-word', arguments[1]);", synonym_elem, test_word)
        print(f"Forced a synonym element's data-word to '{test_word}'.")

        # Simulate clicking the synonym.
        synonym_elem.click()
        print(f"Clicked on the synonym element for '{test_word}'.")

        # Wait until an error message appears indicating no synonyms were found.
        WebDriverWait(driver, 10).until(
            lambda d: "No synonyms found" in d.page_source or "Keine Synonyme gefunden" in d.page_source
        )
        print("Detected error message indicating no synonyms found for the test word.")

        # Verify that the error message references the test word.
        self.assertIn(test_word, driver.page_source,
                      "The error message does not reference the test word.")

        # Verify the "korrekturen" button.
        korrekturen_btn = WebDriverWait(driver, 10).until(
            EC.presence_of_element_located((By.ID, "korrekturen-btn"))
        )
        expected_korrekturen_href = f"https://www.korrekturen.de/synonyme/{test_word}/"
        actual_korrekturen_href = korrekturen_btn.get_attribute("href")
        print(f"Korrekturen button href: '{actual_korrekturen_href}'")
        self.assertEqual(actual_korrekturen_href, expected_korrekturen_href,
                         "The korrekturen button's href is not set correctly.")

        # Verify the "woerterbuchnetz" button.
        woerterbuchnetz_btn = driver.find_element(By.ID, "woerterbuchnetz-btn")
        expected_woerterbuchnetz_href = "https://www.woerterbuchnetz.de/"
        actual_woerterbuchnetz_href = woerterbuchnetz_btn.get_attribute("href")
        print(f"Wörterbuchnetz button href: '{actual_woerterbuchnetz_href}'")
        self.assertEqual(actual_woerterbuchnetz_href, expected_woerterbuchnetz_href,
                         "The Wörterbuchnetz button's href is not set correctly.")

        print("No synonyms found test passed: Correct error message and external button URLs displayed.")

    @classmethod
    def tearDownClass(cls):
        """Close the WebDriver session."""
        time.sleep(2)
        cls.driver.quit()

if __name__ == "__main__":
    unittest.main()
