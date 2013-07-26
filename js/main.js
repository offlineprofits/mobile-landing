jQuery(document).ready(function ($){
	// Loading
	$('#mse_submit').attr('disabled', 'disabled');
	$('#mse_preview .mse_viewport').hide();
	setTimeout(function(){
		$('#mse_preview .mse_loading').remove();
		$('#mse_preview .mse_viewport').fadeIn();
		$('#mse_submit').removeAttr('disabled');
	}, 2500);

	// Trigger Media Uploader
	var _custom_media = true,
		_orig_send_attachment = wp.media.editor.send.attachment;
	$('.n2_file_upload').click(function (e) {
		var send_attachment_bkp = wp.media.editor.send.attachment;
		var button = $(this);
		var id = button.attr('id').replace('_upload', '');
		_custom_media = true;
		wp.media.editor.send.attachment = function (props, attachment) {
			if (_custom_media) {
				$("#" + id).val(attachment.url).change();
			} else {
				return _orig_send_attachment.apply(this, [props, attachment]);
			};
		}
		wp.media.editor.open(button);
		return false;
	});
	$('.add_media').on('click', function () {
		_custom_media = false;
	});
	
	// Responsive Stuff
	enquire.register("screen and (min-width: 1024px) and (max-width: 1600px)", {
		match : function() {
			$('.mse_metabox-holder').removeClass('columns-2');
			$('.mse_sidebar').appendTo('.mse_post-body-content').attr('id','mse_sidebar_bottom');
		},
		unmatch : function() {
			$('.mse_metabox-holder').addClass('columns-2');
			$('#mse_sidebar_bottom').appendTo('.mse_metabox-holder').attr('id','postbox-container-1');
		}
	}).listen();

	// Select2
	$('.wpmse_select2').select2();

	if($('#wpmse_editor_mode').val() == '1'){
		// Advanced Enabled
		$('#toggle_advanced').text('Hide Advanced Options');
		$('.mse_post-body-content .postbox .mse_advanced').show();
		$('#toggle_advanced').click(function (e) {
			e.preventDefault();
			var clicks = $(this).data('clicks');
			if (clicks) {
				$('.mse_post-body-content .postbox .mse_advanced').fadeIn();
				$(this).text('Hide Advanced Options');
				$('#wpmse_editor_mode').val('1');
			} else {
				$('.mse_post-body-content .postbox .mse_advanced').fadeOut();
				$(this).text('Show Advanced Options');
				$('#wpmse_editor_mode').val('0');
			}
			$(this).data("clicks", !clicks);
		});
	}
	else{
		// Advanced Disabled
		$('#toggle_advanced').click(function (e) {
			e.preventDefault();
			var clicks = $(this).data('clicks');
			if (clicks) {
				$('.mse_post-body-content .postbox .mse_advanced').fadeOut();
				$(this).text('Show Advanced Options');
				$('#wpmse_editor_mode').val('0');
			} else {
				$('.mse_post-body-content .postbox .mse_advanced').fadeIn();
				$(this).text('Hide Advanced Options');
				$('#wpmse_editor_mode').val('1');
			}
			$(this).data("clicks", !clicks);
		});
	}

	// Iphone-style Checkboxes
	$(".cb-enable").click(function(){
		var parent = $(this).parents('.mse_switch');
		$('.cb-disable',parent).removeClass('selected');
		$(this).addClass('selected');
		$('.checkbox',parent).attr('checked', true);
	});
	$(".cb-disable").click(function(){
		var parent = $(this).parents('.mse_switch');
		$('.cb-enable',parent).removeClass('selected');
		$(this).addClass('selected');
		$('.checkbox',parent).attr('checked', false);
	});

	// Colorpicker
	var myOptions = {
		defaultColor: false,
		change: function(event, ui){
			var inputColor = ui.color.toString();
			var inputId = $(this).attr('id');
			if (inputId == "mse_button_color") {
				window.mse_btnColor = inputColor;
			}
			if (inputId == "mse_button_bgcolor") {
				window.mse_btnBgColor = inputColor;
			}
			if (inputId == "mse_tagline_color") {
				window.mse_taglineColor = inputColor;
			}
			if (inputId == "mse_social_color") {
				window.mse_socialColor = inputColor;
			}
			if (inputId == "mse_background_color") {
				window.mse_bg = inputColor;
			}
			updateCSS();
		},
		hide: true,
		palettes: true
	};
	$('.wpas_colorpicker').wpColorPicker(myOptions);

	// Update the stylesheet
	window.mse_font = splash.font;
	window.mse_bg = splash.bg_color;
	window.mse_bgImage = 'url("'+splash.background_pattern+'")';
	window.mse_bgRepeat = splash.bg_repeat;
	window.mse_bgPosition = splash.bg_position;
	window.mse_align = splash.alignment;
	window.mse_btnColor = splash.btn_font_color;
	window.mse_btnBgColor = splash.btn_bg_color;
	window.mse_taglineColor = splash.catchphrase_color;
	window.mse_taglineSize = splash.catchphrase_size;
	window.mse_taglineLineHeight = '27';
	window.mse_socialColor = splash.social_bg_color;
	window.extra_css = splash.extra_css;
	window.outputStyle = '.mobile{font-family:'+mse_font+';padding:1em;background:'+mse_bg+';background-image:'+mse_bgImage+';background-repeat:'+mse_bgRepeat+';background-position:'+mse_bgPosition+';text-align:'+mse_align+'}.mobile img.featured{max-width:100%;height:auto;width:auto;-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box}.mobile .aligncenter{display:block;margin-left:auto;margin-right:auto}.mobile .tagline,.tagline_edit{margin:1.5em 0;color:'+mse_taglineColor+';font-size:'+mse_taglineSize+'px;line-height:'+mse_taglineLineHeight+'px;margin:2em 0}.mobile .btn{display:block;padding:1em;margin:.5em auto;background-color:'+mse_btnBgColor+';color:'+mse_btnColor+';text-decoration:none}.mobile .btn:last-child{margin-bottom:0}.mobile .btn.align-left i{float:right}.mobile .btn.align-right i{float:left}.mobile .btn i{float:right;font-size:18px}.mse_social{margin-top:2em}.mse_social li{display:inline-block}.mse_social a{color:'+mse_socialColor+';font-size:250%;text-decoration:none}'+extra_css+'';
	function updateCSS() {
		window.outputStyle = '.mobile{font-family:'+mse_font+';padding:1em;background:'+mse_bg+';background-image:'+mse_bgImage+';background-repeat:'+mse_bgRepeat+';background-position:'+mse_bgPosition+';text-align:'+mse_align+'}.mobile img.featured{max-width:100%;height:auto;width:auto;-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box}.mobile .aligncenter{display:block;margin-left:auto;margin-right:auto}.mobile .tagline,.tagline_edit{margin:1.5em 0;color:'+mse_taglineColor+';font-size:'+mse_taglineSize+'px;line-height:'+mse_taglineLineHeight+'px;margin:2em 0}.mobile .btn{display:block;padding:1em;margin:.5em auto;background-color:'+mse_btnBgColor+';color:'+mse_btnColor+';text-decoration:none}.mobile .btn:last-child{margin-bottom:0}.mobile .btn.align-left i{float:right}.mobile .btn.align-right i{float:left}.mobile .btn i{float:right;font-size:18px}.mse_social{margin-top:2em}.mse_social li{display:inline-block}.mse_social a{color:'+mse_socialColor+';font-size:250%;text-decoration:none}'+extra_css+'';
		$('style[title="live_preview"]').html(outputStyle);
	}

	// Radio onChange
	$('input[name="wpmse_options[font]"]').change(function() {
		window.mse_font = $(this).val();
		updateCSS();
	});

	$('textarea[name="wpmse_options[extra_css]"]').bind("keyup change", function (e) {
		window.extra_css = $(this).val();
		updateCSS();
	});

	// Button Style
	$('#mse_button_style').change(function() {
		window.mse_btnStyle = $(this).val();
		$('#mse_preview .mse_buttons').attr('id',mse_btnStyle);
		$('.mse_buttons').sortable({
			placeholder: "button-placeholder",
			start: function(event, ui) {
				ui.item.find('a[rel=editor]');
			}
		});
		$('.mse_social').sortable({
			placeholder: "social-placeholder",
			start: function(event, ui) {
				ui.item.find('a[rel=editor]');
			}
		});
		if(mse_btnStyle == 'btn-squared'){
			$('.mse_buttons').sortable("disable");
		}
		else{
			$('.mse_buttons').sortable("enable");
		}
		updateCSS();
	}).change();
	$(document).on("click", '.mse_up', function (e) {
		e.preventDefault();

		// Close the popover
		$(this).parents('.popover').css('display','none');
		$(this).parents('li').find('a[rel=editor]').popover('hide');

		// Move it
		var current = $(this).parents('li');
		current.prev().before(current);
	});
	$(document).on("click", '.mse_down', function (e) {
		e.preventDefault();

		// Close the popover
		$(this).parents('.popover').css('display','none');
		$(this).parents('li').find('a[rel=editor]').popover('hide');

		// Move it
		var current = $(this).parents('li');
		current.next().after(current);
	});

	// Background & Image
	$('#mse_featured_img').bind("keyup change", function (e) {
		var featuredImg = $(this).val();
		$('#mse_preview .featured').attr('src',featuredImg);
	}).change();
	$('#mse_background_pattern').bind("keyup change", function (e) {
		window.mse_bgImage = 'url('+ $(this).val() +')';
		if( !$(this).val() ) {
			$('#mse_background_repeat').parents('tr').fadeOut();
		}
		else {
			$('#mse_background_repeat').parents('tr').fadeIn();
		}
		updateCSS();
	});
	if ($('#mse_background_pattern').val() != ""){
		$('#mse_background_repeat').parents('tr').show();
	}
	$('#mse_background_repeat').parents('tr').hide();
	$('#mse_background_repeat').change(function(){
		window.mse_bgRepeat = $(this).find(":selected").val();
		if(mse_bgRepeat != 'repeat'){
			$('#mse_background_position_select').parents('tr').fadeIn();
		}
		else {
			$('#mse_background_position_select').parents('tr').fadeOut();
			window.mse_bgPosition = '0 0';
		}
		updateCSS();
	});
	$('#mse_background_position_select').parents('tr').hide();
	$('#mse_background_position_select a').click(function (e){
		e.preventDefault();
		window.mse_bgPosition = $(this).css('background-position');
		$('#mse_background_position_select a').removeClass('selected');
		$(this).addClass('selected');
		$('#mse_background_position').val(mse_bgPosition);
		updateCSS();
	});

	$('#mse_align_list a').click(function (e){
		e.preventDefault();
		window.mse_align = $(this).data('alignement');
		$('#mse_align_list a').removeClass('button-primary').addClass('button-secondary');
		$(this).removeClass('button-secondary').addClass('button-primary');
		$('#mse_align').val(mse_align);
		$('#mse_preview .mse_viewport').css('text-align',window.mse_align);
		$('#mse_preview .btn').removeClass('align-left align-center align-right align-justify');
		$('#mse_preview .btn').addClass('align-'+window.mse_align);
		updateCSS();
	});
	$(document).on("change", ':radio[name="wpmse_options[fullsite]"]', function (e) {
		if($(this).val() == '1'){
			$('<li class="fullsite"><a rel="editor" class="btn fullsite" href="'+bloginfo.homeUrl+'/?fullsite=true"><span>Full Site <i class="icon-angle-right"></i></span></a></li>').appendTo('.mse_buttons');          
		} else {
			$('.mse_buttons .fullsite').remove();
		}
	});
	$(document).on("change", ':radio[name="wpmse_options[button_icons]"]', function (e) {
		if($(this).val() == '1'){
			$('#mse_preview .btn i').fadeIn();
		} else {
			$('#mse_preview .btn i').fadeOut();
		}
	});
	$(document).on("change", ':radio[name="wpmse_options[social_style]"]', function (e) {
		if($(this).val() == '1'){
			$('#mse_preview .mse_social i').each(function() {
				$(this).attr("class",this.className+'-sign');
			});
		} else {
			$('#mse_preview .mse_social i').each(function() {
				$(this).attr("class",this.className.replace(/-sign/,''));
			});
		}
	});
	$(document).on("change", ':radio[name="wpmse_options[event_tracking]"]', function (e) {
		if($(this).val() == '1'){
			console.log('event_tracking on');
			$('.mse_buttons li > a').each(function() {
				$(this).attr('onClick',"_gaq.push(['_trackEvent', 'Videos', 'Play', 'Baby\'s First Birthday']);");
			});
		} else {
			console.log('event_tracking off');
			$('.mse_buttons li > a').each(function() {
				$(this).removeAttr('onClick');
			});
		}
	});

	// Range onChange
	$('#mse_tagline_size').change(function () {
		window.mse_taglineSize = $(this).val();
		window.mse_taglineLineHeight = Math.floor(parseInt(mse_taglineSize.replace('px','')) * 1.5);
		$('#mse_preview .tagline').css({
			"fontSize":mse_taglineSize+'px',
			"lineHeight":mse_taglineLineHeight+'px'
		});
		updateCSS();
	});

	// Social
	$('#mse_social_list').change(function () {
		if($(this).val() == 'icon-facebook'){
			$('#mse_social_url').attr("placeholder", "https://www.facebook.com/pages/ThemeAvenue/461448310549015");
		}
		if($(this).val() == 'icon-twitter'){
			$('#mse_social_url').attr("placeholder", "https://twitter.com/theme_avenue");
		}
		if($(this).val() == 'icon-github'){
			$('#mse_social_url').attr("placeholder", "https://github.com/themeavenue");
		}
		if($(this).val() == 'icon-linkedin'){
			$('#mse_social_url').attr("placeholder", "http://www.linkedin.com/company/themeavenue");
		}
		if($(this).val() == 'icon-pinterest'){
			$('#mse_social_url').attr("placeholder", "http://pinterest.com/themeavenue");
		}
		if($(this).val() == 'icon-google-plus'){
			$('#mse_social_url').attr("placeholder", "https://plus.google.com/themeavenue");
		}
	});

	$(document).on("click", '#mse_btn_icon_list a', function (e) {
		e.preventDefault();
		var icon = $('i', this).attr("class");
		$('#mse_btn_icon_list a').removeClass('button-primary').addClass('button-secondary');
		$(this).removeClass('button-secondary').addClass('button-primary');
		$('#mse_btn_icon').val(icon);
	});

	// Popover
	// Bind the popover for generated buttons
	// http://stackoverflow.com/questions/9958825/how-do-i-bind-twitter-bootstrap-tooltips-to-dynamically-created-elements
	$('body').popover({
		selector: '[rel=editor]',
		html : true,
		title : 'Edit Button'+'<a href="#" title="Cancel" id="mse_close">&#10007; Esc</a>',
		placement: 'left',
		content: function () {
			return $('#popover_content_wrapper').html();
		}
	});
	$(document).on("click", '#mse_preview a[rel=editor]', function (e) {

		$('a[rel=editor]', this).popover('show');

		var popoverContent = $(this).data('popover').tip();
		var button = $(this).parents('a[rel=editor]');
		var target = $(this).attr('href');
		var anchor = $(this).text();
		var icon = $(this).find('i').attr('class');
		var type = $(this).data('type');
		var icon = 'none';
		var icon = $(this).find('i').attr('class');
		var bgColor = $(this).css('backgroundColor');

		// Default vars
		window.mse_default_color = $(this).css('backgroundColor');
		window.mse_default_icon = $(this).find('i').attr('class');

		// Explode mailto: and tel:
		target = target.replace(/mailto:/, '');
		target = target.replace(/tel:/, '');
		target = target.replace(/sms:/, '');

		// Rename the label for target
		if(type == 'link'){
			$('label[for="mse_btn_target"]').text('URL');
		}
		if(type == 'email'){
			$('label[for="mse_btn_target"]').text('Email Address');
		}
		if(type == 'phone'){
			$('label[for="mse_btn_target"]').text('Phone Number (Format: +99...)');
		}

		popoverContent.find('#mse_btn_target').val(target);
		popoverContent.find('#mse_btn_anchor').val(anchor);
		popoverContent.find('#mse_btn_icon').val(icon);
		popoverContent.find('#mse_btn_type').val(type);
		popoverContent.find('#mse_btn_bgcolor').val(bgColor).click();

		if($(this).hasClass('fullsite')){
			popoverContent.find('label[for="mse_btn_target"],#mse_btn_target,#mse_delete').hide();
			popoverContent.find('label[for="mse_btn_type"],#mse_btn_type').hide();
		}

		if($(this).hasClass('btn-social')){
			popoverContent.find('label[for="mse_btn_anchor"],#mse_btn_anchor').hide();
			popoverContent.find('label[for="mse_btn_type"],#mse_btn_type').hide();
			popoverContent.find('#wpmse_btnicons').hide();
		}

		if($(this).parents('ul').attr('id') == 'btn-squared'){
			popoverContent.find('#btn-squared-on').show();
		}

		return false;
	});

	// Add Buttons & Popover
	$('#mse_btn_addform').bind('submit', function() {
		var btn_anchor = $('#mse_btn_anchor_add').val();
		var btn_target = $('#mse_btn_target_add').val();
		var btn_icon = $('#mse_btn_icon_add').val();
		// Button Type
		if($('#mse_btn_type_add').val() == 'link'){
			$('<li><a rel="editor" class="btn" href="'+btn_target+'" data-type="link"><span>'+btn_anchor+' <i class="'+btn_icon+'"></i></span></a></li>').appendTo('#mse_preview .mse_buttons');
		}		
		if($('#mse_btn_type_add').val() == 'email'){
			$('<li><a rel="editor" class="btn" href="mailto:'+btn_target+'" data-type="email"><span>'+btn_anchor+' <i class="'+btn_icon+'"></i></span></a></li>').appendTo('#mse_preview .mse_buttons');
		}
		if($('#mse_btn_type_add').val() == 'phone'){
			$('<li><a rel="editor" class="btn" href="tel:'+btn_target+'" data-type="phone"><span>'+btn_anchor+' <i class="'+btn_icon+'"></i></span></a></li>').appendTo('#mse_preview .mse_buttons');
		}
		if($('#mse_btn_type_add').val() == 'sms'){
			$('<li><a rel="editor" class="btn" href="sms:'+btn_target+'" data-type="sms"><span>'+btn_anchor+' <i class="'+btn_icon+'"></i></span></a></li>').appendTo('#mse_preview .mse_buttons');
		}
		return false;
	});
	$('#mse_btn_type_add').change(function(){
		if($(this).val() == 'link'){
			$('#mse_btn_target_add')[0].type = 'url';
		}
		if($(this).val() == 'email'){
			$('#mse_btn_target_add').attr('placeholder','example@example.com');
			$('#mse_btn_target_add')[0].type = 'email';
		}
		if($(this).val() == 'phone'){
			$('#mse_btn_target_add').attr('placeholder','+99...');
		}
		if($(this).val() == 'sms'){
			$('#mse_btn_target_add').attr('placeholder','+99...');
		}
	});
	$('#mse_add_socialform').bind('submit', function() {
		var social_icon = $('#mse_social_list').find(":selected").val();
		var social_url = $('#mse_social_url').val();
		var social_style = $('#mse_preview .mse_social i').attr('class');
		if(social_style.indexOf("-sign") >= 0){
			$('<li><a rel="editor" class="btn-social" href="'+social_url+'"><i class="'+social_icon+'-sign"></i></a></li>').appendTo('#mse_preview .mse_social');
		} else{
			$('<li><a rel="editor" class="btn-social" href="'+social_url+'"><i class="'+social_icon+'"></i></a></li>').appendTo('#mse_preview .mse_social');
		}
		return false;
	});
	$('#mse_add_textareaform').bind('submit', function() {
		var position = $('#mse_textarea_pos').val();
		var content = $('#mse_textarea_content').val();
		if (position == 'top'){
			$('<div class="tagline">'+content+'</div>').insertBefore('.mse_buttons_wrapper');
		}
		else{
			$('<div class="tagline">'+content+'</div>').insertAfter('.mse_buttons_wrapper');
		}
		return false;
	});

	// Popover Controls: Close/Save/Delete
	$(document).on("click", '#mse_close', function (e) {
		e.preventDefault();

		$(this).parents('.popover').css('display','none');
		$(this).parents('li').find('a[rel=editor]').popover('hide');

		// return the default values for icon/color		
		var btnCurrent = $(this).parents('.popover').prev('a[rel=editor]');
		btnCurrent.css('backgroundColor',mse_default_color);
		btnCurrent.find('i').attr('class',mse_default_icon);
	});
	$(document).on("click", '#mse_save', function (e) {
		// Get the matching clicked button
		var btnCurrent = $(this).parents('.popover').prev('a[rel=editor]');

		var popoverContent = btnCurrent.data('popover').tip();
		var target = popoverContent.find('#mse_btn_target').val();
		var anchor = popoverContent.find('#mse_btn_anchor').val();
		var type = popoverContent.find('#mse_btn_type').val();
		var icon = popoverContent.find('#mse_btn_icon').val();

		// Update button depending on type of popover
		if(btnCurrent.hasClass('btn-social')){
			$(btnCurrent).attr('href',target);
		}
		else{
			$(btnCurrent).html('<span>'+anchor+' <i class="'+icon+'"></i></span>');
			if(type == 'link'){
				$(btnCurrent).attr('href',target);
				$(btnCurrent).data('type','link');
			}
			if(type == 'email'){
				$(btnCurrent).attr('href','mailto:'+target);
				$(btnCurrent).data('type','email');
			}
			if(type == 'phone'){
				$(btnCurrent).attr('href','tel:'+target);
				$(btnCurrent).data('type','phone');
			}
		}
		$(btnCurrent).popover('hide');

		return false;
	});
	$(document).on("change", '#mse_btn_icon', function (e) {
		var icon = $(this).val();
		var btnCurrent = $(this).parents('.popover').prev('a[rel=editor]');
		btnCurrent.find('i').removeClass().addClass(icon);
	});
	$(document).on("click", '#mse_btn_bgcolor', function (e) {
		$(this).wpColorPicker({
			change: function(event, ui){
				var inputColor = ui.color.toString();
				var btnCurrent = $(this).parents('.popover').prev('a[rel=editor]');
				btnCurrent.css('backgroundColor',inputColor);
			},
			defaultColor: false,
			hide: true,
			palettes: true
		});
	});
	$(document).on("click", '.wp-picker-clear', function (e) {
		var btnCurrent = $(this).parents('.popover').prev('a[rel=editor]');
		$(this).parent().prev().css('backgroundColor',mse_btnBgColor);
		btnCurrent.css('backgroundColor', '');
	});

	$(document).on("click", '#mse_delete', function (e) {
		var conf = confirm("Are you sure you want to delete this button?");
		if(conf == true){
			var popover = $(this).parents('.popover');
			popover.prev('a[rel=editor]').parent().remove(); // Remove the button
			popover.remove(); // Close the popover
		}
		return false;
	});

	// Save HTML to Textarea
	$('#mse_submit').click(function(){
		// Close all popovers
		$('a[rel=editor]').popover('destroy');

		// Clean & Create the clone;
		var textarea = $('#mse_html');
		var clone = $('#mse_preview .mse_viewport').clone();
		textarea.empty();

		// Clean the output HTML
		clone.find('*[class=""]').removeAttr('class');
		clone.find('*[style=""]').removeAttr('style');
		clone.find('*[data-original-title=""]').removeAttr('data-original-title');
		clone.find('*[title=""]').removeAttr('title');
		clone.find('ul').each(function(){
			if($(this).is(':empty')){
				$(this).remove();
			}
		});

		var output = new String(clone.html());
		$('#mse_html').val(output);

		// Output the stylesheet as well
		$('#mse_css').val(outputStyle);
	});

	$('#toggle_custom_css').click(function (e) {
		e.preventDefault();
		var clicks = $(this).data('clicks');
		if (clicks) {
			$(this).text('Show additional CSS');
			$("#custom_css").slideUp("slow");
		} else {
			$(this).text('Hide additional CSS');
			$("#custom_css").slideDown("slow");
		}
		$(this).data("clicks", !clicks);
	});

	// Edit In Place
	var oldText, newText;
	$(".tagline").hover(
		function(){
			$(this).attr('title','Double Click to Edit');
		}, 
		function(){
			$(this).removeAttr('title');
		}
	);
	$(document).on("dblclick", '.tagline', replaceHTML);
	function replaceHTML(e){
		$(this).removeClass().addClass('tagline_edit');
		oldText = $(this).html()
		.replace(/"/g, "&quot;");
		$(this).html("")
		.html('<form><textarea class="editBox">'+ oldText +'</textarea></form><a href="#" class="button-primary btnSave">Save changes</a> <a href="#" class="button-secondary btnDiscard">Discard changes</a>');
	}
	$(document).on("click", '.btnSave', function (e) {
		e.preventDefault();
		newText = $(this).siblings("form")
		.children(".editBox")
		.val().replace(/"/g, "&quot;");
		$(this).parent().html(newText).removeClass().addClass('tagline');
	});
	$(document).on("click", '.btnDiscard', function (e) {
		e.preventDefault();
		$(this).parent().html(oldText).removeClass().addClass('tagline');
	});
});