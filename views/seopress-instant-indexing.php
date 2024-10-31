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

$titles_label = ! empty( $seopress_toggle_options['toggle-instant-indexing'] ) ? $feature_enabled_label : $feature_disabled_label;
$instant_indexing_check = ! empty( $seopress_toggle_options['toggle-instant-indexing'] ) ? 1 : 0;

?>

<div class="ui segment">
	<div class="ui message" id="mainwp-seopress-message-box" style="display: none;"></div>
	<div class="ui two column stackable left aligned grid">
		<div class="column">
			<h2 class="header"><?php esc_html_e( 'Instant Indexing', 'wp-seopress-mainwp' ); ?></h2>
		</div>
		<div class="column right aligned">
			<div class="inline field">
				<div class="ui toggle checkbox checked">
					<input type="checkbox" tabindex="0" data-nonce="<?php echo esc_attr( wp_create_nonce( 'mainwp-seopress-titles-meta-toggle' ) ); ?>" data-enabled-label="<?php echo esc_attr( $feature_enabled_label ); ?>" data-disabled-label="<?php echo esc_attr( $feature_disabled_label ); ?>" value="toggle-instant-indexing" class="hidden mainwp-seopress-toggle-feature" <?php checked( $instant_indexing_check, 1 ); ?>>
					<label><?php echo esc_html( $titles_label ); ?></label>
				</div>
			</div>
		</div>
	</div>
	<div class="ui two column stackable left aligned grid">
		<div class="three wide column mainwp-seopress-titles-menu">
			<div class="ui secondary vertical pointing menu">
				<a class="item active" href="#mainwp-seopress-instant-indexing-general">
					<?php esc_html_e( 'General', 'wp-seopress-mainwp' ); ?>
				</a>
				<a class="item" href="#mainwp-seopress-instant-indexing-settings">
					<?php esc_html_e( 'Settings', 'wp-seopress-mainwp' ); ?>
				</a>
			</div>
		</div>
		<div class="thirteen wide column mainwp-seopress-instant-indexing-content" id="mainwp-seopress-titles-tabs-content">
			<form method="post" id="mainwp-seopress-instant-indexing-general-form" class="mainwp-seopress-settings-form">
				<div class="ui segment mainwp-seopress-tab-content" id="mainwp-seopress-instant-indexing-general">
					<?php do_settings_sections( 'seopress-settings-admin-instant-indexing' ); ?>
				</div>
				<div class="ui segment hidden mainwp-seopress-tab-content" id="mainwp-seopress-instant-indexing-settings">
					<?php do_settings_sections( 'seopress-settings-admin-instant-indexing-settings' ); ?>
				</div>
				<input type="hidden" name="action" value="mainwp_seopress_save_instant_indexing_settings">
				<input type="hidden" name="__nonce" value="<?php echo esc_attr( wp_create_nonce( 'mainwp-seopress-save-instant-indexing-settings-form' ) ); ?>">
			</form>
		</div>
	</div>
</div>
