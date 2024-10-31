<?php
/**
 * SEOPress Tabs Content
 *
 * @package SEOPress\MainWP
 */
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<?php if ( 'seopress-import-export' !== $this->current_tab ) : ?>
	<div class="mainwp-main-content">
		<?php require_once SEOPRESS_WPMAIN_PLUGIN_DIR . 'views/' . $this->current_tab . '.php'; ?>
	</div>
	<div class="mainwp-side-content mainwp-no-padding">
		<div class="mainwp-select-sites">
			<div class="ui header"><?php esc_html_e( 'Select Sites', 'wp-seopress-mainwp' ); ?></div>
			<?php do_action( 'mainwp_select_sites_box', '', 'checkbox', true, true, '', '', $selected_websites, $selected_groups ); ?>
			<button type="button" class="ui button green" id="mainwp-seopress-apply-changes-button"><?php esc_html_e( 'Apply Changes', 'wp-seopress-mainwp' ); ?></button>
			<button type="button" class="ui button basic green" id="mainwp-seopress-load-settings-button"><?php esc_html_e( 'Load Settings', 'wp-seopress-mainwp' ); ?></button>
		</div>
	</div>
<?php else : ?>
	<?php require_once SEOPRESS_WPMAIN_PLUGIN_DIR . 'views/' . $this->current_tab . '.php'; ?>
<?php endif; ?>
<div class="ui hidden clearing divider"></div>
