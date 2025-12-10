<?php
namespace LSDPACELM;

use LSDPACELM\PTypes\Details;

class Boot extends Base
{
    protected $addon;
    private static $ran = false;

    public function __construct()
    {
        // Addon
        $this->addon = new Addon();
    }

    public function init()
    {
        // Run Only Once
        if (self::$ran) return;
        self::$ran = true;

        // Register Actions
        $this->actions();

        // Register Filters
        $this->filters();

        // Details Post Type
        (new Details())->init();

        // Menus
        (new Menus())->init();

        // Elementor
        (new Elementor())->init();
    }

    public function actions()
    {
        // General Options
        add_action('lsd_addon_form', [$this->addon, 'form']);
    }

    public function filters()
    {
        // Inform Listdom About Existence of an Addon
        add_filter('lsd_is_addon_installed', '__return_true');
        add_filter('lsd_is_addelm_installed', '__return_true');

        // Register Addon
        add_filter('lsd_addons', [$this, 'addon']);

        // Backend Header
        add_filter('lsd_backend_header_post_types', [$this, 'backend_header_post_types']);
    }

    public function backend_header_post_types($post_types)
    {
        $post_types[] = Base::PTYPE_DETAILS;
        return $post_types;
    }

    public function addon($addons)
    {
        $key = 'elementor';
        $addons[$key] = [
            'key' => $key,
            'name' => esc_html__('Listdom Elementor Addon', 'listdom-elementor'),
            'options' => \LSD_Options::addons($key),
        ];

        return $addons;
    }
}
