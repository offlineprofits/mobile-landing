<?php
//if uninstall not called from WordPress exit
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) )
	exit();

define( 'WPMSE_PREFIX', 'wpmse_' );

delete_option( WPMSE_PREFIX.'rated' );
delete_option( WPMSE_PREFIX.'first_setup_date' );
delete_option( WPMSE_PREFIX.'latest_setup_date' );
delete_option( WPMSE_PREFIX.'splash_content' );
delete_option( WPMSE_PREFIX.'splash_style' );
delete_option( WPMSE_PREFIX.'options' );
delete_option( WPMSE_PREFIX.'version' );
?>