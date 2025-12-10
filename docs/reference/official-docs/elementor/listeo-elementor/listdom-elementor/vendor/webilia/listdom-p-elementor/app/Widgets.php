<?php
namespace LSDPACELM;

use Elementor\Controls_Manager;
use Elementor\Widget_Base;

abstract class Widgets extends Widget_Base
{
    /**
     * @inheritDoc
     */
    public function get_name()
    {
    }

    public function get_categories(): array
    {
        return ['listdom-listing'];
    }

    protected function register_controls()
    {
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Content', 'listdom-elementor'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'heading',
            [
                'type' => Controls_Manager::RAW_HTML,
                'raw' => '<p>' . esc_html__('No Options', 'listdom-elementor') . '</p>',
            ]
        );

        $this->end_controls_section();
    }

    public function get_listing(): ?\LSD_Entity_Listing
    {
        $listing = \LSD_Payload::get('listing');

        // To Preview
        if (!$listing) $listing = \LSD_PTypes_Listing_Single::preview(true);

        return $listing;
    }

    protected function render()
    {
        // Listing
        $listing = $this->get_listing();
        echo $this->listing($listing);
    }

    abstract protected function listing(\LSD_Entity_Listing $listing): string;
}
