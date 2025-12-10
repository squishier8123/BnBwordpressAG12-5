<?php
namespace LSDPACELM\Widgets;

use LSDPACELM\Widgets;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Text_Shadow;

class Gallery extends Widgets
{
    public function get_name(): string
    {
        return 'lsd-listing-gallery';
    }

    public function get_title(): string
    {
        return esc_html__('Listing Gallery', 'listdom-elementor');
    }

    public function get_icon(): string
    {
        return 'eicon-photo-library';
    }

    public function register_controls()
    {
        $this->start_controls_section(
            'layout_section',
            [
                'label' => esc_html__('Layout', 'listdom-elementor'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'style',
            [
                'label' => esc_html__('Layout', 'listdom-elementor'),
                'type' => Controls_Manager::SELECT,
                'default' => 'list',
                'options' => [
                    'list' => esc_html__('List', 'listdom-elementor'),
                    'slider' => esc_html__('Slider', 'listdom-elementor'),
                    'linear' => esc_html__('Linear Gallery', 'listdom-elementor'),
                ],
            ]
        );

        $this->add_control(
            'include_thumbnail',
            [
                'label' => esc_html__('Include Featured Image', 'listdom-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'listdom-elementor'),
                'label_off' => esc_html__('No', 'listdom-elementor'),
                'return_value' => '1',
                'default' => '1',
            ]
        );

        $this->add_control(
            'lightbox',
            [
                'label' => esc_html__('Image Lightbox', 'listdom-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'listdom-elementor'),
                'label_off' => esc_html__('No', 'listdom-elementor'),
                'return_value' => '1',
                'default' => '1',
            ]
        );

        $this->add_control(
            'image_limit',
            [
                'label' => esc_html__('Number of Images', 'listdom-elementor'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 100,
                'step' => 1,
                'default' => 4,
                'condition' => [
                    'style' => 'linear',
                ],
            ]
        );

        $this->add_control(
            'link_method',
            [
                'label' => esc_html__('Link Method', 'listdom-elementor'),
                'type' => Controls_Manager::SELECT,
                'options' => \LSD_Base::get_listing_link_methods(),
                'default' => 'normal',
                'condition' => [
                    'lightbox!' => '1',
                    'style' => 'slider',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'slider_section',
            [
                'label' => esc_html__('Slider', 'listdom-elementor'),
                'tab' => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'style' => 'slider',
                ],
            ]
        );

        $this->add_control(
            'slider_autoplay',
            [
                'label' => esc_html__('Autoplay', 'listdom-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'listdom-elementor'),
                'label_off' => esc_html__('No', 'listdom-elementor'),
                'return_value' => '1',
                'default' => '1',
            ]
        );

        $this->add_control(
            'slider_auto_height',
            [
                'label' => esc_html__('Auto-height', 'listdom-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'listdom-elementor'),
                'label_off' => esc_html__('No', 'listdom-elementor'),
                'return_value' => '1',
                'default' => '1',
            ]
        );

        $this->add_control(
            'slider_loop',
            [
                'label' => esc_html__('Loop', 'listdom-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'listdom-elementor'),
                'label_off' => esc_html__('No', 'listdom-elementor'),
                'return_value' => '1',
                'default' => '0',
            ]
        );

        $this->add_control(
            'thumbnail_status',
            [
                'label' => esc_html__('Thumbnails', 'listdom-elementor'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'list' => esc_html__('List', 'listdom-elementor'),
                    'image' => esc_html__('On the Image', 'listdom-elementor'),
                    'disabled' => esc_html__('Disabled', 'listdom-elementor'),
                ],
                'default' => 'image',
            ]
        );

        $this->add_control(
            'navigation_method',
            [
                'label' => esc_html__('Navigation Method', 'listdom-elementor'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'dots' => esc_html__('Dots', 'listdom-elementor'),
                    'nav' => esc_html__('Arrows', 'listdom-elementor'),
                    'disabled' => esc_html__('Disabled', 'listdom-elementor'),
                ],
                'default' => 'dots',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'image_style_section',
            [
                'label' => esc_html__('Image', 'listdom-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'image_radius',
            [
                'label' => esc_html__('Image Radius', 'listdom-elementor'),
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
                    '{{WRAPPER}} .lsdaddelm-card-gallery img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_height',
            [
                'label' => esc_html__('Image Height', 'listdom-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'vh'],
                'range' => [
                    'px' => [
                        'min' => 50,
                        'max' => 1000,
                    ],
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                    'em' => [
                        'min' => 1,
                        'max' => 50,
                    ],
                    'vh' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 300,
                ],
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-gallery .lsd-gallery-linear .lsd-gallery-grid-item img' =>
                        'min-height: {{SIZE}}{{UNIT}} !important; max-height: {{SIZE}}{{UNIT}} !important;',
                ],
                'condition' => [
                    'style' => 'linear',
                ],
            ]
        );

        $this->add_responsive_control(
            'slider_image_height',
            [
                'label' => esc_html__('Image Height', 'listdom-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'vh'],
                'range' => [
                    'px' => [
                        'min' => 50,
                        'max' => 1000,
                    ],
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                    'em' => [
                        'min' => 1,
                        'max' => 50,
                    ],
                    'vh' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-gallery .lsd-gallery-slider .lsd-gallery-item a img' =>
                        'min-height: {{SIZE}}{{UNIT}} !important; max-height: {{SIZE}}{{UNIT}} !important;',
                ],
                'condition' => [
                    'style' => 'slider',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_object_fit',
            [
                'label' => esc_html__('Image Object Fit', 'listdom-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'cover',
                'options' => [
                    'fill' => esc_html__('Fill', 'listdom-elementor'),
                    'contain' => esc_html__('Contain', 'listdom-elementor'),
                    'cover' => esc_html__('Cover', 'listdom-elementor'),
                    'none' => esc_html__('None', 'listdom-elementor'),
                    'scale-down' => esc_html__('Scale Down', 'listdom-elementor'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-gallery .lsd-gallery-linear .lsd-gallery-grid-item img' => 'object-fit: {{VALUE}} !important;',
                ],
                'condition' => [
                    'style' => 'linear',
                ],
            ]
        );

        $this->add_control(
            'image_align',
            [
                'label' => esc_html__('Image Align', 'listdom-elementor'),
                'type' => Controls_Manager::SELECT,
                'default' => 'start',
                'options' => [
                    'start' => esc_html__('Start', 'listdom-elementor'),
                    'center' => esc_html__('Center', 'listdom-elementor'),
                    'end' => esc_html__('End', 'listdom-elementor'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-gallery .lsd-image-gallery' => 'justify-content: {{VALUE}};',
                ],
                'condition' => [
                    'style' => 'list',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'arrows_style_section',
            [
                'label' => esc_html__('Arrows', 'listdom-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'style' => 'slider',
                    'navigation_method' => 'nav',
                ],
            ]
        );

        $this->add_control(
            'arrow_color',
            [
                'label' => esc_html__('Arrow Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-gallery .owl-nav .owl-next' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .lsdaddelm-card-gallery .owl-nav .owl-prev' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'arrow_icon_size',
            [
                'label' => esc_html__('Icon Size', 'listdom-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em'],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 100,
                        'step' => 1,
                    ],
                    'em' => [
                        'min' => 0.5,
                        'max' => 5,
                        'step' => 0.1,
                    ],
                    '%' => [
                        'min' => 10,
                        'max' => 200,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-gallery .owl-nav .owl-next' => 'font-size: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .lsdaddelm-card-gallery .owl-nav .owl-prev' => 'font-size: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'arrow_text_shadow',
                'label' => esc_html__('Arrow Shadow', 'listdom-elementor'),
                'selector' => '{{WRAPPER}} .lsdaddelm-card-gallery .owl-nav .owl-next, {{WRAPPER}} .lsdaddelm-card-gallery .owl-nav .owl-prev',
            ]
        );

        $this->add_control(
            'arrow_padding',
            [
                'label' => esc_html__('Arrow Gap', 'listdom-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'default' => [
                    'top' => 16,
                    'right' => 24,
                    'bottom' => 16,
                    'left' => 24,
                    'unit' => 'px',
                    'isLinked' => true,
                ],
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-gallery .owl-nav .owl-next' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .lsdaddelm-card-gallery .owl-nav .owl-prev' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function listing(\LSD_Entity_Listing $listing): string
    {
        $settings = $this->get_settings_for_display();
        $lightbox = $settings['lightbox'] ?? 1;
        $link_method = isset($settings['link_method']) && trim($settings['link_method']) ? $settings['link_method'] : 'normal';
        $include_thumbnail = $settings['include_thumbnail'] ?? 0;
        $autoplay = !isset($settings['slider_autoplay']) || $settings['slider_autoplay'];
        $auto_height = !isset($settings['slider_auto_height']) || $settings['slider_auto_height'];
        $loop = isset($settings['slider_loop']) && $settings['slider_loop'];
        $thumbnail_status = $settings['thumbnail_status'] ?? 'image';
        $image_limit = $settings['image_limit'] ?? 4;
        $navigation_method = isset($settings['navigation_method']) && trim($settings['navigation_method']) ? $settings['navigation_method'] : 'dots';
        $style = $settings['style'] ?? 'list';

        return '<div class="lsdaddelm-card-gallery">' . $listing->get_gallery([
            'lightbox' => $lightbox,
            'link_method' => $link_method,
            'style' => $style,
            'include_thumbnail' => $include_thumbnail,
            'image_limit' => $image_limit,
            'thumbnail_status' => $thumbnail_status,
            'navigation_method' => $navigation_method,
            'autoplay' => $autoplay,
            'auto_height' => $auto_height,
            'loop' => $loop,
        ]) . '</div>';
    }
}
