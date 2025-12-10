<?php
namespace LSDPACELM\Widgets;

use LSDPACELM\Widgets;

class Remark extends Widgets
{
    public function get_name(): string
    {
        return 'lsd-listing-remark';
    }

    public function get_title(): string
    {
        return esc_html__('Listing Remark', 'listdom-elementor');
    }

    public function get_icon(): string
    {
        return 'eicon-blockquote';
    }

    protected function listing(\LSD_Entity_Listing $listing): string
    {
        return '<div class="lsdaddelm-card-remark">' . $listing->get_remark() . '</div>';
    }
}
