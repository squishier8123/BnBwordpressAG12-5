# WordPress Site Editing Quick Start
**Beards & Bucks (beardsandbucks.com)**

---

## TL;DR - Get Started Now

**To edit a page using REST API:**
```bash
# Get page content
curl -s "https://beardsandbucks.com/wp-json/wp/v2/pages/4664" \
  -H "Authorization: Basic $(echo -n 'jeff:kZt6TbW9y9VcZ0Otesk0wIPS' | base64)" | jq .content.rendered

# Update page content
curl -X POST "https://beardsandbucks.com/wp-json/wp/v2/pages/4664" \
  -H "Authorization: Basic $(echo -n 'jeff:kZt6TbW9y9VcZ0Otesk0wIPS' | base64)" \
  -H "Content-Type: application/json" \
  -d '{"content":"<div>New content</div>"}'
```

---

## Site Overview

| Attribute | Value |
|-----------|-------|
| **URL** | https://beardsandbucks.com |
| **Admin Username** | jeff |
| **Admin Password** | kZt6TbW9y9VcZ0Otesk0wIPS |
| **API Base URL** | https://beardsandbucks.com/wp-json/wp/v2 |
| **Authentication Type** | HTTP Basic Auth |
| **Page Builder** | None (Custom HTML/CSS) |
| **Total Pages** | 27 |
| **Design System** | Inline-styled divs with custom CSS |

---

## Available Pages (Quick Reference)

| ID | Page Name | Purpose |
|----|-----------|---------|
| 4370 | Home 3 | Homepage alternative |
| 4664 | Why Choose Beards & Bucks | Value proposition |
| 4663 | Popular Categories | Category showcase |
| 4662 | How It Works | Process explanation |
| 4620 | Join Beards & Bucks | Sign up info |
| 4619 | About Us | Company info |
| 4092 | Contact | Contact page |
| 4192 | Vendors | Vendor directory |
| 4638 | My Dashboard | User dashboard |
| 4622 | Register as Vendor | Vendor registration |
| 4621 | Register as Buyer | Buyer registration |

*For complete page list, see: `WORDPRESS_MCP_DEBUGGING_REPORT_2025_12_06.md`*

---

## Method 1: REST API (Recommended)

### Setup
No setup needed - REST API is already active!

### Get Page Content
```bash
PAGEID=4664
curl -s "https://beardsandbucks.com/wp-json/wp/v2/pages/$PAGEID" \
  -H "Authorization: Basic $(echo -n 'jeff:kZt6TbW9y9VcZ0Otesk0wIPS' | base64)" \
  | jq '.' > page_content.json
```

### View Page HTML Only
```bash
curl -s "https://beardsandbucks.com/wp-json/wp/v2/pages/4664" \
  -H "Authorization: Basic $(echo -n 'jeff:kZt6TbW9y9VcZ0Otesk0wIPS' | base64)" \
  | jq -r '.content.rendered'
```

### Update Page
```bash
curl -X POST "https://beardsandbucks.com/wp-json/wp/v2/pages/4664" \
  -H "Authorization: Basic $(echo -n 'jeff:kZt6TbW9y9VcZ0Otesk0wIPS' | base64)" \
  -H "Content-Type: application/json" \
  -d '{
    "content": "<div style=\"color: red;\">Updated content</div>",
    "title": "New Title (optional)",
    "status": "publish"
  }'
```

### Create New Page
```bash
curl -X POST "https://beardsandbucks.com/wp-json/wp/v2/pages" \
  -H "Authorization: Basic $(echo -n 'jeff:kZt6TbW9y9VcZ0Otesk0wIPS' | base64)" \
  -H "Content-Type: application/json" \
  -d '{
    "title": "My New Page",
    "content": "<div style=\"padding: 20px;\">Page content here</div>",
    "status": "draft"
  }'
```

### Pros & Cons
✅ **Pros:**
- Full control over HTML/CSS
- No page builder limitations
- Direct API access
- Works with any tool (curl, Python, JavaScript, etc.)

❌ **Cons:**
- No visual preview
- Requires HTML/CSS knowledge
- Raw API responses (need parsing)

---

## Method 2: WordPress MCP (with patch)

### Setup
First, apply the patch:
```bash
bash mcp-server-wordpress/patch-respira.sh
```

### Use with Claude Code
```bash
claude mcp list  # Should show wordpress as available
```

### Available Tools
- `wordpress_get_site_context` - Get site info
- `wordpress_list_pages` - List all pages
- `wordpress_read_page` - Get page content
- `wordpress_update_page` - Update page
- And many more...

### Pros & Cons
✅ **Pros:**
- Integrated with Claude Code
- Tool-based interface
- Better for automation

❌ **Cons:**
- Requires patch application
- Patch must be reapplied for new npx instances
- Less direct control than REST API

---

## Understanding Your Page Structure

### Custom HTML/CSS Format
Your pages use inline-styled HTML divs, not a page builder. Example:

```html
<div style="padding: 40px 20px; max-width: 1000px; margin: 0 auto;">
  <h2 style="color: #FFFFFF; font-size: 2.5rem; text-align: center;">
    Page Title
  </h2>

  <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px;">
    <div style="background: #2A2A2A; padding: 30px; border: 2px solid #E85D2D;">
      <h3 style="color: #E85D2D; font-size: 1.3rem;">Feature</h3>
      <p style="color: #E8E8E8;">Description</p>
    </div>
  </div>
</div>
```

