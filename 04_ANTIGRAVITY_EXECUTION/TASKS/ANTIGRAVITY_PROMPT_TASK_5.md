# ANTIGRAVITY EXECUTION PROMPT - TASK 5
## Fix Geocoding for Sunny Apartment Listing

**Status:** Ready for Execution
**Priority:** HIGH
**Estimated Time:** 10 minutes
**Browser Automation Required:** YES
**Depends On:** Task 4 (should delete test listings first to avoid confusion)

---

## Your Mission

Update the "Sunny Apartment" listing to fix its geocoding data. The listing currently points to Sydney, Australia instead of New York, USA. Update the address and geocoding coordinates.

**Current State:** Listing "Sunny Apartment" has address but map pins to Sydney, Australia (wrong location).
**Desired State:** Listing shows New York location with correct latitude/longitude coordinates.

---

## Geocoding Information

**What needs to change:**
- Current: Sydney, Australia (incorrect)
- Desired: New York, USA (correct)

**New York Coordinates (Approximate):**
- Latitude: 40.7128
- Longitude: -74.0060

**If different address needed:**
- Update address to specific New York address
- Then use Geocode button to auto-populate coordinates
- Or manually enter coordinates above

---

## Execution Steps

### Step 1: Navigate to Listings
1. Go to: `https://beardsandbucks.com/wp-admin`
2. Make sure you're logged in
3. In left sidebar, find "Posts" → "Listings"
4. Wait for listings page to load
5. Take screenshot labeled: `task_5_01_listings_page.png`

**Direct URL:**
- `https://beardsandbucks.com/wp-admin/edit.php?post_type=listing`

### Step 2: Find and Open "Sunny Apartment"
1. Look through the listings for "Sunny Apartment"
2. When you find it, click on the title
3. The listing edit page should open
4. Wait for all fields to load
5. Take screenshot labeled: `task_5_02_sunny_apartment_open.png`

### Step 3: Check Current Address and Coordinates
1. Look for address fields (might be labeled "Address", "Location", "Street Address", etc.)
2. Note what address is currently showing
3. Look for coordinates or geocoding fields (might be labeled "Latitude", "Longitude", "Geo", etc.)
4. Note the current coordinates (probably pointing to Sydney)
5. Take screenshot labeled: `task_5_03_current_address_noted.png` (showing current address and coordinates)

### Step 4: Update Address (if needed)
**Option A: If address is already correct (says "New York" or similar)**
- Skip this step, go to Step 5

**Option B: If address needs updating**
1. Find the address input field
2. Click on it
3. Select all the text (Ctrl+A)
4. Delete it
5. Type a New York address, for example:
   - "New York, NY, USA" (generic)
   - "123 Main Street, New York, NY 10001" (specific)
   - "Times Square, New York, NY" (landmark)
6. Take screenshot labeled: `task_5_04_address_updated.png`

### Step 5: Geocode the Address
1. Look for a "Geocode" button, "Geocode Address" button, or similar
2. It might be near the address field or in a separate "Geocoding" section
3. Click the Geocode button
4. Wait 5-10 seconds for the geocoding service to process
5. Look for coordinates to auto-populate:
   - Latitude field should show approximately: 40.7128
   - Longitude field should show approximately: -74.0060
6. If coordinates auto-populated correctly, you're done with this step
7. Take screenshot labeled: `task_5_05_geocoded_coordinates.png` (showing lat/long updated)

**Alternative: Manual Coordinate Entry**
If Geocode button doesn't work or coordinates don't auto-populate:
1. Find Latitude field
2. Clear it
3. Enter: 40.7128
4. Find Longitude field
5. Clear it
6. Enter: -74.0060
7. Take screenshot labeled: `task_5_05_manual_coordinates_entered.png`

### Step 6: Verify Map Display
1. Look for a map preview on the edit page
2. The map should now show New York location (not Sydney)
3. You might see a pin/marker on the map
4. If the map is showing the wrong location:
   - Try refreshing the page
   - Try clicking Geocode button again
   - Check if coordinates were actually saved
5. Take screenshot labeled: `task_5_06_map_shows_new_york.png` (showing map with correct location)

### Step 7: Save the Listing
1. Look for "Update", "Save", or "Publish" button
2. Click the save/update button
3. Wait for confirmation message
4. You should see "Post updated" or similar message
5. Take screenshot labeled: `task_5_07_listing_saved.png` (showing save confirmation)

### Step 8: Verify on Frontend
1. Navigate to the listing on the public site
2. Go to: `https://beardsandbucks.com/listings/sunny-apartment/` (or similar URL)
3. Or go to listings page and click on Sunny Apartment
4. Scroll to find the map section
5. Verify the map shows New York location
6. Verify the pin/marker is in the right place
7. Try zooming in/out on the map
8. Try panning/dragging the map
9. Take screenshot labeled: `task_5_08_frontend_map_shows_new_york.png` (showing correct location on public site)

---

## Success Criteria - ALL Must Be True

- [ ] "Sunny Apartment" listing opened successfully
- [ ] Address field updated or confirmed correct
- [ ] Latitude coordinate set to approximately 40.7128
- [ ] Longitude coordinate set to approximately -74.0060
- [ ] Map preview shows New York location (not Sydney)
- [ ] Listing saved/updated successfully
- [ ] Frontend map displays correct New York location
- [ ] No error messages during geocoding or save

---

## Important Notes

**Coordinate Ranges for Verification:**
- Latitude should be between 40.70 and 40.72 (New York area)
- Longitude should be between -74.01 and -73.99 (New York area)
- If coordinates outside this range, geocoding failed

**Common Geocoding Issues:**
- Geocode button might be in different location than expected
- Might need to save first, then geocode
- Some plugins require specific format (decimal vs DMS)
- Map might take few seconds to update after coordinates change

**Address Format Examples that work:**
- "New York, NY"
- "New York, NY, USA"
- "123 Main St, New York, NY 10001"
- "New York" (just the city)

---

## Troubleshooting

**Problem: Can't find geocoding section**
- Scroll down in the listing editor - might be below visible area
- Look for "Map", "Location", "Geocoding", or "Coordinates" sections
- Check different tabs if the editor has multiple tabs

**Problem: Geocode button doesn't work**
- Make sure address field has content first
- Try clicking button again
- Try saving listing first, then geocoding
- Check console (F12) for error messages

**Problem: Coordinates don't update**
- Try manual entry instead
- Latitude: 40.7128
- Longitude: -74.0060
- Then save

**Problem: Map still shows Sydney after save**
- Try hard refresh (Ctrl+Shift+R) to clear cache
- Check if coordinates actually saved (re-open listing)
- If coordinates are correct but map wrong, might be theme caching issue

**Problem: Address won't update**
- Try clearing field completely
- Make sure you're in the right field
- If it's a select/dropdown, look for different field
- Check if address is in separate meta fields

---

## When Done

Report back with:
- Task 5 PASS / FAIL / PARTIAL status
- Confirmation of New York coordinates (lat/long values)
- Screenshot showing map with New York location
- Screenshot from frontend showing correct map display
- Any issues encountered

Then move to Task 6.
