/* 
Plugin Name: HipSupport
Plugin URI: http://www.adamstrawson.com/HipSupport
Description: HipChat Support on your site!
Version: 0.1
Author: Adam Strawson 
Author URI: http://www.adamstrawson.com
License: GPL2 
*/

// Has jQuery loaded?
jQuery(function(){
	// Initialise HipSupport
	hipsupportInit();
})

/**
 * hipsupportInit
 * 
 * Core function for HipSupport
 * 
 * return void
 */
function hipsupportInit(){
	
	// Click trigger for HipSupport being opened
	jQuery('body').on('click', '.hipsupport-open', function(){
		
		// Close HipSupport
		jQuery('.hipsupport-content').slideUp();
		
		// Remove/Add various classes
		jQuery('.hipsupport-toggle').removeClass('hipsupport-open');
		jQuery('.hipsupport-toggle').addClass('hipsupport-closed');
		
		// Resize the container back to the slim width
		jQuery("#hipsupport-container").animate({
		    width: "300px"
		  }, 500, function() {
		    // Animation complete.
		  });
	});
	
	//Click trigger for HipSupport being closed
	jQuery('body').on('click', '.hipsupport-closed, button.hipsupport-refresh', function(){
		
		// Define a few repeat selectors
		wrapper = jQuery('#hipsupport-container');
		content = jQuery('.hipsupport-content');
		placeholderHtml = jQuery('.hipsupport-placeholder').html();
		
		// If an iFrame exists, a chat session has already been started
		if(jQuery('.hipsupport-content iframe').length > 0){
			
			// Display the container
			content.slideDown();
			
			// Add/remove various classes
			jQuery('.hipsupport-toggle').addClass('hipsupport-open');
			jQuery('.hipsupport-toggle').removeClass('hipsupport-closed');
			
			// Increase container width
			jQuery("#hipsupport-container").animate({
			    width: "400px"
			  }, 500, function() {
			    // Animation complete.
			  });
			
		} else {
			
			// Show loading placeholder while we call to HipChat
			content.html(placeholderHtml);
					
			// If we're not retring form an error
			if(this.className == 'hipsupport-toggle hipsupport-closed'){
				
				//Display the container
				content.slideDown();
				
				// Add/remove various classes
				jQuery('.hipsupport-toggle').addClass('hipsupport-open');
				jQuery('.hipsupport-toggle').removeClass('hipsupport-closed');
			} // if(this.className == 'hipsupport-toggle hipsupport-closed'){
			
			// Confirm that HipSupport is open
			if(!jQuery('#hipsupport-container').hasClass('hipsupport-open')){

				// Ajax GET for the HipChat URL
				jQuery.get(hipsupport.ajaxurl, {'action':'hipsupport'}, function(response) {

					console.log(response);
					// Parse the response
					res = JSON.parse(response);
					
					// If the response is a success
					if(res.status == 'success'){
						
						// Insert HipSupport iFrame
						content.html('<iframe height="100%" width="100%" src="'+res.url+'"></iframe>');
						
						// Widen the container
						jQuery("#hipsupport-container").animate({
						    width: "400px"
						  }, 500, function() {
							  // Animation Complete
						  });
					} else {
						// Show error message and retry button
						content.html('<div class="hipsupport-error"><p>'+res.msg+'</p><p><button class="hipsupport-refresh">Try Again.</button></p></div>');
					} // if(res.status == 'success'){
				});
			} // if(!jQuery('#hipsupport-container').hasClass('hipsupport-open')){

		} // if(jQuery('.hipsupport-content iframe').length > 0){
			
	});
	
}
