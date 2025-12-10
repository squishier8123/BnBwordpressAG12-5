<?php
namespace LSDPACELM\Widgets;

use LSDPACELM\Widgets;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;

class Tags extends Widgets
{
    public function get_name(): string
    {
        return 'lsd-listing-tags';
    }

    public function get_title(): string
    {
        return esc_html__('Listing Tags', 'listdom-elementor');
    }

    public function get_icon(): string
    {
        return 'eicon-tags';
    }

    public function register_controls()
    {
        // Content Tab
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Content', 'listdom-elementor'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        // Layout: Inline or Block
        $this->add_control(
            'layout',
            [
                'label' => esc_html__('Layout', 'listdom-elementor'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'row' => [
                        'title' => esc_html__('Inline', 'listdom-elementor'),
                        'icon' => 'eicon-ellipsis-h',
                    ],
                    'column' => [
                        'title' => esc_html__('Block', 'listdom-elementor'),
                        'icon' => 'eicon-editor-list-ul',
                    ],
                ],
                'default' => 'column',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-tags ul' => 'flex-direction: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'enable_links',
            [
                'label' => esc_html__('Enable Archive Links', 'listdom-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'listdom-elementor'),
                'label_off' => esc_html__('No', 'listdom-elementor'),
                'return_value' => '1',
                'default' => '0',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'box_section',
            [
                'label' => esc_html__('Box', 'listdom-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        // Background Color
        $this->add_control(
            'box_background_color',
            [
                'label' => esc_html__('Background Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-tags' => 'background-color: {{VALUE}} !important',
                ],
            ]
        );

        // Border
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'box_border',
                'label' => esc_html__('Border', 'listdom-elementor'),
                'selector' => '{{WRAPPER}} .lsdaddelm-card-tags',
            ]
        );

        // Border Radius
        $this->add_responsive_control(
            'box_border_radius',
            [
                'label' => esc_html__('Border Radius', 'listdom-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-tags' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'box_padding',
            [
                'label' => esc_html__('Padding', 'listdom-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'default' => [
                    'top' => 3,
                    'right' => 3,
                    'bottom' => 3,
                    'left' => 3,
                    'unit' => 'px',
                    'isLinked' => true,
                ],
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-tags' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'gap',
            [
                'label' => esc_html__('Gap Between Items', 'listdom-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'unit' => 'px',
                    'size' => 4,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                        'step' => 1,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 5,
                        'step' => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-tags ul' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'items_section',
            [
                'label' => esc_html__('Items', 'listdom-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'tags_typography',
                'label' => esc_html__('Typography', 'listdom-elementor'),
                'selector' => '{{WRAPPER}} .lsdaddelm-card-tags li, {{WRAPPER}} .lsdaddelm-card-tags a, {{WRAPPER}} .lsdaddelm-card-tags span.lsd-single-term',
            ]
        );

        $this->add_control(
            'item_color',
            [
                'label' => esc_html__('Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-tags a, {{WRAPPER}} .lsdaddelm-card-tags span.lsd-single-term' => 'color: {{VALUE}} !important',
                ],
            ]
        );

        // Background Color
        $this->add_control(
            'item_background_color',
            [
                'label' => esc_html__('Background Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-tags a, {{WRAPPER}} .lsdaddelm-card-tags span.lsd-single-term' => 'background-color: {{VALUE}} !important',
                ],
            ]
        );

        $this->add_control(
            'item_hover_background_color',
            [
                'label' => esc_html__('Hover Background Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-tags li:hover a, {{WRAPPER}} .lsdaddelm-card-tags li:hover span.lsd-single-term' => 'background-color: {{VALUE}} !important',
                ],
            ]
        );

        $this->add_control(
            'item_hover_color',
            [
                'label' => esc_html__('Hover Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-tags li:hover a, {{WRAPPER}} .lsdaddelm-card-tags li:hover span.lsd-single-term' => 'color: {{VALUE}} !important',
                ],
            ]
        );

        // Border
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'item_border',
                'label' => esc_html__('Border', 'listdom-elementor'),
                'selector' => '{{WRAPPER}} .lsdaddelm-card-tags ul a, {{WRAPPER}} .lsdaddelm-card-tags ul span.lsd-single-term',
            ]
        );

        // Border Radius
        $this->add_responsive_control(
            'item_border_radius',
            [
                'label' => esc_html__('Border Radius', 'listdom-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-tags a, {{WRAPPER}} .lsdaddelm-card-tags span.lsd-single-term' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'items_padding',
            [
                'label' => esc_html__('Padding', 'listdom-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'default' => [
                    'top' => 3,
                    'right' => 3,
                    'bottom' => 3,
                    'left' => 3,
                    'unit' => 'px',
                    'isLinked' => true,
                ],
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-tags a, {{WRAPPER}} .lsdaddelm-card-tags span.lsd-single-term' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function listing(\LSD_Entity_Listing $listing): string
    {
        $settings = $this->get_settings_for_display();
        $enable_links = isset($settings['enable_links']) && $settings['enable_links'] === '1';

        return '<div class="lsdaddelm-card-tags">' . $listing->get_tags($enable_links) . '</div>';
    }
}
