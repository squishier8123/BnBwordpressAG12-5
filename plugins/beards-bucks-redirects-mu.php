<?php
/**
 * Beards & Bucks URL Redirects
 * Must-use plugin for fixing broken URLs
 *
 * This file should be copied to: /wp-content/mu-plugins/beards-bucks-redirects-mu.php
 */

// Redirect broken Add Listing URLs to the working Submit Listing page
add_action('template_redirect', function() {
    // Redirect query parameter version
    if (isset($_GET['page_id']) && $_GET['page_id'] == 4404) {
        wp_redirect('https://beardsandbucks.com/submit-listing-page/', 301);
        exit;
    }
});

// Also handle the /list-your-gear-8/ URL if someone navigates to it directly
add_action('template_redirect', function() {
    $request_uri = $_SERVER['REQUEST_URI'] ?? '';
    if (strpos($request_uri, '/list-your-gear-8/') !== false) {
        wp_redirect('https://beardsandbucks.com/submit-listing-page/', 301);
        exit;
    }
});
