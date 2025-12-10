<?php
namespace LSDPACELM\Widgets;

use LSDPACELM\Widgets;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

class Price extends Widgets
{
    public function get_name(): string
    {
        return 'lsd-listing-price';
    }

    public function get_title(): string
    {
        return esc_html__('Listing Price', 'listdom-elementor');
    }

    public function get_icon(): string
    {
        return 'eicon-price-table';
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
            'minimized',
            [
                'label' => esc_html__('Minimized Price', 'listdom-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'listdom-elementor'),
                'label_off' => esc_html__('No', 'listdom-elementor'),
                'return_value' => '1',
                'default' => '0',
            ]
        );

        $this->add_control(
            'enable_price_link',
            [
                'label' => esc_html__('Link Price', 'listdom-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'listdom-elementor'),
                'label_off' => esc_html__('No', 'listdom-elementor'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $this->add_control(
            'price_link',
            [
                'label' => esc_html__('Price Link URL', 'listdom-elementor'),
                'type' => Controls_Manager::URL,
                'placeholder' => esc_attr__('https://your-link.com', 'listdom-elementor'),
                'dynamic' => [
                    'active' => true,
                ],
                'show_external' => true,
                'default' => [
                    'url' => '',
                    'is_external' => false,
                    'nofollow' => false,
                ],
                'condition' => [
                    'enable_price_link' => 'yes',
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
                'name' => 'price_typography',
                'selector' => '{{WRAPPER}} .lsdaddelm-card-price, {{WRAPPER}} .lsdaddelm-card-price a',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Sign', 'listdom-elementor'),
                'name' => 'currency_typography',
                'selector' => '{{WRAPPER}} .lsd-min-price span, {{WRAPPER}} .lsd-max-price span',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Price Description', 'listdom-elementor'),
                'name' => 'description_typography',
                'selector' => '{{WRAPPER}} .lsd-text-price',
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

        $this->add_control(
            'bg_color',
            [
                'label' => esc_html__('Background Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-price' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label' => esc_html__('Text Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-price' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .lsdaddelm-card-price a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'hr_color',
            [
                'type' => Controls_Manager::DIVIDER,
            ]
        );

        $this->add_control(
            'padding',
            [
                'label' => esc_html__('Padding', 'listdom-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'default' => [
                    'top' => 5,
                    'right' => 5,
                    'bottom' => 5,
                    'left' => 5,
                    'unit' => 'px',
                    'isLinked' => true,
                ],
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-price' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'border_radius',
            [
                'label' => esc_html__('Border Radius', 'listdom-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'default' => [
                    'top' => 3,
                    'right' => 3,
                    'bottom' => 3,
                    'left' => 3,
                    'unit' => 'px',
                    'isLinked' => true,
                ],
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-price' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function listing(\LSD_Entity_Listing $listing): string
    {
        $settings = $this->get_settings_for_display();
        $minimized = $settings['minimized'] ?? 0;

        $price = $listing->get_price((bool) $minimized);
        if (trim($price) === '') return '';

        if (!empty($settings['enable_price_link']) && $settings['enable_price_link'] === 'yes')
        {
            $link_settings = $settings['price_link'] ?? [];
            if (!empty($link_settings['url']))
            {
                $target = $link_settings['is_external'] ? ' target="_blank"' : '';
                $rel = $link_settings['nofollow'] ? ' rel="nofollow"' : '';

                $price = '<a href="' . esc_url($link_settings['url']) . '"' . $target . $rel . '>' . $price . '</a>';
            }
        }

        return '<span class="lsdaddelm-card-price">' . $price . '</span>';
    }
}
