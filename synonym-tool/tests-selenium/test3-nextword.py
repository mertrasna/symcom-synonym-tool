import time
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.common.alert import Alert
from webdriver_manager.chrome import ChromeDriverManager

options = webdriver.ChromeOptions()
options.add_argument("--headless")
options.add_argument("--no-sandbox")
options.add_argument("--disable-dev-shm-usage")

# ✅ Initialize WebDriver with error handling
driver = webdriver.Chrome(service=Service(ChromeDriverManager().install()), options=options)

# ✅ Retry mechanism for connecting to server
for attempt in range(5):
    try:
        driver.get("http://127.0.0.1:8080/synonym-tool/all-symptoms.php")
        print("✅ Connected to PHP server!")
        break  
    except:
        print(f"⚠️ Connection failed. Retrying {attempt + 1}/5...")
        time.sleep(5)
else:
    print("❌ Test Failed: Could not connect to server!")
    driver.quit()
    exit(1)

time.sleep(5)

try:
    target_word = driver.find_element(By.XPATH, "//span[text()='ungereimtes']")
    print("🔎 Found word: 'ungereimtes'")
except:
    print("❌ Test Failed: Word 'ungereimtes' not found!")
    driver.quit()
    exit(1)

target_word.click()
time.sleep(3)

submit_button = driver.find_element(By.ID, "submitSynonyms")
submit_button.click()
time.sleep(2)

try:
    alert = Alert(driver)
    print(f"🔔 Alert Found: {alert.text}") 
    alert.accept()
    print("✅ Alert dismissed successfully!")
    time.sleep(2)
except:
    print("⚠️ No alert found. Continuing...")
    time.sleep(1)

try:
    new_selected_word = driver.find_element(By.ID, "selected-word").text.strip()
    print(f"🔄 Switched to new word: {new_selected_word}")
except:
    print("❌ Test Failed: No new word detected after submit!")
    driver.quit()
    exit(1)

if new_selected_word == "Zeug":
    print("✅ Test Passed: Successfully switched from 'ungereimtes' to 'Zeug' after submitting!")
else:
    print(f"❌ Test Failed: Expected 'Zeug', but got '{new_selected_word}'.")

driver.quit()
