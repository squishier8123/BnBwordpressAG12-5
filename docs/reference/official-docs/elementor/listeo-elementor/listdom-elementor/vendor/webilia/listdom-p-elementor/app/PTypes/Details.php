<?php
namespace LSDPACELM\PTypes;

use LSDPACELM\Base;

class Details extends Base
{
    public $PT;

    public function __construct()
    {
        $this->PT = Base::PTYPE_DETAILS;
    }

    public function init()
    {
        // Register Post Type
        add_action('init', [$this, 'register_post_type']);
        add_filter('manage_' . $this->PT . '_posts_columns', [$this, 'filter_columns']);
        add_action('manage_' . $this->PT . '_posts_custom_column', [$this, 'filter_columns_content'], 10, 2);
        add_action('add_meta_boxes', [$this, 'register_metaboxes'], 10, 2);
        add_action('save_post', [$this, 'save'], 10, 2);

        // Remove From Divi Theme Builder
        add_filter('et_theme_builder_template_settings_options', [$this, 'exclude']);

        // Add Styles
        add_filter('lsd_styles', [$this, 'styles'], 10, 2);

        // Remove Post Attributes metabox
        add_action('admin_init', function ()
        {
            remove_meta_box('pageparentdiv', $this->PT, 'side');
        });
    }

    public function register_post_type()
    {
        $args = [
            'labels' => [
                'name' => esc_html__('Styles', 'listdom-elementor'),
                'singular_name' => esc_html__('Style', 'listdom-elementor'),
                'add_new' => esc_html__('Add Style', 'listdom-elementor'),
                'add_new_item' => esc_html__('Add New Style', 'listdom-elementor'),
                'edit_item' => esc_html__('Edit Style', 'listdom-elementor'),
                'new_item' => esc_html__('New Style', 'listdom-elementor'),
                'view_item' => esc_html__('View Style', 'listdom-elementor'),
                'view_items' => esc_html__('View Styles', 'listdom-elementor'),
                'search_items' => esc_html__('Search Styles', 'listdom-elementor'),
                'not_found' => esc_html__('No styles found!', 'listdom-elementor'),
                'not_found_in_trash' => esc_html__('No styles found in Trash!', 'listdom-elementor'),
                'all_items' => esc_html__('All Styles', 'listdom-elementor'),
                'archives' => esc_html__('Style Archives', 'listdom-elementor'),
            ],
            'public' => true,
            'has_archive' => false,
            'show_ui' => true,
            'show_in_menu' => false,
            'show_in_rest' => false,
            'supports' => ['title', 'editor', 'elementor'],
            'capabilities' => [
                'create_posts' => 'manage_options',
                'edit_post' => 'manage_options',
                'read_post' => 'manage_options',
                'delete_post' => 'manage_options',
                'edit_posts' => 'manage_options',
                'edit_others_posts' => 'manage_options',
                'delete_posts' => 'manage_options',
                'publish_posts' => 'manage_options',
                'read_private_posts' => 'manage_options',
            ],
        ];

        register_post_type($this->PT, apply_filters('lsdaddelm_ptype_details_args', $args));
    }

    public function filter_columns($columns)
    {
        // Move the date column to the end
        $date = $columns['date'];

        unset($columns['date']);

        $columns['type'] = esc_html__('Type', 'listdom-elementor');
        $columns['date'] = $date;

        return $columns;
    }

    public function filter_columns_content($column_name, $post_id)
    {
        if ($column_name === 'type')
        {
            $type = get_post_meta($post_id, 'lsd_type', true);
            if (trim($type) === '') $type = 'details';

            if ($type === 'infowindow') echo esc_html__('Infowindow', 'listdom-elementor');
            else if ($type === 'card') echo esc_html__('Listing Card', 'listdom-elementor');
            else echo esc_html__('Single Listing', 'listdom-elementor');
        }
    }

    public function register_metaboxes()
    {
        add_meta_box('lsdaddelm_metabox', esc_html__('Style Type', 'listdom-elementor'), [$this, 'metabox'], $this->PT, 'side');
    }

    public function metabox($post)
    {
        // Generate output
        include $this->include_html_file('metabox.php', ['return_path' => true]);
    }

    public function save($post_id, $post)
    {
        // We don't need to do anything on post auto save
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

        // It's not a notification
        if ($post->post_type !== $this->PT) return;

        // Nonce is not set!
        if (!isset($_POST['_lsdnonce'])) return;

        // Nonce is not valid!
        if (!wp_verify_nonce(sanitize_text_field($_POST['_lsdnonce']), 'lsdaddelm_details_cpt')) return;

        // Get Listdom Data
        $lsd = $_POST['lsd'] ?? [];

        // Sanitization
        array_walk_recursive($lsd, 'sanitize_text_field');

        // Type
        $type = $lsd['type'] ?? 'details';
        update_post_meta($post_id, 'lsd_type', $type);
    }

    public function exclude(array $options): array
    {
        // Remove from Theme Builder Settings
        if (isset($options[$this->PT])) unset($options[$this->PT]);

        return $options;
    }

    public function styles($styles, $skin)
    {
        // Elementor Styles
        $posts = get_posts([
            'post_type' => $this->PT,
            'numberposts' => -1,
            'post_status' => ['publish', 'pending', 'draft'],
        ]);

        if ($skin === 'detail_types') $styles['elementor'] = esc_html__('Elementor', 'listdom-elementor');

        // Add Elementor Styles
        foreach ($posts as $post)
        {
            // Style Type
            $type = Base::get_layout_type($post->ID);

            // Single Skin
            if ($skin === 'details' && $type === 'details')
            {
                $styles[$post->ID] = $post->post_title . ' (Elementor)';
            }
            else if (\LSD_Skins::is_cardable($skin) && $type === 'card')
            {
                $styles[$post->ID] = $post->post_title . ' (Elementor)';
            }
            else if ($skin === 'infowindow' && $type === 'infowindow')
            {
                $styles[$post->ID] = $post->post_title . ' (Elementor)';
            }
        }

        return $styles;
    }
}
