<?php
function new_year_firework_register_settings() {
	add_option('new_year_firework_status', 'open');
	add_option('new_year_firework_text', 'HAPPY NEW YEAR!');
	add_option('new_year_firework_time', '01 00:00:00');
	add_option('new_year_firework_redirect_place', array('front_page'));
	add_option('new_year_firework_music_url', '');
	register_setting('new_year_firework_options', 'new_year_firework_status');
	register_setting('new_year_firework_options', 'new_year_firework_text');
	register_setting('new_year_firework_options', 'new_year_firework_time');
	register_setting('new_year_firework_options', 'new_year_firework_redirect_place');
	register_setting('new_year_firework_options', 'new_year_firework_music_url');
}
add_action('admin_init', 'new_year_firework_register_settings');

function new_year_firework_register_options_page() {
	add_options_page(__('New Year Firework Options Page', NEW_YEAR_FIREWORK_TEXT_DOMAIN), __('New Year Firework', NEW_YEAR_FIREWORK_TEXT_DOMAIN), 'manage_options', NEW_YEAR_FIREWORK_TEXT_DOMAIN.'-options', 'new_year_firework_options_page');
}
add_action('admin_menu', 'new_year_firework_register_options_page');

function new_year_firework_admin_script(){
	if (isset($_GET['page']) && $_GET['page'] == NEW_YEAR_FIREWORK_TEXT_DOMAIN.'-options'){
		wp_register_script(NEW_YEAR_FIREWORK_TEXT_DOMAIN.'-upload', NEW_YEAR_FIREWORK_PLUGIN_URL.'admin-script.min.js', array('jquery', 'media-upload', 'thickbox'));
		wp_enqueue_script(NEW_YEAR_FIREWORK_TEXT_DOMAIN.'-upload');
		wp_enqueue_script('media-upload');
		wp_enqueue_script('thickbox');
	}
}
add_action('admin_enqueue_scripts', 'new_year_firework_admin_script');

function new_year_firework_admin_style(){
	if (isset($_GET['page']) && $_GET['page'] == NEW_YEAR_FIREWORK_TEXT_DOMAIN.'-options'){
		wp_enqueue_style('thickbox');
	}
}
add_action('admin_enqueue_scripts', 'new_year_firework_admin_style');

function new_year_firework_get_select_option($select_option_name, $select_option_value, $select_option_id){
	?>
	<select name="<?php echo $select_option_name; ?>" id="<?php echo $select_option_name; ?>">
		<?php
		for($num = 0; $num < count($select_option_id); $num++){
			$select_option_value_each = $select_option_value[$num];
			$select_option_id_each = $select_option_id[$num];
			?>
			<option value="<?php echo $select_option_id_each; ?>"<?php if (get_option($select_option_name) == $select_option_id_each){?> selected="selected"<?php } ?>>
				<?php echo $select_option_value_each; ?>
			</option>
		<?php } ?>
	</select>
	<?php
}

function new_year_firework_get_checked($checkbox_name, $check_value){
	if(is_array($checkbox_name)){
		if(in_array($check_value, $checkbox_name)){
			?> checked="checked"<?php
		}
	}
}

function new_year_firework_get_checkbox_option($checkbox_name, $checkbox_value, $checkbox_id){
	for($num = 0; $num < count($checkbox_id); $num++){
		$checkbox_value_each = $checkbox_value[$num];
		$checkbox_id_each = $checkbox_id[$num];
		?>
		<input type="checkbox" name="<?php echo $checkbox_name; ?>[]" id="<?php echo $checkbox_id_each; ?>" value="<?php echo $checkbox_id_each; ?>"<?php new_year_firework_get_checked(get_option($checkbox_name), $checkbox_id_each); ?>><label for="<?php echo $checkbox_id_each; ?>"><?php echo $checkbox_value_each; ?></label>
	<?php
	}
}

function get_new_year_firework_url(){
	$new_year_firework_music_url = get_option('new_year_firework_music_url');
	$new_year_firework_url = NEW_YEAR_FIREWORK_PLUGIN_URL."firework/";
	$new_year_firework_url .= "?text=".urlencode(get_option('new_year_firework_text'));
	$new_year_firework_url .= "&url=".urlencode(home_url());
	if(!empty($new_year_firework_music_url)){
		$new_year_firework_url .= "&music=".urlencode(get_option('new_year_firework_music_url'));
	}
	return $new_year_firework_url;
}

