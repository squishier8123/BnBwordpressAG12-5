<?php
namespace LSDPACELM\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class Shortcode extends Widget_Base
{
    public function get_name(): string
    {
        return 'lsd-listing-shortcode';
    }

    public function get_title(): string
    {
        return esc_html__('Listdom Shortcode', 'listdom-elementor');
    }

    public function get_categories(): array
    {
        return ['listdom'];
    }

    public function get_icon(): string
    {
        return 'eicon-shortcode';
    }

    protected function register_controls()
    {
        $this->start_controls_section(
            'shortcode_section',
            [
                'label' => esc_html__('Shortcode', 'listdom-elementor'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $posts = get_posts([
            'post_type' => \LSD_Base::PTYPE_SHORTCODE,
            'posts_per_page' => '-1',
        ]);

        $shortcodes = [];
        foreach ($posts as $post) $shortcodes[$post->ID] = $post->post_title;

        $this->add_control(
            'shortcode',
            [
                'label' => esc_html__('Listdom Shortcode', 'listdom-elementor'),
                'type' => Controls_Manager::SELECT,
                'options' => $shortcodes,
                'description' => sprintf(esc_html__("You can create unlimited %s shortcodes in the Listdom => Shortcodes menu and use them here.", 'listdom-elementor'), '<strong>' . esc_html__('skin', 'listdom-elementor') . '</strong>'),
            ]
        );

        $this->add_control(
            'shortcode_edit_button',
            [
                'type' => Controls_Manager::RAW_HTML,
                'raw' => '<div style="margin-top:10px; text-align: center;"><a id="lsd-shortcode-edit-link" href="#" class="elementor-button elementor-button-default" target="_blank">' . esc_html__('Edit Shortcode', 'listdom-elementor') . '</a></div>',
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $id = isset($settings['shortcode']) && is_numeric($settings['shortcode']) ? $settings['shortcode'] : 0;

        if (!$id)
        {
            echo esc_html__('Shortcode not found!', 'listdom-elementor');
            return;
        }

        echo do_shortcode('[listdom id="' . $id . '"]');
    }
}
