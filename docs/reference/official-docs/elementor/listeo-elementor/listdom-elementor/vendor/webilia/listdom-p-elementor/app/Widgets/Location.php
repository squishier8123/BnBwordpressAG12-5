<?php
namespace LSDPACELM\Widgets;

class Location extends Taxonomies
{
    protected $shortcode_name = 'listdom_location';
    protected $taxonomy = 'location';
    
    public function get_name(): string
    {
        return 'lsd-listing-location';
    }

    public function get_title(): string
    {
        return esc_html__('Listdom Location', 'listdom-elementor');
    }

    public function get_categories(): array
    {
        return ['listdom'];
    }

    public function get_icon(): string
    {
        return 'eicon-gallery-grid';
    }

    protected function get_available_styles(): array
    {
        return [
            'clean' => esc_html__('Clean', 'listdom-elementor'),
            'simple' => esc_html__('Simple', 'listdom-elementor'),
            'image' => esc_html__('Image', 'listdom-elementor')
        ];
    }

    public function register_controls()
    {
        parent::register_controls();
    }
}
