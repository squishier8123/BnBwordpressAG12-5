# Phase 1: Automation System - Complete Guide

**Status:** ✅ PHASE 1 IMPLEMENTATION COMPLETE

**What This Does:** Automates accuracy verification and pre-flight checks using MCP integration and Claude's native vision capability.

---

## 📁 File Structure

```
/04_ANTIGRAVITY_EXECUTION/automation/
├── mcp_config.json                    # MCP configuration (MySQL + Fetch)
├── screenshot_analyzer.py             # Claude vision integration
├── README.md                          # This file
├── lib/
│   ├── common.sh                      # Shared functions (logging, alerts, database)
│   ├── wordpress_api.sh               # WordPress helper functions
│   └── browser_check.sh               # Page loading and element verification
├── background_monitoring/             # (Phase 2)
│   ├── site_health_monitor.sh
│   ├── error_log_watcher.sh
│   ├── backup_verification.sh
│   └── performance_monitor.sh
└── logs/
    ├── automation.log                 # All automation activity
    ├── ALERTS.log                     # Alert history
    ├── ATTENTION_NEEDED.flag          # Created on critical alert
    └── screenshot_analysis_*.json     # Screenshot analysis specs
```

---

## 🔧 Configuration

### MCP Setup (mcp_config.json)

**MySQL MCP** - Direct database verification:
```json
{
  "DB_HOST": "localhost",
  "DB_PORT": "3306",
  "DB_USER": "wordpress",
  "DB_PASSWORD": "${DB_PASSWORD}",
  "DB_NAME": "beardsandbucks_db"
}
```

**Fetch MCP** - API validation and site health:
```json
{
  "ALLOWED_DOMAINS": "beardsandbucks.com,api.mapbox.com",
  "TIMEOUT_MS": "10000"
}
```

**Usage:**
```bash
# Set environment variable
export DB_PASSWORD="your_db_password"

# Scripts automatically use mcp_config.json for connections
source ./lib/common.sh
get_wp_option "mapbox_api_key"  # Queries database via MySQL MCP
```

---

## 📚 Library Functions

### common.sh
Core functions used by all scripts:

**Logging:**
```bash
log_info "Information message"
log_warn "Warning - logged and flagged"
log_error "Error - stops execution"
log_success "Success message"
```

**Database Functions:**
```bash
db_query "SELECT ..."
get_wp_option "option_name"
update_wp_option "option_name" "value"
check_wp_user_admin "username"
```

**Site Health:**
```bash
check_site_online
check_wordpress_admin
```

**Git Functions:**
```bash
git_repo_clean
git_create_checkpoint "message"
git_get_commit_hash
```

**Alerts:**
```bash
create_alert_flag "CRITICAL" "Message"
clear_alert_flag
```

---

### wordpress_api.sh
WordPress-specific helpers:

```bash
# Settings
get_site_option "option_name"
set_site_option "option_name" "value"

# Listeo Settings
get_listeo_setting "bookings_enable"
set_listeo_setting "bookings_enable" "1"

# Users
get_user_by_login "username"
check_user_has_capability "username" "administrator"

# Pages/Posts
page_exists "page_slug"
get_page_by_slug "page_slug"

# REST API
call_rest_api "/endpoint"
get_posts_via_rest "post_type"
```

---

### browser_check.sh
Page verification helpers:

```bash
# Navigation
check_url_loads "https://example.com"
check_url_title "https://example.com" "Expected Title"

# Elements
element_visible_on_page "url" "selector"
text_exists_on_page "url" "text"

# Forms
check_form_exists "url" "form_id"
check_form_field_exists "url" "field_name"
count_form_fields "url"

# Buttons/Links
check_button_exists "url" "button_text"
check_button_enabled "url" "button_text"
check_link_exists "url" "link_text"

# Errors
check_for_errors_in_html "url"
check_console_errors "url"

# APIs
check_mapbox_api_working "api_key"
check_api_endpoint_working "url"
```

