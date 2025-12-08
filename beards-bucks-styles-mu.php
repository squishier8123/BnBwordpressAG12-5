<?php
/**
 * Beards & Bucks Brand Styles
 * Must-use plugin for applying brand CSS
 *
 * This file should be copied to: /wp-content/mu-plugins/beards-bucks-styles-mu.php
 */

// Inject custom CSS into WordPress head
add_action('wp_head', function() {
    ?>
<style type="text/css">
/* ============================================================================
   BEARDS & BUCKS - BRAND COLORS & INTERACTIVE EFFECTS
   ============================================================================ */

:root {
  --bb-deep-brown: #582F0E;
  --bb-rich-brown: #7F4F24;
  --bb-medium-brown: #936639;
  --bb-tan-light: #B6AD90;
  --bb-tan-medium: #A68A64;
  --bb-cream: #C2C5AA;
  --bb-sage-light: #A4AC86;
  --bb-sage-medium: #656D4A;
  --bb-sage-dark: #414833;
  --bb-dark-green: #333D29;
  --bb-white: #ffffff;
  --bb-black: #1a1a1a;
  --bb-dark-bg: #212121;
  --bb-shadow-sm: 0 2px 4px rgba(88, 47, 14, 0.12);
  --bb-shadow-md: 0 4px 12px rgba(88, 47, 14, 0.18);
  --bb-shadow-lg: 0 8px 24px rgba(88, 47, 14, 0.25);
  --bb-shadow-xl: 0 12px 32px rgba(88, 47, 14, 0.3);
  --bb-glow: 0 0 20px rgba(164, 172, 134, 0.4);
}

.card, .listing-item-container, .product-card, .feature-card, .elementor-widget-container, .et_pb_blurb, .et_pb_testimonial, .et_pb_pricing, div[class*="card"], div[class*="box"] {
  background-color: var(--bb-white) !important;
  border: 1px solid #e8e8e8 !important;
  border-radius: 8px !important;
  box-shadow: var(--bb-shadow-sm) !important;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
  overflow: hidden;
}

.card:hover, .listing-item-container:hover, .product-card:hover, .feature-card:hover, .et_pb_blurb:hover, .et_pb_testimonial:hover, .et_pb_pricing:hover, div[class*="card"]:hover {
  box-shadow: var(--bb-shadow-lg) !important;
  border-color: var(--bb-sage-light) !important;
  transform: translateY(-6px) !important;
}

button, a.button, input[type="submit"], input[type="button"], .btn, .wp-block-button__link, .et_pb_button, a[class*="button"], a[class*="btn"] {
  position: relative;
  overflow: hidden;
  box-shadow: var(--bb-shadow-md) !important;
  transition: all 0.3s ease !important;
  text-transform: uppercase !important;
  letter-spacing: 0.5px !important;
  font-weight: 600 !important;
}

button:not(.orange):not([class*="secondary"]), a.button:not(.orange), input[type="submit"]:not(.orange), .btn:not(.orange), .wp-block-button__link, .et_pb_button {
  background-color: var(--bb-rich-brown) !important;
  color: var(--bb-white) !important;
  border: none !important;
}

button:not(.orange):not([class*="secondary"]):hover, a.button:not(.orange):hover, input[type="submit"]:not(.orange):hover, .btn:not(.orange):hover, .wp-block-button__link:hover, .et_pb_button:hover {
  background-color: var(--bb-deep-brown) !important;
  box-shadow: var(--bb-shadow-xl), var(--bb-glow) !important;
  transform: translateY(-3px) !important;
}

button.orange, a.button.orange, input[type="submit"].orange, .btn.orange {
  background-color: #E69500 !important;
  color: var(--bb-black) !important;
  box-shadow: var(--bb-shadow-md) !important;
}

button.orange:hover, a.button.orange:hover, input[type="submit"].orange:hover, .btn.orange:hover {
  background-color: #D68400 !important;
  box-shadow: var(--bb-shadow-xl) !important;
  transform: translateY(-3px) !important;
}

header, #header, nav.main-navigation, #navigation {
  background-color: var(--bb-dark-green) !important;
  box-shadow: var(--bb-shadow-md) !important;
}

header a, #header a, nav.main-navigation a, #navigation a {
  color: var(--bb-cream) !important;
  transition: color 0.2s ease, text-shadow 0.2s ease;
}

header a:hover, #header a:hover, nav.main-navigation a:hover, #navigation a:hover {
  color: var(--bb-sage-light) !important;
  text-shadow: 0 0 8px rgba(164, 172, 134, 0.3);
}

input[type="text"], input[type="email"], input[type="password"], input[type="search"], input[type="number"], input[type="tel"], textarea, select {
  background-color: var(--bb-white) !important;
  border: 1px solid #ddd !important;
  color: var(--bb-black) !important;
  box-shadow: var(--bb-shadow-sm) !important;
  transition: all 0.2s ease !important;
  border-radius: 4px !important;
}

