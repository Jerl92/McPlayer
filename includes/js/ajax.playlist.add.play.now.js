function ajax_playlist_play_now($, object_id)  {
    
        $.ajax({    
            url: add_play_now_ajax_url,
            type: 'post',
            data: {
                'object_id': object_id,
                'action': 'add_play_now'
            },
            dataType: 'JSON',
            success: function(data){

                    $('#player56s-playnow').html(data);

                    $(".player56s").player56s($);

                    $('#player56s-playnow').html(null);
 
            },
            error: function(errorThrown){
                //error stuff here.text
            }
        });
    
    }