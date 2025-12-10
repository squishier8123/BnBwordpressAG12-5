<?php
namespace LSDPACELM;

class Menus extends Base
{
    public function init()
    {
        // Addon Menus
        add_action('admin_menu', [$this, 'register'], 2);
        add_action('parent_file', [$this, 'mainmenu'], 2);
        add_action('submenu_file', [$this, 'submenu'], 2);

        // Include Backend Assets
        add_filter('lsd_should_include_backend', [$this, 'should_include']);
    }

    public function register()
    {
        add_submenu_page('listdom', esc_html__('Elementor Styles', 'listdom-elementor'), esc_html__('Elementor Styles', 'listdom-elementor'), 'manage_options', 'edit.php?post_type=' . Base::PTYPE_DETAILS, null, 5);
    }

    public function mainmenu($parent_file)
    {
        global $current_screen;
        $post_type = $current_screen->post_type;

        // Don't do anything if the post type is not Elementor Post Type
        if ($post_type !== Base::PTYPE_DETAILS) return $parent_file;

        return 'listdom';
    }

    public function submenu($submenu_file)
    {
        global $current_screen;
        $post_type = $current_screen->post_type;

        // Don't do anything if the post type is not Elementor Post Type
        if ($post_type !== Base::PTYPE_DETAILS) return $submenu_file;

        return 'edit.php?post_type=' . $post_type;
    }

    public function should_include($should): bool
    {
        // Current Screen
        $screen = get_current_screen();

        // It's Elementor Post Type
        if (trim($screen->post_type) && $screen->post_type === Base::PTYPE_DETAILS) return true;

        return $should;
    }
}
