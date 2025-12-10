<?php
namespace LSDPACELM\Widgets;

use LSDPACELM\Widgets;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;

class Labels extends Widgets
{
    public function get_name(): string
    {
        return 'lsd-listing-labels';
    }

    public function get_title(): string
    {
        return esc_html__('Listing Labels', 'listdom-elementor');
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
                'default' => 'row',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-labels .lsd-labels-list' => 'flex-direction: {{VALUE}}',
                    '{{WRAPPER}} .lsdaddelm-card-labels .lsd-labels-simple' => 'flex-direction: {{VALUE}}',
                ],
            ]
        );

        // Link to the label archive: Disable/Enable
        $this->add_control(
            'enable_link',
            [
                'label' => esc_html__('Link to Label Archive', 'listdom-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'listdom-elementor'),
                'label_off' => esc_html__('No', 'listdom-elementor'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'style_section',
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
                    '{{WRAPPER}} .lsdaddelm-card-labels' => 'background-color: {{VALUE}} !important',
                ],
            ]
        );

        // Border
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'box_border',
                'label' => esc_html__('Border', 'listdom-elementor'),
                'selector' => '{{WRAPPER}} .lsdaddelm-card-labels',
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
                    '{{WRAPPER}} .lsdaddelm-card-labels' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .lsdaddelm-card-labels' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .lsdaddelm-card-labels .lsd-labels-list' => 'gap: {{SIZE}}{{UNIT}};',
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
                'name' => 'labels_typography',
                'label' => esc_html__('Typography', 'listdom-elementor'),
                'selector' => '{{WRAPPER}} .lsdaddelm-card-labels li, {{WRAPPER}} .lsdaddelm-card-labels a',
            ]
        );

        $this->add_control(
            'item_color',
            [
                'label' => esc_html__('Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-labels a, {{WRAPPER}} .lsdaddelm-card-labels span' => 'color: {{VALUE}} !important',
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
                    '{{WRAPPER}} .lsdaddelm-card-labels a, {{WRAPPER}} .lsdaddelm-card-labels span' => 'background-color: {{VALUE}} !important',
                ],
            ]
        );

        $this->add_control(
            'item_hover_background_color',
            [
                'label' => esc_html__('Hover Background Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-labels li:hover a, {{WRAPPER}} .lsdaddelm-card-labels li:hover span' => 'background-color: {{VALUE}} !important',
                ],
            ]
        );

        $this->add_control(
            'item_hover_color',
            [
                'label' => esc_html__('Hover Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-labels li:hover a, {{WRAPPER}} .lsdaddelm-card-labels li:hover span' => 'color: {{VALUE}} !important',
                ],
            ]
        );

        // Border
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'item_border',
                'label' => esc_html__('Border', 'listdom-elementor'),
                'selector' => '{{WRAPPER}} .lsdaddelm-card-labels .lsd-labels-list-item a, {{WRAPPER}} .lsdaddelm-card-labels .lsd-labels-list-item span',
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
                    '{{WRAPPER}} .lsdaddelm-card-labels a, {{WRAPPER}} .lsdaddelm-card-labels span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .lsdaddelm-card-labels a, {{WRAPPER}} .lsdaddelm-card-labels span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function listing(\LSD_Entity_Listing $listing): string
    {
        $settings = $this->get_settings_for_display();
        $enable_link = isset($settings['enable_link']) && $settings['enable_link'] === 'yes';

        return '<div class="lsdaddelm-card-labels">' . $listing->get_labels('tags', $enable_link) . '</div>';
    }
}
