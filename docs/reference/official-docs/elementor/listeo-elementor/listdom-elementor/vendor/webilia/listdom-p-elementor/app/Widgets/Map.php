<?php
namespace LSDPACELM\Widgets;

use Elementor\Controls_Manager;
use LSDPACELM\Widgets;

class Map extends Widgets
{
    public function get_name(): string
    {
        return 'lsd-listing-map';
    }

    public function get_title(): string
    {
        return esc_html__('Listing Map', 'listdom-elementor');
    }

    public function get_icon(): string
    {
        return 'eicon-google-maps';
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

        $this->add_control(
            'provider',
            [
                'label' => esc_html__('Map Provider', 'listdom-elementor'),
                'type' => Controls_Manager::SELECT,
                'default' => \LSD_Map_Provider::def(),
                'options' => \LSD_Map_Provider::get_providers(),
            ]
        );

        $this->add_control(
            'infowindow',
            [
                'label' => esc_html__('Infowindow', 'listdom-elementor'),
                'type' => Controls_Manager::SELECT,
                'default' => '0',
                'options' => [
                    '0' => esc_html__('Disabled', 'listdom-elementor'),
                    '1' => esc_html__('Enabled', 'listdom-elementor'),
                ],
            ]
        );

        $this->add_control(
            'zoomlevel',
            [
                'label' => esc_html__('Zoom Level', 'listdom-elementor'),
                'type' => Controls_Manager::SELECT,
                'default' => '14',
                'options' => [
                    '4' => 4, '5' => 5, '6' => 6, '7' => 7,
                    '8' => 8, '9' => 9, '10' => 10, '11' => 11,
                    '12' => 12, '13' => 13, '14' => 14,
                    '15' => 15, '16' => 16,
                ],
            ]
        );

        $this->add_control(
            'map_height',
            [
                'label' => esc_html__('Map Height', 'listdom-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'vh'],
                'range' => [
                    'px' => ['min' => 0, 'max' => 800],
                    'vh' => ['min' => 1, 'max' => 100],
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'googlemap_section',
            [
                'label' => esc_html__('Google Map Settings', 'listdom-elementor'),
                'tab' => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'provider' => 'googlemap',
                ],
            ]
        );

        $this->add_control(
            'style',
            [
                'label' => esc_html__('Style', 'listdom-elementor'),
                'type' => Controls_Manager::SELECT,
                'default' => '',
                'options' => \LSD_Base::get_map_styles(),
            ]
        );

        $this->add_control(
            'gplaces',
            [
                'label' => esc_html__('Google Places', 'listdom-elementor'),
                'type' => Controls_Manager::SELECT,
                'default' => '0',
                'options' => [
                    '0' => esc_html__('Disabled', 'listdom-elementor'),
                    '1' => esc_html__('Enabled', 'listdom-elementor'),
                ],
            ]
        );

        $this->add_control(
            'control_zoom',
            [
                'label' => esc_html__('Zoom Control', 'listdom-elementor'),
                'type' => Controls_Manager::SELECT,
                'default' => 'RIGHT_BOTTOM',
                'options' => $this->get_map_control_options(),
            ]
        );

        $this->add_control(
            'control_maptype',
            [
                'label' => esc_html__('Map Type Control', 'listdom-elementor'),
                'type' => Controls_Manager::SELECT,
                'default' => 'TOP_LEFT',
                'options' => $this->get_map_control_options(),
            ]
        );

        $this->add_control(
            'control_streetview',
            [
                'label' => esc_html__('Street View Control', 'listdom-elementor'),
                'type' => Controls_Manager::SELECT,
                'default' => 'RIGHT_BOTTOM',
                'options' => $this->get_map_control_options(),
            ]
        );

        $this->add_control(
            'control_scale',
            [
                'label' => esc_html__('Scale Control', 'listdom-elementor'),
                'type' => Controls_Manager::SELECT,
                'default' => '0',
                'options' => [
                    '0' => esc_html__('Disabled', 'listdom-elementor'),
                    '1' => esc_html__('Enabled', 'listdom-elementor'),
                ],
            ]
        );

        $this->add_control(
            'control_camera',
            [
                'label' => esc_html__('Camera Control', 'listdom-elementor'),
                'type' => Controls_Manager::SELECT,
                'default' => '0',
                'options' => [
                    '0' => esc_html__('Disabled', 'listdom-elementor'),
                    '1' => esc_html__('Enabled', 'listdom-elementor'),
                ],
            ]
        );

        $this->add_control(
            'control_fullscreen',
            [
                'label' => esc_html__('Fullscreen Control', 'listdom-elementor'),
                'type' => Controls_Manager::SELECT,
                'default' => '1',
                'options' => [
                    '0' => esc_html__('Disabled', 'listdom-elementor'),
                    '1' => esc_html__('Enabled', 'listdom-elementor'),
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function listing(\LSD_Entity_Listing $listing): string
    {
        // Map Options
        $settings = $this->get_settings_for_display();

        $mapcontrols = \LSD_Options::defaults('mapcontrols');
        $mapcontrols['zoom'] = $settings['control_zoom'] ?? $mapcontrols['zoom'];
        $mapcontrols['maptype'] = $settings['control_maptype'] ?? $mapcontrols['maptype'];
        $mapcontrols['streetview'] = $settings['control_streetview'] ?? $mapcontrols['streetview'];
        $mapcontrols['scale'] = $settings['control_scale'] ?? $mapcontrols['scale'];
        $mapcontrols['camera'] = $settings['control_camera'] ?? $mapcontrols['camera'];
        $mapcontrols['fullscreen'] = $settings['control_fullscreen'] ?? $mapcontrols['fullscreen'];
        $mapcontrols['draw'] = '0';
        $mapcontrols['gps'] = '0';

        // Map Height
        $map_height = '';
        if (isset($settings['map_height']['size']) && $settings['map_height']['size'] && isset($settings['map_height']['unit']) && $settings['map_height']['unit'])
        {
            $map_height = $settings['map_height']['size'].$settings['map_height']['unit'];
        }

        // Map
        $map = $listing->get_map([
            'provider' => $settings['provider'] ?? \LSD_Map_Provider::def(),
            'style' => isset($settings['style']) && trim($settings['style']) ? $settings['style'] : null,
            'gplaces' => $settings['gplaces'] ?? 0,
            'infowindow' => $settings['infowindow'] ?? 1,
            'zoomlevel' => $settings['zoomlevel'] ?? 14,
            'map_height' => $map_height,
            'mapcontrols' => $mapcontrols,
        ]);

        // No Data
        if (!trim($map)) return '';

        // Include Map Assets to the page
        \LSD_Assets::map();

        return '<div class="lsdaddelm-card-map">' . $map . '</div>';
    }

    protected function get_map_control_options(): array
    {
        $base = new \LSD_Base();
        $positions = $base->get_map_control_positions();

        return array_merge(
            ['0' => esc_html__('Disabled', 'listdom-elementor')],
            $positions
        );
    }
}
