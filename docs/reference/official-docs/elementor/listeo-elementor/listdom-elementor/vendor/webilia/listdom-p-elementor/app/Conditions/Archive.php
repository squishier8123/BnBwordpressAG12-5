<?php
namespace LSDPACELM\Conditions;

use ElementorPro\Modules\ThemeBuilder\Conditions\Any_Child_Of_Term;
use ElementorPro\Modules\ThemeBuilder\Conditions\Child_Of_Term;
use ElementorPro\Modules\ThemeBuilder\Conditions\Condition_Base;
use ElementorPro\Modules\ThemeBuilder\Conditions\Taxonomy;

class Archive extends Condition_Base
{
    public static function get_type(): string
    {
        return 'archive';
    }

    public function get_label(): string
    {
        return esc_html__('Listings Archive', 'listdom-elementor');
    }

    public function get_name(): string
    {
        return 'lsdaddelm_archive';
    }

    public function get_all_label(): string
    {
        return esc_html__('Any Archive', 'listdom-elementor');
    }

    public function register_sub_conditions()
    {
        foreach (\LSD_Base::taxonomies() as $taxonomy)
        {
            // Taxonomy Object
            $TAX = get_taxonomy($taxonomy);

            // Taxonomy Condition
            $this->register_sub_condition(new Taxonomy([
                'object' => $TAX,
            ]));

            // Hierarchical Taxonomy
            if ($TAX->hierarchical)
            {
                // Direct Child Condition
                $this->register_sub_condition(new Child_Of_Term([
                    'object' => $TAX,
                ]));

                // Any Child Condition
                $this->register_sub_condition(new Any_Child_Of_Term([
                    'object' => $TAX,
                ]));
            }
        }
    }

    public function check($args): bool
    {
        return is_tax(\LSD_Base::taxonomies());
    }
}
