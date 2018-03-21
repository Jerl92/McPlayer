function ajax_playlist_add_sidebar($, object_id)  {

    $.ajax({    
        url: add_track_sidebar_ajax_url,
        type: 'post',
        data: {
            'object_id': object_id,
            'action': 'add_track_sidebar'
        },
        dataType: 'JSON',
        success: function(data){

            var currenttrack = $("#player56s-currenttrack")[0].innerText;

            $("#rs-saved-for-later").html(data); 
            
            tooltip($);

            rs_save_for_later($);
            
            rs_save_for_later_album($);

            if($('.play-now-button').length) {
                $('.play-now-button[data-toggle="tooltip"]').tooltip($);
                $('.play-now-button').on('click', function(event) {
                    event.preventDefault();
        
                $('.add-play-now-button[data-toggle="tooltip"]').tooltip('hide');
        
                    var $this = $(this),
                        object_id = $this.data('object-id');
                    
                    ajax_playlist_play_now($, object_id); 
                    
                    ajax_playlist_update_sidebar($, object_id);
                });
            }

            sortable_playlist($);

            if ( $("#player56s-ui-zone").hasClass('player56s-status-playing') ) {
                $("#play-now-id-"+currenttrack+"").removeClass('onpause');
                $("#add-play-now-id-"+currenttrack+"").removeClass('onpause');
                $("#play-now-id-"+currenttrack+"").addClass('onplay');
                $("#add-play-now-id-"+currenttrack+"").addClass('onplay'); 
            }   

            $("#postid-"+currenttrack+" a").addClass('saved');
            $("#album-class-artist-list-id-"+currenttrack+" a").addClass('saved');
            
            $("#rs-item-"+currenttrack).addClass('playing');
        
        },
        error: function(errorThrown){
            //error stuff here
        }
    });

}

function  ajax_playlist_sortable_sidebar($){
        // var currenttrack = $("#player56s-currenttrack")[0].innerText;
}
    

function  ajax_playlist_update_sidebar($, object_id) {
    
    var currenttrack = $("#player56s-currenttrack")[0].innerText;
    
    if ( $("#player56s-ui-zone").hasClass('player56s-status-playing') ) {
        $("#play-now-id-"+currenttrack+"").removeClass('onpause');
        $("#add-play-now-id-"+currenttrack+"").removeClass('onpause');
        $("#play-now-id-"+currenttrack+"").addClass('onplay');
        $("#add-play-now-id-"+currenttrack+"").addClass('onplay'); 
    }
                                
    $("#postid-"+currenttrack+" a").addClass('saved');
    $("#album-class-artist-list-id-"+currenttrack+" a").addClass('saved');

    $("#rs-item-"+currenttrack).addClass('playing');   
}
    

function  ajax_playlist_remove_sidebar_btn($, object_id)  {
    
    $.ajax({    
        url: remove_track_ajax_url,
        type: 'POST',
        data: {
            'object_id': object_id,
            'action': 'remove_track'
        },
        dataType: 'JSON',
        success: function(data){
            //   console.log(data);
            
            /* postdata = $("#album-class-artist-list-id-"+data+" a").toggleClass('saved');

            postdata; */

            $("#postid-"+data+" a").removeClass('saved');

            $("#album-class-artist-list-id-"+data+" a").removeClass('saved');
                    
            $("#post-"+data+" a.rs-save-for-later-button").removeClass('saved');

        },
        error: function(errorThrown){
            //error stuff here
        }
    });

}
