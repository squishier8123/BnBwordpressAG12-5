<?php
namespace LSDPACELM\Widgets;

use LSDPACELM\Widgets;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

class Stats extends Widgets
{
    public function get_name(): string
    {
        return 'lsd-listing-stats';
    }

    public function get_title(): string
    {
        return esc_html__('Stats Addon', 'listdom-elementor');
    }

    public function get_icon(): string
    {
        return 'eicon-document-file';
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
            'display_zero',
            [
                'label' => esc_html__('Display Zero Values', 'listdom-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'listdom-elementor'),
                'label_off' => esc_html__('No', 'listdom-elementor'),
                'return_value' => '1',
                'default' => '1',
            ]
        );

        $this->add_control(
            'display_visits',
            [
                'label' => esc_html__('Display Visits', 'listdom-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'listdom-elementor'),
                'label_off' => esc_html__('No', 'listdom-elementor'),
                'return_value' => '1',
                'default' => '1',
            ]
        );

        $this->add_control(
            'display_contacts',
            [
                'label' => esc_html__('Display Contacts', 'listdom-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'listdom-elementor'),
                'label_off' => esc_html__('No', 'listdom-elementor'),
                'return_value' => '1',
                'default' => '1',
            ]
        );

        $this->add_control(
            'display_offers',
            [
                'label' => esc_html__('Display Offers', 'listdom-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'listdom-elementor'),
                'label_off' => esc_html__('No', 'listdom-elementor'),
                'return_value' => '1',
                'default' => '1',
            ]
        );

        $this->add_control(
            'display_bookings',
            [
                'label' => esc_html__('Display Bookings', 'listdom-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'listdom-elementor'),
                'label_off' => esc_html__('No', 'listdom-elementor'),
                'return_value' => '1',
                'default' => '1',
            ]
        );

        $this->add_control(
            'display_reviews',
            [
                'label' => esc_html__('Display Reviews', 'listdom-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'listdom-elementor'),
                'label_off' => esc_html__('No', 'listdom-elementor'),
                'return_value' => '1',
                'default' => '1',
            ]
        );

        $this->add_control(
            'display_comments',
            [
                'label' => esc_html__('Display Comments', 'listdom-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'listdom-elementor'),
                'label_off' => esc_html__('No', 'listdom-elementor'),
                'return_value' => '1',
                'default' => '1',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'layout_section',
            [
                'label' => esc_html__('Layout', 'listdom-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

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
                    '{{WRAPPER}} .lsdaddelm-card-stats ul' => 'flex-direction: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'stats_gap',
            [
                'label' => esc_html__('List Gap', 'listdom-elementor'),
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
                        'max' => 20,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-stats ul' => 'gap: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'stats_items_gap',
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
                        'max' => 20,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-stats li' => 'gap: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'typography_section',
            [
                'label' => esc_html__('Typography', 'listdom-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'stats_typography',
                'label' => esc_html__('Typography', 'listdom-elementor'),
                'selector' => '{{WRAPPER}} .lsdaddelm-card-stats span.lsdaddsts-label',
            ]
        );

        $this->add_control(
            'stats_text_color',
            [
                'label' => esc_html__('Text Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-stats .lsdaddsts-label' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'stats_value_typography',
                'label' => esc_html__('Value Typography', 'listdom-elementor'),
                'selector' => '{{WRAPPER}} .lsdaddelm-card-stats .lsdaddsts-value',
            ]
        );

        $this->add_control(
            'stats_value_text_color',
            [
                'label' => esc_html__('Value Text Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-stats .lsdaddsts-value' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'icons_section',
            [
                'label' => esc_html__('Icons', 'listdom-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'stats_icons_bg_color',
            [
                'label' => esc_html__('Icons Background Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-stats i' => 'background-color: {{VALUE}} !important',
                ],
            ]
        );
        
        $this->add_control(
            'stats_icon_color',
            [
                'label' => esc_html__('Icon Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-stats i' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'stats_icon_size',
            [
                'label' => esc_html__('Icon Size', 'listdom-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em'],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 100,
                        'step' => 1,
                    ],
                    'em' => [
                        'min' => 0.5,
                        'max' => 5,
                        'step' => 0.1,
                    ],
                    '%' => [
                        'min' => 10,
                        'max' => 200,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-stats i' => 'font-size: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'stats_icon_border_radius',
            [
                'label' => esc_html__('Icon Border Radius', 'listdom-elementor'),
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
                    '{{WRAPPER}} .lsdaddelm-card-stats i' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function listing(\LSD_Entity_Listing $listing): string
    {
        // Check Existence of Addon
        if (!class_exists(\LSDPACSTS\Base::class))
        {
            return \LSD_Main::alert(esc_html__('Stats addon should be installed and activated!', 'listdom-elementor'), 'warning');
        }

        $settings = $this->get_settings_for_display();

        $args = [
            'display_zero' => $settings['display_zero'] ?? '1',
            'display_visits' => $settings['display_visits'] ?? '1',
            'display_contacts' => $settings['display_contacts'] ?? '1',
            'display_offers' => $settings['display_offers'] ?? '1',
            'display_bookings' => $settings['display_bookings'] ?? '1',
            'display_reviews' => $settings['display_reviews'] ?? '1',
            'display_comments' => $settings['display_comments'] ?? '1',
        ];

        $element = new \LSDPACSTS\Element();
        return '<div class="lsdaddelm-card-stats">' . $element->get($listing->id(), $args) . '</div>';
    }
}
