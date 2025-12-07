# Beards & Bucks - Antigravity WordPress Fixes

Automated WordPress site fixes and audits for the Beards & Bucks vendor directory using Google's Antigravity browser automation agent.

## Project Overview

This project contains comprehensive audit findings and implementation guides to fix critical issues on the Beards & Bucks WordPress site, including:

- **Directory Display**: Vendor directory showing 0 listings (15 exist in backend)
- **Font 404 Errors**: Missing font files causing console errors
- **Search Widget**: Broken search functionality and results page routing
- **Footer Menu**: Missing footer navigation with legal pages

## Quick Start

1. **Review the Audit**: See `01_AUDIT_FINDINGS/` for initial findings
2. **Execute Fixes**: Follow `02_IMPLEMENTATION/ANTIGRAVITY_FIX_IMPLEMENTATION_REVISED.md`
3. **Reference Structure**: Check `INDEX.md` for complete project organization

## Folder Structure

```
.
├── 01_AUDIT_FINDINGS/           # Initial WordPress audit and verification
├── 02_IMPLEMENTATION/           # Active fix execution guides
├── 03_DEPRECATED/               # Previous versions (reference only)
├── .claude/                      # Claude Code configuration
├── Logo/                         # Brand assets
├── colors/                       # Color palette reference
├── INDEX.md                      # Complete project index
├── README.md                     # This file
└── project_rules.md              # Project guidelines
```

## Key Documents

| Document | Purpose | Location |
|----------|---------|----------|
| WordPress MCP Debugging Report | Complete analysis of MCP issues and fixes | `docs/WORDPRESS_MCP_DEBUGGING_REPORT_2025_12_06.md` |
| Execution Brief | Quick reference of what changed | `02_IMPLEMENTATION/ANTIGRAVITY_EXECUTION_BRIEF.md` |
| Fix Implementation | 7-step guide for Antigravity | `02_IMPLEMENTATION/ANTIGRAVITY_FIX_IMPLEMENTATION_REVISED.md` |
| Audit Report | Initial findings and root causes | `01_AUDIT_FINDINGS/audit_report_2025_12_05.md` |
| Full Index | Project structure and references | `INDEX.md` |

## Environment Setup

This project requires WordPress credentials. Environment variables are stored in a `.env` file (not included in repo for security).

Contact the project owner for environment setup details.

## What Changed from Previous Version

The revised implementation guide (`02_IMPLEMENTATION/ANTIGRAVITY_FIX_IMPLEMENTATION_REVISED.md`) differs from the original approach:

| Aspect | Old Version | New Version |
|--------|-----------|-----------|
| Font Fixes | WordPress Customizer UI | Theme File Editor (direct CSS) |
| Priority Order | Fonts first | Directory shortcode first |
| Approach | UI automation | Direct file editing |
| Customizer Use | Required | Completely bypassed |

**Why the change**: Initial attempts to automate WordPress Customizer's custom font picker failed. The revised approach uses Theme File Editor for direct CSS editing, which is fully automatable.

## Success Criteria

When all fixes are complete, verify:

- ✓ Directory page shows 5+ vendor listings (currently 0)
- ✓ No font 404 errors in browser console
- ✓ Search widget submits to working results page
- ✓ Footer displays Privacy Policy and Terms of Service links
- ✓ Responsive design works at mobile (375px) and desktop (1920px)

## Troubleshooting

### Theme File Editor Blocked
If WordPress Theme File Editor is not accessible, use the manual verification checklist as fallback:
- See: `02_IMPLEMENTATION/MANUAL_VERIFICATION_CHECKLIST.md`

### Customizer Font Controls
Font configuration should be done via Theme File Editor (CSS), not Customizer. Direct CSS editing avoids automation issues.

### File Path Issues
All paths in documentation are absolute from the project root. If using different environment, adjust paths accordingly.

## WordPress Site Editing

### Current Site Configuration
- **URL**: https://beardsandbucks.com
- **Page Builder**: Custom HTML/CSS (no Elementor/Divi)
- **Design Flexibility**: Maximum (⭐⭐⭐⭐⭐)
- **Total Pages**: 27 active pages
- **Design Approach**: Inline-styled HTML divs with custom CSS

### How to Edit Pages
**Two Methods Available:**

1. **WordPress REST API (Recommended)** ✅
   - Direct HTTP requests via curl
   - Full control over HTML/CSS
   - Reliable and battle-tested
   - See: `docs/WORDPRESS_MCP_DEBUGGING_REPORT_2025_12_06.md`

2. **WordPress MCP (with patch)**
   - Requires running patch script first
   - Integrated with Claude Code tools
   - Requires applying fix to new package instances
   - See: `mcp-server-wordpress/patch-respira.sh`

### Available Pages for Editing
See `docs/WORDPRESS_MCP_DEBUGGING_REPORT_2025_12_06.md` for complete page list including:
- Why Choose Beards & Bucks (ID: 4664)
- Popular Categories (ID: 4663)
- How It Works (ID: 4662)
- About Us (ID: 4619)
- And 23 more...

### MCP Status
- **WordPress MCP**: ✅ Fixed (patch available)
- **Elementor MCP**: N/A (site doesn't use Elementor)
- **Patch Location**: `mcp-server-wordpress/patch-respira.sh`

## Status

- Audit: ✅ Complete
- Implementation Guide: ✅ Ready
- Fixes (Automated): 🔄 In Progress
- MCP Debugging: ✅ Complete & Fixed
- WordPress Editing: ✅ Ready (REST API or patched MCP)

## References

- **Listeo Plugin Documentation**: https://listeowordpress.com/
- **WordPress Theme Editor**: WordPress Admin > Appearance > Theme File Editor
- **Elementor Documentation**: https://elementor.com/

---

**Last Updated**: 2025-12-06
**Authors**: Antigravity (Google Cloud Browser Automation) + Claude Code MCP Debugging
**Status**: MCP Fixed & Ready for WordPress Site Editing
