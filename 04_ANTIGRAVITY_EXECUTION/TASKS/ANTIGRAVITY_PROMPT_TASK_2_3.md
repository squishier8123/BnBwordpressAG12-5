# ANTIGRAVITY EXECUTION PROMPT - TASKS 2 & 3
## Create Privacy Policy & Terms of Service Pages

**Status:** Ready for Execution
**Priority:** CRITICAL (both legal requirement + footer broken)
**Estimated Time:** 20 minutes
**Browser Automation Required:** YES
**Can Execute In Parallel:** YES (both can be done simultaneously)

---

## Your Mission

Create two new WordPress pages (Privacy Policy and Terms of Service) with reasonable content, publish them, and link them in the footer widget so they're accessible to visitors.

**Current State:** Footer shows "Privacy Policy" and "Terms & Conditions" links that don't work (pages don't exist).
**Desired State:** Both pages exist, are published, and footer links point to them correctly.

---

## TASK 2: Create Privacy Policy Page

### Step 1: Navigate to Pages
1. Go to: `https://beardsandbucks.com/wp-admin`
2. Make sure you're logged in
3. In the left sidebar, find "Pages" (or "All Pages")
4. Click on it
5. Wait for page to load
6. Take screenshot labeled: `task_2_01_pages_list.png`

### Step 2: Create New Page
1. Click the "Add New" button (usually at top or near "Pages" menu item)
2. Or use direct URL: `https://beardsandbucks.com/wp-admin/post-new.php?post_type=page`
3. Wait for page editor to load
4. Take screenshot labeled: `task_2_02_new_page_editor_open.png`

### Step 3: Set Page Title
1. Find the title field (usually at the top, where it says "Add title")
2. Click in the title field
3. Type: `Privacy Policy`
4. Take screenshot labeled: `task_2_03_title_entered.png`

### Step 4: Set Page Slug (URL)
1. Look for "Slug" or "Permalink" section (usually below title or in right sidebar)
2. Click on the slug field
3. Clear existing content
4. Type: `privacy-policy`
5. This ensures the page URL will be: `/privacy-policy/`
6. Take screenshot labeled: `task_2_04_slug_set.png`

### Step 5: Add Page Content
1. Find the main content editor area (large text box for page content)
2. Click in the content area
3. Paste or type the following Privacy Policy template:

```
Privacy Policy

Last Updated: December 6, 2025

1. Introduction

This Privacy Policy explains how Beards & Bucks collects, uses, and protects your personal information when you use our website and services.

2. Information We Collect

We collect information you voluntarily provide when you:
- Create an account
- Complete a listing
- Contact a vendor
- Subscribe to our newsletter

3. How We Use Your Information

We use your information to:
- Provide and improve our services
- Send you updates and notifications
- Respond to your inquiries
- Protect against fraud and abuse

4. Data Protection

We implement appropriate security measures to protect your personal information. However, no method of transmission over the internet is completely secure.

5. Your Rights

You have the right to:
- Access your personal data
- Correct inaccurate information
- Request deletion of your data
- Object to certain processing

6. Contact Us

If you have questions about this Privacy Policy, please contact us at:
Email: privacy@beardsandbucks.com

7. Changes to This Policy

We may update this Privacy Policy periodically. We encourage you to review this policy regularly for any changes.
```

4. After pasting content, take screenshot labeled: `task_2_05_content_added.png`

### Step 6: Publish the Page
1. Look for the "Publish" button (usually right side of screen or at bottom)
2. Make sure page status is set to "Published" (not Draft)
3. Click "Publish" button
4. Wait for confirmation message
5. Take screenshot labeled: `task_2_06_page_published.png`

### Step 7: Verify Page URL
1. After publishing, look for the page URL/permalink
2. Should be: `https://beardsandbucks.com/privacy-policy/`
3. Copy that URL
4. Navigate to it in a new tab/window
5. Verify the page loads with your content
6. Take screenshot labeled: `task_2_07_privacy_policy_page_visible.png`

