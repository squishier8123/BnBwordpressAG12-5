<?php
namespace LSDPACELM\Widgets;

use LSDPACELM\Widgets;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

class Content extends Widgets
{
    protected $css_selector = '{{WRAPPER}} .lsdaddelm-card-content';

    public function get_name(): string
    {
        return 'lsd-listing-content';
    }

    public function get_title(): string
    {
        return esc_html__('Listing Content', 'listdom-elementor');
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
            'content_length',
            [
                'label' => esc_html__('Content Length', 'listdom-elementor'),
                'type' => Controls_Manager::NUMBER,
                'description' => esc_html__('Length in words', 'listdom-elementor'),
                'default' => '',
            ]
        );

        $this->add_control(
            'auto_p',
            [
                'label' => esc_html__('Auto Paragraph', 'listdom-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'listdom-elementor'),
                'label_off' => esc_html__('No', 'listdom-elementor'),
                'return_value' => '1',
                'default' => '0',
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
                'name' => 'content_typography',
                'selector' => $this->css_selector,
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label' => esc_html__('Text Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    $this->css_selector => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function listing(\LSD_Entity_Listing $listing): string
    {
        $content = $listing->post->post_content;
        $settings = $this->get_settings_for_display();

        // Content Length
        $length = (int) ($settings['content_length'] ?? 0);
        if ($length)
        {
            $content = wp_strip_all_tags($content);

            $words = explode(' ', $content);
            $content = array_slice($words, 0, $length);
            $content = implode(' ', $content);
        }

        // Auto Paragraph
        $auto_p = (bool) ($settings['auto_p'] ?? 0);
        if ($auto_p) $content = wpautop($content);

        return '<div class="lsdaddelm-card-content">' . $listing->get_content($content) . '</div>';
    }
}
