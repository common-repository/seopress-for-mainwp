<?php
/**
 * Sends Pro Licence settings to child sites
 *
 * @package SEOPress\MainWP
 */

namespace SEOPress\MainWP\AJAX;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Pro Licence class
 */
class Licence {
	use \SEOPress\MainWP\Traits\Singleton;

	/**
	 * Initialize class
	 *
	 * @return  void
	 */
	private function initialize() {
		add_action( 'wp_ajax_mainwp_seopress_save_pro_licence', array( $this, 'save_pro_licence' ) );
		add_action( 'wp_ajax_mainwp_seopress_reset_pro_licence', array( $this, 'reset_pro_licence' ) );
	}

	/**
	 * AJAX - Save and activate licence for selected child sites
	 *
	 * Action: mainwp_seopress_save_pro_licence
	 *
	 * @return void
	 */
	public function save_pro_licence() {
		$nonce_check = check_ajax_referer( 'mainwp-seopress-save-pro-licence-form', '__nonce', false );

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

		$selected_sites = $this->sanitize_options( $_POST['selected_sites'] );
		$licence        = sanitize_text_field( $_POST['seopress_pro_license_key'] ?? '' );

		$post_data = array(
			'action'  => 'save_pro_licence',
			'licence' => $licence,
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

		update_option( 'seopress_pro_license_key', $license );

		wp_send_json_success(
			array(
				'message' => __( 'Save successfull', 'wp-seopress-mainwp' ),
			)
		);
	}

	/**
	 * AJAX - Reset pro licences for selected child sites
	 *
	 * Action: mainwp_seopress_reset_pro_licence
	 *
	 * @return void
	 */
	public function reset_pro_licence() {
		$nonce_check = check_ajax_referer( 'mainwp-seopress-reset-pro-licence-form', '__nonce', false );

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

		$selected_sites = $this->sanitize_options( $_POST['selected_sites'] );

		$post_data = array(
			'action' => 'reset_pro_licence',
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

		delete_option( 'seopress_pro_license_status' );
	  	delete_option( 'seopress_pro_license_key' );

		wp_send_json_success(
			array(
				'message' => __( 'Reset successfull', 'wp-seopress-mainwp' ),
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
