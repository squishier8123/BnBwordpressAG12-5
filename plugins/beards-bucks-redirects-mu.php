<?php
/**
 * Beards & Bucks URL Redirects
 * Must-use plugin for fixing broken URLs
 *
 * This file should be copied to: /wp-content/mu-plugins/beards-bucks-redirects-mu.php
 */

// Redirect broken Add Listing page to working URL
add_action('template_redirect', function() {
    if (isset($_GET['page_id']) && $_GET['page_id'] == 4404) {
        wp_redirect('https://beardsandbucks.com/list-your-gear-8/', 301);
        exit;
    }
});
