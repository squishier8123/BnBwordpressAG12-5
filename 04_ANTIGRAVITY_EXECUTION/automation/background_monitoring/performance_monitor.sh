#!/bin/bash

# Performance Monitor - Tracks site load time
# Purpose: Monitor page load time every hour
# Cron: 0 * * * * (hourly)
# Alert: WARN if load time > 5 seconds

SITE_URL="https://beardsandbucks.com"
MONITOR_LOG="/mnt/c/Users/Geoff/OneDrive/Desktop/Newbeards&Bucks12-5/04_ANTIGRAVITY_EXECUTION/logs/performance_monitor.log"
MAX_TIME=5  # seconds

mkdir -p "$(dirname "$MONITOR_LOG")"

log_check() {
    local status="$1"
    local message="$2"
    local timestamp=$(date '+%Y-%m-%d %H:%M:%S')
    echo "[${timestamp}] ${status}: ${message}" >> "$MONITOR_LOG"
}

# Measure page load time
LOAD_TIME=$(curl -s -o /dev/null -w "%{time_total}" --connect-timeout 10 "$SITE_URL")

# Convert to integer for comparison (bash doesn't handle floats well)
LOAD_TIME_INT=${LOAD_TIME%.*}

# Log the check
if [ $(echo "$LOAD_TIME < $MAX_TIME" | bc -l) -eq 1 ]; then
    log_check "✅" "Page load: ${LOAD_TIME}s (good)"
else
    log_check "⚠️" "SLOW: Page load: ${LOAD_TIME}s (exceeds ${MAX_TIME}s threshold)"

    # Create warning flag (not critical)
    WARN_FLAG="/mnt/c/Users/Geoff/OneDrive/Desktop/Newbeards&Bucks12-5/04_ANTIGRAVITY_EXECUTION/logs/PERFORMANCE_WARNING.flag"
    {
        echo "WARN_TIMESTAMP=$(date '+%Y-%m-%d %H:%M:%S')"
        echo "WARN_TYPE=PERFORMANCE"
        echo "WARN_MESSAGE=Slow page load: ${LOAD_TIME}s"
    } > "$WARN_FLAG"
fi

# Log additional metrics
RESPONSE_CODE=$(curl -s -o /dev/null -w "%{http_code}" --connect-timeout 10 "$SITE_URL")
log_check "ℹ️" "HTTP Status: $RESPONSE_CODE | Load Time: ${LOAD_TIME}s"

exit 0