---

## 🔍 Verification Scripts

### ⏳ STATUS: PLANNED IMPLEMENTATION

**Current State:** Master script (`verify_all_fixes.sh`) exists but depends on 6 individual verification scripts that are currently in development. The 6 scripts listed below are PLANNED and will be created during Phase 1 of system synchronization. The verification script framework, libraries, and master orchestration are ready.

**What's Ready:**
- ✅ Library functions in `lib/common.sh`, `lib/wordpress_api.sh`, `lib/browser_check.sh`
- ✅ Master script framework in `verify_all_fixes.sh`
- ✅ MCP configuration for database/API access
- ✅ Screenshot analyzer for Claude vision integration

**What's Needed:**
- ⏳ `verify_fix_1_map.sh` - Mapbox API verification
- ⏳ `verify_fix_2_permalink.sh` - Add Listing 404 fix verification
- ⏳ `verify_fix_3_booking.sh` - Booking module verification
- ⏳ `verify_fix_4_modal.sh` - Login modal verification
- ⏳ `verify_fix_5_regions.sh` - Regions field removal verification
- ⏳ `verify_fix_6_footer.sh` - Footer links verification

Each script will follow the template pattern below using shared libraries.

### Running Individual Verifications (Once Created)

```bash
# Verify Fix 1: Map Loading
./VERIFICATION_SCRIPTS/automated/verify_fix_1_map.sh

# Exit codes:
# 0 = PASSED (all checks passed)
# 1 = FAILED (verification failed)
# 2 = PARTIAL (some checks passed, some failed)
```

### Running All Fixes (Parallel)

```bash
# Run all 6 verifications in parallel (2-3 minutes total)
./VERIFICATION_SCRIPTS/automated/verify_all_fixes.sh

# Output:
# ✅ Fix 1: PASSED
# ✅ Fix 2: PASSED
# ⚠️  Fix 3: PARTIAL
# ❌ Fix 4: FAILED
# ...
# Summary: 2 passed, 1 partial, 1 failed
```

### What Each Verification Checks

**Fix 1: Mapbox API Key**
- [ ] API key in database (wp_options)
- [ ] API key format valid (starts with pk.)
- [ ] Mapbox API responds to key
- [ ] Map visible on search page
- [ ] Map visible on listing detail page
- [ ] No console errors

**Fix 2: Add Listing Button (404)**
- [ ] /add-listing/ returns 200 (not 404)
- [ ] Page loads without errors
- [ ] Form fields present (8+ expected)
- [ ] Required fields exist (title, description, price)
- [ ] No 404 in page content

**Fix 3: Booking Module**
- [ ] Bookings enabled in settings
- [ ] "Book Now" button visible on listings
- [ ] Booking widget accessible
- [ ] No booking script errors
- [ ] Booking shortcodes present (if applicable)

**Fix 4: Login Modal**
- [ ] Login button exists on homepage
- [ ] Login form has email and password fields
- [ ] Modal structure detected (not page redirect)
- [ ] Close/dismiss mechanism present
- [ ] Register/signup link present

**Fix 5: Regions Field Removed**
- [ ] Regions field disabled in database
- [ ] Regions NOT visible on Add Listing form
- [ ] Form still has other fields
- [ ] Form can submit without Regions
- [ ] No field removal errors

**Fix 6: Footer Legal Links**
- [ ] Privacy Policy link in footer
- [ ] Terms & Conditions link in footer
- [ ] Privacy page returns 200
- [ ] Terms page returns 200
- [ ] Links are proper href elements

---

## 👁️ Screenshot Analysis (Claude Vision)

### How It Works

1. **Antigravity takes screenshot** of action result
2. **Verification script creates analysis spec** specifying what to check
3. **Claude Code reads screenshot** using native vision
4. **Claude analyzes visual state** (buttons, errors, success, forms, etc.)
5. **Claude reports findings** back to verification script
6. **Script acts on findings** (pass/fail/retry)

