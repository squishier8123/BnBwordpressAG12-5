<?php
namespace LSDPACELM\Tags;

use Elementor\Modules\DynamicTags\Module;
use Elementor\Core\DynamicTags\Tag;
use Elementor\Controls_Manager;

class URL extends Tag
{
    public function get_name(): string
    {
        return 'lsd-listing-url';
    }

    public function get_title(): string
    {
        return esc_html__('Listing URL Fields', 'listdom-elementor');
    }

    public function get_group(): array
    {
        return ['lsd_listings'];
    }

    public function get_categories(): array
    {
        return [Module::URL_CATEGORY];
    }

    protected function register_controls()
    {
        $this->add_control(
            'lsd_meta',
            [
                'type' => Controls_Manager::SELECT,
                'label' => esc_html__('Field', 'textdomain'),
                'options' => \LSD_Meta::pairs([
                    \LSD_Meta::URL,
                    \LSD_Meta::TEL,
                    \LSD_Meta::EMAIL,
                ]),
            ]
        );
    }

    public function render()
    {
        $key = $this->get_settings('lsd_meta');
        if (!$key) return;

        // Meta Field
        $meta = \LSD_Meta::get($key);

        // Meta Type
        $type = $meta['type'] ?? \LSD_Meta::URL;

        // Value
        $value = \LSD_Meta::value($key, get_the_ID());

        if ($type === \LSD_Meta::TEL) echo 'tel:'.$value;
        else if ($type === \LSD_Meta::EMAIL) echo 'mailto:'.$value;
        else echo $value;
    }
}
