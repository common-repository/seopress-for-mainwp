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

$titles_label = ! empty( $seopress_toggle_options['toggle-google-analytics'] ) ? $feature_enabled_label : $feature_disabled_label;
$google_analytics_check = ! empty( $seopress_toggle_options['toggle-google-analytics'] ) ? 1 : 0;

?>

<div class="ui segment">
	<div class="ui message" id="mainwp-seopress-message-box" style="display: none;"></div>
	<div class="ui two column stackable left aligned grid">
		<div class="column">
			<h2 class="header"><?php esc_html_e( 'Analytics', 'wp-seopress-mainwp' ); ?></h2>
		</div>
		<div class="column right aligned">
			<div class="inline field">
				<div class="ui toggle checkbox checked">
					<input type="checkbox" tabindex="0" data-nonce="<?php echo esc_attr( wp_create_nonce( 'mainwp-seopress-titles-meta-toggle' ) ); ?>" data-enabled-label="<?php echo esc_attr( $feature_enabled_label ); ?>" data-disabled-label="<?php echo esc_attr( $feature_disabled_label ); ?>" value="toggle-google-analytics" class="hidden mainwp-seopress-toggle-feature" <?php checked( $google_analytics_check, 1 ); ?>>
					<label><?php echo esc_html( $titles_label ); ?></label>
				</div>
			</div>
		</div>
	</div>
	<div class="ui two column stackable left aligned grid">
		<div class="three wide column mainwp-seopress-titles-menu">
			<div class="ui secondary vertical pointing menu">
				<a class="item active" href="#mainwp-seopress-analytics-general">
					<?php esc_html_e( 'Google Analytics', 'wp-seopress-mainwp' ); ?>
				</a>
				<a class="item" href="#mainwp-seopress-analytics-custom-tracking">
					<?php esc_html_e( 'Custom Tracking', 'wp-seopress-mainwp' ); ?>
				</a>
				<?php if ( $is_pro_version_active ) : ?>
				<a class="item" href="#mainwp-seopress-analytics-ecommerce">
					<?php esc_html_e( 'Ecommerce', 'wp-seopress-mainwp' ); ?>
				</a>
				<?php endif; ?>
				<a class="item" href="#mainwp-seopress-analytics-events">
					<?php esc_html_e( 'Events', 'wp-seopress-mainwp' ); ?>
				</a>
				<a class="item" href="#mainwp-seopress-analytics-custom-dimensions">
					<?php esc_html_e( 'Custom Dimensions', 'wp-seopress-mainwp' ); ?>
				</a>
				<?php if ( $is_pro_version_active ) : ?>
					<a class="item" href="#mainwp-seopress-analytics-stats-in-dashboard">
						<?php esc_html_e( 'Stats in Dashboard', 'wp-seopress-mainwp' ); ?>
					</a>
				<?php endif; ?>
				<a class="item" href="#mainwp-seopress-analytics-cookie-bar-gdpr">
					<?php esc_html_e( 'Cookie Bar / GDPR', 'wp-seopress-mainwp' ); ?>
				</a>
				<a class="item" href="#mainwp-seopress-analytics-matomo">
					<?php esc_html_e( 'Matomo', 'wp-seopress-mainwp' ); ?>
				</a>
				<a class="item" href="#mainwp-seopress-analytics-clarity">
					<?php esc_html_e( 'Clarity', 'wp-seopress-mainwp' ); ?>
				</a>
			</div>
		</div>
		<div class="thirteen wide column mainwp-seopress-analytics-content" id="mainwp-seopress-titles-tabs-content">
			<form method="post" id="mainwp-seopress-analytics-general-form" class="mainwp-seopress-settings-form">
				<div class="ui segment mainwp-seopress-tab-content" id="mainwp-seopress-analytics-general">
					<?php do_settings_sections( 'seopress-settings-admin-google-analytics-enable' ); ?>
				</div>
				<div class="ui segment hidden mainwp-seopress-tab-content" id="mainwp-seopress-analytics-custom-tracking">
					<?php do_settings_sections( 'seopress-settings-admin-google-analytics-custom-tracking' ); ?>
				</div>
				<?php if ( $is_pro_version_active ) : ?>
				<div class="ui segment hidden mainwp-seopress-tab-content" id="mainwp-seopress-analytics-ecommerce">
					<?php do_settings_sections( 'seopress-settings-admin-google-analytics-ecommerce' ); ?>
				</div>
				<?php endif; ?>
				<div class="ui segment hidden mainwp-seopress-tab-content" id="mainwp-seopress-analytics-events">
					<?php do_settings_sections( 'seopress-settings-admin-google-analytics-events' ); ?>
				</div>
				<div class="ui segment hidden mainwp-seopress-tab-content" id="mainwp-seopress-analytics-custom-dimensions">
					<?php do_settings_sections( 'seopress-settings-admin-google-analytics-custom-dimensions' ); ?>
				</div>
				<?php if ( $is_pro_version_active ) : ?>
				<div class="ui segment hidden mainwp-seopress-tab-content" id="mainwp-seopress-analytics-stats-in-dashboard">
					<?php do_settings_sections( 'seopress-settings-admin-google-analytics-dashboard' ); ?>
					<?php do_settings_sections( 'seopress-settings-admin-google-analytics-matomo-widget' ); ?>
				</div>
				<?php endif; ?>
				<div class="ui segment hidden mainwp-seopress-tab-content" id="mainwp-seopress-analytics-cookie-bar-gdpr">
					<?php do_settings_sections( 'seopress-settings-admin-google-analytics-gdpr' ); ?>
				</div>
				<div class="ui segment hidden mainwp-seopress-tab-content" id="mainwp-seopress-analytics-matomo">
					<?php do_settings_sections( 'seopress-settings-admin-google-analytics-matomo' ); ?>
				</div>
				<div class="ui segment hidden mainwp-seopress-tab-content" id="mainwp-seopress-analytics-clarity">
					<?php do_settings_sections( 'seopress-settings-admin-google-analytics-clarity' ); ?>
				</div>
				<input type="hidden" name="action" value="mainwp_seopress_save_analytics_settings">
				<input type="hidden" name="__nonce" value="<?php echo esc_attr( wp_create_nonce( 'mainwp-seopress-save-analytics-settings-form' ) ); ?>">
			</form>
		</div>
	</div>
</div>
