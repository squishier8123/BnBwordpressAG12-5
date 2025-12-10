<?php
namespace LSDPACELM\Widgets;

use LSDPACELM\Widgets;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;

class Owner extends Widgets
{
    public function get_name(): string
    {
        return 'lsd-listing-owner';
    }

    public function get_title(): string
    {
        return esc_html__('Listing Owner', 'listdom-elementor');
    }

    public function get_icon(): string
    {
        return 'eicon-user-circle-o';
    }

    public function register_controls()
    {
        $this->start_controls_section(
            'owner_details_section',
            [
                'label' => esc_html__('Owner Details', 'listdom-elementor'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        // Avatar
        $this->add_control(
            'show_avatar',
            [
                'label' => esc_html__('Show Avatar', 'listdom-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'listdom-elementor'),
                'label_off' => esc_html__('No', 'listdom-elementor'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'link_avatar',
            [
                'label' => esc_html__('Link Avatar to Author Url', 'listdom-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'listdom-elementor'),
                'label_off' => esc_html__('No', 'listdom-elementor'),
                'return_value' => 'yes',
                'default' => 'no',
                'condition' => [
                    'show_avatar' => 'yes',
                ],
            ]
        );

        // Name
        $this->add_control(
            'show_name',
            [
                'label' => esc_html__('Show Name', 'listdom-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'listdom-elementor'),
                'label_off' => esc_html__('No', 'listdom-elementor'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        // Author Link
        $this->add_control(
            'author_link',
            [
                'label' => esc_html__('Author Link', 'listdom-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'listdom-elementor'),
                'label_off' => esc_html__('No', 'listdom-elementor'),
                'return_value' => 'yes',
                'default' => 'no',
                'condition' => [
                    'show_name' => 'yes',
                ],
            ]
        );

        // Job Title
        $this->add_control(
            'show_job_title',
            [
                'label' => esc_html__('Show Job Title', 'listdom-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'listdom-elementor'),
                'label_off' => esc_html__('No', 'listdom-elementor'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        // Bio
        $this->add_control(
            'show_bio',
            [
                'label' => esc_html__('Show Bio', 'listdom-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'listdom-elementor'),
                'label_off' => esc_html__('No', 'listdom-elementor'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        // Social Networks
        if (\LSD_Components::socials())
        {
            $this->add_control(
                'show_socials',
                [
                    'label' => esc_html__('Show Social Networks', 'listdom-elementor'),
                    'type' => Controls_Manager::SWITCHER,
                    'label_on' => esc_html__('Yes', 'listdom-elementor'),
                    'label_off' => esc_html__('No', 'listdom-elementor'),
                    'return_value' => 'yes',
                    'default' => 'yes',
                ]
            );
        }

        // Phone Number (Tel)
        $this->add_control(
            'show_tel',
            [
                'label' => esc_html__('Show Telephone', 'listdom-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'listdom-elementor'),
                'label_off' => esc_html__('No', 'listdom-elementor'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        // Email
        $this->add_control(
            'show_email',
            [
                'label' => esc_html__('Show Email', 'listdom-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'listdom-elementor'),
                'label_off' => esc_html__('No', 'listdom-elementor'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        // Mobile
        $this->add_control(
            'show_mobile',
            [
                'label' => esc_html__('Show Mobile', 'listdom-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'listdom-elementor'),
                'label_off' => esc_html__('No', 'listdom-elementor'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        // Website
        $this->add_control(
            'show_website',
            [
                'label' => esc_html__('Show Website', 'listdom-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'listdom-elementor'),
                'label_off' => esc_html__('No', 'listdom-elementor'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        // Fax
        $this->add_control(
            'show_fax',
            [
                'label' => esc_html__('Show Fax', 'listdom-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'listdom-elementor'),
                'label_off' => esc_html__('No', 'listdom-elementor'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        // Form
        $this->add_control(
            'show_form',
            [
                'label' => esc_html__('Show Form', 'listdom-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'listdom-elementor'),
                'label_off' => esc_html__('No', 'listdom-elementor'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'form_section',
            [
                'label' => esc_html__('Form', 'listdom-elementor'),
                'tab' => Controls_Manager::TAB_CONTENT,
                'condition' => ['show_form' => 'yes'],
            ]
        );

        // Name Field
        $this->add_control(
            'name_field',
            [
                'label' => esc_html__('Show Name Field', 'listdom-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'listdom-elementor'),
                'label_off' => esc_html__('No', 'listdom-elementor'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        // Phone Field
        $this->add_control(
            'phone_field',
            [
                'label' => esc_html__('Show Phone Field', 'listdom-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'listdom-elementor'),
                'label_off' => esc_html__('No', 'listdom-elementor'),
                'return_value' => 'yes',
                'default' => 'yes',
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

        $this->add_responsive_control(
            'layout_items_alignment',
            [
                'label' => esc_html__('Content Alignment', 'listdom-elementor'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'start' => [
                        'title' => esc_html__('Start', 'listdom-elementor'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'listdom-elementor'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'end' => [
                        'title' => esc_html__('End', 'listdom-elementor'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .lsd-owner-information' => 'align-items: {{VALUE}};',
                    '{{WRAPPER}} .lsd-owner-first-part' => 'align-items: {{VALUE}};',
                    '{{WRAPPER}} .lsd-owner-information-part-1' => 'align-items: {{VALUE}};',
                    '{{WRAPPER}} .lsd-owner-information-part-2' => 'align-items: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'layout_items_gap',
            [
                'label' => esc_html__('Content Gap', 'listdom-elementor'),
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
                    '{{WRAPPER}} .lsd-owner-information' => 'gap: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .lsd-owner-first-part' => 'gap: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .lsd-owner-information-part-1' => 'gap: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .lsd-owner-information-part-2' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'style_section',
            [
                'label' => esc_html__('Image', 'listdom-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'border_radius',
            [
                'label' => esc_html__('Border Radius', 'listdom-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'default' => [
                    'top' => 50,
                    'right' => 50,
                    'bottom' => 50,
                    'left' => 50,
                    'unit' => 'px',
                    'isLinked' => true,
                ],
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-owner img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'image_width',
            [
                'label' => esc_html__('Avatar Width', 'listdom-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 90,
                ],
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-owner img' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'image_border',
                'label' => esc_html__('Image Border', 'listdom-elementor'),
                'selector' => '{{WRAPPER}} .lsdaddelm-card-owner img',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'name_section',
            [
                'label' => esc_html__('Name', 'listdom-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'owner_name_text_align',
            [
                'label' => esc_html__('Owner Name Alignment', 'listdom-elementor'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'listdom-elementor'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'listdom-elementor'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'listdom-elementor'),
                        'icon' => 'eicon-text-align-right',
                    ],
                    'justify' => [
                        'title' => esc_html__('Justify', 'listdom-elementor'),
                        'icon' => 'eicon-text-align-justify',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} h4.lsd-owner-name' => 'text-align: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_control(
            'owner_name_color',
            [
                'label' => esc_html__('Owner Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} h4.lsd-owner-name' => 'color: {{VALUE}} !important',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'owner_typography',
                'selector' => '{{WRAPPER}} h4.lsd-owner-name',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'job_section',
            [
                'label' => esc_html__('Job', 'listdom-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'job_title_text_align',
            [
                'label' => esc_html__('Job Title Alignment', 'listdom-elementor'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'listdom-elementor'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'listdom-elementor'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'listdom-elementor'),
                        'icon' => 'eicon-text-align-right',
                    ],
                    'justify' => [
                        'title' => esc_html__('Justify', 'listdom-elementor'),
                        'icon' => 'eicon-text-align-justify',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .lsd-owner-job-title' => 'text-align: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_control(
            'owner_job_title_color',
            [
                'label' => esc_html__('Text Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lsd-owner-job-title' => 'color: {{VALUE}} !important',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'owner_job_title_typography',
                'selector' => '{{WRAPPER}} .lsd-owner-job-title',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'bio_section',
            [
                'label' => esc_html__('Bio', 'listdom-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'bio_text_align',
            [
                'label' => esc_html__('Bio Alignment', 'listdom-elementor'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'listdom-elementor'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'listdom-elementor'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'listdom-elementor'),
                        'icon' => 'eicon-text-align-right',
                    ],
                    'justify' => [
                        'title' => esc_html__('Justify', 'listdom-elementor'),
                        'icon' => 'eicon-text-align-justify',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .lsd-owner-biography' => 'text-align: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_control(
            'owner_bio_color',
            [
                'label' => esc_html__('Bio Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lsd-owner-biography' => 'color: {{VALUE}} !important',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'owner_bio_typography',
                'selector' => '{{WRAPPER}} .lsd-owner-biography',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'contact_info_section',
            [
                'label' => esc_html__('Contact Info', 'listdom-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'contact_info_typography',
                'selector' => '{{WRAPPER}} .lsd-owner-information-part-2 div, {{WRAPPER}} .lsd-owner-information-part-2 div a',
            ]
        );

        $this->add_control(
            'contact_info_color',
            [
                'label' => esc_html__('Contact Info Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lsd-owner-information-part-2 div' => 'color: {{VALUE}} !important',
                    '{{WRAPPER}} .lsd-owner-information-part-2 div a' => 'color: {{VALUE}} !important',
                ],
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'contact_info_forms_section',
            [
                'label' => esc_html__('Form', 'listdom-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['show_form' => 'yes'],
            ]
        );

        $this->add_control(
            'contact_info_input_bg_color',
            [
                'label' => esc_html__('Input Background Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lsd-owner-contact-form input:not([type="submit"])' => 'background-color: {{VALUE}} !important',
                    '{{WRAPPER}} .lsd-owner-contact-form textarea' => 'background-color: {{VALUE}} !important',
                ],
            ]
        );

        $this->add_control(
            'contact_info_input_text_color',
            [
                'label' => esc_html__('Text Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lsd-owner-contact-form input:not([type="submit"])' => 'color: {{VALUE}} !important',
                    '{{WRAPPER}} .lsd-owner-contact-form textarea' => 'color: {{VALUE}} !important',
                ],
            ]
        );

        $this->add_responsive_control(
            'contact_info_input_border_radius',
            [
                'label' => esc_html__('Border Radius', 'listdom-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lsd-owner-contact-form input:not([type="submit"])' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important',
                    '{{WRAPPER}} .lsd-owner-contact-form textarea' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important',
                ],
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'contact_info_icons_section',
            [
                'label' => esc_html__('Icons', 'listdom-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'contact_info_icons_bg_color',
            [
                'label' => esc_html__('Icons Background Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lsd-owner-information-part-2 div i' => 'background-color: {{VALUE}} !important',
                    '{{WRAPPER}} .lsd-owner-social-networks a' => 'background-color: {{VALUE}} !important',
                ],
            ]
        );

        $this->add_control(
            'contact_info_icons_color',
            [
                'label' => esc_html__('Icons Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lsd-owner-information-part-2 div i' => 'color: {{VALUE}} !important',
                    '{{WRAPPER}} .lsd-owner-social-networks i' => 'color: {{VALUE}} !important',
                ],
            ]
        );

        $this->add_responsive_control(
            'contact_info_icons_border_radius',
            [
                'label' => esc_html__('Border Radius', 'listdom-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lsd-owner-information-part-2 div i' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important',
                    '{{WRAPPER}} .lsd-owner-social-networks a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important',
                ],
            ]
        );

        $this->add_responsive_control(
            'icons_gap',
            [
                'label' => esc_html__('Items Gap', 'listdom-elementor'),
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
                    '{{WRAPPER}} .lsd-owner-information-part-2 div i' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .lsd-owner-social-networks i' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'contact_info_icons_gap',
            [
                'label' => esc_html__('Contact Icon gap', 'listdom-elementor'),
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
                    '{{WRAPPER}} .lsd-owner-information-part-2 div i' => 'margin-right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function listing(\LSD_Entity_Listing $listing): string
    {
        $show_avatar = $this->get_settings_for_display('show_avatar');
        $show_name = $this->get_settings_for_display('show_name');
        $link_avatar = $this->get_settings_for_display('link_avatar');
        $author_link = $this->get_settings_for_display('author_link');
        $show_job_title = $this->get_settings_for_display('show_job_title');
        $show_bio = $this->get_settings_for_display('show_bio');
        $show_socials = \LSD_Components::socials() ? $this->get_settings_for_display('show_socials') : 'no';
        $show_tel = $this->get_settings_for_display('show_tel');
        $show_mobile = $this->get_settings_for_display('show_mobile');
        $show_email = $this->get_settings_for_display('show_email');
        $show_website = $this->get_settings_for_display('show_website');
        $show_fax = $this->get_settings_for_display('show_fax');
        $show_form = $this->get_settings_for_display('show_form');
        $field_name = $this->get_settings_for_display('name_field');
        $field_phone = $this->get_settings_for_display('phone_field');

        return '<div class="lsdaddelm-card-owner">' . $listing->get_owner('details', [
                'display_avatar' => $show_avatar === 'yes' ? 1 : 0,
                'display_name' => $show_name === 'yes' ? 1 : 0,
                'author_link' => $author_link === 'yes' ? 1 : 0,
                'link_avatar' => $link_avatar === 'yes' ? 1 : 0,
                'display_job_title' => $show_job_title === 'yes' ? 1 : 0,
                'display_bio' => $show_bio === 'yes' ? 1 : 0,
                'display_socials' => (\LSD_Components::socials() && $show_socials === 'yes') ? 1 : 0,
                'display_tel' => $show_tel === 'yes' ? 1 : 0,
                'display_mobile' => $show_mobile === 'yes' ? 1 : 0,
                'display_email' => $show_email === 'yes' ? 1 : 0,
                'display_website' => $show_website === 'yes' ? 1 : 0,
                'display_fax' => $show_fax === 'yes' ? 1 : 0,
                'display_form' => $show_form === 'yes' ? 1 : 0,
                'name_field' => $field_name === 'yes' ? 1 : 0,
                'phone_field' => $field_phone === 'yes' ? 1 : 0,
            ]) . '</div>';
    }

}
