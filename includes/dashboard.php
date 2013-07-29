<?php
add_action('admin_init', 'wpmse_update_content');
function wpmse_dashboard_content() {
	$content = stripslashes(get_option( WPMSE_PREFIX.'splash_content', false ));
	$fonts   = wpmse_fonts_list();
	$social  = wpmse_social_networks();
	

?>
<!--<a href="<?php echo home_url(); ?>/?splash_preview=true&amp;nonce=<?php echo wp_create_nonce( 'splash_preview' ); ?>" target="_blank"><?php _e('Preview Splash Page', 'wpmse'); ?></a>-->
<div id="mse_update" class="updated below-h2">
	<h2>Updating the awesome!</h2>
	<img src="<?php echo WPMSE_URL; ?>/images/loading-update.gif" alt="Loading...">
	<p>Please be patient. The update process should not take longer than 15 seconds.</p>
</div>
<div id="mse" class="wrap">
	
	<div id="icon-options-general" class="icon32"></div>
	<h2><?php _e('WP Mobile Splash Page Editor', 'wpmse'); ?> <span>v.<?php echo WPMSE_VERSION; ?></span></h2>

	<?php if( isset($_GET['message']) ): ?>
	<div id="setting-error-settings_updated" class="updated settings-error">
		<?php if( $_GET['message'] == '1' ): ?><p><?php _e('Settings updated.', 'wpmse'); ?></p><?php endif; ?>
	</div>
	<?php endif; ?>

	<div id="top_buttons">
		<a id="toggle_advanced" class="button-secondary" href="#" title="<?php _e( 'Show Advanced Options' ); ?>"><?php _e( 'Show Advanced Options' ); ?></a>
	</div>
	
	<div id="poststuff">

		<div id="post-body" class="metabox-holder columns-2 mse_metabox-holder">

			<!-- main content -->
			<div id="post-body-content" class="mse_post-body-content">
				
				<div class="meta-box-sortables ui-sortable">
					
					<div class="postbox" id="first">

						<h3><span><?php _e('Style Options', 'wpmse'); ?></span></h3>
						<div class="inside">
							<div id="mse_preview">
								<div class="mse_loading"><?php _e('Loading', 'wpmse'); ?></div>
								<div class="mse_viewport mobile"><?php echo $content; ?></div>
							</div>

							<div id="popover_content_wrapper" class="hidden">
								<div id="popover_content">
									<div class="input_row">
										<label for="mse_btn_anchor"><?php _e('Link Anchor', 'wpmse'); ?></label>
										<input name="wpmse_options[link_anchor]" id="mse_btn_anchor" type="text" value="" class="large-text" /></td>
									</div>
									<div class="input_row">
										<label for="mse_btn_target"><?php _e('URL', 'wpmse'); ?></label>
										<input name="wpmse_options[link_url]" id="mse_btn_target" type="text" value="" class="large-text" />
									</div>
									<div class="input_row">
										<label for="mse_btn_type"><?php _e('Button Type', 'wpmse'); ?></label>
										<select name="" id="mse_btn_type" class="input-block-level">
											<option value="" selected="selected" disabled=""><?php _e('Select Button Type', 'wpmse') ?></option>
											<option value="link"><?php _e('Link', 'wpmse') ?></option>
											<option value="email"><?php _e('Email', 'wpmse') ?></option>
											<option value="phone"><?php _e('Phone', 'wpmse') ?></option>
											<option value="sms"><?php _e('SMS', 'wpmse') ?></option>
										</select>
									</div>
									<div class="input_row" id="wpmse_btnicons">
										<label for="mse_btn_icon"><?php _e('Button Icon', 'wpmse'); ?></label>
										<select name="" id="mse_btn_icon" class="input-block-level">
											<?php if( wpmse_get_option('icons_pack', 'light') == 'light' ):
												$icons = wpmse_icons_list();
												foreach( $icons as $icon ) {
													?><option value="<?php echo $icon['icon']; ?>" <?php if( $icon['icon'] == 'none' ): ?>selected="selected"<?php endif; ?>><?php echo $icon['label']; ?></option><?php
												}
											else:
												$icons = wpmse_font_awesome_icons();
												foreach( $icons as $icon ) {
													$lbl = str_replace('icon-', '', $icon);
													?><option value="<?php echo $icon; ?>" <?php if( $icon == 'none' ): ?>selected="selected"<?php endif; ?>><?php echo ucwords($lbl); ?></option><?php
												}
											endif; ?>
										</select>
									</div>
									<div class="input_row">
										<label for="mse_btn_bgcolor"><?php _e('Button Background Color', 'wpmse'); ?></label>
										<input id="mse_btn_bgcolor" type="text" style="width: 180px;">
									</div>
									<div class="input_row" id="btn-squared-on">
										<label><?php _e('Button Position', 'wpmse'); ?></label>
										<a class="button-secondary mse_up" href="#">&uarr; <?php _e('Move Up', 'wpmse'); ?></a>
										<a class="button-secondary mse_down" href="#">&darr; <?php _e('Move Down', 'wpmse'); ?></a>
									</div>
									<div class="submit_row">
										<a class="button-primary" href="#" id="mse_save"><?php _e( 'Save' ); ?></a>
										<a class="button-secondary" href="#" id="mse_delete"><?php _e( 'Delete' ); ?></a>
									</div>
								</div>
							</div>

							<div id="mse_social_popover_wrapper" class="hidden">
								<div id="popover_content">
									<label for="tablecell"><?php _e('URL', 'wpmse'); ?></label>
									<input name="wpmse_options[link_target]" id="mse_btn_target" type="text" value="" class="large-text" />
									<a class="button-primary" href="#" id="mse_save"><?php _e( 'Save' ); ?></a>
									<a class="button-secondary" href="#" id="mse_delete"><?php _e( 'Delete' ); ?></i></a>
								</div>
							</div>
          
					        <form action="<?php echo home_url(); ?>/wp-admin/admin.php?page=wpms-dashboard" method="post">
					        	<table class="form-table">
									<tr valign="top">
										<th scope="row">
											<label for="mse_enable"><?php _e('Enable Splash Screen For', 'wpmse');?> :</label>
										</th>
										<td>
											<input type="checkbox" name="wpmse_options[wpmse_enable][]" id="mse_enable_mobiles" value="mobiles" <?php if( is_array(wpmse_get_option('wpmse_enable')) && in_array('mobiles', wpmse_get_option('wpmse_enable')) ): ?>checked="checked"<?php endif; ?> /> <?php _e('Mobiles', 'wpmse'); ?>
											<input type="checkbox" name="wpmse_options[wpmse_enable][]" id="mse_enable_tablets" value="tablets" <?php if( is_array(wpmse_get_option('wpmse_enable')) && in_array('tablets', wpmse_get_option('wpmse_enable')) ): ?>checked="checked"<?php endif; ?> /> <?php _e('Tablets', 'wpmse'); ?>
										</td>
									</tr>
									<tr valign="top">
										<th scope="row">
											<label><?php _e('Enable Link to Full Site', 'wpmse');?> :</label>
										</th>
										<td class="mse_switch">
											<input type="radio" id="mse_fullsite_yes" name="wpmse_options[fullsite]" value="1" <?php if( wpmse_get_option('fullsite') == 1 ): ?>checked="checked"<?php endif; ?>/>
											<input type="radio" id="mse_fullsite_no" name="wpmse_options[fullsite]" value="0" <?php if( wpmse_get_option('fullsite') == 0 ): ?>checked="checked"<?php endif; ?> />
											<label for="mse_fullsite_yes" class="cb-enable <?php if( wpmse_get_option('fullsite') == 1 ): ?>selected<?php endif; ?>"><span><?php _e('Enable', 'wpmse');?></span></label>
											<label for="mse_fullsite_no" class="cb-disable <?php if( wpmse_get_option('fullsite') == 0 ): ?>selected<?php endif; ?>"><span><?php _e('Disable', 'wpmse');?></span></label>
										</td>
									</tr>
									</tr>
									<tr valign="top" class="mse_section">
										<th scope="row">
											<label for="mse_featured_img"><?php _e('Logo or Featured Image', 'wpmse');?> :</label>
										</th>
										<td>
											<label for="mse_featured_img">
												<input id="mse_featured_img" size="36" name="wpmse_options[featured_img]" type="url" class="medium-text" value="<?php echo wpmse_get_option('featured_img'); ?>" /> 
												<input id="mse_featured_img_upload" value="Upload Image" class="button n2_file_upload" type="button" />
												<br /><span class="description"><?php printf(__('Type-in image URL or upload a now one. You can use Data URI <a href="%s" target="_blank">duri.me</a> to improve PageSpeed.', 'wpmse'), 'http://duri.me/');?></span>
											</label>
										</td>
									</tr>
									<tr valign="top">
										<th scope="row">
											<label for="css_ss"><?php _e('Font', 'wpmse');?> :</label>
										</th>
										<td>
											<?php _e('Here is a list of mobile compliant fonts:', 'wpmse');?>
											<fieldset>
												<?php
												foreach( $fonts as $font ) { ?>
													<label>
														<input type="radio" name="wpmse_options[font]" value='<?php echo $font['value']; ?>' class="mse_font" <?php if( stripslashes(wpmse_get_option('font')) == $font['value'] ): ?>checked="checked"<?php endif; ?>/> 
														<span style='font-family: <?php echo $font['family']; ?>'><?php echo $font['name']; ?></span>
													</label><br />
												<?php }
												?>
											</fieldset>
										</td>
									</tr>
									<tr valign="top">
										<th scope="row">
											<label for="mse_align"><?php _e('Content Alignment', 'wpmse');?> :</label>
										</th>
										<td>
											<ul id="mse_align_list">
												<li><a href="#" class="button-<?php if( wpmse_get_option('alignment') == 'left'): ?>primary<?php else: ?>secondary<?php endif; ?>" title="Left" data-alignement="left"><span class="mce_justifyleft"></span></a></li>
												<li><a href="#" class="button-<?php if( wpmse_get_option('alignment') == 'center'): ?>primary<?php else: ?>secondary<?php endif; ?>" title="Center" data-alignement="center"><span class="mce_justifycenter"></span></a></li>
												<li><a href="#" class="button-<?php if( wpmse_get_option('alignment') == 'right'): ?>primary<?php else: ?>secondary<?php endif; ?>" title="Right" data-alignement="right"><span class="mce_justifyright"></span></a></li>
												<li><a href="#" class="button-<?php if( wpmse_get_option('alignment') == 'justify'): ?>primary<?php else: ?>secondary<?php endif; ?>" title="Justify" data-alignement="justify"><span class="mce_justifyfull"></span></a></li>
											</ul>
											<input type="hidden" id="mse_align" name="wpmse_options[alignment]" value="<?php echo wpmse_get_option('alignment'); ?>">
										</td>
									</tr>
									<tr valign="top">
										<th scope="row">
											<label for="mse_tagline_color"><?php _e('Catchphrase Color', 'wpmse');?> :</label>
										</th>
										<td>
											<input id="mse_tagline_color" type="text" value="<?php echo wpmse_get_option('catchphrase_color'); ?>" class="wpas_colorpicker" data-default-color="#111" name="wpmse_options[catchphrase_color]" />
										</td>
									</tr>
									<tr valign="top">
										<th scope="row">
											<label for="mse_tagline_size"><?php _e('Catchphrase Size', 'wpmse');?> :</label>
										</th>
										<td>
											<input id="mse_tagline_size" type="range" value="<?php echo wpmse_get_option('catchphrase_size'); ?>" max="24" min="10" step="2" onchange="mse_tagline_size_value.value=value" name="wpmse_options[catchphrase_size]"></input>
											<output id="mse_tagline_size_value"><?php echo wpmse_get_option('catchphrase_size'); ?></output>
										</td>
									</tr>
									<tr valign="top" class="mse_section">
										<th scope="row">
											<label for="mse_background_color"><?php _e('Background Color', 'wpmse');?> :</label>
										</th>
										<td>
											<input id="mse_background_color" type="text" value="<?php echo wpmse_get_option('bg_color'); ?>" class="wpas_colorpicker" data-default-color="#F9F9F9" name="wpmse_options[bg_color]" />
										</td>
									</tr>
									<tr valign="top">
										<th scope="row">
											<label for="mse_background_pattern"><?php _e('Background Image', 'wpmse');?> :</label>
										</th>
										<td>
											<label for="mse_background_pattern">
												<input id="mse_background_pattern" size="36" name="wpmse_options[background_pattern]" type="url" class="medium-text" value="<?php echo wpmse_get_option('background_pattern'); ?>" /> 
												<input id="mse_background_pattern_upload" value="Upload Image" class="button n2_file_upload" type="button" />
												<br class="clear"><span class="description"><?php printf(__('Type-in image URL or upload a now one. We recommend <a href="%s" target="_blank">subtlepatterns.com</a>.', 'wpmse'), 'http://subtlepatterns.com');?></span>
											</label>
											
											<?php if (get_option('upload_image_ss', '') != ''):?>
											<br/><img src="<?php echo get_option('upload_image_ss');?>" height="100" alt="" />
										<?php endif; ?>
									</td>
									</tr>
									<tr valign="top">
										<th scope="row">
											<label for="mse_background_repeat"><?php _e('Background Image Repetition', 'wpmse');?> :</label>
										</th>
										<td>
											<select name="wpmse_options[bg_repeat]" id="mse_background_repeat">
												<option value="repeat" <?php if( wpmse_get_option('bg_repeat') == 'repeat' ): ?>selected="selected"<?php endif; ?>><?php _e('Repeat', 'wpmse'); ?></option>
												<option value="no-repeat" <?php if( wpmse_get_option('bg_repeat') == 'no-repeat' ): ?>selected="selected"<?php endif; ?>><?php _e('No-Repeat', 'wpmse'); ?></option>
												<option value="repeat-x" <?php if( wpmse_get_option('bg_repeat') == 'repeat-x' ): ?>selected="selected"<?php endif; ?>><?php _e('Repeat Horizontally', 'wpmse'); ?></option>
												<option value="repeat-y" <?php if( wpmse_get_option('bg_repeat') == 'repeat-y' ): ?>selected="selected"<?php endif; ?>><?php _e('Repeat Vertically', 'wpmse'); ?></option>
											</select>
										</td>
									</tr>
									<tr valign="top">
										<th scope="row">
											<label for="mse_background_position"><?php _e('Background Image Position', 'wpmse');?> :</label>
										</th>
										<td>
											<ul id="mse_background_position_select">
												<li>
													<a href="#" style="background-position: top left" title="Top Left"></a>
													<a href="#" style="background-position: top center" title="Top Center"></a>
													<a href="#" style="background-position: top right" title="Top Right"></a>
												</li>
												<li>
													<a href="#" style="background-position: center left" title="Center Left"></a>
													<a href="#" style="background-position: center center" title="Center Center"></a>
													<a href="#" style="background-position: center right" title="Center Right"></a>
												</li>
												<li>
													<a href="#" style="background-position: bottom left" title="Bottom Left"></a>
													<a href="#" style="background-position: bottom center" title="Bottom Center"></a>
													<a href="#" style="background-position: bottom right" title="Bottom Right"></a>
												</li>
											</ul>
											<input type="hidden" id="mse_background_position" name="wpmse_options[bg_position]" value="<?php echo wpmse_get_option('bg_position'); ?>">
										</td>
									</tr>
									<tr valign="top" class="mse_section">
										<th scope="row">
											<label for="mse_button_bgcolor"><?php _e('Buttons Background Color', 'wpmse');?> :</label>
										</th>
										<td>
											<input id="mse_button_bgcolor" type="text" value="<?php echo wpmse_get_option('btn_bg_color'); ?>" class="wpas_colorpicker" data-default-color="#8CB955" name="wpmse_options[btn_bg_color]" />
										</td>
									</tr>
									<tr valign="top">
										<th scope="row">
											<label for="mse_button_color"><?php _e('Buttons Font Color', 'wpmse');?> :</label>
										</th>
										<td>
											<input id="mse_button_color" type="text" value="<?php echo wpmse_get_option('btn_font_color'); ?>" class="wpas_colorpicker" data-default-color="#fff" name="wpmse_options[btn_font_color]" />
										</td>
									</tr>
									<tr valign="top" class="mse_advanced">
										<th scope="row">
											<label for="mse_button_style"><?php _e('Buttons Style', 'wpmse');?> :</label>
										</th>
										<td>
											<select name="wpmse_options[button_style]" id="mse_button_style">
												<option value="" disabled="" <?php if( !wpmse_get_option('button_style') ): ?>selected="selected"<?php endif; ?>><?php _e('Select Button Style', 'wpmse'); ?></option>
												<option value="btn-block" <?php if( wpmse_get_option('button_style') == 'btn-block' ): ?>selected="selected"<?php endif; ?>><?php _e('Block', 'wpmse'); ?></option>
												<option value="btn-block-rounded" <?php if( wpmse_get_option('button_style') == 'btn-block-rounded' ): ?>selected="selected"<?php endif; ?>><?php _e('Block Rounded', 'wpmse'); ?></option>
												<option value="btn-text" <?php if( wpmse_get_option('button_style') == 'btn-text' ): ?>selected="selected"<?php endif; ?>><?php _e('Text', 'wpmse'); ?></option>
												<option value="btn-squared" <?php if( wpmse_get_option('button_style') == 'btn-squared' ): ?>selected="selected"<?php endif; ?>><?php _e('Squared (Metro Style)', 'wpmse'); ?></option>
											</select>
										</td>
									</tr>
									<!-- <tr valign="top">
										<th scope="row">
											<label><?php _e('Display Icons', 'wpmse');?> :</label>
										</th>
										<td class="mse_switch">
											<input type="radio" id="mse_button_icons_yes" name="wpmse_options[button_icons]" value="1" <?php if( wpmse_get_option('button_icons') == 1 ): ?>checked="checked"<?php endif; ?> />
											<input type="radio" id="mse_button_icons_no" name="wpmse_options[button_icons]" value="0" <?php if( wpmse_get_option('button_icons') == 0 ): ?>checked="checked"<?php endif; ?> />
											<label for="mse_button_icons_yes" class="cb-enable <?php if( wpmse_get_option('button_icons') == 1 ): ?>selected<?php endif; ?>"><span><?php _e('Enable', 'wpmse');?></span></label>
											<label for="mse_button_icons_no" class="cb-disable <?php if( wpmse_get_option('button_icons') == 0 ): ?>selected<?php endif; ?>"><span><?php _e('Disable', 'wpmse');?></span></label>
											<br class="clear"><span class="description"><?php _e('Do you want to display icons on the buttons?', 'wpmse');?></span>
										</td>
									</tr> -->
									<tr valign="top" class="mse_section">
										<th scope="row">
											<label><?php _e('Social Networks Style', 'wpmse');?> :</label>
										</th>
										<td class="mse_switch">
											<input type="radio" id="mse_social_style_yes" name="wpmse_options[social_style]" value="1" <?php if( wpmse_get_option('social_style') == 1 ): ?>checked="checked"<?php endif; ?> />
											<input type="radio" id="mse_social_style_no" name="wpmse_options[social_style]" value="0" <?php if( wpmse_get_option('social_style') == 0 ): ?>checked="checked"<?php endif; ?> />
											<label for="mse_social_style_yes" class="cb-enable <?php if( wpmse_get_option('social_style') == 1 ): ?>selected<?php endif; ?>"><span><?php _e('Squared', 'wpmse');?></span></label>
											<label for="mse_social_style_no" class="cb-disable <?php if( wpmse_get_option('social_style') == 0 ): ?>selected<?php endif; ?>"><span><?php _e('Normal', 'wpmse');?></span></label>
											<br class="clear"><span class="description"><?php _e('Do you want to use plain icons for social networks links?', 'wpmse');?></span>
										</td>
									</tr>
									<tr valign="top">
										<th scope="row">
											<label for="mse_social_color"><?php _e('Social Networks Background Color', 'wpmse');?> :</label>
										</th>
										<td>
											<input id="mse_social_color" type="text" value="<?php echo wpmse_get_option('social_bg_color'); ?>" class="wpas_colorpicker" data-default-color="#666" name="wpmse_options[social_bg_color]" />
										</td>
									</tr>
									<tr valign="top" class="mse_advanced">
										<th scope="row">
											<label for="css_ss"><?php _e('Extra CSS', 'wpmse');?> :</label>
										</th>
										<td>
											<a id="toggle_custom_css" class="button-secondary" href="#" title="<?php _e('Add CSS', 'wpmse'); ?>"><?php _e('Show additional CSS', 'wpmse'); ?></a>
											<div id="custom_css">
												<textarea cols="50" rows="10" class="code" name="wpmse_options[extra_css]" style="width:60%"><?php echo wpmse_get_option('extra_css'); ?></textarea>
												<br/>
												<?php _e('The Splash Page\'s &lt;body&gt; tag uses the following class: <code>.mobile</code>.<br/>You can easily style the page with custom CSS.', 'wpmse'); ?>
											</div>
										</td>
									</tr>
									<tr valign="top" class="mse_section">
										<th scope="row">
											<label><?php _e('Enable Google Analytics', 'wpmse');?> :</label>
										</th>
										<td class="mse_switch">
											<input type="radio" id="mse_analytics_yes" name="wpmse_options[enable_analytics]" value="1" <?php if( wpmse_get_option('enable_analytics') == 1 ): ?>checked="checked"<?php endif; ?>/>
											<input type="radio" id="mse_analytics_no" name="wpmse_options[enable_analytics]" value="0" <?php if( wpmse_get_option('enable_analytics') == 0 ): ?>checked="checked"<?php endif; ?> />
											<label for="mse_analytics_yes" class="cb-enable <?php if( wpmse_get_option('enable_analytics') == 1 ): ?>selected<?php endif; ?>"><span><?php _e('Enable', 'wpmse');?></span></label>
											<label for="mse_analytics_no" class="cb-disable <?php if( wpmse_get_option('enable_analytics') == 0 ): ?>selected<?php endif; ?>"><span><?php _e('Disable', 'wpmse');?></span></label>
										</td>
									</tr>
									<tr valign="top">
										<th scope="row">
											<label for="mse_social_color"><?php _e('Google Analytics', 'wpmse');?> :</label>
										</th>
										<td>
											<?php
											if( class_exists( 'Yoast_GA_Plugin_Admin' ) ):
												_e('You are using <strong>Google Analytics for WordPress</strong> plugin. No need to re-enter your Analytics tracking code, we will use the Analytics plugin settings :)', 'wpmse');
											else:
												?><textarea cols="50" rows="5" class="code" name="wpmse_options[analytics]" style="width:60%"><?php echo wpmse_get_option('analytics'); ?></textarea>
											<br/>
											<?php _e('Please paste your Google Analytics tracking code.', 'wpmse');
											endif; ?>
										</td>
									</tr>
								<!--
									<tr valign="top">
										<th scope="row">
											<label for="mse_social_color"><?php _e('Google Analytics Event Tracking', 'wpmse');?> :</label>
										</th>
										<td class="mse_switch">
											<input type="radio" id="mse_analytics_yes" name="wpmse_options[event_tracking]" value="1" <?php if( wpmse_get_option('event_tracking') == 1 ): ?>checked="checked"<?php endif; ?>/>
											<input type="radio" id="mse_analytics_no" name="wpmse_options[event_tracking]" value="0" <?php if( wpmse_get_option('event_tracking') == 0 ): ?>checked="checked"<?php endif; ?> />
											<label for="mse_analytics_yes" class="cb-enable <?php if( wpmse_get_option('event_tracking') == 1 ): ?>selected<?php endif; ?>"><span><?php _e('Enable', 'wpmse');?></span></label>
											<label for="mse_analytics_no" class="cb-disable <?php if( wpmse_get_option('event_tracking') == 0 ): ?>selected<?php endif; ?>"><span><?php _e('Disable', 'wpmse');?></span></label>
										</td>
									</tr>
								-->
									<tr valign="top" class="mse_section mse_advanced">
										<th scope="row">
											<label><?php _e('Activate Font Awesome', 'wpmse');?> :</label>
										</th>
										<td class="mse_switch">
											<input type="radio" id="mse_icons_pack_yes" name="wpmse_options[icons_pack]" value="font-awesome" <?php if( wpmse_get_option('icons_pack') == 'font-awesome' ): ?>checked="checked"<?php endif; ?> />
											<input type="radio" id="mse_icons_pack_no" name="wpmse_options[icons_pack]" value="light" <?php if( wpmse_get_option('icons_pack') == 'light' ): ?>checked="checked"<?php endif; ?> />
											<label for="mse_icons_pack_yes" class="cb-enable <?php if( wpmse_get_option('icons_pack', 'light') == 'font-awesome' ): ?>selected<?php endif; ?>"><span><?php _e('Enable', 'wpmse');?></span></label>
											<label for="mse_icons_pack_no" class="cb-disable <?php if( wpmse_get_option('icons_pack', 'light') == 'light' ): ?>selected<?php endif; ?>"><span><?php _e('Disable', 'wpmse');?></span></label>
											<br class="clear"><span class="description"><?php _e('Using Font Awesome will give you more icons but will impact landing page performance', 'wpmse');?></span>
										</td>
									</tr>
									<tr valign="top" class="mse_section mse_advanced">
										<th scope="row">
											<label><?php _e('Cookie Lifetime', 'wpmse');?> :</label>
										</th>
										<td class="mse_switch">
											<select name="wpmse_options[cookie_lifetime]" id="mse_button_style">
												<option value="86400" <?php if( wpmse_get_option('cookie_lifetime') == '86400' ): ?>selected="selected"<?php endif; ?>><?php _e('1 Day', 'wpmse'); ?></option>
												<option value="604800" <?php if( wpmse_get_option('cookie_lifetime') == '604800' ): ?>selected="selected"<?php endif; ?>><?php _e('1 Week', 'wpmse'); ?></option>
												<option value="2592000" <?php if( !wpmse_get_option('cookie_lifetime') || wpmse_get_option('cookie_lifetime') == '2592000' ): ?>selected="selected"<?php endif; ?>><?php _e('1 Month', 'wpmse'); ?></option>
												<option value="31536000" <?php if( wpmse_get_option('cookie_lifetime') == '31536000' ): ?>selected="selected"<?php endif; ?>><?php _e('1 Year', 'wpmse'); ?></option>
											</select>
										</td>
									</tr>
									<tr valign="top">
										<th scope="row">
											<?php wp_nonce_field( 'update_splash', 'wpmse', false, true ); ?>
											<textarea id="mse_html" class="hidden" name="wpmse_splash_content"></textarea>
											<textarea id="mse_css" class="hidden" name="wpmse_splash_style"></textarea>
											<input type="hidden" id="wpmse_editor_mode" name="wpmse_options[editor_mode]" value="<?php echo wpmse_get_option('editor_mode', '0'); ?>" />
											<input type="submit" id="mse_submit" class="button-primary" name="save" value="<?php _e('Save changes', 'wpmse');?>" />
										</th>
										<td></td>
									</tr>
								</table>
					        </form>
						</div> <!-- .inside -->
					
					</div> <!-- .postbox -->
					
				</div> <!-- .meta-box-sortables .ui-sortable -->
				
			</div> <!-- post-body-content -->
			
			<!-- sidebar -->
			<div id="postbox-container-1" class="postbox-container mse_sidebar">
						
				<div class="meta-box-sortables">
					
					<div class="postbox">
						
						<h3><span><?php _e('Add Buttons', 'wpmse'); ?></span></h3>
						<div class="inside">
							<form id="mse_btn_addform">
								<div class="mse_row">
									<label><?php _e('Add a Button', 'wpmse');?> :</label>
									<select name="" id="mse_btn_type_add" class="input-block-level">
										<option value="" selected="selected" disabled=""><?php _e('Select Button Type', 'wpmse') ?></option>
										<option value="link"><?php _e('Link', 'wpmse') ?></option>
										<option value="email"><?php _e('Email', 'wpmse') ?></option>
										<option value="phone"><?php _e('Phone', 'wpmse') ?></option>
										<option value="sms"><?php _e('SMS', 'wpmse') ?></option>
									</select>
									<select name="" id="mse_btn_icon_add" class="input-block-level wpmse_select2">
										<?php if( wpmse_get_option('icons_pack', 'light') == 'light' ):
											$icons = wpmse_icons_list();
											foreach( $icons as $icon ) {
												?><option value="<?php echo $icon['icon']; ?>" <?php if( $icon['icon'] == 'none' ): ?>selected="selected"<?php endif; ?>><?php echo $icon['label']; ?></option><?php
											}
										else:
											$icons = wpmse_font_awesome_icons();
											foreach( $icons as $icon ) {
												$lbl = str_replace('icon-', '', $icon);
												?><option value="<?php echo $icon; ?>" <?php if( $icon == 'none' ): ?>selected="selected"<?php endif; ?>><?php echo ucwords($lbl); ?></option><?php
											}
										endif; ?>
									</select>
									<input id="mse_btn_anchor_add" type="text" name="wpmse_options[mse_btn_anchor_add]" class="large-text" placeholder="Button Label" required/>
									<input id="mse_btn_target_add" type="text" name="wpmse_options[mse_btn_target_add]" class="large-text" placeholder="http://example.com" required>
									<input id="mse_btn_add" class="button-secondary" type="submit" href="#" value="<?php _e( 'Add a Button', 'wpmse' ); ?>">
								</div>
							</form>
							<form id="mse_add_socialform">
								<div class="mse_row mse_section">
									<label><?php _e('Add a Social Network', 'wpmse');?> :</label>
									<select name="wpmse_options[social_list]" id="mse_social_list" class="input-block-level wpmse_select2" required>
										<optgroup label="<?php _e('Essentials', 'wpmse'); ?>">
											<?php
											foreach( $social as $sn ) {
												?><option value="<?php echo $sn['icon']; ?>"><?php echo $sn['network']; ?></option><?php
											}
											?>
										</optgroup>
										<?php if( wpmse_get_option('icons_pack', 'light') == 'font-awesome' ): ?>
											<optgroup label="<?php _e('Font Awesome', 'wpmse'); ?>">
												<?php
												$icons = wpmse_font_awesome_icons();
												foreach( $icons as $icon ) {
													$lbl = str_replace('icon-', '', $icon);
													?><option value="<?php echo $icon; ?>"><?php echo ucwords($lbl); ?></option><?php
												}
												?>
											</optgroup>
										<?php endif; ?>
									</select>
									<input id="mse_social_url" type="text" class="large-text" placeholder="http://example.com/profile" required>
									<button class="button-secondary" href="#" id="mse_add_social" title="<?php _e( 'Add a Network', 'wpmse' ); ?>"><?php _e( 'Add a Network', 'wpmse' ); ?></button>
								</div>
							</form>
							<form id="mse_add_textareaform">
								<div class="mse_row mse_section">
									<label><?php _e('Add a Textarea', 'wpmse');?> :</label>
									<select name="wpmse_options[textarea_pos]" id="mse_textarea_pos" class="input-block-level" required>
										<option value="top"><?php _e('Before the Buttons', 'wpmse'); ?></option>
										<option value="bottom"><?php _e('After the Buttons', 'wpmse'); ?></option>
									</select>
									<textarea id="mse_textarea_content" type="text" class="large-text" rows="3" placeholder="Enter the content of the new text area" required></textarea>
									<button class="button-secondary" href="#" id="#" title="<?php _e( 'Add textarea', 'wpmse' ); ?>"><?php _e( 'Add textarea', 'wpmse' ); ?></button>
								</div>
							</form>
						</div>
						
					</div> <!-- .postbox -->

					<div class="postbox">

						<h3><span><?php _e('View On Your Mobile', 'wpmse'); ?></span></h3>
						<div class="inside">
							<p><?php _e('Flash this QR Code to see the result on your mobile.', 'wpmse'); ?></p>
							<img src="https://chart.googleapis.com/chart?cht=qr&amp;chs=200x200&amp;chl=<?php echo home_url(); ?>" width="200" height="200" />
						</div>

					</div>

					<div class="postbox">

						<h3><span><?php _e('About The Plugin', 'wpmse'); ?></span></h3>
						<div class="inside">
							<p><?php printf(__('If you encounter any problems using our plugin, please visit our <a href="%s" target="_blank">support site</a>', 'wpmse'), 'http://wpfrogs.freshdesk.com/support/home'); ?>.</p>
							<p><?php printf(__('You can also suggest ideas <a href="%s" target="_blank">here</a>', 'wpmse'), 'http://wpfrogs.com/blogs/'); ?>.</p>
							<hr>
							<p><em>© Copyright 2013 <a href="http://wpfrogs.com" target="_blank" style="color:#333">wpfrogs.com</a></em></p>
						</div>

					</div>
					
				</div> <!-- .meta-box-sortables -->
				
			</div>
			
		</div> <!-- #post-body .metabox-holder .columns-2 -->
		
		<br class="clear">
	</div> <!-- #poststuff -->
	
</div> <!-- .wrap -->
<?php  } ?>