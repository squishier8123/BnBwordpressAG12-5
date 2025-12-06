# Pre-Flight Checklist - Safety Verification Before Antigravity Execution

**Purpose:** Verify site is in safe state before Antigravity executes ANY task
**Must Complete:** Before each Antigravity session starts
**Owner:** Claude Code (Support)
**Enforcement:** HALT if ANY check fails

---

## ✅ Pre-Flight Checks (In Order)

### Check 1: Site is Online and Responsive
**What:** Verify site responds to HTTP requests
**Command:** Test site accessibility
**Pass Criteria:** Site returns 200 OK, loads without error
**Action if Fail:** STOP - Do not start Antigravity. Restore site or fix connectivity.

**Status:** [ ] PASS / [ ] FAIL
**Details:**
**Timestamp:**

---

### Check 2: WordPress Admin is Accessible
**What:** Verify /wp-admin/ loads and login page appears
**Command:** Check WordPress admin URL
**Pass Criteria:** Login page displays, no 404 or 500 errors
**Action if Fail:** STOP - Database or WordPress files corrupted. Restore from backup.

**Status:** [ ] PASS / [ ] FAIL
**Details:**
**Timestamp:**

---

### Check 3: Database Backup Exists and is Recent
**What:** Verify database backup from today exists
**Command:** Check backup directory for latest .sql file
**Pass Criteria:** Backup exists from within last 24 hours, size > 1MB
**Action if Fail:** Create backup NOW before proceeding

**Backup File:**
**Backup Date:**
**Backup Size:**
**Status:** [ ] PASS / [ ] FAIL
**Timestamp:**

---

### Check 4: .env File Contains Required Credentials
**What:** Verify .env has all necessary API keys and credentials
**Command:** Check /mnt/c/Users/Geoff/OneDrive/Desktop/.env.beardsandbucks
**Pass Criteria:** File exists, contains:
  - WP_ADMIN_USER
  - WP_ADMIN_PASSWORD
  - WP_MAPBOX_API_KEY

**Action if Fail:** STOP - Add missing credentials before proceeding

**Credentials Present:**
  - [ ] WP_ADMIN_USER
  - [ ] WP_ADMIN_PASSWORD
  - [ ] WP_MAPBOX_API_KEY

**Status:** [ ] PASS / [ ] FAIL
**Timestamp:**

---

### Check 5: User Account Has Correct Permissions
**What:** Verify WordPress user "jeff" has Administrator role
**Command:** Check WordPress user role via REST API
**Pass Criteria:** User "jeff" has "Administrator" role
**Action if Fail:** Grant Administrator role to "jeff" user before proceeding

**User Account:** jeff
**Current Role:**
**Role Verified:** [ ] YES / [ ] NO
**Status:** [ ] PASS / [ ] FAIL
**Timestamp:**

---

### Check 6: Git Repository is Clean
**What:** Verify no uncommitted changes before Antigravity starts
**Command:** git status
**Pass Criteria:** Working tree is clean, no staged or unstaged changes
**Action if Fail:** Commit or stash changes, OR continue with acknowledgment

**Uncommitted Changes:**
**Status:** [ ] PASS / [ ] FAIL / [ ] ACKNOWLEDGED
**Timestamp:**

---

### Check 7: Create Pre-Session Git Commit
**What:** Save current state before Antigravity makes changes
**Command:** git commit -m "Pre-session checkpoint [timestamp]"
**Pass Criteria:** Commit created successfully, hash recorded
**Action if Fail:** Try again, or document why commit failed

**Commit Hash:**
**Commit Message:**
**Status:** [ ] PASS / [ ] FAIL
**Timestamp:**

---

### Check 8: WordPress Error Logs are Empty (or at acceptable baseline)
**What:** Verify no existing errors that might confuse Antigravity
**Command:** Check /wp-content/debug.log for recent errors
**Pass Criteria:** No errors within last 2 hours, OR existing errors documented
**Action if Fail:** Review errors, fix if necessary, or document baseline for comparison

**Existing Errors:**
**Error Count:**
**Status:** [ ] PASS / [ ] FAIL / [ ] BASELINE_DOCUMENTED
**Timestamp:**

---

### Check 9: Verify No Other Processes Modifying Site
**What:** Ensure no other tasks/scripts are running
**Command:** Check for running processes, scheduled tasks
**Pass Criteria:** No other automation running, site not being modified
**Action if Fail:** Wait for other process to complete, then start fresh pre-flight

**Other Processes Running:**
**Status:** [ ] PASS / [ ] FAIL
**Timestamp:**

---

### Check 10: Verify API Access (if applicable)
**What:** Test Mapbox API key is valid (for Fix 1 execution)
**Command:** Attempt to authenticate with Mapbox API
**Pass Criteria:** API returns valid response, key is accepted
**Action if Fail:** If executing Fix 1: Update .env with valid key before proceeding

**API Key Status:**
**Status:** [ ] PASS / [ ] FAIL / [ ] NOT_APPLICABLE
**Timestamp:**

---

## 📋 Summary

**Total Checks:** 10
**Checks Passed:** ___/10
**Checks Failed:** ___

**Overall Status:**
- [ ] ✅ SAFE TO PROCEED - All checks passed
- [ ] ⚠️ CONDITIONAL - Some checks failed but acknowledged, proceed with caution
- [ ] 🚨 HALT - Critical check failed, do not proceed

**Pre-Flight Approval:** [ ] APPROVED / [ ] BLOCKED

---

## 🆘 If Any Check Fails

**Critical Failures (MUST FIX):**
- [ ] Check 1: Site offline → Restore site or wait for fix
- [ ] Check 2: WordPress broken → Restore from backup
- [ ] Check 3: No backup → Create backup now
- [ ] Check 4: Missing credentials → Add credentials before proceeding
- [ ] Check 5: User lacks permissions → Grant Administrator role

**Non-Critical Failures (Can acknowledge and continue):**
- [ ] Check 6: Uncommitted changes → Document and commit before session
- [ ] Check 8: Existing errors → Document baseline for comparison
- [ ] Check 9: Other processes → Wait or document why acceptable

---

## 📌 Session Information

**Session ID:**
**Date/Time Started:**
**Antigravity Task(s):**
**Expected Duration:**
**Pre-Flight Completed By:** Claude Code
**Approved By:** (blank - automated after all checks pass)

---

## 🔄 Post-Session Closure

**After Antigravity completes:**
- [ ] Verify all fixes (see VERIFICATION_SCRIPTS/)
- [ ] Create post-session git commit
- [ ] Document any issues found
- [ ] Update MASTER_LOG.md
- [ ] Review changes with git diff
- [ ] Backup database post-changes

**Post-Session Commit Hash:**
**Post-Session Backup:**

---

## 📝 Notes

**Session Notes:**
```
[Add any notes, blockers, or special conditions for this session]
```

---

**Last Updated:** 2025-12-06
**Status:** TEMPLATE READY FOR USE
**Next Session:** Run this checklist in full before Antigravity starts

