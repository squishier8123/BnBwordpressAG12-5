<?php
// No Direct Access
defined('ABSPATH') || die();

// Absolute Path
if (!defined('LSDADDELM_ABSPATH')) define('LSDADDELM_ABSPATH', dirname(__FILE__));

// Plugin Base Name
if (!defined('LSDADDELM_BASENAME')) define('LSDADDELM_BASENAME', plugin_basename(LSDADDELM_ABSPATH . '/listdom-elementor.php'));

// Plugin Activation / Deactivation / Uninstall
\LSDADDELM\Hooks::instance();
