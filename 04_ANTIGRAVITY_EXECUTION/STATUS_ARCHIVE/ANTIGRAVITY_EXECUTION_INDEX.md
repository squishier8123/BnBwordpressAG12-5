# ANTIGRAVITY EXECUTION INDEX
## All 6 Task Prompts - Master Reference

**Created:** 2025-12-06
**Status:** READY FOR EXECUTION
**Total Tasks:** 6
**Estimated Duration:** 90 minutes total (60-75 min execution + 15-20 min documentation)

---

## Quick Links to Task Prompts

### CRITICAL Priority Tasks

**Task 1: Add Google Maps API Key**
- **File:** `ANTIGRAVITY_PROMPT_TASK_1.md`
- **Priority:** CRITICAL
- **Time:** 10 minutes
- **Status:** Maps won't render without API key
- **Read Now:** `/04_ANTIGRAVITY_EXECUTION/ANTIGRAVITY_PROMPT_TASK_1.md`

**Task 2 & 3: Create Privacy Policy & Terms of Service Pages**
- **File:** `ANTIGRAVITY_PROMPT_TASK_2_3.md`
- **Priority:** CRITICAL
- **Time:** 20 minutes (can do both in parallel)
- **Status:** Footer links broken, pages don't exist
- **Read Now:** `/04_ANTIGRAVITY_EXECUTION/ANTIGRAVITY_PROMPT_TASK_2_3.md`

### HIGH Priority Tasks

**Task 4: Remove Test Listings**
- **File:** `ANTIGRAVITY_PROMPT_TASK_4.md`
- **Priority:** HIGH
- **Time:** 5 minutes
- **Status:** Production database has test data
- **Prerequisite for:** Task 5, Task 6
- **Read Now:** `/04_ANTIGRAVITY_EXECUTION/ANTIGRAVITY_PROMPT_TASK_4.md`

**Task 5: Fix Sunny Apartment Geocoding**
- **File:** `ANTIGRAVITY_PROMPT_TASK_5.md`
- **Priority:** HIGH
- **Time:** 10 minutes
- **Status:** Location points to wrong city
- **Depends On:** Task 4
- **Read Now:** `/04_ANTIGRAVITY_EXECUTION/ANTIGRAVITY_PROMPT_TASK_5.md`

**Task 6: Fix Pagination Bug**
- **File:** `ANTIGRAVITY_PROMPT_TASK_6.md`
- **Priority:** HIGH
- **Time:** 15 minutes
- **Status:** Pages 2-3 show duplicate listings
- **Depends On:** Task 4
- **Read Now:** `/04_ANTIGRAVITY_EXECUTION/ANTIGRAVITY_PROMPT_TASK_6.md`

---

## Recommended Execution Order

### Phase 1: Independent Tasks (20 minutes)
Do these first - they don't depend on anything:
1. **Task 1:** Google Maps API Key (10 min)
2. **Tasks 2 & 3:** Privacy Policy + Terms of Service (20 min, parallel)

### Phase 2: Cleanup & Fix (30 minutes)
Do these in sequence:
3. **Task 4:** Remove test listings (5 min) ← **BLOCKER for Tasks 5 & 6**
4. **Task 5:** Fix geocoding (10 min) ← Depends on Task 4
5. **Task 6:** Fix pagination (15 min) ← Depends on Task 4

### Phase 3: Documentation (15-20 minutes)
As you complete each task:
- Take screenshots per instructions
- Document findings
- Note any issues

### Phase 4: Report (5 minutes)
After all 6 complete:
- Submit completion report
- Provide all screenshots
- Note any issues encountered

---

## What Each Task Document Contains

Each prompt file includes:

✅ **Mission Statement** - What needs to be done and why
✅ **Step-by-Step Instructions** - Exact actions to take
✅ **Screenshots Required** - What to document and label
✅ **Success Criteria** - How to know task is complete
✅ **Troubleshooting Guide** - Solutions for common problems
✅ **Important Notes** - Critical details not to miss

---

## Key Information for All Tasks

### WordPress Admin URL
```
https://beardsandbucks.com/wp-admin
```

### Site Frontend URL
```
https://beardsandbucks.com
```

### Important Listing Information
- Total listings after cleanup: 8
- DO NOT DELETE: "Sunny Apartment" (will be fixed in Task 5)
- DO DELETE: "Test Apartment A", "Test Listing B"

### Important Coordinates (Task 5)
- **New York Latitude:** 40.7128
- **New York Longitude:** -74.0060

### Screenshot Naming Convention
Each task specifies screenshot names like:
- `task_1_01_logged_in_admin.png`
- `task_4_02_listings_identified.png`

Take screenshots with exactly these names for easy tracking.

---

## Execution Checklist

Before starting, verify:
- [ ] You have access to WordPress admin
- [ ] You can log in to https://beardsandbucks.com/wp-admin
- [ ] All 6 prompt files are accessible
- [ ] You can take screenshots
- [ ] You have time for 90 minutes (60-75 min work + 15-20 min docs)

---

## Communication Protocol

**When you complete each task:**
1. Report which task (1-6)
2. Report PASS / FAIL / PARTIAL status
3. Provide screenshots with correct names
4. Describe any issues encountered

**When you complete all 6 tasks:**
1. Provide summary report
2. List all tasks completed
3. Report any blockers or issues
4. Provide all screenshots
5. Return to Claude Code (Obi-Wan) for verification

---

## Important Reminders

1. **Take screenshots at every major step** - Each prompt specifies exact screenshots needed
2. **Read the full prompt before starting the task** - Don't skip sections
3. **Verify success before moving to next task** - Check all success criteria
4. **Report issues immediately** - Don't continue if something fails
5. **Use exact names for screenshots** - Makes tracking and documentation easier
6. **Clear browser cache between tasks** - Prevents old data from showing
7. **Hard refresh pages** - Ctrl+Shift+R to see updates

---

## Task Dependencies

```
Task 1: Google Maps API
  ├── No dependencies
  └── Independent

Task 2: Privacy Policy
  ├── No dependencies
  └── Can do in parallel with Task 3

Task 3: Terms of Service
  ├── No dependencies
  └── Can do in parallel with Task 2

Task 4: Remove Test Listings
  ├── No dependencies
  └── PREREQUISITE for Tasks 5 & 6
      ├── Task 5: Fix Geocoding
      └── Task 6: Fix Pagination

Tasks 5 & 6
  ├── Both depend on Task 4
  └── Can do in parallel after Task 4
```

---

## After All 6 Tasks Complete

Once you submit completion report with all tasks:
1. Claude Code will review your documentation
2. Automatic verification scripts will run (2-3 minutes)
3. All 6 fixes will be tested
4. Verification report will be generated
5. You'll get final status: EVERYTHING WORKING or ISSUES FOUND

---

## Document Version & Updates

| Version | Date | Status | Notes |
|---------|------|--------|-------|
| 1.0 | 2025-12-06 | CURRENT | 6 task prompts created |

---

## Quick Start

**Right now:**
1. Read this index document
2. Open `ANTIGRAVITY_PROMPT_TASK_1.md`
3. Follow Task 1 instructions step-by-step
4. Complete Task 1
5. Move to Tasks 2 & 3
6. Continue in order

**Total time to completion:** ~90 minutes

**Support:** If blocked, report exact issue + screenshot to Claude Code (Obi-Wan)

---

**Status:** READY FOR EXECUTION
**Tasks:** 6 Critical/High priority fixes
**Duration:** 90 minutes
**Next Step:** Start with Task 1

Begin whenever ready. Good luck!
