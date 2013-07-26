<?php
function wpmse_plugin_options() {
	$options = array(
		array(
			array(
				'id'		=> 'enable_splash_screen',
				'title'		=> __('Enable Splash Screen', 'wpms'),
				'type' 		=> 'switch'
			),
			array(
				'id'		=> 'optimize_perfs',
				'title'		=> __('Enable Performances', 'wpms'),
				'type' 		=> 'switch'
			),
			array(
				'id'		=> 'link_to_main_site',
				'title'		=> __('Add Link to Full Site', 'wpms'),
				'type' 		=> 'switch'
			)
		),
		array(
			array(
				'id'		=> 'featured_image',
				'title'		=> __('Logo or Featured Image', 'wpms'),
				'type' 		=> 'upload',
				'desc' 		=> __('Type-in the URL or upload a new image.', 'wpms'),
			),
			array(
				'id'		=> 'text_font',
				'title'		=> __('Font', 'wpms'),
				'type' 		=> 'font'
			),
			array(
				'id'		=> 'text_alignment',
				'title'		=> __('Content Alignment', 'wpms'),
				'type' 		=> 'alignment'
			),
			array(
				'id'		=> 'catchphrase_color',
				'title'		=> __('Catchphrase Color', 'wpms'),
				'type' 		=> 'colorpicker'
			),
			array(
				'id'		=> 'catchphrase_size',
				'title'		=> __('Catchphrase Size', 'wpms'),
				'type' 		=> 'font-size'
			)
		),
		array(
			array(
				'id'		=> 'bg_color',
				'title'		=> __('Background Color', 'wpms'),
				'type' 		=> 'colorpicker'
			),
			array(
				'id'		=> 'bg_image',
				'title'		=> __('Background Image', 'wpms'),
				'type' 		=> 'upload',
				'desc' 		=> __('Type-in the URL or upload a new image. We recommend <a href="http://subtlepatterns.com" target="_blank">subtlepatterns.com</a>.', 'wpms'),
			)
		),
		array(
			array(
				'id'		=> 'btn_bg_color',
				'title'		=> __('Buttons Background Color', 'wpms'),
				'type' 		=> 'colorpicker'
			),
			array(
				'id'		=> 'btn_font_color',
				'title'		=> __('Buttons Font Color', 'wpms'),
				'type' 		=> 'colorpicker'
			),
			array(
				'id'		=> 'btn_icons',
				'title'		=> __('Display Icons', 'wpms'),
				'type' 		=> 'switch'
			)
		),
		array(
			array(
				'id'		=> 'sn_style',
				'title'		=> __('Social Networks Links Style', 'wpms'),
				'type' 		=> 'switch',
				'labels' 	=> array('squared' => __('Squared', 'wpms'), 'default' => __('Normal', 'wpms')),
				'desc' 		=> __('Do you want to use plain icons?', 'wpms')
			),
			array(
				'id'		=> 'sn_bg_color',
				'title'		=> __('Social Networks Links Color', 'wpms'),
				'type' 		=> 'colorpicker'
			),
			array(
				'id'		=> 'addon_css',
				'title'		=> __('Extra CSS', 'wpms'),
				'type' 		=> 'css_expand'
			)
		)
	);

	$options = apply_filters( 'wpms_edit_plugin_options', $options );

	return $options;
}
?>