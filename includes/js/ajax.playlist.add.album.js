function ajax_playlist_add_album($, object_id)  {
    
                $.ajax({    
                    url: add_album_ajax_url,
                    type: 'post',
                    data: {
                        'object_id': object_id,
                        'action': 'add_track_album'
                    },
                    dataType: 'JSON',
                    success: function(data){
                        //print stuff heres  
                        data.forEach(function(element) {
                            ajax_playlist($, element); 
                            sleep(50);
                        }, this);
                        console.log( ajax_playlist_add_sidebar($, object_id));                     
                    },
                    error: function(errorThrown){
                        //error stuff here.text
                        //console.log(errorThrown);
                    }
            });
    
    }

    function sleep(delay) {
        var start = new Date().getTime();
        while (new Date().getTime() < start + delay);
    }