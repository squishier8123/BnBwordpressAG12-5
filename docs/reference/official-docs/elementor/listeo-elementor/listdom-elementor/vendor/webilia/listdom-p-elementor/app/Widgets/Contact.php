<?php
namespace LSDPACELM\Widgets;

use LSDPACELM\Widgets;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

class Contact extends Widgets
{
    public function get_name(): string
    {
        return 'lsd-listing-contact';
    }

    public function get_title(): string
    {
        return esc_html__('Contact Info', 'listdom-elementor');
    }

    public function get_icon(): string
    {
        return 'eicon-mail';
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
            'style_type',
            [
                'label' => esc_html__('Style Type', 'listdom-elementor'),
                'type' => Controls_Manager::SELECT,
                'default' => 'default',
                'options' => [
                    'default' => esc_html__('Default', 'listdom-elementor'),
                    'custom' => esc_html__('Custom', 'listdom-elementor'),
                ],
            ]
        );

        $this->add_control(
            'show_email',
            [
                'label' => esc_html__('Show Email', 'listdom-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'listdom-elementor'),
                'label_off' => esc_html__('No', 'listdom-elementor'),
                'return_value' => '1',
                'default' => '1',
                'condition' => [
                    'style_type' => 'default',
                ],
            ]
        );

        $this->add_control(
            'show_phone',
            [
                'label' => esc_html__('Show Phone', 'listdom-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'listdom-elementor'),
                'label_off' => esc_html__('No', 'listdom-elementor'),
                'return_value' => '1',
                'default' => '1',
                'condition' => [
                    'style_type' => 'default',
                ],
            ]
        );

        $this->add_control(
            'show_website',
            [
                'label' => esc_html__('Show Website', 'listdom-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'listdom-elementor'),
                'label_off' => esc_html__('No', 'listdom-elementor'),
                'return_value' => '1',
                'default' => '1',
                'condition' => [
                    'style_type' => 'default',
                ],
            ]
        );

        $this->add_control(
            'show_address',
            [
                'label' => esc_html__('Show Address', 'listdom-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'listdom-elementor'),
                'label_off' => esc_html__('No', 'listdom-elementor'),
                'return_value' => '1',
                'default' => '1',
                'condition' => [
                    'style_type' => 'default',
                ],
            ]
        );

        if (\LSD_Components::socials())
        {
            $this->add_control(
                'show_socials',
                [
                    'label' => esc_html__('Show Socials', 'listdom-elementor'),
                    'type' => Controls_Manager::SWITCHER,
                    'label_on' => esc_html__('Yes', 'listdom-elementor'),
                    'label_off' => esc_html__('No', 'listdom-elementor'),
                    'return_value' => '1',
                    'default' => '1',
                    'condition' => [
                        'style_type' => 'default',
                    ],
                ]
            );
        }

        $this->add_control(
            'display_icon',
            [
                'label' => esc_html__('Display Icon', 'listdom-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'listdom-elementor'),
                'label_off' => esc_html__('No', 'listdom-elementor'),
                'return_value' => '1',
                'default' => '1',
                'condition' => [
                    'style_type' => 'default',
                ],
            ]
        );

        $this->add_control(
            'display_label',
            [
                'label' => esc_html__('Display Label', 'listdom-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'listdom-elementor'),
                'label_off' => esc_html__('No', 'listdom-elementor'),
                'return_value' => '1',
                'default' => '0',
                'condition' => [
                    'style_type' => 'default',
                ],
            ]
        );

        $contact_info = $this->get_contact();

        if (\LSD_Components::socials())
        {
            // Merge additional social fields from LSD_Options::socials()
            $social_fields = \LSD_Options::socials();
            foreach ($social_fields as $key => $value)
            {
                $contact_info[$key] = [
                    'value' => $value,
                    'icon' => $this->get_share_icon($key),
                ];
            }
        }

        // Prepare repeater fields dynamically
        $fields = [];
        $default_repeater_items = [];

        foreach ($contact_info as $key => $data)
        {
            $fields[$key] = ucfirst(str_replace('_', ' ', $key));
            $default_repeater_items[] = [
                'field_id' => $key,
                'field_icon' => $data['icon'],
                'field_display_name' => '0',
            ];
        }

        // Add the Repeater control
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
                        'name' => 'field_icon',
                        'label' => esc_html__('Icon', 'listdom-elementor'),
                        'type' => Controls_Manager::ICONS,
                        'default' => [],
                        'label_block' => true,
                        'skin' => 'media',
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
                    [
                        'name' => 'custom_display_name',
                        'label' => esc_html__('Name', 'listdom-elementor'),
                        'type' => Controls_Manager::TEXT,
                        'default' => '',
                        'condition' => [
                            'field_display_name' => '1',
                        ],
                    ],
                ],
                'default' => $default_repeater_items,
                'title_field' => '# {{{ field_id }}}',
                'condition' => [
                    'style_type' => 'custom',
                ],
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
                'name' => 'contact_typography',
                'selector' => '{{WRAPPER}} .lsdaddelm-card-contact ul li a',
                'condition' => [
                    'style_type' => 'default',
                ],
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
                    '{{WRAPPER}} .lsdaddelm-card-contact .lsd-contact-info ul' => 'flex-direction: {{VALUE}}',
                ],
            ]
        );

        if (\LSD_Components::socials())
        {
            $this->add_control(
                'social_layout',
                [
                    'label' => esc_html__('Social Icons Layout', 'listdom-elementor'),
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
                        '{{WRAPPER}} .lsdaddelm-card-contact .lsd-listing-social-networks ul' => 'flex-direction: {{VALUE}}',
                    ],
                    'condition' => [
                        'style_type' => 'default',
                    ],
                ]
            );
        }

        $this->add_control(
            'gap',
            [
                'label' => esc_html__('Gap', 'listdom-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-contact .lsd-contact-info ul' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Typography and Color for Name
        $this->add_control(
            'name_color',
            [
                'label' => esc_html__('Name Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-contact .lsd-contact-name' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'style_type' => 'custom',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'name_typography',
                'label' => esc_html__('Name Typography', 'listdom-elementor'),
                'selector' => '{{WRAPPER}} .lsdaddelm-card-contact .lsd-contact-name',
                'condition' => [
                    'style_type' => 'custom',
                ],
            ]
        );

        // Typography and Color for Value
        $this->add_control(
            'value_color',
            [
                'label' => esc_html__('Value Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-contact .lsd-contact-value' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'style_type' => 'custom',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'value_typography',
                'label' => esc_html__('Value Typography', 'listdom-elementor'),
                'selector' => '{{WRAPPER}} .lsdaddelm-card-contact .lsd-contact-value',
                'condition' => [
                    'style_type' => 'custom',
                ],
            ]
        );

        // Icon size and color
        $this->add_control(
            'icon_size',
            [
                'label' => esc_html__('Icon Size', 'listdom-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 16,
                ],
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-contact i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'style_type' => 'custom',
                ],
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label' => esc_html__('Icon Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-contact i' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'style_type' => 'custom',
                ],
            ]
        );

        $this->add_control(
            'padding',
            [
                'label' => esc_html__('Padding', 'listdom-elementor'),
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
                    '{{WRAPPER}} .lsdaddelm-card-contact' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function listing(\LSD_Entity_Listing $listing): string
    {
        $settings = $this->get_settings_for_display();

        if ($settings['style_type'] === 'custom')
        {
            if (empty($settings['fields'])) return '<div>' . esc_html__('No fields selected.', 'listdom-elementor') . '</div>';

            $output = '<div class="lsdaddelm-card-contact lsd-no-bullets">';
            $output .= '<div class="lsd-contact-info"><ul>';

            foreach ($settings['fields'] as $field)
            {
                $field_id = $field['field_id'];
                $value = get_post_meta($listing->id(), 'lsd_' . $field_id, true);

                if (trim($value) === '') continue;

                $icon = $field['field_icon']['value'] ?? '';
                $custom_display_name = $field['custom_display_name'] ?? '';
                $field_name = trim($custom_display_name) ? $custom_display_name : ucfirst(str_replace('_', ' ', $field_id));
                $display_name = isset($field['field_display_name']) && $field['field_display_name'] === '1';

                $output .= '<li>';

                if (!empty($icon)) $output .= '<i class="' . esc_attr($icon) . '"></i> ';
                if ($display_name) $output .= '<span class="lsd-contact-name">' . esc_html($field_name) . ': </span>';

                if (\LSD_Base::is_url($value))
                {
                    $output .= '<span class="lsd-contact-value">
                        <a href="' . esc_url($value) . '" target="_blank">' . esc_html(\LSD_Base::remove_protocols($value)) . '</a>
                    </span>';
                }
                else if (is_email($value))
                {
                    $output .= '<span class="lsd-contact-value">
                        <a href="mailto:' . esc_attr($value) . '">' . esc_html($value) . '</a>
                    </span>';
                }
                else if ($field_id === 'phone')
                {
                    $output .= '<span class="lsd-contact-value">
                        <a href="tel:' . esc_attr($value) . '">' . esc_html($value) . '</a>
                    </span>';
                }
                else if ($field_id === 'whatsapp')
                {
                    $tel = str_replace([' ', '-', '(', ')'], '', $value);
                    $output .= '<span class="lsd-contact-value">
                        <a href="https://wa.me/' . esc_attr($tel) . '">' . esc_html($value) . '</a>
                    </span>';
                }
                else $output .= '<span class="lsd-contact-value">' . esc_html($value) . '</span>';

                $output .= '</li>';
            }

            $output .= '</ul></div></div>';
            return $output;
        }
        else
        {
            return '<div class="lsdaddelm-card-contact lsd-no-bullets">' . $listing->get_contact_info([
                    'show_email' => $settings['show_email'] ?? 1,
                    'show_phone' => $settings['show_phone'] ?? 1,
                    'show_website' => $settings['show_website'] ?? 1,
                    'show_address' => $settings['show_address'] ?? 1,
                    'show_socials' => \LSD_Components::socials() ? ($settings['show_socials'] ?? 1) : 0,
                    'display_icon' => $settings['display_icon'] ?? 1,
                    'display_label' => $settings['display_label'] ?? 0,
                ]) . '</div>';
        }
    }

    private function get_contact(): array
    {
        return [
            'email' => [
                'value' => '',
                'icon' => ['value' => 'fas fa-envelope', 'library' => 'solid'],
            ],
            'phone' => [
                'value' => '',
                'icon' => ['value' => 'fas fa-phone', 'library' => 'solid'],
            ],
            'website' => [
                'value' => '',
                'icon' => ['value' => 'fas fa-globe', 'library' => 'solid'],
            ],
            'contact_address' => [
                'value' => '',
                'icon' => ['value' => 'fas fa-map-marker-alt', 'library' => 'solid'],
            ],
        ];
    }

    public function get_share_icon($key): array
    {
        $icons = [
            'facebook' => 'fab fa-facebook',
            'twitter' => 'fa fa-times',
            'instagram' => 'fab fa-instagram',
            'linkedin' => 'fab fa-linkedin',
            'pinterest' => 'fab fa-pinterest',
            'whatsapp' => 'fab fa-whatsapp',
            'youtube' => 'fab fa-youtube',
            'tiktok' => 'fab fa-tiktok',
            'telegram' => 'fab fa-telegram',
        ];

        return [
            'value' => $icons[$key] ?? 'fas fa-share-alt',
            'library' => 'brands',
        ];
    }
}
