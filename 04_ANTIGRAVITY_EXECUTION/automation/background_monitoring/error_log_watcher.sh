#!/bin/bash

# Error Log Watcher - Detects new WordPress errors
# Purpose: Monitor WordPress debug.log for new errors every 5 minutes
# Cron: */5 * * * *
# Alert: WARN if > 10 errors in 5 minutes

DEBUG_LOG="/mnt/c/Users/Geoff/OneDrive/Desktop/Beards&Bucks/wp-content/debug.log"
MONITOR_LOG="/mnt/c/Users/Geoff/OneDrive/Desktop/Newbeards&Bucks12-5/04_ANTIGRAVITY_EXECUTION/logs/error_monitor.log"
STATE_FILE="/tmp/error_log_state.txt"

mkdir -p "$(dirname "$MONITOR_LOG")"

log_check() {
    local status="$1"
    local message="$2"
    local timestamp=$(date '+%Y-%m-%d %H:%M:%S')
    echo "[${timestamp}] ${status}: ${message}" >> "$MONITOR_LOG"
}

# Check if debug.log exists
if [ ! -f "$DEBUG_LOG" ]; then
    log_check "ℹ️" "WordPress debug.log not found (logging may be disabled)"
    exit 0
fi

# Get line count of debug.log
CURRENT_LINES=$(wc -l < "$DEBUG_LOG" 2>/dev/null || echo "0")
PREVIOUS_LINES=0

# Read previous line count
if [ -f "$STATE_FILE" ]; then
    PREVIOUS_LINES=$(cat "$STATE_FILE")
fi

# Calculate new lines (errors) since last check
NEW_LINES=$((CURRENT_LINES - PREVIOUS_LINES))

if [ $NEW_LINES -lt 0 ]; then
    NEW_LINES=$CURRENT_LINES
fi

# Count actual ERROR and WARNING entries
ERROR_COUNT=$(tail -n $NEW_LINES "$DEBUG_LOG" 2>/dev/null | grep -ic "error\|warning" || echo "0")

# Log the check
if [ $ERROR_COUNT -eq 0 ]; then
    log_check "✅" "No new errors (${NEW_LINES} new lines)"
elif [ $ERROR_COUNT -lt 10 ]; then
    log_check "⚠️" "Found ${ERROR_COUNT} new errors/warnings"
else
    log_check "🚨" "CRITICAL: Found ${ERROR_COUNT} errors (> 10 threshold)"

    # Create alert flag
    ALERT_FLAG="/mnt/c/Users/Geoff/OneDrive/Desktop/Newbeards&Bucks12-5/04_ANTIGRAVITY_EXECUTION/logs/ATTENTION_NEEDED.flag"
    {
        echo "ALERT_TIMESTAMP=$(date '+%Y-%m-%d %H:%M:%S')"
        echo "ALERT_SEVERITY=CRITICAL"
        echo "ALERT_MESSAGE=Too many errors in debug.log: ${ERROR_COUNT}"
    } > "$ALERT_FLAG"
fi

# Save current line count
echo "$CURRENT_LINES" > "$STATE_FILE"

exit 0
