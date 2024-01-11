function ajax_playlist_remove_album($, object_id)  {
    
                $.ajax({    
                    type: 'post',
                    url: add_album_ajax_url,
                    data: {
                        'object_id': object_id,
                        'action': 'remove_track_album'
                    },
                    dataType: 'JSON',
                    success: function(data){
                        //print stuff heres   
                        data.forEach(function(element) {
                            $("#player56s-removetrack").html(element);
                            $(".player56s").player56s($);
                            $("#player56s-removetrack").html(null);
                            sleep(75);   
                            $("#rs-item-"+element).remove();
                            $("#album-class-artist-list-id-"+element+" a").removeClass("saved");
                            $(".album-"+element+" li a").removeClass("saved");
                        }, this); 
                        ajax_playlist_update_sidebar($, object_id);
                    },
                    error: function(errorThrown){
                        console.log(errorThrown);
                    }
            });
    
    }