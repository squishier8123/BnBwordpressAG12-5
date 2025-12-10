<?php
namespace LSDPACELM\Widgets;

use LSDPACELM\Widgets;

class Abuse extends Widgets
{
    public function get_name(): string
    {
        return 'lsd-listing-abuse';
    }

    public function get_title(): string
    {
        return esc_html__('Report Abuse', 'listdom-elementor');
    }

    public function get_icon(): string
    {
        return 'eicon-alert';
    }

    protected function listing(\LSD_Entity_Listing $listing): string
    {
        return '<div class="lsdaddelm-card-abuse">' . $listing->get_abuse() . '</div>';
    }
}
