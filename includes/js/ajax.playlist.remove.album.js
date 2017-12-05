function ajax_playlist_remove_album($, object_id)  {
    
                $.ajax({    
                    url: add_album_ajax_url,
                    type: 'post',
                    data: {
                        'object_id': object_id,
                        'action': 'remove_track_album',
                    },
                    dataType: 'JSON',
                    success: function(data){
                        //print stuff heres   
                        data.forEach(function(element) {
                            $("#player56s-removetrack").html(element);
                            $(".player56s").player56s($, object_id);
                            $("#player56s-removetrack").html(null);    
                        }, this);         
                      //  ajax_playlist_add_sidebar($, object_id);     
                    },
                    error: function(errorThrown){
                        //error stuff here.text
                        //console.log(errorThrown);
                    },
            });
    
    }