<?php
/**
 * Main Class
 *
 * @package SEOPress\MainWP
 */

namespace SEOPress\MainWP;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Main
 */
class Main {
	use \SEOPress\MainWP\Traits\Singleton;

	/**
	 * Initialize class
	 *
	 * @return  void
	 */
	private function initialize() {
		add_action( 'plugins_loaded', array( $this, 'load_objects' ) );
		add_action( 'plugins_loaded', array( $this, 'load_textdomain' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'load_admin_assets' ) );
		add_action( 'mainwp_before_header', array( $this, 'seopress_error_notice' ) );

		add_action( 'wp_roles_init', array( $this, 'add_roles_from_child_sites' ) );

		add_filter( 'seopress_post_types', array( $this, 'remove_mainwp_post_types' ), 10, 3 );
		add_filter( 'seopress_get_taxonomies_list', array( $this, 'add_taxomonies_from_child_sites' ), 10, 2 );
		add_filter( 'seopress_skip_woocommerce_active_check', '__return_true' );
	}

	/**
	 * Load admin assets
	 *
	 * @param  string $hook The page on which the action is called.
	 *
	 * @return void
	 */
	public function load_admin_assets( $hook ) {
		if ( 'mainwp_page_Extensions-Seopress-For-Mainwp' !== $hook ) {
			return;
		}

		if ( isset( $_GET['tab'] ) && 'seopress-social' === $_GET['tab'] ) {
			$prefix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

			wp_enqueue_script(
				'seopress-media-uploader',
				SEOPRESS_PLUGIN_DIR_URL . 'assets/js/seopress-media-uploader' . $prefix . '.js',
				array( 'jquery' ),
				SEOPRESS_VERSION,
				false
			);
		}

		if ( \SEOPress\MainWP\Tabs::is_pro_version_active() && isset( $_GET['tab'] ) && 'seopress-pro-page' === $_GET['tab'] ) {
			wp_enqueue_script(
				'seopress-page-speed',
				SEOPRESS_PRO_PLUGIN_DIR_URL . 'assets/js/seopress-page-speed.js',
				array( 'jquery' ),
				SEOPRESS_PRO_VERSION,
				true
			);

			wp_localize_script(
				'seopress-page-speed',
				'seopressAjaxRequestPageSpeed',
				array(
					'seopress_nonce'              => wp_create_nonce( 'seopress_request_page_speed_nonce' ),
					'seopress_request_page_speed' => esc_url( admin_url( 'admin-ajax.php' ) ),
				)
			);

			wp_localize_script(
				'seopress-page-speed',
				'seopressAjaxClearPageSpeedCache',
				array(
					'seopress_nonce'                  => wp_create_nonce( 'seopress_clear_page_speed_cache_nonce' ),
					'seopress_clear_page_speed_cache' => esc_url( admin_url( 'admin-ajax.php' ) ),
				)
			);
		}

		if ( isset( $_GET['tab'] ) && in_array( $_GET['tab'], array( 'seopress-social', 'seopress-pro-page' ), true ) ) {
			wp_enqueue_media();
		}

		wp_enqueue_script(
			'mainwp-seopress-extension-main',
			SEOPRESS_WPMAIN_PLUGIN_URL . 'assets/js/main.js',
			array( 'jquery' ),
			SEOPRESS_WPMAIN_VERSION,
			true
		);

		wp_localize_script(
			'mainwp-seopress-extension-main',
			'mainWPSEOPress',
			array(
				'selectOneSiteMessage'        => __( 'Please select only one site to load settings from', 'wp-seopress-mainwp' ),
				'wpLoadSiteSettingsNonce'     => wp_create_nonce( 'mainwp-seopress-load-site-settings-nonce' ),
				'wpFlushRulesNonce'           => wp_create_nonce( 'mainwp-seopress-flush-rewrite-rules' ),
				'flushRulesButtonLoadingText' => __( 'Flushing...', 'wp-seopress-mainwp' ),
				'seopress_nonce'              => wp_create_nonce( 'seopress_instant_indexing_post_nonce' ),
				'proPageToggleNonce'          => wp_create_nonce( 'mainwp-seopress-titles-meta-toggle' ),
				'resetLicenceKeyNonce'        => wp_create_nonce( 'mainwp-seopress-reset-pro-licence-form' ),
				'resetLicenceLoadingText'     => __( 'Resetting...', 'wp-seopress-mainwp' ),
			)
		);

		wp_enqueue_style(
			'mainwp-seopress-extension-main',
			SEOPRESS_WPMAIN_PLUGIN_URL . 'assets/css/main.css',
			array(),
			SEOPRESS_WPMAIN_VERSION
		);
	}

