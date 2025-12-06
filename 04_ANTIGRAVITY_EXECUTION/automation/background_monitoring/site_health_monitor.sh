#!/bin/bash

# Site Health Monitor - 24/7 Monitoring
# Purpose: Monitor site availability every 15 minutes
# Cron: */15 * * * *
# Alert: CRITICAL if site down for 2 consecutive checks

SITE_URL="https://beardsandbucks.com"
LOG_FILE="/mnt/c/Users/Geoff/OneDrive/Desktop/Newbeards&Bucks12-5/04_ANTIGRAVITY_EXECUTION/logs/health_monitor.log"
STATE_FILE="/tmp/site_health_state.txt"

# Ensure log file exists
mkdir -p "$(dirname "$LOG_FILE")"

# Function to log
log_check() {
    local status="$1"
    local message="$2"
    local timestamp=$(date '+%Y-%m-%d %H:%M:%S')
    echo "[${timestamp}] ${status}: ${message}" >> "$LOG_FILE"
}

# Check site
check_site() {
    local response=$(curl -s -o /dev/null -w "%{http_code}" --connect-timeout 10 "$SITE_URL")

    if [ "$response" = "200" ]; then
        echo "ONLINE"
        return 0
    else
        echo "OFFLINE (HTTP $response)"
        return 1
    fi
}

# Get current state
CURRENT_STATE=$(check_site)

# Read previous state
PREVIOUS_STATE="ONLINE"
if [ -f "$STATE_FILE" ]; then
    PREVIOUS_STATE=$(cat "$STATE_FILE")
fi

# Log the check
if [[ "$CURRENT_STATE" == "ONLINE" ]]; then
    log_check "✅" "Site online (HTTP 200)"
else
    log_check "⚠️" "Site unreachable: $CURRENT_STATE"
fi

# Check for alert condition (2 consecutive failures)
if [[ "$PREVIOUS_STATE" =~ "OFFLINE" ]] && [[ "$CURRENT_STATE" =~ "OFFLINE" ]]; then
    log_check "🚨" "CRITICAL: Site offline for 2+ consecutive checks"

    # Create alert flag
    ALERT_FLAG="/mnt/c/Users/Geoff/OneDrive/Desktop/Newbeards&Bucks12-5/04_ANTIGRAVITY_EXECUTION/logs/ATTENTION_NEEDED.flag"
    {
        echo "ALERT_TIMESTAMP=$(date '+%Y-%m-%d %H:%M:%S')"
        echo "ALERT_SEVERITY=CRITICAL"
        echo "ALERT_MESSAGE=Site offline - ${CURRENT_STATE}"
    } > "$ALERT_FLAG"
fi

# Save current state
echo "$CURRENT_STATE" > "$STATE_FILE"

exit 0
