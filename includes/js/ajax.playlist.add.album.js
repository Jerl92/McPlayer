function ajax_playlist_add_album($, object_id)  {
    
    $.fn.ready();
	'use strict';

                $.ajax({    
                    type: 'post',
                    url: add_album_ajax_url,
                    data: {
                        'object_id': object_id.postid_album,
                        'action': 'add_track_album'
                    },
                    dataType: 'JSON',
                    success: function(data){
                        object_id.postid.forEach(function(element, index) {
                            setTimeout(function() {
                                ajax_playlist($, element);
                                ajax_playlist_add_sidebar($, element);
                            }, index*100);
                        }, this);   
                    },
                    error: function(errorThrown){
                        console.log(errorThrown);
                    }
            });
    
    }