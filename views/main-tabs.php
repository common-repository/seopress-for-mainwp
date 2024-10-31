<?php
/**
 * Main Tabs
 *
 * @package SEOPress\MainWP
 */
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div class="ui labeled icon inverted menu mainwp-sub-submenu" id="mainwp-advanced-uptime-monitor-menu">

	<a href="<?php echo add_query_arg(['page' => 'Extensions-Seopress-For-Mainwp', 'tab' => 'seopress-dashboard'], admin_url('admin.php')); ?>" class="item <?php echo ( 'seopress-dashboard' === $this->current_tab ? 'active' : '' ); ?>"><i class="dashboard icon"></i> <?php esc_html_e( 'Dashboard', 'wp-seopress-mainwp' ); ?></a>
	<a href="<?php echo add_query_arg(['page' => 'Extensions-Seopress-For-Mainwp', 'tab' => 'seopress-titles'], admin_url('admin.php')); ?>" class="item <?php echo ( 'seopress-titles' === $this->current_tab ? 'active' : '' ); ?>"><i class="heading icon"></i> <?php esc_html_e( 'Titles & Metas', 'wp-seopress-mainwp' ); ?></a>
	<a href="<?php echo add_query_arg(['page' => 'Extensions-Seopress-For-Mainwp', 'tab' => 'seopress-xml-sitemap'], admin_url('admin.php')); ?>" class="item <?php echo ( 'seopress-xml-sitemap' === $this->current_tab ? 'active' : '' ); ?>"><i class="sitemap icon"></i> <?php esc_html_e( 'XML - HTML Sitemap', 'wp-seopress-mainwp' ); ?></a>
	<a href="<?php echo add_query_arg(['page' => 'Extensions-Seopress-For-Mainwp', 'tab' => 'seopress-social'], admin_url('admin.php')); ?>" class="item <?php echo ( 'seopress-social' === $this->current_tab ? 'active' : '' ); ?>"><i class="globe icon"></i> <?php esc_html_e( 'Social Networks', 'wp-seopress-mainwp' ); ?></a>
	<a href="<?php echo add_query_arg(['page' => 'Extensions-Seopress-For-Mainwp', 'tab' => 'seopress-google-analytics'], admin_url('admin.php')); ?>" class="item <?php echo ( 'seopress-google-analytics' === $this->current_tab ? 'active' : '' ); ?>"><i class="chartline icon"></i> <?php esc_html_e( 'Analytics', 'wp-seopress-mainwp' ); ?></a>
	<a href="<?php echo add_query_arg(['page' => 'Extensions-Seopress-For-Mainwp', 'tab' => 'seopress-instant-indexing'], admin_url('admin.php')); ?>" class="item <?php echo ( 'seopress-instant-indexing' === $this->current_tab ? 'active' : '' ); ?>"><i class="search icon"></i> <?php esc_html_e( 'Instant Indexing', 'wp-seopress-mainwp' ); ?></a>
	<a href="<?php echo add_query_arg(['page' => 'Extensions-Seopress-For-Mainwp', 'tab' => 'seopress-advanced'], admin_url('admin.php')); ?>" class="item <?php echo ( 'seopress-advanced' === $this->current_tab ? 'active' : '' ); ?>"><i class="expand arrows alternate icon"></i> <?php esc_html_e( 'Advanced', 'wp-seopress-mainwp' ); ?></a>
	<a href="<?php echo add_query_arg(['page' => 'Extensions-Seopress-For-Mainwp', 'tab' => 'seopress-import-export'], admin_url('admin.php')); ?>" class="item <?php echo ( 'seopress-import-export' === $this->current_tab ? 'active' : '' ); ?>"><i class="cog icon"></i> <?php esc_html_e( 'Tools', 'wp-seopress-mainwp' ); ?></a>
	<?php if ( $is_pro_version_active ) : ?>
		<a href="<?php echo add_query_arg(['page' => 'Extensions-Seopress-For-Mainwp', 'tab' => 'seopress-pro-page'], admin_url('admin.php')); ?>" class="item <?php echo ( 'seopress-pro-page' === $this->current_tab ? 'active' : '' ); ?>"><i class="upload icon"></i> <?php esc_html_e( 'PRO', 'wp-seopress-mainwp' ); ?></a>
		<a href="<?php echo add_query_arg(['page' => 'Extensions-Seopress-For-Mainwp', 'tab' => 'seopress-license'], admin_url('admin.php')); ?>" class="item <?php echo ( 'seopress-license' === $this->current_tab ? 'active' : '' ); ?>"><i class="id badge icon"></i> <?php esc_html_e( 'License', 'wp-seopress-mainwp' ); ?></a>
	<?php endif; ?>
</div>
<div class="ui segment">
	<div class="ui message info">
		<?php
			$current_site = get_option( 'mainwp_seopress_current_site_settings', array() );

			$site_url = ! empty( $current_site ) ? $current_site['url'] : get_site_url();

			printf(
				'%s <strong>%s.</strong> %s',
				esc_html__( 'Current settings are loaded from', 'wp-seopress-mainwp' ),
				$site_url,
				esc_html__( 'If there are changes made directly on that site, you need to re-load the new settings using the "Load Settings" button.', 'wp-seopress-mainwp')
			);
		?>
	</div>
</div>
