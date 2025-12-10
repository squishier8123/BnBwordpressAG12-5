# Antigravity Workflow: Beards & Bucks Site Testing
**Automated UX Testing with Intelligent Agents**

## Overview
This Antigravity workflow runs autonomous agents as simulated users, each with distinct personas and goals. Agents navigate the Beards & Bucks site using browser interaction, score their experience, and generate a comprehensive report.

## Workflow Steps

### Step 1: Initialize Test Session
```
Action: Setup
- Load agent_personas.json configuration
- Initialize test environment
- Set site target: https://beardsandbucks.com
- Enable browser automation with Playwright
- Create test session ID and timestamp
```

**Input Variables:**
- `siteDomain`: https://beardsandbucks.com
- `testMode`: "interactive" (agents use real browser)
- `headless`: false (capture visual issues)

---

### Step 2: Randomize Agent Selection
```
Action: SelectRandomAgent
- Get list of 5 agents from configuration
- Randomly select one agent
- Load agent persona, goals, and system prompt
- Initialize scoring context
```

**Randomization Logic:**
```
agents = ["jake_hunter", "sarah_vendor", "mike_shopper", "emma_researcher", "tom_outfitter"]
selectedAgent = random.choice(agents)
```

**Output:**
- `selectedAgentId`: string (e.g., "jake_hunter")
- `selectedAgentName`: string (e.g., "Jake")
- `selectedAgentRole`: string (e.g., "Hunter Seeking Outfitter")
- `systemPrompt`: full agent system prompt

---

### Step 3: Launch Agent Browser Session
```
Action: LaunchBrowser
- Start Playwright browser instance (Chromium)
- Navigate to agent's entry point
- Load scoring evaluation context
- Begin recording interaction metrics
```

**Metrics Tracked:**
- Page load times
- Click interactions
- Form submissions
- Error messages encountered
- Mobile responsiveness (test at multiple breakpoints)
- Visual consistency (check brand colors)

---

### Step 4: Agent Autonomous Navigation Loop
```
Action: RunAgentLoop (Runs until agent reaches goal or timeout)

Loop:
  1. Agent views current page (screenshot + accessibility tree)
  2. Claude (via Antigravity) decides next action based on:
     - Current goal
     - Page content
     - Previous interactions
     - Success criteria
  3. Execute action (click, scroll, type, etc.)
  4. Record metrics and observations
  5. Evaluate against scoring rubric
  6. Continue until goal complete or timeout reached

Timeout: 15 minutes per agent
```

**Agent Decision Factors:**
- Current location on site
- Goal progress (e.g., "find outfitter" → found → "read reviews" → reading)
- Obstacles encountered (e.g., broken links, missing features)
- Alternative paths if primary path blocked

**Scoring During Navigation:**
As agent navigates, continuously evaluate:
- Discoverability (Can they find what they need? How many clicks?)
- Performance (Load times, responsiveness)
- Design (Visual appeal, brand consistency, layout clarity)
- Functionality (Features work as expected?)
- Content (Is information clear and accurate?)
- Mobile (Responsive and touch-friendly?)

---

### Step 5: Collect Agent Observations
```
Action: CollectObservations
- Compile issues encountered
- Document frustrations and pain points
- List what worked well
- Capture screenshots of key pages
- Record timing data
```

**Issue Categories:**
1. **Critical Issues** (Block user goal)
   - Feature completely broken
   - Navigation impossible
   - Required information missing

2. **Major Issues** (Significantly hurt UX)
   - Feature partially broken
   - Confusing navigation
   - Slow performance
   - Missing important content

3. **Minor Issues** (Inconvenient)
   - Typos or grammar
   - Visual inconsistencies
   - Suboptimal layout
   - Missing polish

---

### Step 6: Score Agent Experience
```
Action: ScoreExperience
- Rate across 6 dimensions (0-100 total)
- Generate per-agent report
- Document score justification
```

**Scoring Calculation:**
```
Score =
  Discoverability (0-20) +
  Performance (0-20) +
  Design (0-15) +
  Functionality (0-20) +
  Content (0-15) +
  Mobile (0-10)
= Total (0-100)
```

