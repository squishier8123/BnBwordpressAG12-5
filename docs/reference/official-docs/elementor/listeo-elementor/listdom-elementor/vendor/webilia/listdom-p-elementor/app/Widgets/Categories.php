<?php
namespace LSDPACELM\Widgets;

use LSDPACELM\Widgets;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;

class Categories extends Widgets
{
    public function get_name(): string
    {
        return 'lsd-listing-categories';
    }

    public function get_title(): string
    {
        return esc_html__('Listing Categories', 'listdom-elementor');
    }

    public function get_icon(): string
    {
        return 'eicon-gallery-grid';
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

        $this->add_control(
            'default_colors',
            [
                'label' => esc_html__('Default Colors', 'listdom-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'listdom-elementor'),
                'label_off' => esc_html__('No', 'listdom-elementor'),
                'default' => 'yes',
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
                    '{{WRAPPER}} .lsdaddelm-card-categories' => 'flex-direction: {{VALUE}} !important',
                ],
            ]
        );

        $this->add_control(
            'hr_layout',
            [
                'type' => Controls_Manager::DIVIDER,
            ]
        );

        $this->add_control(
            'display_name',
            [
                'label' => esc_html__('Category Name', 'listdom-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'listdom-elementor'),
                'label_off' => esc_html__('Hide', 'listdom-elementor'),
                'return_value' => '1',
                'default' => '1',
            ]
        );

        $this->add_control(
            'display_icon',
            [
                'label' => esc_html__('Category Icon', 'listdom-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'listdom-elementor'),
                'label_off' => esc_html__('Hide', 'listdom-elementor'),
                'return_value' => '1',
                'default' => '0',
            ]
        );

        $this->add_control(
            'enable_link',
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
                    '{{WRAPPER}} .lsdaddelm-card-categories' => 'background-color: {{VALUE}} !important',
                ],
            ]
        );

        // Border
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'box_border',
                'label' => esc_html__('Border', 'listdom-elementor'),
                'selector' => '{{WRAPPER}} .lsdaddelm-card-categories',
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
                    '{{WRAPPER}} .lsdaddelm-card-categories' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .lsdaddelm-card-categories' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .lsdaddelm-card-categories' => 'gap: {{SIZE}}{{UNIT}};',
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
                'name' => 'categories_typography',
                'label' => esc_html__('Typography', 'listdom-elementor'),
                'selector' => '{{WRAPPER}} .lsdaddelm-card-categories a, {{WRAPPER}} .lsdaddelm-card-categories span.lsd-single-term',
            ]
        );

        $this->add_control(
            'padding',
            [
                'label' => esc_html__('Padding', 'listdom-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'default' => [
                    'top' => 5,
                    'right' => 5,
                    'bottom' => 5,
                    'left' => 5,
                    'unit' => 'px',
                    'isLinked' => true,
                ],
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-categories a, {{WRAPPER}} .lsdaddelm-card-categories span.lsd-single-term' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'hr_typography',
            [
                'type' => Controls_Manager::DIVIDER,
            ]
        );

        $this->add_control(
            'bg_color',
            [
                'label' => esc_html__('Background Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-categories a, {{WRAPPER}} .lsdaddelm-card-categories span.lsd-single-term' => 'background-color: {{VALUE}} !important',
                ],
                'condition' => [
                    'default_colors' => ''
                ]
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label' => esc_html__('Text Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-categories a, {{WRAPPER}} .lsdaddelm-card-categories span.lsd-single-term' => 'color: {{VALUE}} !important',
                ],
                'condition' => [
                    'default_colors' => ''
                ]
            ]
        );

        $this->add_control(
            'bg_hover_color',
            [
                'label' => esc_html__('Hover Background Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-categories a:hover, {{WRAPPER}} .lsdaddelm-card-categories span.lsd-single-term:hover' => 'background-color: {{VALUE}} !important',
                ],
            ]
        );

        $this->add_control(
            'text_hover_color',
            [
                'label' => esc_html__('Hover Text Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-categories a:hover, {{WRAPPER}} .lsdaddelm-card-categories span.lsd-single-term:hover' => 'color: {{VALUE}} !important',
                ],
            ]
        );

        $this->add_control(
            'hr_colors',
            [
                'type' => Controls_Manager::DIVIDER,
            ]
        );

        $this->add_control(
            'border_color',
            [
                'label' => esc_html__('Border Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-categories a, {{WRAPPER}} .lsdaddelm-card-categories span.lsd-single-term' => 'border-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'border_width',
            [
                'label' => esc_html__('Border', 'listdom-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'default' => [
                    'top' => 0,
                    'right' => 0,
                    'bottom' => 0,
                    'left' => 0,
                    'unit' => 'px',
                    'isLinked' => true,
                ],
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-categories a, {{WRAPPER}} .lsdaddelm-card-categories span.lsd-single-term' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'border_radius',
            [
                'label' => esc_html__('Border Radius', 'listdom-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'default' => [
                    'top' => 3,
                    'right' => 3,
                    'bottom' => 3,
                    'left' => 3,
                    'unit' => 'px',
                    'isLinked' => true,
                ],
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-categories a, {{WRAPPER}} .lsdaddelm-card-categories span.lsd-single-term' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'hr_border',
            [
                'type' => Controls_Manager::DIVIDER,
                'condition' => [
                    'display_name' => '1',
                    'display_icon' => '1',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_gap',
            [
                'label' => esc_html__('Icon gap', 'listdom-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
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
                    '%' => [
                        'min' => 0,
                        'max' => 10,
                        'step' => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-categories a i, {{WRAPPER}} .lsdaddelm-card-categories span.lsd-single-term i' => 'margin-right: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'display_name' => '1',
                    'display_icon' => '1',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function listing(\LSD_Entity_Listing $listing): string
    {
        // Display Main Category or All Categories
        $multiple = apply_filters('lsd_listing_display_multiple_categories', false);

        $settings = $this->get_settings_for_display();
        $default_colors = $settings['default_colors'] === 'yes';
        $display_name = !isset($settings['display_name']) || $settings['display_name'] === '1';
        $display_icon = isset($settings['display_icon']) && $settings['display_icon'] === '1';
        $enable_link = isset($settings['enable_link']) && $settings['enable_link'] === '1';

        // Get Categories
        return '<div class="lsdaddelm-card-categories">' . $listing->get_categories([
            'show_color' => $default_colors,
            'multiple_categories' => $multiple,
            'display_name' => $display_name,
            'display_icon' => $display_icon,
            'enable_link' => $enable_link,
        ]) . '</div>';
    }
}
