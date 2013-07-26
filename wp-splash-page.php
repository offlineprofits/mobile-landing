<?php
/*
Plugin Name: WP Mobile Landing Page Editor
Plugin URI: http://wpfrogs.com/plugins
Description: WP Mobile Splash Page Editor allows you to easily create a mobile splash page for your website. Not every business need a mobile or responsive site, sometimes a well designed splash page with all the key information is the best way to get more leads.
Version: 1.1.1
Author: wpfrogs.com
Author URI: http://wpfrogs.com/
License: GPL2
*/
require_once('MSE_PLE_Client_Util.php');
define( 'WPMSE_VERSION', '1.1.1' );
define( 'WPMSE_NAME', 'WP Mobile Splash Page' );
define( 'WPMSE_URL', plugin_dir_url( __FILE__ ) );
define( 'WPMSE_PATH', plugin_dir_path( __FILE__ ) );
define( 'WPMSE_PREFIX', 'wpmse_' );

$ta_plugin_ver = WPMSE_VERSION;

/* Prepare the translation */
load_plugin_textdomain( 'wpmse', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

/* We load the Mobile_Detect class */
if( !is_admin() ) {
	if( !class_exists('Mobile_Detect') ) {
		require_once(WPMSE_PATH.'/includes/Mobile_Detect.php');
	}
	require(WPMSE_PATH.'/redirect-to-splash.php');
}

/* Add the menu item */
add_action( 'admin_menu', 'wpmse_display_dashboard' );
function wpmse_display_dashboard() {
	add_menu_page( __('WP Mobile Splash Page Editor', 'wpms'), __('Splash Page', 'wpms'), 'edit_posts', 'wpms-dashboard', 'mobile_activate', WPMSE_URL.'images/icon.png' );
}
function mobile_activate() {
	$activation = new MSE_PLE_Client_Util();
	$activation->init('mse_pfx_','Mobile Splash Editor');
	$activation->preCheckLicense();
	if($activation->hasLicense()) {
		wpmse_dashboard_content();
	}
}

/* Call setup file */
require(WPMSE_PATH.'functions.php');
require(WPMSE_PATH.'install.php');

/* Call required files if needed */
if( !is_admin() || is_admin() && isset($_GET['page']) && $_GET['page'] == 'wpms-dashboard' ) {
	require(WPMSE_PATH.'includes/debug.php');
	require(WPMSE_PATH.'includes/resources.php');
	require(WPMSE_PATH.'includes/options.php');
	require(WPMSE_PATH.'includes/listings.php');
	require(WPMSE_PATH.'includes/dashboard.php');
	require(WPMSE_PATH.'includes/presstrends.php');

	/* -----------------------------------------
	* Add jQuery object with current theme path
	----------------------------------------- */
	add_action('wp_print_scripts', 'wpmse_add_theme_vars');
	function wpmse_add_theme_vars() {
		$var = '
		<script type="text/javascript">var bloginfo = {"homeUrl":"'.home_url().'","templatePath":"'.get_stylesheet_directory_uri().'"}</script>';

		echo $var;
	}
}
register_deactivation_hook( __FILE__ ,'deactivate_plugin');
function deactivate_plugin() {

	$activation = new MSE_PLE_Client_Util();
	$activation->init('mse_pfx_','Mobile Splash Editor');
	$activation->onPluginDeactivate();	
}
?>
