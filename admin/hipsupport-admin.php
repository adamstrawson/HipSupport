<?php

/* 
Plugin Name: HipSupport
Plugin URI: http://www.adamstrawson.com/HipSupport
Description: HipChat Support on your site!
Version: 0.1
Author: Adam Strawson 
Author URI: http://www.adamstrawson.com
License: GPL v3

HipSupport Plugin
Copyright (C) 2014, Adam Strawson - adam@adamstrawson.com

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/


/*
 * An array of timezones that HipChat supports
 * This must be passed when requesting a room
 * 
 * https://www.hipchat.com/docs/api/timezones
 */
$timezones = array("(GMT-11:00) Pacific: Midway" => "Pacific/Midway",
		"(GMT-11:00) Pacific: Pago Pago" => "Pacific/Pago_Pago",
		"(GMT-10:00) Pacific: Johnston" => "Pacific/Johnston",
		"(GMT-10:00) Pacific: Honolulu" => "Pacific/Honolulu",
		"(GMT-10:00) US: Hawaii" => "US/Hawaii",
		"(GMT-9:30) Pacific: Marquesas" => "Pacific/Marquesas",
		"(GMT-9:00) America: Adak (DST)" => "America/Adak",
		"(GMT-9:00) Pacific: Gambier" => "Pacific/Gambier",
		"(GMT-8:00) US: Alaska (DST)" => "US/Alaska",
		"(GMT-8:00) Pacific: Pitcairn" => "Pacific/Pitcairn",
		"(GMT-8:00) America: Anchorage (DST)" => "America/Anchorage",
		"(GMT-7:00) America: Phoenix" => "America/Phoenix",
		"(GMT-7:00) America: Los Angeles (DST)" => "America/Los_Angeles",
		"(GMT-7:00) America: Tijuana (DST)" => "America/Tijuana",
		"(GMT-7:00) US: Pacific (DST)" => "US/Pacific",
		"(GMT-7:00) US: Arizona" => "US/Arizona",
		"(GMT-6:00) Pacific: Easter" => "Pacific/Easter",
		"(GMT-6:00) America: Regina" => "America/Regina",
		"(GMT-6:00) America: Guatemala" => "America/Guatemala",
		"(GMT-6:00) US: Mountain (DST)" => "US/Mountain",
		"(GMT-6:00) America: Denver (DST)" => "America/Denver",
		"(GMT-6:00) America: Belize" => "America/Belize",
		"(GMT-5:00) America: Bogota" => "America/Bogota",
		"(GMT-5:00) America: Winnipeg (DST)" => "America/Winnipeg",
		"(GMT-5:00) America: Chicago (DST)" => "America/Chicago",
		"(GMT-5:00) America: Mexico City (DST)" => "America/Mexico_City",
		"(GMT-5:00) US: Central (DST)" => "US/Central",
		"(GMT-4:30) America: Caracas" => "America/Caracas",
		"(GMT-4:00) America: Anguilla" => "America/Anguilla",
		"(GMT-4:00) America: Toronto (DST)" => "America/Toronto",
		"(GMT-4:00) America: Antigua" => "America/Antigua",
		"(GMT-4:00) America: Aruba" => "America/Aruba",
		"(GMT-4:00) America: Santo Domingo" => "America/Santo_Domingo",
		"(GMT-4:00) US: Eastern (DST)" => "US/Eastern",
		"(GMT-4:00) America: Barbados" => "America/Barbados",
		"(GMT-4:00) Antarctica: Palmer" => "Antarctica/Palmer",
		"(GMT-4:00) America: New York (DST)" => "America/New_York",
		"(GMT-4:00) America: Nassau (DST)" => "America/Nassau",
		"(GMT-4:00) America: Curacao" => "America/Curacao",
		"(GMT-4:00) America: La Paz" => "America/La_Paz",
		"(GMT-4:00) America: Iqaluit (DST)" => "America/Iqaluit",
		"(GMT-4:00) America: Montreal (DST)" => "America/Montreal",
		"(GMT-4:00) America: Santiago" => "America/Santiago",
		"(GMT-3:00) Antarctica: Rothera" => "Antarctica/Rothera",
		"(GMT-3:00) America: Montevideo" => "America/Montevideo",
		"(GMT-3:00) America: Halifax (DST)" => "America/Halifax",
		"(GMT-3:00) America: Argentina: Buenos Aires" => "America/Argentina/Buenos_Aires",
		"(GMT-3:00) America: Buenos Aires" => "America/Buenos_Aires",
		"(GMT-3:00) America: Sao Paulo" => "America/Sao_Paulo",
		"(GMT-3:00) Atlantic: Bermuda (DST)" => "Atlantic/Bermuda",
		"(GMT-2:30) America: St Johns (DST)" => "America/St_Johns",
		"(GMT-2:00) America: Godthab (DST)" => "America/Godthab",
		"(GMT-2:00) America: Noronha" => "America/Noronha",
		"(GMT-1:00) Atlantic: Cape Verde" => "Atlantic/Cape_Verde",
		"(GMT+0:00) UTC" => "UTC",
		"(GMT+0:00) Atlantic: Azores (DST)" => "Atlantic/Azores",
		"(GMT+1:00) Africa: Algiers" => "Africa/Algiers",
		"(GMT+1:00) Africa: Windhoek" => "Africa/Windhoek",
		"(GMT+1:00) Africa: Porto-Novo" => "Africa/Porto-Novo",
		"(GMT+1:00) Africa: Luanda" => "Africa/Luanda",
		"(GMT+1:00) Africa: Lagos" => "Africa/Lagos",
		"(GMT+1:00) Europe: London (DST)" => "Europe/London",
		"(GMT+2:00) Europe: Berlin (DST)" => "Europe/Berlin",
		"(GMT+2:00) Africa: Johannesburg" => "Africa/Johannesburg",
		"(GMT+2:00) Europe: Vienna (DST)" => "Europe/Vienna",
		"(GMT+2:00) Europe: Amsterdam (DST)" => "Europe/Amsterdam",
		"(GMT+2:00) Europe: Berlin (DST)" => "CET",
		"(GMT+2:00) Europe: Andorra (DST)" => "Europe/Andorra",
		"(GMT+2:00) Europe: Tirane (DST)" => "Europe/Tirane",
		"(GMT+2:00) Europe: Brussels (DST)" => "Europe/Brussels",
		"(GMT+3:00) Europe: Helsinki (DST)" => "Europe/Helsinki",
		"(GMT+3:00) Europe: Minsk" => "Europe/Minsk",
		"(GMT+3:00) Asia: Bahrain" => "Asia/Bahrain",
		"(GMT+3:00) Asia: Beirut (DST)" => "Asia/Beirut",
		"(GMT+3:00) Asia: Baghdad" => "Asia/Baghdad",
		"(GMT+3:00) Antarctica: Syowa" => "Antarctica/Syowa",
		"(GMT+3:00) Asia: Jerusalem (DST)" => "Asia/Jerusalem",
		"(GMT+3:00) Asia: Istanbul (DST)" => "Asia/Istanbul",
		"(GMT+4:00) Asia: Yerevan" => "Asia/Yerevan",
		"(GMT+4:00) Asia: Dubai" => "Asia/Dubai",
		"(GMT+4:00) Europe: Moscow" => "Europe/Moscow",
		"(GMT+4:30) Asia: Tehran (DST)" => "Asia/Tehran",
		"(GMT+4:30) Asia: Kabul" => "Asia/Kabul",
		"(GMT+5:00) Asia: Aqtobe" => "Asia/Aqtobe",
		"(GMT+5:00) Antarctica: Mawson" => "Antarctica/Mawson",
		"(GMT+5:00) Asia: Karachi" => "Asia/Karachi",
		"(GMT+5:00) Asia: Baku (DST)" => "Asia/Baku",
		"(GMT+5:30) Asia: Kolkata" => "Asia/Kolkata",
		"(GMT+5:45) Asia: Kathmandu" => "Asia/Kathmandu",
		"(GMT+6:00) Asia: Yekaterinburg" => "Asia/Yekaterinburg",
		"(GMT+6:00) Antarctica: Vostok" => "Antarctica/Vostok",
		"(GMT+6:00) Asia: Dhaka" => "Asia/Dhaka",
		"(GMT+6:00) Asia: Thimphu" => "Asia/Thimphu",
		"(GMT+6:30) Asia: Rangoon" => "Asia/Rangoon",
		"(GMT+7:00) Asia: Omsk" => "Asia/Omsk",
		"(GMT+7:00) Asia: Bangkok" => "ICT",
		"(GMT+7:00) Antarctica: Davis" => "Antarctica/Davis",
		"(GMT+7:00) Asia: Jakarta" => "Asia/Jakarta",
		"(GMT+8:00) Asia: Taipei" => "Asia/Taipei",
		"(GMT+8:00) Asia: Krasnoyarsk" => "Asia/Krasnoyarsk",
		"(GMT+8:00) Antarctica: Casey" => "Antarctica/Casey",
		"(GMT+8:00) Australia: Perth" => "Australia/Perth",
		"(GMT+8:00) Asia: Shanghai" => "Asia/Shanghai",
		"(GMT+8:45) Australia: Eucla" => "Australia/Eucla",
		"(GMT+9:00) Asia: Irkutsk" => "Asia/Irkutsk",
		"(GMT+9:00) Asia: Tokyo" => "Asia/Tokyo",
		"(GMT+9:30) Australia: Adelaide" => "Australia/Adelaide",
		"(GMT+9:30) Australia: Darwin" => "Australia/Darwin",
		"(GMT+10:00) Australia: Brisbane" => "Australia/Brisbane",
		"(GMT+10:00) Australia: Hobart" => "Australia/Hobart",
		"(GMT+10:00) Asia: Yakutsk" => "Asia/Yakutsk",
		"(GMT+10:00) Australia: Sydney" => "Australia/Sydney",
		"(GMT+10:00) Australia: Melbourne" => "Australia/Melbourne",
		"(GMT+10:00) Antarctica: DumontDUrville" => "Antarctica/DumontDUrville",
		"(GMT+10:30) Australia: Lord Howe" => "Australia/Lord_Howe",
		"(GMT+11:00) Pacific: Ponape" => "Pacific/Ponape",
		"(GMT+11:00) Pacific: Noumea" => "Pacific/Noumea",
		"(GMT+11:00) Asia: Vladivostok" => "Asia/Vladivostok",
		"(GMT+11:30) Pacific: Norfolk" => "Pacific/Norfolk",
		"(GMT+12:00) Pacific: Auckland" => "Pacific/Auckland",
		"(GMT+12:00) Antarctica: South Pole" => "Antarctica/South_Pole",
		"(GMT+12:00) Antarctica: McMurdo" => "Antarctica/McMurdo",
		"(GMT+12:00) Asia: Kamchatka" => "Asia/Kamchatka",
		"(GMT+12:00) Pacific: Majuro" => "Pacific/Majuro",
		"(GMT+12:00) Pacific: Wake" => "Pacific/Wake",
		"(GMT+12:00) Pacific: Tarawa" => "Pacific/Tarawa",
		"(GMT+12:45) Pacific: Chatham" => "Pacific/Chatham",
		"(GMT+13:00) Pacific: Apia" => "Pacific/Apia",
		"(GMT+13:00) Pacific: Enderbury" => "Pacific/Enderbury",
		"(GMT+13:00) Pacific: Tongatapu" => "Pacific/Tongatapu",
		"(GMT+14:00) Pacific: Kiritimati" => "Pacific/Kiritimati");

