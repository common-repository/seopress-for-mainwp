<?php
/**
 * SEOPress Dashboard
 *
 * @package SEOPress\MainWP
 */
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$titles_check = ! empty( $seopress_toggle_options['toggle-titles'] ) ? 1 : 0;
$sitemap_check = ! empty( $seopress_toggle_options['toggle-xml-sitemap'] ) ? 1 : 0;
$social_check = ! empty( $seopress_toggle_options['toggle-social'] ) ? 1 : 0;
$google_analytics_check = ! empty( $seopress_toggle_options['toggle-google-analytics'] ) ? 1 : 0;
$instant_indexing_check = ! empty( $seopress_toggle_options['toggle-instant-indexing'] ) ? 1 : 0;
$advanced_check = ! empty( $seopress_toggle_options['toggle-advanced'] ) ? 1 : 0;
$woocommerce_check = ! empty( $seopress_toggle_options['toggle-woocommerce'] ) ? 1 : 0;
$edd_check = ! empty( $seopress_toggle_options['toggle-edd'] ) ? 1 : 0;
$inspect_url_check = ! empty( $seopress_toggle_options['toggle-inspect-url'] ) ? 1 : 0;
$ai_check = ! empty( $seopress_toggle_options['toggle-ai'] ) ? 1 : 0;
$local_business_check = ! empty( $seopress_toggle_options['toggle-local-business'] ) ? 1 : 0;
$dublin_core_check = ! empty( $seopress_toggle_options['toggle-dublin-core'] ) ? 1 : 0;
$rich_snippets_check = ! empty( $seopress_toggle_options['toggle-rich-snippets'] ) ? 1 : 0;
$breadcrumbs_check = ! empty( $seopress_toggle_options['toggle-breadcrumbs'] ) ? 1 : 0;
$robots_check = ! empty( $seopress_toggle_options['toggle-robots'] ) ? 1 : 0;
$news_check = ! empty( $seopress_toggle_options['toggle-news'] ) ? 1 : 0;
$redirects_check = ! empty( $seopress_toggle_options['toggle-404'] ) ? 1 : 0;
$rewrite_check = ! empty( $seopress_toggle_options['toggle-rewrite'] ) ? 1 : 0;
?>

