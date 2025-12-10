<?php
namespace LSDPACELM\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class Search extends Widget_Base
{
    public function get_name(): string
    {
        return 'lsd-listing-search';
    }

    public function get_title(): string
    {
        return esc_html__('Listdom Search', 'listdom-elementor');
    }

    public function get_categories(): array
    {
        return ['listdom'];
    }

    public function get_icon(): string
    {
        return 'eicon-search';
    }

    protected function register_controls()
    {
        $this->start_controls_section(
            'search_section',
            [
                'label' => esc_html__('Search', 'listdom-elementor'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $posts = get_posts([
            'post_type' => \LSD_Base::PTYPE_SEARCH,
            'posts_per_page' => '-1',
        ]);

        $searches = [];
        foreach ($posts as $post) $searches[$post->ID] = $post->post_title;

        $this->add_control(
            'search',
            [
                'label' => esc_html__('Listdom Search', 'listdom-elementor'),
                'type' => Controls_Manager::SELECT,
                'options' => $searches,
            ]
        );

        $this->add_control(
            'search_edit_button',
            [
                'type' => Controls_Manager::RAW_HTML,
                'raw' => '<div style="margin-top:10px; text-align: center;"><a id="lsd-search-edit-link" href="#" class="elementor-button elementor-button-default" target="_blank">' . esc_html__('Edit Search Form', 'listdom-elementor') . '</a></div>',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'search_box_content_section',
            [
                'label' => esc_html__('Box', 'listdomer-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        // Content Background Color
        $this->add_control(
            'content_bg_color',
            [
                'label' => esc_html__('Content Background Color', 'listdomer-core'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-search-shortcode .lsd-search-row' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .lsdaddelm-search-shortcode .lsd-search-row-more-options' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'search_fields_content_section',
            [
                'label' => esc_html__('Fields', 'listdomer-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'content_color',
            [
                'label' => esc_html__('Content Color', 'listdomer-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000',
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-search-shortcode .lsd-search-row' => 'color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_control(
            'input_bg',
            [
                'label' => esc_html__('Input Background', 'listdomer-core'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-search-shortcode .lsd-search-row .lsd-search-filter' => 'background-color: {{VALUE}} !important;',
                    '{{WRAPPER}} .lsdaddelm-search-shortcode .lsd-search-row .lsd-search-filter label' => 'background-color: {{VALUE}} !important;',
                ],
            ]
        );

        // Input Border
        $this->add_control(
            'input_border_color',
            [
                'label' => esc_html__('Input Border Color', 'listdomer-core'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => 'var(--listdom-search-form-input-border-color)',
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-search-shortcode .lsd-search-row .lsd-search-filter' => 'border-color: {{VALUE}} !important;',
                ],
            ]
        );

        // Input Border Width
        $this->add_control(
            'input_border_width',
            [
                'label' => esc_html__('Input Border Width', 'listdomer-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-search-shortcode .lsd-search-row .lsd-search-filter' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important',
                ],
            ]
        );

        // Input Border Style
        $this->add_control(
            'input_border_style',
            [
                'label' => esc_html__('Input Border Style', 'listdomer-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'none' => esc_html__('None', 'listdomer-core'),
                    'solid' => esc_html__('Solid', 'listdomer-core'),
                    'dashed' => esc_html__('Dashed', 'listdomer-core'),
                    'dotted' => esc_html__('Dotted', 'listdomer-core'),
                    'double' => esc_html__('Double', 'listdomer-core'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-search-shortcode .lsd-search-row .lsd-search-filter' => 'border-style: {{VALUE}} !important;',
                ],
            ]
        );

        // Input Border Radius
        $this->add_control(
            'input_border_radius',
            [
                'label' => esc_html__('Input Border Radius', 'listdomer-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-search-shortcode .lsd-search-row .lsd-search-filter' => 'border-radius: {{SIZE}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $id = isset($settings['search']) && is_numeric($settings['search']) ? $settings['search'] : 0;

        if (!$id)
        {
            echo esc_html__('Search Shortcode not found!', 'listdom-elementor');
            return;
        }

        echo '<div class="lsdaddelm-search-shortcode">' . do_shortcode('[listdom-search id="' . $id . '"]') . '</div>';
    }
}
