# Project Directory Structure - Optimized Organization

**Last Updated**: December 8, 2025
**Status**: Fully Organized and Optimized

---

## Overview

The Beards & Bucks project directory has been comprehensively reorganized for maximum efficiency, clarity, and maintainability.

### Key Metrics
- **Total Size**: ~55 MB
- **Files Organized**: 68+ files moved/consolidated
- **Duplicates Removed**: 4 duplicate audit reports + metadata
- **Root Level Files**: Reduced to 8 essential files only

---

## Root Directory (Essential Only)

Essential configuration and metadata files only:

```
.env                    # Local environment variables (NOT in git)
.env.example            # Template for environment setup
.gitignore              # Git ignore patterns
.mcp.json               # MCP server configuration
package.json            # Node.js dependencies
package-lock.json       # Dependency lock file
README.md               # Project overview
TODO.md                 # Main project todo list
```

---

## Directory Structure

### `/docs/` - Documentation (508 KB)
Comprehensive project documentation organized by type:

```
docs/
├── guides/                          # Session summaries & planning docs
│   ├── ORGANIZATION_GUIDE.md
│   ├── SESSION_SUMMARY_2025_12_07.md
│   ├── SESSION_SUMMARY_2025_12_07_CSS_FIXES.md
│   └── audit_report.md              # Final audit findings
├── reports/                         # Verification & analysis reports
│   ├── ANTIGRAVITY_CSS_VERIFICATION.md
│   ├── CLEANUP_COMPLETE_2025_12_07.md
│   ├── CSS_FIXES_VERIFICATION_COMPLETE_2025_12_07.md
│   ├── HOME_3_INVESTIGATION_REPORT_2025_12_07.md
│   ├── css-contrast-fixes.css       # CSS utilities
│   ├── css-contrast-readability-report.md
│   └── apply_css_fixes.py           # CSS application script
├── archived-reports/                # Old dated session reports
│   ├── 2025-12-05_Initial/
│   ├── 2025-12-06_Navigation/
│   ├── 2025-12-07_CSS_Fixes/
│   └── 2025-12-07_Listeo/
├── archived-tasks/                  # Old task management
│   └── task.md
└── reference/                       # Quick reference docs
    ├── PAGE_MAPPING_QUICK_REFERENCE.md
    ├── PAGE_STRUCTURE_VISUAL_MAP.md
    ├── CURRENT_PAGE_STRUCTURE_REPORT.md
    ├── homepage_analysis.md
    └── county-page-elementor.json   # Template reference
```

### `/plugins/` - WordPress Plugins (28 KB)
Must-use WordPress plugins (deploy to `/wp-content/mu-plugins/`):

```
plugins/
├── beards-bucks-redirects-mu.php    # URL redirect fix for broken pages
├── beards-bucks-styles-mu.php       # Brand CSS injection
└── beards-bucks-custom-styles.php   # Additional custom styling
```

**Deployment Note**: These files are copied to Hostinger at:
- `wp-content/mu-plugins/` for auto-loading

### `/media/` - Test Media (25 MB)
Screenshots and audit test reports:

```
media/
└── webp-reports/                    # All test screenshots & reports
    ├── buyer_*.png                  # Buyer persona audit screenshots
    ├── hunter_*.png                 # Hunter persona screenshots
    ├── seller_*.png                 # Seller persona screenshots
    ├── vendor_*.png                 # Vendor dashboard screenshots
    └── *_audit_*.webp               # Agent audit reports (webp format)
```

**Purpose**: Documentation of testing, not needed for production

### `/archive/` - Archived Files (208 KB)

```
archive/
├── exports/                         # Exported conversation logs
│   ├── 2025-12-07-*.txt
│   ├── 2025-12-08-*.txt
│   └── *_agent_log.txt              # Playwright agent test logs
└── conversations/                   # Old conversation archives
```

### `/brand-assets/` - Branding (14 MB)
Logo files and brand resources:

