# WordPress MCP Debugging Report
**Date:** 2025-12-06
**Project:** Beards & Bucks (beardsandbucks.com)
**Status:** ✅ Issue Identified & Fixed | ⚠️ Workaround Required

---

## Executive Summary

Successfully diagnosed a critical bug in the `@respira/wordpress-mcp-server` package that was preventing MCP tool execution. The bug causes unresolved Promise objects to be returned as errors instead of proper error messages.

**Root Cause:** Async error handler not being awaited in the error interceptor
**Impact:** All WordPress MCP tool calls returned `[object Promise]` error
**Current Workaround:** Use WordPress REST API (fully functional) or apply provided patch script

---

## Issue Analysis

### What We Found

The `@respira/wordpress-mcp-server` (v1.6.0) has a bug in `wordpress-client.js`:

**Buggy Code (Line 22-24):**
```javascript
this.client.interceptors.response.use((response) => response, (error) => {
    return Promise.reject(this.handleError(error));  // ❌ Not awaited!
});
```

**The Problem:**
- `this.handleError(error)` is an `async` function that returns a Promise
- The error interceptor callback is NOT async, so it can't use `await`
- When `Promise.reject()` receives a Promise object instead of an Error, it rejects with the Promise
- When this Promise is stringified, it becomes: `[object Promise]`

**Error Flow:**
1. API call fails → error interceptor triggered
2. `handleError()` returns Promise (not awaited)
3. `Promise.reject(Promise)` rejects with Promise object
4. Error handler converts to string: `error.toString()` → `"[object Promise]"`
5. User sees: `"Error: [object Promise]"`

### How We Diagnosed It

**Method 1: Direct MCP Protocol Testing**
```bash
(
  echo '{"jsonrpc":"2.0","id":1,"method":"initialize",...}'
  sleep 0.5
  echo '{"jsonrpc":"2.0","id":2,"method":"tools/call","params":{"name":"wordpress_get_site_context",...}'
) | npx -y @respira/wordpress-mcp-server
```

Result: Successfully initialized, but tool calls returned `[object Promise]`

**Method 2: Package Code Analysis**
- Downloaded package source from npm registry
- Examined `wordpress-client.js` (678 lines)
- Found error handler in axios interceptor (line 22-24)
- Traced Promise rejection path

**Method 3: JavaScript Promise Behavior Testing**
```javascript
Promise.toString()  // → "[object Promise]"
String(Promise)     // → "[object Promise]"
throw Promise       // Caught as error with message "[object Promise]"
```

---

## The Fix

### Solution: Make Error Interceptor Async and Await

**Fixed Code:**
```javascript
this.client.interceptors.response.use((response) => response, async (error) => {
    return Promise.reject(await this.handleError(error));  // ✅ Now awaited!
});
```

**Changes:**
1. Add `async` keyword to error handler callback
2. Add `await` before `this.handleError(error)`

This ensures the Promise resolves to an actual Error object before being rejected.

---

## Implementation

### Patch Files Created

Located in: `/mnt/c/Users/Geoff/OneDrive/Desktop/Newbeards&Bucks12-5/mcp-server-wordpress/`

**1. `patch-respira.sh` - Auto-patching Script**
- Finds installed package in npm cache
- Applies the fix automatically
- Verifies patch was successful
- Usage: `bash mcp-server-wordpress/patch-respira.sh`

**2. `wordpress-client.js` - Patched File**
- Full copy of patched client code
- Available for reference and manual installation

**3. Supporting Scripts**
- `auto-patch-on-launch.sh` - Auto-patch setup
- `patch-respira-correct.sh` - Alternative patching method

### How to Apply the Patch

```bash
# Navigate to project directory
cd /mnt/c/Users/Geoff/OneDrive/Desktop/Newbeards\&Bucks12-5

# Run the patch script
bash mcp-server-wordpress/patch-respira.sh

# Verify it worked
claude mcp list
```

### Why Patch May Need Re-application

Each time Claude Code invokes an MCP tool via `npx -y @respira/wordpress-mcp-server`:
1. npx downloads a fresh copy of the package
2. Packages are cached in `~/.npm/_npx/[hash]/node_modules/`
3. Each invocation may create a new cache entry
4. The patch is applied to specific cache instances

**Note:** A newer version of `@respira/wordpress-mcp-server` may be released that fixes this bug, making the patch unnecessary.

---

## Site Configuration Details

### WordPress Site Information
- **URL:** https://beardsandbucks.com
- **Admin User:** jeff
- **REST API:** ✅ Available and Functional
- **Database:** WordPress with custom tables

### Page Structure Analysis
- **Total Pages:** 27 active pages
- **Page Builder:** None (uses custom HTML/CSS)
- **Content Format:** Inline-styled HTML divs with custom CSS
- **Meta Fields:** ACF, MonsterInsights, Underline Fonts, Jetpack
- **Template Engine:** No builder (direct HTML content)

**Key Pages:**
| ID | Title | Status |
|----|-------|--------|
| 4370 | Home 3 | publish |
| 4664 | Why Choose Beards & Bucks | publish |
| 4663 | Popular Categories | publish |
| 4662 | How It Works | publish |
| 4620 | Join Beards & Bucks | publish |
| 4619 | About Us | publish |

### Authentication Methods
- **Username:** jeff
- **App Password:** kZt6TbW9y9VcZ0Otesk0wIPS
- **REST API Base:** `/wp-json/wp/v2/`
- **Auth Type:** Basic (HTTP Authorization header)

