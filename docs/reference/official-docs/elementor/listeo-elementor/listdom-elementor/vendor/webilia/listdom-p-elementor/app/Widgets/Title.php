<?php
namespace LSDPACELM\Widgets;

use LSDPACELM\Widgets;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

class Title extends Widgets
{
    public function get_name(): string
    {
        return 'lsd-listing-title';
    }

    public function get_title(): string
    {
        return esc_html__('Listing Title', 'listdom-elementor');
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
            'title_tag',
            [
                'label' => esc_html__('Title Tag', 'listdom-elementor'),
                'type' => Controls_Manager::SELECT,
                'default' => 'h2',
                'options' => [
                    'h1' => esc_html__('Heading 1', 'listdom-elementor'),
                    'h2' => esc_html__('Heading 2', 'listdom-elementor'),
                    'h3' => esc_html__('Heading 3', 'listdom-elementor'),
                    'h4' => esc_html__('Heading 4', 'listdom-elementor'),
                    'p' => esc_html__('Paragraph', 'listdom-elementor'),
                    'strong' => esc_html__('Strong', 'listdom-elementor'),
                ],
            ]
        );

        $this->add_control(
            'link_method',
            [
                'label' => esc_html__('Link Method', 'listdom-elementor'),
                'type' => Controls_Manager::SELECT,
                'default' => 'normal',
                'options' => \LSD_Base::get_listing_link_methods(),
            ]
        );

        $this->end_controls_section();

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
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .lsdaddelm-card-title a, {{WRAPPER}} .lsdaddelm-card-title > *',
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label' => esc_html__('Text Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-title a, {{WRAPPER}} .lsdaddelm-card-title > *' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'text_hover_color',
            [
                'label' => esc_html__('Hover Text Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-title a:hover, {{WRAPPER}} .lsdaddelm-card-title > *:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'text_alignment',
            [
                'label' => esc_html__('Alignment', 'listdom-elementor'),
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
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-title a, {{WRAPPER}} .lsdaddelm-card-title > *' => 'justify-content: {{VALUE}} !important; text-align: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function listing(\LSD_Entity_Listing $listing): string
    {
        $settings = $this->get_settings_for_display();
        $method = $settings['link_method'] ?? 'normal';

        $tag = $settings['title_tag'] ?? 'h2';
        if(!in_array($tag, ['h1', 'h2', 'h3', 'h4', 'p', 'strong'])) $tag = 'h2';

        return '<div class="lsdaddelm-card-title"><' . $tag . '>' . $listing->get_title_tag($method) . '</' . $tag . '></div>';
    }
}
