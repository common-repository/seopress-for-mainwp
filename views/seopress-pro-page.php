<?php
/**
 * SEOPress Pro Page
 *
 * @package SEOPress\MainWP
 */
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$woocommerce_check = ! empty( $seopress_toggle_options['toggle-woocommerce'] ) ? 1 : 0;
$edd_check = ! empty( $seopress_toggle_options['toggle-edd'] ) ? 1 : 0;
$inspect_url_check = ! empty( $seopress_toggle_options['toggle-inspect-url'] ) ? 1 : 0;
$local_business_check = ! empty( $seopress_toggle_options['toggle-local-business'] ) ? 1 : 0;
$dublin_core_check = ! empty( $seopress_toggle_options['toggle-dublin-core'] ) ? 1 : 0;
$rich_snippets_check = ! empty( $seopress_toggle_options['toggle-rich-snippets'] ) ? 1 : 0;
$breadcrumbs_check = ! empty( $seopress_toggle_options['toggle-breadcrumbs'] ) ? 1 : 0;
$robots_check = ! empty( $seopress_toggle_options['toggle-robots'] ) ? 1 : 0;
$news_check = ! empty( $seopress_toggle_options['toggle-news'] ) ? 1 : 0;
$redirects_check = ! empty( $seopress_toggle_options['toggle-404'] ) ? 1 : 0;
$rewrite_check = ! empty( $seopress_toggle_options['toggle-rewrite'] ) ? 1 : 0;
?>

