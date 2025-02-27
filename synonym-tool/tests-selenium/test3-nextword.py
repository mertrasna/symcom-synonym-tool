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

driver = webdriver.Chrome(service=Service(ChromeDriverManager().install()), options=options)

# 🔥 Update this URL to use the Docker container name
driver.get("http://php-apache/synonym-tool/all-symptoms.php")

time.sleep(10)  # Wait for page load

try:
    target_word = driver.find_element(By.XPATH, "//span[text()='ungereimtes']")
    print("✅ Found word: 'ungereimtes'")
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
    print(f"✅ Alert Found: {alert.text}")
    alert.accept()
    print("✅ Alert dismissed successfully!")
except:
    print("⚠️ No alert found. Continuing...")

try:
    new_selected_word = driver.find_element(By.ID, "selected-word").text.strip()
    print(f"🔄 Switched to new word: {new_selected_word}")
except:
    print("❌ Test Failed: No new word detected after submit!")
    driver.quit()
    exit(1)

driver.quit()
