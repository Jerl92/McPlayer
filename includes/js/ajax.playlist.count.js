function count_playlist(currentTrack) {

    jQuery.ajax({    
        type: 'post',
        url: count_playlist_ajax_url,
        data: {
            'object_id': currentTrack,
            'action': 'count_play'
        },
        dataType: 'JSON',
        success: function(data){
            jQuery( "#add_count" ).html(data);
            setTimeout(function() {
                jQuery( "#add_count" ).html(null);
            }, 7500);
           jQuery( ".count-play-loop-sidebar-"+currentTrack).html(data);
           jQuery( ".count-play-loop-album-"+currentTrack).html(data);
        },
        error: function(errorThrown){
            console.log(errorThrown);
        }
    });
}