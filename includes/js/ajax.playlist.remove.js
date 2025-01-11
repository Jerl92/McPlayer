function ajax_playlist_remove_track($, object_id) {

                jQuery.ajax({    
                    type: 'post',
                    url: remove_track_ajax_url,
                    data: {
                        'object_id': object_id,
                        'action': 'remove_track',
                    },
                    dataType: 'JSON',
                    success: function(data){
                        jQuery("#player56s-removetrack").html(data);  
                        jQuery(".player56s").player56s($); 
                        jQuery("#player56s-removetrack").html(null);
                        jQuery("#postid-"+object_id+" rs-item-nav a").removeClass("saved");
                        jQuery("#add-play-now-id-"+object_id).removeClass("saved");
                        ajax_playlist_remove_sidebar($, data);
                        ajax_playlist_remove_page_btn($, data);
                    },
                    error: function(errorThrown){
                        console.log(errorThrown);
                    },
            });
    
    }
    
