function ajax_playlist_add_sidebar($, object_id)  {

    jQuery.ajax({    
        url: add_track_sidebar_ajax_url,
        type: 'post',
        data: {
            'object_id': object_id,
            'action': 'add_track_sidebar'
        },
        dataType: 'JSON',
        success: function(data){

            jQuery("#rs-saved-for-later-nothing").empty();
            jQuery("#rs-saved-for-later-nothing").css('padding', '0px');

            if ( data[0] !== null ) {
                if(jQuery("#rs-item-"+data[1]).length === 0){
                    jQuery( "#rs-saved-for-later" ).prepend(data[0]);

                    rs_save_for_later($);
                
                    rs_save_for_later_album($);
        
                    play_pause($);
                    
                    play_now($);
                    
                    ajax_playlist_update_sidebar($);   
                    
                    tooltip($);
                }
                
            }
        
        },
        error: function(errorThrown){
            //error stuff here
        }
    });

}

function ajax_playlist_add_sidebar_load($)  {

    jQuery.ajax({    
        url: add_track_sidebar_ajax_url,
        type: 'post',
        data: {
            'action': 'add_track_sidebar_load'
        },
        dataType: 'JSON',
        success: function(data){

            jQuery("#rs-saved-for-later-nothing").empty();
            jQuery("#rs-saved-for-later-nothing").css('padding', '0px');

            jQuery('.playlist_matches_count').html(data[1]);
            jQuery('.playlist_matches_length').html(data[2]);

            if ( data !== null ) {
                jQuery( "#rs-saved-for-later" ).empty();

                jQuery( "#rs-saved-for-later" ).append(data[0]);

                rs_save_for_later($);
                
                rs_save_for_later_album($);
    
                play_pause($);
                
                play_now($);
                
                ajax_playlist_update_sidebar($);   
                
                tooltip($);
                
            }
        
        },
        error: function(errorThrown){
            //error stuff here
        }
    });

}

jQuery(document).ready(function($) {
    ajax_playlist_add_sidebar_load($);
});

function  ajax_playlist_update_sidebar($) {
    
    var currenttrack = jQuery("#player56s-currenttrack")[0].innerText;
    
    if ( jQuery("#player56s-ui-zone").hasClass('player56s-status-playing') ) {
        jQuery("#play-now-id-"+currenttrack+"").removeClass('onpause');
        jQuery("#add-play-now-id-"+currenttrack+"").removeClass('onpause');
        jQuery("#play-now-id-"+currenttrack+"").addClass('onplay');
        jQuery("#add-play-now-id-"+currenttrack+"").addClass('onplay'); 
    }
                                
    jQuery("#postid-"+currenttrack+" a").addClass('saved');
    jQuery("#album-class-artist-list-id-"+currenttrack+" a").addClass('saved');

    jQuery("#rs-item-"+currenttrack).addClass('playing');   
}
    

function  ajax_playlist_remove_page_btn($, object_id)  {
    
    jQuery("#postid-"+object_id+" a").removeClass('saved');

    jQuery("#album-class-artist-list-id-"+object_id+" a").removeClass('saved');
            
    jQuery("#post-"+object_id+" a.rs-save-for-later-button").removeClass('saved');

    jQuery("#add-play-now-id-"+object_id+"").removeClass('onplay');
    
    jQuery("#add-play-now-id-"+object_id+"").addClass('onpause');

}