function send_form($){

	$(".mcplayer-contact-from").on("click", function() {
	
		var fullname = jQuery('#fullname').val();	
		var email = jQuery('#email').val();	
		var feedback = jQuery('#feedback').val();
		
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
		
	});	

}

jQuery(document).ready(function($) {
    send_form($);
});