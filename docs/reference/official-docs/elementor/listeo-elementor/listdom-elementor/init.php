<?php

use LSDADDELM\I18n;

final class LSDADDELM
{
    /**
     * Version.
     *
     * @var string
     */
    public $version = '2.9.0';

    /**
     * The single instance of the class.
     *
     * @var LSDADDELM
     * @since 1.0.0
     */
    protected static $instance = null;

    public static function instance(): LSDADDELM
    {
        // Get an instance of Class
        if (is_null(self::$instance)) self::$instance = new self();

        // Return the instance
        return self::$instance;
    }

    protected function __construct()
    {
        // Define Constants
        $this->define_constants();

        // Initialize the Addon
        $this->init();

        // Do addon_loaded action
        do_action('lsdaddelm_loaded');
    }

    /**
     * Define Addon Constants.
     */
    private function define_constants()
    {
        // Directory Name
        if (!defined('LSDADDELM_DIRNAME')) define('LSDADDELM_DIRNAME', basename(LSDADDELM_ABSPATH));

        // Version
        if (!defined('LSDADDELM_VERSION')) define('LSDADDELM_VERSION', $this->version);
    }

    /**
     * Initialize the Addon
     */
    private function init()
    {
        // Auto Update
        new LSD_Plugin_Update([
            'version' => LSDADDELM_VERSION,
            'basename' => LSDADDELM_BASENAME,
            'prefix' => 'lsdaddelm',
        ]);

        // Internationalization
        (new I18n())->init();

        // Run if Activated
        LSD_Licensing::runIfValid(LSDADDELM_BASENAME, 'lsdaddelm', function ()
        {
            // Bootstrap
            (new \LSDPACELM\Boot())->init();
        });
    }
}
