<?php
/**
 * Plugin Name: Listdom Elementor
 * Plugin URI: https://listdom.net
 * Description: Design listing pages the way you like!
 * Version: 2.9.0
 * Author: Webilia
 * Author URI: https://webilia.com/
 * Requires at least: 4.2
 * Tested up to: 6.8
 * Requires Plugins: listdom, elementor
 *
 * Text Domain: listdom-elementor
 * Domain Path: /i18n/languages/
 */

// No Direct Access
defined('ABSPATH') || die();

// Autoload
require_once dirname(__FILE__) . '/vendor/autoload.php';

// Activation
require_once dirname(__FILE__) . '/plugin.php';

function lsdaddelm_init()
{
    // Init the Addon
    require_once 'init.php';

    LSDADDELM::instance();
}

if (did_action('listdom_loaded')) lsdaddelm_init();
else add_action('listdom_loaded', 'lsdaddelm_init');
