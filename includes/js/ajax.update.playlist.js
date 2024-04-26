
function checkValue(value, arr) {
    var status = 0;

    for (var i = 0; i < arr.length; i++) {
        var name = arr[i];
        if (name == value) {
            status = 1;
            break;
        }
    }

    return status;
}

function update_playlist($)  {

    $.fn.ready();
	'use strict';

    $.ajax({    
        type: 'post',
        url: update_playlist_ajax_url,
        data: {
            'action': 'update_playlist'
        },
        dataType: 'JSON',
        success: function(data){
            if(data === null){
                var data = [];
            }
            if($('#player56s-load-playlist').val().length === 0){
                data.forEach(function(element, index) {
                    if($('#rs-item-'+element).html()){
                        //
                    } else {
                        ajax_playlist($, element);
                        ajax_playlist_add_sidebar($, element);	
                    }
                    $('.playlist_matches_count').html(index+1);
                }, this);
                $('.rs-item-saved-for-later').each(function() {
                    var data_id = $(this).data("object-id");
                    if(checkValue(data_id, data) === 0) {
                        ajax_playlist_remove_sidebar($, data_id);
                        ajax_playlist_remove_track($, data_id);
                    }
                }, this);
            }
        },
        error: function(errorThrown){
            //error stuff here.text
        }
});

}

jQuery(document).ready(function($) {
    setInterval(function(){
        update_playlist($);
    }, 500);
});