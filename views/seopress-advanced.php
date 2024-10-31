<?php
/**
 * SEOPress Titles & Metas
 *
 * @package SEOPress\MainWP
 */
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$feature_disabled_label = __( 'Click to enable this feature', 'wp-seopress-mainwp' );
$feature_enabled_label  = __( 'Click to disable this feature', 'wp-seopress-mainwp' );

$titles_label = ! empty( $seopress_toggle_options['toggle-advanced'] ) ? $feature_enabled_label : $feature_disabled_label;
$advanced_check = ! empty( $seopress_toggle_options['toggle-advanced'] ) ? 1 : 0;

?>

<div class="ui segment">
	<div class="ui message" id="mainwp-seopress-message-box" style="display: none;"></div>
	<div class="ui two column stackable left aligned grid">
		<div class="column">
			<h2 class="header"><?php esc_html_e( 'Advanced', 'wp-seopress-mainwp' ); ?></h2>
		</div>
		<div class="column right aligned">
			<div class="inline field">
				<div class="ui toggle checkbox checked">
					<input type="checkbox" tabindex="0" data-nonce="<?php echo esc_attr( wp_create_nonce( 'mainwp-seopress-titles-meta-toggle' ) ); ?>" data-enabled-label="<?php echo esc_attr( $feature_enabled_label ); ?>" data-disabled-label="<?php echo esc_attr( $feature_disabled_label ); ?>" value="toggle-advanced" class="hidden mainwp-seopress-toggle-feature" <?php checked( $advanced_check, 1 ); ?>>
					<label><?php echo esc_html( $titles_label ); ?></label>
				</div>
			</div>
		</div>
	</div>
	<div class="ui two column stackable left aligned grid">
		<div class="three wide column mainwp-seopress-titles-menu">
			<div class="ui secondary vertical pointing menu">
				<a class="item active" href="#mainwp-seopress-advanced-image-seo">
					<?php esc_html_e( 'Image SEO', 'wp-seopress-mainwp' ); ?>
				</a>
				<a class="item" href="#mainwp-seopress-advanced-advanced">
					<?php esc_html_e( 'Advanced', 'wp-seopress-mainwp' ); ?>
				</a>
				<a class="item" href="#mainwp-seopress-advanced-appearance">
					<?php esc_html_e( 'Appearance', 'wp-seopress-mainwp' ); ?>
				</a>
				<a class="item" href="#mainwp-seopress-advanced-security">
					<?php esc_html_e( 'Security', 'wp-seopress-mainwp' ); ?>
				</a>
			</div>
		</div>
		<div class="thirteen wide column mainwp-seopress-advanced-content" id="mainwp-seopress-titles-tabs-content">
			<form method="post" id="mainwp-seopress-advanced-image-seo-form" class="mainwp-seopress-settings-form">
				<div class="ui segment mainwp-seopress-tab-content" id="mainwp-seopress-advanced-image-seo">
					<?php do_settings_sections( 'seopress-settings-admin-advanced-image' ); ?>
				</div>
				<div class="ui segment hidden mainwp-seopress-tab-content" id="mainwp-seopress-advanced-advanced">
					<?php do_settings_sections( 'seopress-settings-admin-advanced-advanced' ); ?>
				</div>
				<div class="ui segment hidden mainwp-seopress-tab-content" id="mainwp-seopress-advanced-appearance">
					<?php do_settings_sections( 'seopress-settings-admin-advanced-appearance' ); ?>
				</div>
				<div class="ui segment hidden mainwp-seopress-tab-content" id="mainwp-seopress-advanced-security">
					<?php do_settings_sections( 'seopress-settings-admin-advanced-security' ); ?>
				</div>
				<input type="hidden" name="action" value="mainwp_seopress_save_advanced_settings">
				<input type="hidden" name="__nonce" value="<?php echo esc_attr( wp_create_nonce( 'mainwp-seopress-save-advanced-settings-form' ) ); ?>">
			</form>
		</div>
	</div>
</div>
