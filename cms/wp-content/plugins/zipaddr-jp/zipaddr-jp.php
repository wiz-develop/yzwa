<?php
if( !defined('ABSPATH') ) exit;
/*
Plugin Name: zipaddr-jp
Plugin URI: https://zipaddr2.com/wordpress/
Description: The input convert an address from a zip code automatically.
Version: 1.45
Author: Tatsuro, Terunuma
Author URI: https://pierre-soft.com/
License: GPLv2 or later
*/
define('ZIPADDR_JP_PLUGIN_DIR', plugin_dir_path(__FILE__)); // /myplugin/
define('ZIPADDR_JP_PLUGIN_URL',plugins_url( '', __FILE__));
define('ZIPADDR_JP_VERS',  '1.45');
define('ZIPADDR_JP_KEYS',  'zipaddr-config');
define('ZIPADDR_JP_SYS',   'sys_');
define('ZIPADDR_JP_COM',   'https://zipaddr.com/');
define('ZIPADDR_JP_2COM',  'https://zipaddr2.com/');
define('ZIPADDR_JP_GIT',   'https://zipaddr.github.io/');
define('ZIPADDR_JP_DEFINE','zipaddr_define');
define('ZIPADDR_JP_MEI',   plugin_basename(dirname(__FILE__)));
define('ZIPADDR_JP_FILE1', str_replace("/".ZIPADDR_JP_MEI."/","",ZIPADDR_JP_PLUGIN_DIR)."/zipaddr_define.txt"); //‹Œ
define('ZIPADDR_JP_FILE2', ZIPADDR_JP_PLUGIN_DIR."include/zipaddrjp_define.php"); //V

	$zipaddr_jp_plugin="";
	$zipaddr_jp_keywd= "usces_";
	if( !empty($_SERVER["REQUEST_URI"]) ){
		$zipaddr_jp_wk= trim( sanitize_text_field(wp_unslash($_SERVER["REQUEST_URI"])) );
		$zipaddr_jp_wk= htmlspecialchars($zipaddr_jp_wk, ENT_QUOTES);
		if( strpos($zipaddr_jp_wk,'?page='.$zipaddr_jp_keywd) !== false ) $zipaddr_jp_plugin= $zipaddr_jp_keywd;
	}
	require_once ZIPADDR_JP_PLUGIN_DIR.'include/zipaddrjp_config.php';

if( is_admin() && $zipaddr_jp_plugin == $zipaddr_jp_keywd ){ // welcart
	define( 'ZIPADDR_JP_IDENT', '3');
	require_once ZIPADDR_JP_PLUGIN_DIR.'zipaddr.php';
	add_filter('usces_filter_apply_admin_addressform', 'zipaddr_jp_usces', 99999, 3);// welcart
}
else
if( is_admin() ){                                 // admin
	define( 'ZIPADDR_JP_IDENT', '2');
	require_once ZIPADDR_JP_PLUGIN_DIR.'admin.php';
	add_action('admin_menu', 'zipaddr_admin_menu');
	if( function_exists('register_uninstall_hook') ) {register_uninstall_hook( __FILE__, 'zipaddr_uninstall' );} // uninstallŒÄo‚µ
}
else {                                            // user
	define( 'ZIPADDR_JP_IDENT', '1');
	require_once ZIPADDR_JP_PLUGIN_DIR.'zipaddr.php';
	add_filter('usces_filter_apply_addressform', 'zipaddr_jp_usces', 99999, 3);// welcart
	add_filter('usces_filter_cart_delivery_script','zipaddr_jp_welcart', 99999, 3);// welcart
	add_filter('the_content', 'zipaddr_jp_change', 99999); // html change
}

function zipaddr_jp_usces($formtag,$type,$data) {return zipaddr_jp_change($formtag,"1");}
function zipaddr_jp_welcart($script) {return $script;
	$zipaddr_jp_keywd1="if(delivery_days[selected]";
$addon="
if(typeof Zip.welorder==='function'){
	var wk1= $('#delivery_country').val();
	var wk2= $('#delivery_pref').val();
	if( wk1!='' && wk2!='' ) {delivery_country=wk1; delivery_pref=wk2;}
}
";
	$zipaddr_jp_wk0= strpos($script,$zipaddr_jp_keywd1);
	if( $zipaddr_jp_wk0!==false ) {$script= str_replace($zipaddr_jp_keywd1, $addon.$zipaddr_jp_keywd1, $script);}
	return $script;
}
function zipaddr_uninstall() {delete_option(ZIPADDR_JP_DEFINE);} // uninstallˆ—
?>
