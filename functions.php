<?php
add_action('admin_init', 'wpmse_save_options');
function wpmse_save_options() {
	if( !isset($_POST['wpmse_options']) )
		return false;

	/* First we save individual options */
	update_option( WPMSE_PREFIX.'options', $_POST['wpmse_options'] );
	/* Then content and style separately */
	update_option( WPMSE_PREFIX.'splash_content', $_POST['wpmse_splash_content'] );
	update_option( WPMSE_PREFIX.'splash_style', $_POST['wpmse_splash_style'] );

	/* Reed-only redirect */
	wp_redirect( home_url().'/wp-admin/admin.php?page=wpms-dashboard&message=1', 302 );
}

add_action('admin_print_styles', 'wpmse_display_custom_style');
function wpmse_display_custom_style() {
	$style 	 = get_option( WPMSE_PREFIX.'splash_style', true );

	if( '' == $style )
		return;

	echo '<style type="text/css" title="live_preview">'.stripslashes($style).'</style>';
}

add_action('admin_head', 'wpmse_add_viewport');
function wpmse_add_viewport() {
	echo '<meta name="viewport" content="width=device-width">';
}

/* -----------------------------------------
* Add jQuery object with theme options
----------------------------------------- */
add_action('wp_print_scripts', 'wpmse_pass_options_to_script');
function wpmse_pass_options_to_script() {
	$vars = get_option( WPMSE_PREFIX.'options', false );

	if( !$vars )
		return;

	$vars = maybe_unserialize( $vars );

	$var = '
	<script type="text/javascript">var splash = {';

	foreach( $vars as $key => $value ) {
		$var .= '"'.$key.'":"'.$value.'",';
	}
	
	$var .= '}</script>';

	echo $var;
}

add_action('admin_head', 'wpmse_ask_to_rate_plugin');
function wpmse_ask_to_rate_plugin() {
	/* Cancel reting invite */
	if( isset($_GET['rate']) && $_GET['rate'] == 'yes' ) {
		$rated_option = WPMSE_PREFIX.'rated';
		update_option( $rated_option, 'rated' );
		wp_redirect( home_url().'/wp-admin/admin.php?page=wpms-dashboard', 302 );
	}

	/* Asking user to rate theme on TF */
	$opt 		= WPMSE_PREFIX.'rated';
	$rated 		= get_option( $opt, true );
	$setup_date = get_option(WPMSE_PREFIX.'first_setup_date', true);
	$setup_date = strtotime( $setup_date );
	$limit 		= strtotime('+10 days', $setup_date);
	if( strtotime('now') > $limit && isset($_GET['page']) && $_GET['page'] == 'wpms-dashboard' ) {
		if( $rated == 'pending' ) {
			?><div id="wpas_rated" class="updated fade"><p><?php printf(__('Dear WordPress user! Once again we\'re proud that you chose <strong>%s</strong> as your support plugin! You\'ve now been using it for a few days and we would love you to rate it on Codecanyon! If you feel like doing it now, <a href="%s" target="_blank">sign in your Codecanyon account</a> ;) &mdash; <em><a href="%s/wp-admin/admin.php?page=wpms-dashboard&amp;rate=yes">I did it already, don\'t bug me</a></em>', 'n2cpanel'), WPMSE_NAME, 'https://account.envato.com/sign_in?to=codecanyon', home_url()); ?></p></div><?php
		}
	}
}

function wpmse_get_option( $value, $default = false ) {
	$options = get_option( WPMSE_PREFIX.'options', false );
	$options = maybe_unserialize( $options );
	if( isset($options[$value]) )
		return $options[$value];
	else
		return $default;
}

function wpmse_update_content() {
	$do_update = get_option( WPMSE_PREFIX.'update_content', false );

	if( !$do_update )
		return;

	add_action( 'admin_head', 'wpas_content_update_script' );
	add_action( 'admin_notices', 'wpas_plugin_updated_notice' );
	delete_option( WPMSE_PREFIX.'update_content' );
}

function wpas_plugin_updated_notice() { ?>
    <div class="updated">
        <p><?php _e( 'Please wait while we finish updating the plugin.', 'wpas' ); ?></p>
    </div>
<?php }

function wpas_content_update_script() { ?>
	<script type="text/javascript">
	jQuery(window).load(function() {
		jQuery('#mse').hide();
		jQuery('#mse_update').show();

		// Update the markup
		jQuery('.mse_buttons').wrap('<div class="clearfix mse_buttons_wrapper"></div>');
		jQuery('.mse_buttons > li > a').wrapInner('<span></span>');
		jQuery('.mse_buttons > li > a > span').append('<i class="none"></i>');

		setTimeout(function(){
			jQuery('#mse_submit').click();
		}, 8000);
	});
	</script>
<?php }

add_filter( 'wpmse_add_new_social_network', 'wpmse_add_new_network' );
function wpmse_add_new_network( $networks ) {
    $networks[] = array(
        'network' => 'My Network',
        'icon'       => 'icon-github'
    );

    return $networks;
}
?>