# Phase 2: Cron Job Setup Guide

**Purpose:** Configure background monitoring to run automatically 24/7

**Setup Time:** 5 minutes

---

## 📋 Cron Jobs to Add

### Job 1: Site Health Monitor (Every 15 minutes)
```bash
*/15 * * * * /mnt/c/Users/Geoff/OneDrive/Desktop/Newbeards&Bucks12-5/04_ANTIGRAVITY_EXECUTION/automation/background_monitoring/site_health_monitor.sh
```
- **Checks:** Site returns HTTP 200
- **Alert:** CRITICAL if site offline for 2+ consecutive checks
- **Log:** `/logs/health_monitor.log`

### Job 2: Error Log Watcher (Every 5 minutes)
```bash
*/5 * * * * /mnt/c/Users/Geoff/OneDrive/Desktop/Newbeards&Bucks12-5/04_ANTIGRAVITY_EXECUTION/automation/background_monitoring/error_log_watcher.sh
```
- **Checks:** WordPress debug.log for new errors
- **Alert:** CRITICAL if > 10 errors in 5 minutes
- **Log:** `/logs/error_monitor.log`

### Job 3: Backup Verification (Daily at 2 AM)
```bash
0 2 * * * /mnt/c/Users/Geoff/OneDrive/Desktop/Newbeards&Bucks12-5/04_ANTIGRAVITY_EXECUTION/automation/background_monitoring/backup_verification.sh
```
- **Checks:** Backup exists and is recent (>1 MB)
- **Alert:** CRITICAL if no backup from today
- **Log:** `/logs/backup_monitor.log`

### Job 4: Performance Monitor (Every hour)
```bash
0 * * * * /mnt/c/Users/Geoff/OneDrive/Desktop/Newbeards&Bucks12-5/04_ANTIGRAVITY_EXECUTION/automation/background_monitoring/performance_monitor.sh
```
- **Checks:** Page load time
- **Alert:** WARN if load time > 5 seconds
- **Log:** `/logs/performance_monitor.log`

---

## 🚀 Installation Steps

### Step 1: Edit Crontab
```bash
crontab -e
```

### Step 2: Add All Four Jobs
Paste this into your crontab editor:

```
# Phase 2: Background Monitoring (24/7)
# Site Health: Every 15 minutes
*/15 * * * * /mnt/c/Users/Geoff/OneDrive/Desktop/Newbeards&Bucks12-5/04_ANTIGRAVITY_EXECUTION/automation/background_monitoring/site_health_monitor.sh >> /mnt/c/Users/Geoff/OneDrive/Desktop/Newbeards&Bucks12-5/04_ANTIGRAVITY_EXECUTION/logs/cron.log 2>&1

# Error Log: Every 5 minutes
*/5 * * * * /mnt/c/Users/Geoff/OneDrive/Desktop/Newbeards&Bucks12-5/04_ANTIGRAVITY_EXECUTION/automation/background_monitoring/error_log_watcher.sh >> /mnt/c/Users/Geoff/OneDrive/Desktop/Newbeards&Bucks12-5/04_ANTIGRAVITY_EXECUTION/logs/cron.log 2>&1

# Backup: Daily at 2 AM
0 2 * * * /mnt/c/Users/Geoff/OneDrive/Desktop/Newbeards&Bucks12-5/04_ANTIGRAVITY_EXECUTION/automation/background_monitoring/backup_verification.sh >> /mnt/c/Users/Geoff/OneDrive/Desktop/Newbeards&Bucks12-5/04_ANTIGRAVITY_EXECUTION/logs/cron.log 2>&1

# Performance: Every hour
0 * * * * /mnt/c/Users/Geoff/OneDrive/Desktop/Newbeards&Bucks12-5/04_ANTIGRAVITY_EXECUTION/automation/background_monitoring/performance_monitor.sh >> /mnt/c/Users/Geoff/OneDrive/Desktop/Newbeards&Bucks12-5/04_ANTIGRAVITY_EXECUTION/logs/cron.log 2>&1
```

### Step 3: Save and Exit
- Press `Ctrl+X` (nano) or `:wq` (vim) to save

### Step 4: Verify Installation
```bash
crontab -l
```

You should see all 4 jobs listed.

---

## 📊 Monitoring the Monitors

