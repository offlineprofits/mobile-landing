<?php
if( isset($_GET['activate']) && $_GET['activate'] == 'true') {
	add_action( 'init', 'wpmse_update_version', 1 );
	add_action( 'init', 'wpmse_save_default_options', 2 );
}

function wpmse_save_default_options() {
	/* Define options */
	$setup_date 		= date ( 'Y-m-d H:i:s' );
	$wpas_rated 		= WPMSE_PREFIX.'rated';
	$wpas_first_setup 	= WPMSE_PREFIX.'first_setup_date';
	$wpas_setup 		= WPMSE_PREFIX.'latest_setup_date';
	$wpas_version 		= WPMSE_PREFIX.'version';

	/* Check DB */
	$rated 				= get_option( WPMSE_PREFIX.'rated', false );
	$first_setup 		= get_option( WPMSE_PREFIX.'first_setup_date', false );
	$version 			= get_option( WPMSE_PREFIX.'version', false );

	if( !$rated ) { update_option( $wpas_rated, 'pending' ); }
	if( !$first_setup ) { update_option( $wpas_first_setup, $setup_date ); }
	if( !$wpas_version ) { update_option( $wpas_version, WPMSE_VERSION ); }
	update_option( $wpas_setup, $setup_date );

	/* Default plugin values */
	$html = '<img src=\"http://placehold.it/300x120\" class=\"featured\"><div class=\"tagline\">This is your tagline. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.</div><div class=\"clearfix mse_buttons_wrapper\"><ul class=\"mse_buttons ui-sortable\"><li><a rel=\"editor\" class=\"btn\" href=\"tel:+01234567890\" data-type="phone"><span>Click To Call: +01234567890<i class=\"icon-phone\"></i></span></a></li><li><a rel=\"editor\" class=\"btn\" href=\"mailto:mail@example.com\" data-type="email"><span>Or Click To Email Us<i class=\"icon-envelope-alt\"></i></span></a></li><li><a rel=\"editor\" class=\"btn\" href=\"http://goo.gl/maps/hXAM5\" data-type="link"><span>Click to Get Directions<i class=\"icon-map-marker\"></i></span></a></li></ul></div><ul class=\"mse_social ui-sortable\"><li><a rel=\"editor\" class=\"btn-social\" href=\"https://www.facebook.com/pages/ThemeAvenue/461448310549015\"><i class=\"icon-facebook\"></i></a></li><li><a rel=\"editor\" class=\"btn-social\" href=\"https://twitter.com/theme_avenue\"><i class=\"icon-twitter\"></i></a></li><li><a rel=\"editor\" class=\"btn-social\" href=\"https://linkedin.com/company/themeavenue\"><i class=\"icon-linkedin\"></i></a></li></ul>';
	
	$css  = '.mobile{font-family:georgia, sans-serif;padding:1em;background:#f9f9f9;background-image:none;background-repeat:repeat;background-position:0 0;text-align:center}.mobile img.featured{max-width:100%;height:auto;width:auto;-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box}.mobile .aligncenter{display:block;margin-left:auto;margin-right:auto}.mobile .tagline,.tagline_edit{margin:1.5em 0;color:#111111;font-size:18px;line-height:24px;margin:2em 0}.mobile .btn{display:block;padding:1em;margin:.5em auto;border:1px solid #ddd;background-color:#8cb955;color:#ffffff;text-decoration:none}.mobile .btn:last-child{margin-bottom:0}.mobile .btn.align-left i{float:right}.mobile .btn.align-right i{float:left}.mobile .btn i{float:right;font-size:18px}.mse_social{margin-top:2em}.mse_social li{display:inline-block}.mse_social a{color:#666666;font-size:250%;text-decoration:none}';
	
	$opts = 'a:17:{s:12:"wpmse_enable";a:1:{i:0;s:7:"mobiles";}s:8:"fullsite";s:1:"0";s:12:"featured_img";s:27:"http://placehold.it/300x120";s:4:"font";s:19:"georgia, sans-serif";s:9:"alignment";s:6:"center";s:17:"catchphrase_color";s:7:"#111111";s:16:"catchphrase_size";s:2:"18";s:8:"bg_color";s:7:"#f9f9f9";s:18:"background_pattern";s:0:"";s:9:"bg_repeat";s:6:"repeat";s:11:"bg_position";s:0:"";s:12:"btn_bg_color";s:7:"#8cb955";s:14:"btn_font_color";s:7:"#ffffff";s:12:"social_style";s:1:"0";s:15:"social_bg_color";s:7:"#666666";s:9:"extra_css";s:0:"";s:16:"enable_analytics";s:1:"0";}';

	if( !get_option( WPMSE_PREFIX.'splash_content', false ) ) {
		update_option( WPMSE_PREFIX.'splash_content', $html );
	}

	if( !get_option( WPMSE_PREFIX.'splash_style', false ) ) {
		update_option( WPMSE_PREFIX.'splash_style', $css );
	}

	if( !get_option( WPMSE_PREFIX.'options', false ) ) {
		update_option( WPMSE_PREFIX.'options', $opts );
	}
}

function wpmse_update_version() {
	$version = get_option( WPMSE_PREFIX.'version', false );
	$options = get_option( WPMSE_PREFIX.'options', false );
	$options = maybe_unserialize( $options );
	$setup   = get_option( WPMSE_PREFIX.'first_setup_date', false );

	if( !$version ) {
		/* Update from 1.0.1 to 1.1.0 */
		if( WPMSE_VERSION == '1.1.0' && $setup ) {
			$enable = wpmse_get_option('wpmse_enable');
			if( $enable == '1') {
				$enable = array('mobiles');
			} else {
				$enable = array();
			}

			/* Add the new options values */
			$options['wpmse_enable'] 	 = $enable;
			$options['enable_analytics'] = 0;
			$options['analytics'] 		 = '';
			$options['button_style']	 = 'btn-block';
			$options['cookie_lifetime']	 = '2592000';
			$options['wpmse_editor_mode'] = '0';

			update_option( WPMSE_PREFIX.'options', serialize($options) );
			update_option( WPMSE_PREFIX.'version', WPMSE_VERSION );
			update_option( WPMSE_PREFIX.'update_content', 'true' );
		}
	}
}