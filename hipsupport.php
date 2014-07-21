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
 * Require various classes, and the admin panel
 */
require_once(WP_PLUGIN_DIR . '/hipsupport/admin/hipsupport-admin.php');
require_once(WP_PLUGIN_DIR . '/hipsupport/includes/hipsupport.class.php');
require_once(WP_PLUGIN_DIR . '/hipsupport/includes/hipchat.class.php');

/**
 * hipsupportFrontend
 * 
 * HipSupport frontend, adds the chat window.
 * 
 * return void
 */
function hipsupport_frontend(){
	// Get the HipSupport options
	$hipsupport_options = get_option('hipsupport_options');
	
	// If no options are set, assume HipSupport hasn't been set up yet.
	if(!is_array($hipsupport_options)) return;
	// Check wither HipSupport is online
	if($hipsupport_options['chat_status'] == 'offline') return;
	
	// Queue up the CSS and JS
	wp_enqueue_style('hipsupport', plugins_url( '/public/css/hipsupport.min.css', __FILE__ ));
	wp_enqueue_script('hipsupport', plugins_url( '/public/js/hipsupport.min.js', __FILE__ ));
	wp_localize_script('hipsupport', 'hipsupport', array('ajaxurl' => admin_url('admin-ajax.php')));
	
	// HipSupport Container
	echo "<div id='hipsupport-container'>
			<div class='hipsupport-toggle hipsupport-closed'><span>".$hipsupport_options['chat_title']."</span></div>
			<div class='hipsupport-content'>
			</div>
			<div class='hipsupport-placeholder' style='display:none;'>
				<div class='hipsupport-wait'>
					<img align='middle' src='".plugins_url( '/public/img/spin.gif', __FILE__ )."' alt='Please Wait...' />
					<span>Connecting...</span>
				</div>
			</div>
		</div>";
		
}

/**
 * hipsupportAjax
 * 
 * Ajax processing for HipSupport, returns room information
 * 
 * return void
 * 
 */
function hipsupport_ajax(){
	
	// Get the HipSupport options
	$hipsupport_options = get_option('hipsupport_options');
	
	// If no options are set, assume HipSupport hasn't been set up yet.
	// Shouldn't hit this if it's set up, but let's be safe.
	if(!is_array($hipsupport_options) || $hipsupport_options['chat_status'] == 'offline') return;
	
	// Initialised HipChat Class
	$HipChat = new HipChat\HipChat($hipsupport_options['api_token']);
	// Initialise the HipSupport wrapper
	$HipSupport = new HipSupport\HipSupport($HipChat);
	
	// Set the various required params
	$HipSupport->set_room('HipSupport - '.date('d-m-Y H:i'))
				->set_owner_user_id($hipsupport_options['owner_user_id'])
				->set_notification_value('room_id', $hipsupport_options['room_id'])
				->set_chat_options_value('welcome_msg', $hipsupport_options['welcome_msg'])
				->set_chat_options_value('timezone', $hipsupport_options['timezone']);
	
	// Build the room
	$room = $HipSupport->start();
	
	// If something errored, or no room URL, return an error, otherwise return the room URL
	if(!empty($room) && isset($room->hipsupport_url)){
		$data = array(
			'status' => 'success',
			'url'	=> $room->hipsupport_url,
		);
	} else {
		$data = array(
				'status' => 'error',
				'msg'	=> 'Sorry, something went wrong. Refreshing the page usually fixes it.'
		);
	}
	
	// return json
	echo json_encode($data);
	die;
}

// Add Actions for WP
add_action( 'wp_ajax_hipsupport', 'hipsupport_ajax' );
add_action( 'wp_ajax_nopriv_hipsupport', 'hipsupport_ajax' );
add_action( 'wp_footer', 'hipsupport_frontend' );