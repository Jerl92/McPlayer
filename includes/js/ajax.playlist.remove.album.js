function ajax_playlist_remove_album($, object_id)  {

                $.ajax({    
                    type: 'post',
                    url: add_album_ajax_url,
                    data: {
                        'object_id': object_id.postid_album,
                        'action': 'remove_track_album'
                    },
                    dataType: 'JSON',
                    success: function(data){ 
                        data.forEach(function(element, index) {
                            setTimeout(function() {
                                ajax_playlist_remove_sidebar($, element);
                                ajax_playlist_remove_track($, element);
                            }, index*250);
                        }, this);

                    },
                    error: function(errorThrown){
                        console.log(errorThrown);
                    }
            });
    
    }