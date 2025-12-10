# Antigravity Testing - Quick Start Guide

## 30-Second Overview

You have a complete autonomous testing system that uses 5 AI agents to test your site like real users would. Each agent has a goal, navigates your site independently, and scores their experience.

---

## Files You Have

```
antigravity/
├── README.md                          ← Start here (overview)
├── QUICK_START.md                     ← This file
├── IMPLEMENTATION_GUIDE.md            ← Detailed setup instructions
├── beards_bucks_testing_workflow.md   ← How it works (10 steps)
├── agent_personas.json                ← 5 agents: Jake, Sarah, Mike, Emma, Tom
└── antigravity_config.yaml            ← Full configuration
```

---

## The 5 Agents (Personas)

| Agent | Goal | Type |
|-------|------|------|
| **Jake** | Find and book an outfitter | Hunter |
| **Sarah** | List used gear for sale | Vendor |
| **Mike** | Find cheap used gear | Shopper |
| **Emma** | Research hunting in Illinois | Info Seeker |
| **Tom** | Manage outfitter business | Business Owner |

Each agent automatically navigates your site, explores features, and scores their experience from 0-100.

---

## How to Run Tests

### Option 1: Quick Test (1 Agent, 15 min)
```bash
antigravity run --config antigravity/antigravity_config.yaml --pattern=single
```

### Option 2: Full Test (5 Agents, 90 min)
```bash
antigravity run --config antigravity/antigravity_config.yaml --pattern=full
```

### Option 3: Specific Agents
```bash
antigravity run --config antigravity/antigravity_config.yaml --agents=jake_hunter,sarah_vendor
```

---

## Understanding Results

### Score Interpretation

```
90-100: ⭐⭐⭐⭐⭐ Excellent - Launch ready
80-89:  ⭐⭐⭐⭐ Good - Minor fixes needed
70-79:  ⭐⭐⭐ Acceptable - Several fixes needed
60-69:  ⭐⭐ Fair - Major work needed
<60:    ⭐ Poor - Not ready
```

### Example: Agent Scores 81/100

```
Discoverability:  16/20 (Good)    → Easy to find things
Performance:      18/20 (Good)    → Pages load fast
Design:           12/15 (Good)    → Looks professional
Functionality:    14/20 (Fair)    → Some features broken
Content:          13/15 (Good)    → Clear and accurate
Mobile:            8/10 (Fair)    → Works on phones but issues
```

### Report Output

Tests generate a report with:
- Individual agent scores
- Critical issues that block goals
- Major issues that hurt UX
- Minor issues (polish)
- What the site does well
- Specific recommendations to fix issues

---

## What Gets Scored

### 6 Dimensions (0-100 total)

1. **Discoverability & Navigation** (0-20 pts)
   - Can users find what they need?
   - How intuitive is the site?

2. **Performance** (0-20 pts)
   - How fast do pages load?
   - Is the site responsive?

3. **Design & Branding** (0-15 pts)
   - Does it look professional?
   - Is branding consistent?

4. **Functionality** (0-20 pts)
   - Do features work correctly?
   - Are there broken buttons/forms?

5. **Content Quality** (0-15 pts)
   - Is information clear and accurate?
   - Is content complete?

6. **Mobile Experience** (0-10 pts)
   - Does it work well on phones?
   - Is it touch-friendly?

---

## Typical Workflow

```
1. Run test (15-90 minutes)
   antigravity run --config antigravity/antigravity_config.yaml --pattern=full

2. Review report
   open tests/antigravity_results/antigravity_test_report_*.md

3. Identify issues
   • Critical: Blocks user goals (fix immediately)
   • Major: Hurts UX (fix this week)
   • Minor: Inconvenient (fix soon)

4. Fix issues
   • Update site
   • Deploy changes

5. Run test again
   antigravity run --config antigravity/antigravity_config.yaml --pattern=single

6. Verify improvements
   • Check if score went up
   • Verify critical issues fixed
   • Plan next fixes
```

---

## What's Being Tested

### User Goals
- **Jake**: Find outfitter → Read reviews → Book
- **Sarah**: Register as vendor → List product → Manage store
- **Mike**: Browse gear → Filter by price → Buy
- **Emma**: Explore content → Read vendor info → Evaluate trust
- **Tom**: Access dashboard → Manage listings → View analytics

