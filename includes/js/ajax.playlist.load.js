
function mcplayer_load_saved_playlist($) {    

    jQuery('.rs-save-for-later-load-playlist').on('click', function(event) {
        event.preventDefault();
        event.stopPropagation();
        event.stopImmediatePropagation();

        jQuery.ajax({
            type: 'post',
            url: save_playlist_ajax_url,
            data: {
                'action': 'load_saved_playlist'
            },
            dataType: 'json',
            success: function(data){
                jQuery("#subnav-content-load").html(null);
                data.forEach(function(element, index) {
                    jQuery("#subnav-content-load").append(element);
                }, this); 
                mcplayer_load_playlist($);
                
            },
            error: function(errorThrown){
                console.log(errorThrown);
            }
        });
        jQuery("#subnav-content-load").toggleClass("subnav-content-display");
        jQuery("#subnav-content-save").removeClass("subnav-content-display");
    });
}
    
function mcplayer_load_playlist($) { 

    jQuery('.playlist-load-loop').on('click', function(event) {
        event.preventDefault();
        event.stopPropagation();
        event.stopImmediatePropagation();

        var $this = jQuery(this),
        object_id = $this.data('id');
    
        jQuery.ajax({
            type: 'post',
            url: save_playlist_ajax_url,
            data: {
                'object_id': object_id,
                'action': 'load_playlist'
            },
            dataType: 'json',
            success: function(data){
                jQuery("#player56s-removetracks-all").html("1");
                jQuery(".player56s").player56s($);
                jQuery("#player56s-removetracks-all").html(null);
                links = data.playlist.reverse();
                links.forEach(function(element, index) {
                    setTimeout(function() {
                        ajax_playlist($, element);
                        ajax_playlist_add_sidebar($, element);
                        jQuery('.genre_widget').html(data.genres);
                        jQuery('.playlist_matches_count').html(index+1);
                        jQuery(".playlist_matches_length").html(data.length);
                        
                        jQuery('.rs-save-for-later-button').each(function(){
                            if(jQuery(this).data('object-id') === element){
                                jQuery(this).addClass('saved');
                                jQuery(this).attr('data-original-title', 'Remove');
                            }
                        });
                    }, index*250);
                }, this);  
                data.playlist_album.forEach(function(element) {
                    jQuery('.rs-save-for-later-button-album').each(function() {
                        var data_id = jQuery(this).data("object-id");
                        if(data_id == element){
                            jQuery(this).addClass('saved');
                            jQuery(this).attr('data-original-title', 'Remove');
                        }
                    }); 
                }, this);

                if (jQuery.isFunction(jQuery.fn.theiaStickySidebar)){ 
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
		
					jQuery(mysticky_sidebar_id).theiaStickySidebar({
						containerSelector: mystickyside_content_id,
						additionalMarginTop: mystickyside_margin_top,
						additionalMarginBottom: mystickyside_margin_bot,
						updateSidebarHeight: mystickyside_update_sidebar_height,
						minWidth: mystickyside_min_width
					});  
				}
                
            },
            error: function(errorThrown){
                console.log(errorThrown);
            }
        });
        jQuery("#subnav-content-load").toggleClass("subnav-content-display");
    });
}

jQuery(document).ready(function($) {
    mcplayer_load_playlist($);
    mcplayer_load_saved_playlist($);
});