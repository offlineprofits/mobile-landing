<?php
/* Check WordPress version */
if( !function_exists('wp_enqueue_media') )
	wp_die( __('This plugin requires functions available in WordPress 3.5+. Please update your site before using this plugin.', 'wpmse'), __('WordPress Version Outdated', 'wpmse'), array('back_link' => true) );
	
add_action('admin_print_styles', 'wpms_load_styles');
function wpms_load_styles() {
	wp_enqueue_style( 'wpmse', WPMSE_URL.'css/mse.css', '', NULL, 'screen' );
	/* Load the icon pack */
	if( wpmse_get_option('icons_pack', 'light') == 'font-awesome' ) {
		wp_enqueue_style( 'font-awesome', WPMSE_URL.'css/font-awesome.min.css', '', false, 'screen' );
	} else {
		wp_enqueue_style( 'wpmse-icons', WPMSE_URL.'css/icons.min.css', '', NULL, 'screen' );
	}
	wp_enqueue_style( 'wpmse-bootstrap', WPMSE_URL.'css/bootstrap.min.css', '', NULL, 'screen' );
	wp_enqueue_style( 'wpmse-select2', WPMSE_URL.'js/select2/select2.css', '', NULL, 'screen' );

	if( !wp_style_is( 'jquery-ui' ) )
		wp_enqueue_style( 'jquery-ui', 'http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css', '', NULL, 'screen' );

	wp_enqueue_style( 'wp-color-picker' );
}

add_action('admin_print_scripts', 'wpms_load_scripts');
function wpms_load_scripts() {
	wp_enqueue_script( 'wpmse-bootstrap', WPMSE_URL.'js/bootstrap.min.js', '', NULL, true );
	wp_enqueue_script( 'wpmse-enquire', WPMSE_URL.'js/enquire.min.js', '', NULL, true );

	if( !wp_script_is( 'jquery-ui' ) )
		wp_enqueue_script( 'jquery-ui', 'http://code.jquery.com/ui/1.10.2/jquery-ui.js', '', '1.10.2', true );

	wp_enqueue_media();
	wp_enqueue_script( 'wpmse-select2', WPMSE_URL.'js/select2/select2.min.js', '', NULL, true );
	wp_enqueue_script( 'wpmse-main', WPMSE_URL.'js/main.js', '', NULL, true );
	wp_enqueue_script( 'wp-color-picker' );
}
?>