input[type="text"]:focus, input[type="email"]:focus, input[type="password"]:focus, input[type="search"]:focus, input[type="number"]:focus, input[type="tel"]:focus, textarea:focus, select:focus {
  border-color: var(--bb-sage-light) !important;
  box-shadow: var(--bb-shadow-md), inset 0 0 0 2px rgba(164, 172, 134, 0.1) !important;
  outline: none !important;
}

.price, .listing-price, .product-price, .rate-display {
  background: linear-gradient(135deg, var(--bb-deep-brown) 0%, var(--bb-rich-brown) 100%) !important;
  color: var(--bb-cream) !important;
  padding: 8px 16px !important;
  border-radius: 4px !important;
  font-weight: 700 !important;
  font-size: 16px !important;
  box-shadow: var(--bb-shadow-lg) !important;
  display: inline-block !important;
}

.price:hover, .listing-price:hover {
  box-shadow: var(--bb-shadow-xl), var(--bb-glow) !important;
  transform: scale(1.05);
}

h1, h2 {
  color: var(--bb-deep-brown) !important;
}

h3, h4 {
  color: var(--bb-sage-dark) !important;
}

footer, .footer, .site-footer, #footer {
  background: linear-gradient(135deg, var(--bb-dark-green) 0%, var(--bb-sage-dark) 100%) !important;
  color: var(--bb-cream) !important;
  box-shadow: inset 0 2px 8px rgba(0, 0, 0, 0.2) !important;
}

footer a, .footer a, .site-footer a {
  color: var(--bb-sage-light) !important;
  transition: color 0.2s ease, text-shadow 0.2s ease;
}

footer a:hover, .footer a:hover, .site-footer a:hover {
  color: var(--bb-cream) !important;
  text-shadow: 0 0 8px rgba(164, 172, 134, 0.3);
}

a:not(.button):not(.no-hover) {
  position: relative;
  transition: color 0.2s ease;
}

a:not(.button):not(.no-hover)::after {
  content: '';
  position: absolute;
  bottom: -2px;
  left: 0;
  width: 0;
  height: 2px;
  background: linear-gradient(90deg, var(--bb-sage-light), var(--bb-cream));
  transition: width 0.3s ease;
}

a:not(.button):not(.no-hover):hover::after {
  width: 100%;
}

.feature-icon, .service-icon, .category-icon, i[class*="icon"] {
  transition: all 0.3s ease;
  display: inline-block;
}

.feature-icon:hover, .service-icon:hover, .category-icon:hover, a:hover i[class*="icon"] {
  color: var(--bb-sage-light) !important;
  filter: drop-shadow(0 0 8px rgba(164, 172, 134, 0.4));
  transform: scale(1.1) rotate(5deg);
}

html {
  scroll-behavior: smooth;
}

::selection {
  background-color: var(--bb-sage-light) !important;
  color: var(--bb-sage-dark) !important;
}

::-moz-selection {
  background-color: var(--bb-sage-light) !important;
  color: var(--bb-sage-dark) !important;
}

* {
  transition-property: background-color, border-color, color, box-shadow, transform;
  transition-duration: 0.3s;
  transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
}

body.loading * {
  transition: none !important;
}

@media (max-width: 768px) {
  .card, .listing-item-container, .product-card {
    margin-bottom: 16px;
  }

  button, a.button, .btn {
    padding: 10px 20px !important;
    font-size: 14px !important;
  }

  h1 { font-size: 24px !important; }
  h2 { font-size: 20px !important; }
  h3 { font-size: 18px !important; }
}

.bg-deep-brown { background-color: var(--bb-deep-brown) !important; }
.bg-rich-brown { background-color: var(--bb-rich-brown) !important; }
.bg-sage-light { background-color: var(--bb-sage-light) !important; }
.bg-sage-dark { background-color: var(--bb-sage-dark) !important; }
.bg-cream { background-color: var(--bb-cream) !important; }

.text-deep-brown { color: var(--bb-deep-brown) !important; }
.text-rich-brown { color: var(--bb-rich-brown) !important; }
.text-sage-light { color: var(--bb-sage-light) !important; }
.text-sage-dark { color: var(--bb-sage-dark) !important; }
.text-cream { color: var(--bb-cream) !important; }

.shadow-sm { box-shadow: var(--bb-shadow-sm) !important; }
.shadow-md { box-shadow: var(--bb-shadow-md) !important; }
.shadow-lg { box-shadow: var(--bb-shadow-lg) !important; }
.shadow-xl { box-shadow: var(--bb-shadow-xl) !important; }

.hover-lift:hover { transform: translateY(-6px) !important; }
.hover-glow:hover { box-shadow: var(--bb-glow) !important; }
.hover-scale:hover { transform: scale(1.05) !important; }
</style>
    <?php
}, 5, 0);
