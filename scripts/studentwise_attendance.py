import sys
import json
import time
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from bs4 import BeautifulSoup

# --- Get arguments from PHP ---
roll_no = sys.argv[1]
from_date = sys.argv[2]
to_date = sys.argv[3]

st = time.time()

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
    "tables": []
}

try:
    driver.get("https://vignanits.ac.in/Attendance/Validate.php")
    driver.find_element(By.NAME, "uname").send_keys("840")
    driver.find_element(By.NAME, "pass").send_keys("vgnt")
    driver.find_element(By.NAME, 'pass').submit()

    view_reports_link = WebDriverWait(driver, 10).until(
        EC.element_to_be_clickable((By.XPATH, "//a[@href='Sreports.php']"))
    )
    view_reports_link.click()

    driver.find_element(By.NAME, "rno").send_keys(roll_no)
    driver.find_element(By.NAME, "fdt").send_keys(from_date)
    driver.find_element(By.NAME, "tdt").send_keys(to_date)
    driver.find_element(By.NAME, "tdt").submit()

    WebDriverWait(driver, 30).until(
        EC.presence_of_element_located((By.TAG_NAME, "table"))
    )

    soup = BeautifulSoup(driver.page_source, "html.parser")
    tables = soup.find_all("table")
    percentages = []

    name_element = soup.find(string=lambda text: text and "Name" in text)
    if name_element:
        try:
            attendance_data["student_name"] = name_element.strip().split(":")[-1].strip()
        except Exception:
            attendance_data["student_name"] = "Student"
    else:
        attendance_data["student_name"] = "Student"

    for i, table in enumerate(tables, 1):
        rows = table.find_all("tr")
        data_rows = [row for row in rows if row.find("td")]
        table_data = []

        if data_rows:
            for row in data_rows:
                columns = row.find_all(["td", "th"])
                data = [col.get_text(strip=True) for col in columns]
                table_data.append(data)

                if i == 2 and data[-1] != '--':
                    try:
                        percentages.append(float(data[-1]))
                    except ValueError:
                        continue

        attendance_data["tables"].append(table_data)

    if percentages:
        average_percentage = sum(percentages) / len(percentages)
        attendance_data["average_attendance_percentage"] = f"{average_percentage:.2f}"
    else:
        attendance_data["average_attendance_percentage"] = "No valid percentages found in the second table."

except Exception as e:
    attendance_data["error"] = f"Failed to load data: {str(e)}"

finally:
    driver.quit()
    with open("attendance_data.json", "w") as json_file:
        json.dump(attendance_data, json_file, indent=4)
    et = time.time()
    print(f"Execution time: {et - st:.2f} seconds")
    sys.stdout.flush()
