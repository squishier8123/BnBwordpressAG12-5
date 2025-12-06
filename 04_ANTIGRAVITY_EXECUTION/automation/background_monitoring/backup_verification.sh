#!/bin/bash

# Backup Verification - Ensures backup exists daily
# Purpose: Verify database backup exists and is recent
# Cron: 0 2 * * * (2 AM daily)
# Alert: CRITICAL if no backup from today

BACKUP_DIR="/mnt/c/Users/Geoff/OneDrive/Desktop/Newbeards&Bucks12-5/backups"
MONITOR_LOG="/mnt/c/Users/Geoff/OneDrive/Desktop/Newbeards&Bucks12-5/04_ANTIGRAVITY_EXECUTION/logs/backup_monitor.log"
MIN_SIZE=1048576  # 1 MB minimum

mkdir -p "$(dirname "$MONITOR_LOG")"
mkdir -p "$BACKUP_DIR"

log_check() {
    local status="$1"
    local message="$2"
    local timestamp=$(date '+%Y-%m-%d %H:%M:%S')
    echo "[${timestamp}] ${status}: ${message}" >> "$MONITOR_LOG"
}

# Check if backup directory exists
if [ ! -d "$BACKUP_DIR" ]; then
    log_check "❌" "Backup directory not found: $BACKUP_DIR"
    exit 1
fi

# Get today's date
TODAY=$(date '+%Y-%m-%d')

# Find most recent backup
LATEST_BACKUP=$(ls -t "$BACKUP_DIR"/backup-*.sql 2>/dev/null | head -1)

if [ -z "$LATEST_BACKUP" ]; then
    log_check "🚨" "CRITICAL: No backups found in $BACKUP_DIR"

    # Create alert flag
    ALERT_FLAG="/mnt/c/Users/Geoff/OneDrive/Desktop/Newbeards&Bucks12-5/04_ANTIGRAVITY_EXECUTION/logs/ATTENTION_NEEDED.flag"
    {
        echo "ALERT_TIMESTAMP=$(date '+%Y-%m-%d %H:%M:%S')"
        echo "ALERT_SEVERITY=CRITICAL"
        echo "ALERT_MESSAGE=No database backups found"
    } > "$ALERT_FLAG"

    exit 1
fi

# Check backup size
BACKUP_SIZE=$(stat -f%z "$LATEST_BACKUP" 2>/dev/null || stat -c%s "$LATEST_BACKUP" 2>/dev/null)

if [ -z "$BACKUP_SIZE" ] || [ "$BACKUP_SIZE" -lt "$MIN_SIZE" ]; then
    log_check "❌" "Backup file too small: $BACKUP_SIZE bytes (min: $MIN_SIZE)"
    exit 1
fi

# Check if backup is from today
BACKUP_DATE=$(basename "$LATEST_BACKUP" | sed 's/backup-\([0-9-]*\).sql/\1/')

if [ "$BACKUP_DATE" = "$TODAY" ]; then
    log_check "✅" "Today's backup exists: $(basename $LATEST_BACKUP) ($(numfmt --to=iec $BACKUP_SIZE 2>/dev/null || echo "$BACKUP_SIZE bytes"))"
else
    log_check "⚠️" "Latest backup from: $BACKUP_DATE (not today: $TODAY)"
    log_check "⚠️" "File: $(basename $LATEST_BACKUP)"
fi

# Log backup info
log_check "ℹ️" "Backup directory contains $(ls -1 "$BACKUP_DIR"/backup-*.sql 2>/dev/null | wc -l) backup files"

exit 0