### Check if Cron Jobs Are Running
```bash
# View cron execution log
tail -20 /mnt/c/Users/Geoff/OneDrive/Desktop/Newbeards&Bucks12-5/04_ANTIGRAVITY_EXECUTION/logs/cron.log

# Check specific monitor logs
tail -20 /mnt/c/Users/Geoff/OneDrive/Desktop/Newbeards&Bucks12-5/04_ANTIGRAVITY_EXECUTION/logs/health_monitor.log
tail -20 /mnt/c/Users/Geoff/OneDrive/Desktop/Newbeards&Bucks12-5/04_ANTIGRAVITY_EXECUTION/logs/error_monitor.log
tail -20 /mnt/c/Users/Geoff/OneDrive/Desktop/Newbeards&Bucks12-5/04_ANTIGRAVITY_EXECUTION/logs/backup_monitor.log
tail -20 /mnt/c/Users/Geoff/OneDrive/Desktop/Newbeards&Bucks12-5/04_ANTIGRAVITY_EXECUTION/logs/performance_monitor.log
```

### Check for Active Alerts
```bash
cat /mnt/c/Users/Geoff/OneDrive/Desktop/Newbeards&Bucks12-5/04_ANTIGRAVITY_EXECUTION/logs/ATTENTION_NEEDED.flag
```

---

## ⚠️ Alert Levels

### CRITICAL (Creates ATTENTION_NEEDED.flag)
- Site offline for 2+ consecutive checks
- > 10 errors in debug.log
- No backup exists

### WARN (Logged but no flag)
- Slow page load (> 5 seconds)
- Backup not from today
- Small error counts

### INFO (Logged silently)
- All checks passed
- Routine monitoring events

---

## 🔧 Troubleshooting

### Cron Not Running?

**Check if cron service is active:**
```bash
sudo systemctl status cron  # Linux
sudo launchctl list | grep cron  # macOS
```

**Enable cron (if needed):**
```bash
sudo systemctl start cron  # Linux
```

### Scripts Not Executing?

**Check file permissions:**
```bash
ls -la /mnt/c/Users/Geoff/OneDrive/Desktop/Newbeards&Bucks12-5/04_ANTIGRAVITY_EXECUTION/automation/background_monitoring/
# Should show: -rwxr-xr-x (755 permissions)
```

**Test script manually:**
```bash
bash /mnt/c/Users/Geoff/OneDrive/Desktop/Newbeards&Bucks12-5/04_ANTIGRAVITY_EXECUTION/automation/background_monitoring/site_health_monitor.sh
```

**Check cron logs:**
```bash
# macOS
log stream --predicate 'process == "cron"'

# Linux
sudo tail -50 /var/log/syslog | grep CRON
```

### Alert Flag Not Creating?

**Check permissions on logs directory:**
```bash
mkdir -p /mnt/c/Users/Geoff/OneDrive/Desktop/Newbeards&Bucks12-5/04_ANTIGRAVITY_EXECUTION/logs
chmod 777 /mnt/c/Users/Geoff/OneDrive/Desktop/Newbeards&Bucks12-5/04_ANTIGRAVITY_EXECUTION/logs
```

---

## 📅 Monitoring Schedule

**Active Monitoring:**
- Site health: Every 15 minutes (96 checks/day)
- Errors: Every 5 minutes (288 checks/day)
- Performance: Every hour (24 checks/day)
- Backups: Once daily (2 AM)

**Expected Log Files:**
- `health_monitor.log` - ~1500 lines/week
- `error_monitor.log` - ~2000 lines/week
- `backup_monitor.log` - ~8 lines/week
- `performance_monitor.log` - ~200 lines/week

---

## ✅ Verification Checklist

After setup, verify:
- [ ] All 4 cron jobs appear in `crontab -l`
- [ ] Scripts are executable (`ls -la` shows `x`)
- [ ] Logs directory exists and is writable
- [ ] First execution completes without errors
- [ ] Log files are being created
- [ ] Alert flag creates properly when triggered

---

## 🎯 Next Steps

Once cron jobs are running:
1. Monitor logs for first 24 hours to verify normal operation
2. Test alert flag creation (stop site briefly to trigger alert)
3. Integrate alert response (check ATTENTION_NEEDED.flag in workflows)
4. Archive old logs weekly to prevent disk issues

---

**Phase 2 Status:** ✅ READY TO DEPLOY

All 4 background monitoring scripts are ready. Just add them to crontab and you'll have 24/7 monitoring.
