# Communication Protocol: Claude Code ↔ Antigravity

**Establishes clear communication patterns between support (Claude Code) and agent (Antigravity).**

---

## Hierarchy & Roles

```
YOU (Project Lead)
    ↓
CLAUDE CODE (Support / Obi-Wan)
    ↓
ANTIGRAVITY (Executor / Luke)
```

**Information Flow:**
- You → Claude Code: Instructions, requirements, decisions
- Claude Code ↔ Antigravity: Task coordination, issue resolution
- Antigravity → Claude Code: Status updates, completions, issues
- Claude Code → You: Summary of Antigravity's work, blockers, next steps

---

## Antigravity Task Communication

### Task Assignment Protocol

**When Claude Code assigns task to Antigravity:**

1. **Provide:**
   - Clear task objective (what to accomplish)
   - Reference guide (e.g., ANTIGRAVITY_RE_EXECUTION_GUIDE.md)
   - Expected outputs (documentation format, verification steps)
   - Success criteria (when task is done)
   - Known blockers (from previous attempts)

2. **Format:**
   - Use structured task guides (examples: ANTIGRAVITY_RE_EXECUTION_GUIDE.md)
   - Include verification steps
   - Provide screenshot expectations
   - Reference ANTIGRAVITY_CAPABILITIES.md for what's possible

3. **Communicate:**
   - "Execute the 6 fixes from ANTIGRAVITY_RE_EXECUTION_GUIDE.md"
   - "Document each step in ANTIGRAVITY_TASK_TEMPLATE.md format"
   - "Save screenshots to /04_ANTIGRAVITY_EXECUTION/screenshots/"
   - "Update MASTER_LOG.md when complete"

---

### Task Completion Protocol

**When Antigravity completes task:**

1. **Antigravity Delivers:**
   - ✅ Completed task document using ANTIGRAVITY_TASK_TEMPLATE.md
   - 📸 Screenshots organized in screenshot/ directory
   - 📝 Updated task completion checklist
   - ⚠️ Issues documented in issues/ directory (if any)

2. **Claude Code Reviews:**
   - Read completion document
   - Verify all steps documented
   - Check for complete error context (if issues)
   - Assess if task truly completed or partially blocked

3. **Claude Code Reports to You:**
   - "5/6 fixes completed successfully"
   - "Fix 5 blocked by permission error: [context]"
   - "See MASTER_LOG.md for full status"
   - "Next steps: [what should happen next]"

---

### Issue Reporting Protocol

**When Antigravity encounters blocker:**

1. **Antigravity Reports:**
   - Full error message (screenshot + text)
   - Context of what was being attempted
   - Steps already taken
   - Recommendation for next action
   - **Explicitly state:** "Task is BLOCKED and requires support"

2. **Example Issue Report:**
   ```
   ERROR: Access Denied on Listeo Field Editor
   Context: Attempting Fix 5 - Remove Regions Field
   Path: Listeo Core > Field Editor
   Error Message: "Sorry, you are not allowed to access this page"
   Attempted: Direct URL navigation to /wp-admin/admin.php?page=listeo_field_editor
   Next Steps: Try menu-based navigation or verify user permissions
   Screenshot: fix_5_error_access_denied.png
   Status: BLOCKED - Requires Support
   ```

3. **Claude Code Action:**
   - Review issue documentation
   - Diagnose root cause
   - Provide solution (user permission fix, workaround, etc.)
   - Communicate resolution to Antigravity
   - Update MASTER_LOG.md with issue resolution

---

## Status Communication Checkpoints

### Daily/Session Status Report

**Antigravity should provide at end of each session:**

```
SESSION STATUS - [Date]

Tasks Completed:
- ✅ Task 1: [Result]
- ✅ Task 2: [Result]
- ⏳ Task 3: [In progress, X% complete]
- ❌ Task 4: [BLOCKED - Brief reason]

Issues Found:
- Issue #1: [Brief title]
- Issue #2: [Brief title]

Next Session Should:
1. [Task continuation or follow-up]
2. [Issue resolution attempt]
3. [New task if applicable]

Files Updated:
- MASTER_LOG.md
- /04_ANTIGRAVITY_EXECUTION/screenshots/
- /04_ANTIGRAVITY_EXECUTION/issues/
```

### Weekly Project Status