---

## TASK 3: Create Terms of Service Page

### Step 1: Create New Page
1. Go back to: `https://beardsandbucks.com/wp-admin`
2. Click "Pages" → "Add New"
3. Or use: `https://beardsandbucks.com/wp-admin/post-new.php?post_type=page`
4. Wait for editor to load
5. Take screenshot labeled: `task_3_01_new_page_editor.png`

### Step 2: Set Page Title
1. Click in the title field
2. Type: `Terms of Service`
3. Take screenshot labeled: `task_3_02_title_entered.png`

### Step 3: Set Page Slug
1. Find the slug field
2. Clear it
3. Type: `terms-of-service`
4. Ensures URL: `/terms-of-service/`
5. Take screenshot labeled: `task_3_03_slug_set.png`

### Step 4: Add Page Content
1. Click in the content editor
2. Paste or type the following Terms of Service template:

```
Terms of Service

Last Updated: December 6, 2025

1. Acceptance of Terms

By using this website, you agree to comply with and be bound by these Terms of Service.

2. Use License

Permission is granted to temporarily download one copy of the materials for personal, non-commercial transitory viewing only. This is the grant of a license, not a transfer of title.

3. Disclaimer

The materials on our website are provided on an "as is" basis. We make no warranties, expressed or implied, and hereby disclaim and negate all other warranties including, without limitation, implied warranties or conditions of merchantability, fitness for a particular purpose, or non-infringement of intellectual property or other violation of rights.

4. Limitations

In no event shall Beards & Bucks or its suppliers be liable for any damages (including, without limitation, damages for loss of data or profit, or due to business interruption) arising out of the use or inability to use the materials on this website.

5. Accuracy of Materials

The materials appearing on our website could include technical, typographical, or photographic errors. We do not warrant that any of the materials are accurate, complete, or current.

6. Links

We have not reviewed all of the sites linked to our website and are not responsible for the contents of any such linked site. The inclusion of any link does not imply endorsement by us of the site. Use of any such linked website is at the user's own risk.

7. Modifications

We may revise these Terms of Service at any time without notice. By using this website, you are agreeing to be bound by the then current version of these Terms of Service.

8. User Conduct

You agree not to:
- Harass, threaten, or abuse other users
- Post illegal or copyrighted content
- Attempt to gain unauthorized access
- Interfere with site operations

9. Governing Law

These terms and conditions are governed by and construed in accordance with the laws of the United States.

10. Contact

If you have questions about these Terms of Service, please contact us at:
Email: legal@beardsandbucks.com
```

2. After pasting, take screenshot labeled: `task_3_04_content_added.png`

### Step 5: Publish the Page
1. Click "Publish" button
2. Make sure status is "Published"
3. Wait for confirmation
4. Take screenshot labeled: `task_3_05_page_published.png`

### Step 6: Verify Page URL
1. After publishing, get the page URL
2. Should be: `https://beardsandbucks.com/terms-of-service/`
3. Copy that URL
4. Navigate to it in a new tab
5. Verify page loads with content
6. Take screenshot labeled: `task_3_06_terms_page_visible.png`

---

## TASK 2.5: Add Links to Footer Widget

**Do this after BOTH pages are created and published.**

### Step 1: Navigate to Widgets
1. Go to: `https://beardsandbucks.com/wp-admin`
2. In left sidebar, find "Appearance" → "Widgets"
3. Click on "Widgets"
4. Wait for widgets page to load
5. Take screenshot labeled: `task_2_5_01_widgets_page.png`

### Step 2: Find Footer Widget
Look for a widget area named:
- "Footer" or
- "Footer 1st Column" or
- "Footer Column 1" or
- "Footer Widgets" or
- Similar

1. Find the footer widget area
2. Look inside for an existing text widget or custom HTML widget
3. Or look for where the "Privacy Policy" and "Terms" text might be
4. Take screenshot labeled: `task_2_5_02_footer_widget_found.png`

