from selenium import webdriver
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.common.by import By
from selenium.webdriver.common.action_chains import ActionChains
import time

# Specify the ChromeDriver path
service = Service("/usr/local/bin/chromedriver")  
driver = webdriver.Chrome(service=service)

# Target URL
url = "http://localhost:8080/synonym-tool/all-symptoms.php?mid=5072"  
print(f"Opening the page: {url}")
driver.get(url)
driver.maximize_window()

# Wait for the page to load
time.sleep(2)
print("Page loaded successfully.")

# Words to search for
search_terms = ["Ameisen-Laufen", "Auswurf"]

try:
    word_found = False

    # Loop through the search terms and search them on the page
    for term in search_terms:
        try:
            print(f"Searching for '{term}' on the page...")
            word_element = driver.find_element(By.XPATH, f"//span[contains(text(), '{term}')]")
            
            # If found, click on the word
            print(f"Word '{term}' found on the page.")
            ActionChains(driver).move_to_element(word_element).click().perform()
            print(f"Clicked on '{term}' successfully.\n")

            word_found = True
            break  # Stop after clicking the first match
        except Exception as e:
            print(f"Word '{term}' not found. Error: {str(e)}. Trying next word...\n")
            continue  # Try the next word if the current one isn't found

    # If no word was found
    if not word_found:
        print("Neither 'Ameisen-Laufen' nor 'Auswurf' were found on the page.\n")
    else:
        print("Test passed: Successfully clicked on one of the search terms.\n")

    # Wait for 10 seconds after clicking
    time.sleep(10)

except Exception as e:
    print(f"Test Failed: An error occurred - {e}")

# End of the test
print("Test completed. Closing the browser.")
driver.quit()
