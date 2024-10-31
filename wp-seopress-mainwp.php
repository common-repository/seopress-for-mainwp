<?php
/*
Plugin Name: SEOPress for MainWP
Plugin URI: https://www.seopress.org/
Description: The official SEOPress for MainWP extension.
Author: The SEO Guys at SEOPress
Author URI: https://www.seopress.org/wordpress-seo-plugins/seopress-mainwp-add-on/
Version: 1.4
License: GPLv2 or later
Text Domain: wp-seopress-mainwp
Domain Path: /languages
Documentation URI: https://www.seopress.org/docs/mainwp
Requires PHP: 7.4
Requires at least: 6.0
*/

/*  Copyright 2022 - 2024 - Benjamin Denis  (email : contact@seopress.org)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WordPress Main Plugin Class
 */
final class SEOPress_MainWP_Extension {
	/**
	 * Instance of the plugin
	 *
	 * @var SEOPress
	 */
	private static $instance;

	/**
	 * Plugin version
	 *
	 * @var string
	 */
	private $version = '1.4';

	/**
	 * Protected variable containg information about MainWP plugin status.
	 *
	 * @var bool
	 */
	protected $mainwp_main_activated = false;

	/**
	 * Protected variable containg information about the Extension status.
	 *
	 * @var bool
	 */
	protected $child_enabled = false;

	/**
	 * Protected variable containg the Extension key.
	 *
	 * @var bool|string
	 */
	protected $child_key = false;

	/**
	 * Protected variable containg the child file.
	 *
	 * @var string
	 */
	protected $child_file = false;

	/**
	 * Protected variable containg the extension handle.
	 *
	 * @var string
	 */
	protected $plugin_handle = 'wp-seopress-mainwp';

	/**
	 * Protected variable containg the extension ID (product title).
	 *
	 * @var string
	 */
	protected $product_id = 'SEOPress';

