<?php
namespace LSDPACELM\Widgets;

use LSDPACELM\Widgets;

class Auction extends Widgets
{
    public function get_name(): string
    {
        return 'lsd-listing-auction';
    }

    public function get_title(): string
    {
        return esc_html__('Auction Addon', 'listdom-elementor');
    }

    public function get_icon(): string
    {
        return 'eicon-posts-ticker';
    }

    protected function listing(\LSD_Entity_Listing $listing): string
    {
        // Check Existence of Addon
        if (!class_exists(\LSDPACAUC\Base::class))
        {
            return \LSD_Main::alert(esc_html__('Auction addon should be installed and activated!', 'listdom-elementor'), 'warning');
        }

        $element = new \LSDPACAUC\Element();
        return '<div class="lsdaddelm-card-auction">' . $element->get($listing->id()) . '</div>';
    }
}