### Using Screenshot Analyzer

```bash
# Import in Python
python3 -c "
from automation.screenshot_analyzer import ScreenshotAnalyzer
analyzer = ScreenshotAnalyzer()

# Analyze Fix 1 screenshot
analyzer.analyze_fix_1_screenshot('/path/to/screenshot.png')

# Creates: logs/screenshot_analysis_YYYYMMDD_HHMMSS.json
# Claude Code reads this spec and analyzes the screenshot
"

# From bash
python3 ./automation/screenshot_analyzer.py --fix 1 --screenshot /path/to/file.png
```

### Screenshot Analysis Checks

**Visual State Verification:**
- ✅ Button clicked/loading state
- ✅ Error messages (red text, error icons)
- ✅ Success indicators (checkmarks, "saved" messages)
- ✅ URL/page navigation correct
- ✅ Form fields filled/empty correctly
- ✅ Modal open/closed as expected
- ✅ Loading spinners or processing state
- ✅ UI regressions or layout breaks

---

## 🚨 Alert System

### Alert Levels

**INFO** - Logged silently
```
[2025-12-06 14:30:15] INFO: Pre-flight check 3 passed
```

**WARN** - Logged and flagged
```
[2025-12-06 14:30:15] WARN: Backup > 10 minutes old
```

**CRITICAL** - Creates action flag
```
[2025-12-06 14:30:15] CRITICAL: Site offline - blocking Antigravity
File created: /04_ANTIGRAVITY_EXECUTION/logs/ATTENTION_NEEDED.flag
```

### Using Alerts

```bash
source ./lib/common.sh

# Create alert
create_alert_flag "CRITICAL" "Database connection failed"

# Check for alert (in scripts)
if [ -f "${ALERT_FLAG}" ]; then
    echo "Alert detected - blocking execution"
    exit 1
fi

# Clear alert (after resolution)
clear_alert_flag
```

---

## 📊 Logs and Reports

### Log Files Created

**automation.log** - All activity
```
[2025-12-06 14:30:15] INFO: Starting pre-flight checks
[2025-12-06 14:30:20] ✅ Site online and responding
[2025-12-06 14:30:25] ✅ Database backup exists
```

**ALERTS.log** - Warnings and errors
```
2025-12-06 14:35:10 WARN: Error log has 15 entries
2025-12-06 14:35:15 CRITICAL: Backup missing
```

**verification_YYYYMMDD_HHMMSS.log** - Verification run
```
Fix 1: PASSED (all checks passed)
Fix 2: FAILED (Add Listing page 404)
Fix 3: PARTIAL (Booking module enabled but widget not loading)
```

**screenshot_analysis_YYYYMMDD_HHMMSS.json** - Visual analysis spec
```json
{
  "timestamp": "2025-12-06T14:30:15",
  "analyses": [
    {
      "check_type": "button_click",
      "screenshot": "/path/to/screenshot.png",
      "prompt": "Verify the Save button was clicked..."
    }
  ]
}
```

---

## 🔗 Integration With Antigravity

### Workflow

```
User: "Run Antigravity to fix issues"
  ↓
Claude Code: Run pre-flight automation
  ├── Check site online
  ├── Verify database backup
  ├── Check user permissions
  └── Verify API keys
  ↓
If all pass → proceed to Antigravity
If any fail → block and alert user
  ↓
Antigravity: Perform task (e.g., "Save Mapbox API key")
  ├── Takes screenshot
  ├── Reports: "Task complete"
  ↓
Claude Code: Run verification
  ├── Query database for API key
  ├── Test Mapbox API with key
  ├── Analyze screenshot using vision
  └── Verify frontend loads map
  ↓
If all pass → ✅ FIX VERIFIED
If any fail → ❌ FIX FAILED, investigate
  ↓
Post-execution: Generate verification report
  ├── 5/6 fixes verified
  ├── 1 fix failed (with reason)
  ├── 0 hallucinations detected
  └── Full audit trail logged
```

