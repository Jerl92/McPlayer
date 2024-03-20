function ajax_playlist_add_album($, object_id)  {
                $.ajax({    
                    type: 'post',
                    url: add_album_ajax_url,
                    data: {
                        'object_id': object_id,
                        'action': 'add_track_album'
                    },
                    dataType: 'JSON',
                    success: function(data){
                        data.forEach(function(element, index) {
                            ajax_playlist($, element);
                            ajax_playlist_add_sidebar($, element);
                        }, this);        
                    },
                    error: function(errorThrown){
                        console.log(errorThrown);
                    }
            });
    
    }