<?php
function ta_debug_info() {
	if( !isset($_GET['ta_debug']) || isset($_GET['ta_debug']) && $_GET['ta_debug'] != 'true' )
		return;

	global $ta_plugin_ver; ?>

	<style type="text/css">
		#debug_info{
			width: 500px;
			margin: 0 auto;
		}
		#debug_info thead th{
			text-align: center;
		}
	</style>

	<script type="text/javascript">
	jQuery(document).ready(function ($){
		$('.jquery_version').text($().jquery);
	});
	</script>
	
	</head>
	<body>
		<table id="debug_info" class="widefat">
			<thead>
				<tr>
					<th class="row-title" colspan="2"><?php _e('Debug Information', 'wpmse'); ?></th>
				</tr>
			</thead>
			<tr valign="top" class="alternate">
				<th scope="row" class="row-title">WordPress Version</th>
				<td><?php bloginfo('version'); ?></td>
			</tr>
			<tr valign="top">
				<th scope="row" class="row-title">jQuery Enabled</th>
				<td><?php if( wp_script_is('jquery', 'done') ) { echo 'True'; } else { echo 'False'; } ?></td>
			</tr>
			<?php if( wp_script_is('jquery', 'done') ): ?>
			<tr valign="top" class="alternate">
				<th scope="row" class="row-title">jQuery Version</th>
				<td><span class="jquery_version"></span></td>
			</tr>
			<?php endif; ?>
			<tr valign="top">
				<th scope="row" class="row-title">Plugin Version</th>
				<td><?php echo $ta_plugin_ver; ?></td>
			</tr>
			<tr valign="top" class="alternate">
				<th scope="row" class="row-title">Debugging Mode</th>
				<td><?php if( WP_DEBUG ) { echo 'Enabled'; } else { echo 'Disabled'; } ?></td>
			</tr>
		</table>
	</body>
	</html>
<?php 
	exit;
}
add_action('admin_head', 'ta_debug_info', 100);
?>