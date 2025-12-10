<?php
namespace LSDPACELM\Widgets;

class Feature extends Taxonomies
{
    protected $shortcode_name = 'listdom_feature';
    protected $taxonomy = 'feature';
    
    public function get_name(): string
    {
        return 'lsd-listing-feature';
    }

    public function get_title(): string
    {
        return esc_html__('Listdom Feature', 'listdom-elementor');
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
            'simple' => esc_html__('Simple', 'listdom-elementor')
        ];
    }

    public function register_controls()
    {
        parent::register_controls();
    }
}