/*
 * Inactive room defaults
 * Default times for when a room should be removed after 
 * being inactive for a set time
 */
$inactive_times = array(
					'1' => '1 Hour',
					'2' => '2 Hours',
					'6' => '6 Hours',
					'12' => '12 Hours',
					'24' => '1 Day',
					'48' => '2 Days',
					'168' => '1 Week',
					'672' => '1 Month'
				);

// Add the menu item to Wordpress
add_action('admin_menu', 'create_hipsupport_options_page');

/**
 * create_hipsupport_options_page
 * Add the menu item to Wordpress
 * 
 * Return void
 */
function create_hipsupport_options_page() {
	add_options_page('HipSupport', 'HipSupport', 'administrator', __FILE__, 'build_hipsupport_options_page');
}

/**
 * build_hipsupport_options_page
 * Build the framework for the options page
 * 
 * Return void
 */
function build_hipsupport_options_page() {
	?>  
	<div id="theme-options-wrap">    
		<div class="icon32" id="icon-tools"> <br /> </div>    
		<h2>HipSupport</h2>    
		<p>Enter your HipChat details below to set up HipSupport</p>    
		<form method="post" action="options.php" enctype="multipart/form-data">  
			<?php settings_fields('hipsupport_options'); ?>  
			<?php do_settings_sections(__FILE__); ?>  
			<p class="submit">    
				<input name="Submit" type="submit" class="button-primary" value="<?php esc_attr_e('Save Changes'); ?>" />  
			</p>
		</form>
	</div>
	<?php
}

