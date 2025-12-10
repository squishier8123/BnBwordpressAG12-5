<?php
namespace LSDPACELM\Widgets;

use LSDPACELM\Widgets;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

class Availability extends Widgets
{
    public function get_name(): string
    {
        return 'lsd-listing-availability';
    }

    public function get_title(): string
    {
        return esc_html__('Listing Working Hours', 'listdom-elementor');
    }

    public function get_icon(): string
    {
        return 'eicon-calendar';
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
            'type',
            [
                'label' => esc_html__('Type', 'listdom-elementor'),
                'type' => Controls_Manager::SELECT,
                'default' => 'one-day',
                'options' => [
                    'one-day' => esc_html__('One Day', 'listdom-elementor'),
                    'full' => esc_html__('Full Week', 'listdom-elementor'),
                ],
            ]
        );

        $this->add_control(
            'display_icon',
            [
                'label' => esc_html__('Display Icon', 'listdom-elementor'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'inline' => esc_html__('Yes', 'listdom-elementor'),
                    'none' => esc_html__('No', 'listdom-elementor'),
                ],
                'default' => 'inline',
                'selectors' => [
                    '{{WRAPPER}} .lsd-ava-one-day .lsd-icon' => 'display: {{VALUE}};',
                ],
                'condition' => ['type' => 'one-day'],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'one_day_text_section',
            [
                'label' => esc_html__('Text & Color', 'listdom-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['type' => 'one-day'],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'one_day_typography',
                'label' => esc_html__('Typography', 'listdom-elementor'),
                'selector' => '{{WRAPPER}} .lsd-ava-hour',
            ]
        );

        $this->add_control(
            'one_day_text_color',
            [
                'label' => esc_html__('Text Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lsd-ava-hour' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'one_day_off_text_color',
            [
                'label' => esc_html__('Off Text Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lsd-ava-one-day-off .lsd-ava-hour' => 'color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'one_day_icon_section',
            [
                'label' => esc_html__('Icon', 'listdom-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['type' => 'one-day'],
            ]
        );

        $this->add_control(
            'one_day_icon_color',
            [
                'label' => esc_html__('Icon Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lsd-icon' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'type' => 'one-day',
                    'display_icon' => 'inline',
                ],
            ]
        );

        $this->add_control(
            'one_day_gap',
            [
                'label' => esc_html__('Gap', 'listdom-elementor'),
                'type' => Controls_Manager::SLIDER,
                'selectors' => [
                    '{{WRAPPER}} .lsd-icon' => 'margin-right: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'type' => 'one-day',
                    'display_icon' => 'inline',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'full_week_text_section',
            [
                'label' => esc_html__('Text & Color', 'listdom-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['type' => 'full'],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'weekday_typography',
                'label' => esc_html__('Weekday Typography', 'listdom-elementor'),
                'selector' => '{{WRAPPER}} .lsd-ava-weekday-column',
            ]
        );

        $this->add_control(
            'weekday_text_color',
            [
                'label' => esc_html__('Weekday Text Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lsd-ava-weekday-column' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'hour_typography',
                'label' => esc_html__('Hour Typography', 'listdom-elementor'),
                'selector' => '{{WRAPPER}} .lsd-ava-hours-column',
            ]
        );

        $this->add_control(
            'hour_text_color',
            [
                'label' => esc_html__('Hour Text Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lsd-ava-hours-column' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'off_text_color',
            [
                'label' => esc_html__('Off Text Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lsd-ava-offday .lsd-ava-hours-column' => 'color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'full_week_gap_section',
            [
                'label' => esc_html__('Gaps', 'listdom-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['type' => 'full'],
            ]
        );

        $this->add_control(
            'gap_weekday_hour',
            [
                'label' => esc_html__('Text Gap', 'listdom-elementor'),
                'type' => Controls_Manager::SLIDER,
                'selectors' => [
                    '{{WRAPPER}} .lsd-ava-weekday-wrapper .lsd-row' => 'column-gap: {{SIZE}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->add_control(
            'gap_rows',
            [
                'label' => esc_html__('Row Gap', 'listdom-elementor'),
                'type' => Controls_Manager::SLIDER,
                'selectors' => [
                    '{{WRAPPER}} .lsd-ava-week .lsd-ava-weekday-wrapper' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function listing(\LSD_Entity_Listing $listing): string
    {
        $settings = $this->get_settings_for_display();
        $type = $settings['type'] ?? 'one-day';

        return '<div class="lsdaddelm-card-availability">' . $listing->get_availability($type === 'one-day') . '</div>';
    }
}
