<?php
namespace LSDPACELM\Widgets;

use LSDPACELM\Widgets;

class Booking extends Widgets
{
    public function get_name(): string
    {
        return 'lsd-listing-booking';
    }

    public function get_title(): string
    {
        return esc_html__('Booking Addon', 'listdom-elementor');
    }

    public function get_icon(): string
    {
        return 'eicon-folder-o';
    }

    protected function listing(\LSD_Entity_Listing $listing): string
    {
        // Check Existence of Addon
        if (!class_exists(\LSDPACBOK\Base::class))
        {
            return \LSD_Main::alert(esc_html__('Booking addon should be installed and activated!', 'listdom-elementor'), 'warning');
        }

        $element = new \LSDPACBOK\Element();
        return '<div class="lsdaddelm-card-booking">' . $element->get($listing->id()) . '</div>';
    }
}
