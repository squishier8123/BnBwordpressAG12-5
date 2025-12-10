<?php
namespace LSDPACELM\Widgets;

use LSDPACELM\Widgets;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

class Address extends Widgets
{
    public function get_name(): string
    {
        return 'lsd-listing-address';
    }

    public function get_title(): string
    {
        return esc_html__('Listing Address', 'listdom-elementor');
    }

    public function get_icon(): string
    {
        return 'eicon-map-pin';
    }

    public function register_controls()
    {
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Content', 'listdom-elementor'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'show_icon',
            [
                'label' => esc_html__('Show Icon', 'listdom-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'listdom-elementor'),
                'label_off' => esc_html__('Hide', 'listdom-elementor'),
                'return_value' => '1',
                'default' => '1',
            ]
        );

        $this->end_controls_section();

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
                'name' => 'address_typography',
                'selector' => '{{WRAPPER}} .lsdaddelm-card-address, {{WRAPPER}} .lsdaddelm-card-address a',
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label' => esc_html__('Text Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-address' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .lsdaddelm-card-address a' => 'color: {{VALUE}}'
                ],
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label' => esc_html__('Icon Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-address i' => 'color: {{VALUE}} !important',
                ],
                'condition' => [
                    'show_icon' => '1',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function listing(\LSD_Entity_Listing $listing): string
    {
        $settings = $this->get_settings_for_display();

        return '<div class="lsdaddelm-card-address">' . $listing->get_address(
                isset($settings['show_icon']) && $settings['show_icon']
            ) . '</div>';
    }
}
