<?php
/**
 * Export Class
 *
 * @package SEOPress\MainWP
 */

namespace SEOPress\MainWP\AJAX;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Export
 */
class Export {
	use \SEOPress\MainWP\Traits\Singleton;

	/**
	 * Initialize class
	 *
	 * @return  void
	 */
	private function initialize() {
		add_action( 'wp_ajax_mainwp_seopress_export_settings', array( $this, 'export_settings' ) );
	}

	/**
	 * AJAX - Export settings from selected site
	 *
	 * Action: mainwp_seopress_export_settings
	 *
	 * @return void
	 */
	public function export_settings() {
		$nonce_check = check_ajax_referer( 'mainwp-seopress-export-settings-form', '__nonce', false );

		if ( ! $nonce_check ) {
			wp_send_json_error(
				__( 'Invalid nonce', 'wp-seopress-mainwp' ),
				403
			);
		} elseif ( $nonce_check > 1 ) {
			wp_send_json_error(
				__( 'Invalid form. Please refresh the page and try again.', 'wp-seopress-mainwp' ),
				403
			);
		}

		if ( empty( $_POST['selected_sites'] ) ) {
			wp_send_json_error(
				__( 'Please select a site from which to export the settings', 'wp-seopress-mainwp' ),
				400
			);
		}

		$selected_site = absint( sanitize_text_field( $_POST['selected_sites'][0] ) );

		$post_data = array(
			'action' => 'export_settings',
		);

		global $seopress_main_wp_extension;

		$information = apply_filters( 'mainwp_fetchurlauthed', $seopress_main_wp_extension->get_child_file(), $seopress_main_wp_extension->get_child_key(), $selected_site, 'wp_seopress', $post_data );

		if ( ! empty( $information['error'] ) ) {
			wp_send_json_error(
				$information['error'],
				400
			);
		}

		wp_send_json_success( $information );
	}
}
