import unittest
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
import time
import random

class SynonymizingToolTests(unittest.TestCase):
    @classmethod
    def setUpClass(cls):
        """ Setup WebDriver (Runs Once for All Tests) """
        cls.driver = webdriver.Chrome()
        cls.driver.get("http://localhost:8080/")
        cls.driver.maximize_window()

    def setUp(self):
        """ Runs Before Each Test Case (No Refresh) """
        pass 

    def test_navigation_ui_interactions(self):
        """  Test 1: Navigation and UI Interactions """
        print("\n" + "="*50)
        print("TEST 1: Navigation & UI Interactions")
        print("="*50)

        steps = [
            ("Materia Medica", "//a[contains(@href, 'materia-medica.php')]"),
            ("SEARCH", "//button[normalize-space()='SEARCH']"),
            ("Synonym Classification", "//a[@title='Synonyms classification']/i"),
        ]

        for label, xpath in steps:
            WebDriverWait(self.driver, 10).until(EC.element_to_be_clickable((By.XPATH, xpath))).click()
            print(f" Clicked on: {label}")

        # Toggle worksheet view
        toggle_arrow = WebDriverWait(self.driver, 10).until(
            EC.element_to_be_clickable((By.ID, "toggleView"))
        )

        toggle_arrow.click()
        print(" Expanded Worksheet View")
        time.sleep(1)

        toggle_arrow.click()
        print(" Returned to Split-Screen View")
        print("="*50 + "\n")

    def test_scroll_and_navigation(self):
        """  Test 2: Scroll Symptoms Without Refreshing """
        print("\n" + "="*50)
        print("TEST 2: Scroll & Navigation")
        print("="*50)

        symptom_list = WebDriverWait(self.driver, 10).until(
            EC.presence_of_element_located((By.ID, "symptom-list-container"))
        )

        self.driver.execute_script("arguments[0].scrollTop += 400", symptom_list)  # Scroll down
        time.sleep(1)
        print(" Scrolled DOWN Symptoms List")

        self.driver.execute_script("arguments[0].scrollTop -= 400", symptom_list)  # Scroll up
        time.sleep(1)
        print(" Scrolled UP Symptoms List")
        print("="*50 + "\n")

    def test_stop_words_exclusion(self):
        """  Test 3: Stop Words Exclusion (Check Only 1 Symptom, No Repeats) """
        print("\n" + "="*50)
        print("TEST 3: Stop Words Exclusion")
        print("="*50)

        symptom = WebDriverWait(self.driver, 10).until(
            EC.element_to_be_clickable((By.XPATH, "(//li[contains(@class, 'symptom-item')])[1]"))
        )
        symptom.click()
        print(" Selected a Symptom to Check Stop Words")

        stop_words = symptom.find_elements(By.XPATH, ".//span[contains(@class, 'stopword')]")

        if stop_words:
            print(" Stop Words Found:")
            for stop_word in stop_words:
                print(f"   - {stop_word.text}")
        else:
            print("❌ No Stop Words Found in this Symptom")

        print("="*50 + "\n")

    def test_symptom_selection_and_synonym_click(self):
        """  Test 4: Click ONE Symptom, Print All Synonyms, and Repeat for Random Symptom """
        print("\n" + "="*50)
        print("TEST 4: Symptom Selection & Verification")
        print("="*50)

        #  click a symptom
        symptom = WebDriverWait(self.driver, 10).until(
            EC.element_to_be_clickable((By.XPATH, "(//li[contains(@class, 'symptom-item')])[1]"))
        )
        symptom_text = symptom.text
        symptom.click()
        print(f" Clicked on Symptom: {symptom_text}")

        worksheet_entry = WebDriverWait(self.driver, 10).until(
            EC.presence_of_element_located((By.ID, "symptom-details"))
        )
        self.assertIn(symptom_text, worksheet_entry.text, "Symptom did not appear in the worksheet!")
        print(" Verified Symptom in Worksheet")

        #  find all synonyms (blue words) and print them
        synonym_words = worksheet_entry.find_elements(By.XPATH, ".//span[contains(@class, 'synonym-word')]")

        if synonym_words:
            print(" Synonyms Found:")
            for synonym in synonym_words:
                print(f"   - {synonym.text}")
        else:
            print("❌ No Synonyms Found")

        #  click on one synonym to verify clickability
        if synonym_words:
            synonym_words[0].click()
            print(" Synonym Clicked")

        print("="*50 + "\n")

        # step 5: Repeat for Random Symptom after Step 4
        print("\n" + "="*50)
        print("TEST 5: Repeat for Random Symptom after Step 4")
        print("="*50)

        # get all symptoms (excluding the one already clicked)
        symptoms = WebDriverWait(self.driver, 10).until(
            EC.presence_of_all_elements_located((By.XPATH, "//li[contains(@class, 'symptom-item')]"))
        )
        
        # exclude the already clicked symptom
        random_symptom = random.choice(symptoms[1:])  # Skip the first symptom already clicked
        random_symptom_text = random_symptom.text
        random_symptom.click()
        print(f" Clicked on Random Symptom: {random_symptom_text}")

        worksheet_entry = WebDriverWait(self.driver, 10).until(
            EC.presence_of_element_located((By.ID, "symptom-details"))
        )
        self.assertIn(random_symptom_text, worksheet_entry.text, "Symptom did not appear in the worksheet!")
        print(" Verified Random Symptom in Worksheet")

        # repeat Step 3: Check Stop Words
        stop_words = random_symptom.find_elements(By.XPATH, ".//span[contains(@class, 'stopword')]")
        if stop_words:
            print(" Stop Words Found:")
            for stop_word in stop_words:
                print(f"   - {stop_word.text}")
        else:
            print("❌ No Stop Words Found in this Symptom")

        # repeat Step 4: Find and click Synonyms
        synonym_words = worksheet_entry.find_elements(By.XPATH, ".//span[contains(@class, 'synonym-word')]")
        if synonym_words:
            print(" Synonyms Found:")
            for synonym in synonym_words:
                print(f"   - {synonym.text}")
            synonym_words[0].click()
            print(" Synonym Clicked")

        print("="*50 + "\n")

    @classmethod
    def tearDownClass(cls):
        """ Close WebDriver (Runs Once After All Tests) """
        time.sleep(2)  
        cls.driver.quit()


if __name__ == "__main__":
    unittest.main()
