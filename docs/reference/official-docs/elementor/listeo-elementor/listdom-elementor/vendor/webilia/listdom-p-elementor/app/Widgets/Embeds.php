<?php
namespace LSDPACELM\Widgets;

use LSDPACELM\Widgets;

class Embeds extends Widgets
{
    public function get_name(): string
    {
        return 'lsd-listing-embeds';
    }

    public function get_title(): string
    {
        return esc_html__('Listing Embeds', 'listdom-elementor');
    }

    public function get_icon(): string
    {
        return 'eicon-slider-video';
    }

    protected function listing(\LSD_Entity_Listing $listing): string
    {
        return '<div class="lsdaddelm-card-embeds">' . $listing->get_embeds() . '</div>';
    }
}
