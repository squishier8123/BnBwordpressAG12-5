<?php
namespace LSDPACELM\Widgets;

class Label extends Taxonomies
{
    protected $shortcode_name = 'listdom_label';
    protected $taxonomy = 'label';
    
    public function get_name(): string
    {
        return 'lsd-listing-label';
    }

    public function get_title(): string
    {
        return esc_html__('Listdom Label', 'listdom-elementor');
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