// Register and build the HipSupport fields
add_action('admin_init', 'register_and_build_hipsupport_fields');

/**
 * register_and_build_hipsupport_fields
 * Register and Build the fields for HipSupport
 * 
 * Return void
 * 
 */
function register_and_build_hipsupport_fields() {

	// Register the settings
	register_setting('hipsupport_options', 'hipsupport_options', 'validate_hipsupport_setting');
	
	// Add the setting sections
	add_settings_section('main_section', 'Main Settings', 'section_cb', __FILE__);
	add_settings_section('notificaiton_section', 'Notifications', 'section_cb', __FILE__);
	add_settings_section('chat_section', 'Chat Options', 'section_cb', __FILE__);
	
	// Main Section
	add_settings_field('chat_status', 'Chat Status:', 'chat_status_setting', __FILE__, 'main_section');
	add_settings_field('owner_user_id', 'Owner User ID:', 'owner_user_id_setting', __FILE__, 'main_section');
	add_settings_field('api_token', 'API Token:', 'api_token_setting', __FILE__, 'main_section');
	add_settings_field('cleanup', 'Inactive Room Deletion:', 'cleanup_setting', __FILE__, 'main_section');
	
	// Notification Section
	add_settings_field('room_id', 'Room ID to send notifications to:', 'room_id_setting', __FILE__, 'notificaiton_section');
	
	// Chat Section
	add_settings_field('chat_title', 'Chat Window Title:', 'chat_title_setting', __FILE__, 'chat_section');
	add_settings_field('welcome_msg', 'Welcome Message:', 'welcome_msg_setting', __FILE__, 'chat_section');
	add_settings_field('timezone', 'Timezone:', 'timezone_setting', __FILE__, 'chat_section');
	
}

