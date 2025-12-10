<?php
namespace LSDPACELM\Widgets;

use Elementor\Group_Control_Typography;
use LSDPACELM\Widgets;
use Elementor\Controls_Manager;

class Rate extends Widgets
{
    public function get_name(): string
    {
        return 'lsd-listing-rate';
    }

    public function get_title(): string
    {
        return esc_html__('Listing Rate', 'listdom-elementor');
    }

    public function get_icon(): string
    {
        return 'eicon-star';
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
                'default' => 'stars',
                'options' => [
                    'stars' => esc_html__('Stars', 'listdom-elementor'),
                    'summary' => esc_html__('Summary', 'listdom-elementor'),
                ],
            ]
        );

        $this->add_control(
            'show_count',
            [
                'label' => esc_html__('Show Review Count', 'listdom-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'condition' => [
                    'type' => 'stars',
                ],
            ]
        );

        $this->end_controls_section();

        // Styling Section
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
                'name' => 'rate_typography',
                'label' => esc_html__('Typography', 'listdom-elementor'),
                'selector' => '{{WRAPPER}} .lsdaddelm-rating-stars .lsd-listing-rate a',
                'condition' => [
                    'type' => 'stars',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'summary_typography',
                'label' => esc_html__('Typography', 'listdom-elementor'),
                'selector' => '{{WRAPPER}} .lsdaddelm-rating-stars .lsd-listing-rate .lsd-summary',
                'condition' => [
                    'type' => 'summary',
                ],
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label' => esc_html__('Text Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#333',
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-rating-stars .lsd-listing-rate a' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .lsdaddelm-rating-stars .lsd-listing-rate .lsd-summary' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'text_shadow',
                'label' => esc_html__('Text Shadow', 'listdom-elementor'),
                'selector' => '{{WRAPPER}} .lsd-listing-rate a, {{WRAPPER}} .lsd-listing-rate .lsd-summary, {{WRAPPER}} .lsd-stars i',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'stars_section',
            [
                'label' => esc_html__('Stars', 'listdom-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'type' => 'stars',
                ],
            ]
        );

        $this->add_control(
            'stars_spacing',
            [
                'label' => esc_html__('Stars Gap', 'listdom-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .lsd-stars' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'stars_background',
            [
                'label' => esc_html__('Stars Background', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lsd-stars span' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'stars_padding',
            [
                'label' => esc_html__('Stars Padding', 'listdom-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .lsd-stars span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'stars_border_radius',
            [
                'label' => esc_html__('Border Radius', 'listdom-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .lsd-stars span' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'stars_color',
            [
                'label' => esc_html__('Stars Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#FFD700',
                'selectors' => [
                    '{{WRAPPER}} .lsd-stars i' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'empty_stars_color',
            [
                'label' => esc_html__('Empty Stars Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ddd',
                'selectors' => [
                    '{{WRAPPER}} .lsd-stars i.far' => 'color: {{VALUE}} !important;',
                ],
            ]
        );


        $this->end_controls_section();
    }

    protected function listing(\LSD_Entity_Listing $listing): string
    {
        // Check Existence of Addon
        if (!class_exists(\LSDPACREV\Base::class))
        {
            return \LSD_Main::alert(esc_html__('Review addon should be installed and activated!', 'listdom-elementor'), 'warning');
        }

        $settings = $this->get_settings_for_display();
        $type = $settings['type'] ?? 'stars';
        $link = $settings['show_count'] === 'yes';

        return '<div class="lsdaddelm-rating-stars">' . $listing->get_rate_stars($type, $link) . '</div>';
    }
}
