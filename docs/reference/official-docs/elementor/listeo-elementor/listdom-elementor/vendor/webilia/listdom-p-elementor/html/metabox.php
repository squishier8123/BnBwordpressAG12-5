<?php
// no direct access
defined('ABSPATH') || die();

/** @var WP_Post $post */

$type = \LSDPACELM\Base::get_layout_type($post->ID);
?>
<div class="lsd-metabox lsdaddelm-metabox">
    <div class="lsd-form-row">
        <div class="lsd-col-12">
            <?php /* Security Nonce */ LSD_Form::nonce('lsdaddelm_details_cpt', '_lsdnonce'); ?>
            <?php echo LSD_Form::select([
                'id' => 'lsdaddelm_type',
                'name' => 'lsd[type]',
                'options' => $this->get_layout_types(),
                'value' => $type,
                'class' => 'lsd-mt-3',
            ]); ?>
        </div>
    </div>
    <p class="description lsd-mt-3">
        <?php echo sprintf(
            esc_html__('If the layout is for search results or grid views, select %s. For single listing pages, choose %s. For map views, pick %s.', 'listdom-elementor'),
            '<strong>' . esc_html__('Listing Card', 'listdom-elementor') . '</strong>',
            '<strong>' . esc_html__('Single Listing', 'listdom-elementor') . '</strong>',
            '<strong>' . esc_html__('Infowindow', 'listdom-elementor') . '</strong>'
        ); ?>
    </p>

    <?php if (!class_exists(\LSDPACAM\Base::class)): ?>
        <p class="lsd-alert lsd-warning"><?php echo sprintf(esc_html__('The %s addon is required to design info-windows.', 'listdom-elementor'), '<strong>' . esc_html__('Listdom Advanced Map', 'listdom-elementor') . '</strong>'); ?></p>
    <?php endif; ?>
</div>
