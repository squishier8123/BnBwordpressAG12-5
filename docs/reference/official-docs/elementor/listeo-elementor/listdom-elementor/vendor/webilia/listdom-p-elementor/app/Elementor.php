<?php
namespace LSDPACELM;

use Elementor\Elements_Manager;
use Elementor\Plugin;
use Elementor\Widgets_Manager;
use ElementorPro\Modules\ThemeBuilder\Classes\Conditions_Manager;

class Elementor extends Base
{
    public function init()
    {
        // Categories
        add_action('elementor/elements/categories_registered', [$this, 'categories']);

        // Widgets
        add_action('elementor/widgets/register', [$this, 'widgets']);

        // Listing Created by Elementor
        add_filter('lsd_listing_before_single_content', [$this, 'listing'], 10, 2);

        // Conditional Display
        add_action('elementor/theme/register_conditions', [$this, 'conditions']);

        // Dynamic Tags
        add_action('elementor/dynamic_tags/register', [$this, 'tag_categories']);
        add_action('elementor/dynamic_tags/register', [$this, 'tags']);
    }

    public function listing($output, \LSD_PTypes_Listing_Single $single): string
    {
        // Validation
        if (!isset($single->entity) || !isset($single->entity->post)) return $output;

        // Listing Built with Elementor
        if (!$output && class_exists(Plugin::class) && Plugin::$instance->documents->get($single->entity->post->ID)->is_built_with_elementor())
        {
            $single->style = $single->entity->post->ID;
            return $single->builders();
        }

        return $output;
    }

    public function categories(Elements_Manager $elements_manager)
    {
        $elements_manager->add_category('listdom-listing', [
            'title' => esc_html__('Listing', 'listdom-elementor'),
            'icon' => 'fa fa-file',
        ]);

        $elements_manager->add_category('listdom', [
            'title' => esc_html__('Listdom', 'listdom-elementor'),
            'icon' => 'eicon-code-bold',
        ]);
    }

    public function widgets(Widgets_Manager $manager)
    {
        // Listing Title
        $manager->register(new \LSDPACELM\Widgets\Title());

        // Listing Address
        if (\LSD_Components::map())
        {
            $manager->register(new \LSDPACELM\Widgets\Address());
        }

        // Claim Button
        $manager->register(new \LSDPACELM\Widgets\Claim());

        // Favorite Button
        $manager->register(new \LSDPACELM\Widgets\Favorite());

        // Compare Button
        $manager->register(new \LSDPACELM\Widgets\Compare());

        // Listing Locations
        $manager->register(new \LSDPACELM\Widgets\Locations());

        // Listing Owner
        $manager->register(new \LSDPACELM\Widgets\Owner());

        // Report Abuse
        $manager->register(new \LSDPACELM\Widgets\Abuse());

        // Listing Attributes
        $manager->register(new \LSDPACELM\Widgets\Attributes());

        // Listing Availability
        if (\LSD_Components::work_hours())
        {
            $manager->register(new \LSDPACELM\Widgets\Availability());
        }

        // Listing Stars
        $manager->register(new \LSDPACELM\Widgets\Rate());

        // Listing BreadCrumb
        $manager->register(new \LSDPACELM\Widgets\Breadcrumb());

        // Listing Categories
        $manager->register(new \LSDPACELM\Widgets\Categories());

        // Listing Content
        $manager->register(new \LSDPACELM\Widgets\Content());

        // Listing Excerpt
        $manager->register(new \LSDPACELM\Widgets\Excerpt());

        // Listing Remark
        $manager->register(new \LSDPACELM\Widgets\Remark());

        // Listing Features
        $manager->register(new \LSDPACELM\Widgets\Features());

        // Listing Map
        if (\LSD_Components::map())
        {
            $manager->register(new \LSDPACELM\Widgets\Map());
        }

        // Listing Image
        $manager->register(new \LSDPACELM\Widgets\Image());

        // Listing Gallery
        $manager->register(new \LSDPACELM\Widgets\Gallery());

        // Listing Embeds
        $manager->register(new \LSDPACELM\Widgets\Embeds());

        // Listing Labels
        $manager->register(new \LSDPACELM\Widgets\Labels());

        // Disable Price Modules
        if (\LSD_Components::pricing())
        {
            // Listing Price
            $manager->register(new \LSDPACELM\Widgets\Price());

            // Listing Price Class
            $manager->register(new \LSDPACELM\Widgets\PC());
        }

        // Listing Share
        if (\LSD_Components::socials())
        {
            $manager->register(new \LSDPACELM\Widgets\Share());
        }

        // Listing Tags
        $manager->register(new \LSDPACELM\Widgets\Tags());

        // Listing Contact
        $manager->register(new \LSDPACELM\Widgets\Contact());

        // ACF Addon
        $manager->register(new \LSDPACELM\Widgets\ACF());

        // Franchise Addon
        $manager->register(new \LSDPACELM\Widgets\Franchise());

        // Auction Addon
        $manager->register(new \LSDPACELM\Widgets\Auction());

        // Stats Addon
        $manager->register(new \LSDPACELM\Widgets\Stats());

        // Booking Addon
        $manager->register(new \LSDPACELM\Widgets\Booking());

        // Review Addon
        $manager->register(new \LSDPACELM\Widgets\Discussion());

        // Jobs Addon
        $manager->register(new \LSDPACELM\Widgets\Application());

        // Advanced Map Direction Addon
        $manager->register(new \LSDPACELM\Widgets\Direction());

        // Team Addon
        $manager->register(new \LSDPACELM\Widgets\Team());

        /**
         * Non-listing Shortcodes
         */

        // Listdom Shortcode
        $manager->register(new \LSDPACELM\Widgets\Shortcode());

        // Listdom Search
        $manager->register(new \LSDPACELM\Widgets\Search());

        // Listdom Profile
        $manager->register(new \LSDPACELM\Widgets\Profile());
        $manager->register(new \LSDPACELM\Widgets\Users());

        // Listdom Taxonomies
        $manager->register(new \LSDPACELM\Widgets\Category());
        $manager->register(new \LSDPACELM\Widgets\Location());
        $manager->register(new \LSDPACELM\Widgets\Tag());
        $manager->register(new \LSDPACELM\Widgets\Feature());
        $manager->register(new \LSDPACELM\Widgets\Label());
    }

    public function conditions(Conditions_Manager $conditions_manager)
    {
        $conditions_manager->get_condition('archive')
            ->register_sub_condition(new \LSDPACELM\Conditions\Archive());
    }

    public function tag_categories(\Elementor\Core\DynamicTags\Manager $dynamic_tags_manager)
    {
        $dynamic_tags_manager->register_group(
            'lsd_listings',
            [
                'title' => esc_html__('Listings', 'listdom-elementor'),
            ]
        );
    }

    public function tags(\Elementor\Core\DynamicTags\Manager $dynamic_tags_manager)
    {
        $dynamic_tags_manager->register(new \LSDPACELM\Tags\Listing());
        $dynamic_tags_manager->register(new \LSDPACELM\Tags\URL());
        $dynamic_tags_manager->register(new \LSDPACELM\Tags\Number());
        $dynamic_tags_manager->register(new \LSDPACELM\Tags\Datetime());
        $dynamic_tags_manager->register(new \LSDPACELM\Tags\Image());
        $dynamic_tags_manager->register(new \LSDPACELM\Tags\Gallery());
    }
}
