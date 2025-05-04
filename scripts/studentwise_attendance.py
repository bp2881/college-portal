import sys
import json
import time
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from bs4 import BeautifulSoup
from os import getenv
from dotenv import load_dotenv

roll_no = sys.argv[2]
from_date = sys.argv[3]
to_date = sys.argv[4]

st = time.time()
load_dotenv()
LOGIN_ID = getenv("LOGIN_ID")
LOGIN_PASS = getenv("LOGIN_PASS")
URL = getenv("URL")
# Check for existing data
try:
    with open("C:\\xampp\\htdocs\\college-portal\\attendance_data.json", "r") as json_file:
        data = json.load(json_file)
        if data.get("roll_no") == roll_no and data.get("attendance_dates", {}).get("from") == from_date and data.get("attendance_dates", {}).get("to") == to_date:
            print(f"Data already exists for Roll No: {roll_no}, From: {from_date}, To: {to_date}")
            sys.exit(0)
except FileNotFoundError:
    pass

# Setup headless Chrome browser
options = webdriver.ChromeOptions()
options.add_argument("blink-settings=imagesEnabled=false")
options.add_argument("--headless")
options.add_argument("--window-size=1920,1080")
options.add_argument('--disable-extensions')
options.add_argument('--disable-gpu')
options.add_argument('--no-sandbox')
driver = webdriver.Chrome(options=options)

attendance_data = {
    "roll_no": roll_no,
    "student_name": "",
    "course": "",
    "semester": "",
    "attendance_dates": {
        "from": from_date,
        "to": to_date
    },
    "tables": [],
    "total_attended": 0,
    "total_classes": 0,
    "calculated_percentage": "0.00"
}

try:
    # Navigate and login
    driver.get(URL)
    driver.find_element(By.NAME, "uname").send_keys(LOGIN_ID)
    driver.find_element(By.NAME, "pass").send_keys(LOGIN_PASS)
    driver.find_element(By.NAME, 'pass').submit()

    # Go to student reports
    view_reports_link = WebDriverWait(driver, 10).until(
        EC.element_to_be_clickable((By.XPATH, "//a[@href='Sreports.php']"))
    )
    view_reports_link.click()

    # Fill the report form
    driver.find_element(By.NAME, "rno").send_keys(roll_no)
    driver.find_element(By.NAME, "fdt").send_keys(from_date)
    driver.find_element(By.NAME, "tdt").send_keys(to_date)
    driver.find_element(By.NAME, "tdt").submit()

    WebDriverWait(driver, 30).until(
        EC.presence_of_element_located((By.TAG_NAME, "table"))
    )

    soup = BeautifulSoup(driver.page_source, "html.parser")
    tables = soup.find_all("table")

    # Extract student info
    if tables and len(tables) > 0:
        info_table = tables[0]
        rows = info_table.find_all("tr")
        if rows:
            info_data = []
            for row in rows:
                columns = row.find_all(["td", "th"])
                data = [col.get_text(strip=True) for col in columns]
                if data:
                    info_data.append(data)
            
            attendance_data["tables"].append(info_data)
            
            # Extract student name, course, and semester if available
            for row in info_data:
                if len(row) >= 7:  # Check if we have enough columns
                    attendance_data["student_name"] = row[1] if len(row) > 1 else ""
                    attendance_data["course"] = row[2] if len(row) > 2 else ""
                    attendance_data["semester"] = row[3] if len(row) > 3 else ""
                    break

    # Extract attendance data
    if len(tables) > 1:
        attendance_table = tables[1]
        rows = attendance_table.find_all("tr")
        if rows:
            attendance_rows = []
            total_attended = 0
            total_classes = 0
            
            for row in rows:
                columns = row.find_all(["td", "th"])
                data = [col.get_text(strip=True) for col in columns]
                if data:
                    attendance_rows.append(data)
                    
                    # Calculate attendance totals
                    # Check if this is a subject row with attendance data (typically has 4 columns)
                    if len(data) >= 4 and data[-1] != '--':
                        try:
                            attended = int(data[2]) if data[2].isdigit() else 0
                            total = int(data[1]) if data[1].isdigit() else 0
                            
                            if total > 0:  # Ensure we don't count empty rows
                                total_attended += attended
                                total_classes += total
                        except (ValueError, IndexError):
                            continue
            
            attendance_data["tables"].append(attendance_rows)
            attendance_data["total_attended"] = total_attended
            attendance_data["total_classes"] = total_classes
            
            if total_classes > 0:
                attendance_data["calculated_percentage"] = f"{(total_attended / total_classes) * 100:.2f}"
            else:
                attendance_data["calculated_percentage"] = "0.00"

except Exception as e:
    attendance_data["error"] = f"Failed to load data: {str(e)}"

finally:
    driver.quit()
    with open("C:\\xampp\\htdocs\\college-portal\\attendance_data.json", "w") as json_file:
        json.dump(attendance_data, json_file, indent=4)
    et = time.time()
    print(f"Execution time: {et - st:.2f} seconds")
    sys.stdout.flush()