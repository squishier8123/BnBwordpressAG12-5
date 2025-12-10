<?php
namespace LSDPACELM\Widgets;

use LSDPACELM\Widgets;

class Locallogic extends Widgets
{
    public function get_name(): string
    {
        return 'lsd-listing-locallogic';
    }

    public function get_title(): string
    {
        return esc_html__('Local Logic Addon', 'listdom-elementor');
    }

    public function get_icon(): string
    {
        return 'eicon-map-pin';
    }

    protected function listing(\LSD_Entity_Listing $listing): string
    {
        // Check Existence of Addon
        if (!class_exists(\LSDPACLCL\Base::class))
        {
            return \LSD_Main::alert(esc_html__('Local Logic addon should be installed and activated!', 'listdom-elementor'), 'warning');
        }

        // Addon Options
        $llogic = \LSD_Options::addons('llogic');

        // API Token
        $token = isset($llogic['token']) && trim($llogic['token']) ? $llogic['token'] : '';

        // Token is Required
        if ($token)
        {
            // Include Assets
            (new \LSDPACLCL\Addon())->assets($token);

            $element = new \LSDPACLCL\Element();
            return '<div class="lsdaddelm-card-locallogic">' . $element->get($listing->id()) . '</div>';
        }

        return '';
    }
}
