<?php
/**
 * Sends Pro Page settings to child sites
 *
 * @package SEOPress\MainWP
 */

namespace SEOPress\MainWP\AJAX;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Pro Page class
 */
class Pro_Page {
	use \SEOPress\MainWP\Traits\Singleton;

	/**
	 * Initialize class
	 *
	 * @return  void
	 */
	private function initialize() {
		add_action( 'wp_ajax_mainwp_seopress_save_pro_settings', array( $this, 'save_pro_settings' ) );
	}

	/**
	 * AJAX - Send pro settings to selected child sites
	 *
	 * Action: mainwp_seopress_save_pro_settings
	 *
	 * @return void
	 */
	public function save_pro_settings() {
		$nonce_check = check_ajax_referer( 'mainwp-seopress-save-pro-settings-form', '__nonce', false );

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
		$settings       = $this->sanitize_options( $_POST['seopress_pro_option_name'] ?? array() );

		$post_data = array(
			'action'   => 'sync_settings',
			'settings' => $settings,
			'option'   => 'seopress_pro_option_name',
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
			seopress_mainwp_save_settings( $settings, 'seopress_pro_option_name' );
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
						if ('seopress_ai_openai_api_key' == $field) {
							$options = get_option('seopress_pro_option_name');
							$old = isset($options['seopress_ai_openai_api_key']) ? $options['seopress_ai_openai_api_key'] : null;
			
							if ('xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx' == $value) {
								$option[ $field ] = $old;
							} else {
								$option[ $field ] = sanitize_textarea_field( wp_unslash($value) );
							}
						} elseif ( 'seopress_robots_file' === $field || 'seopress_instant_indexing_google_api_key' === $field ) {
							$option[ $field ] = sanitize_textarea_field( wp_unslash( $value ) );
						} elseif ('seopress_rss_after_html' == $field || 'seopress_rss_before_html' == $field) {
							$args = [
								'strong' => [],
								'em' => [],
								'br' => [],
								'a' => ['href' => [], 'rel' => []],
							];
							$input[$value] = wp_kses($input[$value], $args);
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
