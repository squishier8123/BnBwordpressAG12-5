# Directory Automation - Quick Start

**TL;DR**: Run one command to automatically organize your project directory based on a simple reusable blueprint.

---

## 30-Second Overview

Instead of manually reorganizing files, you now have:

1. **A Blueprint** (`.claude/DIRECTORY_BLUEPRINT.md`) - Define your organization rules once
2. **A Script** (`scripts/organize-directory.sh`) - Automatically applies the rules
3. **A Git Hook** (optional) - Reminds you to organize before commits
4. **A Guide** (`docs/guides/AUTOMATION_GUIDE.md`) - Full documentation

---

## One-Time Setup (Already Done ✅)

Nothing to do! Everything is installed:
- ✅ Blueprint created and configured
- ✅ Script ready to use
- ✅ Git hook installed
- ✅ Documentation written

---

## Basic Usage

### Preview Changes (Safe)

```bash
bash scripts/organize-directory.sh --dry-run
```

Shows what WOULD be moved, nothing actually happens.

### Actually Organize

```bash
bash scripts/organize-directory.sh --execute
```

Moves files to proper locations according to blueprint rules.

### Just Clean Metadata

```bash
bash scripts/organize-directory.sh --cleanup
```

Deletes `.metadata.json`, `.resolved` files, etc. (doesn't move anything).

---

## Organization Rules (Currently Configured)

| Files | Go To |
|-------|-------|
| `*SESSION*`, `*SUMMARY*` | `docs/guides/` |
| `*REPORT*`, `*VERIFICATION*` | `docs/reports/` |
| `*.png`, `*.webp` | `media/webp-reports/` |
| `*mu.php`, `beards-bucks-*.php` | `plugins/` |
| `*export*.txt`, `*agent*.log` | `archive/exports/` |
| `*.metadata.json`, `*.resolved` | DELETE |

Want different rules? Edit `.claude/DIRECTORY_BLUEPRINT.md`

---

## Git Hook (Optional)

Every commit, you'll see:

```
Running directory auto-organization...
⚠ Note: Files could be auto-organized
To auto-organize: bash scripts/organize-directory.sh --execute
```

This is a **friendly reminder only** - commits always work. You can:
- Ignore it and commit anyway
- Run the script before committing
- Disable it with: `git commit --no-verify`
- Permanently remove: `rm .git/hooks/pre-commit`

---

## Recommended Workflow

### Option A: Manual (Most Control)

```bash
# When root directory gets messy...
bash scripts/organize-directory.sh --dry-run      # See what would move
bash scripts/organize-directory.sh --execute      # Do it
git add -A
git commit -m "refactor: auto-organize files"
```

### Option B: Weekly

```bash
# Every Sunday (or whenever you want)
bash scripts/organize-directory.sh --execute
git add -A
git commit -m "refactor: auto-organize files"
```

### Option C: Let Git Hook Remind You

```bash
# Just commit normally
git commit -m "my changes"
# → Hook reminds you if files need organizing
# → You decide if you want to run it
```

---

## Examples

### Example 1: New Screenshot From Test

```
Script finds: buyer_audit_1765168606565.webp
Moves to: media/webp-reports/
Done automatically!
```

### Example 2: Multiple Reports Generated

```
Script finds:
  - CSS_VERIFICATION_REPORT.md
  - SESSION_SUMMARY_2025_12_08.md
  - FINAL_REPORT.md

Moves to:
  - docs/reports/CSS_VERIFICATION_REPORT.md
  - docs/guides/SESSION_SUMMARY_2025_12_08.md
  - docs/reports/FINAL_REPORT.md

All automatically sorted!
```

### Example 3: Metadata Cleanup

```
Script finds and deletes:
  - task.md.metadata.json
  - audit_report.md.resolved
  - *.metadata.json files

Done!
```

---

## Important: All Files Stay in Git

The script only **moves files** - nothing is lost. You can always:

```bash
# Undo all moves
git checkout .

# See what moved
git diff --name-status
```

---

## Customizing Rules

Edit: `.claude/DIRECTORY_BLUEPRINT.md`

Example: Add a new rule for backup files:

```markdown
| Pattern | Destination |
|---------|-------------|
| `backup-*.sql` | `archive/backups/` |
```

Save the file. Next time you run the script, it will use the new rule!

---

## Files You Need to Know

| File | Purpose | Edit? |
|------|---------|-------|
| `.claude/DIRECTORY_BLUEPRINT.md` | Organization rules | ✅ Yes - edit to customize |
| `scripts/organize-directory.sh` | The automation script | ❌ No - reads blueprint |
| `docs/guides/AUTOMATION_GUIDE.md` | Full documentation | ❌ Reference only |
| `.git/hooks/pre-commit` | Git hook (optional) | ❌ Can delete if you want |

---

## Troubleshooting

### "Command not found"

```bash
# Make sure you're in project root
cd /path/to/Newbeards&Bucks12-5

# Then run the script
bash scripts/organize-directory.sh --dry-run
```

### Script says "Permission denied"

```bash
chmod +x scripts/organize-directory.sh
```

### Git hook is annoying

```bash
# Disable for one commit
git commit --no-verify

# Or delete the hook permanently
rm .git/hooks/pre-commit
```

### Need full documentation?

Read: `docs/guides/AUTOMATION_GUIDE.md`

---

## Summary

- ✅ Blueprint configured (`.claude/DIRECTORY_BLUEPRINT.md`)
- ✅ Script ready (`scripts/organize-directory.sh`)
- ✅ Git hook installed (optional, non-blocking)
- ✅ All rules documented

**You're all set!** Just run:

```bash
bash scripts/organize-directory.sh --execute
```

Whenever your root directory gets messy. The blueprint will handle the rest automatically.

---

Last Updated: December 8, 2025
