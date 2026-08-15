function send_form($){

	$(".mcplayer-contact-from").on("click", function(event) {
	    event.preventDefault();
		event.stopPropagation();
		event.stopImmediatePropagation();
		
		var error = 0;
		var fullname = jQuery('#fullname').val();	
		var email = jQuery('#email').val();	
		var feedback = jQuery('#feedback').val();
		
		if(fullname.length < 3) { 
			error = 1;
			jQuery('#fullname').css('border', '0.5px solid red');
			jQuery('.mcplayer-contact-from-error-fullname').html('You need at least 3 characters for the full name.');
		} else  {'' 
			jQuery('#fullname').css('border', '0.5px solid gray');
			jQuery('.mcplayer-contact-from-error-fullname').html('');
		}
		
		var regex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
		if (!regex.test(email)) {
			error = 1;
			jQuery('#email').css('border', '0.5px solid red');
			jQuery('.mcplayer-contact-from-error-email').html('Not a valid Email adresse.');
		} else { 
			jQuery('#email').css('border', '0.5px solid gray');
			jQuery('.mcplayer-contact-from-error-email').html('');
		}
		
		if(feedback.length < 15) { 
			error = 1;
			jQuery('#feedback').css('border', '0.5px solid red');
			jQuery('.mcplayer-contact-from-error-feedback').html('You need at least 15 characters for the feedback.');
		} else  { 
			jQuery('#feedback').css('border', '0.5px solid gray');
			jQuery('.mcplayer-contact-from-error-feedback').html('');
		}
		
		if(error === 0){ 
			jQuery.ajax({
				type: 'post',
				url: send_form_ajax_url,
				data: {
				    'fullname': fullname,
				    'email': email,
				    'feedback': feedback,
				    'action': 'send_form'
				},
				dataType: 'json',
				success: function(data){
				        jQuery('.send_form').html('');
				        jQuery('.send_form').html(data);
				},
				error: function(errorThrown){
				    console.log(errorThrown);
				}
			});
		}
		
	});	

}

jQuery(document).ready(function($) {
    send_form($);
});