$new_year_firework_url = get_new_year_firework_url();

function new_year_firework_options_page() {
	global $new_year_firework_url;
?>
<div class="wrap">
	<h2><?php _e("New Year Firework Options Page", NEW_YEAR_FIREWORK_TEXT_DOMAIN); ?></h2>
	<form method="post" action="options.php">
		<?php settings_fields('new_year_firework_options'); ?>
		<h3><?php _e("General Options", NEW_YEAR_FIREWORK_TEXT_DOMAIN); ?></h3>
			<p><?php printf(__('You can go to your New Year Firework directly by %sURL%s too!', NEW_YEAR_FIREWORK_TEXT_DOMAIN), '<a href="'.$new_year_firework_url.'" target="_blank">', '</a>'); ?></p>
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><label for="new_year_firework_status"><?php _e("Open Firework?", NEW_YEAR_FIREWORK_TEXT_DOMAIN); ?></label></th>
					<td>
						<?php new_year_firework_get_select_option("new_year_firework_status", array(__('Open', NEW_YEAR_FIREWORK_TEXT_DOMAIN), __('Close', NEW_YEAR_FIREWORK_TEXT_DOMAIN)), array('open', 'close')); ?>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="new_year_firework_text"><?php _e("Text of firework: (A Space for a line)", NEW_YEAR_FIREWORK_TEXT_DOMAIN); ?></label></th>
					<td>
						<input type="text" name="new_year_firework_text" id="new_year_firework_text" value="<?php echo get_option('new_year_firework_text'); ?>" />
						<?php _e("(English Only)", NEW_YEAR_FIREWORK_TEXT_DOMAIN); ?>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="new_year_firework_time"><?php _e("How many times do you want to redirect to firework again?", NEW_YEAR_FIREWORK_TEXT_DOMAIN); ?></label></th>
					<td>
						<input type="text" name="new_year_firework_time" id="new_year_firework_time" pattern="[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2}" title="<?php _e("DD HH:MM:SS", NEW_YEAR_FIREWORK_TEXT_DOMAIN); ?>" value="<?php echo get_option('new_year_firework_time'); ?>" />
						<?php _e("Use format of DD HH:MM:SS", NEW_YEAR_FIREWORK_TEXT_DOMAIN); ?>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="new_year_firework_redirect_place"><?php _e("Where do you want to redirect the firework from?", NEW_YEAR_FIREWORK_TEXT_DOMAIN); ?></label></th>
					<td>
						<?php new_year_firework_get_checkbox_option("new_year_firework_redirect_place", array(__('Home', NEW_YEAR_FIREWORK_TEXT_DOMAIN), __('Post', NEW_YEAR_FIREWORK_TEXT_DOMAIN), __('Page', NEW_YEAR_FIREWORK_TEXT_DOMAIN), __('Archive', NEW_YEAR_FIREWORK_TEXT_DOMAIN), __('Search Result', NEW_YEAR_FIREWORK_TEXT_DOMAIN), __('All Pages', NEW_YEAR_FIREWORK_TEXT_DOMAIN)), array('front_page', 'single', 'page', 'archive', 'search', 'all')); ?>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="new_year_firework_music_url"><?php _e("The Music URL of the Firework: ", NEW_YEAR_FIREWORK_TEXT_DOMAIN); ?></label></th>
					<td>
						<input id="new_year_firework_music_url" type="text" name="new_year_firework_music_url" value="<?php echo get_option('new_year_firework_music_url'); ?>" size="50" />
						<input class="<?php echo NEW_YEAR_FIREWORK_TEXT_DOMAIN; ?>-music-upload-button button" type="button" value="<?php _e("Upload Music", NEW_YEAR_FIREWORK_TEXT_DOMAIN); ?>" />
						<p><?php _e("(Leave Empty for No Music)", NEW_YEAR_FIREWORK_TEXT_DOMAIN); ?></p>
					</td>
				</tr>
			</table>
		<?php submit_button(); ?>
	</form>
</div>
<?php
}
?>