<?php
namespace LSDPACELM\Widgets;

use LSDPACELM\Widgets;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Icons_Manager;

class Locations extends Widgets
{
    public function get_name(): string
    {
        return 'lsd-listing-locations';
    }

    public function get_title(): string
    {
        return esc_html__('Listing Locations', 'listdom-elementor');
    }

    public function get_icon(): string
    {
        return 'eicon-map-pin';
    }

    public function register_controls()
    {
        // Content Tab
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Content', 'listdom-elementor'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        // Link to the location archive: Disable/Enable
        $this->add_control(
            'enable_location_link',
            [
                'label' => esc_html__('Link to Location Archive', 'listdom-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'listdom-elementor'),
                'label_off' => esc_html__('No', 'listdom-elementor'),
                'default' => 'yes',
            ]
        );

        // Icon Selection
        $this->add_control(
            'icon',
            [
                'label' => esc_html__('Icon', 'listdom-elementor'),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-map-marker-alt',
                    'library' => 'solid',
                ],
            ]
        );

        // Layout: Inline or Block
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
                'default' => 'row',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-locations .lsd-locations-list' => 'flex-direction: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();

        // Style Tab
        $this->start_controls_section(
            'style_section',
            [
                'label' => esc_html__('General', 'listdom-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'locations_typography',
                'label' => esc_html__('Typography', 'listdom-elementor'),
                'selector' => '{{WRAPPER}} .lsdaddelm-card-locations li, {{WRAPPER}} .lsdaddelm-card-locations a',
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label' => esc_html__('Text Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-locations li, {{WRAPPER}} .lsdaddelm-card-locations a' => 'color: {{VALUE}}',
                ],
            ]
        );

        // Icon Color
        $this->add_control(
            'icon_color',
            [
                'label' => esc_html__('Icon Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-locations .lsd-fe-icon' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .lsdaddelm-card-locations svg' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'padding',
            [
                'label' => esc_html__('Padding', 'listdom-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-locations' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'gap',
            [
                'label' => esc_html__('Gap Between Items', 'listdom-elementor'),
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
                ],
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-locations .lsd-locations-list' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'items_section',
            [
                'label' => esc_html__('Item', 'listdom-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        // Background Color
        $this->add_control(
            'item_background_color',
            [
                'label' => esc_html__('Background Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-locations .lsd-locations-list-item' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        // Border
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'item_border',
                'label' => esc_html__('Border', 'listdom-elementor'),
                'selector' => '{{WRAPPER}} .lsdaddelm-card-locations .lsd-locations-list-item',
            ]
        );

        // Border Radius
        $this->add_responsive_control(
            'item_border_radius',
            [
                'label' => esc_html__('Border Radius', 'listdom-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-locations .lsd-locations-list-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'items_padding',
            [
                'label' => esc_html__('Padding', 'listdom-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-locations .lsd-locations-list-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'item_gap',
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
                ],
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-locations .lsd-locations-list li' => 'gap: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .lsdaddelm-card-locations .lsd-locations-list li a' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function listing(\LSD_Entity_Listing $listing): string
    {
        $locations = wp_get_post_terms($listing->id(), \LSD_Base::TAX_LOCATION);

        // No Locations
        if (!is_array($locations) || !count($locations)) return '';

        $settings = $this->get_settings_for_display();

        return '<div class="lsdaddelm-card-locations">' .
            '<ul class="lsd-locations-list">' .
            implode('', array_map(function ($location) use ($settings)
            {
                $icon = '';
                if (isset($settings['icon']['value']) && is_array($settings['icon']['value']))
                {
                    ob_start();
                    Icons_Manager::render_icon($settings['icon'], ['aria-hidden' => 'true']);
                    $icon = ob_get_clean();
                }
                else if (isset($settings['icon']['value']))
                {
                    $icon = '<i class="lsd-fe-icon ' . esc_attr($settings['icon']['value']) . '"></i>';
                }

                $link = $settings['enable_location_link'] === 'yes'
                    ? sprintf(
                        '<a href="%s" ' . lsd_schema()->name() . '>%s%s</a>',
                        esc_url(get_term_link($location->term_id, \LSD_Base::TAX_LOCATION)),
                        $icon,
                        esc_html($location->name)
                    )
                    : $icon . esc_html($location->name);

                return sprintf(
                    '<li class="lsd-locations-list-item" ' . lsd_schema()->scope()->type('https://schema.org/Place')->prop('areaServed') . '>%s</li>',
                    $link
                );
            }, $locations)) .
            '</ul>
        </div>';
    }
}