<div class="ui segment mainwp-seopress-dashboard">
	<div class="ui message" id="mainwp-seopress-message-box" style="display: none;"></div>
	<div class="ui sixteen column stackable left aligned grid">
		<div class="column">
			<h2 class="header"><?php esc_html_e( 'Dashboard', 'wp-seopress-mainwp' ); ?></h2>
		</div>
	</div>
	<div class="sixteen wide column mainwp-seopress-dashboard-content" id="mainwp-seopress-dashboard-content">
		<div class="ui segment mainwp-seopress-tab-content">
			<h3><?php esc_html_e( 'SEO management', 'wp-seopress-mainwp' ); ?></h3>
			<div class="ui one column">
				<div class="six wide column mainwp-seopress-dashboard-toggles">
					<div class="ui checkbox toggle">
						<input type="checkbox" value="toggle-titles" name="mainwp_seopress_dashboard[seopress_titles_metas]" class="mainwp-seopress-dashboard-checks" id="seopress-titles-metas" <?php checked( $titles_check, 1 ); ?> data-nonce="<?php echo esc_attr( wp_create_nonce( 'mainwp-seopress-titles-meta-toggle' ) ); ?>">
						<label for="seopress-titles-metas"><?php esc_html_e( 'Titles & Metas', 'wp-seopress-mainwp' ); ?></label>
						<div>
							<em><?php esc_html_e( 'Manage all your titles & metas for post types, taxonomies, archives...', 'wp-seopress-mainwp' ); ?></em>
						</div>
					</div>
				</div>
				<div class="six wide column mainwp-seopress-dashboard-toggles">
					<div class="ui checkbox toggle">
						<input type="checkbox" value="toggle-xml-sitemap" name="mainwp_seopress_dashboard[seopress_xml_html_sitemaps]" class="mainwp-seopress-dashboard-checks" id="seopress-xml-html-sitemaps" <?php checked( $sitemap_check, 1 ); ?> data-nonce="<?php echo esc_attr( wp_create_nonce( 'mainwp-seopress-titles-meta-toggle' ) ); ?>">
						<label for="seopress-xml-html-sitemaps"><?php esc_html_e( 'XML & HTML Sitemaps', 'wp-seopress-mainwp' ); ?></label>
						<div>
							<em><?php esc_html_e( 'Manage your XML - Image - Video - HTML Sitemap.', 'wp-seopress-mainwp' ); ?></em>
						</div>
					</div>
				</div>
				<div class="six wide column mainwp-seopress-dashboard-toggles">
					<div class="ui checkbox toggle">
						<input type="checkbox" value="toggle-social" name="mainwp_seopress_dashboard[seopress_social_networks]" class="mainwp-seopress-dashboard-checks" id="seopress-social-networks" <?php checked( $social_check, 1 ); ?> data-nonce="<?php echo esc_attr( wp_create_nonce( 'mainwp-seopress-titles-meta-toggle' ) ); ?>">
						<label for="seopress-social-networks"><?php esc_html_e( 'Social Networks', 'wp-seopress-mainwp' ); ?></label>
						<div>
							<em><?php esc_html_e( 'Open Graph, X Cards, Google Knowledge Graph and more...', 'wp-seopress-mainwp' ); ?></em>
						</div>
					</div>
				</div>
				<div class="six wide column mainwp-seopress-dashboard-toggles">
					<div class="ui checkbox toggle">
						<input type="checkbox" value="toggle-google-analytics" name="mainwp_seopress_dashboard[seopress_analytics]" class="mainwp-seopress-dashboard-checks" id="seopress-analytics" <?php checked( $google_analytics_check, 1 ); ?> data-nonce="<?php echo esc_attr( wp_create_nonce( 'mainwp-seopress-titles-meta-toggle' ) ); ?>">
						<label for="seopress-analytics"><?php esc_html_e( 'Analytics', 'wp-seopress-mainwp' ); ?></label>
						<div>
							<em><?php esc_html_e( 'Track everything about your visitors with Google Analytics / Matomo / Microsoft Clarity.', 'wp-seopress-mainwp' ); ?></em>
						</div>
					</div>
				</div>
				<div class="six wide column mainwp-seopress-dashboard-toggles">
					<div class="ui checkbox toggle">
						<input type="checkbox" value="toggle-instant-indexing" name="mainwp_seopress_dashboard[instant_indexing]" class="mainwp-seopress-dashboard-checks" id="seopress-instant-indexing" <?php checked( $instant_indexing_check, 1 ); ?> data-nonce="<?php echo esc_attr( wp_create_nonce( 'mainwp-seopress-titles-meta-toggle' ) ); ?>">
						<label for="seopress-instant-indexing"><?php esc_html_e( 'Instant Indexing', 'wp-seopress-mainwp' ); ?></label>
						<div>
							<em><?php esc_html_e( 'Ping Google & Bing to quickly index your content.', 'wp-seopress-mainwp' ); ?></em>
						</div>
					</div>
				</div>
				<div class="six wide column mainwp-seopress-dashboard-toggles">
					<div class="ui checkbox toggle">
						<input type="checkbox" value="toggle-advanced" name="mainwp_seopress_dashboard[advanced]" class="mainwp-seopress-dashboard-checks" id="seopress-advanced" <?php checked( $advanced_check, 1 ); ?> data-nonce="<?php echo esc_attr( wp_create_nonce( 'mainwp-seopress-titles-meta-toggle' ) ); ?>">
						<label for="seopress-advanced"><?php esc_html_e( 'Advanced', 'wp-seopress-mainwp' ); ?></label>
						<div>
							<em><?php esc_html_e( 'Optimize your images for SEO. Configure advanced settings.', 'wp-seopress-mainwp' ); ?></em>
						</div>
					</div>
				</div>
				<?php if ( $is_pro_version_active ) : ?>
					<div class="six wide column mainwp-seopress-pro-dashboard-toggles">
						<div class="ui checkbox toggle">
							<input type="checkbox" value="toggle-woocommerce" name="mainwp_seopress_dashboard[woocommerce]" class="mainwp-seopress-dashboard-checks" id="seopress-woocommerce" <?php checked( $woocommerce_check, 1 ); ?> data-nonce="<?php echo esc_attr( wp_create_nonce( 'mainwp-seopress-titles-meta-toggle' ) ); ?>">
							<label for="seopress-woocommerce"><?php esc_html_e( 'WooCommerce', 'wp-seopress-mainwp' ); ?></label>
							<div>
								<em><?php esc_html_e( 'Improve WooCommerce SEO', 'wp-seopress-mainwp' ); ?></em>
							</div>
						</div>
					</div>
					<div class="six wide column mainwp-seopress-pro-dashboard-toggles">
						<div class="ui checkbox toggle">
							<input type="checkbox" value="toggle-edd" name="mainwp_seopress_dashboard[edd]" class="mainwp-seopress-dashboard-checks" id="seopress-edd" <?php checked( $edd_check, 1 ); ?> data-nonce="<?php echo esc_attr( wp_create_nonce( 'mainwp-seopress-titles-meta-toggle' ) ); ?>">
							<label for="seopress-edd"><?php esc_html_e( 'Easy Digital Downloads', 'wp-seopress-mainwp' ); ?></label>
							<div>
								<em><?php esc_html_e( 'Imporove Easy Digital Downloads SEO', 'wp-seopress-mainwp' ); ?></em>
							</div>
						</div>
					</div>
					<div class="six wide column mainwp-seopress-pro-dashboard-toggles">
						<div class="ui checkbox toggle">
							<input type="checkbox" value="toggle-ai" name="mainwp_seopress_dashboard[google_ai]" class="mainwp-seopress-dashboard-checks" id="seopress-ai" <?php checked( $ai_check, 1 ); ?> data-nonce="<?php echo esc_attr( wp_create_nonce( 'mainwp-seopress-titles-meta-toggle' ) ); ?>">
							<label for="seopress-ai"><?php esc_html_e( 'AI', 'wp-seopress-mainwp' ); ?></label>
							<div>
								<em><?php esc_html_e( 'Use the power of artificial intelligence to increase your productivity.', 'wp-seopress-mainwp' ); ?></em>
							</div>
						</div>
					</div>
					<div class="six wide column mainwp-seopress-pro-dashboard-toggles">
						<div class="ui checkbox toggle">
							<input type="checkbox" value="toggle-inspect-url" name="mainwp_seopress_dashboard[google_inspect_url]" class="mainwp-seopress-dashboard-checks" id="seopress-inspect-url" <?php checked( $inspect_url_check, 1 ); ?> data-nonce="<?php echo esc_attr( wp_create_nonce( 'mainwp-seopress-titles-meta-toggle' ) ); ?>">
							<label for="seopress-inspect-url"><?php esc_html_e( 'Google Search Console', 'wp-seopress-mainwp' ); ?></label>
							<div>
								<em><?php esc_html_e( 'Get clicks, positions, CTR and impressions. Inspect your URL for details about crawling, indexing, mobile compatibility, schemas and more.', 'wp-seopress-mainwp' ); ?></em>
							</div>
						</div>
					</div>
					<div class="six wide column mainwp-seopress-pro-dashboard-toggles">
						<div class="ui checkbox toggle">
							<input type="checkbox" value="toggle-local-business" name="mainwp_seopress_dashboard[local_business]" class="mainwp-seopress-dashboard-checks" id="seopress-local-business" <?php checked( $local_business_check, 1 ); ?> data-nonce="<?php echo esc_attr( wp_create_nonce( 'mainwp-seopress-titles-meta-toggle' ) ); ?>">
							<label for="seopress-local-business"><?php esc_html_e( 'Local Business', 'wp-seopress-mainwp' ); ?></label>
							<div>
								<em><?php esc_html_e( 'Add Google Local Business data type.', 'wp-seopress-mainwp' ); ?></em>
							</div>
						</div>
					</div>
					<div class="six wide column mainwp-seopress-pro-dashboard-toggles">
						<div class="ui checkbox toggle">
							<input type="checkbox" value="toggle-dublin-core" name="mainwp_seopress_dashboard[dublin_core]" class="mainwp-seopress-dashboard-checks" id="seopress-dublin-core" <?php checked( $dublin_core_check, 1 ); ?> data-nonce="<?php echo esc_attr( wp_create_nonce( 'mainwp-seopress-titles-meta-toggle' ) ); ?>">
							<label for="seopress-dublic-core"><?php esc_html_e( 'Dublin Core', 'wp-seopress-mainwp' ); ?></label>
							<div>
								<em><?php esc_html_e( 'Add Dublin Core meta tags.', 'wp-seopress-mainwp' ); ?></em>
							</div>
						</div>
					</div>
					<div class="six wide column mainwp-seopress-pro-dashboard-toggles">
						<div class="ui checkbox toggle">
							<input type="checkbox" value="toggle-rich-snippets" name="mainwp_seopress_dashboard[structured_data_types]" class="mainwp-seopress-dashboard-checks" id="seopress-schemas" <?php checked( $rich_snippets_check, 1 ); ?> data-nonce="<?php echo esc_attr( wp_create_nonce( 'mainwp-seopress-titles-meta-toggle' ) ); ?>">
							<label for="seopress-dublic-core"><?php esc_html_e( 'Schemas', 'wp-seopress-mainwp' ); ?></label>
							<div>
								<em><?php esc_html_e( 'Add data types to your content: articles, courses, recipes, videos, events, products and more.', 'wp-seopress-mainwp' ); ?></em>
							</div>
						</div>
					</div>
					<div class="six wide column mainwp-seopress-pro-dashboard-toggles">
						<div class="ui checkbox toggle">
							<input type="checkbox" value="toggle-breadcrumbs" name="mainwp_seopress_dashboard[breadcrumbs]" class="mainwp-seopress-dashboard-checks" id="seopress-breadcrumbs" <?php checked( $breadcrumbs_check, 1 ); ?> data-nonce="<?php echo esc_attr( wp_create_nonce( 'mainwp-seopress-titles-meta-toggle' ) ); ?>">
							<label for="seopress-breadcrumbs"><?php esc_html_e( 'Breadcrumbs', 'wp-seopress-mainwp' ); ?></label>
							<div>
								<em><?php esc_html_e( 'Enable Breadcrumbs for your theme and improve your SEO in SERPs.', 'wp-seopress-mainwp' ); ?></em>
							</div>
						</div>
					</div>
					<div class="six wide column">
						<div>
							<a href="admin.php?page=Extensions-Seopress-For-Mainwp&tab=seopress-pro-page#mainwp-seopress-pro-pagespeed-insights"><?php esc_html_e( 'Google Page Speed', 'wp-seopress-mainwp' ); ?></a>
							<div>
								<em><?php esc_html_e( 'Track your website performance to improve SEO with Google Page Speed.', 'wp-seopress-mainwp' ); ?></em>
							</div>
						</div>
					</div>
					<div class="six wide column mainwp-seopress-pro-dashboard-toggles">
						<div class="ui checkbox toggle">
							<input type="checkbox" value="toggle-robots" name="mainwp_seopress_dashboard[robots_txt]" class="mainwp-seopress-dashboard-checks" id="seopress-robots-txt" <?php checked( isset( $robots_check ), 1 ); ?> data-nonce="<?php echo esc_attr( wp_create_nonce( 'mainwp-seopress-titles-meta-toggle' ) ); ?>">
							<label for="seopress-robotos-txt"><?php esc_html_e( 'robots.txt', 'wp-seopress-mainwp' ); ?></label>
							<div>
								<em><?php esc_html_e( 'Edit your robots.txt file', 'wp-seopress-mainwp' ); ?></em>
							</div>
						</div>
					</div>
					<div class="six wide column mainwp-seopress-pro-dashboard-toggles">
						<div class="ui checkbox toggle">
							<input type="checkbox" value="toggle-news" name="mainwp_seopress_dashboard[google_news_sitemap]" class="mainwp-seopress-dashboard-checks" id="seopress-google-news-sitemap" <?php checked( $news_check, 1 ); ?> data-nonce="<?php echo esc_attr( wp_create_nonce( 'mainwp-seopress-titles-meta-toggle' ) ); ?>">
							<label for="seopress-google-news-sitemap"><?php esc_html_e( 'Google News Sitemap', 'wp-seopress-mainwp' ); ?></label>
							<div>
								<em><?php esc_html_e( 'Optimize your site for Google News.', 'wp-seopress-mainwp' ); ?></em>
							</div>
						</div>
					</div>
					<div class="six wide column mainwp-seopress-pro-dashboard-toggles">
						<div class="ui checkbox toggle">
							<input type="checkbox" value="toggle-404" name="mainwp_seopress_dashboard[redirections]" class="mainwp-seopress-dashboard-checks" id="seopress-redirections" <?php checked( $redirects_check, 1 ); ?> data-nonce="<?php echo esc_attr( wp_create_nonce( 'mainwp-seopress-titles-meta-toggle' ) ); ?>">
							<label for="seopress-redirections"><?php esc_html_e( 'Redirections', 'wp-seopress-mainwp' ); ?></label>
							<div>
								<em><?php esc_html_e( 'Monitor 404, create 301, 302 and 307 redirections.', 'wp-seopress-mainwp' ); ?></em>
							</div>
						</div>
					</div>
					<div class="six wide column mainwp-seopress-pro-dashboard-toggles">
						<div class="ui checkbox toggle">
							<input type="checkbox" value="toggle-rewrite" name="mainwp_seopress_dashboard[url_rewriting]" class="mainwp-seopress-dashboard-checks" id="seopress-url-rewriting" <?php checked( $rewrite_check, 1 ); ?> data-nonce="<?php echo esc_attr( wp_create_nonce( 'mainwp-seopress-titles-meta-toggle' ) ); ?>">
							<label for="seopress-url-rewriting"><?php esc_html_e( 'URL Rewriting', 'wp-seopress-mainwp' ); ?></label>
							<div>
								<em><?php esc_html_e( 'Customize your permalinks.', 'wp-seopress-mainwp' ); ?></em>
							</div>
						</div>
					</div>
					<div class="six wide column">
						<div>
							<a href="admin.php?page=Extensions-Seopress-For-Mainwp&tab=seopress-pro-page#mainwp-seopress-pro-rss"><?php esc_html_e( 'RSS', 'wp-seopress-mainwp' ); ?></a>
							<div>
								<em><?php esc_html_e( 'Configure default WordPress RSS.', 'wp-seopress-mainwp' ); ?></em>
							</div>
						</div>
					</div>
				<?php endif; ?>
				<div class="six wide column">
					<div>
						<a href="admin.php?page=Extensions-Seopress-For-Mainwp&tab=seopress-import-export"><?php esc_html_e( 'Tools', 'wp-seopress-mainwp' ); ?></a>
						<div>
							<em><?php esc_html_e( 'Import/Export plugin settings from site to site.', 'wp-seopress-mainwp' ); ?></em>
						</div>
					</div>
				</div>
				<?php if ( $is_pro_version_active ) : ?>
					<div class="six wide column">
						<div>
							<a href="admin.php?page=Extensions-Seopress-For-Mainwp&tab=seopress-licence"><?php esc_html_e( 'Licence', 'wp-seopress-mainwp' ); ?></a>
							<div>
								<em><?php esc_html_e( 'Edit your licence key.', 'wp-seopress-mainwp' ); ?></em>
							</div>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>
