<?php
/**
 * Sends social networks settings to child sites
 *
 * @package SEOPress\MainWP
 */

namespace SEOPress\MainWP\AJAX;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Social Networks class
 */
class Social_Networks {
	use \SEOPress\MainWP\Traits\Singleton;

	/**
	 * Initialize class
	 *
	 * @return  void
	 */
	private function initialize() {
		add_action( 'wp_ajax_mainwp_seopress_save_social_networks_settings', array( $this, 'save_social_networks_settings' ) );
	}

	/**
	 * AJAX - Send social networks settings to selected child sites
	 *
	 * Action: mainwp_seopress_save_social_networks_settings
	 *
	 * @return void
	 */
	public function save_social_networks_settings() {
		$nonce_check = check_ajax_referer( 'mainwp-seopress-save-social-networks-settings-form', '__nonce', false );

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
		$settings       = $this->sanitize_options( $_POST['seopress_social_option_name'] ?? array() );

		$post_data = array(
			'action'   => 'sync_settings',
			'settings' => $settings,
			'option'   => 'seopress_social_option_name',
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
			seopress_mainwp_save_settings( $settings, 'seopress_social_option_name' );
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
						if (( ! empty ($option['seopress_social_accounts_facebook']) && 'seopress_social_accounts_facebook' === $field) || (! empty ($option['seopress_social_accounts_pinterest']) && 'seopress_social_accounts_pinterest' === $field) || (! empty ($option['seopress_social_accounts_instagram']) && 'seopress_social_accounts_instagram' === $value) || (! empty ($option['seopress_social_accounts_youtube']) && 'seopress_social_accounts_youtube' === $value) || (! empty ($option['seopress_social_accounts_linkedin']) && 'seopress_social_accounts_linkedin' === $value) || ( ! empty ($option['seopress_social_facebook_img']) && 'seopress_social_facebook_img' === $field) || ( ! empty ($option['seopress_social_twitter_card_img']) && 'seopress_social_twitter_card_img' === $field)) {
							$option[ $field ] = sanitize_url($value);
						} elseif (( ! empty ($option['seopress_social_accounts_extra']) && 'seopress_social_accounts_extra' === $field)) {
							$option[ $field ] = sanitize_textarea_field( wp_unslash( $value ) );
						} elseif (( ! empty ($option['seopress_social_knowledge_email']) && 'seopress_social_knowledge_email' === $field)) {
							$option[ $field ] = sanitize_email($value);
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