/**
 * validate_setting
 * 
 * Validate HipSupport Options
 * 
 * @param array $hipsupport_options
 * @return array
 */
function validate_hipsupport_setting($hipsupport_options) {
	return $hipsupport_options;
}

/**
 * section_cb
 * Section CallBack
 * 
 * Return void
 */
function section_cb() {}

/**
 * chat_status_setting
 * Chat Status Settings
 * 
 * Return void
 */
function chat_status_setting() {
	$options = get_option('hipsupport_options');  
	echo "<select name='hipsupport_options[chat_status]'>
			<option ".($options['chat_status'] == 'offline' ? 'selected' : '' )." value='offline'>Offline</option>
			<option ".($options['chat_status'] == 'online' ? 'selected' : '' )." value='online'>Online</option>
		</select>";
}

/**
 * owner_user_id_setting
 * Owner User ID Settings
 *
 * Return void
 */
function owner_user_id_setting() {
	$options = get_option('hipsupport_options');
	echo "<input name='hipsupport_options[owner_user_id]' type='number' value='{$options['owner_user_id']}' />";
	echo '<p class="description">This needs to be an admin user that has permission to create rooms.</p>';
}

/**
 * api_token_setting
 * API Token Settings
 *
 * Return void
 */
function api_token_setting() {
	$options = get_option('hipsupport_options');
	echo "<input name='hipsupport_options[api_token]' type='text' value='{$options['api_token']}' />";
}

