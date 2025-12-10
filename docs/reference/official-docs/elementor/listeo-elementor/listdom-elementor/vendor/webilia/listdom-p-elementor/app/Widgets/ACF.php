<?php
namespace LSDPACELM\Widgets;

use LSDPACELM\Widgets;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

class ACF extends Widgets
{
    public function get_name(): string
    {
        return 'lsd-listing-acf';
    }

    public function get_title(): string
    {
        return esc_html__('ACF Addon', 'listdom-elementor');
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

        // Fetch ACF Fields
        $acf_fields = $this->get_acf_fields();

        $default_fields = [];
        foreach ($acf_fields as $key => $label)
        {
            $default_fields[] = [
                'acf_field_key' => $key,
                'field_label' => '',
            ];
        }

        $this->add_control(
            'acf_fields',
            [
                'label' => esc_html__('ACF Fields', 'listdom-elementor'),
                'type' => Controls_Manager::REPEATER,
                'fields' => [
                    [
                        'name' => 'acf_field_key',
                        'label' => esc_html__('Field', 'listdom-elementor'),
                        'type' => Controls_Manager::SELECT,
                        'options' => $acf_fields,
                        'default' => '',
                    ],
                    [
                        'name' => 'field_label',
                        'label' => esc_html__('Label', 'listdom-elementor'),
                        'type' => Controls_Manager::TEXT,
                        'default' => '',
                    ],
                ],
                'title_field' => '{{{ field_label || acf_field_key }}}',
                'default' => $default_fields,
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
                'name' => 'acf_label_typography',
                'label' => esc_html__('Label Typography', 'listdom-elementor'),
                'selector' => '{{WRAPPER}} .lsdaddelm-card-acf strong',
            ]
        );

        $this->add_control(
            'label_text_color',
            [
                'label' => esc_html__('Label Text Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-acf strong' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'acf_typography',
                'label' => esc_html__('Value Typography', 'listdom-elementor'),
                'selector' => '{{WRAPPER}} .lsdaddelm-card-acf span',
            ]
        );

        $this->add_control(
            'value_text_color',
            [
                'label' => esc_html__('Value Text Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-acf' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();
    }

    private function get_acf_fields(): array
    {
        // Ensure ACF is active
        if (!function_exists('acf_get_field_groups'))
        {
            return [];
        }

        $field_groups = acf_get_field_groups([
            'post_type' => \LSD_Base::PTYPE_LISTING,
            'post_status' => 'publish',
        ]);

        $fields = [];

        foreach ($field_groups as $group)
        {
            $group_fields = acf_get_fields($group['key']);
            if (is_array($group_fields))
            {
                foreach ($group_fields as $field)
                {
                    if (in_array($field['type'], ['tab', 'accordion', 'message'])) continue;
                    $fields[$field['name']] = $field['label'] . ' (' . $field['name'] . ')';
                }
            }
        }

        return $fields;
    }

    protected function listing(\LSD_Entity_Listing $listing): string
    {
        // Ensure ACF Addon is installed
        if (!class_exists(\LSDPACACF\Base::class))
        {
            return \LSD_Main::alert(esc_html__('ACF addon should be installed and activated!', 'listdom-elementor'), 'warning');
        }

        $settings = $this->get_settings_for_display();
        $output = '<div class="lsdaddelm-card-acf">';

        if (count($settings['acf_fields']))
        {
            foreach ($settings['acf_fields'] as $field)
            {
                $acf_field = acf_get_field($field['acf_field_key']);

                if (!$acf_field) continue;
                if (in_array($acf_field['type'], ['tab', 'accordion', 'message'])) continue;

                // Get field value and pass it to acf() method
                $acf_field['value'] = get_field($acf_field['key'], $listing->id());
                $field_html = \LSD_Fields::acf($acf_field, $listing->id());

                $label = $field['field_label'] ?: $acf_field['label'];
                $output .= sprintf('<div class="acf-field"><strong>%s:</strong> <span>%s</span></div>', esc_html($label), $field_html);
            }
        }

        $output .= '</div>';
        return $output;
    }
}
