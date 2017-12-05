
function play_now($) {                  


    $.fn.ready();
    'use strict';

         /**
         * Save/Unsave for Later
         */
        if($('.add-play-now-button').length) {
            $('.add-play-now-button[data-toggle="tooltip"]').tooltip();
    
            $('.add-play-now-button').on('click', function(event) {
                event.preventDefault();

               $('.add-play-now-button[data-toggle="tooltip"]').tooltip('hide');
    
                var $this = $(this),
                    object_id = $this.data('object-id');
    
                $.ajax({
                    type: 'post',
                    url: play_now_ajax_url.ajax_url,
                    data: {
                        'object_id': object_id,
                        'action': 'save_and_play_now'
                    },
                    dataType: 'JSON',
                    success: function(data) {

                     if( ! $("#postid-"+object_id+" a").hasClass('saved') ) {

                        $this.attr('data-title', play_now_ajax_url.unsave_txt);

                        $this.attr('data-original-title', play_now_ajax_url.unsave_txt);

                        ajax_playlist($, object_id);
                        
                        sleep(100);

                        ajax_playlist_add_sidebar($, object_id);

                        ajax_playlist_play_now($, object_id);

                        ajax_playlist_update_sidebar($, object_id);   

                    } else if ( $this.hasClass('onplay') ) {
                        
                        $('.add-play-now-button[data-toggle="tooltip"]').tooltip();

                        $this.attr('data-title', 'Play');
                        
                        $this.attr('data-original-title', 'Play');

                        ajax_playlist_play_now($, object_id);
                        
                        ajax_playlist_update_sidebar($, object_id);   

                    } else if ( $this.hasClass('onpause') ) {  
                
                        $('.add-play-now-button[data-toggle="tooltip"]').tooltip();                        
                        
                        $this.attr('data-title', play_now_ajax_url.unsave_txt);
                        
                        $this.attr('data-original-title', play_now_ajax_url.unsave_txt);

                        ajax_playlist_play_now($, object_id);
                        
                        ajax_playlist_update_sidebar($, object_id);   
                    }

           //         $('.add-play-now-button[data-toggle="tooltip"]').tooltip();

                  },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });
        }

        if($('.play-now-button').length) {
            $('.play-now-button[data-toggle="tooltip"]').tooltip();
            $('.play-now-button').on('click', function(event) {
                event.preventDefault();
    
            //	$('.add-play-now-button[data-toggle='tooltip']').tooltip('hide');
    
                var $this = $(this),
                    object_id = $this.data('object-id');
                
                ajax_playlist_play_now($, object_id); 
                
                ajax_playlist_update_sidebar($, object_id);
            });
        }
    
}

function sleep(delay) {
    var start = new Date().getTime();
    while (new Date().getTime() < start + delay);
}

jQuery(document).ready(function($) {
    play_now($);
});
    