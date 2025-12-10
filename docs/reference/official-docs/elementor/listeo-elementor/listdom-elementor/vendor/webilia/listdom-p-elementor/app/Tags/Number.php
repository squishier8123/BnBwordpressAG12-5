<?php
namespace LSDPACELM\Tags;

use Elementor\Modules\DynamicTags\Module;
use Elementor\Core\DynamicTags\Tag;
use Elementor\Controls_Manager;

class Number extends Tag
{
    public function get_name(): string
    {
        return 'lsd-listing-number';
    }

    public function get_title(): string
    {
        return esc_html__('Listing Numeric Fields', 'listdom-elementor');
    }

    public function get_group(): array
    {
        return ['lsd_listings'];
    }

    public function get_categories(): array
    {
        return [Module::NUMBER_CATEGORY];
    }

    protected function register_controls()
    {
        $this->add_control(
            'lsd_meta',
            [
                'type' => Controls_Manager::SELECT,
                'label' => esc_html__('Field', 'textdomain'),
                'options' => \LSD_Meta::pairs([
                    \LSD_Meta::NUMBER
                ]),
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
