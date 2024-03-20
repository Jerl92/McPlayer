function ajax_playlist_remove_album($, object_id)  {
                $.ajax({    
                    type: 'post',
                    url: add_album_ajax_url,
                    data: {
                        'object_id': object_id,
                        'action': 'remove_track_album'
                    },
                    dataType: 'JSON',
                    success: function(data){ 
                        var x = 0;
                        data.forEach(function(element, index) {
                            if(index <= data.length){
                                setTimeout(function() {
                                    ajax_playlist_remove_sidebar($, element);
                                    ajax_playlist_remove_track($, element);
                                }, index*100);
                            }

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

                        }, this);

                    },
                    error: function(errorThrown){
                        console.log(errorThrown);
                    }
            });
    
    }