**Example Scoring Output:**
```json
{
  "agentId": "jake_hunter",
  "agentName": "Jake",
  "scores": {
    "discoverability": 16,
    "performance": 18,
    "design": 12,
    "functionality": 14,
    "content": 13,
    "mobile": 8,
    "total": 81
  },
  "interpretation": "Good - Minor improvements needed",
  "issuesFound": [
    {
      "severity": "critical",
      "description": "County search feature not working properly",
      "impact": "Cannot find outfitters by location"
    },
    {
      "severity": "major",
      "description": "Booking form missing availability calendar",
      "impact": "Hard to check outfitter availability"
    }
  ],
  "strengths": [
    "Clear vendor profiles with detailed information",
    "Professional design and branding",
    "Responsive mobile experience"
  ],
  "completionTime": "12 minutes",
  "goalStatus": "Partially Complete"
}
```

---

### Step 7: Option - Run Additional Agents (Loop)
```
Action: QueryRunMore
- Ask if workflow should run next agent
- If YES: Return to Step 2 (randomize next agent)
- If NO: Proceed to Step 8
```

**Usage:**
- Run single agent for quick check
- Run all 5 agents for comprehensive assessment
- Run agents multiple times for consistency validation

---

### Step 8: Aggregate Results
```
Action: AggregateScores
- Combine all agent scores
- Calculate site average score
- Identify pattern issues (problems multiple agents found)
- Rank issues by severity and frequency
```

**Aggregation Output:**
```json
{
  "testSessionId": "test_20250101_001",
  "timestamp": "2025-01-01T14:30:00Z",
  "siteUrl": "https://beardsandbucks.com",
  "agentsRun": [
    {
      "name": "Jake",
      "score": 81,
      "timeMinutes": 12
    },
    {
      "name": "Sarah",
      "score": 72,
      "timeMinutes": 14
    },
    {
      "name": "Mike",
      "score": 78,
      "timeMinutes": 10
    }
  ],
  "siteAverageScore": 77,
  "scoreInterpretation": "Acceptable - Several improvements needed"
}
```

---

### Step 9: Generate Final Report
```
Action: GenerateReport
- Create comprehensive test report
- Include all agent findings
- Prioritize recommendations
- Suggest fixes and improvements
```

**Report Structure:**
```
ANTIGRAVITY TEST REPORT
═════════════════════════════════════════════

EXECUTIVE SUMMARY
─────────────────
Test Date: [Date]
Site: https://beardsandbucks.com
Agents Run: 5 (Jake, Sarah, Mike, Emma, Tom)
Overall Score: [X]/100
Assessment: [Excellent/Good/Acceptable/Fair/Poor]

INDIVIDUAL AGENT RESULTS
─────────────────────────
[Detailed scores and findings for each agent]

CRITICAL ISSUES (Must Fix)
──────────────────────────
1. Issue #1 - [Description] - [Impact]
2. Issue #2 - [Description] - [Impact]

MAJOR ISSUES (High Priority)
──────────────────────────────
1. Issue #1 - [Description]
2. Issue #2 - [Description]

MINOR ISSUES (Low Priority)
────────────────────────────
1. Issue #1
2. Issue #2

STRENGTHS
─────────
- Strength #1
- Strength #2
- Strength #3

RECOMMENDATIONS
────────────────
Priority 1 (Immediate):
  - Fix [critical issue]
  - Fix [critical issue]

Priority 2 (High):
  - Fix [major issue]
  - Improve [feature]

Priority 3 (Medium):
  - Polish [UI element]
  - Enhance [functionality]

NEXT STEPS
──────────
1. Schedule fix implementation
2. Re-run tests after fixes
3. Track improvements to score
4. Schedule next full test cycle

═════════════════════════════════════════════
```

---

### Step 10: Save Results
```
Action: SaveResults
- Store report as markdown file
- Store JSON data for dashboarding
- Save agent interaction logs
- Archive test artifacts (screenshots, etc.)
```

