# Antigravity Hallucination Prevention Rules

**Purpose:** Enforce strict verification rules to catch Antigravity hallucinations immediately
**Enforced By:** Claude Code (Support)
**Applies To:** Every single action Antigravity performs
**Failure Tolerance:** Zero - One hallucination caught and stopped

---

## 🚨 Critical Rules (Non-Negotiable)

### Rule 1: Screenshot Evidence Required
**What:** Every action Antigravity performs must have photographic proof
**Enforcement:** If no screenshot → Action didn't happen → REJECT

**Examples:**
```
Antigravity claims: "Clicked Save button"
Claude Code verification:
  ✅ ACCEPT if: Screenshot shows button being clicked/loading state
  ❌ REJECT if: No screenshot provided
  ❌ REJECT if: Screenshot shows button not present
  ❌ REJECT if: Screenshot shows error after click
```

**Implementation:**
```
After each action, Antigravity MUST provide:
1. Screenshot of action being performed
2. Timestamp of screenshot
3. Reference to previous screenshot (to show state before)
4. Description of what screenshot shows
```

---

### Rule 2: State Change Verification
**What:** Any claim of a change must be verified in actual system state
**Enforcement:** Check database, file system, or frontend to confirm change

**Examples:**
```
Antigravity claims: "API key saved to settings"
Claude Code verification:
  ✅ ACCEPT if: Database query shows option_value contains the key
  ✅ ACCEPT if: WordPress admin page shows key in field
  ❌ REJECT if: Database still shows old key
  ❌ REJECT if: Settings page shows empty field
```

**Verification Methods:**
1. **Database Direct Check** (most reliable)
   - Query WordPress options table
   - Verify specific settings changed
   - Check modification timestamps

2. **WordPress Admin Check**
   - Navigate to settings page
   - Verify visual confirmation of change
   - Check for success message

3. **Frontend Behavioral Check**
   - Test feature that depends on setting
   - Verify it works (not just appears)
   - Screenshot the working feature

---

### Rule 3: Error Detection
**What:** If Antigravity's screenshot shows any error, treat as failure
**Enforcement:** Automatic failure, no matter what Antigravity claims

**Error Indicators to Watch:**
```
RED FLAGS (automatic HALT):
- Error message on screen (red text, error icon)
- "404 Not Found" or "500 Server Error"
- "Access Denied" or "Permission Denied"
- "Invalid" or "Error saving"
- HTML error stack trace visible
- Browser error indicator (red X, red circle)
- Blank page or white screen
- "Unexpected" or "Failed to"
```

**Implementation:**
```
Before accepting any Antigravity claim:
1. Scan screenshot for red/orange error text
2. Scan for error icons or banners
3. Check URL (verify didn't navigate to error page)
4. Review console (if screenshot includes dev tools)
5. If ANY error visible → REJECT claim
```

---

### Rule 4: URL Verification
**What:** Verify Antigravity actually navigated to the correct page
**Enforcement:** Check URL in screenshot, verify page matches expectation

**Examples:**
```
Antigravity claims: "Navigated to Listeo Core > Map Settings"
Claude Code verification:
  ✅ ACCEPT if: URL is /wp-admin/admin.php?page=listeo_map_settings (or similar)
  ❌ REJECT if: URL is /wp-admin/ (stayed on main admin)
  ❌ REJECT if: URL is 404 page
  ❌ REJECT if: URL is login page (got logged out)
```

**Verification Steps:**
1. Check URL bar in screenshot
2. Verify URL matches expected path
3. Verify page title/header matches location
4. Verify breadcrumb navigation (if visible)

---

### Rule 5: Element Visibility Verification
**What:** Before action, verify element Antigravity claims to click is actually visible
**Enforcement:** Screenshot must show clickable element

**Examples:**
```
Antigravity claims: "Clicked Save Settings button"
Claude Code verification:
  ✅ ACCEPT if: Button visible and clickable in screenshot
  ❌ REJECT if: Button not in screenshot
  ❌ REJECT if: Button appears grayed out/disabled
  ❌ REJECT if: Button is below fold (might not be visible after scroll)
```

**Implementation:**
```
Before Antigravity clicks element:
1. Get screenshot showing element location
2. Verify element color/state (not disabled)
3. Verify element is visible (not hidden)
4. Only then approve the click
5. Get screenshot showing click/loading state
```

---

### Rule 6: Wait for Confirmation States
**What:** Don't accept "action complete" claims - wait for completion indicators
**Enforcement:** Verify page shows success state (not just action executed)

**Examples:**
```
Antigravity claims: "Saved settings"
Claude Code verification:
  ✅ ACCEPT if: Page shows "Settings saved" message
  ✅ ACCEPT if: Settings values persist in form
  ❌ REJECT if: Form still shows unsaved indicator
  ❌ REJECT if: Page hasn't refreshed/reloaded
  ❌ REJECT if: Spinner still visible
```

**Confirmation Indicators:**
```
Wait for ONE of:
- "Saved" or "Success" message appears
- Spinner/loading animation completes
- Page reloads and shows updated data
- Form fields show updated values
- Timestamp shows recent update

If none visible after 5 seconds → Action likely failed
```

---

## 🔍 Detection Process (Step-by-Step)

### For Each Antigravity Action:

