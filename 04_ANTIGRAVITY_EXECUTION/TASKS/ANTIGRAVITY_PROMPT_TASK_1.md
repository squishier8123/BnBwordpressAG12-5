# ANTIGRAVITY EXECUTION PROMPT - TASK 1
## Add Google Maps API Key to Listeo Settings

**Status:** Ready for Execution
**Priority:** CRITICAL
**Estimated Time:** 10 minutes
**Browser Automation Required:** YES

---

## Your Mission

Configure the Mapbox/Google Maps API key in the Listeo WordPress plugin so that maps render correctly on listing detail pages.

**Current State:** Maps are broken on listing pages because no API key is configured.
**Desired State:** Maps render with proper zooming, panning, and pin placement on all listing pages.

---

## Execution Steps

### Step 1: Navigate to WordPress Admin
1. Go to: `https://beardsandbucks.com/wp-admin`
2. Log in with your WordPress credentials
3. Wait for dashboard to fully load
4. Take screenshot labeled: `task_1_01_logged_in_admin.png`

### Step 2: Navigate to Listeo Map Settings
**Path:** WordPress Admin Dashboard → Listeo Core → Map Settings

1. Look for "Listeo Core" in the left sidebar menu
2. Click to expand the menu
3. Look for "Map Settings", "Maps", "Location Settings", or similar option
4. Click on that option
5. Wait for page to load completely
6. Take screenshot labeled: `task_1_02_map_settings_page.png`

**Alternative Path (if menu navigation fails):**
- Try direct URL: `https://beardsandbucks.com/wp-admin/admin.php?page=listeo_map_settings`
- If that doesn't work, try: `https://beardsandbucks.com/wp-admin/admin.php?page=listeo-map-settings`

### Step 3: Locate API Key Field
On the Map Settings page, look for:
- A text input field labeled "Mapbox API Key", "API Key", or "Public Key"
- It might say "Mapbox Public Token" or similar
- It should be a required field
- There may be a description explaining it's the Mapbox public key

1. Identify the API key input field
2. Take screenshot labeled: `task_1_03_api_key_field_empty.png` (showing empty field)

### Step 4: Enter the API Key
You need a valid Mapbox API key. Options:

**Option A: If you have an existing key**
- Use that key

**Option B: If you need to find it**
- Check your environment variables or .env file
- Look in the WordPress options table: `wp_options` where `option_name` contains 'mapbox' or 'map'
- Check password manager or configuration files

**Once you have the key:**
1. Click on the API key input field
2. Clear any existing content (if any)
3. Paste/enter the Mapbox public key
4. The key format should look like: `pk.eyJ1IjoiYXV0aG9yIiwiYSI6ImNrNjl0c28wMjAwMDAwdmg5cW8xcTAifQ...` (long alphanumeric string starting with "pk.")
5. Take screenshot labeled: `task_1_04_api_key_entered.png` (showing key in field)

### Step 5: Save Settings
1. Look for a "Save" or "Save Settings" button
2. It's usually at the bottom of the form
3. Click the Save button
4. Wait for confirmation message
5. Take screenshot labeled: `task_1_05_settings_saved.png` (showing save confirmation)

### Step 6: Verify on Frontend - Part 1: Find a Listing
1. Navigate to: `https://beardsandbucks.com/listings` or `https://beardsandbucks.com/` (homepage)
2. Look for any listing card with an image/title
3. Click on a listing to open its detail page
4. Wait for page to load completely
5. Take screenshot labeled: `task_1_06_listing_page_loaded.png`

### Step 7: Verify Maps Render
On the listing detail page:
1. Scroll down to find the map section
2. Look for a map display with:
   - A visible map showing a location
   - A pin/marker on the map
   - Zoom controls (+ and - buttons)
   - Pan capability (ability to drag the map)
3. Verify the map shows a real location (not blank/error)
4. Try zooming in/out using the + and - buttons
5. Try dragging the map to pan around
6. Take screenshot labeled: `task_1_07_map_renders_correctly.png` (showing the map with location)

### Step 8: Check Console for Errors
1. Open browser Developer Tools (F12 or Right-click → Inspect)
2. Go to the "Console" tab
3. Look for any red error messages
4. Look specifically for errors containing "mapbox", "maps", "API", or "403"
5. Take screenshot labeled: `task_1_08_console_check.png` (showing console, no errors)

**If you see errors:**
- Take detailed screenshot of the error
- Note the exact error message
- Report as PARTIAL (maps broken, API key issue)

---

## Success Criteria - ALL Must Be True

- [ ] Mapbox API key successfully entered and saved in Listeo settings
- [ ] Map displays on listing detail page (not blank or error state)
- [ ] Map shows correct location with visible pin/marker
- [ ] Zoom controls work (+ and - buttons responsive)
- [ ] Map can be panned/dragged without errors
- [ ] No red error messages in browser console
- [ ] No "403 Forbidden" or authentication errors

---

## Documentation to Provide

When complete, provide:
1. All 8 screenshots listed above
2. Final status: PASS / FAIL / PARTIAL
3. If FAIL/PARTIAL:
   - Describe what went wrong
   - Include full error message text
   - Suggest next steps

---

## Troubleshooting

**Problem: Can't find Map Settings in menu**
- Solution 1: Try direct URL: `https://beardsandbucks.com/wp-admin/admin.php?page=listeo_map_settings`
- Solution 2: Look under "Listeo Core" → "Settings" → look for Maps tab
- Solution 3: Search WordPress documentation for "Listeo Map Settings"

**Problem: Map doesn't render after saving API key**
- Solution 1: Clear browser cache (Ctrl+Shift+Delete)
- Solution 2: Hard refresh page (Ctrl+Shift+R)
- Solution 3: Check if API key is valid (try test key from Mapbox docs)
- Solution 4: Check console for specific error message

**Problem: "Invalid API Key" error**
- Solution: Verify you're using the PUBLIC key, not the SECRET key
- Mapbox public keys start with `pk.`

**Problem: Console shows 403 error**
- Solution: API key might be invalid or restrictions set wrong
- Contact Mapbox support or verify key from dashboard

---

## When Done

Report back with:
- Task 1 PASS / FAIL / PARTIAL status
- All screenshots
- Description of final map state
- Any issues encountered

Then move to Task 2.
