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

namespace HipSupport;

class HipSupport {
	
	protected $room_name;
	protected $owner_user_id;
	protected $notification = array(
		'room_id' => NULL,
		'from' => 'HipSupport',
		'message' => 'A new live chat session has been initiated.<br />Go to room: <strong>[room_name]</strong>.',
		'message_format' => 'html',
		'notify' => true,		
		'color' => 'green'		
	);
	protected $chat_options = array(
		'anonymous' => true,
		'minimal' => true, 
		'welcome_msg' => 'How can we help you?', // Default
		'timezone' => 'utc' // Default
	);

	/**
	 * HipChat instance.
	 *
	 * @var HipChat\HipChat
	 */
	protected $hipchat;

	/**
	 * Create a HipSupport instance.
	 *
	 * @param  HipChat\HipChat  $hipchat
	 * @return void
	 */
	//public function __construct()
	public function __construct($hipchat)
	{
		$this->hipchat = $hipchat;
	}

	/**
	 * start
	 * return the room array
	 *
	 * @return mixed
	 */
	public function start()
	{		
		// Create the room
		$room = $this->create_room($this->room_name, $this->owner_user_id);

		// Build the client URL
		$room->hipsupport_url = $this->build_url($room->guest_access_url);

		// Notify a room of the new chat session
		$this->notify($room);

		return $room;
	}
	
	/**
	 * setRoom
	 * Set the room name
	 * 
	 * @param string $room
	 * @return \HipSupport\HipSupport
	 */
	public function set_room($room){	
		$this->room_name = $room;
		return $this;
	}
	
	/**
	 * setOwnerUserID
	 * Set the admin user ID
	 * 
	 * @param int $owner_user_id
	 * @return \HipSupport\HipSupport
	 */
	public function set_owner_user_id($owner_user_id){
		$this->owner_user_id = $owner_user_id;
		return $this;
	}
	
	/**
	 * setNotificationValue
	 * Set a value for the Notification Array
	 * 
	 * @param string $key
	 * @param mixed $value
	 * @return \HipSupport\HipSupport
	 */
	public function set_notification_value($key, $value){
		
		if(array_key_exists($key, $this->notification)){
			$this->notification[$key] = $value;	
		}
		return $this;		
	}
	
	/**
	 * setChatOptionsValue
	 * Set a value for the Chat Options Array
	 * 
	 * @param string $key
	 * @param mixed $value
	 * @return \HipSupport\HipSupport
	 */
	public function set_chat_options_value($key, $value){
	
		if(array_key_exists($key, $this->chat_options)){
			$this->chat_options[$key] = $value;
		}
		return $this;
	}

	/**
	 * create_room
	 * Create a public new room
	 *
	 * @param  string  $name
	 * @param  integer  $owner_user_id
	 * @return object
	 */
	public function create_room($name, $owner_user_id = null)
	{
		$i = 1;
		$room_name = $name;
		$owner_user_id = $owner_user_id;

		// Make sure that a room doesn't already exist with this name.
		// If one does exist, add a number to the end of the name.
		while ($this->room_exists($room_name))
		{
			$room_name = $name . ' ' . $i++;
		}

		// Create room.
		$room = $this->hipchat->create_room($room_name, $owner_user_id, null, null, true);

		return $room->room;
	}

	/**
	 * room_exists
	 * Check to see if a room name already exists.
	 *
	 * @param  string  $name
	 * @return boolean
	 */
	public function room_exists($name)
	{
		$room = null;

		try
		{
			$room = $this->hipchat->get_room($name);
		}
		catch (\HipChat\HipChat_Exception $e)
		{
			return false;
		}

		return (boolean) $room;
	}
	
	/**
	 * cleanUp
	 * Cleanup task to delete inactive rooms
	 * @param int $duration
	 * 
	 * return void
	 */
	public function clean_up($duration = '1'){
			
			// Get a list of all the HipChat rooms
			$rooms = $this->hipchat->get_rooms();
			
			//Get the unixtime for the duration to clear
			$duration = strtotime("-".$duration." hour");
			
			// Loop through all the rooms
			foreach($rooms as $room){
				
				//Find only the HipSupport rooms, so not to delete any non-HipSupport rooms
				if (strpos($room->name,'HipSupport') !== false) {
					
					// If inactive longer than the inactive duation, delete the room
					if ($duration >= $room->last_active) {
						// Delete the room
						$this->hipchat->delete_room($room->room_id);
					}
				}
			}
			return;
	}

	/**
	 * buildUrl
	 * Get the hash from a Guest Access URL
	 *
	 * @param  string  $url
	 * @param  array  $options
	 * @return string
	 */
	protected function build_url($url)
	{
	
		// Set URL params required by HipChat
		$params['minimal'] = $this->chat_options['minimal'];
		$params['anonymous'] = $this->chat_options['anonymous'];
		$params['timezone'] = $this->chat_options['timezone'];
		$params['welcome_msg'] = $this->chat_options['welcome_msg'];

		return $url . '?' . http_build_query($params);
	}

	/**
	 * notify
	 * Send notification that a new room has been created.
	 *
	 * @param  array  $options
	 * @param  object  $room
	 * @return boolean
	 */
	protected function notify($room = null)
	{
		// Extrat the notifcations array
		extract($this->notification);
		
		// If no room_id is set, return false
		if (!isset($room_id) or !$room_id) return false;

		// Insert the room name
		if ($room) $message = str_replace('[room_name]', $room->name, $message);

		// Send notifcation
		return (boolean) $this->hipchat->message_room($room_id, $from, $message, $notify, $color, $message_format);
	}

}