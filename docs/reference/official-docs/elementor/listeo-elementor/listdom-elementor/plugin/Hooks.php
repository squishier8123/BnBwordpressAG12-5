<?php
namespace LSDADDELM;

class Hooks
{
    /**
     * The single instance of the class.
     *
     * @var Hooks
     * @since 1.0.0
     */
    protected static $instance = null;

    public static function instance(): Hooks
    {
        // Get an instance of Class
        if (is_null(self::$instance)) self::$instance = new self();

        // Return the instance
        return self::$instance;
    }

    protected function __construct()
    {
        register_activation_hook(LSDADDELM_BASENAME, [$this, 'activate']);
        register_deactivation_hook(LSDADDELM_BASENAME, [$this, 'deactivate']);
        register_uninstall_hook(LSDADDELM_BASENAME, [Hooks::class, 'uninstall']);

        // Add to License-able products
        add_filter('lsd_products', function ($products = [])
        {
            $products['lsdaddelm'] = [
                'name' => esc_html__('Listdom Elementor', 'listdom-elementor'),
                'icon' => 'https://cdn.webilia.com/u/products/27/icon-128.png',
                'licensing' => new \LSD_Plugin_Licensing([
                    'basename' => LSDADDELM_BASENAME,
                    'prefix' => 'lsdaddelm',
                ]),
            ];

            return $products;
        });

        // Add Action Links
        add_filter('plugin_action_links_' . LSDADDELM_BASENAME, function ($links)
        {
            $links[] = '<a href="' . esc_url(admin_url('/admin.php?page=listdom-settings&tab=addons')) . '">' . esc_html__('Settings', 'listdom-elementor') . '</a>';
            return $links;
        });
    }

    /**
     * Runs on plugin activation
     * @param bool $network
     */
    public function activate(bool $network = false)
    {
        $current_blog_id = get_current_blog_id();

        // Plugin activated only for one blog
        if (!function_exists('is_multisite') || !is_multisite()) $network = false;
        if (!$network)
        {
            $this->install($current_blog_id);

            // Add WordPress flush rewrite rules in to do list
            if (class_exists(\LSD_RewriteRules::class)) \LSD_RewriteRules::todo();

            // Don't run rest of the function
            return;
        }

        // Plugin activated for all blogs
        $blogs = self::blogs();
        foreach ($blogs as $blog_id)
        {
            switch_to_blog($blog_id);
            $this->install($blog_id);
        }

        switch_to_blog($current_blog_id);

        // Add WordPress flush rewrite rules in to do list
        if (class_exists(\LSD_RewriteRules::class)) \LSD_RewriteRules::todo();
    }

    /**
     * Install the plugin on a certain blog
     * @param int $blog_id
     */
    public function install(int $blog_id = 1)
    {
        // Save Installation Time
        add_option('lsdaddelm_installed_at', current_time('timestamp'));
    }

    /**
     * Runs on plugin deactivation
     * @param bool $network
     */
    public function deactivate(bool $network = false)
    {
    }

    /**
     * Runs on plugin uninstallation
     */
    public static function uninstall()
    {
        // Getting current blog
        $current_blog_id = get_current_blog_id();

        // Single WordPress Installation
        if (!function_exists('is_multisite') || !is_multisite())
        {
            self::purge($current_blog_id);

            /**
             * Refresh WordPress rewrite rules
             * We cannot use LSD_RewriteRules here because plugin is deactivated and it won't run
             */
            flush_rewrite_rules();

            // Don't run rest of the function
            return;
        }

        // WordPress is multisite, so we should purge the plugin from all blogs
        $blogs = self::blogs();
        foreach ($blogs as $blog_id)
        {
            switch_to_blog($blog_id);
            self::purge($blog_id);
        }

        // Switch back to current blog
        switch_to_blog($current_blog_id);

        /**
         * Refresh WordPress rewrite rules
         * We cannot use LSD_RewriteRules here because plugin is deactivated and it won't run
         */
        flush_rewrite_rules();
    }

    /**
     * Remove Addon from a blog
     * @param int $blog_id
     */
    public static function purge(int $blog_id = 1)
    {
    }

    /**
     * Get All Blogs
     * @return array
     */
    public static function blogs(): array
    {
        global $wpdb;
        return $wpdb->get_col("SELECT `blog_id` FROM `" . $wpdb->base_prefix . "blogs`");
    }
}
