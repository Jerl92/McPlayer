
function play_now($) {                  

         /**
         * Save/Unsave for Later
         */
        if($('.add-play-now-button').length) {
            $('.add-play-now-button[data-toggle="tooltip"]').tooltip();
    
            $('.add-play-now-button').on('click', function(event) {
                event.preventDefault();
                event.stopPropagation();
                event.stopImmediatePropagation();
        
                var $this = $(this),
                    object_id = $this.data('object-id');

                $('.add-play-now-button[data-toggle="tooltip"]').tooltip("hide");
                $.ajax({
                    type: 'post',
                    url: play_now_ajax_url,
                    data: {
                        'object_id': object_id,
                        'action': 'save_and_play_now'
                    },
                    dataType: 'JSON',
                    success: function(data) {

                    if ( ( $this.hasClass('onplay') || $this.hasClass('onpause') ) && $this.hasClass('saved') ) {

                        ajax_playlist_play_now($, object_id);

                        ajax_playlist_update_sidebar($, object_id);
                    
                    }

                     if( ! $this.hasClass('saved') ) {

                        if(!$('#rs-item-'+object_id).length){
                            ajax_playlist_add_sidebar($, object_id);
                        }

                        $('#postid-'+object_id+' a').addClass('saved');

                        $('#postid-'+object_id+' a').attr('data-original-title', 'Remove');
                        
                        $('#album-class-artist-list-id-'+object_id+' a').addClass('saved');

                        $('#album-class-artist-list-id-'+object_id+' a').attr('data-original-title', 'Remove');

                        ajax_playlist_play_now($, object_id);

                        ajax_playlist_update_sidebar($, object_id);

                        $('.playlist_matches_count').html(null);
                        
						$('.playlist_matches_count').html(data.count);		

                        $this.attr('data-title', 'Pause');

                    }

                    play_now($);

                },
                error: function(error) {
                    console.log(error);
                }
            });
        });
    }
    
}

function play_pause($) {                  

    if($('.play-now-button').length) {
        $('.play-now-button[data-toggle="tooltip"]').tooltip();
        $('.play-now-button').on('click', function(event) {
            event.preventDefault();
            event.stopPropagation();
            event.stopImmediatePropagation();

            $('.add-play-now-button[data-toggle="tooltip"]').tooltip('hide');

            var $this = $(this),
                object_id = $this.data('object-id');
            
            ajax_playlist_play_now($, object_id); 
            
            ajax_playlist_update_sidebar($, object_id);

            play_pause($);
        });
    }
}

jQuery(document).ready(function($) {
    play_now($);
    play_pause($);
});
    
