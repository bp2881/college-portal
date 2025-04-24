from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait, Select
from selenium.webdriver.support import expected_conditions as EC
from bs4 import BeautifulSoup
import time
import sys
import json

st = time.time()

# --- Get arguments from PHP ---
branch = sys.argv[1]
from_date = sys.argv[2]
to_date = sys.argv[3]
year = sys.argv[4]
section = sys.argv[5]

json_path = "C:\\xampp\\htdocs\\college-portal\\class_attendance_data.json"

# --- Check if data already exists ---
try:
    with open(json_path, "r") as json_file:
        data = json.load(json_file)
        if data.get("year") == year and data.get("attendance_dates", {}).get("from") == from_date and data.get("attendance_dates", {}).get("to") == to_date and data.get("branch") == branch and data.get("section") == section:
            print(f"Data already exists, From: {from_date}, To: {to_date}")
            sys.exit(0)
except FileNotFoundError:
    pass

# --- Set up headless Chrome ---
options = webdriver.ChromeOptions()
options.add_argument("blink-settings=imagesEnabled=false")
#options.add_argument("--headless")
options.add_argument("--window-size=1920,1080")
options.add_argument('--disable-extensions')
options.add_argument('--disable-gpu')
options.add_argument('--no-sandbox')

driver = webdriver.Chrome(options=options)

try:
    # --- Login ---
    driver.get("https://vignanits.ac.in/Attendance/Validate.php")
    driver.find_element(By.NAME, "uname").send_keys("840")
    driver.find_element(By.NAME, "pass").send_keys("vgnt")
    driver.find_element(By.NAME, "pass").submit()

    # --- Navigate to reports page ---
    WebDriverWait(driver, 10).until(EC.element_to_be_clickable((By.XPATH, "//a[@href='Creports.php']"))).click()

    # --- Wait for form and fill details ---
    WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.NAME, "br")))
    Select(driver.find_element(By.NAME, "br")).select_by_visible_text(branch)
    Select(driver.find_element(By.NAME, "yr")).select_by_visible_text(year)
    Select(driver.find_element(By.NAME, "sc")).select_by_visible_text(section)
    driver.find_element(By.NAME, "fdt").send_keys(from_date)
    driver.find_element(By.NAME, "tdt").send_keys(to_date)

    # --- Submit the form ---
    WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.XPATH, "//input[@type='submit']"))).click()

    # --- Wait for report table ---
    WebDriverWait(driver, 30).until(EC.presence_of_element_located((By.TAG_NAME, "table")))

    soup = BeautifulSoup(driver.page_source, "html.parser")
    tables = soup.find_all("table")

    student_data = []
    subjects = []
    header_found = False
    row_count_after_header = 0

    for table in tables:
        rows = table.find_all("tr")
        for row in rows:
            cols = row.find_all(["th", "td"])
            values = [col.get_text(strip=True) for col in cols]

            # Find and extract subjects from header row
            if not header_found and "Student Name" in values:
                subjects = values[3:-2]
                header_found = True
                continue

            # Skip "Number of Hours Conducted" row (comes right after header)
            if header_found and row_count_after_header == 0:
                row_count_after_header += 1
                continue

            # Student rows
            if header_found and len(values) >= 3 + len(subjects) + 2:
                student_dict = {
                    "sno": values[0],
                    "htno": values[1],
                    "name": values[2],
                    "subjects": {subjects[i]: values[3 + i] for i in range(len(subjects))},
                    "total": values[-2],
                    "percentage": values[-1]
                }
                student_data.append(student_dict)

    # --- Save to JSON ---
    output_data = {
        "branch": branch,
        "year": year,
        "section": section,
        "attendance_dates": {
            "from": from_date,
            "to": to_date
        },
        "students": student_data
    }

    with open(json_path, "w") as json_out:
        json.dump(output_data, json_out, indent=2)

    print(f"\n✅ Stored {len(student_data)} students with {len(subjects)} subjects in JSON")

except Exception as e:
    print("❌ Error:", e)

finally:
    driver.quit()
    et = time.time()
    print("⏱️ Execution time:", round(et - st, 2), "seconds")