	/**
	 * Instanciate the plugin
	 */
	public static function get_instance() {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof SEOPress ) ) {
			self::$instance = new SEOPress_MainWP_Extension();
			self::$instance->constants();
			self::$instance->includes();
			self::$instance->run();

			add_filter( 'mainwp_getextensions', [self::$instance, 'get_this_extension'] );
			add_action( 'admin_notices', [self::$instance, 'mainwp_error_notice'] );

			add_filter( 'mainwp_extensions_page_top_header', [self::$instance, 'title_page_top_header'], 10, 2);

			add_filter( 'mainwp_plugins_install_checks', [self::$instance, 'plugins_install_checks'], 10, 1 );

			register_activation_hook( __FILE__, [self::$instance, 'activate'] );
			register_deactivation_hook( __FILE__,  [self::$instance, 'deactivate'] );
		}

		return self::$instance;
	}

	/**
	 * 3rd party includes
	 *
	 * @return  void
	 */
	private function includes() {
		require_once SEOPRESS_WPMAIN_PLUGIN_DIR . 'inc/core/autoloader.php';
	}

	/**
	 * Define plugin constants
	 *
	 * @return  void
	 */
	private function constants() {
		// Plugin version.
		if ( ! defined( 'SEOPRESS_WPMAIN_VERSION' ) ) {
			define( 'SEOPRESS_WPMAIN_VERSION', $this->version );
		}

		// Plugin Folder Path.
		if ( ! defined( 'SEOPRESS_WPMAIN_PLUGIN_DIR' ) ) {
			define( 'SEOPRESS_WPMAIN_PLUGIN_DIR', trailingslashit( plugin_dir_path( __FILE__ ) ) );
		}

		// Plugin Folder URL.
		if ( ! defined( 'SEOPRESS_WPMAIN_PLUGIN_URL' ) ) {
			define( 'SEOPRESS_WPMAIN_PLUGIN_URL', trailingslashit( plugin_dir_url( __FILE__ ) ) );
		}

		$this->child_file = __FILE__;
	}

	/**
	 * Load some data
	 *
	 * @return void
	 */
	public function run() {
		$this->mainwp_main_activated = apply_filters( 'mainwp_activated_check', false );

		if ( false !== $this->mainwp_main_activated ) {
			$this->activate_this();
		} else {
			add_action( 'mainwp_activated', array( self::$instance, 'activate_this' ) );
		}
	}

	/**
	 * Add your extension to MainWP via the 'mainwp_getextensions' filter.
	 *
	 * @param array $params Array containing the extensions info.
	 *
	 * @return array Updated array containing the extensions info.
	 */
	public function get_this_extension( $params ) {
		$params[] = array(
			'plugin'     => __FILE__,
			'api'        => $this->plugin_handle,
			'mainwp'     => false,
			'name' 		 => 'SEOPress',
			'callback'   => array( $this, 'render_settings' ),
			'apiManager' => false,
			'icon' 		 => plugin_dir_url( __FILE__ ) . 'assets/img/logo.svg',
		);

		return $params;
	}

	/**
	 * Check if required plugins are installed via the 'mainwp_plugins_install_checks' filter.
	 *
	 * @param array $plugins Array containing the plugins info.
	 *
	 * @return array Updated array containing the plugins info.
	 */
	public function plugins_install_checks( $plugins ) {
		$plugins[] = [
			'page' => 'Extensions-Seopress-For-Mainwp',
			'slug' => 'wp-seopress/seopress.php',
			'name' => 'SEOPress for MainWP',
		];

		return $plugins;
	}

	/**
	 * Displays the extension page with adequate header and footer.
	 */
	public function render_settings() {
		do_action( 'mainwp_pageheader_extensions', __FILE__ );

		$tabs = \SEOPress\MainWP\Tabs::get_instance();
		$tabs->render();

		do_action( 'mainwp_pagefooter_extensions', __FILE__ );
	}

	/**
	 * Activate the extension API license and initiate the extension.
	 */
	public function activate_this() {
		$this->mainwp_main_activated = apply_filters( 'mainwp_activated_check', $this->mainwp_main_activated );

		$this->child_enabled = apply_filters( 'mainwp_extension_enabled_check', __FILE__ );
		$this->child_key     = $this->child_enabled['key'];

		\SEOPress\MainWP\Main::get_instance();
	}

	/**
	 * Render the warning notice if the MainWP Dashboard plugin is not activated.
	 */
	public function mainwp_error_notice() {
		global $current_screen;

		if ( 'plugins' === $current_screen->parent_base && false === $this->mainwp_main_activated ) {
			_e('<div class="error"><p>SEOPress for MainWP requires MainWP Dashboard Plugin. Please install and activate <a href="https://mainwp.com/" target="_blank">MainWP Dashboard Plugin</a> first.</p></div>','wp-seopress-mainwp');
		}
	}

	/**
	 * Get child key
	 *
	 * @return string
	 */
	public function get_child_key() {
		return $this->child_key;
	}

	/**
	 * Get child file
	 *
	 * @return string
	 */
	public function get_child_file() {
		return $this->child_file;
	}

	/**
	 * Activate the extension license.
	 */
	public function activate() {
		$options = array(
			'product_id'       => $this->product_id,
			'software_version' => $this->version,
		);

		do_action( 'mainwp_activate_extension', $this->plugin_handle, $options );
	}

	/**
	 * Deactivate the extension license.
	 */
	public function deactivate() {
		do_action( 'mainwp_deactivate_extension', $this->plugin_handle );
	}

	/**
	 * Filter title in MainWP admin bar
	 */
	public function title_page_top_header( $title, $page ) {
		if ( 'Extensions-Seopress-For-Mainwp' === $page ) {
			return 'SEOPress';
		}
		return $title;
	}
}

global $seopress_main_wp_extension;
$seopress_main_wp_extension = SEOPress_MainWP_Extension::get_instance();