<?php
namespace LSDPACELM\Widgets;

use Elementor\Group_Control_Typography;
use Elementor\Plugin;
use LSDPACELM\Widgets;
use Elementor\Controls_Manager;

class Claim extends Widgets
{
    public function get_name(): string
    {
        return 'lsd-listing-claim-button';
    }

    public function get_title(): string
    {
        return esc_html__('Claim Button', 'listdom-elementor');
    }

    public function get_icon(): string
    {
        return 'eicon-post';
    }

    public function register_controls()
    {
        $this->start_controls_section(
            'content_status_section',
            [
                'label' => esc_html__('After Claim', 'listdom-elementor'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'claimed_text',
            [
                'label' => esc_html__('Text', 'listdom-elementor'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Claimed!', 'listdom-elementor'),
            ]
        );

        $this->add_control(
            'preview_claimed',
            [
                'label' => esc_html__('Preview', 'textdomain'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'textdomain'),
                'label_off' => esc_html__('Hide', 'textdomain'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'style_button_section',
            [
                'label' => esc_html__('Before Claim', 'listdom-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'text_typography',
                'label' => esc_html__('Typography', 'listdom-elementor'),
                'selector' => '{{WRAPPER}} .lsdaddelm-card-claim .lsd-claim-button a',
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label' => esc_html__('Text Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-claim .lsd-claim-button a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'bg_color',
            [
                'label' => esc_html__('Background Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-claim .lsd-claim-button a' => 'background-color: {{VALUE}} !important',
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
                    'top' => 5,
                    'right' => 5,
                    'bottom' => 5,
                    'left' => 5,
                    'unit' => 'px',
                    'isLinked' => true,
                ],
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-claim .lsd-claim-button a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .lsdaddelm-card-claim .lsd-claim-button a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'style_claimed_section',
            [
                'label' => esc_html__('After Claim', 'listdom-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'claimed_text_typography',
                'label' => esc_html__('Typography', 'listdom-elementor'),
                'selector' => '{{WRAPPER}} .lsdaddelm-card-claim .lsd-claim-verified',
            ]
        );

        $this->add_control(
            'claimed_text_color',
            [
                'label' => esc_html__('Text Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-claim .lsd-claim-verified' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'claimed_bg_color',
            [
                'label' => esc_html__('Background Color', 'listdom-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lsdaddelm-card-claim .lsd-claim-verified' => 'background-color: {{VALUE}} !important',
                ],
            ]
        );

        $this->add_control(
            'claimed_padding',
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
                    '{{WRAPPER}} .lsdaddelm-card-claim .lsd-claim-verified' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'claimed_border_radius',
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
                    '{{WRAPPER}} .lsdaddelm-card-claim .lsd-claim-verified' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function listing(\LSD_Entity_Listing $listing): string
    {
        // Check Existence of Addon
        if (!class_exists(\LSDPACCLM\Base::class))
        {
            return \LSD_Main::alert(esc_html__('Claim addon should be installed and activated!', 'listdom-elementor'), 'warning');
        }

        $settings = $this->get_settings_for_display();

        $claimed_text = isset($settings['claimed_text']) && trim($settings['claimed_text'])
            ? $settings['claimed_text']
            : esc_html__('Claimed!', 'listdom-elementor');

        $preview_claimed = $settings['preview_claimed'] ?? 0;

        if ($listing->is_claimed() || (Plugin::instance()->editor->is_edit_mode() && $preview_claimed))
        {
            return '<div class="lsdaddelm-card-claim">
                <span class="lsd-claim-verified">' . esc_html($claimed_text) . '</span>
            </div>';
        }
        else return '<div class="lsdaddelm-card-claim">' . $listing->get_claim_button() . '</div>';
    }
}