	/**
	 * Render the warning notice if the SEOPress plugin is not activated.
	 */
	public function seopress_error_notice() {
		$screen = get_current_screen();

		if ( $screen && strpos( $screen->base, 'mainwp_' ) !== false && ! in_array( 'wp-seopress/seopress.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ), true ) ) {
			printf(
				'<div class="ui red message">
					<div class="header">' . esc_html__( 'The SEOPress plugin is not detected on the Dashboard site!', 'wp-seopress-mainwp' ) . '</div>
					' . esc_html__( 'The MainWP SEOPress Extension requires the SEOPress plugin to be installed and activated on your MainWP Dashboard site.', 'wp-seopress-mainwp' ) . '
				</div>'
			);
		}
	}

	/**
	 * Initialize classes / objects here
	 *
	 * @return  void
	 */
	public function load_objects() {
		// Global objects.
		\SEOPress\MainWP\AJAX\Toggle_Features::get_instance();
		\SEOPress\MainWP\AJAX\Load_Site_Settings::get_instance();
		\SEOPress\MainWP\AJAX\Titles_Metas::get_instance();
		\SEOPress\MainWP\AJAX\XML_HTML_Sitemap::get_instance();
		\SEOPress\MainWP\AJAX\Social_Networks::get_instance();
		\SEOPress\MainWP\AJAX\Analytics::get_instance();
		\SEOPress\MainWP\AJAX\Instant_Indexing::get_instance();
		\SEOPress\MainWP\AJAX\Advanced::get_instance();
		\SEOPress\MainWP\AJAX\Export::get_instance();
		\SEOPress\MainWP\AJAX\Import::get_instance();

		if ( \SEOPress\MainWP\Tabs::is_pro_version_active() ) {
			\SEOPress\MainWP\AJAX\Pro_Page::get_instance();
			\SEOPress\MainWP\AJAX\Licence::get_instance();
		}
	}

	/**
	 * Register textdomain
	 *
	 * @return  void
	 */
	public function load_textdomain() {
		load_plugin_textdomain( 'wp-seopress-mainwp', false, SEOPRESS_WPMAIN_PLUGIN_DIR . 'languages' );
	}

	/**
	 * Remove mainwp dashboard plugin registered post types and add CPTs from child sites.
	 *
	 * @param  array $post_types List of post types.
	 * @param  bool  $return_all If all post types are returned or they are unset.
	 * @param  array $return_all Arguments sent to the query.
	 *
	 * @return array
	 */
	public function remove_mainwp_post_types( $post_types, $return_all, $args ) {
		$key = 'seopress_mainwp_external_cpt' . md5( $return_all . wp_json_encode( $args ) );

		$external_cpt = get_option( $key, array() );

		if ( ! empty( $external_cpt ) ) {
			return $external_cpt;
		}

		unset( $post_types['bulkpost'] );
		unset( $post_types['bulkpage'] );

		$default_pt = get_post_types( array(
			'_builtin' => true
		));

		if (!is_array($default_pt)) {
			return;
		}

		$default_pt_keys = array_keys( $default_pt );

		global $seopress_main_wp_extension;

		$child_websites = apply_filters( 'mainwp_getsites', $seopress_main_wp_extension->get_child_file(), $seopress_main_wp_extension->get_child_key() );

		foreach ( $child_websites as $web ) {

			$dbwebsites = apply_filters( 'mainwp_getdbsites', $seopress_main_wp_extension->get_child_file(), $seopress_main_wp_extension->get_child_key(), [ $web['id'] ], [] );
			
			$website = current( $dbwebsites );

			$args = [];
			
			if (!empty($website) && (!empty($website->http_user) && !empty($website->http_pass))) {
				$args['headers'] = array('Authorization' => 'Basic ' . base64_encode( $website->http_user . ':' . $website->http_pass ));
			}

			$pt = wp_remote_get( trailingslashit( $web['url'] ) . 'wp-json/wp/v2/types', $args );

			if ( ! is_wp_error( $pt ) && 200 == wp_remote_retrieve_response_code( $pt )) {
				$original = json_decode( wp_remote_retrieve_body( $pt ), true );

				if (!is_array($original)) {
					return;
				}

				$pt = array_keys( $original );

				$diff = array_diff( $pt, $default_pt_keys );

				foreach ( $diff as $new_pt ) {
					if ( isset( $post_types[ $new_pt ] ) ) {
						continue;
					}

					$new_pt_obj = get_post_type_object( $new_pt );

					if ( ! $new_pt_obj ) {
						$new_pt_obj = new \stdClass();
						$new_pt_obj->name = $new_pt;
						$new_pt_obj->label = $original[ $new_pt ]['name'];
						$new_pt_obj->labels = new \stdClass();
						$new_pt_obj->labels->name = $original[ $new_pt ]['name'];
					}

					$post_types[ $new_pt ] = $new_pt_obj;
				}
			}
		}

		update_option( $key, $post_types );

		return $post_types;
	}

	/**
	 * Add taxonomies from child sites
	 *
	 * @param  array $taxonomies List of taxonomies.
	 * @param  bool  $return_all If all post types are returned or they are unset.
	 *
	 * @return array
	 */
	public function add_taxomonies_from_child_sites( $taxonomies, $return_all ) {
		$external_tax = get_option( 'seopress_mainwp_external_tax' . $return_all, array() );

		if ( ! empty( $external_tax ) ) {
			return $external_tax;
		}

		$skip = array(
			'nav_menu',
		);

		global $seopress_main_wp_extension;

		$child_websites = apply_filters( 'mainwp_getsites', $seopress_main_wp_extension->get_child_file(), $seopress_main_wp_extension->get_child_key() );

		foreach ( $child_websites as $web ) {

			$dbwebsites = apply_filters( 'mainwp_getdbsites', $seopress_main_wp_extension->get_child_file(), $seopress_main_wp_extension->get_child_key(), [ $web['id'] ], [] );
			
			$website = current( $dbwebsites );

			$args = [];
			
			if (!empty($website) && (!empty($website->http_user) && !empty($website->http_pass))) {
				$args['headers'] = array('Authorization' => 'Basic ' . base64_encode( $website->http_user . ':' . $website->http_pass ));
			}

			$pt = wp_remote_get( trailingslashit( $web['url'] ) . 'wp-json/wp/v2/taxonomies', $args );

			if ( ! is_wp_error( $pt ) && 200 == wp_remote_retrieve_response_code( $pt )) {
				$original = json_decode( wp_remote_retrieve_body( $pt ), true );

				if (!is_array($original)) {
					return;
				}

				$new_taxonomies = array_keys( $original );

				foreach ( $new_taxonomies as $new_tax ) {
					if ( isset( $taxonomies[ $new_tax ] ) || in_array( $new_tax, $skip, true ) ) {
						continue;
					}

					$new_tax_obj = get_taxonomy( $new_tax );

					if ( ! $new_tax_obj ) {
						$new_tax_obj = new \stdClass();
						$new_tax_obj->name = $new_tax;
						$new_tax_obj->label = $original[ $new_tax ]['name'];
						$new_tax_obj->labels = new \stdClass();
						$new_tax_obj->labels->name = $original[ $new_tax ]['name'];
					}

					$taxonomies[ $new_tax ] = $new_tax_obj;
				}
			}
		}

		update_option( 'seopress_mainwp_external_tax' . $return_all, $taxonomies );

		return $taxonomies;
	}

	/**
	 * Add roles from child sites
	 *
	 * @param  \WP_Role $wp_role The wp_role object.
	 *
	 * @return void
	 */
	public function add_roles_from_child_sites( $wp_role ) {
		$external_load = get_option( 'seopress_mainwp_external_load_set', false );

		if ( $external_load ) {
			return;
		}

		global $seopress_main_wp_extension;

		$current_site = get_option( 'mainwp_seopress_current_site_settings', array() );

		if ( empty( $current_site ) ) {
			return;
		}

		$default_roles = array(
			'administrator',
			'editor',
			'author',
			'contributor',
			'subscriber',
		);

		$current_roles = $wp_role->get_names();

		if (!is_array($current_roles)) {
			return;
		}

		$current_roles = array_keys( $current_roles );

		foreach ( $current_roles as $r ) {
			if ( ! in_array( $r, $default_roles, true ) ) {
				$wp_role->remove_role( $r );
			}
		}

		$roles_response = wp_remote_get( trailingslashit( $current_site['url'] ) . 'wp-json/seopress/v1/roles' );

		if ( ! is_wp_error( $roles_response ) ) {
			$roles = json_decode( wp_remote_retrieve_body( $roles_response ), true );

			if ( empty( $roles ) ) {
				return;
			}

			foreach ( $roles as $slug => $name ) {
				$wp_role->add_role(
					$slug,
					$name
				);
			}
		}

		update_option( 'seopress_mainwp_external_load_set', true );
	}
}
