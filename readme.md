=== Plugin Name ===
Contributors: adamstrawson
Tags: hipsupport, hipchat, chat, livechat
Requires at least: 3.0.1
Tested up to: 3.9
Stable tag: 0.1
License: GPLv3
License URI: http://www.adamstrawson.com/HipSupport

Interact and communicate with your sites visitors via the HipChat client. 

== Description ==

Interact and communicate with your sites visitors via the HipChat client.

== Installation ==

## Manual Installation  

1. Upload the HipSupport directory to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Update the option under 'Settings' -> 'HipSupport'

## Settings

**Chat Status**  
Wither you're avalible to chat, set to online to display the chat box, or offline to hide the chatbox.

**Owner User ID**  
The ID of a HipChat admin user that has permission to create a room. You can find this ID by viewing the profile of the admin user, and getting the ID from the URL (https://subdomain.hipchat.com/people/show/877512/username = 877512)

**API Token**  
Login to HipChat as an admin and generate an API Token - https://subdomain.hipchat.com/admin/api

**Inactive Room Deletion**  
How long a room should be inactive before it is deleted. Defaults to 1 hour.

**Room ID to send notifications to**  
An ID of an existing room which notifications of a new chat session are sent to. You can find the room ID by viewing a the room in the web client and getting the ID from the URL (https://subdomain.hipchat.com/rooms/show/705622/test_room = 705622)

**Chat Window Title**  
The title that is displayed on the chat box

**Welcome Message**  
The message that is first posted when a user starts a chat session

**Timezone**  
Set your timezone so that the correct times are shown with messages.


== Frequently Asked Questions ==

= A question that someone might have =

An answer to that question.

= What about foo bar? =

Answer to foo bar dilemma.

== Screenshots ==

1. This screen shot description corresponds to screenshot-1.(png|jpg|jpeg|gif). Note that the screenshot is taken from
the /assets directory or the directory that contains the stable readme.txt (tags or trunk). Screenshots in the /assets 
directory take precedence. For example, `/assets/screenshot-1.png` would win over `/tags/4.3/screenshot-1.png` 
(or jpg, jpeg, gif).
2. This is the second screen shot

== Changelog ==

= 0.1 =

* Initial beta release. 
