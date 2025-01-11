function ajax_playlist_play_now($, object_id)  {
    
    jQuery.ajax({    
        type: 'post',
        url: add_track_ajax_url,
        data: {
            'object_id': object_id,
            'action': 'add_track'
        },
        dataType: 'JSON',
        success: function(data){

            jQuery("#player56s-addtrack").html(data);

            jQuery(".player56s").player56s($);
                        
            jQuery("#player56s-addtrack").html(null);

            jQuery('#player56s-playnow').html(object_id);

            jQuery(".player56s").player56s($);
            
            jQuery('#player56s-playnow').html(null);

        },
        error: function(errorThrown){
            //error stuff here.text
        }
    });

}