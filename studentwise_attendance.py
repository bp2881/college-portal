from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from bs4 import BeautifulSoup

options = webdriver.ChromeOptions()
prefs = {
    "profile.managed_default_content_settings.images": 2  # Disable images
}
options.add_experimental_option("prefs", prefs)
options.add_argument("--headless")  # Run in background
options.add_argument("--window-size=1920,1080")

driver = webdriver.Chrome(options=options)


try:
    driver.get("https://vignanits.ac.in/Attendance/Validate.php")
    print("going in validate")
    driver.find_element(By.NAME, "uname").send_keys("840")
    driver.find_element(By.NAME, "pass").send_keys("vgnt")
    password_input = driver.find_element(By.NAME, 'pass')
    password_input.submit()

    view_reports_link = WebDriverWait(driver, 10).until(
        EC.element_to_be_clickable((By.XPATH, "//a[@href='Sreports.php']"))
    )
    view_reports_link.click()

    driver.find_element(By.NAME, "rno").send_keys("23891A0549") # Roll-no
    driver.find_element(By.NAME, "fdt").send_keys("20-01-2025")
    driver.find_element(By.NAME, "tdt").send_keys("18-04-2025")
    tdt = driver.find_element(By.NAME, "tdt")
    tdt.submit()

    WebDriverWait(driver, 30).until(
        EC.presence_of_element_located((By.TAG_NAME, "table"))
    )
    print("Student-Wise Report page accessed successfully.")

    soup = BeautifulSoup(driver.page_source, "html.parser")
    tables = soup.find_all("table")

    print("Student-Wise Report:")
    percentages = []
    for i, table in enumerate(tables, 1):
        rows = table.find_all("tr")
        data_rows = [row for row in rows if row.find("td")]
        if data_rows:
            print(f"\nTable {i}:")
            for row in data_rows:
                columns = row.find_all(["td", "th"])
                data = [col.get_text(strip=True) for col in columns]
                print(data)
                # Process the second table's last column
                if i == 2 and data[-1] != '--':
                    try:
                        percentages.append(float(data[-1]))
                    except ValueError:
                        continue

    if percentages:
        total_percentage = sum(percentages)
        average_percentage = total_percentage / len(percentages)
        print(f"Attendance Percentage: {average_percentage:.2f}")
    else:
        print("\nNo valid percentages found in the second table.")

except Exception as e:
    print("Failed to load attendance data within the specified time:", e)

finally:
    driver.quit()