**Output Files:**
- `antigravity_test_report_[timestamp].md` - Human-readable report
- `antigravity_test_data_[timestamp].json` - Machine-readable data
- `antigravity_test_logs_[timestamp].txt` - Detailed interaction logs
- `antigravity_screenshots_[timestamp]/` - Directory with screenshots

**Storage Location:**
- Reports: `/tests/antigravity_results/`
- Data: `/tests/antigravity_data/`

---

## Workflow Execution Patterns

### Pattern 1: Single Agent Quick Check
**Purpose**: Fast feedback on specific user journey
```
1. Initialize
2. Select specific agent (not random)
3. Run agent loop
4. Score
5. Generate simple report
Time: ~15-20 minutes
```

### Pattern 2: Full Site Assessment
**Purpose**: Comprehensive testing of all user types
```
1. Initialize
2. Loop 5x:
   - Randomize agent selection
   - Run agent
   - Score
   - Collect observations
3. Aggregate all results
4. Generate comprehensive report
Time: ~90 minutes
```

### Pattern 3: Regression Testing
**Purpose**: Verify fixes after changes
```
1. Run specific agents affected by changes
2. Compare new scores to baseline
3. Verify critical issues resolved
4. Generate change impact report
Time: ~30-45 minutes
```

### Pattern 4: Continuous Monitoring
**Purpose**: Regular automated checks
```
1. Run on schedule (e.g., daily)
2. Randomize agent selection each run
3. Track score trends over time
4. Alert on significant drops
Time: ~15 minutes per run
```

---

## Configuration Variables

**In agent_personas.json:**
- Agent system prompts (customize per persona)
- Scoring rubric weights (adjust importance)
- Success criteria (define what "passing" means)
- Timeout duration (max time per agent)

**In workflow:**
- `siteDomain`: Target site URL
- `headless`: Browser mode (true for CI/CD, false for dev)
- `randomizeAgents`: Enable/disable random selection
- `screenshotEnabled`: Capture interaction screenshots
- `performanceTracking`: Enable detailed performance metrics

---

## Integration with Antigravity

**Required Capabilities:**
- Autonomous agent with browser control
- Vision/Screenshot capability (to see current page state)
- Accessibility tree parsing (to understand page structure)
- Decision-making based on goals and context
- Timing and metric collection
- Result aggregation and reporting

**Antigravity Features Used:**
- Multi-agent orchestration
- Browser automation (Playwright integration)
- Vision-based navigation
- Natural language decision-making
- Result aggregation
- Report generation

---

## Example Antigravity Integration

```
// Pseudo-code showing how Antigravity executes this workflow

workflow BeardsBucksTestingWorkflow {

  // Step 1: Initialize
  initialize() {
    loadConfig("agent_personas.json")
    setupBrowser("https://beardsandbucks.com")
  }

  // Step 2-7: Run agents
  for (let i = 0; i < 5; i++) {
    agent = selectRandomAgent()

    with agent("browser", "vision", "decision-making") {
      // Agent autonomously navigates site
      // Uses vision to see pages
      // Uses decision-making to choose actions
      // Evaluates against scoring rubric

      score = collectAndScoreExperience()
      observations = compileObservations()
    }
  }

  // Step 8-10: Report
  aggregateResults()
  generateReport()
  saveResults()
}
```

---

## Success Criteria

Test execution is successful when:
- All agents run to completion (or timeout naturally)
- All scores are calculated and justified
- All issues documented with severity levels
- Report is generated and saved
- Data is stored for historical comparison
- Results are actionable (clear fix priorities)

---

## Next Steps

1. **Configure Antigravity** with this workflow
2. **Customize agent personas** based on your site's actual user types
3. **Adjust scoring rubric** weights based on business priorities
4. **Run initial test** to establish baseline score
5. **Review findings** and prioritize fixes
6. **Implement fixes** and re-run tests to validate improvements
7. **Schedule regular testing** (daily, weekly, or monthly)

---

**Status**: Workflow ready for Antigravity implementation
**Last Updated**: December 10, 2025
