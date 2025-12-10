<?php
namespace LSDPACELM\Widgets;

use LSDPACELM\Widgets;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;

class Attributes extends Widgets
{
    public function get_name(): string
    {
        return 'lsd-listing-attributes';
    }

    public function get_title(): string
    {
        return esc_html__('Listing Custom Fields', 'listdom-elementor');
    }

    public function get_icon(): string
    {
        return 'eicon-database';
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
            'layout',
            [
                'label' => esc_html__('Layout', 'listdom-elementor'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'column' => [
                        'title' => esc_html__('Default', 'listdom-elementor'),
                        'icon' => 'eicon-editor-list-ul',
                    ],
                    'row' => [
                        'title' => esc_html__('Inline', 'listdom-elementor'),
                        'icon' => 'eicon-ellipsis-h',
                    ],
                ],
                'default' => 'column',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-attributes' => 'flex-direction: {{VALUE}}',
                ],
            ]
        );

        // Attributes
        $terms = \LSD_Main::get_attributes();

        $fields = [];
        foreach ($terms as $term) $fields[$term->slug] = $term->name;

        $this->add_control(
            'fields',
            [
                'label' => esc_html__('Fields', 'listdom-elementor'),
                'description' => esc_html__('Select your desired fields to display', 'listdom-elementor'),
                'type' => Controls_Manager::REPEATER,
                'fields' => [
                    [
                        'name' => 'field_id',
                        'label' => esc_html__('Field', 'listdom-elementor'),
                        'type' => Controls_Manager::SELECT,
                        'options' => $fields,
                        'default' => '',
                        'label_block' => false,
                    ],
                    [
                        'name' => 'field_global_icon',
                        'label' => esc_html__('Global Icon', 'listdom-elementor'),
                        'type' => Controls_Manager::SWITCHER,
                        'label_on' => esc_html__('Yes', 'listdom-elementor'),
                        'label_off' => esc_html__('No', 'listdom-elementor'),
                        'return_value' => '1',
                        'default' => '1',
                    ],
                    [
                        'name' => 'field_icon',
                        'label' => esc_html__('Icon', 'listdom-elementor'),
                        'type' => Controls_Manager::ICONS,
                        'default' => [],
                        'label_block' => true,
                        'skin' => 'media',
                        'condition' => [
                            'field_global_icon' => '',
                        ],
                    ],
                    [
                        'name' => 'field_display_name',
                        'label' => esc_html__('Name', 'listdom-elementor'),
                        'type' => Controls_Manager::SWITCHER,
                        'label_on' => esc_html__('Show', 'listdom-elementor'),
                        'label_off' => esc_html__('Hide', 'listdom-elementor'),
                        'return_value' => '1',
                        'default' => '1',
                    ],
                ],
                'title_field' => '# {{{ field_id }}}',
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

        $this->add_control('icon_scale', [
            'label' => esc_html__('Icon Scale', 'listdom-elementor'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['em'],
            'range' => [
                'em' => [
                    'min' => 0.0,
                    'max' => 4.0,
                    'step' => 0.1,
                ],
            ],
            'default' => [
                'unit' => 'em',
                'size' => 1,
            ],
            'selectors' => [
                '{{WRAPPER}} .lsdaddelm-card-attributes .lsdaddelm-attr-key img' => 'transform: scale({{SIZE}});',
                '{{WRAPPER}} .lsdaddelm-card-attributes .lsdaddelm-attr-key svg' => 'transform: scale({{SIZE}});',
                '{{WRAPPER}} .lsdaddelm-card-attributes .lsdaddelm-attr-key i' => 'transform: scale({{SIZE}});',
            ],
        ]);

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'attributes_typography',
                'selector' => '{{WRAPPER}} .lsdaddelm-card-attributes, {{WRAPPER}} .lsdaddelm-card-attributes a',
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label' => esc_html__('Text Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-attributes' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .lsdaddelm-card-attributes a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function listing(\LSD_Entity_Listing $listing): string
    {
        $listing_attributes = get_post_meta($listing->id(), 'lsd_attributes', true);

        if (!is_array($listing_attributes)) $listing_attributes = [];
        if (!count($listing_attributes)) return '';

        $settings = $this->get_settings_for_display();
        $fields = isset($settings['fields']) && is_array($settings['fields']) ? $settings['fields'] : [];

        $output = '';
        foreach ($fields as $field)
        {
            // No Field ID
            if (!isset($field['field_id'])) continue;

            // Term
            if (!is_numeric($field['field_id'])) $term = get_term_by('slug', $field['field_id'], \LSD_Base::TAX_ATTRIBUTE);
            else $term = get_term($field['field_id']);

            // No Term
            if (!isset($term->term_id) || $term->taxonomy !== \LSD_Base::TAX_ATTRIBUTE) continue;

            // Listdom Attribute
            $att = new \LSD_Entity_Attribute($term->term_id);

            // Value
            $value = $att->render($listing_attributes[$term->slug] ?? '');

            // No Value
            if (trim($value) === '') continue;

            $global_icon = (bool) ($field['field_global_icon'] ?? 0);

            if ($global_icon) $icon = \LSD_Kses::element($att->icon());
            else $icon = Icons_Manager::try_get_icon_html($field['field_icon'], ['aria-hidden' => 'true', 'class' => 'lsd-icon', 'title' => $term->name]);

            $display_name = (bool) ($field['field_display_name'] ?? 0);

            $name = '';
            if ($display_name) $name = esc_html($term->name) . ': ';

            $output .= '<div class="lsdaddelm-attr lsdaddelm-attr-' . sanitize_html_class($att->type) . '" ' . \LSD_Entity_Attribute::schema($term->term_id) . '>
                <span class="lsdaddelm-attr-key">' . $icon . $name . '</span>
                <span class="lsdaddelm-attr-value">' . \LSD_Kses::element($value) . '</span>
            </div>';
        }

        // No Attributes
        if (trim($output) === '') return '';

        return '<div class="lsdaddelm-card-attributes">' . $output . '</div>';
    }
}