### Step 3: Edit Footer Widget (Method A: Existing Widget)
**If there's already a text/custom HTML widget with links:**

1. Click to edit that widget
2. Look for the existing links in the content
3. Find where it says "Privacy" or similar
4. Update the link to point to `/privacy-policy/`
5. Find where it says "Terms" or similar
6. Update the link to point to `/terms-of-service/`
7. Example format:
```html
<ul>
  <li><a href="/privacy-policy/">Privacy Policy</a></li>
  <li><a href="/terms-of-service/">Terms & Conditions</a></li>
</ul>
```
8. Click Save
9. Take screenshot labeled: `task_2_5_03_footer_widget_updated.png`

### Step 3: Edit Footer Widget (Method B: Create New Widget)
**If there's no existing footer widget:**

1. Click "Add a New Widget" or similar button
2. Select "Text" or "Custom HTML" widget
3. In the widget content area, enter:
```html
<ul>
  <li><a href="/privacy-policy/">Privacy Policy</a></li>
  <li><a href="/terms-of-service/">Terms & Conditions</a></li>
</ul>
```
4. Set widget title (optional): "Legal" or "Footer Links"
5. Choose display area: "Footer" or "Footer Column 1" (whichever exists)
6. Click Save
7. Take screenshot labeled: `task_2_5_03_footer_widget_created.png`

### Step 4: Verify Links on Frontend
1. Navigate to: `https://beardsandbucks.com/`
2. Scroll to the footer
3. Look for "Privacy Policy" and "Terms & Conditions" links
4. Click on "Privacy Policy" link
5. Verify it loads the Privacy Policy page
6. Go back
7. Click on "Terms & Conditions" link
8. Verify it loads the Terms of Service page
9. Take screenshot labeled: `task_2_5_04_footer_links_working.png` (showing both links visible)
10. Take screenshot labeled: `task_2_5_05_privacy_link_clicked.png` (showing page loaded)

---

## Success Criteria - ALL Must Be True

**Task 2 (Privacy Policy):**
- [ ] Page created with title "Privacy Policy"
- [ ] Page slug is "privacy-policy"
- [ ] Page is Published
- [ ] Page loads at `/privacy-policy/`
- [ ] Page contains reasonable privacy policy content
- [ ] URL accessible from frontend

**Task 3 (Terms of Service):**
- [ ] Page created with title "Terms of Service"
- [ ] Page slug is "terms-of-service"
- [ ] Page is Published
- [ ] Page loads at `/terms-of-service/`
- [ ] Page contains reasonable terms content
- [ ] URL accessible from frontend

**Footer Links:**
- [ ] Footer widget updated with links
- [ ] Privacy Policy link visible in footer
- [ ] Terms & Conditions link visible in footer
- [ ] Both links are clickable
- [ ] Both links point to correct pages
- [ ] Both pages load when links clicked

---

## Documentation to Provide

When complete, provide:
1. All screenshots listed above (at least 13 total)
2. Final status: PASS / FAIL / PARTIAL
3. URLs of both pages (confirm they work)
4. Screenshot showing both links visible in footer
5. Any issues encountered

---

## Troubleshooting

**Problem: Can't find Widgets area**
- Go directly to: `https://beardsandbucks.com/wp-admin/widgets.php`

**Problem: No footer widget exists**
- Create a new one (Method B)
- Choose the footer area when adding widget

**Problem: Links don't work after adding**
- Clear browser cache
- Hard refresh (Ctrl+Shift+R)
- Check URL format in widget (should be `/privacy-policy/` not `privacy-policy`)

**Problem: Widget not showing on frontend**
- Check if widget is assigned to correct area (Footer, not Sidebar)
- Check theme footer template to confirm widget area displays widgets

---

## When Done

Report back with:
- Task 2 PASS / FAIL / PARTIAL status
- Task 3 PASS / FAIL / PARTIAL status
- Footer links status: WORKING / NOT WORKING
- All screenshots
- Any issues encountered

Then move to Task 4.
