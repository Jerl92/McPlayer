
function mcplayer_load_saved_playlist($) {    

    $('.rs-save-for-later-load-playlist').on('click', function(event) {
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
                $("#subnav-content-load").html(null);
                data.forEach(function(element, index) {
                    $("#subnav-content-load").append(element);
                }, this); 
                mcplayer_load_playlist($);
                
            },
            error: function(errorThrown){
                console.log(errorThrown);
            }
        });
        $("#subnav-content-load").toggleClass("subnav-content-display");
        $("#subnav-content-save").removeClass("subnav-content-display");
    });
}
    
function mcplayer_load_playlist($) { 

    $('.playlist-load-loop').on('click', function(event) {
        event.preventDefault();
        event.stopPropagation();
        event.stopImmediatePropagation();

        var $this = $(this),
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
                $("#player56s-removetracks-all").html("1");
                $(".player56s").player56s($);
                $("#player56s-removetracks-all").html(null);
                links = data.playlist.reverse();
                links.forEach(function(element, index) {
                    setTimeout(function() {
                        ajax_playlist($, element);
                        ajax_playlist_add_sidebar($, element);
                        $('.genre_widget').html(data.genres);
                        $('.playlist_matches_count').html(index+1);
                        $(".playlist_matches_length").html(data.length);
                        
                        $('.rs-save-for-later-button').each(function(){
                            if($(this).data('object-id') === element){
                                $(this).addClass('saved');
                                $(this).attr('data-original-title', 'Remove');
                            }
                        });
                    }, index*250);
                }, this);  
                data.playlist_album.forEach(function(element) {
                    $('.rs-save-for-later-button-album').each(function() {
                        var data_id = $(this).data("object-id");
                        if(data_id == element){
                            $(this).addClass('saved');
                            $(this).attr('data-original-title', 'Remove');
                        }
                    }); 
                }, this);

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
                
            },
            error: function(errorThrown){
                console.log(errorThrown);
            }
        });
        $("#subnav-content-load").toggleClass("subnav-content-display");
    });
}

jQuery(document).ready(function($) {
    mcplayer_load_playlist($);
    mcplayer_load_saved_playlist($);
});