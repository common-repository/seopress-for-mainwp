<?php
/**
 * Import Class
 *
 * @package SEOPress\MainWP
 */

namespace SEOPress\MainWP\AJAX;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Import
 */
class Import {
	use \SEOPress\MainWP\Traits\Singleton;

	/**
	 * Initialize class
	 *
	 * @return  void
	 */
	private function initialize() {
		add_action( 'wp_ajax_mainwp_seopress_import_settings', array( $this, 'import_settings' ) );
	}

	/**
	 * AJAX - Import settings from selected site
	 *
	 * Action: mainwp_seopress_import_settings
	 *
	 * @return void
	 */
	public function import_settings() {
		$nonce_check = check_ajax_referer( 'mainwp-seopress-import-settings-form', '__nonce', false );

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
				__( 'Please select a site on which to import the settings', 'wp-seopress-mainwp' ),
				400
			);
		}

		if ( empty( $_POST['mainwp_seopress_settings'] ) ) {
			wp_send_json_error(
				__( 'Please add settings', 'wp-seopress-mainwp' ),
				400
			);
		}

		$selected_sites = $this->sanitize_options( $_POST['selected_sites'] );
		$settings       = $this->sanitize_options( stripslashes( $_POST['mainwp_seopress_settings'] ) );

		json_decode( $settings );

		if ( json_last_error() !== JSON_ERROR_NONE ) {
			wp_send_json_error(
				__( 'Invalid json. Plase check the settings you added for any json validation error.', 'wp-seopress-mainwp' ),
				400
			);
		}

		$post_data = array(
			'action'   => 'import_settings',
			'settings' => $settings,
		);

		global $seopress_main_wp_extension;

		$errs = array();

		foreach ( $selected_sites as $selected_site ) {
			$information = apply_filters( 'mainwp_fetchurlauthed', $seopress_main_wp_extension->get_child_file(), $seopress_main_wp_extension->get_child_key(), $selected_site, 'wp_seopress', $post_data );

			if ( ! empty( $information['error'] ) ) {
				// translators: %d - Site id.
				$errs[] = sprintf( __( 'Site ID %d: ', 'wp-seopress-mainwp' ), $selected_site ) . $information['error'];
			}
		}

		if ( ! empty( $errs ) ) {
			wp_send_json_error(
				implode( '<br>', $errs ),
				400
			);
		}

		if ( function_exists( 'seopress_do_import_settings' ) ) {
			$settings = json_decode( $settings, true );

			seopress_do_import_settings( $settings );

			global $wpdb;

			$wpdb->query( "DELETE FROM {$wpdb->options} WHERE option_name LIKE 'seopress_mainwp_external_%'" );
		}

		wp_send_json_success(
			array(
				'message' => __( 'Import successfull. Page will reload to load latest settings...', 'wp-seopress-mainwp' ),
			)
		);
	}

	/**
	 * Sanitize options
	 *
	 * @param  array $option The option to be sanitized.
	 *
	 * @return array
	 */
	private function sanitize_options( $option ) {
		if ( is_array( $option ) ) {
			foreach ( $option as $field => $value ) {
				if ( is_numeric( $value ) ) {
					$option[ $field ] = (int) $value;
				} else {
					if ( is_array( $value ) ) {
						$option[ $field ] = $this->sanitize_options( $value );
					} else {
						if ( 'seopress_robots_file' === $field || 'seopress_instant_indexing_google_api_key' === $field ) {
							$option[ $field ] = sanitize_textarea_field( wp_unslash( $value ) );
						} else {
							$option[ $field ] = sanitize_text_field( wp_unslash( $value ) );
						}
					}
				}
			}
		}

		return $option;
	}
}
