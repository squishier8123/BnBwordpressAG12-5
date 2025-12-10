<?php
// no direct access
defined('ABSPATH') || die();
/** @var string $subtab */
?>
<div id="lsd_panel_addons_elementor" class="lsd-tab-content<?php echo $subtab === 'elementor' ? ' lsd-tab-content-active' : ''; ?>"<?php echo $subtab === 'elementor' ? '' : ' hidden'; ?>>
    <h3 class="lsd-mt-0 lsd-admin-title"><?php esc_html_e('Elementor', 'listdom-elementor'); ?></h3>
    <div class="lsd-settings-group-wrapper">
        <div class="lsd-settings-fields-wrapper">
            <p class="lsd-admin-description lsd-m-0"><?php echo sprintf(esc_html__('No options here. Design listing pages from the %s menu.', 'listdom-elementor'), '<strong>' . esc_html__('Elementor Styles', 'listdom-elementor') . '</strong>'); ?></p>
        </div>
    </div>
</div>
