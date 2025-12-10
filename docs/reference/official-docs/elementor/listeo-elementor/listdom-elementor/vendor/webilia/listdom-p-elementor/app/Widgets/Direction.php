<?php
namespace LSDPACELM\Widgets;

use LSDPACELM\Widgets;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;

class Direction extends Widgets
{
    public function get_name(): string
    {
        return 'lsd-listing-direction';
    }

    public function get_title(): string
    {
        return esc_html__('External Direction', 'listdom-elementor');
    }

    public function get_icon(): string
    {
        return 'eicon-long-arrow-right';
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
            'label',
            [
                'label' => esc_html__('Link Text', 'listdom-elementor'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'placeholder' => esc_attr__('Directions', 'listdom-elementor'),
                'default' => esc_html__('Directions', 'listdom-elementor'),
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

        $this->add_control('icon', [
            'label' => esc_html__('Icon', 'listdom-elementor'),
            'type' => Controls_Manager::ICONS,
            'default' => [
                'value' => 'fas fa-directions',
                'library' => 'fa-solid',
            ],
            'condition' => [
                'show_icon' => '1',
            ],
        ]);

        $this->end_controls_section();

        $this->start_controls_section(
            'general_style_section',
            [
                'label' => esc_html__('General', 'listdom-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'link_typography',
                'selector' => '{{WRAPPER}} .lsdaddelm-card-am-direction a',
            ]
        );

        $this->add_control(
            'bg_color',
            [
                'label' => esc_html__('Background Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-am-direction' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label' => esc_html__('Text Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-am-direction a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_position',
            [
                'label' => esc_html__('Icon Position', 'listdom-elementor'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'row' => [
                        'title' => esc_html__('Left', 'listdom-elementor'),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'row-reverse' => [
                        'title' => esc_html__('Right', 'listdom-elementor'),
                        'icon' => 'eicon-h-align-right',
                    ],
                    'column' => [
                        'title' => esc_html__('Top', 'listdom-elementor'),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'column-reverse' => [
                        'title' => esc_html__('Bottom', 'listdom-elementor'),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                ],
                'default' => 'row',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-am-direction a' => 'flex-direction: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_vertical_align',
            [
                'label' => esc_html__('Vertical Alignment', 'listdom-elementor'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__('Top', 'listdom-elementor'),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'center' => [
                        'title' => esc_html__('Middle', 'listdom-elementor'),
                        'icon' => 'eicon-v-align-middle',
                    ],
                    'flex-end' => [
                        'title' => esc_html__('Bottom', 'listdom-elementor'),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                ],
                'default' => 'center',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-am-direction a' => 'align-items: {{VALUE}};',
                ],
                'condition' => [
                    'icon_position' => ['row', 'row-reverse'],
                ],
            ]
        );

        $this->add_responsive_control(
            'text_align',
            [
                'label' => esc_html__('Text Alignment', 'listdom-elementor'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__('Left', 'listdom-elementor'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'listdom-elementor'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'flex-end' => [
                        'title' => esc_html__('Right', 'listdom-elementor'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'center',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-am-direction a' => 'justify-content: {{VALUE}};',
                ],
                'condition' => [
                    'icon_position' => ['row', 'row-reverse'],
                ],
            ]
        );

        $this->add_responsive_control(
            'column_text_align',
            [
                'label' => esc_html__('Text Alignment', 'listdom-elementor'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__('Left', 'listdom-elementor'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'listdom-elementor'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'flex-end' => [
                        'title' => esc_html__('Right', 'listdom-elementor'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'center',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-am-direction a' => 'align-items: {{VALUE}};',
                ],
                'condition' => [
                    'icon_position' => ['column', 'column-reverse'],
                ],
            ]
        );

        $this->add_responsive_control(
            'padding',
            [
                'label' => esc_html__('Padding', 'listdom-elementor'),
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
                    '{{WRAPPER}} .lsdaddelm-card-am-direction' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'border_radius',
            [
                'label' => esc_html__('Border Radius', 'listdom-elementor'),
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
                    '{{WRAPPER}} .lsdaddelm-card-am-direction' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'icon_style_section',
            [
                'label' => esc_html__('Icon', 'listdom-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_icon' => '1',
                ],
            ]
        );

        $this->add_control(
            'icon_bg_color',
            [
                'label' => esc_html__('Background Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-am-direction i' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .lsdaddelm-card-am-direction svg' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label' => esc_html__('Icon Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-am-direction i' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .lsdaddelm-card-am-direction svg' => 'fill: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'gap',
            [
                'label' => esc_html__('Gap', 'listdom-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-am-direction a' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control('icon_scale', [
            'label' => esc_html__('Icon Scale', 'listdom-elementor'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['em'],
            'range' => [
                'em' => [
                    'min' => 0.0,
                    'max' => 4.0,
                    'step' => 0.1,
                ],
            ],
            'default' => [
                'unit' => 'em',
                'size' => 1,
            ],

            'selectors' => [
                '{{WRAPPER}} .lsdaddelm-card-am-direction img' => 'transform: scale({{SIZE}});',
                '{{WRAPPER}} .lsdaddelm-card-am-direction svg' => 'transform: scale({{SIZE}}); width: calc(1em * {{SIZE}}); height: calc(1em * {{SIZE}});',
                '{{WRAPPER}} .lsdaddelm-card-am-direction i' => 'transform: scale({{SIZE}});',
            ],
        ]);

        $this->add_responsive_control(
            'icon_padding',
            [
                'label' => esc_html__('Padding', 'listdom-elementor'),
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
                    '{{WRAPPER}} .lsdaddelm-card-am-direction svg' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .lsdaddelm-card-am-direction i' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_border_radius',
            [
                'label' => esc_html__('Border Radius', 'listdom-elementor'),
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
                    '{{WRAPPER}} .lsdaddelm-card-am-direction svg' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .lsdaddelm-card-am-direction i' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();
    }

    protected function listing(\LSD_Entity_Listing $listing): string
    {
        // Check Existence of Addon
        if (!class_exists(\LSDPACAM\Direction::class))
        {
            return \LSD_Main::alert(esc_html__('Advanced Map addon should be installed and activated!', 'listdom-elementor'), 'warning');
        }

        // Settings
        $settings = $this->get_settings_for_display();

        // Label
        $label = isset($settings['label']) && trim($settings['label']) !== '' ? $settings['label'] : '';

        // Icon
        $icon_settings = isset($settings['icon']) && is_array($settings['icon']) ? $settings['icon'] : ['value' => 'fas fa-directions', 'library' => 'fa-solid'];

        ob_start();
        Icons_Manager::render_icon($icon_settings, ['aria-hidden' => 'true']);
        $icon = ob_get_clean();

        $am = new \LSDPACAM\Direction();
        return '<div class="lsdaddelm-card-am-direction">' . $am->link(
                $listing,
                $label,
                isset($settings['show_icon']) && $settings['show_icon'],
                $icon
            ) . '</div>';
    }
}
