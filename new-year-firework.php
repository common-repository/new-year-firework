<?php
/*

**************************************************************************

Plugin Name:  New Year Firework
Plugin URI:   http://www.arefly.com/new-year-firework/
Description:  Redirect you to a New Year Firework page with your own text.
Version:      1.1.9
Author:       Arefly
Author URI:   http://www.arefly.com/
Text Domain:  new-year-firework
Domain Path:  /lang/

**************************************************************************

	Copyright 2014  Arefly  (email : eflyjason@gmail.com)

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License, version 2, as 
	published by the Free Software Foundation.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

**************************************************************************/

define("NEW_YEAR_FIREWORK_PLUGIN_URL", plugin_dir_url( __FILE__ ));
define("NEW_YEAR_FIREWORK_FULL_DIR", plugin_dir_path( __FILE__ ));
define("NEW_YEAR_FIREWORK_TEXT_DOMAIN", "new-year-firework");

/* Plugin Localize */
function new_year_firework_load_plugin_textdomain() {
	load_plugin_textdomain(NEW_YEAR_FIREWORK_TEXT_DOMAIN, false, dirname(plugin_basename( __FILE__ )).'/lang/');
}
add_action('plugins_loaded', 'new_year_firework_load_plugin_textdomain');

include_once NEW_YEAR_FIREWORK_FULL_DIR."options.php";

/* Add Links to Plugins Management Page */
function new_year_firework_action_links($links) {
	$links[] = '<a href="'.get_admin_url(null, 'options-general.php?page='.NEW_YEAR_FIREWORK_TEXT_DOMAIN.'-options').'">'.__("Settings", LAST_POST_REDIRECT_TEXT_DOMAIN).'</a>';
	return $links;
}
add_filter('plugin_action_links_'.plugin_basename(__FILE__), 'new_year_firework_action_links');

function new_year_firework_set_cookie() {
	if(!isset($_COOKIE['new_year_firework_visited'])) {
		sscanf(get_option('new_year_firework_time'), "%d %d:%d:%d", $days, $hours, $minutes, $seconds);
		$cookies_seconds = $days*24*60*60 + $hours*60*60 + $minutes*60 + $seconds*1;
		setcookie("new_year_firework_visited", true, time()+$cookies_seconds);
	}
}
add_action('template_redirect', 'new_year_firework_set_cookie');

function new_year_firework_redirect() {
	$new_year_firework_url = get_new_year_firework_url();
	if(in_array("all", get_option('new_year_firework_redirect_place'))) {
		wp_redirect($new_year_firework_url);
		exit;
	}else{
		foreach(get_option('new_year_firework_redirect_place') as $template_name) {
			if(call_user_func('is_'.$template_name)) {
				wp_redirect($new_year_firework_url);
				exit;
			}
		}
	}
}

if(get_option('new_year_firework_status') == "open") {
	if(!isset($_COOKIE['new_year_firework_visited'])) {
		add_action('template_redirect', 'new_year_firework_redirect');
	}
}