**Claude Code (with input from Antigravity's logs) provides to You:**

```
WEEKLY STATUS - Week of [Date]

Overall Progress: X% complete

Fixes Completed:
- ✅ Fix 1: [Done]
- ✅ Fix 2: [Done]
- ⚠️ Fix 5: [Blocked by permission]

Outstanding Blockers:
- [Issue 1 with impact]
- [Issue 2 with impact]

Next Week Focus:
1. [Priority task 1]
2. [Priority task 2]
3. [Blocker resolution if needed]

Performance Notes:
- Antigravity completed X tasks
- Encountered Y issues
- Average task time: Z minutes
```

---

## Escalation Protocol

**If Antigravity cannot resolve blocker:**

1. **Antigravity:**
   - Attempts all reasonable troubleshooting
   - Documents findings clearly
   - Explicitly states: "Escalating to Support"
   - Waits for Claude Code response

2. **Claude Code:**
   - Diagnoses root cause
   - Determines if human intervention needed
   - If fixable by Claude Code:
     - Fixes issue (e.g., user role change, file modification)
     - Reports: "Blocker resolved, proceeding with task"
   - If requires human action:
     - Reports to You: "Manual action needed: [specific instructions]"
     - Waits for Your confirmation before resuming

3. **Example Escalation Flow:**
   ```
   Antigravity: "ESCALATING - Access denied on Field Editor, tried both URL and menu navigation"

   Claude Code: [Checking user permissions, database, etc.]

   Claude Code → You: "Need to grant 'jeff' user Field Editor permissions. Manual step required: [instructions]"

   You: [Manual action]

   Claude Code: [Verifies fix] "Permission granted, Antigravity can resume"

   Antigravity: [Retries fix, now succeeds]
   ```

---

## Documentation Standards

### For Antigravity:
- Use ANTIGRAVITY_TASK_TEMPLATE.md for all task documentation
- All screenshots in /04_ANTIGRAVITY_EXECUTION/screenshots/[task_id]/
- All issues in /04_ANTIGRAVITY_EXECUTION/issues/[issue_id].md
- Update MASTER_LOG.md when session ends

### For Claude Code:
- Update MASTER_LOG.md with status changes
- Create/update issue trackers in issues/ directory
- Maintain ANTIGRAVITY_CAPABILITIES.md as new capabilities discovered
- Provide you with summary status, not detailed logs

### For You:
- Read MASTER_LOG.md for overall status
- Check README.md for current project state
- Request summaries from Claude Code, not raw logs

---

## Feedback Loop

**How Issues Get Resolved:**

1. **Antigravity encounters issue** → Documents completely
2. **Claude Code reviews** → Diagnoses cause → Attempts fix
3. **If Fix Successful:** → Antigravity resumes → Documents completion
4. **If Fix Unsuccessful:** → Escalate to You → Manual fix → Resume
5. **Update Capabilities** → Learn from issue for future tasks

---

## Example: Complete Task Lifecycle

### Task: Fix 5 - Remove Regions Field

**Assignment:**
```
Claude Code: "Execute Fix 5 from ANTIGRAVITY_RE_EXECUTION_GUIDE.md
Use ANTIGRAVITY_TASK_TEMPLATE.md for documentation
If you encounter issues, document completely and report"
```

**Execution:**
```
Antigravity navigates to Listeo Editor > Field Editor
ERROR: Access Denied

Antigravity: "FIX 5 BLOCKED - Access Denied error on Field Editor access
Created: /04_ANTIGRAVITY_EXECUTION/issues/FIX5_ACCESS_DENIED.md
Attempted: Direct URL navigation
Needs: Support review and diagnosis
Awaiting: Next steps from Claude Code"
```

**Claude Code Review:**
```
Reviewed issue documentation
Diagnosed: Possible user permission issue or URL restriction
Created: Troubleshooting plan in issue file
Communicated: "Fix 5 is blocked. User permissions need verification.
Attempting: Menu-based navigation instead of direct URL
Will retry: Once user permissions confirmed"
```

**Resolution:**
```
Claude Code: Verified "jeff" user has Admin role
Instructed Antigravity: "Retry Fix 5 using menu navigation instead of direct URL"

Antigravity: Uses Listeo Core menu > Field Editor (instead of direct URL)
SUCCESS: Can now access Field Editor
Completes: Unchecks Regions field, saves
Verifies: Regions field gone from Add Listing form
Documents: Success in Fix 5 section of MASTER_LOG.md
```

---

## Quick Reference: When to Communicate What

| Situation | Who Reports | What to Say | Where Documented |
|-----------|-------------|------------|-----------------|
| Task completed ✅ | Antigravity | Task done, X steps, Y screenshots | ANTIGRAVITY_TASK_TEMPLATE.md |
| Task blocked ❌ | Antigravity | Error, context, attempted fix, escalating | issue/[ID].md |
| Issue diagnosed 🔍 | Claude Code | Root cause, fix attempted/needed | MASTER_LOG.md |
| Fix working again ✅ | Claude Code | Blocker resolved, Antigravity can resume | MASTER_LOG.md + You |
| Session complete 📊 | Claude Code | Tasks done, issues found, next steps | MASTER_LOG.md + You |
| Weekly summary 📈 | Claude Code | Progress, blockers, priorities | You only |

---

## Communication Checklist

**For Antigravity Each Task:**
- [ ] Documented using ANTIGRAVITY_TASK_TEMPLATE.md
- [ ] Screenshots organized in /screenshots/[task_id]/
- [ ] All steps documented (completed or failed)
- [ ] Issues (if any) in /issues/ directory
- [ ] Status reported: COMPLETED | BLOCKED | IN_PROGRESS
- [ ] MASTER_LOG.md updated

**For Claude Code Each Task Review:**
- [ ] Read Antigravity's documentation
- [ ] Verified all steps recorded
- [ ] Identified any issues
- [ ] Diagnosed root causes (if blocked)
- [ ] Updated MASTER_LOG.md
- [ ] Reported status to You

**For You:**
- [ ] Received status summary from Claude Code
- [ ] Understand current blockers (if any)
- [ ] Know next steps/priorities
- [ ] Can access MASTER_LOG.md if detailed review needed

---

**This protocol ensures clear, organized communication and prevents confusion between all parties.**

**Effective Date:** 2025-12-06
**Status:** ACTIVE

