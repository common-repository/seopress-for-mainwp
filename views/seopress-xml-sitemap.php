<?php
/**
 * SEOPress XML - HTML Sitemap
 *
 * @package SEOPress\MainWP
 */
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$feature_disabled_label = __( 'Click to enable this feature', 'wp-seopress-mainwp' );
$feature_enabled_label  = __( 'Click to disable this feature', 'wp-seopress-mainwp' );

$titles_label = ! empty( $seopress_toggle_options['toggle-xml-sitemap'] ) ? $feature_enabled_label : $feature_disabled_label;
$sitemap_check = ! empty( $seopress_toggle_options['toggle-xml-sitemap'] ) ? 1 : 0;

?>

<div class="ui segment">
	<div class="ui message" id="mainwp-seopress-message-box" style="display: none;"></div>
		<div class="ui two column stackable left aligned grid">
			<div class="column">
				<h2 class="header"><?php esc_html_e( 'XML - HTML Sitemap', 'wp-seopress-mainwp' ); ?></h2>
			</div>
			<div class="column right aligned">
				<div class="inline field">
					<div class="ui toggle checkbox checked">
						<input type="checkbox" tabindex="0" data-nonce="<?php echo esc_attr( wp_create_nonce( 'mainwp-seopress-titles-meta-toggle' ) ); ?>" data-enabled-label="<?php echo esc_attr( $feature_enabled_label ); ?>" data-disabled-label="<?php echo esc_attr( $feature_disabled_label ); ?>" value="toggle-xml-sitemap" class="hidden mainwp-seopress-toggle-feature" <?php checked( $sitemap_check, 1 ); ?>>
						<label><?php echo esc_html( $titles_label ); ?></label>
					</div>
				</div>
			</div>
		</div>
		<div class="ui two column stackable left aligned grid">
			<div class="three wide column mainwp-seopress-titles-menu">
				<div class="ui secondary vertical pointing menu">
					<a class="item active" href="#mainwp-seopress-xml-html-sitemap-general">
						<?php esc_html_e( 'General', 'wp-seopress-mainwp' ); ?>
					</a>
					<a class="item" href="#mainwp-seopress-xml-html-sitemap-post-types">
						<?php esc_html_e( 'Post Types', 'wp-seopress-mainwp' ); ?>
					</a>
					<a class="item" href="#mainwp-seopress-xml-html-sitemap-taxonomies">
						<?php esc_html_e( 'Taxonomies', 'wp-seopress-mainwp' ); ?>
					</a>
					<a class="item" href="#mainwp-seopress-xml-html-sitemap-html-sitemap">
						<?php esc_html_e( 'HTML Sitemap', 'wp-seopress-mainwp' ); ?>
					</a>
				</div>
			</div>
			<div class="thirteen wide column" id="mainwp-seopressxml-html-sitemap-tabs-content">
				<form method="post" id="mainwp-seopress-xml-html-sitemap-general-form" class="mainwp-seopress-settings-form">
					<div class="ui segment mainwp-seopress-tab-content" id="mainwp-seopress-xml-html-sitemap-general">
						<?php do_settings_sections( 'seopress-settings-admin-xml-sitemap-general' ); ?>
					</div>
					<div class="ui segment hidden mainwp-seopress-tab-content hidden" id="mainwp-seopress-xml-html-sitemap-post-types">
						<?php do_settings_sections( 'seopress-settings-admin-xml-sitemap-post-types' ); ?>
					</div>
					<div class="ui segment hidden mainwp-seopress-tab-content hidden" id="mainwp-seopress-xml-html-sitemap-taxonomies">
						<?php do_settings_sections( 'seopress-settings-admin-xml-sitemap-taxonomies' ); ?>
					</div>
					<div class="ui segment hidden mainwp-seopress-tab-content hidden" id="mainwp-seopress-xml-html-sitemap-html-sitemap">
						<?php do_settings_sections( 'seopress-settings-admin-html-sitemap' ); ?>
					</div>
					<input type="hidden" name="action" value="mainwp_seopress_save_xml_html_sitemap_settings">
					<input type="hidden" name="__nonce" value="<?php echo esc_attr( wp_create_nonce( 'mainwp-seopress-save-xml-html-sitemap-settings-form' ) ); ?>">
				</form>
			</div>
		</div>
	</div>
</div>
