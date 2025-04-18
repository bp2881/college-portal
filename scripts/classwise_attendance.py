from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support.ui import Select
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.chrome.service import Service as ChromeService
from webdriver_manager.chrome import ChromeDriverManager
from bs4 import BeautifulSoup
import time
st = time.time()

# Set up Chrome options
options = webdriver.ChromeOptions()
prefs = {
    "profile.managed_default_content_settings.images": 2  # Disable images
}
options.add_experimental_option("prefs", prefs)
options.add_argument("--headless")  # Run in background
options.add_argument("--window-size=1920,1080")

driver = webdriver.Chrome(options=options)

try:
    # Login
    driver.get("https://vignanits.ac.in/Attendance/Validate.php")
    print("Attempting to log in...")
    driver.find_element(By.NAME, "uname").send_keys("840")
    driver.find_element(By.NAME, "pass").send_keys("vgnt")
    driver.find_element(By.NAME, "pass").submit()
    print("Login submitted")

    # Navigate to reports
    view_reports_link = WebDriverWait(driver, 10).until(
        EC.element_to_be_clickable((By.XPATH, "//a[@href='Creports.php']"))
    )
    view_reports_link.click()
    print("Navigated to reports page")

    # Wait for the form to load
    WebDriverWait(driver, 10).until(
        EC.presence_of_element_located((By.NAME, "br"))
    )
    print("Form loaded")

    # Select Branch
    branch_select = Select(driver.find_element(By.NAME, "br"))
    branch_select.select_by_visible_text("CSE")
    print("Branch selected: CSE")

    # Select Year
    year_select = Select(driver.find_element(By.NAME, "yr"))
    year_select.select_by_visible_text("2")
    print("Year selected: 2")

    # Select Section
    section_select = Select(driver.find_element(By.NAME, "sc"))
    section_select.select_by_visible_text("A")
    print("Section selected: A")

    # Enter Date range
    driver.find_element(By.NAME, "fdt").send_keys("20-01-2025")
    driver.find_element(By.NAME, "tdt").send_keys("18-04-2025")
    print("Dates entered")

    # Submit the form
    WebDriverWait(driver, 10).until(
        EC.presence_of_element_located((By.XPATH, "//input[@type='submit']"))
    )  # Wait for submit button
    submit_button = driver.find_element(By.XPATH, "//input[@type='submit']")  # Generic XPath
    submit_button.click()
    print("Form submitted")
    print("Current URL:", driver.current_url)  # Debug current page

    # Wait for table data after submission
    WebDriverWait(driver, 30).until(
        EC.presence_of_element_located((By.TAG_NAME, "table"))
    )
    print("Report page accessed successfully")

    # Parse the page
    soup = BeautifulSoup(driver.page_source, "html.parser")
    tables = soup.find_all("table")

    print("Student-Wise Report:")
    for i, table in enumerate(tables, 1):
        rows = table.find_all("tr")
        data_rows = [row for row in rows if row.find("td")]
        if data_rows:
            print(f"\nTable {i}:")
            for row in data_rows:
                columns = row.find_all(["td", "th"])
                data = [col.get_text(strip=True) for col in columns]
                print(data)

    time.sleep(2)

except Exception as e:
    print("Failed to load attendance data within the specified time:", e)

finally:
    driver.quit()
    print("Driver quit")
    et = time.time()
    print("Execution time:", et - st)