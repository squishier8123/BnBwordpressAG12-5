<?php
namespace LSDPACELM\Widgets;

use Elementor\Controls_Manager;
use LSDPACELM\Widgets;

class Share extends Widgets
{
    public function get_name(): string
    {
        return 'lsd-listing-share';
    }

    public function get_title(): string
    {
        return esc_html__('Listing Share', 'listdom-elementor');
    }

    public function get_icon(): string
    {
        return 'eicon-share';
    }

    public function register_controls()
    {
        $this->start_controls_section(
            'main_icon_section',
            [
                'label' => esc_html__('Main Icon', 'listdom-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'icon_bg_color',
            [
                'label' => esc_html__('Background Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-share' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'icon_padding',
            [
                'label' => esc_html__('Padding', 'listdom-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-share' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_control(
            'icon_border_radius',
            [
                'label' => esc_html__('Border Radius', 'listdom-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-share' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'main_icon_color',
            [
                'label' => esc_html__('Icon Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-share .lsd-main-icon i' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'main_icon_hover_color',
            [
                'label' => esc_html__('Icon Hover Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-share .lsd-main-icon i:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'sub_icon_section',
            [
                'label' => esc_html__('Sub Icons', 'listdom-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'icon_color',
            [
                'label' => esc_html__('Sub Icon Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-share .lsd-share-list-item a i' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'icon_hover_color',
            [
                'label' => esc_html__('Sub Icon Hover Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-share .lsd-share-list-item a i:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function listing(\LSD_Entity_Listing $listing): string
    {
        return '<div class="lsdaddelm-card-share">' . $listing->get_share_buttons() . '</div>';
    }
}
