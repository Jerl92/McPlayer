
function mcplayer_save_playlist($) {    
    $('.rs-save-for-later-save-playlist').on('click', function(event) {
        event.preventDefault();
        event.stopPropagation();
        event.stopImmediatePropagation();
        
        $('#subnav-content-save').toggleClass('subnav-content-display');
        $("#subnav-content-load").removeClass("subnav-content-display");

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

    });

    $('.save-playlist').on('click', function(event) {
        event.preventDefault();
        event.stopPropagation();
        event.stopImmediatePropagation();

        var inputVal = document.getElementById("lnamesave").value;
    
        jQuery.ajax({
            type: 'post',
            url: save_playlist_ajax_url,
            data: {
                'inputVal': inputVal,
                'action': 'save_playlist'
            },
            dataType: 'json',
            success: function(data){
                $('#subnav-content-save').toggleClass('subnav-content-display');
                $('#lnamesave').val('');
            },
            error: function(errorThrown){
                //error stuff here.text
            }
        });
    });
}

jQuery(document).ready(function($) {
    mcplayer_save_playlist($);
});