# Antigravity Comprehensive Testing Prompt
## Beards & Bucks Hunting Marketplace

**Purpose**: Thoroughly test all aspects of the Beards & Bucks platform using randomly-assigned personas and real-world user scenarios.

**Testing Date**: December 8, 2025
**Site URL**: https://beardsandbucks.com
**Objective**: Identify bugs, UX issues, broken features, and optimization opportunities

---

## 🎭 Persona Assignment System

For each test session, **randomly select ONE persona below**. This persona has a specific goal and agenda. Stay in character throughout the entire test. Document findings from that persona's perspective.

### Persona 1: **Sarah Chen - Serious Bowhunter Shopper**
- **Role**: Experienced bowhunter looking for used gear deals
- **Goal**: Find and purchase quality used compound bow equipment
- **Mindset**: Price-conscious, quality-focused, experienced with hunting
- **Concerns**: Authenticity of used gear, seller reputation, shipping safety
- **Test Focus**:
  - Browse marketplace for compound bows
  - Search and filter functionality
  - Seller ratings and review system
  - Product detail pages and specifications
  - Checkout process and payment
  - Account creation and order tracking
  - Message seller functionality
  - Product image quality and descriptions

### Persona 2: **Marcus Williams - Casual Visitor / Potential Outfitter**
- **Role**: Illinois hunter thinking about starting a guide service
- **Goal**: Research existing outfitters, understand the market, and explore vendor opportunities
- **Mindset**: Curious, skeptical, wants to understand pricing and requirements
- **Concerns**: Competition, setup costs, verification process
- **Test Focus**:
  - Listeo directory - browse all outfitters
  - Search by county/region functionality
  - Outfitter detail pages
  - Outfitter ratings and reviews
  - Contact/inquiry forms
  - Vendor signup or inquiry process
  - Pricing tier information
  - "Become a Vendor" call-to-action
  - Mobile responsiveness for research browsing

### Persona 3: **Jennifer Park - Budget-Conscious Beginner**
- **Role**: New to hunting, wants affordable gear and guidance
- **Goal**: Learn about hunting in Illinois, find cheap starter gear, get advice
- **Mindset**: Nervous, needs guidance, price-sensitive
- **Concerns**: Safety, legality, getting scammed, overwhelming complexity
- **Test Focus**:
  - Homepage clarity and navigation
  - Search for "beginner" or "starter" gear
  - Blog/educational content if available
  - FAQ pages and help sections
  - Contact forms for general inquiries
  - Simple browsing experience (not advanced features)
  - Mobile experience (assumed primary device)
  - Loading times and page performance
  - Clear call-to-action buttons

### Persona 4: **Tom Johnson - Frustrated Tech-Savvy User**
- **Role**: Experienced e-commerce shopper, expects professional functionality
- **Goal**: Quickly find and buy specific equipment with minimal friction
- **Mindset**: Impatient, detail-oriented, expects zero errors
- **Concerns**: Slow site, bad UX, missing features, broken links
- **Test Focus**:
  - Advanced filtering and sorting
  - Search result accuracy
  - Page load times (must be < 3 seconds)
  - Mobile responsiveness at 320px and 1440px
  - Missing images or broken assets
  - 404 errors or broken links
  - Form validation and error messages
  - Consistent branding and spacing
  - Cart functionality and checkout flow
  - Payment processing

### Persona 5: **Angela Martinez - Platform Administrator**
- **Role**: Site owner/manager monitoring platform health
- **Goal**: Ensure site operates correctly, all systems functional, security maintained
- **Mindset**: Systematic, detail-obsessed, wants comprehensive monitoring
- **Concerns**: Downtime, data integrity, spam, user complaints, revenue issues
- **Test Focus**:
  - Plugin functionality (Dokan, WooCommerce)
  - All pages load without errors
  - Form submissions work correctly
  - Payment gateway integration
  - User account creation process
  - Vendor account creation/management
  - Backend navigation (if accessible)
  - Email notifications
  - SEO meta tags (title, description, og:image)
  - Schema markup and structured data
  - Core Web Vitals
  - SSL certificate and security headers

