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

$titles_label = ! empty( $seopress_toggle_options['toggle-titles'] ) ? $feature_enabled_label : $feature_disabled_label;
$titles_check = ! empty( $seopress_toggle_options['toggle-titles'] ) ? 1 : 0;

?>

<div class="ui segment">
	<div class="ui message" id="mainwp-seopress-message-box" style="display: none;"></div>
	<div class="ui two column stackable left aligned grid">
		<div class="column">
			<h2 class="header"><?php esc_html_e( 'Titles & Metas', 'wp-seopress-mainwp' ); ?></h2>
		</div>
		<div class="column right aligned">
			<div class="inline field">
				<div class="ui checkbox toggle">
					<input type="checkbox" tabindex="0" data-nonce="<?php echo esc_attr( wp_create_nonce( 'mainwp-seopress-titles-meta-toggle' ) ); ?>" data-enabled-label="<?php echo esc_attr( $feature_enabled_label ); ?>" data-disabled-label="<?php echo esc_attr( $feature_disabled_label ); ?>" value="toggle-titles" class="hidden mainwp-seopress-toggle-feature" <?php checked( $titles_check, 1 ); ?>>
					<label><?php echo esc_html( $titles_label ); ?></label>
				</div>
			</div>
		</div>
	</div>
	<div class="ui two column stackable left aligned grid">
		<div class="three wide column mainwp-seopress-titles-menu">
			<div class="ui secondary vertical pointing menu">
				<a class="item active" href="#mainwp-seopress-titles-home">
					<?php esc_html_e( 'Home', 'wp-seopress-mainwp' ); ?>
				</a>
				<a class="item" href="#mainwp-seopress-titles-post-types">
					<?php esc_html_e( 'Post Types', 'wp-seopress-mainwp' ); ?>
				</a>
				<a class="item" href="#mainwp-seopress-titles-archives">
					<?php esc_html_e( 'Archives', 'wp-seopress-mainwp' ); ?>
				</a>
				<a class="item" href="#mainwp-seopress-titles-taxonomies">
					<?php esc_html_e( 'Taxonomies', 'wp-seopress-mainwp' ); ?>
				</a>
				<a class="item" href="#mainwp-seopress-titles-advanced">
					<?php esc_html_e( 'Advanced', 'wp-seopress-mainwp' ); ?>
				</a>
			</div>
		</div>
		<div class="thirteen wide column" id="mainwp-seopress-titles-tabs-content">
			<form method="post" id="mainwp-seopress-titles-home-form" class="mainwp-seopress-settings-form">
				<div class="ui segment mainwp-seopress-tab-content" id="mainwp-seopress-titles-home">
					<?php do_settings_sections( 'seopress-settings-admin-titles-home' ); ?>
				</div>
				<div class="ui segment hidden mainwp-seopress-tab-content" id="mainwp-seopress-titles-post-types">
					<?php do_settings_sections( 'seopress-settings-admin-titles-single' ); ?>
				</div>
				<div class="ui segment hidden mainwp-seopress-tab-content" id="mainwp-seopress-titles-archives">
					<?php do_settings_sections( 'seopress-settings-admin-titles-archives' ); ?>
				</div>
				<div class="ui segment hidden mainwp-seopress-tab-content" id="mainwp-seopress-titles-taxonomies">
					<?php do_settings_sections( 'seopress-settings-admin-titles-tax' ); ?>
				</div>
				<div class="ui segment hidden mainwp-seopress-tab-content" id="mainwp-seopress-titles-advanced">
					<?php do_settings_sections( 'seopress-settings-admin-titles-advanced' ); ?>
				</div>
				<input type="hidden" name="action" value="mainwp_seopress_save_titles_metas_settings">
				<input type="hidden" name="__nonce" value="<?php echo esc_attr( wp_create_nonce( 'mainwp-seopress-save-titles-metas-settings-form' ) ); ?>">
			</form>
		</div>
	</div>
</div>