```
brand-assets/
├── beards-and-bucks-logo.png
├── beards-and-bucks-logo-icon.png
└── [Additional brand assets]
```

### Other Project Directories

```
/tests/                             # Playwright end-to-end tests
/test-results/                      # Test execution reports
/scripts/                           # Utility scripts for deployment
/qa/                                # QA test files
/logs/                              # Application logs
/css/                               # Local CSS references
/mcp-server-wordpress/              # MCP WordPress integration
/node_modules/                      # Dependencies (not in git)
/.claude/                           # Claude Code configuration
/.git/                              # Git repository
```

### To Deprecate/Clean (Optional Future Work)

These folders could be removed or archived in a future cleanup:

- `/04_ANTIGRAVITY_EXECUTION/` (28 KB) - Old execution logs
- `/test-results/` (1.6 MB) - Historical test reports
- `/logs/` (256 KB) - Old application logs
- Duplicate brand assets in `/brand-assets/`

---

## File Organization Principles

### 1. **Root Level Only**
- Configuration files (`.env`, `.gitignore`, package files)
- Main project README
- Active TODO list
- NOTHING else

### 2. **Documentation**
- Session summaries → `/docs/guides/`
- Verification reports → `/docs/reports/`
- Historical reports → `/docs/archived-reports/`
- Reference docs → `/docs/reference/`

### 3. **Code Assets**
- WordPress plugins → `/plugins/`
- Test files → `/tests/`
- Utility scripts → `/scripts/`

### 4. **Test/Media Files**
- Screenshots → `/media/webp-reports/`
- Test logs → `/archive/exports/`

### 5. **Archive**
- Old exports/logs → `/archive/exports/`
- Historical conversations → `/archive/conversations/`

---

## Usage Quick Reference

### Finding Files

| What you need | Location |
|---|---|
| Brand colors/CSS | `/plugins/beards-bucks-styles-mu.php` or `/docs/reports/css-contrast-*.css` |
| Current status | `/docs/guides/audit_report.md` or `/TODO.md` |
| Historical reports | `/docs/archived-reports/` |
| Test screenshots | `/media/webp-reports/` |
| Deployment files | `/plugins/` |
| WordPress setup | `/docs/guides/ORGANIZATION_GUIDE.md` |

### Adding New Work

1. **Documentation**: Add to `/docs/guides/` (active) or `/docs/archived-reports/` (historical)
2. **WordPress plugins**: Add to `/plugins/`, deploy to live site
3. **Test files**: Add to `/tests/`, results go in `/test-results/`
4. **Media**: Screenshots → `/media/webp-reports/`
5. **Logs**: Temporary logs → `/archive/exports/` when done

---

## Recent Changes (Dec 8, 2025)

✅ **Moved files to archive/**
- All .txt export files → `/archive/exports/`
- Removed 4 duplicate audit report files
- Removed metadata files (.metadata.json, .resolved)

✅ **Organized by type**
- PHP plugins → `/plugins/`
- Screenshots/webp → `/media/webp-reports/`
- Documentation → `/docs/{guides,reports,archived-reports}`

✅ **Cleaned root**
- From 68 scattered files → 8 essential files only
- 60 files properly organized into subdirectories

✅ **Committed to git**
- Single commit: `f8ab1a4 - refactor: Comprehensive directory cleanup`
- Clean working tree, ready for next phase

---

## Size Reference

| Folder | Size | Purpose |
|---|---|---|
| node_modules | 13 MB | Dependencies (auto-generated) |
| brand-assets | 14 MB | Logo files |
| media | 25 MB | Test screenshots |
| docs | 508 KB | Documentation |
| archive | 208 KB | Old exports |
| **Total Project** | **~55 MB** | Full repo |

---

## Next Steps

1. ✅ Cleanup complete - directory is now optimized
2. Deploy `/plugins/` files to live site if not done
3. Reference `/docs/guides/audit_report.md` for current status
4. Continue development - all files are properly organized

---

Generated: December 8, 2025