### Persona 6: **Alex Rodriguez - Competitive Marketplace Seller**
- **Role**: Experienced seller with multiple listings
- **Goal**: Maximize sales, manage inventory, communicate with buyers
- **Mindset**: Entrepreneurial, wants professional selling tools
- **Concerns**: Low visibility, buyer communication, fees, shipping issues
- **Test Focus**:
  - Vendor signup and verification
  - Product listing creation
  - Product editing and bulk operations
  - Inventory management
  - Orders dashboard
  - Shipping label generation
  - Commission calculation
  - Analytics/sales reports
  - Dispute resolution system
  - Seller messaging system
  - Product promotion features
  - Bulk upload capabilities

### Persona 7: **David Thompson - Mobile-First User**
- **Role**: On-the-go hunter using primarily mobile
- **Goal**: Browse listings and make purchases from field or truck
- **Mindset**: Values speed and simplicity, needs clear touch targets
- **Concerns**: Slow mobile, hard to click, excessive scrolling, data usage
- **Test Focus**:
  - Mobile page speed (must load < 4 seconds)
  - Touch target sizes (minimum 44px)
  - Text readability on small screens
  - Image optimization for mobile
  - Hamburger menu and navigation
  - Mobile forms (easy input)
  - Checkout on mobile (one-handed use)
  - Mobile payment options (Apple Pay, Google Pay)
  - No horizontal scrolling
  - Tab/touch focus states

---

## 📋 Testing Checklist - Run All Tests for Assigned Persona

### Navigation & Basic Functionality
- [ ] **Homepage loads without errors** - Document load time
- [ ] **Main navigation works** - All links clickable and lead to correct pages
- [ ] **Search bar functions** - Can search for keywords, results relevant
- [ ] **Breadcrumbs work** (if present) - Show correct path
- [ ] **Footer links work** - All footer links are functional
- [ ] **Mobile menu works** - Hamburger opens/closes correctly
- [ ] **No 404 errors** - All pages accessible
- [ ] **All images load** - No missing/broken image icons

### Directory (Listeo) - If Applicable to Persona
- [ ] **Browse all listings** - Can view full list of outfitters/services
- [ ] **Search by category** - Filter by service type (outfitter, lodging, vendor)
- [ ] **Search by location** - Filter by county/region
- [ ] **Listing detail page** - Shows all relevant info (hours, services, ratings, contact)
- [ ] **Contact form works** - Can send inquiry message
- [ ] **Rating/review system** - Can read reviews, reviews display correctly
- [ ] **Map integration** - Map loads and shows location (if present)
- [ ] **Call button works** - (mobile) Can tap to call

### Marketplace (Dokan/WooCommerce) - If Applicable to Persona
- [ ] **Browse product categories** - All categories visible and clickable
- [ ] **Search products** - Search bar returns relevant results
- [ ] **Filter products** - Price range, condition, category, seller rating all work
- [ ] **Product detail page** - Shows images, specs, shipping, reviews
- [ ] **Product images** - Multiple images, zoom functionality works
- [ ] **Reviews section** - Can read reviews, review count accurate
- [ ] **Related products** - Shows similar items
- [ ] **Out of stock indication** - Clear when items unavailable
- [ ] **Add to cart** - Button works, cart updates
- [ ] **Quantity selector** - Can increase/decrease quantity
- [ ] **Wishlist/Save** - Can save items (if feature exists)
- [ ] **Share product** - Social sharing works (if present)

### User Account - If Applicable to Persona
- [ ] **Account creation** - Can register new account
- [ ] **Email verification** - Email verification process works
- [ ] **Login** - Can log in with credentials
- [ ] **Password reset** - Password reset process works
- [ ] **Profile editing** - Can update account information
- [ ] **Order history** - Can view past orders
- [ ] **Addresses** - Can save multiple addresses
- [ ] **Payment methods** - Can save payment info (securely)
- [ ] **Wishlists** - Can create/manage wishlists
- [ ] **Notification preferences** - Can control email/SMS preferences
- [ ] **Account deletion** - Can delete account (if applicable)
- [ ] **Logout** - Can log out cleanly

