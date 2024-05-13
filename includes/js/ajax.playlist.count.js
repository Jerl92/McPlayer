function count_playlist($, currentTrack) {

    $.ajax({    
        type: 'post',
        url: count_playlist_ajax_url,
        data: {
            'object_id': currentTrack,
            'action': 'count_play'
        },
        dataType: 'JSON',
        success: function(data){
            //
        },
        error: function(errorThrown){
            console.log(errorThrown);
        }
    });
}