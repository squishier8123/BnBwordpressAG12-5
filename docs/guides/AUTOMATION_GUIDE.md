# Directory Automation Guide

**Purpose**: Keep your directory automatically organized without manual intervention
**Updated**: December 8, 2025
**Status**: Ready to use

---

## Overview

Instead of manually reorganizing files every time they accumulate, the system now automatically:

1. ✅ **Reads** the organization blueprint (`.claude/DIRECTORY_BLUEPRINT.md`)
2. ✅ **Moves** files to proper locations automatically
3. ✅ **Cleans** up metadata and duplicate files
4. ✅ **Warns** you before committing (non-blocking)

All based on a simple, unchanging ruleset that you define once.

---

## Quick Start

### Option 1: Manual Reorganization (Recommended for Control)

Run anytime you want to organize:

```bash
# Preview what would happen (safe, no changes)
bash scripts/organize-directory.sh --dry-run

# Actually organize files
bash scripts/organize-directory.sh --execute

# Only delete metadata, don't move files
bash scripts/organize-directory.sh --cleanup
```

### Option 2: Automatic on Commit (Optional)

Every time you commit, git will check if files need organizing and suggest it:

```bash
git commit -m "my changes"
# → Git hook runs and suggests: "Run scripts/organize-directory.sh --execute"
```

**Note**: The hook is non-blocking - commits always succeed, you just get a suggestion.

### Option 3: Scheduled (Advanced)

Add to crontab to organize automatically every week:

```bash
# Edit crontab
crontab -e

# Add this line (organize every Sunday at 2 AM)
0 2 * * 0 cd /path/to/project && bash scripts/organize-directory.sh --execute
```

---

## How It Works

### The Blueprint

**File**: `.claude/DIRECTORY_BLUEPRINT.md`

This is like `CLAUDE.md` - it's a living document that defines HOW you want files organized. Example rules:

```
Pattern: *SESSION*
Destination: docs/guides/

Pattern: *REPORT*
Destination: docs/reports/

Pattern: *.png
Destination: media/webp-reports/
```

### The Script

**File**: `scripts/organize-directory.sh`

This script reads the blueprint and applies the rules automatically:

```bash
# Phase 1: Delete metadata (.metadata.json, .resolved, etc)
# Phase 2: Move markdown files to docs/guides or docs/reports
# Phase 3: Move PHP files to plugins/
# Phase 4: Move images to media/
# Phase 5: Move logs to archive/
# Phase 6: Move scripts to docs/reports/
```

### The Git Hook

**File**: `.git/hooks/pre-commit`

Optional - runs before every commit to remind you to organize. Non-blocking.

---

## File Organization Rules

These rules are currently defined in `DIRECTORY_BLUEPRINT.md`:

### Documentation

| Pattern | Goes To |
|---------|---------|
| `*SESSION*`, `*SUMMARY*` | `docs/guides/` |
| `*REPORT*`, `*VERIFICATION*` | `docs/reports/` |
| `*INVESTIGATION*`, `*ANALYSIS*` | `docs/reports/` |
| `audit*`, `*GUIDE*` | `docs/guides/` |
| `BRAND_*` | `docs/reference/` |
| Dated files (2025-12-0X) | `docs/archived-reports/2025-12-XX/` |

### Code

| Pattern | Goes To |
|---------|---------|
| `*mu.php`, `beards-bucks-*.php` | `plugins/` |
| `*.test.js`, `*test*.js` | `tests/` |
| `apply*.py`, `*fix*.py` | `docs/reports/` |

### Media

| Pattern | Goes To |
|---------|---------|
| `*.png`, `*.jpg`, `*.webp` | `media/webp-reports/` |

### Logs & Archives

| Pattern | Goes To |
|---------|---------|
| `*export*.txt`, `*agent*.log` | `archive/exports/` |

### Cleanup

| Pattern | Action |
|---------|--------|
| `*.metadata.json` | Delete |
| `*.resolved`, `*.resolved.*` | Delete |
| `task.md.metadata.json` | Delete |

---

## Examples

### Example 1: Adding a New Test Report

1. Playwright finishes and creates `buyer_audit_1765168606565.webp` in root
2. You run: `bash scripts/organize-directory.sh --execute`
3. Script sees the `.webp` file and moves it to `media/webp-reports/`
4. Done - no manual work

### Example 2: Multiple Markdown Files

You generate a bunch of reports:
- `FINAL_REPORT.md`
- `SESSION_SUMMARY_2025_12_08.md`
- `CSS_VERIFICATION_REPORT.md`

Run:
```bash
bash scripts/organize-directory.sh --dry-run
```

Output:
```
ℹ Phase 2: Organizing documentation files...
ℹ [DRY-RUN] Would move: CSS_VERIFICATION_REPORT.md → docs/reports/
ℹ [DRY-RUN] Would move: SESSION_SUMMARY_2025_12_08.md → docs/guides/
ℹ [DRY-RUN] Would move: FINAL_REPORT.md → docs/reports/
```

