# Directory Structure Blueprint

**Purpose**: Automated directory organization based on file patterns
**Updated**: December 8, 2025
**Mode**: Declarative (defines structure, not procedures)

This file works like `CLAUDE.md` - it defines the WHAT, not the HOW. The accompanying script reads this and auto-organizes files.

---

## Root Level (Essential Only)

These files MUST stay in root:

```
✓ .env                      # Environment variables
✓ .env.example              # Template
✓ .gitignore                # Git patterns
✓ .mcp.json                 # MCP config
✓ package.json              # Dependencies
✓ package-lock.json         # Lock file
✓ README.md                 # Project overview
✓ TODO.md                   # Active todo list
✓ DIRECTORY_STRUCTURE.md    # Organization guide
```

**Rule**: Any file not in the allowlist below should be moved to subdirectories.

---

## Automatic Organization Rules

### Documentation Files

**Pattern**: `*.md` files (except root allowlist)

| Pattern | Destination |
|---------|-------------|
| `*SESSION*` or `*SUMMARY*` | `docs/guides/` |
| `*REPORT*` or `*VERIFICATION*` | `docs/reports/` |
| `*INVESTIGATION*` or `*ANALYSIS*` | `docs/reports/` |
| `*GUIDE*` or `ORGANIZATION*` | `docs/guides/` |
| `BRAND_*` or `brand*` | `docs/reference/` |
| `*2025-12-0[5-7]_*` (dated) | `docs/archived-reports/2025-12-XX_*` (by date folder) |
| `audit*` | `docs/guides/` |

### Code Files

**Pattern**: `*.php`, `*.py`, `*.js`

| Pattern | Destination |
|---------|-------------|
| `*mu.php` or `beards-bucks-*.php` | `plugins/` |
| `*test*.js` or `*.test.js` | `tests/` |
| `*script*.py` or `apply*.py` | `docs/reports/` |
| Other PHP in root | `plugins/` |

### Media Files

**Pattern**: `*.png`, `*.jpg`, `*.jpeg`, `*.webp`, `*.gif`

| Pattern | Destination |
|---------|-------------|
| All images | `media/webp-reports/` |

### Log Files

**Pattern**: `*.log`, `*.txt`

| Pattern | Destination |
|---------|-------------|
| `*export*.txt` | `archive/exports/` |
| `*agent*.log` or `*test*.txt` | `archive/exports/` |
| Other logs | `logs/` |

### Configuration Files

**Pattern**: `.env*`, `*.json` (not in root)

| Pattern | Destination |
|---------|-------------|
| `.env*` files | Root (keep) |
| `*.json` (config) | Keep current location or `scripts/` |

### Cleanup Rules

**Delete These Automatically**:
- `*.metadata.json` - Metadata artifacts
- `*.resolved` or `*.resolved.*` - Resolved artifacts
- `task.md.metadata.json` - Task metadata
- Duplicate files detected by filename + size

**Move These to Archive**:
- Files older than 30 days (optional, verify first)
- Old test results
- Historical exports

---

## Folder Structure (Reference)

```
project/
├── .claude/
│   ├── DIRECTORY_BLUEPRINT.md    ← This file
│   └── [other config]
│
├── docs/
│   ├── guides/                   # Active session summaries, audit findings
│   ├── reports/                  # Verification reports, analysis
│   ├── archived-reports/         # Dated historical reports
│   │   ├── 2025-12-05_Initial/
│   │   ├── 2025-12-06_Navigation/
│   │   └── 2025-12-07_CSS_Fixes/
│   ├── archived-tasks/           # Old task.md files
│   └── reference/                # Quick reference docs
│
├── plugins/                      # WordPress must-use plugins
│   ├── beards-bucks-redirects-mu.php
│   ├── beards-bucks-styles-mu.php
│   └── beards-bucks-custom-styles.php
│
├── media/                        # Test media, screenshots
│   └── webp-reports/            # All screenshots/webp files
│
├── archive/                      # Old/archived items
│   ├── exports/                 # Exported conversation logs
│   └── conversations/           # Old conversations
│
├── tests/                        # Test files
├── scripts/                      # Utility scripts
├── logs/                         # Application logs
├── css/                          # CSS references
└── [other working directories]
```

---

## Automation Triggers

**When to run reorganization:**

1. **Scheduled**: Weekly (recommended - once per week)
2. **Manual**: User runs `npm run organize` or equivalent
3. **Git Hook**: Before commit (optional - can be slow)
4. **After Downloads**: When files are added to root

---

## Safe Mode (Recommended)

The automation script should support a **dry-run mode**:

```bash
./organize.sh --dry-run          # Show what WOULD happen
./organize.sh --execute          # Actually move files
./organize.sh --cleanup-only     # Only delete duplicates/metadata
```

---

## Edge Cases

**What to do if uncertain:**

1. **Unknown file type**: Keep in root, flag for review
2. **Matches multiple rules**: Use most specific rule first
3. **Old files (>60 days)**: Ask user before archiving
4. **Large files (>100MB)**: Don't move in automation (manual review)
5. **Files in use**: Skip, don't interrupt active work

---

## Configuration Example (for script)

```yaml
blueprint:
  rules:
    - pattern: "*SESSION*"
      destination: "docs/guides/"
      action: "move"

    - pattern: "*REPORT*"
      destination: "docs/reports/"
      action: "move"

    - pattern: "*.metadata.json"
      destination: null
      action: "delete"

    - pattern: "*mu.php"
      destination: "plugins/"
      action: "move"

    - pattern: "*.png"
      destination: "media/webp-reports/"
      action: "move"
```

---

## Notes for Script Implementation

- **Dry-run first**: Always show what will move before moving
- **Preserve timestamps**: Don't lose file metadata
- **Git aware**: Don't break active git operations
- **Reversible**: Users can run `git checkout` if needed
- **Logging**: Show what was organized, what was skipped, why

---

## Update Frequency

This blueprint rarely changes. Update when:
- ✅ Adding a new major folder category
- ✅ Changing file organization rules
- ✅ Restructuring doc categories

Don't update for:
- Individual file moves (automation handles these)
- One-time reorganizations
- Temporary file placement

---

Generated: December 8, 2025
Last Modified: December 8, 2025
