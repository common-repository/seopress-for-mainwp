<?php
/**
 * Roles Class
 *
 * @package SEOPress\MainWP
 */

namespace SEOPress\MainWP;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Tabs
 */
class Tabs {
	use \SEOPress\MainWP\Traits\Singleton;

	/**
	 * Current active tab
	 *
	 * @var string
	 */
	protected $current_tab;

	/**
	 * Initialize class
	 *
	 * @return void
	 */
	private function initialize() {
		$this->current_tab = ! empty( $_GET['tab'] ) ? sanitize_text_field( wp_unslash( $_GET['tab'] ) ) : 'seopress-dashboard'; //phpcs:ignore
	}

	/**
	 * Check if pro version is active
	 *
	 * @return boolean
	 */
	public static function is_pro_version_active() {
		return in_array( 'wp-seopress-pro/seopress-pro.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ), true );
	}

	/**
	 * Add new capabilites
	 *
	 * @return  void
	 */
	public function render() {
		$selected_websites = array();
		$selected_groups   = array();

		$is_pro_version_active = $this->is_pro_version_active();

		$seopress_toggle_options = get_option( 'seopress_toggle' );

		$dashboard_settings = get_option( 'mainwp_seopress_dashboard' );

		require_once SEOPRESS_WPMAIN_PLUGIN_DIR . 'views/main-tabs.php';
		require_once SEOPRESS_WPMAIN_PLUGIN_DIR . 'views/tabs-content.php';
	}
}
