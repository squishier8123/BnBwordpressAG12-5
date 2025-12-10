# Antigravity Testing System for Beards & Bucks
**Autonomous Agent-Based UX Testing and Scoring**

---

## What This Is

A complete testing framework that uses **Antigravity autonomous agents** to simulate real users with different personas, goals, and backgrounds. Each agent:

- ✅ Autonomously navigates your site (https://beardsandbucks.com)
- ✅ Uses browser like a real user would
- ✅ Makes decisions based on goals using Claude
- ✅ Scores the user experience across 6 dimensions
- ✅ Documents issues found (critical, major, minor)
- ✅ Generates comprehensive test reports

---

## Quick Facts

| Aspect | Details |
|--------|---------|
| **Agent Count** | 5 personas: Jake, Sarah, Mike, Emma, Tom |
| **Test Duration** | ~15 min per agent, ~90 min for full test |
| **Score Scale** | 0-100 points (90+ = excellent, 70-79 = acceptable, <60 = poor) |
| **Scoring Dimensions** | Discoverability, Performance, Design, Functionality, Content, Mobile |
| **Output** | Markdown report with scores, issues, recommendations, next steps |
| **Randomization** | Agents selected randomly each run (different results each time) |
| **Browser** | Real Chromium browser with screenshots and interaction logging |

---

## The 5 Agent Personas

### 1. **Jake** - Hunter Seeking Outfitter
Goal: Find and book a premium hunting outfitter in Illinois
- Explores search/browse features
- Reads reviews and vendor info
- Attempts to book an experience
- Scores: Discoverability, Performance, Content

### 2. **Sarah** - Used Gear Vendor
Goal: List used archery gear for sale, manage inventory
- Finds vendor registration
- Creates account
- Lists first product
- Explores vendor dashboard
- Scores: Discoverability, Functionality, Design

### 3. **Mike** - Budget Gear Shopper
Goal: Find affordable used hunting gear
- Browses marketplace
- Filters by price and category
- Compares products
- Attempts purchase
- Scores: Performance, Functionality, Discoverability

### 4. **Emma** - Information Seeker
Goal: Learn about hunting in Illinois
- Explores vendor profiles
- Reads reviews and content
- Gathers information before committing
- Evaluates trustworthiness
- Scores: Content Quality, Design, Discoverability

### 5. **Tom** - Outfitter Vendor
Goal: Manage hunting outfitter business online
- Accesses vendor dashboard
- Updates business information
- Manages listings
- Views analytics
- Scores: Functionality, Design, Content

---

## Files in This Directory

### Configuration Files
- **`agent_personas.json`** - Agent definitions, goals, success criteria, scoring rubric
- **`antigravity_config.yaml`** - Complete configuration: site, browser, scoring, reporting

### Documentation
- **`beards_bucks_testing_workflow.md`** - 10-step detailed workflow explanation
- **`IMPLEMENTATION_GUIDE.md`** - How to set up, run, and interpret tests
- **`README.md`** - This file

---

## How It Works

```
┌──────────────────────────────────────────┐
│ Antigravity Reads Configuration          │
│ (agent_personas.json, antigravity_config.yaml) │
└────────────────┬─────────────────────────┘
                 ↓
┌──────────────────────────────────────────┐
│ Select Random Agent                      │
│ (Jake? Sarah? Mike? Emma? Tom?)          │
└────────────────┬─────────────────────────┘
                 ↓
┌──────────────────────────────────────────┐
│ Launch Browser & Start Navigation        │
│ Opens https://beardsandbucks.com         │
└────────────────┬─────────────────────────┘
                 ↓
┌──────────────────────────────────────────┐
│ Autonomous Loop (Until goal or timeout)  │
│ • Agent sees page (screenshot + structure) │
│ • Claude decides what to do next         │
│ • Execute action (click, type, scroll)   │
│ • Record metrics & experiences           │
│ • Score against rubric                   │
│ • Loop                                   │
└────────────────┬─────────────────────────┘
                 ↓
┌──────────────────────────────────────────┐
│ Score Agent Experience (0-100)           │
│ • Discoverability (0-20)                 │
│ • Performance (0-20)                     │
│ • Design (0-15)                          │
│ • Functionality (0-20)                   │
│ • Content (0-15)                         │
│ • Mobile (0-10)                          │
└────────────────┬─────────────────────────┘
                 ↓
┌──────────────────────────────────────────┐
│ Compile Issues & Observations            │
│ • Critical issues (blocks user goal)     │
│ • Major issues (hurts UX significantly)  │
│ • Minor issues (inconvenient)            │
│ • Screenshots & logs                     │
└────────────────┬─────────────────────────┘
                 ↓
┌──────────────────────────────────────────┐
│ Generate Report                          │
│ • Individual agent score & breakdown     │
│ • All issues found                       │
│ • Strengths identified                   │
│ • Prioritized recommendations            │
└────────────────┬─────────────────────────┘
                 ↓
┌──────────────────────────────────────────┐
│ Save Results                             │
│ • Markdown report (human-readable)       │
│ • JSON data (machine-readable)           │
│ • Screenshots & logs (analysis)          │
└──────────────────────────────────────────┘
```

---

## Running Tests

### Quick Single Agent Test
```bash
antigravity run --config antigravity_config.yaml --pattern=single
```
- Runs 1 random agent
- Takes ~15-20 minutes
- Quick feedback on one user journey

### Full Assessment (All 5 Agents)
```bash
antigravity run --config antigravity_config.yaml --pattern=full
```
- Runs all 5 agents
- Takes ~90 minutes
- Comprehensive site assessment
- Best for thorough testing

### Specific Agents Only
```bash
antigravity run --config antigravity_config.yaml --agents=jake_hunter,sarah_vendor
```
- Run only selected agents
- Good for focused testing after changes

---

## Understanding Scores

### Score Ranges

| Score | Rating | Meaning |
|-------|--------|---------|
| 90-100 | ⭐⭐⭐⭐⭐ Excellent | Production-ready, minor polish only |
| 80-89 | ⭐⭐⭐⭐ Good | Most issues fixed, ready to go |
| 70-79 | ⭐⭐⭐ Acceptable | Several improvements needed |
| 60-69 | ⭐⭐ Fair | Significant work needed |
| <60 | ⭐ Poor | Major issues, not ready |

### Example Report Snippet

```
SITE AVERAGE SCORE: 77/100 ✓ Acceptable

Individual Agent Scores:
- Jake (Hunter):      81/100 Good
- Sarah (Vendor):     72/100 Acceptable
- Mike (Shopper):     78/100 Good
- Emma (Researcher):  76/100 Acceptable
- Tom (Outfitter):    73/100 Acceptable

CRITICAL ISSUES (Must Fix):
🔴 Vendor Dashboard link missing from homepage
   Impact: Vendors cannot access business tools
   Fix: Add "Vendor Dashboard" link to main menu

MAJOR ISSUES (High Priority):
🟠 County search doesn't filter results properly
   Impact: Hunters can't find outfitters by location
   Fix: Debug search filter logic

MINOR ISSUES:
🟡 Button text inconsistency ("Book Now" vs "Reserve")
🟡 Vendor photos load slowly
```

---

## Key Features

✅ **Autonomous Navigation** - Agents navigate like real users, not scripted sequences
✅ **Multi-Persona Testing** - Test from 5 different user perspectives
✅ **Goal-Based** - Each agent has a specific goal and success criteria
✅ **Quantified Scoring** - Objective scores (0-100) with detailed breakdown
✅ **Issue Classification** - Issues prioritized by severity (critical/major/minor)
✅ **Real Browser** - Uses actual Chromium browser with screenshots
✅ **Performance Metrics** - Tracks page load times, interaction speed
✅ **Mobile Testing** - Tests responsive design across multiple breakpoints
✅ **Randomization** - Different results each run (realistic variability)
✅ **Comprehensive Reports** - Markdown + JSON + screenshots + logs

---

## What Gets Tested

### By Category

**Discoverability & Navigation**
- Can users find what they're looking for?
- How many clicks needed?
- Are menus/navigation intuitive?
- Is search effective?

**Performance**
- How fast do pages load?
- Is interaction responsive?
- Mobile performance?
- No lag or slowness?

**Design & Branding**
- Is it visually appealing?
- Consistent branding?
- Professional appearance?
- Good layout and hierarchy?

**Functionality**
- Do features work correctly?
- No broken buttons/forms?
- All expected features present?
- No errors during use?

**Content Quality**
- Is information clear and accurate?
- Complete vendor details?
- Helpful descriptions?
- Good grammar and spelling?

**Mobile Experience**
- Responsive design?
- Touch-friendly buttons?
- Information accessible on small screens?
- Fast on mobile?

---

## Common Use Cases

### After Launch
Run full test to get baseline score and identify issues to fix before public launch

### After Major Changes
Run specific agents that are affected by your changes to verify improvements

### Regular Monitoring
Schedule weekly/daily tests to catch regressions early

### Before Promotions
Run test before running ads or promotions to ensure site is user-ready

### Vendor Onboarding
Run Sarah (vendor) test to verify vendor signup and dashboard are working smoothly

### Mobile Updates
Run all agents on mobile to verify responsive design is working after updates

---

## Next Steps

1. **Read Documentation**
   - Overview: This README
   - Workflow: `beards_bucks_testing_workflow.md`
   - Setup: `IMPLEMENTATION_GUIDE.md`
   - Config: `antigravity_config.yaml`

2. **Set Up Antigravity** (if not already done)
   - Install Antigravity
   - Configure API credentials
   - Verify Playwright browser installed

3. **Run First Test**
   ```bash
   antigravity run --config antigravity_config.yaml --pattern=single
   ```

4. **Review Results**
   - Check report in `tests/antigravity_results/`
   - Read agent feedback
   - Note critical issues

5. **Plan Fixes**
   - Create tickets for critical/major issues
   - Assign to team
   - Set timeline

6. **Iterate**
   - Fix issues
   - Run tests again
   - Track improvement in score

---

## Customization

### Change Agents
Edit `agent_personas.json` to modify personas, goals, or success criteria

### Adjust Scoring Weights
Edit `antigravity_config.yaml` to make certain dimensions more/less important

### Modify Config
Edit `antigravity_config.yaml` to change:
- Target site URL
- Browser settings (headless, viewport size, etc.)
- Timeout duration
- Report format
- Performance thresholds
- Brand colors to check

### Add New Agent
Add entry to `agent_personas.json`:
```json
{
  "id": "new_agent",
  "name": "Name",
  "role": "Role",
  "goal": "Goal statement",
  "systemPrompt": "You are [name]...",
  "successCriteria": ["Criteria 1", "Criteria 2"]
}
```

---

## Troubleshooting

**Agent Gets Stuck** → Agent is exploring differently than expected. Let it time out or increase timeout in config.

**Low Score** → Normal! Review report for specific issues and fix them.

**Inconsistent Results** → Expected! Agents explore differently. Run 3+ times and average.

**Report Not Generated** → Check `tests/antigravity_results/` directory exists and check logs.

**Performance Issues** → Check server load, run tests at different times, optimize images.

See `IMPLEMENTATION_GUIDE.md` for more troubleshooting tips.

---

## Support

For questions:
- **Workflow Details**: See `beards_bucks_testing_workflow.md`
- **Configuration Help**: See `antigravity_config.yaml` (heavily commented)
- **Setup Instructions**: See `IMPLEMENTATION_GUIDE.md`
- **Agent Definitions**: See `agent_personas.json`

---

## Summary

This system turns Antigravity autonomous agents into comprehensive UX testers that:
- 🎯 Act like real users with real goals
- 📊 Score experience across 6 dimensions
- 🐛 Find and categorize issues
- 📝 Generate actionable reports
- 🔄 Enable continuous improvement

**Ready to use. Start with:** `antigravity run --config antigravity_config.yaml --pattern=single`

---

**Status**: Complete and ready to implement
**Created**: December 10, 2025
**Author**: Claude Code
