# Antigravity Task Execution Template

**Use this template for all future Antigravity tasks to maintain consistency and organization.**

---

## Task Header

**Task Name:** [Name of the task - e.g., "Remove Regions Field from Add Listing"]
**Task ID:** [Unique identifier - e.g., FIX_5_REGIONS]
**Execution Date:** [Date when task executed - e.g., 2025-12-06]
**Status:** [IN_PROGRESS | COMPLETED | BLOCKED]
**Blocker:** [YES | NO] - [Brief description if YES]

---

## Objective

**Primary Goal:**
[What should be accomplished? Be specific.]

**Expected Outcome:**
[What should be different after task is complete?]

**Success Criteria:**
- [ ] [Criterion 1]
- [ ] [Criterion 2]
- [ ] [Criterion 3]

---

## Execution Steps

### Step 1: [Brief Step Name]
**Action:** [What to do]
**Navigation Path:** [How to get there - menu path preferred]
**Location:** [URL or menu location]
**Expected Result:** [What should happen]

**Screenshot:** [Filename - e.g., step_1_navigation.png]
**Status:** ⏳ IN_PROGRESS / ✅ COMPLETED / ❌ FAILED

**Notes:**
[Any observations or issues]

---

### Step 2: [Brief Step Name]
**Action:** [What to do]
**Navigation Path:** [How to get there]
**Location:** [URL or menu location]
**Expected Result:** [What should happen]

**Screenshot:** [Filename]
**Status:** ⏳ IN_PROGRESS / ✅ COMPLETED / ❌ FAILED

**Notes:**
[Any observations or issues]

---

## Frontend Verification

**URL:** [Frontend page to verify]
**Verification Steps:**
1. [ ] Navigate to frontend
2. [ ] Check for [specific element/behavior]
3. [ ] Take screenshot showing verification
4. [ ] Note any unexpected behavior

**Screenshot:** [Verification screenshot filename]
**Result:** ✅ VERIFIED / ❌ NOT VISIBLE / ⚠️ PARTIAL

---

## Issues & Errors

### If No Issues:
✅ **No issues encountered** - Task executed smoothly

### If Issues Occurred:

**Issue #[Number]:** [Brief title]
- **Error Message:** [Full error text]
- **Context:** [What were you doing when error occurred]
- **Attempted Resolution:** [What did you try]
- **Result:** [Did resolution work]
- **Recommendation:** [What should be tried next]
- **Blocker:** [YES | NO]

**Screenshot:** [Error screenshot filename]

---

## Completion Summary

**Task Status:** ✅ COMPLETED / ⏳ IN_PROGRESS / ❌ BLOCKED

**Completed Steps:** [X/Y steps completed]

**Issues:** [0 issues | 1 critical issue blocking completion]

**Screenshots Captured:** [List all screenshots]
1. step_1_navigation.png
2. step_2_configuration.png
3. frontend_verification.png

**Time Elapsed:** [HH:MM minutes]

**Final Notes:**
[Any final observations, recommendations, or context for next person]

---

## Files & Documentation

**Output Files Created:**
- [Document 1 - e.g., fix_walkthrough.md]
- [Document 2 - e.g., fix_task_list.md]
- [Etc.]

**Related Documentation:**
- [Link to related files or guides]

**Next Steps:**
1. [What should happen next]
2. [Any follow-up verification needed]
3. [Any additional tasks pending]

---

## Critical Rules (MUST FOLLOW)

1. **Do Not Hallucinate**
   - Only interact with visible DOM elements
   - If element not found, report it clearly
   - Take screenshots as proof of every action
   - Do not assume elements exist

2. **Error Reporting**
   - Capture full error messages
   - Describe context (what were you doing)
   - Note whether error blocks task completion
   - Suggest next steps for resolution

3. **Screenshot Organization**
   - Save all screenshots to: `/04_ANTIGRAVITY_EXECUTION/screenshots/[task_id]/`
   - Use descriptive filenames
   - Reference screenshots by filename in this document

4. **Clean Documentation**
   - All tasks documented in this template format
   - Keep files organized in 04_ANTIGRAVITY_EXECUTION/
   - Update MASTER_LOG.md when task completes
   - Create issue tracker if problems found

5. **Frontend Verification**
   - After any configuration change, verify on frontend
   - Take screenshots showing changes are live
   - Check browser console for errors
   - Document any unexpected behavior

---

## Example: Completed Task Using This Template

See this structure applied to previous fixes:
- Maps to ANTIGRAVITY_RE_EXECUTION_GUIDE.md (the task specs)
- Results documented in fix_walkthrough.md (the execution)
- Task checklist in fix_task_list.md (the progress)

---

## Support Contact

**If Blocked:**
1. Follow "Critical Rules" above
2. Document error context completely
3. Suggest next troubleshooting steps
4. Wait for Claude Code (Support) response

**Claude Code will:**
- Review your documentation
- Diagnose root cause
- Provide next steps or manual intervention

---

**Use this template for every Antigravity task execution going forward.**

