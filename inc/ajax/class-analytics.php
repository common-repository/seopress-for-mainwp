<?php
/**
 * Sends Analytics settings to child sites
 *
 * @package SEOPress\MainWP
 */

namespace SEOPress\MainWP\AJAX;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Analytics class
 */
class Analytics {
	use \SEOPress\MainWP\Traits\Singleton;

	/**
	 * Initialize class
	 *
	 * @return  void
	 */
	private function initialize() {
		add_action( 'wp_ajax_mainwp_seopress_save_analytics_settings', array( $this, 'save_analytics_settings' ) );
	}

	/**
	 * AJAX - Send Analytics settings to selected child sites
	 *
	 * Action: mainwp_seopress_save_analytics_settings
	 *
	 * @return void
	 */
	public function save_analytics_settings() {
		$nonce_check = check_ajax_referer( 'mainwp-seopress-save-analytics-settings-form', '__nonce', false );

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
		$settings       = $this->sanitize_options( $_POST['seopress_google_analytics_option_name'] ?? array() );

		$post_data = array(
			'action'   => 'sync_settings',
			'settings' => $settings,
			'option'   => 'seopress_google_analytics_option_name',
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
			seopress_mainwp_save_settings( $settings, 'seopress_google_analytics_option_name' );
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
					} elseif ( ! empty($option['seopress_google_analytics_matomo_widget_auth_token']) && 'seopress_google_analytics_matomo_widget_auth_token' === $input[$value]) {
						$options = get_option('seopress_google_analytics_option_name');
			
						$token = isset($options['seopress_google_analytics_matomo_widget_auth_token']) ? $options['seopress_google_analytics_matomo_widget_auth_token'] : null;
			
						$option[ $field ] = $option[ $field ] ==='xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx' ? $token : sanitize_text_field( wp_unslash($value));
					} elseif (( ! empty ($option['seopress_google_analytics_other_tracking']) && 'seopress_google_analytics_other_tracking' === $field) || (! empty ($option['seopress_google_analytics_other_tracking_body']) && 'seopress_google_analytics_other_tracking_body' === $field) || (! empty ($option['seopress_google_analytics_other_tracking_footer']) && 'seopress_google_analytics_other_tracking_footer' === $value) ) {
						if (current_user_can('unfiltered_html')) {
							$option[ $field ] = $value; //No sanitization for this field
						} else {
							$options = get_option('seopress_google_analytics_option_name');
							$option[ $field ] = isset($options[$field]) ? $options[$field] : sanitize_textarea_field($option[ $field ]);
						}
					} elseif ( ! empty($option['seopress_google_analytics_opt_out_msg']) && 'seopress_google_analytics_opt_out_msg' === $field) {
						$args = [
								'strong' => [],
								'em'     => [],
								'br'     => [],
								'a'      => [
									'href'   => [],
									'target' => [],
								],
						];
						$option[ $field ] = wp_kses($option[ $field ], $args);
					} else {
						$option[ $field ] = sanitize_text_field( wp_unslash( $value ) );
					}
				}
			}
		}

		return $option;
	}
}