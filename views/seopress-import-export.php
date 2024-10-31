<?php
/**
 * SEOPress Settings
 *
 * @package SEOPress\MainWP
 */

$selected_websites = array();
$selected_groups   = array();
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div class="mainwp-seopress-settings" style="padding: 10px;">
	<div class="ui segment">
		<div class="ui two column stackable left aligned grid">
			<div class="column">
				<h2 class="header"><?php esc_html_e( 'Tools', 'wp-seopress-mainwp' ); ?></h2>
			</div>
		</div>
	</div>
	<div class="ui segment mainwp-widget">
		<h3 class="ui header"><?php esc_html_e( 'Export / Import Settings', 'wp-seopress-mainwp' ); ?></h3>
		<div class="ui message" id="mainwp-seopress-message-box" style="display: none;"></div>
		<div class="ui stackable grid">
			<div class="eight wide column">
				<a href="#" class="ui button basic green mainwp-seoress-toggle-export-import-form" id="mainwp-seopress-show-export-form" data-inverted=""><?php esc_html_e( 'Export', 'wp-seopress-mainwp' ); ?></a>
				<a href="#" class="ui button basic green mainwp-seoress-toggle-export-import-form" id="mainwp-seopress-show-import-form" data-inverted=""><?php esc_html_e( 'Import', 'wp-seopress-mainwp' ); ?></a>
			</div>
			<div class="eight wide column">
			</div>
		</div>
		<div class="ui middle aligned divided selection list" id="mainwp-seopress-show-export-form-area" style="display:none;">
			<div class="ui section hidden divider"></div>
			<div style="display: flex; justify-content:space-between;">
				<form method="post" id="mainwp-seopress-export-settings-form" style="width: 100%;">
					<div class="mainwp-select-sites">
						<div class="ui header"><?php esc_html_e( 'Select Sites', 'wp-seopress-mainwp' ); ?></div>
						<?php do_action( 'mainwp_select_sites_box', '', 'radio', true, false, '', '', $selected_websites, $selected_groups ); ?>
					</div>
					<div class="actions">
						<input type="hidden" name="action" value="mainwp_seopress_export_settings">
						<input type="hidden" name="__nonce" value="<?php echo esc_attr( wp_create_nonce( 'mainwp-seopress-export-settings-form' ) ); ?>">
						<button type="submit" name="mainwp_seopress_btn_export" id="mainwp-seopress-btn-export" class="ui green button"><?php esc_html_e( 'Export Settings', 'wp-seopress-mainwp' ); ?></button>
					</div>
				</form>
				<span>
					<textarea id="mainwp-seopress-exported-settings" cols="100" rows="50" readonly></textarea>
				</span>
			</div>
		</div>
		<div class="ui middle aligned divided selection list" id="mainwp-seopress-show-import-form-area" style="display:none;">
			<div class="ui section hidden divider"></div>
			<form method="post" id="mainwp-seopress-import-settings-form" style="width: 100%;">
				<div style="display: flex; justify-content:space-between;">
					<div style="width: 100%;">
						<div class="mainwp-select-sites">
							<div class="ui header"><?php esc_html_e( 'Select Sites', 'wp-seopress-mainwp' ); ?></div>
							<?php do_action( 'mainwp_select_sites_box', '', 'checkbox', true, true, '', '', $selected_websites, $selected_groups ); ?>
						</div>
						<div class="actions">
							<input type="hidden" name="action" value="mainwp_seopress_import_settings">
							<input type="hidden" name="__nonce" value="<?php echo esc_attr( wp_create_nonce( 'mainwp-seopress-import-settings-form' ) ); ?>">
							<button type="submit" name="mainwp_seopress_btn_import" id="mainwp-seopress-btn-import" class="ui green button"><?php esc_html_e( 'Import Settings', 'wp-seopress-mainwp' ); ?></button>
						</div>
					</div>
					<span>
						<textarea id="mainwp-seopress-imported-settings" name="mainwp_seopress_settings" cols="100" rows="50"></textarea>
					</span>
				</div>
			</form>
		</div>
	</div>
</div>
