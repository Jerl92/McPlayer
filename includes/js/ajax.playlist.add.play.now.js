function ajax_playlist_play_now($, object_id)  {

    $.ajax({    
        type: 'post',
        url: add_track_ajax_url,
        data: {
            'object_id': object_id,
            'action': 'add_track'
        },
        dataType: 'JSON',
        success: function(data){

            $("#player56s-addtrack").html(data);

            $('#player56s-playnow').html(object_id);

            $(".player56s").player56s($);
            
            $('#player56s-playnow').html(null);
            
            $("#player56s-addtrack").html(null);

        },
        error: function(errorThrown){
            //error stuff here.text
        }
    });

}