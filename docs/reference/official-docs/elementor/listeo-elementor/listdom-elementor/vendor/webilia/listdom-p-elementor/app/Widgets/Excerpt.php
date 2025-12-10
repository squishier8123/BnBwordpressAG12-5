<?php
namespace LSDPACELM\Widgets;

class Excerpt extends Content
{
    protected $css_selector = '{{WRAPPER}} .lsdaddelm-card-excerpt p';

    public function get_name(): string
    {
        return 'lsd-listing-excerpt';
    }

    public function get_title(): string
    {
        return esc_html__('Listing Excerpt', 'listdom-elementor');
    }

    protected function listing(\LSD_Entity_Listing $listing): string
    {
        $settings = $this->get_settings_for_display();
        $words = (int) ($settings['content_length'] ?? 12);

        return '<div class="lsdaddelm-card-excerpt">' . $listing->get_excerpt($words) . '</div>';
    }
}
