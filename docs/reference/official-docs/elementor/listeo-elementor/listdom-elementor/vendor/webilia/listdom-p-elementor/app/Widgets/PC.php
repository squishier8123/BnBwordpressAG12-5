<?php
namespace LSDPACELM\Widgets;

use LSDPACELM\Widgets;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

class PC extends Widgets
{
    public function get_name(): string
    {
        return 'lsd-listing-price-class';
    }

    public function get_title(): string
    {
        return esc_html__('Listing Price Class', 'listdom-elementor');
    }

    public function get_icon(): string
    {
        return 'eicon-price-table';
    }

    public function register_controls()
    {
        $this->start_controls_section(
            'style_section',
            [
                'label' => esc_html__('Style', 'listdom-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'price_typography',
                'selector' => '{{WRAPPER}} .lsdaddelm-card-price-class',
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label' => esc_html__('Text Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-price-class' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function listing(\LSD_Entity_Listing $listing): string
    {
        $price_class = $listing->get_price_class();
        if (trim($price_class) === '') return '';

        return '<span class="lsdaddelm-card-price-class">' . $price_class . '</span>';
    }
}
