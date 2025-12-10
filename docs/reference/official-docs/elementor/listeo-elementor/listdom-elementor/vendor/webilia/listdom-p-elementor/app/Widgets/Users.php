<?php
namespace LSDPACELM\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class Users extends Widget_Base
{
    public function get_name(): string
    {
        return 'lsd-listing-users';
    }

    public function get_title(): string
    {
        return esc_html__('Listdom Users', 'listdom-elementor');
    }

    public function get_categories(): array
    {
        return ['listdom'];
    }

    public function get_icon(): string
    {
        return 'eicon-person';
    }

    protected function register_controls()
    {
        $this->start_controls_section(
            'users_section',
            [
                'label' => esc_html__('Users', 'listdom-elementor'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'style',
            [
                'label' => esc_html__('Style', 'listdom-elementor'),
                'type' => Controls_Manager::SELECT,
                'default' => 'list',
                'options' => [
                    'list' => esc_html__('List', 'listdom-elementor'),
                    'grid' => esc_html__('Grid', 'listdom-elementor'),
                ],
            ]
        );

        $this->add_control(
            'limit',
            [
                'label' => esc_html__('Limit', 'listdom-elementor'),
                'type' => Controls_Manager::NUMBER,
                'default' => 12,
                'min' => 1,
                'max' => 100,
            ]
        );

        $this->add_control(
            'columns',
            [
                'label' => esc_html__('Columns', 'listdom-elementor'),
                'type' => Controls_Manager::NUMBER,
                'default' => 4,
                'min' => 1,
                'max' => 8,
                'condition' => [
                    'style' => 'grid',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_users_section',
            [
                'label' => esc_html__('Container', 'listdom-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        // Container styles
        $this->add_control(
            'container_bg',
            [
                'label' => esc_html__('Background Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-users-shortcode .lsd-user-card' => 'background-color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_responsive_control(
            'container_padding',
            [
                'label' => esc_html__('Padding', 'listdom-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-users-shortcode .lsd-user-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'container_border',
                'selector' => '{{WRAPPER}} .lsdaddelm-users-shortcode .lsd-user-card',
            ]
        );

        $this->add_responsive_control(
            'container_border_radius',
            [
                'label' => esc_html__('Border Radius', 'listdom-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-users-shortcode .lsd-user-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Content Section Styles
        $this->start_controls_section(
            'section_author_name',
            [
                'label' => esc_html__('Author Name', 'listdom-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        // Name
        $this->add_control(
            'name_text_color',
            [
                'label' => esc_html__('Text Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-users-shortcode .lsd-user-name' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'name_typography',
                'selector' => '{{WRAPPER}} .lsdaddelm-users-shortcode .lsd-user-name',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_job_title',
            [
                'label' => esc_html__('Job Title', 'listdom-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        // Job Title
        $this->add_control(
            'job_title_text_color',
            [
                'label' => esc_html__('Text Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-users-shortcode .lsd-user-job-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'job_title_typography',
                'selector' => '{{WRAPPER}} .lsdaddelm-users-shortcode .lsd-user-job-title',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_contact_info',
            [
                'label' => esc_html__('Contact Info', 'listdom-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        // Contact Info
        $this->add_control(
            'contact_info_icon_color',
            [
                'label' => esc_html__('Icon Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-users-shortcode .lsd-user-info .lsd-user-bottom-bar .lsd-user-socials i' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_button',
            [
                'label' => esc_html__('Button', 'listdom-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        // Button Background Color
        $this->add_control(
            'button_bg_color',
            [
                'label' => esc_html__('Background Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-users-shortcode .lsd-users-wrapper .lsd-view-profile-button' => 'background: {{VALUE}} !important;',
                ],
            ]
        );

        // Button Text Color
        $this->add_control(
            'button_text_color',
            [
                'label' => esc_html__('Text Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-users-shortcode .lsd-users-wrapper .lsd-view-profile-button' => 'color: {{VALUE}} !important;',
                ],
            ]
        );

        // Button Padding
        $this->add_responsive_control(
            'button_padding',
            [
                'label' => esc_html__('Padding', 'listdom-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-users-shortcode .lsd-users-wrapper .lsd-view-profile-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Button Border
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'button_border',
                'selector' => '{{WRAPPER}} .lsdaddelm-users-shortcode .lsd-users-wrapper .lsd-view-profile-button',
            ]
        );

        // Button Border Radius
        $this->add_responsive_control(
            'button_border_radius',
            [
                'label' => esc_html__('Border Radius', 'listdom-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-users-shortcode .lsd-users-wrapper .lsd-view-profile-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_bio',
            [
                'label' => esc_html__('Bio', 'listdom-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'style' => 'list',
                ],
            ]
        );

        // Bio
        $this->add_control(
            'bio_text_color',
            [
                'label' => esc_html__('Text Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-users-shortcode .lsd-user-card .lsd-user-top-bar .lsd-user-bio' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'bio_typography',
                'selector' => '{{WRAPPER}} .lsdaddelm-users-shortcode .lsd-user-card .lsd-user-top-bar .lsd-user-bio',
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $style = isset($settings['style']) ? esc_attr($settings['style']) : 'list';
        $limit = isset($settings['limit']) ? intval($settings['limit']) : 12;
        $columns = isset($settings['columns']) ? intval($settings['columns']) : 4;

        echo '<div class="lsdaddelm-users-shortcode">' .
            do_shortcode("[listdom-users style='$style' limit='$limit' columns='$columns']") .
        '</div>';
    }
}
