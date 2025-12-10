<?php
namespace LSDPACELM\Widgets;

use LSDPACELM\Widgets;

class Application extends Widgets
{
    public function get_name(): string
    {
        return 'lsd-listing-application';
    }

    public function get_title(): string
    {
        return esc_html__('Jobs Addon', 'listdom-elementor');
    }

    public function get_icon(): string
    {
        return 'eicon-user-circle-o';
    }

    protected function listing(\LSD_Entity_Listing $listing): string
    {
        // Check Existence of Addon
        if (!class_exists(\LSDPACJOB\Base::class))
        {
            return \LSD_Main::alert(esc_html__('Jobs addon should be installed and activated!', 'listdom-elementor'), 'warning');
        }

        $element = new \LSDPACJOB\Element();
        return '<div class="lsdaddelm-card-application">' . $element->get($listing->id()) . '</div>';
    }
}
