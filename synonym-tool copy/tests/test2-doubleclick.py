import random
from selenium import webdriver
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.common.by import By
from selenium.webdriver.common.action_chains import ActionChains
import time

# Specify ChromeDriver path
service = Service("/usr/local/bin/chromedriver")  # Adjust path if needed
driver = webdriver.Chrome(service=service)

# Target URL
url = "http://localhost:8080/synonym-tool/all-symptoms.php?mid=5072"  # Your actual URL
print(f"Opening the page: {url}")
driver.get(url)
driver.maximize_window()

# Wait for the page to load
time.sleep(2)
print("Page loaded successfully.")

try:
    # Step 1: Click a random word from the left section (synonym list)
    left_words = driver.find_elements(By.XPATH, "//div[@id='symptom-list-container']//span[contains(@class, 'synonym-word')]")  # Adjust XPath if needed

    if not left_words:
        print("No words found in the left section.")
    else:
        selected_left_word = random.choice(left_words)
        

        ActionChains(driver).move_to_element(selected_left_word).click().perform()
        time.sleep(2)  # Allow time for the word to appear on the right side

        # Step 2: Wait for words to appear in the right panel
        right_words = driver.find_elements(By.XPATH, "//div[@id='worksheet-container']//span[contains(@class, 'synonym-word')]")  # Adjust XPath if needed

        if len(right_words) < 2:
            print("Not enough words found in the right section to click consecutively.")
        else:
            # Select two random words
            word1 = random.choice(right_words)
            word2 = random.choice(right_words)

            print(f"Randomly selected words: '{word1.text}' and '{word2.text}' in the right section. Double-clicking on them...")

            # Double-click on the first word
            ActionChains(driver).move_to_element(word1).double_click().perform()
            print(f"Successfully double-clicked on '{word1.text}'.")
            time.sleep(2)  # Small delay between double clicks

            # Double-click on the second word
            ActionChains(driver).move_to_element(word2).double_click().perform()
            print(f"Successfully double-clicked on '{word2.text}'.")

            time.sleep(10)  # Wait for the user to observe the actions

except Exception as e:
    print(f"Test Failed: An error occurred - {e}")

# End of the test
print("Test completed. Closing the browser.")
driver.quit()