### Experience Aspects
- Navigation clarity and intuitiveness
- Page load speed and responsiveness
- Visual design and brand consistency
- Feature functionality and reliability
- Content accuracy and completeness
- Mobile responsiveness and usability

---

## Key Configuration

Edit `antigravity_config.yaml` to customize:

```yaml
site:
  domain: "https://beardsandbucks.com"  # What site to test

agents:
  execution:
    timeout: 900  # seconds (15 min per agent)

browser:
  headless: false  # Show browser, set true for CI/CD

reporting:
  outputDir: "tests/antigravity_results"  # Where reports go
```

---

## Common Scenarios

### Scenario 1: First Time Testing
1. Run: `antigravity run --config antigravity/antigravity_config.yaml --pattern=single`
2. Review report to understand current state
3. Plan fixes based on critical/major issues
4. Implement fixes
5. Re-run test to verify

### Scenario 2: After Major Changes
1. Run specific agents affected by changes
2. Compare new scores to previous run
3. Verify improvements in target areas

### Scenario 3: Daily Automated Testing
1. Schedule test to run daily
2. Monitor for score drops
3. Alert team if critical issues found

### Scenario 4: Testing New Feature
1. Run all agents
2. Check if new feature improves scores
3. Verify no regressions in other areas

---

## Interpreting the Report

### Section: Executive Summary
- **Overall Score**: 77/100
- **Assessment**: "Acceptable - Several improvements needed"
- **Recommendation**: Fix the issues listed

### Section: Individual Agent Results
Each agent shows:
- Their score (e.g., Jake: 81/100)
- Breakdown by dimension (Discoverability, Performance, etc.)
- Issues they encountered

### Section: Critical Issues
These **block user goals**. Fix first.
```
🔴 CRITICAL: Vendor Dashboard link missing
   Impact: Vendors cannot access business tools
   Fix: Add "Vendor Dashboard" to main menu
   Effort: Low (1 hour)
```

### Section: Major Issues
These **hurt UX significantly**. Fix soon.
```
🟠 MAJOR: County search doesn't work
   Impact: Hunters can't find outfitters by location
   Fix: Debug search filter logic
   Effort: Medium (2-3 hours)
```

### Section: Recommendations
Prioritized action items:
```
IMMEDIATE (This Week):
  1. Fix critical issues
  2. Verify mobile responsive

HIGH PRIORITY (This Month):
  1. Fix major issues
  2. Optimize performance
```

---

## Customization Quick Tips

### Add Custom Agent
Edit `agent_personas.json`:
```json
{
  "id": "custom_agent",
  "name": "Custom",
  "goal": "Your custom goal",
  "systemPrompt": "You are... [your instructions]"
}
```

### Adjust What Matters
Edit `antigravity_config.yaml`:
```yaml
scoring:
  dimensions:
    performance:
      weight: 1.5  # Make performance matter more
    design:
      weight: 0.8  # Make design matter less
```

### Test Different Site
Edit `antigravity_config.yaml`:
```yaml
site:
  domain: "https://staging.beardsandbucks.com"  # Test staging instead
```

---

## Troubleshooting

| Problem | Solution |
|---------|----------|
| Agent stuck | Let timeout expire, review logs |
| Low score | Normal! Read report and fix issues |
| No report | Check `tests/antigravity_results/` exists |
| Slow performance | Check server load, optimize images |
| Different score each time | Normal! Agents explore differently |

---

## Full Documentation

- **README.md** - Complete overview
- **IMPLEMENTATION_GUIDE.md** - Detailed setup and running
- **beards_bucks_testing_workflow.md** - How it all works (10 steps)
- **antigravity_config.yaml** - All configuration options (heavily commented)
- **agent_personas.json** - Agent definitions

---

## TL;DR

```bash
# 1. Run test
antigravity run --config antigravity/antigravity_config.yaml --pattern=single

# 2. Review report
open tests/antigravity_results/antigravity_test_report_*.md

# 3. Fix issues from report

# 4. Run again and verify improvements
antigravity run --config antigravity/antigravity_config.yaml --pattern=single
```

That's it! You now have autonomous agents testing your site and scoring the user experience.

---

**Next**: Run your first test and check the results report!
