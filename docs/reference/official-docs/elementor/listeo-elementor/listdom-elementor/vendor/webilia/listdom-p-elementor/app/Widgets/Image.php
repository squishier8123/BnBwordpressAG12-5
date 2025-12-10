<?php
namespace LSDPACELM\Widgets;

use LSDPACELM\Widgets;
use Elementor\Group_Control_Typography;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;

class Image extends Widgets
{
    public function get_name(): string
    {
        return 'lsd-listing-image';
    }

    public function get_title(): string
    {
        return esc_html__('Listing Image', 'listdom-elementor');
    }

    public function get_icon(): string
    {
        return 'eicon-image';
    }

    public function register_controls()
    {
        $this->start_controls_section(
            'tags_section',
            [
                'label' => esc_html__('Tags', 'listdom-elementor'),
                'tab' => Controls_Manager::TAB_CONTENT,
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
            'content_section',
            [
                'label' => esc_html__('Content', 'listdom-elementor'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        // Image Modules
        $modules = apply_filters('lsdaddelm_image_modules', [
            'availability' => esc_html__('Working Hours', 'listdom-elementor'),
            'labels' => esc_html__('Labels', 'listdom-elementor'),
            'owner' => esc_html__('Owner', 'listdom-elementor'),
            'categories' => esc_html__('Categories', 'listdom-elementor'),
            'price' => esc_html__('Price', 'listdom-elementor'),
            'locations' => esc_html__('Locations', 'listdom-elementor'),
            'share' => esc_html__('Share', 'listdom-elementor'),
            'tags' => esc_html__('Tags', 'listdom-elementor'),
        ]);

        $this->add_control(
            'top_left',
            [
                'label' => esc_html__('Top Left', 'listdom-elementor'),
                'type' => Controls_Manager::SELECT2,
                'label_block' => true,
                'multiple' => true,
                'default' => [],
                'options' => $modules,
            ]
        );

        $this->add_control(
            'top_right',
            [
                'label' => esc_html__('Top Right', 'listdom-elementor'),
                'type' => Controls_Manager::SELECT2,
                'label_block' => true,
                'multiple' => true,
                'default' => [],
                'options' => $modules,
            ]
        );

        $this->add_control(
            'bottom_left',
            [
                'label' => esc_html__('Bottom Left', 'listdom-elementor'),
                'type' => Controls_Manager::SELECT2,
                'label_block' => true,
                'multiple' => true,
                'default' => [],
                'options' => $modules,
            ]
        );

        $this->add_control(
            'bottom_right',
            [
                'label' => esc_html__('Bottom Right', 'listdom-elementor'),
                'type' => Controls_Manager::SELECT2,
                'label_block' => true,
                'multiple' => true,
                'default' => [],
                'options' => $modules,
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'image_section',
            [
                'label' => esc_html__('Image', 'listdom-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'image_resolution',
                'exclude' => ['custom'],
                'include' => [],
                'default' => 'medium',
            ]
        );

        $this->add_responsive_control(
            'image_width',
            [
                'label' => esc_html__('Width', 'listdom-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 800,
                    ],
                ],
                'devices' => ['desktop', 'tablet', 'mobile'],
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-image > a img' => 'width: {{SIZE}}{{UNIT}};',
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
                    'top' => 0,
                    'right' => 0,
                    'bottom' => 0,
                    'left' => 0,
                    'unit' => 'px',
                    'isLinked' => true,
                ],
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-image > a img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'text_align',
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
                'default' => 'left',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-image > a' => 'justify-content: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'owner_section',
            [
                'label' => esc_html__('Owner Image', 'listdom-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'owner_image_width',
            [
                'label' => esc_html__('Width', 'listdom-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 800,
                    ],
                ],
                'devices' => ['desktop', 'tablet', 'mobile'],
                'selectors' => [
                    '{{WRAPPER}} .lsd-owner-image img' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'owner_border_radius',
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
                    '{{WRAPPER}} .lsd-owner-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'labels_section',
            [
                'label' => esc_html__('Labels', 'listdom-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'labels_color',
            [
                'label' => esc_html__('Labels Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lsd-labels-list-item a' => 'color: {{VALUE}} !important',
                ],
            ]
        );

        $this->add_control(
            'labels_bg',
            [
                'label' => esc_html__('Labels Background', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lsd-labels-list-item a' => 'background-color: {{VALUE}} !important',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'labels_typography',
                'label' => esc_html__('Typography', 'listdom-elementor'),
                'selector' => '{{WRAPPER}} .lsd-labels-list-item a',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'categories_section',
            [
                'label' => esc_html__('Categories', 'listdom-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'category_color',
            [
                'label' => esc_html__('Text Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-categories-module a' => 'color: {{VALUE}} !important',
                ],
            ]
        );

        $this->add_control(
            'category_bg',
            [
                'label' => esc_html__('Background Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-categories-module a' => 'background-color: {{VALUE}} !important',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'categories_typography',
                'label' => esc_html__('Typography', 'listdom-elementor'),
                'selector' => '{{WRAPPER}} .lsdaddelm-categories-module a, {{WRAPPER}} .lsdaddelm-categories-module a i',
            ]
        );

        $this->add_control(
            'hr_categories_colors',
            [
                'type' => Controls_Manager::DIVIDER,
            ]
        );

        $this->add_control(
            'categories_padding',
            [
                'label' => esc_html__('Padding', 'listdom-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'default' => [
                    'top' => 3,
                    'right' => 9,
                    'bottom' => 3,
                    'left' => 9,
                    'unit' => 'px',
                    'isLinked' => true,
                ],
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-categories-module a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'gap',
            [
                'label' => esc_html__('Gap', 'listdom-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'unit' => 'px',
                    'size' => 8,
                ],
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
                    '{{WRAPPER}} .lsdaddelm-categories-module' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'hr_categories_gap',
            [
                'type' => Controls_Manager::DIVIDER,
            ]
        );

        $this->add_control(
            'categories_display_name',
            [
                'label' => esc_html__('Category Name', 'listdom-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'listdom-elementor'),
                'label_off' => esc_html__('Hide', 'listdom-elementor'),
                'return_value' => '1',
                'default' => '1',
            ]
        );

        $this->add_control(
            'categories_display_icon',
            [
                'label' => esc_html__('Category Icon', 'listdom-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'listdom-elementor'),
                'label_off' => esc_html__('Hide', 'listdom-elementor'),
                'return_value' => '1',
                'default' => '0',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'price_section',
            [
                'label' => esc_html__('Price', 'listdom-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'price_typography',
                'label' => esc_html__('Typography', 'listdom-elementor'),
                'selector' => '{{WRAPPER}} .lsdaddelm-price-module',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'currency_typography',
                'label' => esc_html__('Sign Typography', 'listdom-elementor'),
                'selector' => '{{WRAPPER}} .lsd-min-price span, {{WRAPPER}} .lsd-max-price span',
            ]
        );

        $this->add_control(
            'hr_price_typography',
            [
                'type' => Controls_Manager::DIVIDER,
            ]
        );

        $this->add_control(
            'price_bg',
            [
                'label' => esc_html__('Background Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-price-module' => 'background-color: {{VALUE}} !important',
                ],
            ]
        );

        $this->add_control(
            'price_color',
            [
                'label' => esc_html__('Text Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-price-module' => 'color: {{VALUE}} !important',
                ],
            ]
        );

        $this->add_control(
            'hr_price_color',
            [
                'type' => Controls_Manager::DIVIDER,
            ]
        );

        $this->add_control(
            'price_padding',
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
                    '{{WRAPPER}} .lsdaddelm-price-module' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'price_border_radius',
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
                    '{{WRAPPER}} .lsdaddelm-price-module' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'locations_section',
            [
                'label' => esc_html__('Locations', 'listdom-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'locations_color',
            [
                'label' => esc_html__('Locations Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lsd-locations-list-item a' => 'color: {{VALUE}} !important',
                ],
            ]
        );

        $this->add_control(
            'locations_bg',
            [
                'label' => esc_html__('Locations Background', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lsd-locations-list-item a' => 'background-color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'locations_typography',
                'label' => esc_html__('Typography', 'listdom-elementor'),
                'selector' => '{{WRAPPER}} .lsd-locations-list-item a',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'tag_section',
            [
                'label' => esc_html__('Tags', 'listdom-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'tags_color',
            [
                'label' => esc_html__('Tags Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-tags-module a' => 'color: {{VALUE}} !important',
                ],
            ]
        );

        $this->add_control(
            'tags_bg',
            [
                'label' => esc_html__('Tags Background', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-tags-module a' => 'background-color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'tags_typography',
                'label' => esc_html__('Typography', 'listdom-elementor'),
                'selector' => '{{WRAPPER}} .lsdaddelm-tags-module a',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'availability_section',
            [
                'label' => esc_html__('Working Hours', 'listdom-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'availability_color',
            [
                'label' => esc_html__('Working Hour Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lsd-ava-one-day span' => 'color: {{VALUE}} !important',
                ],
            ]
        );

        $this->add_control(
            'availability_bg',
            [
                'label' => esc_html__('Working Hour Background', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lsd-ava-one-day span' => 'background-color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'availability_typography',
                'label' => esc_html__('Typography', 'listdom-elementor'),
                'selector' => '{{WRAPPER}} .lsd-ava-one-day span',
            ]
        );

        $this->end_controls_section();

        // Third Party Controls
        do_action('lsdaddelm_image_controls', $this);
    }

    protected function listing(\LSD_Entity_Listing $listing): string
    {
        $settings = $this->get_settings_for_display();
        $link_method = $settings['link_method'] ?? 'normal';

        $resolution_size = $settings['image_resolution_size'] ?? 'medium';

        $tl = isset($settings['top_left']) && is_array($settings['top_left']) ? $settings['top_left'] : [];
        $tr = isset($settings['top_right']) && is_array($settings['top_right']) ? $settings['top_right'] : [];
        $bl = isset($settings['bottom_left']) && is_array($settings['bottom_left']) ? $settings['bottom_left'] : [];
        $br = isset($settings['bottom_right']) && is_array($settings['bottom_right']) ? $settings['bottom_right'] : [];

        $top_left = $this->get_modules_output($listing, 'top-left', $tl);
        $top_right = $this->get_modules_output($listing, 'top-right', $tr);
        $bottom_left = $this->get_modules_output($listing, 'bottom-left', $bl);
        $bottom_right = $this->get_modules_output($listing, 'bottom-right', $br);

        return '<div class="lsdaddelm-card-image">'
            . $listing->get_cover_image($resolution_size, $link_method) .
            '<div class="lsdaddelm-card-image-overlay">
                <div class="lsdaddelm-card-image-overlay-top-left">' . \LSD_Kses::full($top_left) . '</div>
                <div class="lsdaddelm-card-image-overlay-top-right">' . \LSD_Kses::full($top_right) . '</div>
                <div class="lsdaddelm-card-image-overlay-bottom-left">' . \LSD_Kses::full($bottom_left) . '</div>
                <div class="lsdaddelm-card-image-overlay-bottom-right">' . \LSD_Kses::full($bottom_right) . '</div>
            </div>
        </div>';
    }

    private function get_modules_output(\LSD_Entity_Listing $listing, string $position, array $modules = []): string
    {
        $settings = $this->get_settings_for_display();

        $output = '';

        foreach ($modules as $module)
        {
            $m = '';
            if ($module === 'availability') $m .= $listing->get_availability(true);
            else if ($module === 'labels')
            {
                $labels = $listing->get_labels();
                $m .= trim($labels) ? '<div class="lsdaddelm-labels-module">' . $labels . '</div>' : '';
            }
            else if ($module === 'tags')
            {
                $tags = $listing->get_tags();
                $m .= trim($tags) ? '<div class="lsdaddelm-tags-module">' . $tags . '</div>' : '';
            }
            else if ($module === 'owner') $m .= $listing->get_owner('image-name');
            else if ($module === 'share') $m .= $listing->get_share_buttons();
            else if ($module === 'categories')
            {
                // Display Main Category or All Categories
                $multiple = apply_filters('lsd_listing_display_multiple_categories', false);

                $display_name = !isset($settings['categories_display_name']) || $settings['categories_display_name'] === '1';
                $display_icon = isset($settings['categories_display_icon']) && $settings['categories_display_icon'] === '1';

                $categories = $listing->get_categories([
                    'show_color' => true,
                    'multiple_categories' => $multiple,
                    'display_name' => $display_name,
                    'display_icon' => $display_icon,
                ]);

                $m .= trim($categories) ? '<div class="lsdaddelm-categories-module">' . $categories . '</div>' : '';
            }
            else if ($module === 'price')
            {
                $price = $listing->get_price(true);
                $m .= trim($price) ? '<div class="lsdaddelm-price-module lsd-color-m-bg ' . \LSD_Color::text_class() . '">' . $price . '</div>' : '';
            }
            else if ($module === 'locations') $m .= $listing->get_locations();
            // Output of Third Party Modules
            else $m .= apply_filters('lsdaddelm_image_module_output', '', $module, $listing, $position, $modules);

            $output .= trim($m) ? '<div class="lsdaddelm-card-image-module">' . $m . '</div>' : '';
        }

        return (string) apply_filters('lsdaddelm_image_modules_output', $output, $listing, $position, $modules);
    }
}
