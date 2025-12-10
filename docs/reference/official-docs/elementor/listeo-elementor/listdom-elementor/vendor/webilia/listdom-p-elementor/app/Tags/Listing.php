<?php
namespace LSDPACELM\Tags;

use Elementor\Modules\DynamicTags\Module;
use Elementor\Controls_Manager;
use Elementor\Core\DynamicTags\Tag;

class Listing extends Tag
{
    public function get_name(): string
    {
        return 'lsd-listing';
    }

    public function get_title(): string
    {
        return esc_html__('Listing Fields', 'listdom-elementor');
    }

    public function get_group(): array
    {
        return ['lsd_listings'];
    }

    public function get_categories(): array
    {
        return [Module::TEXT_CATEGORY, Module::POST_META_CATEGORY];
    }

    protected function register_controls()
    {
        $this->add_control(
            'lsd_meta',
            [
                'type' => Controls_Manager::SELECT,
                'label' => esc_html__('Field', 'textdomain'),
                'options' => \LSD_Meta::pairs(),
            ]
        );
    }

    public function render()
    {
        $key = $this->get_settings('lsd_meta');
        if (!$key) return;

        echo \LSD_Meta::value($key, get_the_ID());
    }
}