### Shopping Cart & Checkout - If Applicable to Persona
- [ ] **Cart displays correctly** - All items shown with correct prices
- [ ] **Quantity editing** - Can change quantities in cart
- [ ] **Item removal** - Can remove items from cart
- [ ] **Cart totals** - Subtotal, tax, shipping calculated correctly
- [ ] **Coupon/discount code** - Can apply codes (if applicable)
- [ ] **Shipping options** - Multiple options available, prices correct
- [ ] **Estimated delivery** - Shows realistic delivery timeframes
- [ ] **Checkout flow** - Single-page or multi-step, clear progression
- [ ] **Address entry** - Zip code lookup, address validation
- [ ] **Shipping address** - Can use different billing/shipping
- [ ] **Payment method selection** - Multiple payment options
- [ ] **Credit card form** - Fields clear, validation works
- [ ] **Order review** - Final review before purchase
- [ ] **Order confirmation** - Confirmation number shown, email sent
- [ ] **Order tracking** - Can track order after purchase

### Vendor/Seller Features - If Applicable to Persona
- [ ] **Vendor signup** - Registration process clear and secure
- [ ] **Vendor verification** - Verification method clear
- [ ] **Dashboard access** - Can log in to vendor dashboard
- [ ] **Product creation** - Can add new products
- [ ] **Bulk upload** - Can upload multiple products at once
- [ ] **Product editing** - Can modify product details
- [ ] **Inventory management** - Can track stock levels
- [ ] **Order management** - Can view and manage orders
- [ ] **Shipping integration** - Can generate shipping labels
- [ ] **Messages/support** - Can communicate with buyers
- [ ] **Analytics dashboard** - Can see sales, views, conversions
- [ ] **Payouts** - Commission calculation clear, payment method setup
- [ ] **Store customization** - Can customize seller storefront (if applicable)
- [ ] **Review management** - Can respond to reviews

### Performance & Technical
- [ ] **Page load time** - Measure and document (aim for <3 seconds)
- [ ] **Lighthouse score** - Run Chrome DevTools audit, document scores
- [ ] **No console errors** - Browser console clean (F12 → Console tab)
- [ ] **No JavaScript errors** - Site functions without JS errors
- [ ] **Mobile responsive** - Test at 375px, 768px, 1440px widths
- [ ] **Touch targets** - All clickable elements minimum 44px
- [ ] **Text readability** - No text too small or cut off
- [ ] **Forms usable** - Input fields accessible, labels clear
- [ ] **Videos/embeds** - All media loads and plays
- [ ] **Third-party scripts** - No slow external scripts blocking page

### Security & Privacy
- [ ] **HTTPS enabled** - All pages use HTTPS (green lock icon)
- [ ] **SSL certificate valid** - Certificate not expired
- [ ] **No mixed content** - No HTTP resources on HTTPS pages
- [ ] **Password fields secure** - Password input masked
- [ ] **Payment secure** - PCI DSS compliance (if applicable)
- [ ] **No exposed API keys** - Check network tab, no keys visible
- [ ] **GDPR compliance** - Privacy policy accessible
- [ ] **Cookie consent** - Cookie banner present (if required)
- [ ] **Spam protection** - Forms have captcha or equivalent
- [ ] **User data protection** - Clear privacy policy, data handling explained

### SEO & Metadata
- [ ] **Page title** - Unique, descriptive (visible in browser tab)
- [ ] **Meta description** - Present, under 160 characters
- [ ] **H1 heading** - Exactly one H1 per page
- [ ] **Header hierarchy** - H1 → H2 → H3 (logical structure)
- [ ] **Image alt text** - All images have descriptive alt text
- [ ] **Internal links** - Links use descriptive anchor text (not "click here")
- [ ] **Canonical tags** - Present on all pages
- [ ] **Structured data** - Schema.org markup present (check with JSON-LD)
- [ ] **Open Graph tags** - og:title, og:description, og:image present
- [ ] **Mobile viewport** - Viewport meta tag present and correct

