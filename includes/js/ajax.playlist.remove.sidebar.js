function ajax_playlist_remove_sidebar($, object_id)  {
    
    jQuery("#rs-item-" + object_id).remove();     
    
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

}        

