#!/bin/bash

# WordPress REST API Page Creation Script
# Creates "Add a Listing" page on beardsandbucks.com

# Configuration
WP_SITE_URL="https://beardsandbucks.com"
WP_USERNAME="jeff"
WP_APP_PASSWORD="kZt6TbW9y9VcZ0Otesk0wIPS"

# Page content (HTML with inline styles)
PAGE_CONTENT='<div class="listing-decision-page">
  <div class="page-header">
    <h1>Add a Listing to Beards & Bucks</h1>
    <p class="subtitle">Choose the option that'\''s right for you</p>
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
</style>'

# Create JSON payload
JSON_PAYLOAD=$(jq -n \
  --arg title "Add a Listing" \
  --arg slug "add-a-listing" \
  --arg content "$PAGE_CONTENT" \
  --arg status "draft" \
  '{
    title: $title,
    slug: $slug,
    content: $content,
    status: $status
  }')

# Make API request
echo "Creating page 'Add a Listing'..."
RESPONSE=$(curl -s -X POST "${WP_SITE_URL}/wp-json/wp/v2/pages" \
  -u "${WP_USERNAME}:${WP_APP_PASSWORD}" \
  -H "Content-Type: application/json" \
  -d "$JSON_PAYLOAD")

# Check if successful
if echo "$RESPONSE" | jq -e '.id' > /dev/null 2>&1; then
  PAGE_ID=$(echo "$RESPONSE" | jq -r '.id')
  PAGE_URL=$(echo "$RESPONSE" | jq -r '.link')

  echo ""
  echo "✓ Page created successfully!"
  echo "  Page ID: $PAGE_ID"
  echo "  Page URL: $PAGE_URL"
  echo "  Status: draft"
  echo ""
  echo "You can now edit this page in Elementor before publishing."
else
  echo ""
  echo "✗ Failed to create page. Error response:"
  echo "$RESPONSE" | jq .
  echo ""
  echo "TROUBLESHOOTING:"
  echo "1. Verify the application password is correct in WordPress admin"
  echo "2. Ensure the user 'jeff' has page creation permissions"
  echo "3. Check that Application Passwords are enabled in WordPress"
fi
