
function play_now($) {        
            if(jQuery('.add-play-now-button').length) {
                jQuery('.add-play-now-button[data-toggle="tooltip"]').tooltip();

                jQuery('.add-play-now-button').on('click', function(event) {
                    event.preventDefault();
                    event.stopPropagation();
                    event.stopImmediatePropagation();
            
                    var $this = jQuery(this),
                        object_id = $this.data('object-id');

                    jQuery('.add-play-now-button[data-toggle="tooltip"]').tooltip("hide");
                    jQuery.ajax({
                        type: 'post',
                        url: play_now_ajax_url,
                        data: {
                            'object_id': object_id,
                            'action': 'save_and_play_now'
                        },
                        dataType: 'JSON',
                        success: function(data) {

                        if(!$this.hasClass('saved') ) {

                            jQuery('.genre_widget').html(data.genres);
                            jQuery('.playlist_matches_count').html(data.count);
                            jQuery('.playlist_matches_length').html(data.length);

                            if(!jQuery('#rs-item-'+object_id).length){
                                ajax_playlist_add_sidebar($, object_id);
                            }

                            jQuerythis.addClass('saved');

                            jQuerythis.attr('data-original-title', 'Pause');

                            jQuery('#postid-'+object_id+' a').addClass('saved');

                            jQuery('#postid-'+object_id+' a').attr('data-original-title', 'Remove');

                            jQuery('add-play-now-id-'+object_id+' a').addClass('saved');

                            jQuery('add-play-now-id-'+object_id+' a').attr('data-original-title', 'Pause');
                            
                            jQuery('#album-class-artist-list-id-'+object_id+' a').addClass('saved');

                            jQuery('#album-class-artist-list-id-'+object_id+' a').attr('data-original-title', 'Pause');

                        }
                            ajax_playlist_play_now($, object_id);

                            ajax_playlist_update_sidebar($, object_id);
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });

            });
        }    
    }


function play_pause($) {             
        if(jQuery('.play-now-button').length) {
            jQuery('.play-now-button[data-toggle="tooltip"]').tooltip();
            jQuery('.play-now-button').on('click', function(event) {
                event.preventDefault();
                event.stopPropagation();
                event.stopImmediatePropagation();

                jQuery('.add-play-now-button[data-toggle="tooltip"]').tooltip('hide');

                var $this = $(this),
                    object_id = $this.data('object-id');

                ajax_playlist_play_now($, object_id);
                
                ajax_playlist_update_sidebar($, object_id);
            });
            
        }
    }

jQuery(document).ready(function($) {
    play_now($);
    play_pause($);
});
    
