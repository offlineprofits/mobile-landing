<?php
function wpmse_splash_page_redirect() {
	if( wpmse_go_full_site() )
		return;

	global $ta_plugin_ver;
	$body_ver = str_replace('.', '_', $ta_plugin_ver);

	$detect  = new Mobile_Detect();
	$display = wpmse_get_option('wpmse_enable');

	/* We check if the user enabled the plugin */
	if( !is_array($display) || is_array($display) && empty($display) )
		return;
	
	/* If not browsing from a mobile we stop here */
	if( !$detect->isMobile() && !isset($_GET['splash_preview']) )
		return;

	/* We check the plugin activation */
	if( $detect->isTablet() && !in_array('tablets', $display) ) { // On tablets
		return;
	} elseif( !$detect->isTablet() && !in_array('mobiles', $display) ) { // On mobiles
		return;
	}

	$options = get_option( WPMSE_PREFIX.'options', true );

	$style     = get_option( WPMSE_PREFIX.'splash_style', true );
	$content   = get_option( WPMSE_PREFIX.'splash_content', true );
	$title     = get_bloginfo('name');
	$normalize = wpmse_get_base_css();
	$custom    = 'ol,ul,li{list-style:none;margin:0;padding:0}';
	$style 	   = $normalize.$custom.$style;
	if( isset($options['wpmse_analytics']) )
		$analytics = $options['wpmse_analytics'];

	if( wpmse_get_option('icons_pack', 'light') == 'font-awesome' ) {
		$font = '<link rel="stylesheet" id="icons"  href="'.WPMSE_URL.'css/font-awesome.min.css" type="text/css" media="screen" />';
	} else {
		$font = '<link rel="stylesheet" id="icons"  href="'.WPMSE_URL.'css/icons.min.css" type="text/css" media="screen" />';
	}

	header('Content-Type: text/html; charset=utf-8');


	/* Prepare the splash page header */
	echo '
	<!doctype html>
	<html>
	<head>
		<meta charset="utf-8" />
		<title>'.$title.'</title>
		<meta name="author" content="ThemeAvenue.net">
		<meta name="viewport" content="width=device-width,initial-scale=1">
		'.$font.'
		<style>'.stripslashes($style).'</style>';

	/* If Analytics is enabled we retrieve the tracking code */
	if( wpmse_get_option('enable_analytics') == '1' ) {
		if( class_exists( 'GA_Filter' ) ) {
			$yoast_ga = new GA_Filter();
			$options  = get_option( 'Yoast_Google_Analytics' );
			$yoast_ga->spool_analytics();
		} elseif( $analytics && '' != $analytics ) {
			echo $analytics;
		}
	}

	echo '</head>';

	/* Then the content */
	echo '<body class="mobile v_'.$body_ver.'">'.stripslashes($content).'</body></html>';

	/* And now we stop everything else! */
	exit;
}
add_action('init', 'wpmse_splash_page_redirect', 1);

function wpmse_get_base_css() {
	$normalize = 'article,aside,details,figcaption,figure,footer,header,hgroup,main,nav,section,summary{display:block}audio,canvas,video{display:inline-block}audio:not([controls]){display:none;height:0}[hidden]{display:none}html{font-family:sans-serif;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%}body{margin:0}a:focus{outline:thin dotted}a:active,a:hover{outline:0}h1{font-size:2em;margin:.67em 0}abbr[title]{border-bottom:1px dotted}b,strong{font-weight:bold}dfn{font-style:italic}hr{-moz-box-sizing:content-box;box-sizing:content-box;height:0}mark{background:#ff0;color:#000}code,kbd,pre,samp{font-family:monospace,serif;font-size:1em}pre{white-space:pre-wrap}q{quotes:"\201C" "\201D" "\2018" "\2019"}small{font-size:80%}sub,sup{font-size:75%;line-height:0;position:relative;vertical-align:baseline}sup{top:-0.5em}sub{bottom:-0.25em}img{border:0}svg:not(:root){overflow:hidden}figure{margin:0}fieldset{border:1px solid #c0c0c0;margin:0 2px;padding:.35em .625em .75em}legend{border:0;padding:0}button,input,select,textarea{font-family:inherit;font-size:100%;margin:0}button,input{line-height:normal}button,select{text-transform:none}button,html input[type="button"],input[type="reset"],input[type="submit"]{-webkit-appearance:button;cursor:pointer}button[disabled],html input[disabled]{cursor:default}input[type="checkbox"],input[type="radio"]{box-sizing:border-box;padding:0}input[type="search"]{-webkit-appearance:textfield;-moz-box-sizing:content-box;-webkit-box-sizing:content-box;box-sizing:content-box}input[type="search"]::-webkit-search-cancel-button,input[type="search"]::-webkit-search-decoration{-webkit-appearance:none}button::-moz-focus-inner,input::-moz-focus-inner{border:0;padding:0}textarea{overflow:auto;vertical-align:top}table{border-collapse:collapse;border-spacing:0}';

	$buttons = '.clearfix{*zoom:1}.clearfix:before,.clearfix:after{display:table;line-height:0;content:""}.clearfix:after{clear:both}#btn-squared>li>a{float:left;width:50%;height:0;margin:0;padding:50% 0 0 0;border:0;position:relative}#btn-squared>li>a>span{display:block;width:100%;text-align:center;position:absolute;bottom:12px;left:0}#btn-squared>li>a>span>i{display:block;width:100%;position:absolute;top:-100px;left:0;font-size:460%}#btn-text>li>a{background:none!important;border:0;text-decoration:underline;-moz-text-decoration-line:underline;-moz-text-decoration-style:dashed;-moz-text-decoration-color:green;-webkit-text-decoration-line:underline;-webkit-text-decoration-style:dashed;-webkit-text-decoration-color:green;font-size:18px;padding:.5em 1em}#btn-text>li>a i{display:none}#btn-block-rounded>li>a{border-radius:30px}';

	$out = $normalize.$buttons;

	return $out;
}

function wpmse_go_full_site() {
	/* For preview purposes on desktop computer */
	if( isset($_GET['splash_preview']) && $_GET['splash_preview'] == 'true' )
		return false;
	
	/* Let's go to full site and place a cookie */
	if( isset($_GET['fullsite']) ) {
		switch( $_GET['fullsite'] ):
			case 'true':
				$lifetime = wpmse_get_option('cookie_lifetime', '604800');
				setcookie( 'wpmse_fullsite', 'true', time()+$lifetime );
				return true;
			break;
			case 'false':
				setcookie( 'wpmse_fullsite', 'true', time()-1 );
				return false;
			break;
		endswitch;
	} elseif( isset($_COOKIE['wpmse_fullsite']) && $_COOKIE['wpmse_fullsite'] == 'true' ) {
		return true;
	} else {
		return false;
	}
}
?>