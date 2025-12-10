<?php
namespace LSDPACELM\Widgets;

use LSDPACELM\Widgets;

class Team extends Widgets
{
    public function get_name(): string
    {
        return 'lsd-listing-team';
    }

    public function get_title(): string
    {
        return esc_html__('Team Addon', 'listdom-elementor');
    }

    public function get_icon(): string
    {
        return 'eicon-user-circle-o';
    }

    protected function listing(\LSD_Entity_Listing $listing): string
    {
        // Check Existence of Addon
        if (!class_exists(\LSDPACTIM\Base::class))
        {
            return \LSD_Main::alert(esc_html__('Team addon should be installed and activated!', 'listdom-elementor'), 'warning');
        }

        $element = new \LSDPACTIM\Element();
        return '<div class="lsdaddelm-card-team">' . $element->get($listing->id()) . '</div>';
    }
}
