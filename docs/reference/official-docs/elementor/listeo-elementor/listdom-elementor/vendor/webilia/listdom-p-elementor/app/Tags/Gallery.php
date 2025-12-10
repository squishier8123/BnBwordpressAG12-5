<?php
namespace LSDPACELM\Tags;

use Elementor\Modules\DynamicTags\Module;
use Elementor\Controls_Manager;
use Elementor\Core\DynamicTags\Data_Tag;

class Gallery extends Data_Tag
{
    public function get_name(): string
    {
        return 'lsd-listing-gallery';
    }

    public function get_title(): string
    {
        return esc_html__('Listing Gallery Fields', 'listdom-elementor');
    }

    public function get_group(): array
    {
        return ['lsd_listings'];
    }

    public function get_categories(): array
    {
        return [Module::GALLERY_CATEGORY];
    }

    protected function register_controls()
    {
        $this->add_control(
            'lsd_meta',
            [
                'type' => Controls_Manager::SELECT,
                'label' => esc_html__('Field', 'textdomain'),
                'options' => \LSD_Meta::pairs([
                    \LSD_Meta::GALLERY
                ]),
            ]
        );
    }

    protected function get_value(array $options = []): array
    {
        $data = [];

        $key = $this->get_settings('lsd_meta');
        if (!$key) return $data;

        $gallery = \LSD_Meta::value($key, get_the_ID());
        if (is_array($gallery) && count($gallery))
        {
            foreach ($gallery as $image)
            {
                $data[] = [
                    'id' => (int) $image
                ];
            }
        }

        return $data;
    }
}