### Accessibility
- [ ] **Color contrast** - Text contrast meets WCAG AA (4.5:1 minimum)
- [ ] **Keyboard navigation** - Can use Tab key to navigate
- [ ] **Focus indicators** - Can see which element has focus
- [ ] **Form labels** - All inputs have associated labels
- [ ] **Error messages** - Clear, associated with form fields
- [ ] **Alt text quality** - Descriptions are meaningful, not "image"
- [ ] **No autoplay** - Video/audio don't autoplay with sound
- [ ] **Readable fonts** - Sans-serif, minimum 14px, adequate line spacing
- [ ] **Links underlined** - Links visually distinct (color + underline or similar)
- [ ] **Screen reader friendly** - Semantic HTML used (nav, main, article, etc.)

### Brand & Design
- [ ] **Brand colors correct** - Verify primary/secondary colors match CLAUDE.md
- [ ] **Logo present** - Logo visible on header
- [ ] **Consistent spacing** - Consistent margins/padding throughout
- [ ] **Font consistency** - Same fonts used across site
- [ ] **Button styles** - Consistent button styling
- [ ] **Brand messaging** - Copy aligns with "premium outdoorsman" brand
- [ ] **No placeholder text** - All copy is final, no "Lorem ipsum"
- [ ] **Photography style** - Images match golden-hour, whitetail-focused aesthetic
- [ ] **Mobile spacing** - Proper spacing on small screens
- [ ] **Dark mode** - (If applicable) Dark mode works correctly

### Content Quality
- [ ] **Spelling & grammar** - No typos or grammatical errors
- [ ] **Outdated information** - All dates and info current
- [ ] **Contact info accurate** - Phone numbers, emails correct
- [ ] **Links working** - All internal/external links functional
- [ ] **Call-to-action clear** - Buttons have clear action text
- [ ] **Content organized** - Information easy to scan and find
- [ ] **No jargon** - Content accessible to beginners
- [ ] **Helpful descriptions** - Product/service descriptions detailed enough
- [ ] **FAQ relevant** - FAQ answers common questions
- [ ] **Contact available** - Multiple ways to reach support

---

## 📸 Screenshots & Evidence Required

For **each test**, capture screenshots of:

1. **Homepage** - Full page scroll screenshot
2. **Main features tested** - Each major feature gets before/after screenshots
3. **Error states** - Any errors encountered (404, form validation, etc.)
4. **Performance metrics** - Chrome DevTools Lighthouse report
5. **Mobile view** - Key pages at 375px width
6. **Forms submitted** - Confirmation screens
7. **Issues found** - Screenshots of any bugs or UX problems

**Naming convention**: `[PERSONA_INITIALS]_[FEATURE]_[TIMESTAMP].png`

Example: `SC_marketplace_search_2025_12_08_14_30.png`

---

## 📝 Reporting Format

For each test session, create a report using this structure:

