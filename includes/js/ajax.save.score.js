function round(value, decimals) {
    return Number(Math.round(value+'e'+decimals)+'e-'+decimals);
}

function save_score($){
    var typingTimer;
    var doneTypingInterval = 1000;
    jQuery('.song-unique-score-input').on('input', function() {
        clearTimeout(typingTimer);
        var input = jQuery(this);
        typingTimer = setTimeout(function() {
        	
        	var error = 0;
		var finalNumber = input.val();
		var postid = jQuery('.postid').html();
		var userid = jQuery('.userid').html();
		
		if(input.val() > 5){	
			error = 1;
			jQuery('.song-unique-score-input').css('border', '0.5px solid red');
			jQuery('.newarray').html('Value need to be under 5.');
		}
		
		if(input.val() < 0){	
			error = 1;
			jQuery('.song-unique-score-input').css('border', '0.5px solid red');
			jQuery('.newarray').html('Value need to be below 0.');
		}
		
		if(input.val() > 0 && input.val() < 5){	
			error = 0;
			jQuery('.song-unique-score-input').css('border', '0.5px solid gray');
		}
            
        	if(error == 0){
			jQuery.ajax({
				type: 'post',
				url: save_score_ajax_url,
				data: {
				    'userid':userid,
				    'postid': postid,
				    'value': round(finalNumber, 2),
				    'action': 'save_score'
				},
				dataType: 'json',
				success: function(data){
				        jQuery('.newarray').html(data);
				},
				error: function(errorThrown){
				    console.log(errorThrown);
				}
			});
		}
		
        }, doneTypingInterval);
    });
}

jQuery(document).ready(function($) {
    save_score($);
});