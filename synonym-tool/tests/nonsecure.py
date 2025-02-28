from selenium import webdriver
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.common.by import By
from selenium.webdriver.common.action_chains import ActionChains
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
import time
import mysql.connector

# Database connection configuration
DB_CONFIG = {
    "host": "localhost",
    "port": 6000,  # Change to your Docker-exposed port
    "user": "root",
    "password": "root",
    "database": "symcom_minified_db"
}

# Function to connect to the database
def connect_to_db():
    try:
        db = mysql.connector.connect(
            host=DB_CONFIG["host"],
            port=DB_CONFIG["port"],
            user=DB_CONFIG["user"],
            password=DB_CONFIG["password"],
            database=DB_CONFIG["database"]
        )
        print("Database connection successful!")
        return db
    except mysql.connector.Error as err:
        print(f"Error: {err}")
        return None

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
search_terms = ["Tag", "Auswurf"]

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
        print("Neither 'Tag' nor 'Auswurf' were found on the page.\n")
    else:
        print("Test passed: Successfully clicked on one of the search terms.\n")

        # Find and click on the "Not Sure" checkbox
        try:
            not_sure_checkbox = driver.find_element(By.ID, "notSureCheckbox")
            print("Clicking on the 'Not Sure' checkbox...")
            not_sure_checkbox.click()
            print("Clicked on the 'Not Sure' checkbox successfully.\n")
            
            # Wait for the comment input field to appear and click on it
            comment_input = WebDriverWait(driver, 10).until(
                EC.element_to_be_clickable((By.ID, "commentText"))  # Replace with the actual ID of the comment input field
            )
            
            # Click on the comment input field (this will focus it)
            comment_input.click()
            print("Comment input field clicked successfully.\n")

            # Type something in the comment input field
            comment_input.send_keys("This is a test comment added after selecting 'Not Sure'.")

            print("Typed in the 'Not Sure' comment successfully.\n")

            # Find and click on the "Save" button
            save_button = driver.find_element(By.ID, "saveComment")  # Adjust ID if necessary
            save_button.click()
            print("Clicked on 'Save' button successfully.\n")
            
            # Find the form and submit it directly
            synonym_form = driver.find_element(By.ID, "synonymForm")
            synonym_form.submit()
            print("Form submitted successfully.\n")

            # Wait for 10 seconds after interacting
            time.sleep(10)

            # Now, let's check the database to verify the changes
            db = connect_to_db()
            if db:
                cursor = db.cursor()

                # Check if the `non_secure_flag` for the word "Tag" is set to '1'
                selected_word = 'Tag'
                cursor.execute("""
                    SELECT non_secure_flag FROM synonym_de WHERE word = %s
                """, (selected_word,))
                result = cursor.fetchone()

                # Assert the results
                if result:
                    print("Database result:", result)
                    assert result[0] == '1', f"Expected non_secure_flag to be '1', got {result[0]}"
                    print("Database check passed: non_secure_flag is correctly set to 1 for the word 'Tag'.")
                else:
                    print(f"No record found for the word '{selected_word}' in the database.")

                # Clean up the database connection
                cursor.close()
                db.close()

        except Exception as e:
            print(f"Error interacting with the 'Not Sure' checkbox, comment field, or buttons: {str(e)}")

except Exception as e:
    print(f"Test Failed: An error occurred - {e}")

# End of the test
print("Test completed. Closing the browser.")
driver.quit()
