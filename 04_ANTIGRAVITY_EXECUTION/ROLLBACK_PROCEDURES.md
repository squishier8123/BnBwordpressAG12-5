# Rollback Procedures - Emergency Recovery

**Purpose:** Quickly undo Antigravity's changes if something goes wrong
**Owner:** Claude Code (Support)
**When to Use:** If hallucination detected or major error occurs
**Recovery Time:** 2-5 minutes from backup

---

## 🚨 When to Rollback

**Roll back if:**
- ✅ Antigravity causes unintended changes
- ✅ Hallucination detected that corrupted data
- ✅ Database error or data corruption
- ✅ Settings changed incorrectly
- ✅ Pages/content deleted by accident
- ✅ WordPress becomes unstable
- ✅ Any major issue that requires complete reset

**Don't roll back if:**
- ❌ Just a verification failure (investigate first)
- ❌ Minor UI issue (can be fixed without rollback)
- ❌ Only Antigravity's documentation wrong (data is fine)

---

## 🔄 Rollback Methods (In Order)

### Method 1: Git Rollback (Fastest - 30 seconds)

**When:** Antigravity only modified files, not database
**Command:**
```bash
cd "/mnt/c/Users/Geoff/OneDrive/Desktop/Newbeards&Bucks12-5"
git log --oneline -10  # See recent commits
git reset --hard [COMMIT_HASH]  # Go back to safe commit
```

**Example:**
```bash
# Your pre-session commit was: abc123f "Pre-session checkpoint"
# Antigravity messed up, commit was: def456e "Antigravity session"
git reset --hard abc123f  # Go back to before Antigravity ran
```

**Result:** All Antigravity's file changes undone
**Verification:** `git status` shows clean working tree

---

### Method 2: Database Restore (Most Critical - 2-5 minutes)

**When:** Antigravity modified database (settings, deleted pages, etc.)
**Requirement:** Database backup exists from before Antigravity

**Steps:**

#### Step 1: Locate Backup File
```bash
ls -la "/path/to/backups/backup-*.sql"
# Look for most recent backup before Antigravity started
# Example: backup-2025-12-06-06-30.sql
```

#### Step 2: Stop WordPress (Optional but Safer)
```bash
# If WordPress running, stop it to prevent conflicts
# For local/dev: Just continue
# For production: Stop PHP/Apache if needed
```

#### Step 3: Restore Database
```bash
# Using MySQL/MariaDB command line:
mysql -u [user] -p [database_name] < backup-2025-12-06-06-30.sql

# OR using wp-cli (if available):
wp db import backup-2025-12-06-06-30.sql --allow-root
```

**Example (Using Direct MySQL):**
```bash
mysql -u wordpress -p beardsandbucks_db < backup-2025-12-06-06-30.sql
# Enter password when prompted
```

#### Step 4: Verify Restore
```bash
# Connect to database
mysql -u [user] -p [database_name]

# Check recent changes were removed:
SELECT option_name, option_value FROM wp_options WHERE option_name = 'mapbox_api_key';
# Should show old value (or null if not set before)

# Exit
exit
```

#### Step 5: Clear WordPress Cache
```bash
# If using cache plugin, clear it:
# Go to WordPress admin > Cache settings > Clear All Cache
# OR delete cache files manually
```

**Result:** Database restored to pre-Antigravity state
**Verification:** Check WordPress admin shows old data

---

### Method 3: Combined Rollback (Full Reset)

**When:** Needed to roll back BOTH files and database
**Use This:** If you're not sure which changed

**Steps:**
```bash
# Step 1: Git rollback
cd "/mnt/c/Users/Geoff/OneDrive/Desktop/Newbeards&Bucks12-5"
git reset --hard [SAFE_COMMIT_HASH]

# Step 2: Database restore
mysql -u [user] -p [database_name] < backup-2025-12-06-06-30.sql

# Step 3: Clear all caches
# Remove /wp-content/cache/ files if using file-based cache
rm -rf /path/to/wp-content/cache/*

# Step 4: Verify site loads
# Navigate to site, check homepage loads correctly
```

**Result:** Complete reset to pre-session state
**Time:** ~5 minutes total

---

## 📋 Pre-Rollback Checklist

**Before rolling back, verify:**
- [ ] You have identified the exact issue
- [ ] Rollback won't lose important new data
- [ ] Backup file exists and is recent enough
- [ ] You have commit hash of safe state
- [ ] You understand what will be lost
- [ ] You're not about to lose user data

---

## 🔍 How to Find Safe Commit

**View git history:**
```bash
git log --oneline
```

**You'll see:**
```
def456e Antigravity session 4 - completed fixes 1-3
abc123f Pre-session checkpoint
xyz789z Previous working state
...
```

**Safe commit to roll back to:** `abc123f` (the pre-session checkpoint)

---

## 🔍 How to Find Safe Backup

**List backups:**
```bash
ls -la "/path/to/backups/" | grep backup
```

**You'll see:**
```
backup-2025-12-06-06-30.sql (taken before Antigravity)
backup-2025-12-06-06-45.sql (taken after Antigravity messed up)
```

**Safe backup to restore:** The earlier one (06-30)

---

## ✅ Verification After Rollback

**Confirm rollback successful:**

### For Git Rollback:
```bash
git log --oneline -2  # Verify HEAD is at safe commit
git status  # Should show "nothing to commit, working tree clean"
```

### For Database Rollback:
```bash
# Test by checking WordPress admin
# 1. Navigate to WordPress admin
# 2. Check Settings show pre-change values
# 3. Check any deleted pages are restored
# 4. Verify no new database errors
```

### For Full Rollback:
```bash
# Test both:
# 1. Git status shows clean
# 2. WordPress admin shows correct data
# 3. Frontend loads without errors
# 4. No error messages in browser console
```

---

## 🚨 Emergency Contacts

**If rollback fails:**

1. **Check backup file exists**: `ls -la backup-*.sql`
2. **Try alternate backup**: Use older backup if recent one failed
3. **Manual database restore**: If automated restore fails
4. **Reinstall WordPress**: Last resort if database corrupted

---

## 📝 Rollback Log

**I maintain a log of all rollbacks:**

| Date | Reason | Method | Result | Time |
|------|--------|--------|--------|------|
| 2025-12-06 | Test (none yet) | — | — | — |
| | | | | |

---

## 🎯 Prevention (Better than Rollback)

**To avoid needing rollbacks:**

1. ✅ **Pre-flight checks** - Verify safe state before Antigravity starts
2. ✅ **Pre-session backup** - Always create backup before running Antigravity
3. ✅ **Pre-session git commit** - Save known-good state
4. ✅ **Real-time monitoring** - Catch issues as they happen
5. ✅ **Hallucination detection** - Stop bad actions before they complete

**The goal:** Never need to rollback because Antigravity's work is verified at each step.

---

**Rollback Status:** READY TO USE
**Last Tested:** N/A (not yet needed)
**Keep Backups:** At least 7 days

