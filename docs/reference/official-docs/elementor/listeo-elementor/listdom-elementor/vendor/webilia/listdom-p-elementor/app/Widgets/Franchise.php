<?php
namespace LSDPACELM\Widgets;

use LSDPACELM\Widgets;

class Franchise extends Widgets
{
    public function get_name(): string
    {
        return 'lsd-listing-franchise';
    }

    public function get_title(): string
    {
        return esc_html__('Franchise Addon', 'listdom-elementor');
    }

    public function get_icon(): string
    {
        return 'eicon-device-desktop';
    }

    protected function listing(\LSD_Entity_Listing $listing): string
    {
        // Check Existence of Addon
        if (!class_exists(\LSDPACFS\Base::class))
        {
            return \LSD_Main::alert(esc_html__('Franchise addon should be installed and activated!', 'listdom-elementor'), 'warning');
        }

        $element = new \LSDPACFS\Element();
        return '<div class="lsdaddelm-card-franchise">' . $element->get($listing->id()) . '</div>';
    }
}
