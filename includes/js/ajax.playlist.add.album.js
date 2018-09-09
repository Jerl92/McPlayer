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
                        //print stuff heres  
                        var i = 0;
                        data.forEach(function(element, index) {
                            if (index == i)  {
                                ajax_playlist($, element);
                                $("#album-class-artist-list-id-"+element+" a").addClass("saved");
                                $("#album-class-artist-list-id-"+element+" a").attr("data-original-title", "Remove");
                                [i++];
                            }
                            sleep(25);
                        }, this);                 
                    },
                    error: function(errorThrown){
                        //error stuff here.text
                        //console.log(errorThrown);
                    }
            });
    
    }