```
1. Antigravity Claims: "I [did action]"

2. Claude Code Verification:
   a) Check screenshot exists
   b) Scan screenshot for errors
   c) Verify URL is correct
   d) Verify element is visible
   e) Verify action was performed (not just attempted)
   f) Verify completion indicator visible

3. Claude Code Determines:
   ✅ ACCEPT - All checks passed, action completed successfully
   ⚠️ UNCLEAR - Some concerns, need investigation
   ❌ REJECT - Evidence shows action didn't complete

4. Claude Code Reports:
   ✅ "Confirmed - [action] completed, [evidence]"
   ⚠️ "WAIT - [issue detected], investigating..."
   ❌ "HALT - [action] failed, [evidence], STOPPING execution"
```

---

## 📋 Common Hallucination Patterns (Watch For)

### Pattern 1: "Action Performed Without Evidence"
```
Hallucination: "I clicked the Save button"
Reality: No screenshot showing button click
Detection: Missing screenshot evidence
Response: REJECT - "Provide screenshot showing button click"
```

### Pattern 2: "Success Claim Without Confirmation"
```
Hallucination: "Settings saved"
Reality: Screenshot shows form still has unsaved indicator
Detection: Success message not visible in screenshot
Response: REJECT - "Settings not saved, form shows unsaved state"
```

### Pattern 3: "Wrong Page Navigation"
```
Hallucination: "Navigated to Listeo Core > Map Settings"
Reality: URL is still /wp-admin/, screenshot shows admin main page
Detection: URL doesn't match claim, page title is wrong
Response: REJECT - "You're still on admin main page, didn't navigate"
```

### Pattern 4: "Error Masked as Success"
```
Hallucination: "API key saved successfully"
Reality: Screenshot shows "Invalid API key" error in red
Detection: Error message visible in screenshot
Response: REJECT - "API key save failed, error message shows: [error text]"
```

### Pattern 5: "Element Doesn't Exist"
```
Hallucination: "Clicked Regions field checkbox"
Reality: No Regions field visible on page (already removed)
Detection: Element not present in screenshot
Response: REJECT - "Regions field not visible on this page"
```

### Pattern 6: "Partial Action Only"
```
Hallucination: "Saved the widget"
Reality: Screenshot shows widget configuration open, but Save button not clicked
Detection: Save button still visible, not in loading/post-save state
Response: REJECT - "Widget not saved yet, need to click Save button"
```

---

## ✅ Verification Checklist (Before Accepting Any Claim)

**Use this for every Antigravity action:**

```
□ Screenshot exists and shows action context
□ No error messages visible in screenshot
□ URL matches expected location
□ Element/button is visible and not disabled
□ Action execution visible (click, loading, input)
□ Completion indicator present (success message, page reload, etc.)
□ State changed in database/system (where verifiable)
□ Frontend reflects change (where applicable)
□ No unexpected behavior or side effects
□ Timestamp is recent (action just happened)
```

**Requirement:** ✅ 8/10 checks minimum to ACCEPT
**If less than 8:** Ask for clarification or REJECT and retry

---

## 🛑 HALT Conditions (Stop Everything)

**Claude Code STOPS Antigravity immediately if:**

1. **Access Denied or Permission Error**
   - Antigravity can't access page/feature
   - User lacks permissions
   - Action: Document issue, wait for manual intervention

2. **Database Error or Corruption**
   - Query fails or returns unexpected data
   - Data corrupted or inconsistent
   - Action: Rollback to backup, investigate

3. **Multiple Failed Retries**
   - Same action fails 3+ times
   - Suggests hallucination or system issue
   - Action: Stop task, investigate root cause

4. **Conflicting Changes**
   - Antigravity's action conflicts with expected state
   - System state different than Antigravity expects
   - Action: Verify system state, redo investigation

5. **Unrecoverable Error**
   - Page crashes or becomes unresponsive
   - Browser session broken
   - WordPress fatal error
   - Action: Restore from backup, restart

---

## 📊 Hallucination Score

**I track a "hallucination score" for Antigravity:**

```
Hallucination Score: [0-100]
0 = Perfect execution (no hallucinations detected)
50 = Some minor issues, still acceptable
100 = Major hallucination, task failed

Calculation:
- Each major hallucination detected: +25 points
- Each minor inconsistency: +5 points
- Each error masked as success: +30 points
- Perfect verification: +0 points (no penalty)

Action:
- Score 0-20: Task approved, proceed normally
- Score 20-40: Task approved with notation, review carefully
- Score 40+: Task FAILED, redo with investigation
```

---

## 🔁 Retry Protocol

**If hallucination detected:**

```
1. Document hallucination completely
2. Screenshot showing evidence
3. Create issue file: /issues/[ISSUE_ID].md
4. Stop current task
5. Investigate root cause
6. Attempt fix (workaround or manual)
7. Retry task with updated instructions
8. Monitor extra carefully on retry
9. Document lessons learned
```

---

## 📝 Enforcement Log

**I maintain this log of all hallucinations:**

| Date | Action | Hallucination Detected | Evidence | Resolution |
|------|--------|----------------------|----------|-----------|
| 2025-12-06 | Fix 5 | Access denied masked as issue | Screenshot showed error | Documented, escalated |
| | | | | |

---

## 🎯 Goal

**No hallucinations escape to production.**

Every single claim Antigravity makes is verified before you see it.
Every change to your site is confirmed working before moving on.
Every error is caught and documented.
You can trust the reports because they're backed by evidence.

---

**Rule Status:** ACTIVE & ENFORCED
**Enforcer:** Claude Code (Support)
**Tolerance for Hallucinations:** ZERO

