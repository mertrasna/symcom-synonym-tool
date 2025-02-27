import time
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from webdriver_manager.chrome import ChromeDriverManager
from urllib.parse import urlparse, parse_qs

options = webdriver.ChromeOptions()
options.add_argument("--headless")
options.add_argument("--no-sandbox")
options.add_argument("--disable-dev-shm-usage")

driver = webdriver.Chrome(service=Service(ChromeDriverManager().install()), options=options)

# 🔥 Update this URL to use the Docker container name
driver.get("http://php-apache/synonym-tool/all-symptoms.php")

try:
    WebDriverWait(driver, 10).until(
        EC.presence_of_element_located((By.CLASS_NAME, "symptom-item"))
    )
    print("✅ Symptoms loaded successfully!")
except:
    print("❌ Symptoms did not load in time!")
    driver.quit()
    exit(1)

symptoms_before = driver.find_elements(By.CLASS_NAME, "symptom-item")
symptoms_texts_before = [symptom.text for symptom in symptoms_before]
current_url = driver.current_url

try:
    reload_button = driver.find_element(By.ID, "reloadSymptoms")
    reload_button.click()
    time.sleep(3)
    print("🔄 Clicked 'Reload New Symptoms' button.")
except:
    print("❌ Test Failed: 'Reload New Symptoms' button not found!")
    driver.quit()
    exit(1)

new_url = driver.current_url
new_symptoms = driver.find_elements(By.CLASS_NAME, "symptom-item")
new_symptoms_texts = [symptom.text for symptom in new_symptoms]

if symptoms_texts_before != new_symptoms_texts and parse_qs(urlparse(new_url).query).get("offset"):
    print("✅ Test Passed: 'Reload New Symptoms' loaded new symptoms correctly!")
else:
    print("❌ Test Failed: Symptoms did not change or offset is missing in URL.")

try:
    back_to_start_button = driver.find_element(By.ID, "resetToStart")
    back_to_start_button.click()
    time.sleep(3)
    print("🔄 Clicked 'Back to Start' button.")
except:
    print("❌ Test Failed: 'Back to Start' button not found!")
    driver.quit()
    exit(1)

driver.quit()
