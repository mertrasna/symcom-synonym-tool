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

# ✅ Retry mechanism for connecting to server
for attempt in range(5):
    try:
        driver.get("http://host.docker.internal:8080/synonym-tool/all-symptoms.php")

        print("✅ Connected to PHP server!")
        break  
    except:
        print(f"⚠️ Connection failed. Retrying {attempt + 1}/5...")
        time.sleep(5)
else:
    print("❌ Test Failed: Could not connect to server!")
    driver.quit()
    exit(1)

# ✅ Wait for page to load
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

print(f"📌 Initial URL: {current_url}")

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
    print(f"🔎 Before: {symptoms_texts_before}")
    print(f"🔎 After: {new_symptoms_texts}")

try:
    back_to_start_button = driver.find_element(By.ID, "resetToStart")
    back_to_start_button.click()
    time.sleep(3)
    print("🔄 Clicked 'Back to Start' button.")
except:
    print("❌ Test Failed: 'Back to Start' button not found!")
    driver.quit()
    exit(1)

reset_url = driver.current_url
if "offset=0" in reset_url:
    print("✅ Test Passed: 'Back to Start' correctly reset offset!")
else:
    print(f"❌ Test Failed: Expected offset=0 but got {reset_url}")

driver.quit()