<div class="ui segment">
	<div class="ui message" id="mainwp-seopress-message-box" style="display: none;"></div>
	<div class="ui two column stackable left aligned grid">
		<div class="column">
			<h2 class="header"><?php esc_html_e( 'PRO', 'wp-seopress-mainwp' ); ?></h2>
		</div>
	</div>
	<div class="ui two column stackable left aligned grid">
		<div class="three wide column mainwp-seopress-titles-menu">
			<div class="ui secondary vertical pointing menu">
				<a class="item" href="#mainwp-seopress-pro-redirections-404">
					<?php esc_html_e( 'Redirections / 404', 'wp-seopress-mainwp' ); ?>
				</a>
				<a class="item" href="#mainwp-seopress-pro-structured-data-types">
					<?php esc_html_e( 'Structured Data Types', 'wp-seopress-mainwp' ); ?>
				</a>
				<a class="item" href="#mainwp-seopress-pro-robots-txt">
					<?php esc_html_e( 'robots.txt', 'wp-seopress-mainwp' ); ?>
				</a>
				<a class="item active" href="#mainwp-seopress-pro-local-business">
					<?php esc_html_e( 'Local Business', 'wp-seopress-mainwp' ); ?>
				</a>
				<a class="item active" href="#mainwp-seopress-pro-ai">
					<?php esc_html_e( 'AI', 'wp-seopress-mainwp' ); ?>
				</a>
				<a class="item" href="#mainwp-seopress-pro-breadcrumbs">
					<?php esc_html_e( 'Breadcrumbs', 'wp-seopress-mainwp' ); ?>
				</a>
				<a class="item" href="#mainwp-seopress-pro-woocommerce">
					<?php esc_html_e( 'WooCommerce', 'wp-seopress-mainwp' ); ?>
				</a>
				<a class="item" href="#mainwp-seopress-pro-easy-digital-downloads">
					<?php esc_html_e( 'Easy Digital Downloads', 'wp-seopress-mainwp' ); ?>
				</a>
				<a class="item" href="#mainwp-seopress-pro-google-inspect-url">
					<?php esc_html_e( 'Google Search Console', 'wp-seopress-mainwp' ); ?>
				</a>
				<a class="item" href="#mainwp-seopress-pro-google-news">
					<?php esc_html_e( 'Google News', 'wp-seopress-mainwp' ); ?>
				</a>
				<a class="item" href="#mainwp-seopress-pro-dublin-core">
					<?php esc_html_e( 'Dublin Core', 'wp-seopress-mainwp' ); ?>
				</a>
				<a class="item" href="#mainwp-seopress-pro-url-rewriting">
					<?php esc_html_e( 'URL Rewriting', 'wp-seopress-mainwp' ); ?>
				</a>
				<a class="item" href="#mainwp-seopress-pro-rss">
					<?php esc_html_e( 'RSS', 'wp-seopress-mainwp' ); ?>
				</a>
				<a class="item" href="#mainwp-seopress-pro-white-label">
					<?php esc_html_e( 'White Label', 'wp-seopress-mainwp' ); ?>
				</a>
			</div>
		</div>
		<div class="thirteen wide column mainwp-seopress-pro-content" id="mainwp-seopress-titles-tabs-content">
			<form method="post" id="mainwp-seopress-pro-local-business-form" class="mainwp-seopress-settings-form">
				<div class="ui segment mainwp-seopress-tab-content" id="mainwp-seopress-pro-local-business">
					<?php do_settings_sections( 'seopress-settings-admin-local-business' ); ?>
				</div>
				<div class="ui segment hidden mainwp-seopress-tab-content" id="mainwp-seopress-pro-dublin-core">
					<?php do_settings_sections( 'seopress-settings-admin-dublin-core' ); ?>
				</div>
				<div class="ui segment hidden mainwp-seopress-tab-content" id="mainwp-seopress-pro-structured-data-types">
					<?php do_settings_sections( 'seopress-settings-admin-rich-snippets' ); ?>
				</div>
				<div class="ui segment hidden mainwp-seopress-tab-content" id="mainwp-seopress-pro-breadcrumbs">
					<?php do_settings_sections( 'seopress-settings-admin-breadcrumbs' ); ?>
				</div>
				<div class="ui segment hidden mainwp-seopress-tab-content" id="mainwp-seopress-pro-woocommerce">
					<?php do_settings_sections( 'seopress-settings-admin-woocommerce' ); ?>
				</div>
				<div class="ui segment hidden mainwp-seopress-tab-content" id="mainwp-seopress-pro-easy-digital-downloads">
					<?php do_settings_sections( 'seopress-settings-admin-edd' ); ?>
				</div>
				<div class="ui segment hidden mainwp-seopress-tab-content" id="mainwp-seopress-pro-google-inspect-url">
					<?php do_settings_sections( 'seopress-settings-admin-inspect-url' ); ?>
				</div>
				<div class="ui segment hidden mainwp-seopress-tab-content" id="mainwp-seopress-pro-robots-txt">
					<?php do_settings_sections( 'seopress-settings-admin-robots' ); ?>
				</div>
				<div class="ui segment hidden mainwp-seopress-tab-content" id="mainwp-seopress-pro-google-news">
					<?php do_settings_sections( 'seopress-settings-admin-news' ); ?>
				</div>
				<div class="ui segment hidden mainwp-seopress-tab-content" id="mainwp-seopress-pro-redirections-404">
					<?php do_settings_sections( 'seopress-settings-admin-monitor-404' ); ?>
				</div>
				<div class="ui segment hidden mainwp-seopress-tab-content" id="mainwp-seopress-pro-rss">
					<?php do_settings_sections( 'seopress-settings-admin-rss' ); ?>
				</div>
				<div class="ui segment hidden mainwp-seopress-tab-content" id="mainwp-seopress-pro-url-rewriting">
					<?php do_settings_sections( 'seopress-settings-admin-rewrite' ); ?>
				</div>
				<div class="ui segment hidden mainwp-seopress-tab-content" id="mainwp-seopress-pro-white-label">
					<?php do_settings_sections( 'seopress-settings-admin-white-label' ); ?>
				</div>
				<div class="ui segment hidden mainwp-seopress-tab-content" id="mainwp-seopress-pro-ai">
					<?php do_settings_sections( 'seopress-settings-admin-ai' ); ?>
				</div>
				<input type="hidden" name="action" value="mainwp_seopress_save_pro_settings">
				<input type="hidden" name="__nonce" value="<?php echo esc_attr( wp_create_nonce( 'mainwp-seopress-save-pro-settings-form' ) ); ?>">
			</form>
		</div>
	</div>
</div>
