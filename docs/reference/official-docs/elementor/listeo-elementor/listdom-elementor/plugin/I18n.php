<?php
namespace LSDADDELM;

class I18n
{
    public function init()
    {
        // Register Language Files
        add_action('init', [$this, 'load_languages']);
    }

    public function load_languages()
    {
        // Listdom File
        $file = new \LSD_File();

        // Get current locale
        $locale = apply_filters('plugin_locale', get_locale(), 'listdom-elementor');

        // WordPress' language directory /wp-content/languages/listdom-elementor-en_US.mo
        $path = WP_LANG_DIR . '/listdom-elementor-' . $locale . '.mo';

        // If language file exists on WordPress' language directory use it
        if ($file->exists($path))
        {
            load_textdomain('listdom-elementor', $path);
        }
        // Otherwise use plugin directory /path/to/plugin/i18n/languages/listdom-elementor-en_US.mo
        else
        {
            load_plugin_textdomain('listdom-elementor', false, dirname(LSDADDELM_BASENAME) . '/i18n/languages/');
        }
    }
}
