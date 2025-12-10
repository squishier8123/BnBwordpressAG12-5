<?php
namespace LSDPACELM\Widgets;

use Elementor\Group_Control_Typography;
use LSDPACELM\Widgets;
use Elementor\Controls_Manager;

class Breadcrumb extends Widgets
{
    public function get_name(): string
    {
        return 'lsd-listing-breadcrumb';
    }

    public function get_title(): string
    {
        return esc_html__('Listing Breadcrumb', 'listdom-elementor');
    }

    public function get_icon(): string
    {
        return 'fa fa-sitemap';
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
            'icon',
            [
                'label' => esc_html__('Icon', 'listdom-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'default' => true,
            ]
        );

        $this->add_control(
            'taxonomy',
            [
                'label' => esc_html__('Taxonomy', 'listdom-elementor'),
                'type' => Controls_Manager::SELECT,
                'default' => 'listdom-category',
                'options' => [
                    'listdom-category'           => esc_html__('Category', 'listdom-elementor'),
                    'listdom-tag'           => esc_html__('Tag', 'listdom-elementor'),
                    'listdom-location'           => esc_html__('Location', 'listdom-elementor'),
                    'listdom-label'           => esc_html__('Label', 'listdom-elementor'),
                    'listdom-features'           => esc_html__('Feature', 'listdom-elementor'),
                    ],
            ]
        );

        $this->end_controls_section();

        // Styling Section
        $this->start_controls_section(
            'general_section',
            [
                'label' => esc_html__('General', 'listdom-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'breadcrumb_item_gap',
            [
                'label' => esc_html__('Item Gap', 'listdom-elementor'),
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
                    '{{WRAPPER}} .lsdaddelm-breadcrumb .lsd-breadcrumb-item' => 'gap: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .lsdaddelm-breadcrumb .lsd-breadcrumb-list' => 'gap: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'home_section',
            [
                'label' => esc_html__('Home', 'listdom-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        // Home breadcrumb styles
        $this->add_control(
            'home_text_color',
            [
                'label' => esc_html__('Text Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-breadcrumb .lsd-home-page a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'home_icon_color',
            [
                'label' => esc_html__('Icon Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'condition' => ['icon' => 'yes'],
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-breadcrumb .lsd-home-page i' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'home_icon_size',
            [
                'label' => esc_html__('Icon Size', 'listdom-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'range' => [
                    'px' => ['min' => 8, 'max' => 64],
                ],
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-breadcrumb .lsd-home-page i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
                'condition' => ['icon' => 'yes'],
            ]
        );

        $this->add_responsive_control(
            'home_icon_text_gap',
            [
                'label' => esc_html__('Icon & Text Gap', 'listdom-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'condition' => ['icon' => 'yes'],
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
                    '{{WRAPPER}} .lsdaddelm-breadcrumb .lsd-home-page a' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'home_typography',
                'label' => esc_html__('Typography', 'listdom-elementor'),
                'selector' => '{{WRAPPER}} .lsdaddelm-breadcrumb .lsd-home-page a',
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'taxonomy_section',
            [
                'label' => esc_html__('Taxonomy', 'listdom-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        // Taxonomy breadcrumb styles
        $this->add_control(
            'taxonomy_text_color',
            [
                'label' => esc_html__('Text Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-breadcrumb .lsd-taxonomy-page a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'taxonomy_typography',
                'label' => esc_html__('Typography', 'listdom-elementor'),
                'selector' => '{{WRAPPER}} .lsdaddelm-breadcrumb .lsd-taxonomy-page a',
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'current_section',
            [
                'label' => esc_html__('Current', 'listdom-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        // Current breadcrumb styles
        $this->add_control(
            'current_text_color',
            [
                'label' => esc_html__('Text Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-breadcrumb .lsd-current-page span' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'current_typography',
                'label' => esc_html__('Typography', 'listdom-elementor'),
                'selector' => '{{WRAPPER}} .lsdaddelm-breadcrumb .lsd-current-page span',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'separator_section',
            [
                'label' => esc_html__('Separator', 'listdom-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'separator_color',
            [
                'label' => esc_html__('Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-breadcrumb .lsd-breadcrumb-item:after' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'separator_icon_size',
            [
                'label' => esc_html__('Icon Size', 'listdom-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'range' => [
                    'px' => ['min' => 8, 'max' => 64],
                ],
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-breadcrumb .lsd-breadcrumb-item:after' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

    }

    protected function listing(\LSD_Entity_Listing $listing): string
    {
        $settings = $this->get_settings_for_display();
        $icon = $settings['icon'] ?? true;
        $taxonomy = $settings['taxonomy'] ?? 'listdom-category';

        return '<div class="lsdaddelm-breadcrumb">' . $listing->get_breadcrumb($icon, $taxonomy) . '</div>';
    }
}
