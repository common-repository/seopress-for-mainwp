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
class Load_Site_Settings {
	use \SEOPress\MainWP\Traits\Singleton;

	/**
	 * Initialize class
	 *
	 * @return  void
	 */
	private function initialize() {
		add_action( 'wp_ajax_mainwp_seopress_load_site_settings', array( $this, 'load_settings' ) );
	}

	/**
	 * AJAX - Load settings from selected site
	 *
	 * Action: mainwp_seopress_load_site_settings
	 *
	 * @return void
	 */
	public function load_settings() {
		$nonce_check = check_ajax_referer( 'mainwp-seopress-load-site-settings-nonce', '__nonce', false );

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

		if ( empty( $_POST['selected_site'] ) ) {
			wp_send_json_error(
				__( 'Please select a site from which to export the settings', 'wp-seopress-mainwp' ),
				400
			);
		}

		if ( ! function_exists( 'seopress_do_import_settings' ) ) {
			wp_send_json_success(
				__( 'Failed to load site settings. Function `seopress_do_import_settings` is missing.', 'wp-seopress-mainwp' ),
				500
			);
		}

		$selected_site = absint( sanitize_text_field( $_POST['selected_site'] ) );

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

		$settings = $information['settings'];

		if ( function_exists( 'seopress_do_import_settings' ) ) {
			$settings = $this->sanitize_options( $settings );
			
			seopress_do_import_settings( $settings );

			global $wpdb;

			$wpdb->query( "DELETE FROM {$wpdb->options} WHERE option_name LIKE 'seopress_mainwp_external_%'");
		}

		$child_websites = apply_filters( 'mainwp_getsites', $seopress_main_wp_extension->get_child_file(), $seopress_main_wp_extension->get_child_key() );

		foreach ( $child_websites as $web ) {
			if ( (int) $web['id'] === (int) $selected_site ) {
				update_option( 'mainwp_seopress_current_site_settings', $web );
				break;
			}
		}

		wp_send_json_success(
			__( 'Settings loaded successfully. Page will reload to show new settings...', 'wp-seopress-mainwp' ),
			200
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