```markdown
# Antigravity Test Report
## [Persona Name] - [Date]

### Persona Tested: [Full Persona Details]
- **Role**:
- **Goal**:
- **Testing Duration**: [Time spent]

### Overall Site Score: [X/100]

### Issues Found

#### Critical (Site Breaking)
- [ ] Issue #1
  - **Location**: [Page/Feature]
  - **Description**: [What's wrong]
  - **Steps to Reproduce**: [How to find it]
  - **Screenshot**: [filename]
  - **Impact**: [What happens to users]

#### High Priority (Functionality Broken)
- [ ] Issue #1
  - [Same format as above]

#### Medium Priority (Poor UX)
- [ ] Issue #1
  - [Same format as above]

#### Low Priority (Minor Issues)
- [ ] Issue #1
  - [Same format as above]

### Positive Findings (What Works Well)
- [Feature that works perfectly]
- [Another positive]

### Performance Results
- **Homepage Load Time**: [X seconds]
- **Average Page Load**: [X seconds]
- **Lighthouse Performance**: [X/100]
- **Lighthouse Accessibility**: [X/100]
- **Lighthouse Best Practices**: [X/100]
- **Lighthouse SEO**: [X/100]

### Browser/Device Tested
- **Browser**: [Chrome/Firefox/Safari]
- **OS**: [Windows/Mac/iOS/Android]
- **Device Type**: [Desktop/Tablet/Mobile]
- **Screen Width**: [pixels]

### Recommendations for Next Test
- [ ] Recommendation 1
- [ ] Recommendation 2

### Testing Checklist Complete
- [X] Navigation tested
- [X] Core features tested
- [X] Performance measured
- [X] Accessibility checked
- [X] Mobile tested
- [ ] (Other persona-specific items)

### Session Notes
[Any additional notes or observations]
```

---

## 🚀 How to Use This Prompt

### Step 1: Assign Random Persona
Roll a die or use random selection to pick Personas 1-7. This is your assigned role for the entire test session.

### Step 2: Read Persona Details
Carefully read your persona's role, goal, mindset, and concerns. **Stay in character throughout.**

### Step 3: Follow Testing Checklist
Go through the checklist systematically. For items applicable to your persona, perform the action and document:
- ✅ What works
- ❌ What doesn't work
- 🐛 Any bugs found
- 📸 Screenshot locations

### Step 4: Capture Screenshots
For every issue found or major feature tested, capture a screenshot. Use consistent naming.

### Step 5: Fill Report
After testing, complete the report template above with all findings.

### Step 6: Compile Results
Combine all persona test reports into a master "ANTIGRAVITY_TEST_RESULTS_2025_12_08.md" file.

---

## 💡 Tips for Thorough Testing

1. **Think like the persona** - If you're Sarah (bowhunter), what would frustrate you? What would delight you?
2. **Test on real mobile** - If possible, test on actual phone, not just browser resize
3. **Check DevTools** - Open F12 and check Console tab for JavaScript errors
4. **Test forms** - Submit forms with valid/invalid data to test validation
5. **Time yourself** - Note how long tasks take (users expect <3 seconds per action)
6. **Look for edge cases** - Out of stock items, expired products, edge prices
7. **Try to break it** - Rapid clicks, back button during checkout, etc.
8. **Compare to competitors** - How does this compare to Amazon, eBay, etc.?
9. **Document everything** - If it's wrong, screenshot it and describe it
10. **Be kind but honest** - Honest feedback helps improve the platform

---

## 📊 Success Metrics

The site is **ready for launch** when:
- ✅ **No Critical Issues** - No broken features or 404 errors
- ✅ **Load Times** - All pages load <3 seconds
- ✅ **Mobile Responsive** - Works well at 375px, 768px, 1440px
- ✅ **Accessibility** - No color contrast issues, keyboard navigable
- ✅ **Security** - HTTPS, no mixed content, forms secure
- ✅ **SEO** - All meta tags present, proper heading hierarchy
- ✅ **Forms Work** - All forms submit successfully
- ✅ **Checkout Complete** - Full purchase flow works
- ✅ **Mobile Performance** - <4 second load time on 3G
- ✅ **No JavaScript Errors** - Clean console (F12)

---

## 🎯 Final Deliverables

When all testing complete:
1. **Individual persona reports** (one per tester/persona)
2. **Master results file** - Combines all findings
3. **Screenshots folder** - All captured images organized
4. **Bug tracking spreadsheet** (optional) - CSV of all issues
5. **Video walkthrough** (if possible) - Screen recording of key workflows

---

**Generated**: December 8, 2025
**For**: Beards & Bucks Marketplace
**Testing Period**: [Ongoing]
**Last Updated**: December 8, 2025
