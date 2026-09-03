<?php
/**
 * Plugin Name: MW WP Form reCAPTCHA
 * Plugin URI: http://webcre-archive.com
 * Description: Adds reCAPTCHA field to MW WP Form
 * Version: 1.0.7
 * Author: Ryujiro Yamamoto
 * Author URI: http://webcre-archive.com
 * Text Domain: mw-wp-form-recaptcha
 * Domain Path: /languages/
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */

/*********************************************
* Admin Panel
*********************************************/

function mw_wp_form_recaptcha_admin_menu() {
	add_menu_page(
		'MW WP Form reCAPTCHA',
		'MW WP Form reCAPTCHA',
		'manage_options',
		'mw-wp-formrecaptcha',
		'mw_wp_form_recaptcha_admin',
		'dashicons-admin-post',
		58
	);
}
add_action( 'admin_menu', 'mw_wp_form_recaptcha_admin_menu' );

function mw_wp_form_recaptcha_admin() {
?>
<div class="wrap">
<h2>MW WP Form reCAPTCHA</h2>
<?php settings_errors(); ?>

<form id="mw-wp-form-recaptcha-form" method="post" action="">
	<?php wp_nonce_field( 'mw-wp-form-recaptcha-nonce-key', 'mw-wp-form-recaptcha-nonce' ); ?>
	<h3>Site key</h3>
	<p><input type="text" name="mw-wp-form-recaptcha-sitekey" size="50" value="<?php echo esc_attr( get_option( 'mw-wp-form-recaptcha-sitekey' ) ); ?>"><br>
	<a href="https://www.google.com/recaptcha/admin#list" target="_blank"><?php echo __( 'Get the Site key of reCAPTCHA.', 'mw-wp-form-recaptcha' ); ?></a></p>

	<h3>Centering reCAPTCHA</h3>
	<p><input type="checkbox" name="mw-wp-form-recaptcha-centering" <?php checked( get_option( 'mw-wp-form-recaptcha-centering' ), 1 ); ?> value="1"> <?php echo __( 'Centering reCAPTCHA', 'mw-wp-form-recaptcha' ); ?></p>

	<p style="margin-top: 30px;"><input type="submit" value="<?php echo __( 'Save Changes', 'mw-wp-form-recaptcha' ); ?>" class="button button-primary button-large"></p>
</form>

</div>
<?php
}

/* Data Save */
function mw_wp_form_recaptcha_init() {

	load_plugin_textdomain( 'mw-wp-form-recaptcha', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );

	if( isset( $_POST['mw-wp-form-recaptcha-nonce'] ) && $_POST['mw-wp-form-recaptcha-nonce'] ) {
		if( check_admin_referer( 'mw-wp-form-recaptcha-nonce-key', 'mw-wp-form-recaptcha-nonce' ) ) {

			/* mw-wp-form-recaptcha-sitekey */
			if( isset( $_POST['mw-wp-form-recaptcha-sitekey'] ) && $_POST['mw-wp-form-recaptcha-sitekey'] ) {
				update_option( 'mw-wp-form-recaptcha-sitekey', $_POST['mw-wp-form-recaptcha-sitekey'] );
			} else {
				update_option( 'mw-wp-form-recaptcha-sitekey', '' );
			}

			/* mw-wp-form-recaptcha-centering */
			if( isset( $_POST['mw-wp-form-recaptcha-centering'] ) && $_POST['mw-wp-form-recaptcha-centering'] ) {
				update_option( 'mw-wp-form-recaptcha-centering', $_POST['mw-wp-form-recaptcha-centering'] );
			} else {
				update_option( 'mw-wp-form-recaptcha-centering', '' );
			}

			echo '<div class="updated"><ul><li>' . __( 'Settings saved.', 'mw-wp-form-recaptcha' ) . '</li></ul></div>';

			wp_safe_redirect( menu_page_url( 'mw-wp-form-recaptcha-nonce', false ) );
		}
	}
}
add_action( 'admin_init', 'mw_wp_form_recaptcha_init' );


/*********************************************
* Frontend
*********************************************/

function mw_wp_form_recaptcha() {

// sitekeyをDBから取得
$sitekey = esc_attr( get_option( 'mw-wp-form-recaptcha-sitekey' ) );

echo <<<EOT
<script src="//www.google.com/recaptcha/api.js"></script>
<script type="text/javascript">
jQuery(function() {
	// reCAPTCHAの挿入
	jQuery( '.mw_wp_form_input button, .mw_wp_form_input input[type="submit"]' ).before( '<div data-callback="syncerRecaptchaCallback" data-sitekey="
EOT;
echo $sitekey;
echo <<<EOT
" class="g-recaptcha"></div>' );
	// [input] Add disabled to input or button
	jQuery( '.mw_wp_form_input button, .mw_wp_form_input input[type="submit"]' ).attr( "disabled", "disabled" );
	// [confirm] Remove disabled
	jQuery( '.mw_wp_form_confirm input, .mw_wp_form_confirm select, .mw_wp_form_confirm textarea, .mw_wp_form_confirm button' ).removeAttr( 'disabled' );
});
// reCAPTCHA Callback
function syncerRecaptchaCallback( code ) {
	if(code != "") {
		jQuery( '.mw_wp_form_input button, .mw_wp_form_input input[type="submit"]' ).removeAttr( 'disabled' );
	}
}
</script>
<style type="text/css">
.g-recaptcha { margin: 20px 0 15px; }
EOT;
if( get_option( 'mw-wp-form-recaptcha-centering' ) === "1" ) {
	echo '.g-recaptcha > div { margin: 0 auto; }';
}
echo <<<EOT
</style>

EOT;
}
add_action( 'wp_head', 'mw_wp_form_recaptcha' );
?>