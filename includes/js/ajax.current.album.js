
function current_album($)  {

    $.ajax({    
        type: 'post',
        url: current_album_ajax_url,
        data: {
            'action': 'current_album'
        },
        dataType: 'JSON',
        success: function(data){
            data.forEach(function(element) {
                $('.rs-save-for-later-button-album').each(function() {
                    var data_id = $(this).data("object-id");
                    if(data_id == element){
                        $(this).addClass('saved');
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