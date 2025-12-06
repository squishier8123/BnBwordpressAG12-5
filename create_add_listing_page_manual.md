# Manual Instructions: Create "Add a Listing" Page

## Authentication Issue
The WordPress REST API authentication is currently failing. This could be due to:
1. Application Passwords not being enabled on the WordPress site
2. The application password needs to be regenerated
3. The user account lacks necessary permissions

## Option 1: Fix REST API Authentication (Recommended)

### Generate New Application Password
1. Log into WordPress admin at https://beardsandbucks.com/wp-admin
2. Go to Users > Profile (or edit user 'jeff')
3. Scroll down to "Application Passwords" section
4. Generate a new application password with name "REST API Access"
5. Copy the generated password (it will be in format: `xxxx xxxx xxxx xxxx xxxx xxxx`)
6. Update the `.env` file with the new password (remove spaces)
7. Run the script: `bash create_add_listing_page.sh`

### Verify Permissions
Ensure the user 'jeff' has administrator or editor role with page creation permissions.

## Option 2: Create Page Manually via WordPress Admin

If REST API continues to fail, create the page manually:

### Steps:
1. Log into WordPress admin: https://beardsandbucks.com/wp-admin
2. Go to Pages > Add New
3. Set Page Title: **Add a Listing**
4. Set Page Slug: **add-a-listing** (in permalink settings)
5. Switch to "Code Editor" or "Text" mode (not Visual)
6. Paste the HTML content below
7. Save as Draft
8. Note the Page ID and URL

### HTML Content to Paste:

```html
<div class="listing-decision-page">
  <div class="page-header">
    <h1>Add a Listing to Beards & Bucks</h1>
    <p class="subtitle">Choose the option that's right for you</p>
  </div>

  <div class="decision-cards-container">

    <div class="decision-card individual-listing">
      <div class="card-icon">📋</div>
      <h2>List a Single Item</h2>
      <p class="card-description">Perfect for selling one piece of used hunting gear or equipment without creating a vendor account.</p>

      <ul class="card-benefits">
        <li>No vendor account needed</li>
        <li>Quick and easy submission</li>
        <li>Perfect for one-time sellers</li>
        <li>Multiple pricing options available</li>
      </ul>

      <a href="https://beardsandbucks.com/list-your-gear-8/" class="btn btn-primary">List Your Gear</a>
    </div>

    <div class="decision-card vendor-listing">
      <div class="card-icon">🏪</div>
      <h2>Become a Vendor</h2>
      <p class="card-description">Perfect for businesses and experienced sellers who want to manage multiple products and build a professional store.</p>

      <ul class="card-benefits">
        <li>Professional vendor store</li>
        <li>Manage multiple products</li>
        <li>Build your brand presence</li>
        <li>Access to vendor dashboard</li>
      </ul>

      <a href="https://beardsandbucks.com/register-as-vendor/" class="btn btn-primary">Register as Vendor</a>
    </div>
  </div>

  <div class="existing-vendor-section">
    <p class="existing-vendor-text">Already have a vendor account?
      <a href="https://beardsandbucks.com/vendor-dashboard/" class="login-link">Login to your vendor dashboard</a>
    </p>
  </div>
</div>

<style>
.listing-decision-page {
  padding: 40px 20px;
  max-width: 1200px;
  margin: 0 auto;
}

.page-header {
  text-align: center;
  margin-bottom: 50px;
}

.page-header h1 {
  font-size: 2.5rem;
  margin-bottom: 10px;
  color: #333;
}

.page-header .subtitle {
  font-size: 1.2rem;
  color: #666;
}

.decision-cards-container {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
  gap: 30px;
  margin-bottom: 50px;
}

.decision-card {
  border: 2px solid #e0e0e0;
  border-radius: 8px;
  padding: 30px;
  text-align: center;
  transition: all 0.3s ease;
}

.decision-card:hover {
  border-color: #cc6633;
  box-shadow: 0 5px 20px rgba(0,0,0,0.1);
}

.card-icon {
  font-size: 3rem;
  margin-bottom: 15px;
}

.decision-card h2 {
  font-size: 1.5rem;
  margin-bottom: 15px;
  color: #333;
}

.card-description {
  color: #666;
  margin-bottom: 20px;
  line-height: 1.6;
}

.card-benefits {
  text-align: left;
  margin: 20px 0;
  padding-left: 20px;
  list-style-position: inside;
}

.card-benefits li {
  margin-bottom: 8px;
  color: #555;
}

.btn {
  display: inline-block;
  padding: 12px 30px;
  border-radius: 4px;
  text-decoration: none;
  font-weight: bold;
  transition: all 0.3s ease;
  margin-top: 15px;
}

.btn-primary {
  background-color: #cc6633;
  color: white;
}

.btn-primary:hover {
  background-color: #b8551f;
}

.existing-vendor-section {
  text-align: center;
  padding: 20px;
  background-color: #f5f5f5;
  border-radius: 4px;
}

.existing-vendor-text {
  color: #555;
  font-size: 1rem;
}

.login-link {
  color: #cc6633;
  text-decoration: none;
  font-weight: bold;
}

.login-link:hover {
  text-decoration: underline;
}

@media (max-width: 768px) {
  .page-header h1 {
    font-size: 1.8rem;
  }

  .decision-cards-container {
    grid-template-columns: 1fr;
  }
}
</style>
```

## After Creating the Page

Once the page is created (via API or manually):

1. **Note the Page ID and URL**
   - Page ID can be found in the URL when editing: `post.php?post=XXX&action=edit`
   - URL will be: `https://beardsandbucks.com/add-a-listing/`

2. **Edit in Elementor**
   - Click "Edit with Elementor" button
   - Customize the design as needed
   - Publish when ready

3. **Update Navigation**
   - Add link to homepage navigation menu
   - Use URL: `https://beardsandbucks.com/add-a-listing/`
   - Link text: "Add a Listing" or "Sell Your Gear"

## REST API Troubleshooting

If you want to fix the REST API for future use:

1. **Check Application Passwords Plugin**
   - Go to Plugins in WordPress admin
   - Ensure "Application Passwords" is enabled (built into WP 5.6+)

2. **Verify User Role**
   - User 'jeff' needs Administrator or Editor role
   - Check: Users > All Users > Edit jeff

3. **Test Authentication**
   ```bash
   curl -u "jeff:YOUR_APP_PASSWORD" https://beardsandbucks.com/wp-json/wp/v2/users/me
   ```
   Should return user details, not an error

4. **Check .htaccess**
   - Some servers block Authorization headers
   - May need to add: `SetEnvIf Authorization "(.*)" HTTP_AUTHORIZATION=$1`