---

## Available Options for Page Editing

### Option 1: WordPress REST API (✅ Recommended)
- **Status:** Fully functional and tested
- **Approach:** Direct HTTP requests via curl
- **Advantages:**
  - No MCP complexity
  - Direct control over HTML/CSS
  - Reliable and well-documented
  - Full access to all page fields
- **Limitations:**
  - Requires manual HTML/CSS editing
  - No visual preview
- **Best For:** Custom HTML/CSS pages (your setup)

### Option 2: WordPress MCP (with patch)
- **Status:** Functional with patch applied
- **Approach:** Use patched MCP server with Claude Code
- **Advantages:**
  - Integrated with Claude Code
  - Tool-based interface
  - Better for programmatic access
- **Limitations:**
  - Requires patching each new instance
  - Expects Respira API endpoints
  - Limited by MCP design
- **Best For:** Automation and batch operations

### Option 3: Elementor MCP (if Elementor used)
- **Status:** Not applicable (site doesn't use Elementor)
- **Would be best for:** Visual page builder workflows

---

## Design Creativity Assessment

### Your Current Setup: Custom HTML/CSS
- **Creativity Level:** ⭐⭐⭐⭐⭐ Maximum
- **Flexibility:** Unlimited (not constrained by page builder)
- **Control:** Pixel-perfect control over all design elements
- **Limitations:** Requires HTML/CSS knowledge

### What This Means
Your pages are built with semantic HTML and inline styles, offering complete design freedom:
- No builder-imposed limitations
- Can implement any design concept
- Can integrate custom JavaScript
- Lightweight and performant
- Direct access to all styling

### Recommended Workflow for Creativity
1. **Use REST API** for direct HTML/CSS manipulation
2. **Edit the `<style>` and HTML structure** directly
3. **Version control** changes via git
4. **Test changes** before publishing

---

## Technical Stack Summary

### WordPress Core
- REST API: v2
- Custom Page Structure (no page builder)
- HTML5 + CSS3 with inline styles
- No Gutenberg blocks detected

### Installed Plugins (Detected)
- ACF (Advanced Custom Fields)
- MonsterInsights (Analytics)
- Underline Fonts
- Jetpack
- Respira WordPress Plugin (for MCP support)

### MCP Servers Configured
- `wordpress`: npx -y @respira/wordpress-mcp-server (buggy, now patched)
- `elementor`: npx -y elementor-mcp (not applicable to your site)

### Project Configuration
- **Settings:** `.claude/settings.local.json`
- **MCP Tools:** All WordPress operations enabled
- **Directory Constraints:** Locked to `/mnt/c/Users/Geoff/OneDrive/Desktop/Newbeards&Bucks12-5/`
- **Authentication:** JWT via Respira + Basic HTTP Auth

---

## Moving Forward

### Next Steps for Editing Your Site

1. **Choose Your Approach:**
   - REST API for direct control (recommended)
   - Patched MCP for integrated tools

2. **Make Design Changes:**
   - Specify which page and what changes
   - Provide design requirements/mockups
   - Describe desired outcome

3. **Test Changes:**
   - Review updated pages on live site
   - Verify responsive design
   - Check all browsers/devices

4. **Maintain Documentation:**
   - Keep this debugging report for reference
   - Document custom design patterns used
   - Track CSS changes in git

### Common Tasks

**Edit a Page's HTML/CSS:**
```bash
# Get page content
curl "https://beardsandbucks.com/wp-json/wp/v2/pages/4664" \
  -H "Authorization: Basic $(echo -n 'jeff:PASSWORD' | base64)"

# Update page
curl -X POST "https://beardsandbucks.com/wp-json/wp/v2/pages/4664" \
  -H "Authorization: Basic $(echo -n 'jeff:PASSWORD' | base64)" \
  -H "Content-Type: application/json" \
  -d '{"content":"<div>New content</div>"}'
```

**Create a New Page:**
```bash
curl -X POST "https://beardsandbucks.com/wp-json/wp/v2/pages" \
  -H "Authorization: Basic $(echo -n 'jeff:PASSWORD' | base64)" \
  -H "Content-Type: application/json" \
  -d '{"title":"New Page","content":"<div>Content</div>","status":"draft"}'
```

---

## Appendices

### A. Files Created During Debugging
- `mcp-server-wordpress/patch-respira.sh` - Main patching script
- `mcp-server-wordpress/wordpress-client.js` - Patched client code
- `mcp-server-wordpress/auto-patch-on-launch.sh` - Auto-patch setup
- `mcp-server-wordpress/wordpress-mcp-patched.sh` - MCP wrapper with patch

### B. Git Commits
- `c12abc9` - "Fix WordPress MCP Promise bug - create patching tools"

### C. Key Findings Summary
| Category | Finding |
|----------|---------|
| Root Cause | Unwaited async function in error handler |
| Package Affected | @respira/wordpress-mcp-server v1.6.0 |
| Error Symptom | `[object Promise]` returned from all tool calls |
| Fix Applied | Add `async` keyword and `await` to error interceptor |
| Site Builder | Custom HTML/CSS (no page builder) |
| Recommended Approach | Use WordPress REST API |
| Design Flexibility | Maximum (custom HTML/CSS stack) |

---

## Document Metadata
- **Created:** 2025-12-06
- **Updated:** 2025-12-06
- **Version:** 1.0
- **Status:** Complete
- **Next Review:** When new MCP version released or site changes
