<?php
namespace LSDPACELM\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class Profile extends Widget_Base
{
    public function get_name(): string
    {
        return 'lsd-listing-profile';
    }

    public function get_title(): string
    {
        return esc_html__('Listdom Profile', 'listdom-elementor');
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
        // Profile Section Styles
        $this->start_controls_section(
            'section_profile_section',
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
                    '{{WRAPPER}} .lsdaddelm-profile-shortcode .lsd-profile-wrapper .lsd-profile-details .lsd-profile-box' => 'background-color: {{VALUE}} !important;',
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
                    '{{WRAPPER}} .lsdaddelm-profile-shortcode .lsd-profile-wrapper .lsd-profile-details .lsd-profile-box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'container_border',
                'selector' => '{{WRAPPER}} .lsdaddelm-profile-shortcode .lsd-profile-wrapper .lsd-profile-details .lsd-profile-box',
            ]
        );

        $this->add_responsive_control(
            'container_border_radius',
            [
                'label' => esc_html__('Border Radius', 'listdom-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-profile-shortcode .lsd-profile-wrapper .lsd-profile-details .lsd-profile-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Title styles
        $this->add_control(
            'title_text_color',
            [
                'label' => esc_html__('Title Text Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-profile-shortcode .lsd-profile-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .lsdaddelm-profile-shortcode .lsd-profile-title',
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
                    '{{WRAPPER}} .lsdaddelm-profile-shortcode .lsd-profile-name' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'name_typography',
                'selector' => '{{WRAPPER}} .lsdaddelm-profile-shortcode .lsd-profile-name',
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
                    '{{WRAPPER}} .lsdaddelm-profile-shortcode .lsd-job-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'job_title_typography',
                'selector' => '{{WRAPPER}} .lsdaddelm-profile-shortcode .lsd-job-title',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_count',
            [
                'label' => esc_html__('Listing Count', 'listdom-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        // Count
        $this->add_control(
            'count_text_color',
            [
                'label' => esc_html__('Text Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-profile-shortcode .lsd-author-listing-count span' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'count_icon_color',
            [
                'label' => esc_html__('Icon Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-profile-shortcode .lsd-author-listing-count i' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'count_typography',
                'selector' => '{{WRAPPER}} .lsdaddelm-profile-shortcode .lsd-author-listing-count span',
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
            'contact_info_text_color',
            [
                'label' => esc_html__('Text Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-profile-shortcode .lsd-profile-wrapper .lsd-profile-details .lsd-profile-box .lsd-profile-information a' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .lsdaddelm-profile-shortcode .lsd-profile-wrapper .lsd-profile-details .lsd-profile-box .lsd-profile-information div' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'contact_info_icon_color',
            [
                'label' => esc_html__('Icon Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-profile-shortcode .lsd-profile-information i' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'contact_info_social_icon_color',
            [
                'label' => esc_html__('Social Icon Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-profile-shortcode .lsd-profile-details .lsd-profile-box .lsd-profile-socials ul li i' => 'color: {{VALUE}};',
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
                    '{{WRAPPER}} .lsdaddelm-profile-shortcode .lsd-message-modal-button' => 'background: {{VALUE}} !important;',
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
                    '{{WRAPPER}} .lsdaddelm-profile-shortcode .lsd-message-modal-button' => 'color: {{VALUE}} !important;',
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
                    '{{WRAPPER}} .lsdaddelm-profile-shortcode .lsd-message-modal-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );

        // Button Border
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'button_border',
                'selector' => '{{WRAPPER}} .lsdaddelm-profile-shortcode .lsd-message-modal-button',
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
                    '{{WRAPPER}} .lsdaddelm-profile-shortcode .lsd-message-modal-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_bio',
            [
                'label' => esc_html__('Bio', 'listdom-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        // Bio
        $this->add_control(
            'bio_text_color',
            [
                'label' => esc_html__('Text Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-profile-shortcode .lsd-profile-wrapper .lsd-profile-details .lsd-profile-box p.lsd-profile-bio' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'bio_typography',
                'selector' => '{{WRAPPER}} .lsdaddelm-profile-shortcode .lsd-profile-wrapper .lsd-profile-details .lsd-profile-box p.lsd-profile-bio',
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        echo '<div class="lsdaddelm-profile-shortcode">' . do_shortcode('[listdom-profile]') . '</div>';
    }
}
