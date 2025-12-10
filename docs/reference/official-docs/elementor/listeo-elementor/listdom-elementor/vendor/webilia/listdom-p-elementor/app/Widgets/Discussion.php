<?php
namespace LSDPACELM\Widgets;

use LSDPACELM\Widgets;

class Discussion extends Widgets
{
    public function get_name(): string
    {
        return 'lsd-listing-discussion';
    }

    public function get_title(): string
    {
        return esc_html__('Listing Review Form', 'listdom-elementor');
    }

    public function get_icon(): string
    {
        return 'eicon-comments';
    }

    protected function listing(\LSD_Entity_Listing $listing): string
    {
        // Check Existence of Addon
        if (!class_exists(\LSDPACREV\Base::class))
        {
            return \LSD_Main::alert(esc_html__('Review addon should be installed and activated!', 'listdom-elementor'), 'warning');
        }

        $element = new \LSDPACREV\Element();
        $content = $element->get($listing->id());

        // Disable General Comments
        $element->disable();

        return '<div class="lsdaddelm-card-discussion">' . $content . '</div>';
    }
}
