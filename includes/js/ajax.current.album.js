
function current_album($)  {

    jQuery.ajax({    
        type: 'post',
        url: current_album_ajax_url,
        data: {
            'action': 'current_album'
        },
        dataType: 'JSON',
        success: function(data){
            data.forEach(function(element) {
                jQuery('.rs-save-for-later-button-album').each(function() {
                    var data_id = jQuery(this).data("object-id");
                    if(data_id == element){
                        jQuery(this).addClass('saved');
                    }
                }); 
            }, this); 
            
        },
        error: function(errorThrown){
            //error stuff here.text
        }
});

}

jQuery(document).ready(function($) {
	current_album($);
});