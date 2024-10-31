<?php
/**
 * Sends Advanced settings to child sites
 * 
 * These classes serve as hub for communication between SEOPress along with MainWP and MainWP-Child Plugin on the remote sites.
 * Sanitization is already done in the remote sites, that is, in the MainWP-Child class which is receiving these remote requests.
 * But, I added sanitization here as well, because why not, even tho these classes save no data in the database.
 * 
 * @package SEOPress\MainWP
 */

namespace SEOPress\MainWP\AJAX;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Advanced class
 */
class Advanced {
	use \SEOPress\MainWP\Traits\Singleton;

	/**
	 * Initialize class
	 *
	 * @return  void
	 */
	private function initialize() {
		add_action( 'wp_ajax_mainwp_seopress_save_advanced_settings', array( $this, 'save_advanced_settings' ) );
	}

	/**
	 * AJAX - Send advanced settings to selected child sites
	 *
	 * Action: mainwp_seopress_save_advanced_settings
	 *
	 * @return void
	 */
	public function save_advanced_settings() {
		$nonce_check = check_ajax_referer( 'mainwp-seopress-save-advanced-settings-form', '__nonce', false );

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
				__( 'Please select a site on which to save the settings', 'wp-seopress-mainwp' ),
				400
			);
		}

		// Selected site is sanitized down there where it is used.
		$selected_sites = $this->sanitize_options( $_POST['selected_sites'] );
		$settings       = $this->sanitize_options( $_POST['seopress_advanced_option_name'] ?? array() );

		$post_data = array(
			'action'   => 'sync_settings',
			'settings' => $settings,
			'option'   => 'seopress_advanced_option_name',
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

		if ( function_exists( 'seopress_mainwp_save_settings' ) ) {
			seopress_mainwp_save_settings( $settings, 'seopress_advanced_option_name' );
		}

		wp_send_json_success(
			array(
				'message' => __( 'Save successfull', 'wp-seopress-mainwp' ),
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
						$option[ $field ] = sanitize_text_field( wp_unslash( $value ) );
					}
				}
			}
		}

		return $option;
	}
}
