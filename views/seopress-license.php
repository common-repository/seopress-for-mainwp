<?php
/**
 * SEOPress License Page
 *
 * @package SEOPress\MainWP
 */
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$licence = get_option( 'seopress_pro_license_key', '' );
?>

<div class="ui segment">
	<div class="ui message" id="mainwp-seopress-message-box" style="display: none;"></div>
	<div class="ui two column stackable left aligned grid">
		<div class="column">
			<h2 class="header"><?php esc_html_e( 'License', 'wp-seopress-mainwp' ); ?></h2>
		</div>
	</div>
	<div class="ui two column stackable left aligned grid">
		<div class="sixteen wide column mainwp-seopress-mainwp-licence-content">
			<div class="ui segment mainwp-seopress-tab-content" id="mainwp-seopress-mainwp-licence">
				<p><?php esc_html_e( 'The license key is used to access automatic updates and support.', 'wp-seopress-mainwp' ); ?></p>
				<div>
					<a href="https://www.seopress.org/account/?utm_source=mainwp_extension&utm_medium=wp-admin-help-tab&utm_campaign=seopress" target="_blank" class="ui button basic green">
						<?php esc_html_e( 'View my account', 'wp-seopress-mainwp' ); ?>
					</a>
					<button type="button" class="ui button basic green" id="seopress_pro_license_reset">
						<?php esc_html_e( 'Reset your license', 'wp-seopress-mainwp' ); ?>
					</button>
				</div>
				<div class="ui info message ignored">
					<p>
						<strong><?php esc_html_e( 'Steps to follow to activate your license:', 'wp-seopress-mainwp' ); ?></strong>
					</p>

					<ol>
						<li><?php esc_html_e( 'Paste your license key', 'wp-seopress-mainwp' ); ?>
						</li>
						<li><?php esc_html_e( 'Select Sites', 'wp-seopress-mainwp' ); ?>
						</li>
						<li><?php esc_html_e( 'Apply Changes', 'wp-seopress-mainwp' ); ?>
						</li>
					</ol>

					<p>
						<?php esc_html_e( 'That\'s it!', 'wp-seopress-mainwp' ); ?>
					</p>

					<p>
						<a class="seopress-help"
							href="https://www.seopress.org/support/guides/activate-seopress-pro-license/?utm_source=mainwp_extension&utm_medium=wp-admin-help-tab&utm_campaign=seopress"
							target="_blank">
							<?php esc_html_e( 'Download unauthorized? - Can‘t activate?', 'wp-seopress-mainwp' ); ?>
						</a>
						<span class="seopress-help dashicons dashicons-external"></span>
					</p>
				</div>
				<form method="post" id="mainwp-seopress-pro-licence-form" class="mainwp-seopress-settings-form">
					<div class="ui form" style="margin-bottom: 10px;">
						<div class="field">
							<label for="mainwp-seopress-pro-licence"><?php esc_html_e( 'Licence Key', 'wp-seopress-mainwp' ); ?></label>
							<input type="text" name="seopress_pro_license_key" autocomplete="off" id="mainwp-seopress-pro-licence" placeholder="<?php esc_attr_e( 'Enter your licence key', 'wp-seopress-mainwp' ); ?>" value="<?php echo esc_attr( $licence ); ?>">
						</div>
					</div>
					<input type="hidden" name="action" value="mainwp_seopress_save_pro_licence">
					<input type="hidden" name="__nonce" value="<?php echo esc_attr( wp_create_nonce( 'mainwp-seopress-save-pro-licence-form' ) ); ?>">
				</form>
			</div>
		</div>
	</div>
</div>
