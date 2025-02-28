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
        # Update the URL if needed
        cls.driver.get("http://localhost:8080/synonym-tool/all-symptoms.php?mid=5072")
        cls.driver.maximize_window()

    def test_no_synonyms_found_buttons(self):
        """
        Force a word with no synonyms by modifying a synonym element's data-word to a test word.
        Then click that element, and verify that:
          - The "korrekturen" button's href is set correctly.
          - The "woerterbuchnetz" button's href is set correctly.
        """
        driver = self.driver
        test_word = "(Whl.)."  # Test word per your sample HTML

        # Locate any synonym element (assumes at least one exists)
        synonym_elem = WebDriverWait(driver, 10).until(
            EC.presence_of_element_located((By.CSS_SELECTOR, ".synonym-word"))
        )

        # Force the element's data-word attribute to our test word.
        driver.execute_script("arguments[0].setAttribute('data-word', arguments[1]);", synonym_elem, test_word)
        print(f"Forced a synonym element's data-word to '{test_word}'.")

        # Simulate clicking the synonym.
        synonym_elem.click()
        print(f"Clicked on the synonym element for '{test_word}'.")

        # (Optional) Wait until any error message or UI update occurs.
        # Here we simply proceed to verify the button hrefs.

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
        expected_woerterbuchnetz_href = "https://www.woerterbuchnetz.de/"  # Adjusted to include trailing slash
        actual_woerterbuchnetz_href = woerterbuchnetz_btn.get_attribute("href")
        print(f"Wörterbuchnetz button href: '{actual_woerterbuchnetz_href}'")
        self.assertEqual(actual_woerterbuchnetz_href, expected_woerterbuchnetz_href,
                         "The Wörterbuchnetz button's href is not set correctly.")

        print(" No synonyms found test passed: Correct external button URLs displayed.")

    @classmethod
    def tearDownClass(cls):
        """Close the WebDriver session."""
        time.sleep(2)
        cls.driver.quit()

if __name__ == "__main__":
    unittest.main()