### Key Features
- **No external stylesheets** - All CSS is inline
- **Responsive design** - Uses CSS Grid and Flexbox
- **Dark theme** - Dark backgrounds (#2A2A2A) with orange accents (#E85D2D)
- **Semantic HTML** - Proper heading hierarchy

### Color Scheme Reference
| Color | Hex | Usage |
|-------|-----|-------|
| Dark BG | #2A2A2A | Container backgrounds |
| Light Text | #F5F5F5 | Body text |
| Subtle Text | #E8E8E8 | Secondary text |
| Accent Orange | #E85D2D | Highlights and borders |
| White | #FFFFFF | Headings |

---

## Common Tasks

### Task: Change Text on a Page
1. Get the page: `curl ... | jq '.content.rendered'`
2. Edit the HTML text
3. Update: `curl -X POST ... -d '{"content": "..."}'`

### Task: Change Colors
Find the style attributes and modify the hex values:
```html
<!-- Change this -->
<h2 style="color: #FFFFFF;">Title</h2>

<!-- To this -->
<h2 style="color: #FF6600;">Title</h2>
```

### Task: Add New Section
Copy the pattern of existing sections and add inside the main container:

```html
<div style="padding: 40px 20px; max-width: 1000px; margin: 0 auto;">
  <!-- Existing content -->

  <!-- New section -->
  <div style="background: #2A2A2A; padding: 30px; margin-top: 40px;">
    <h2 style="color: #E85D2D;">New Section</h2>
    <p style="color: #E8E8E8;">Your content here</p>
  </div>
</div>
```

### Task: Create Two-Column Layout
```html
<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px;">
  <div style="background: #2A2A2A; padding: 30px;">
    <h3>Column 1</h3>
    <p>Content</p>
  </div>
  <div style="background: #2A2A2A; padding: 30px;">
    <h3>Column 2</h3>
    <p>Content</p>
  </div>
</div>
```

### Task: Change Page Title
Update the `<h2>` tag at the top of the main container.

### Task: Publish Draft Page
Update with `"status": "publish"` in the request body.

---

## Best Practices

### 1. Always Get Current Content First
Don't overwrite without knowing what you're replacing:
```bash
curl "https://beardsandbucks.com/wp-json/wp/v2/pages/4664" \
  -H "Authorization: Basic ..." | jq -r '.content.rendered' > current.html
```

### 2. Test Changes Locally
Edit the HTML in a local editor, test in a browser, then upload:
```bash
cat current.html  # Edit this file
curl -X POST ... -d "{\"content\": \"$(cat current.html | jq -R -s .)\"}"
```

### 3. Keep Styling Consistent
- Use the established color scheme
- Match padding/margin patterns
- Maintain responsive grid layout

### 4. Save Backups
Before making major changes:
```bash
curl "https://beardsandbucks.com/wp-json/wp/v2/pages/4664" \
  -H "Authorization: Basic ..." > backup_4664_$(date +%Y%m%d).json
```

### 5. Use Git to Track Changes
```bash
git add -A
git commit -m "Update page 4664: [description of changes]"
```

---

## Troubleshooting

### "Invalid username. Check again or try your email address."
Make sure you're using the correct credentials:
- Username: `jeff` (not `geoff`)
- Password: `kZt6TbW9y9VcZ0Otesk0wIPS`

### "No route was found matching the URL"
The MCP is trying to use Respira API endpoints which don't exist. Use REST API instead or apply the patch first.

### "401 Unauthorized"
Make sure the Authorization header is properly formatted:
```bash
echo -n 'jeff:kZt6TbW9y9VcZ0Otesk0wIPS' | base64
# Should output something like: amVmZjprWnQ2VGJXOXk5VmNaME90ZXNrMHdJUFM=
```

### Changes Don't Appear on Site
- Make sure status is set to `"publish"`, not `"draft"`
- Clear browser cache
- Check the WordPress admin to verify update took

---

## Design Creativity Assessment

### Your Setup Allows:
✅ Complete HTML/CSS control
✅ Custom JavaScript injection
✅ Advanced CSS Grid/Flexbox layouts
✅ Custom animations and transitions
✅ API integrations via custom code
✅ Responsive design at any breakpoint

### Compared to Page Builders:
- **More creative freedom** than Elementor/Divi
- **Less UI drag-and-drop** convenience
- **Maximum code control**
- **Best for developers** comfortable with HTML/CSS

---

## Next Steps

1. **Choose a page to edit** - Pick from the list above
2. **Get the current content** - Use the curl commands
3. **Make your changes** - Edit the HTML/CSS
4. **Test locally** - View in a browser
5. **Upload changes** - Use the update command
6. **Verify on site** - Check https://beardsandbucks.com

---

## Additional Resources

- **Full MCP Report**: `docs/WORDPRESS_MCP_DEBUGGING_REPORT_2025_12_06.md`
- **WordPress REST API Docs**: https://developer.wordpress.org/rest-api/
- **HTML Reference**: https://developer.mozilla.org/en-US/docs/Web/HTML
- **CSS Reference**: https://developer.mozilla.org/en-US/docs/Web/CSS

---

**Last Updated:** 2025-12-06
**Status:** Ready to Edit
