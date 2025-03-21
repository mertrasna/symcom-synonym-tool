import unittest
import time
from selenium import webdriver
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.common.by import By
from selenium.webdriver.common.action_chains import ActionChains
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from webdriver_manager.chrome import ChromeDriverManager  # ✅ NEW

# -------------------------------------------------------------------
# Configuration
# -------------------------------------------------------------------
TARGET_URL = "http://localhost:8080/synonym-tool/all-symptoms.php?mid=5072"

class HoverSynonymPopupTest(unittest.TestCase):

    @classmethod
    def setUpClass(cls):
        print("\n========== Test Setup ==========")
        print("Launching browser and navigating to the test page...")
        # ✅ Automatically handles the ChromeDriver installation and setup
        cls.driver = webdriver.Chrome(service=Service(ChromeDriverManager().install()))
        cls.driver.get(TARGET_URL)
        cls.driver.maximize_window()
        WebDriverWait(cls.driver, 10).until(
            EC.presence_of_element_located((By.TAG_NAME, "body"))
        )
        print("Page loaded successfully.\n")

    @classmethod
    def tearDownClass(cls):
        print("\n========== Test Teardown ==========")
        print("Closing browser.")
        cls.driver.quit()

    def get_popup_content(self):
        """Retrieve the content of the popup box displayed on hover."""
        return self.driver.execute_script(
            "return document.getElementById('popup-box')?.innerText;"
        ).strip()

    def normalize_popup_text(self, text):
        """Normalize popup text by removing leading whitespace and filtering out the 'Word:' line."""
        lines = [
            line.strip() for line in text.splitlines()
            if line.strip() and not line.startswith("Word:")
        ]
        return "\n".join(lines)

    def click_on_word(self, word):
        """Click the specified word to trigger DB update/highlighting."""
        print(f"[ACTION] Clicking on word: '{word}'")
        try:
            element = WebDriverWait(self.driver, 10).until(
                EC.presence_of_element_located(
                    (By.XPATH, f"//span[normalize-space(text())='{word}']")
                )
            )
            ActionChains(self.driver).move_to_element(element).click().perform()
            print(f"[INFO] Clicked on '{word}'. Waiting for backend processing...")
            time.sleep(5)
        except Exception as e:
            print(f"[ERROR] Failed to click on '{word}': {e}")

    def hover_over_word(self, word):
        """Hover over the specified word and capture popup content."""
        print(f"[ACTION] Hovering over word: '{word}'")
        element = WebDriverWait(self.driver, 10).until(
            EC.presence_of_element_located(
                (By.XPATH, f"//span[normalize-space(text())='{word}']")
            )
        )
        ActionChains(self.driver).move_to_element(element).perform()
        time.sleep(5)
        popup_text = self.get_popup_content()
        print(f"[RESULT] Popup content for '{word}':\n{popup_text}\n")
        return popup_text

    def test_hover_over_augen_variants(self):
        print("\n========== Running Hover Comparison Test ==========")

        # Step 1: Click both words to ensure they are processed
        self.click_on_word("Augen")
        self.click_on_word("Augen,")

        # Step 2: Hover over each word and capture popup content
        popup_augen = self.hover_over_word("Augen")
        popup_augen_comma = self.hover_over_word("Augen,")

        # Step 3: Normalize the popup text for comparison
        norm_augen = self.normalize_popup_text(popup_augen)
        norm_augen_comma = self.normalize_popup_text(popup_augen_comma)

        print("========== Comparing Normalized Popup Content ==========")
        print("[Normalized] 'Augen':")
        print(norm_augen)
        print("\n[Normalized] 'Augen,':")
        print(norm_augen_comma)

        # Step 4: Assert equality of hover popups
        self.assertEqual(
            norm_augen,
            norm_augen_comma,
            "Synonym hover popups for 'Augen' and 'Augen,' should be identical after normalization."
        )
        print("\nTest Passed: Hover popup content is consistent for both word variants.")

# -------------------------------------------------------------------
# Entry Point
# -------------------------------------------------------------------
if __name__ == "__main__":
    unittest.main(verbosity=2)
