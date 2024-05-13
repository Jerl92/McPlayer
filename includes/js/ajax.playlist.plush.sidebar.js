function ajax_playlist_add_sidebar($, object_id)  {

    $.fn.ready();
	'use strict';

    $.ajax({    
        url: add_track_sidebar_ajax_url,
        type: 'post',
        data: {
            'object_id': object_id,
            'action': 'add_track_sidebar'
        },
        dataType: 'JSON',
        success: function(data){

            $("#rs-saved-for-later-nothing").empty();
            $("#rs-saved-for-later-nothing").css('padding', '0px');

            if ( data[0] !== null ) {
                if($("#rs-item-"+data[1]).length === 0){
                    $( "#rs-saved-for-later" ).prepend(data[0]);
                }

                tooltip($);

                rs_save_for_later($);
                
                rs_save_for_later_album($);
    
                play_pause($);
                
                play_now($);
                
                ajax_playlist_update_sidebar($);   

				if ($.isFunction($.fn.theiaStickySidebar)){ 
					if ( jQuery.browser.mobile && !mystickyside_name.device_mobile) {
						return false;
					} else if ( !jQuery.browser.mobile && !mystickyside_name.device_desktop) {
						return false;
					}
					var mysticky_sidebar_id = document.querySelector(mystickyside_name.mystickyside_string),
					mystickyside_content_id = (mystickyside_name.mystickyside_content_string),
					mystickyside_margin_top = parseInt(mystickyside_name.mystickyside_margin_top_string),
					mystickyside_margin_bot = parseInt(mystickyside_name.mystickyside_margin_bot_string),
					mystickyside_update_sidebar_height = Boolean(mystickyside_name.mystickyside_update_sidebar_height_string),
					mystickyside_min_width = parseInt(mystickyside_name.mystickyside_min_width_string);
		
					$(mysticky_sidebar_id).theiaStickySidebar({
						containerSelector: mystickyside_content_id,
						additionalMarginTop: mystickyside_margin_top,
						additionalMarginBottom: mystickyside_margin_bot,
						updateSidebarHeight: mystickyside_update_sidebar_height,
						minWidth: mystickyside_min_width
					});  
				}
            }
        
        },
        error: function(errorThrown){
            //error stuff here
        }
    });

}

function ajax_playlist_flush_sidebar($)  {
    
    $("#rs-saved-for-later").html('<li id="rs-saved-for-later-nothing" style="text-align: center; padding:15px 0;">Nothing in the playlist</li>');
}

function  ajax_playlist_update_sidebar($) {
    
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
    

function  ajax_playlist_remove_page_btn($, object_id)  {
    
    $("#postid-"+object_id+" a").removeClass('saved');

    $("#album-class-artist-list-id-"+object_id+" a").removeClass('saved');
            
    $("#post-"+object_id+" a.rs-save-for-later-button").removeClass('saved');

    $("#add-play-now-id-"+object_id+"").removeClass('onplay');
    
    $("#add-play-now-id-"+object_id+"").addClass('onpause');

}