/**
 * cleanup_setting
 * Cleanup Settings
 *
 * Return void
 */
function cleanup_setting() {
	global $inactive_times;
	 
	$options = get_option('hipsupport_options');
	echo "<select name='hipsupport_options[cleanup]'>";
	foreach($inactive_times as $key => $value){
		echo "<option ".($options['cleanup'] == $key ? 'selected' : '')." value='".$key."'>".$value."</option>";
	}
	echo '</select>';
	echo '<p class="description">How long a room should be inactive before it is deleted.</p>';
}

/**
 * room_id_setting
 * Notification Room ID Settings
 *
 * Return void
 */
function room_id_setting() {
	$options = get_option('hipsupport_options');
	echo "<input name='hipsupport_options[room_id]' type='number' value='{$options['room_id']}' />";
}

/**
 * chat_title_setting
 * Chat Title Settings
 *
 * Return void
 */
function chat_title_setting() {
	$options = get_option('hipsupport_options');
	
	if(!isset($options['chat_title']) || is_null($options['chat_title'])) { $options['chat_title'] = 'Chat with us!'; }
	
	echo "<input name='hipsupport_options[chat_title]' type='text' value='{$options['chat_title']}' />";
}

/**
 * welcome_msg_setting
 * Welcome Message Settings
 *
 * Return void
 */
function welcome_msg_setting() {
	$options = get_option('hipsupport_options');
	
	if(!isset($options['welcome_msg']) || is_null($options['welcome_msg'])) { $options['welcome_msg'] = 'Hello, How can we help you?'; }
	
	echo "<textarea name='hipsupport_options[welcome_msg]' rows='4' cols='38'>{$options['welcome_msg']}</textarea>";
	echo '<p class="description">A default message the user will first see. Set to blank for no message.</p>';
}

/**
 * timezone_setting
 * Timezone Settings
 *
 * Return void
 */
function timezone_setting() {
	global $timezones;
	
	$options = get_option('hipsupport_options');
	
	if(!isset($options['timezone']) || is_null($options['timezone'])) { $options['timezone'] = 'UTC'; }
	
	echo "<select name='hipsupport_options[timezone]'>";
	foreach($timezones as $key => $value){
		echo "<option ".($options['timezone'] == $value ? 'selected' : '')." value='".$value."'>".$key."</option>";
	}
	echo "</select>";

}

// Register the activation hook for HipSupport
register_activation_hook( __FILE__, 'hipsupport_cleanup_activation' );
/**
 * hipsupport_cleanup_activation
 * Set up the hourly cleanup event
 * 
 * Return void
 */
function hipsupport_cleanup_activation() {
	wp_schedule_event( time(), 'hourly', 'hipsupport_cleanup_event_hourly' );
}

// Add an action for the hourly clenup event
add_action( 'hipsupport_cleanup_event_hourly', 'hipsupport_cleanup' );

/**
 * hipsupport_cleanup
 * Clean up inactive rooms
 * 
 * Return void
 */
function hipsupport_cleanup() {

	$options = get_option('hipsupport_options');
	
	// If no cleanup time is set, default to 1 hour
	if(!isset($options['cleanup']) || is_null($options['cleanup'])) { $options['cleanup'] = '1'; }
	
	// Call the HipSupport cleanup task
	$cleanup = new HipSupport\HipSupport();
	$cleanup->clean_up($options['cleanup']);
	
	return;

}

//Register the deactivation hook for HipSupport
register_deactivation_hook( __FILE__, 'hipsupport_cleanup_deactivation' );
/**
 * hipsupport_cleanup_deactivation
 * Remove the hourly cleanup event
 *
 * Return void
 */
function hipsupport_cleanup_deactivation() {
	wp_clear_scheduled_hook( 'hipsupport_cleanup_event_hourly' );
}