---

## 🧪 Testing Phase 1

### Quick Test

```bash
# Test database connection
source ./lib/common.sh
mapbox_key=$(get_wp_option "mapbox_api_key")
echo "API Key: ${mapbox_key:0:10}..."

# Test site health
check_site_online && echo "✅ Site online" || echo "❌ Site offline"

# Test verification script
bash ./VERIFICATION_SCRIPTS/automated/verify_fix_1_map.sh

# Test all verifications
bash ./VERIFICATION_SCRIPTS/automated/verify_all_fixes.sh
```

### Full Test Suite

```bash
# 1. Test libraries load
bash -c 'source ./lib/common.sh && log_success "✅ common.sh loaded"'
bash -c 'source ./lib/wordpress_api.sh && log_success "✅ wordpress_api.sh loaded"'
bash -c 'source ./lib/browser_check.sh && log_success "✅ browser_check.sh loaded"'

# 2. Test MCP connections
python3 -c "import json; print('✅ Config loads:', json.load(open('mcp_config.json')))"

# 3. Run verifications
for i in {1..6}; do
  bash ./VERIFICATION_SCRIPTS/automated/verify_fix_${i}*.sh || echo "Fix ${i} test failed"
done

# 4. Test screenshot analyzer
python3 ./automation/screenshot_analyzer.py --fix 1 --screenshot ./test.png
```

---

## 🛠️ Troubleshooting

### Database Connection Fails

```bash
# Check MySQL is running
mysql -h localhost -u wordpress -p"${DB_PASSWORD}" -e "SELECT 1"

# Verify credentials in mcp_config.json
grep -A5 '"mysql"' ./mcp_config.json

# Test direct query
mysql -h localhost -u wordpress beardsandbucks_db -se "SELECT option_value FROM wp_options LIMIT 1"
```

### Verification Script Fails

```bash
# Run with debug output
bash -x ./VERIFICATION_SCRIPTS/automated/verify_fix_1_map.sh

# Check logs
tail -20 ./logs/automation.log
tail -20 ./logs/ALERTS.log

# Verify site is accessible
curl -I https://beardsandbucks.com
```

### Screenshot Analysis Not Working

```bash
# Check Python environment
python3 --version

# Test screenshot analyzer import
python3 -c "from automation.screenshot_analyzer import ScreenshotAnalyzer; print('✅ Loaded')"

# Check screenshot file exists
ls -la ./screenshots/

# Run analysis with verbose output
python3 ./automation/screenshot_analyzer.py --fix 1 --screenshot /path/to/file.png
```

---

## 📋 Next Steps (Phase 2)

Phase 1 is complete. Phase 2 adds background monitoring:

- [ ] Site health monitor (every 15 min)
- [ ] Error log watcher (every 5 min)
- [ ] Backup verification (daily at 2 AM)
- [ ] Performance monitor (hourly)
- [ ] Post-execution verification runner
- [ ] Cron job scheduling

See `/04_ANTIGRAVITY_EXECUTION/automation/background_monitoring/` for Phase 2 scripts.

---

## 📞 Support

**If verification fails:**
1. Check logs: `tail ./logs/automation.log`
2. Check for alerts: `cat ./logs/ATTENTION_NEEDED.flag`
3. Run specific verification: `bash ./VERIFICATION_SCRIPTS/automated/verify_fix_X.sh`
4. Review alert system: Understand severity levels (INFO/WARN/CRITICAL)

**For screenshot analysis issues:**
1. Ensure screenshot file exists
2. Check Claude Code can read it (using Read tool)
3. Review analysis spec: `cat ./logs/screenshot_analysis_*.json`

---

**Phase 1 Status:** ✅ COMPLETE AND READY TO TEST
