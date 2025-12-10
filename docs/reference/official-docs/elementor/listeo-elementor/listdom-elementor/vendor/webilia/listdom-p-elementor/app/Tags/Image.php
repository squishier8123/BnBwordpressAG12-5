<?php
namespace LSDPACELM\Tags;

use Elementor\Modules\DynamicTags\Module;
use Elementor\Controls_Manager;
use Elementor\Core\DynamicTags\Data_Tag;

class Image extends Data_Tag
{
    public function get_name(): string
    {
        return 'lsd-listing-image';
    }

    public function get_title(): string
    {
        return esc_html__('Listing Image Fields', 'listdom-elementor');
    }

    public function get_group(): array
    {
        return ['lsd_listings'];
    }

    public function get_categories(): array
    {
        return [Module::IMAGE_CATEGORY];
    }

    protected function register_controls()
    {
        $this->add_control(
            'lsd_meta',
            [
                'type' => Controls_Manager::SELECT,
                'label' => esc_html__('Field', 'textdomain'),
                'options' => \LSD_Meta::pairs([
                    \LSD_Meta::IMAGE
                ]),
            ]
        );
    }

    protected function get_value(array $options = []): array
    {
        $data = [
            'id' => null,
            'url' => '',
        ];

        $key = $this->get_settings('lsd_meta');
        if (!$key) return $data;

        $id = \LSD_Meta::value($key, get_the_ID());
        if ($id)
        {
            $data['id'] = $id;
            $data['url'] = wp_get_attachment_url($id);
        }

        return $data;
    }
}
