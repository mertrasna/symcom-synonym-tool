import unittest
import mysql.connector
import random
import re
import time
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.common.exceptions import StaleElementReferenceException

#  MySQL Configuration
DB_CONFIG = {
    "host": "localhost",
    "port": 6000, 
    "user": "root",
    "password": "root",
    "database": "symcom_minified_db",
    "charset": "utf8mb4"  
}

class SynonymizingToolTests(unittest.TestCase):
    @classmethod
    def setUpClass(cls):
        """  Setup WebDriver with Logging Enabled """
        chrome_options = webdriver.ChromeOptions()
        chrome_options.set_capability("goog:loggingPrefs", {"browser": "ALL"})  
        cls.driver = webdriver.Chrome(options=chrome_options)
        cls.driver.get("http://localhost:8080/synonym-tool/all-symptoms.php?mid=5072")  
        cls.driver.maximize_window()

    def test_find_synonyms_until_3_found(self):
        """  Click Synonyms Until At Least 3 Are Found in DB """
        print("\n" + "="*50)
        print(" TEST: Click Synonyms Until 3 Are Found in DB")
        print("="*50 + "\n")

        #  Step 1: Select a symptom
        symptom = WebDriverWait(self.driver, 10).until(
            EC.element_to_be_clickable((By.XPATH, "(//li[contains(@class, 'symptom-item')])[1]"))
        )
        symptom_text = symptom.text.strip()
        symptom.click()
        print(f"  Clicked on Symptom: `{symptom_text}`\n")

        #  Step 2: Find blue synonyms (ignoring green words)
        synonym_elements = WebDriverWait(self.driver, 10).until(
            EC.presence_of_all_elements_located((By.XPATH, "//span[contains(@class, 'synonym-word')][not(contains(@class, 'green'))]"))
        )

        if not synonym_elements:
            print(" No blue synonyms found.")
            return

        print(f"  Found {len(synonym_elements)} blue synonyms. Selecting up to 6.\n")

        found_synonyms = 0  

        
        random.shuffle(synonym_elements)

        for synonym_element in synonym_elements:
            synonym_text = synonym_element.text.strip()

            
            if not synonym_text or synonym_text.isdigit():
                continue

            found = self.click_synonym_twice(symptom_text, synonym_text)

            if found:
                found_synonyms += 1 
            
           
            if found_synonyms >= 3:
                print("\n Found 3 synonyms in the database. Stopping test.\n")
                break

        print("\n" + "="*50 + "\n")

    def click_synonym_twice(self, word, synonym):
        """  Click a Synonym, Wait 1s, Reclick, Capture Logs & Verify DB """
        print(f" **Testing Synonym:** `{synonym}`")

        try:
            #  click the synonym for the first time
            synonym_element = WebDriverWait(self.driver, 10).until(
                EC.presence_of_element_located((By.XPATH, f"//span[contains(@class, 'synonym-word') and text()='{synonym}']"))
            )
            synonym_element.click()
            print(f"  Clicked on Synonym: `{synonym}`")

            
            time.sleep(1)

           
            synonym_element = WebDriverWait(self.driver, 10).until(
                EC.presence_of_element_located((By.XPATH, f"//span[contains(@class, 'synonym-word') and text()='{synonym}']"))
            )
            synonym_element.click()
            print(f"  Clicked AGAIN on Synonym: `{synonym}`")

        
            logs = self.driver.get_log("browser")
            clean_logs = self.extract_relevant_logs(logs)

            
            if self.check_synonym_in_db(synonym):
                
                return True
            else:
                
                if "No synonyms available" in clean_logs:
                    print(f"ℹ️ No synonyms available for `{synonym}`.\n")
                else:
                    print(f"ℹ️ No synonyms added for `{synonym}` because it or variation of it already exists under synonyms in database.\n")
                return False

        except StaleElementReferenceException:
            print(f" Stale Element Error: Retrying `{synonym}`...")
            return self.click_synonym_twice(word, synonym)  # 🔄 Retry once

        except Exception as e:
            print(f" Unexpected Error: {e}")
            return False

    def extract_relevant_logs(self, logs):
        """  Extracts & Cleans Console Logs, Removing Unnecessary Data """
        clean_logs = []
        for log in logs:
            log_message = log['message']

            
            if (
                "Selected Word:" in log_message
                or "Fetching synonyms from Korrekturen" in log_message
                or "search_synonym.php Response:" in log_message
                or "No synonyms available" in log_message
            ):
               
                log_message = re.sub(r"http://localhost:8080/[^ ]+ ", "", log_message)  # Remove file paths
                log_message = log_message.replace("📜 Console Log:", "").strip()
                clean_logs.append(log_message)

        return "\n".join(clean_logs)

    def check_synonym_in_db(self, word):
        """  Fetch and Print Synonyms for the Clicked Word in `synonym_de` Table """
        try:
            query = "SELECT synonym FROM synonym_de WHERE word = %s"

            connection = mysql.connector.connect(**DB_CONFIG)
            connection.autocommit = True 
            cursor = connection.cursor()

            cursor.execute(query, (word,))
            result = cursor.fetchone()

            if result:
                stored_synonyms = result[0]
                print(f" ✓ Synonyms for `{word}` in DB: `{stored_synonyms}`\n")
                cursor.close()
                connection.close()
                return True  #  synonym exists
            else:
                cursor.close()
                connection.close()
                return False  #  synonym not found

        except mysql.connector.Error as db_err:
            print(f" Database Error: {db_err}")
            return False

    @classmethod
    def tearDownClass(cls):
        """  Close WebDriver """
        time.sleep(2)
        cls.driver.quit()

if __name__ == "__main__":
    unittest.main()