Then run:
```bash
bash scripts/organize-directory.sh --execute
```

All three are moved to the right places.

### Example 3: Cleanup Metadata

You see some leftover metadata files:
- `task.md.metadata.json`
- `task.md.resolved`
- `audit_report.md.metadata.json`

Run:
```bash
bash scripts/organize-directory.sh --cleanup
```

All metadata artifacts are deleted.

---

## Customizing Rules

### To Add a New Rule

1. Edit `.claude/DIRECTORY_BLUEPRINT.md`
2. Add a new entry under the appropriate section:

```markdown
### My Custom Files

| Pattern | Destination |
|---------|-------------|
| `backup-*.sql` | `archive/backups/` |
| `*.dump` | `archive/backups/` |
```

3. The script will automatically pick up the new rules next time it runs

### To Change Destinations

1. Edit `.claude/DIRECTORY_BLUEPRINT.md`
2. Change the `Destination` column
3. Next run will move files to the new location

### To Add New File Types

Example: You want to organize JSON files:

```markdown
### Configuration Files

| Pattern | Destination |
|---------|-------------|
| `config-*.json` | `configs/` |
| `*.config.json` | `configs/` |
```

---

## Safe Practices

### 1. Always Use --dry-run First

```bash
# See what WOULD happen
bash scripts/organize-directory.sh --dry-run

# Then actually do it
bash scripts/organize-directory.sh --execute
```

### 2. Git Protects You

If something goes wrong, you can undo:

```bash
git checkout .    # Restore all files to committed state
```

### 3. Disable Hook If Needed

If the git hook is annoying:

```bash
# Commit without running hook
git commit --no-verify

# Or disable it entirely
rm .git/hooks/pre-commit
```

### 4. Large Files Are Skipped

Files >100MB are skipped by default. Move them manually or edit the script.

---

## Troubleshooting

### "Script not found" error

Make sure you're in the project root:
```bash
cd /path/to/Newbeards&Bucks12-5
bash scripts/organize-directory.sh --dry-run
```

### Script says "Permission denied"

Make the script executable:
```bash
chmod +x scripts/organize-directory.sh
```

### Files aren't moving

Check the dry-run output:
```bash
bash scripts/organize-directory.sh --dry-run
```

See if files are being skipped and why. Common reasons:
- File is already in the right location
- File matches multiple patterns (most specific one wins)
- File is in use (actively open/locked)

### Git hook is bothering me

You have three options:

**Option 1**: Ignore it (it's non-blocking, commits still work)

**Option 2**: Disable for one commit
```bash
git commit --no-verify
```

**Option 3**: Disable permanently
```bash
rm .git/hooks/pre-commit
```

### Want to move files manually?

You still can. The automation is purely optional:

```bash
# Do everything manually
mv my-report.md docs/reports/
mv my-screenshot.png media/webp-reports/

# Then commit normally
git add .
git commit -m "organize files"
```

---

## When to Update the Blueprint

**Update the blueprint when:**
- ✅ You're adding a new major folder category
- ✅ You want to change where certain files go
- ✅ You identify a new pattern that needs organizing

**Don't update for:**
- Individual file moves (automation handles these)
- One-time reorganizations
- Temporary file placement

---

## Integration with Your Workflow

### Recommended Weekly Routine

```bash
# Once a week, organize accumulated files
bash scripts/organize-directory.sh --dry-run     # See what's there
bash scripts/organize-directory.sh --execute     # Clean it up
git add -A
git commit -m "refactor: auto-organize directory"
```

### Alternative: On-Demand

Only run when you notice files accumulating in root:

```bash
# When root gets messy...
bash scripts/organize-directory.sh --execute
git add -A
git commit -m "refactor: organize files"
```

### No Action Needed

If you prefer manual organization, just ignore the automation:
- Don't run the script
- Ignore the git hook message
- Organize manually as needed

The automation is entirely optional.

---

## Files Involved

**You should know about these files:**

- `.claude/DIRECTORY_BLUEPRINT.md` - **Read this to understand rules**
- `scripts/organize-directory.sh` - **Run this to organize**
- `.git/hooks/pre-commit` - **Optional git integration**
- `DIRECTORY_STRUCTURE.md` - **Reference of actual structure**

**You don't need to edit:**
- `scripts/organize-directory.sh` - It reads the blueprint automatically
- `.git/hooks/pre-commit` - It just warns you, no configuration needed

---

## Summary

**3 ways to stay organized:**

1. **Manual**: `bash scripts/organize-directory.sh --execute` whenever you want
2. **On Commit**: Git hook suggests organization before each commit
3. **Scheduled**: Crontab runs it automatically every week

All based on one simple blueprint (`.claude/DIRECTORY_BLUEPRINT.md`) that you update once and forget about.

---

Generated: December 8, 2025
