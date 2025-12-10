<?php
namespace LSDPACELM\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;

abstract class Taxonomies extends Widget_Base
{
    protected $shortcode_name;
    protected $taxonomy;

    public function get_name(): string
    {
        return 'lsd-listing-taxonomies';
    }

    public function get_title(): string
    {
        return esc_html__('Listdom Taxonomies', 'listdom-elementor');
    }

    public function get_categories(): array
    {
        return ['listdom'];
    }

    public function get_icon(): string
    {
        return 'eicon-gallery-grid';
    }

    public function register_controls()
    {
        // Add "Select Style" control
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
                'label' => esc_html__('Style', 'listdom-elementor'),
                'type' => Controls_Manager::SELECT,
                'default' => 'clean',
                'options' => $this->get_available_styles(),
            ]
        );

        // Max Grid control (for grid-based displays)
        $this->add_control(
            'grid',
            [
                'label' => esc_html__('Columns Count', 'listdom-elementor'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    1 => esc_html__('1 Column', 'listdom-elementor'),
                    2 => esc_html__('2 Columns', 'listdom-elementor'),
                    3 => esc_html__('3 Columns', 'listdom-elementor'),
                    4 => esc_html__('4 Columns', 'listdom-elementor'),
                    6 => esc_html__('6 Columns', 'listdom-elementor'),
                ],
                'default' => 4,
                'condition' => [
                    'style' => ['simple', 'clean'],
                ],
            ]
        );

        // Max Grid control (for grid-based displays)
        $this->add_control(
            'max_grid',
            [
                'label' => esc_html__('Maximum Images Per Row', 'listdom-elementor'),
                'type' => Controls_Manager::NUMBER,
                'default' => 8,
                'min' => 1,
                'max' => 100,
                'condition' => [
                    'style' => ['image'],
                ],
            ]
        );

        // Limit control (how many items to show)
        $this->add_control(
            'limit',
            [
                'label' => esc_html__('Limit', 'listdom-elementor'),
                'type' => Controls_Manager::NUMBER,
                'default' => 5,
                'min' => 1,
                'max' => 100,
            ]
        );

        // Show count (if to show term count)
        $this->add_control(
            'show_count',
            [
                'label' => esc_html__('Show Count', 'listdom-elementor'),
                'type' => Controls_Manager::SELECT,
                'default' => '0',
                'options' => [
                    '0' => esc_html__('No', 'listdom-elementor'),
                    '1' => esc_html__('Yes', 'listdom-elementor'),
                ],
                'condition' => [
                    'style' => ['clean', 'simple', 'image'],
                ],
            ]
        );

        if (in_array($this->shortcode_name, ['listdom_feature', 'listdom_category']))
        {
            $this->add_control(
                'show_icon',
                [
                    'label' => esc_html__('Show Icon', 'listdom-elementor'),
                    'type' => Controls_Manager::SELECT,
                    'default' => '1',
                    'options' => [
                        '0' => esc_html__('No', 'listdom-elementor'),
                        '1' => esc_html__('Yes', 'listdom-elementor'),
                    ],
                    'condition' => [
                        'style' => ['clean', 'carousel'],
                    ],
                ]
            );

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
                    'condition' => [
                        'style' => ['clean', 'carousel'],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .lsdaddelm-card-taxonomies .lsd-taxonomy-shortcode-clean .lsd-row>div a' => 'flex-direction: {{VALUE}} !important',
                        '{{WRAPPER}} .lsdaddelm-card-taxonomies .lsd-taxonomy-shortcode-carousel .lsd-term-carousel-item .lsd-term-carousel-item-wrapper a' => 'flex-direction: {{VALUE}} !important',
                    ],
                ]
            );
        }

        $this->end_controls_section();

        $this->start_controls_section(
            'query_section',
            [
                'label' => esc_html__('Query', 'listdom-elementor'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        // Add Source Control
        $this->add_control(
            'source',
            [
                'label' => esc_html__('Source', 'listdom-elementor'),
                'type' => Controls_Manager::SELECT,
                'default' => 'all',
                'options' => [
                    'all' => esc_html__('Show All', 'listdom-elementor'),
                    'manual' => esc_html__('Manual Selection', 'listdom-elementor'),
                    'parent' => esc_html__('Parent', 'listdom-elementor'),
                    'search' => esc_html__('Search', 'listdom-elementor'),
                ],
            ]
        );

        $this->add_control('manual_terms',
            [
                'label' => esc_html__('Select Terms', 'listdom-elementor'),
                'type' => Controls_Manager::SELECT2,
                'options' => $this->get_taxonomy_terms('listdom-' . $this->taxonomy),
                'multiple' => true,
                'label_block' => true,
                'condition' => [
                    'source' => 'manual',
                ],
                'description' => esc_html__('Select specific terms to display.', 'listdom-elementor'),
            ]
        );

        // Add Parent ID Control (only for 'parent' source option)
        $this->add_control(
            'parent_id',
            [
                'label' => esc_html__('Parent ID', 'listdom-elementor'),
                'type' => Controls_Manager::NUMBER,
                'default' => 0,
                'min' => 0,
                'description' => esc_html__('Enter the parent category ID. Use "0" for top-level categories.', 'listdom-elementor'),
                'condition' => [
                    'source' => 'parent',
                ],
            ]
        );

        // Add Search Keyword Control (only for 'search' source option)
        $this->add_control(
            'search_keyword',
            [
                'label' => esc_html__('Search Keyword', 'listdom-elementor'),
                'type' => Controls_Manager::TEXT,
                'description' => esc_html__('Enter the keyword to search categories.', 'listdom-elementor'),
                'condition' => [
                    'source' => 'search',
                ],
            ]
        );

        // Add Orderby Control
        $this->add_control(
            'orderby',
            [
                'label' => esc_html__('Order By', 'listdom-elementor'),
                'type' => Controls_Manager::SELECT,
                'default' => 'name',
                'options' => [
                    'name' => esc_html__('Name', 'listdom-elementor'),
                    'ID' => esc_html__('ID', 'listdom-elementor'),
                    'count' => esc_html__('Count', 'listdom-elementor'),
                ],
            ]
        );

        // Add Order Control
        $this->add_control(
            'order',
            [
                'label' => esc_html__('Order', 'listdom-elementor'),
                'type' => Controls_Manager::SELECT,
                'default' => 'ASC',
                'options' => [
                    'ASC' => esc_html__('Ascending', 'listdom-elementor'),
                    'DESC' => esc_html__('Descending', 'listdom-elementor'),
                ],
            ]
        );

        // Add Hide Empty Control
        $this->add_control(
            'hide_empty',
            [
                'label' => esc_html__('Hide Empty', 'listdom-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'listdom-elementor'),
                'label_off' => esc_html__('No', 'listdom-elementor'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'content_style_section',
            [
                'label' => esc_html__('Content', 'listdom-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => esc_html__('Title Typography', 'listdom-elementor'),
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-taxonomies > div[class^="lsd-taxonomy-shortcode-"] > div.lsd-row > div[class^="lsd-col-"] > a > .lsd-title' => 'font-size: {{SIZE}}{{UNIT}} !important; font-weight: {{WEIGHT}} !important; font-style: {{STYLE}} !important; line-height: {{LINE_HEIGHT}}{{UNIT}} !important;',
                    '{{WRAPPER}} .lsdaddelm-card-taxonomies > div[class^="lsd-taxonomy-shortcode-"] a > .lsd-term-name' => 'font-size: {{SIZE}}{{UNIT}} !important; font-weight: {{WEIGHT}} !important; font-style: {{STYLE}} !important; line-height: {{LINE_HEIGHT}}{{UNIT}} !important;',
                ],
                'condition' => [
                    'style' => ['clean', 'carousel', 'simple'],
                ],
            ]
        );

        $this->add_control(
            'title_text_color',
            [
                'label' => esc_html__('Title Text Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-taxonomies > div[class^="lsd-taxonomy-shortcode-"] .lsd-title' => 'color: {{VALUE}} !important',
                    '{{WRAPPER}} .lsdaddelm-card-taxonomies > div[class^="lsd-taxonomy-shortcode-"] .lsd-term-name' => 'color: {{VALUE}} !important',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'count_typography',
                'label' => esc_html__('Count Typography', 'listdom-elementor'),
                'selector' => '{{WRAPPER}} .lsdaddelm-card-taxonomies > div[class^="lsd-taxonomy-shortcode-"] > .lsd-row > div[class^="lsd-col-"] > a .lsd-count',
                'condition' => [
                    'style' => ['clean', 'carousel', 'simple'],
                ],
            ]
        );

        $this->add_control(
            'count_text_color',
            [
                'label' => esc_html__('Count Text Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-taxonomies > div[class^="lsd-taxonomy-shortcode-"] .lsd-count' => 'color: {{VALUE}} !important',
                ],
            ]
        );

        $this->add_responsive_control(
            'simple_content_padding',
            [
                'label' => esc_html__('Box Padding', 'listdom-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-taxonomies .lsd-taxonomy-shortcode-simple' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'style' => ['simple'],
                ],
            ]
        );

        $this->add_responsive_control(
            'justify_content',
            [
                'label' => esc_html__('Alignment', 'listdom-elementor'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__('Start', 'listdom-elementor'),
                        'icon' => 'eicon-align-start-h',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'listdom-elementor'),
                        'icon' => 'eicon-align-center-h',
                    ],
                    'flex-end' => [
                        'title' => esc_html__('End', 'listdom-elementor'),
                        'icon' => 'eicon-align-end-h',
                    ],
                    'space-between' => [
                        'title' => esc_html__('Space Between', 'listdom-elementor'),
                        'icon' => 'eicon-justify-space-between-h',
                    ],
                    'space-around' => [
                        'title' => esc_html__('Space Around', 'listdom-elementor'),
                        'icon' => 'eicon-justify-space-around-h',
                    ],
                    'space-evenly' => [
                        'title' => esc_html__('Space Evenly', 'listdom-elementor'),
                        'icon' => 'eicon-justify-space-evenly-h',
                    ],
                ],
                'default' => 'flex-start',
                'toggle' => true,
                'condition' => [
                    'style' => ['clean'],
                ],
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-taxonomies .lsd-taxonomy-shortcode-clean .lsd-row>div a' => 'justify-content: {{VALUE}} !important;',
                    '{{WRAPPER}} .lsdaddelm-card-taxonomies .lsd-taxonomy-shortcode-carousel .lsd-term-carousel-item .lsd-term-carousel-item-wrapper a' => 'justify-content: {{VALUE}} !important;',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'item_style_section',
            [
                'label' => esc_html__('Items', 'listdom-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'item_background_color',
            [
                'label' => esc_html__('Item Background Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-taxonomies > div[class^="lsd-taxonomy-shortcode-"]:not(.lsd-taxonomy-shortcode-carousel) a' => 'background-color: {{VALUE}} !important',
                    '{{WRAPPER}} .lsdaddelm-card-taxonomies .lsd-taxonomy-shortcode-carousel .lsd-term-carousel-item-wrapper' => 'background-color: {{VALUE}} !important',
                ],
                'condition' => [
                    'style' => ['simple', 'clean', 'image'],
                ],
            ]
        );

        $this->add_control(
            'carousel_item_background_color',
            [
                'label' => esc_html__('Carousel Item Background Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-taxonomies .lsd-taxonomy-shortcode-carousel .lsd-term-carousel-item-wrapper' => 'background-color: {{VALUE}} !important',
                ],
                'condition' => [
                    'style' => 'carousel',
                ],
            ]
        );

        $this->add_control(
            'item_hover_background_color',
            [
                'label' => esc_html__('Item Hover Background Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-taxonomies > div[class^="lsd-taxonomy-shortcode-"]:not(.lsd-taxonomy-shortcode-carousel) a:hover' => 'background-color: {{VALUE}} !important',
                    '{{WRAPPER}} .lsdaddelm-card-taxonomies .lsd-taxonomy-shortcode-image .lsd-ts-image-wrapper .lsd-ts-image>a:hover .lsd-title' => 'background-color: {{VALUE}} !important',
                ],
                'condition' => [
                    'style' => ['simple', 'clean', 'image'],
                ],
            ]
        );

        $this->add_control(
            'carousel_item_hover_background_color',
            [
                'label' => esc_html__('Carousel Item Hover Background Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-taxonomies .lsd-taxonomy-shortcode-carousel .lsd-term-carousel-item-wrapper:hover' => 'background-color: {{VALUE}} !important',
                ],
                'condition' => [
                    'style' => 'carousel',
                ],
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
                    '{{WRAPPER}} .lsdaddelm-card-taxonomies > div[class^="lsd-taxonomy-shortcode-"] a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .lsdaddelm-card-taxonomies .lsd-taxonomy-shortcode-carousel .lsd-term-carousel-item-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'style' => ['clean', 'simple', 'carousel'],
                ],
            ]
        );

        $this->add_responsive_control(
            'items_padding',
            [
                'label' => esc_html__('Items Padding', 'listdom-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-taxonomies > div[class^="lsd-taxonomy-shortcode-"] a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .lsdaddelm-card-taxonomies .lsd-taxonomy-shortcode-carousel .lsd-term-carousel-item-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'style' => ['clean', 'simple'],
                ],
            ]
        );

        $this->add_responsive_control(
            'gap_title_count',
            [
                'label' => esc_html__('Gap Between Title and Count', 'listdom-elementor'),
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
                    '{{WRAPPER}} .lsdaddelm-card-taxonomies > .lsd-taxonomy-shortcode-wrapper > .lsd-row > div[class^="lsd-col-"] > a > .lsd-title' => 'gap: {{SIZE}}{{UNIT}} !important;',
                ],
                'condition' => [
                    'style' => 'clean',
                ],
            ]
        );

        $this->add_responsive_control(
            'gap_icon_content',
            [
                'label' => esc_html__('Gap Between Icon and Content', 'listdom-elementor'),
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
                    '{{WRAPPER}} .lsdaddelm-card-taxonomies > .lsd-taxonomy-shortcode-wrapper > .lsd-row > div[class^="lsd-col-"] > a' => 'gap: {{SIZE}}{{UNIT}} !important;',
                    '{{WRAPPER}} .lsdaddelm-card-taxonomies > .lsd-taxonomy-shortcode-wrapper .owl-stage-outer > .owl-stage > .owl-item > .lsd-term-carousel-item a' => 'gap: {{SIZE}}{{UNIT}} !important;',
                ],
                'condition' => [
                    'style' => ['clean', 'carousel'],
                ],
            ]
        );

        $this->end_controls_section();

        if (in_array($this->shortcode_name, ['listdom_feature', 'listdom_category']))
        {

            $this->start_controls_section(
                'icon_style_section',
                [
                    'label' => esc_html__('Icon', 'listdom-elementor'),
                    'tab' => Controls_Manager::TAB_STYLE,
                    'condition' => [
                        'style' => ['clean', 'carousel'],
                    ],
                ]
            );

            $this->add_control(
                'term_circle_background_color',
                [
                    'label' => esc_html__('Term Circle Background Color', 'listdom-elementor'),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .lsdaddelm-card-taxonomies > div[class^="lsd-taxonomy-shortcode-"] .lsd-term-circle' => 'background-color: {{VALUE}} !important',
                    ],
                ]
            );

            $this->add_control(
                'count_icon_color',
                [
                    'label' => esc_html__('Icon Text Color', 'listdom-elementor'),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .lsdaddelm-card-taxonomies > div[class^="lsd-taxonomy-shortcode-"] .lsd-term-circle .lsd-fe-icon' => 'color: {{VALUE}} !important',
                        '{{WRAPPER}} .lsdaddelm-card-taxonomies .lsd-taxonomy-shortcode-carousel .lsd-term-circle .lsd-icon-wrapper' => 'color: {{VALUE}} !important',
                    ],
                ]
            );

            $this->add_responsive_control(
                'icon_items_padding',
                [
                    'label' => esc_html__('Icon Box Padding', 'listdom-elementor'),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', '%', 'em'],
                    'selectors' => [
                        '{{WRAPPER}} .lsdaddelm-card-taxonomies > div[class^="lsd-taxonomy-shortcode-"] .lsd-row>div a>div.lsd-term-circle' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                        '{{WRAPPER}} .lsdaddelm-card-taxonomies > div[class^="lsd-taxonomy-shortcode-"] .lsd-term-circle' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                    ],
                ]
            );
            $this->end_controls_section();
        }

    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        // Common shortcode attributes
        $atts = [
            'style' => $settings['style'] ?? 'clean',
        ];

        // Add optional attributes
        foreach (['limit', 'max_grid', 'grid', 'show_count', 'show_icon', 'orderby', 'order'] as $key)
        {
            if (isset($settings[$key]))
            {
                $atts[$key] = $settings[$key];
            }
        }

        if (isset($settings['hide_empty']) && $settings['hide_empty'] === 'yes')
        {
            $atts['hide_empty'] = true;
        }

        // Process the source settings
        if (isset($settings['source']))
        {
            switch ($settings['source'])
            {
                case 'manual':
                    $manual_terms_key = 'manual_terms';
                    if (!empty($settings[$manual_terms_key]))
                    {
                        $atts['ids'] = implode(',', array_map('intval', $settings[$manual_terms_key]));
                    }
                    break;
                case 'parent':
                    if (isset($settings['parent_id']))
                    {
                        $atts['parent'] = $settings['parent_id'];
                    }
                    break;
                case 'search':
                    if (isset($settings['search_keyword']))
                    {
                        $atts['search'] = $settings['search_keyword'];
                    }
                    break;
                case 'all':
                default:
                    break;
            }
        }

        // Build shortcode attributes string
        $atts_parts = [];
        foreach ($atts as $key => $value)
        {
            if (is_bool($value)) $value = $value ? 'true' : 'false';
            $atts_parts[] = $key . '="' . (is_array($value) ? implode(',', $value) : $value) . '"';
        }

        // Generate the shortcode
        $shortcode = '[' . $this->shortcode_name . ' ' . implode(' ', $atts_parts) . ']';

        // Render the output
        echo '<div class="lsdaddelm-card-taxonomies">' . do_shortcode($shortcode) . '</div>';
    }

    protected function get_taxonomy_terms($taxonomy): array
    {
        $terms = get_terms([
            'taxonomy' => $taxonomy,
            'hide_empty' => false,
        ]);

        $options = [];
        if (!is_wp_error($terms))
        {
            foreach ($terms as $term) $options[$term->term_id] = $term->name;
        }

        return $options;
    }

    abstract protected function get_available_styles(): array;
}
