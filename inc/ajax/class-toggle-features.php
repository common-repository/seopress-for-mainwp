<?php
/**
 * Enables / disables SEO Main features
 *
 * @package SEOPress\MainWP
 */

namespace SEOPress\MainWP\AJAX;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Toggle features class
 */
class Toggle_Features {
	use \SEOPress\MainWP\Traits\Singleton;

	/**
	 * Initialize class
	 *
	 * @return  void
	 */
	private function initialize() {
		add_action( 'wp_ajax_mainwp_seopress_titles_meta_toggle', array( $this, 'toggle_feature' ) );
	}

	/**
	 * AJAX - Toggle Titles & Metas feature
	 *
	 * Action: mainwp_seopress_titles_meta_toggle
	 *
	 * @return void
	 */
	public function toggle_feature() {
		$nonce_check = check_ajax_referer( 'mainwp-seopress-titles-meta-toggle', '__nonce', false );

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

		if ( empty( $_POST['feature'] ) ) {
			wp_send_json_error(
				__( 'Feature missing. Please refresh the page.', 'wp-seopress-mainwp' ),
				400
			);
		}

		$selected_sites = $this->sanitize_options( $_POST['selected_sites'] );
		$feature        = sanitize_text_field( $_POST['feature'] );

		$seopress_toggle_options = get_option( 'seopress_toggle' );

		if ( ! isset( $seopress_toggle_options[ $feature ] ) ) {
			$seopress_toggle_options[ $feature ] = 1;
		} else {
			unset( $seopress_toggle_options[ $feature ] );
		}

		$post_data = array(
			'action'   => 'sync_settings',
			'settings' => $seopress_toggle_options,
			'option'   => 'seopress_toggle',
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
			seopress_mainwp_save_settings( $seopress_toggle_options, 'seopress_toggle' );
		}

		wp_send_json_success(
			__( 'Settings saved successfully', 'wp-seopress-mainwp' ),
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
						$option[ $field ] = sanitize_text_field( wp_unslash( $value ) );
					}
				}
			}
		}

		return $option;
	}
}
