function ajax_playlist_remove_track($, object_id) {
                
                $.ajax({    
                    type: 'post',
                    url: remove_track_ajax_url,
                    data: {
                        'object_id': object_id,
                        'action': 'remove_track',
                    },
                    dataType: 'JSON',
                    success: function(data){
                        //print stuff heres
                        console.log(data);
                        $("#player56s-removetrack").html(data);  
                        $(".player56s").player56s($); 
                        $("#player56s-removetrack").html(null);
                        $("#postid-"+object_id+" rs-item-nav a").removeClass("saved");
                        $("#add-play-now-id-"+object_id).removeClass("saved");
                        ajax_playlist_remove_page_btn($, object_id);
                    },
                    error: function(errorThrown){
                        //error stuff here
                    },
            });
    
    }
    
