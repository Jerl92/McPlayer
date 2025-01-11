function rs_save_for_later($) {

	if(jQuery('.rs-save-for-later-button').length) {
		jQuery('.rs-save-for-later-button[data-toggle="tooltip"]').tooltip();
		jQuery('.rs-save-for-later-button').on('click', function(event) {
			event.preventDefault();
			event.stopPropagation();
			event.stopImmediatePropagation();

			jQuery('.rs-save-for-later-button[data-toggle="tooltip"]').tooltip('hide');

			var $this = jQuery(this),
				object_id = $this.data('object-id');

			jQuery.ajax({
				type: 'post',
				url: rs_save_for_later_ajax,
				data: {
					'object_id': object_id,
					'action': 'save_unsave_for_later'
				},
				success: function(data) {
					if($this.hasClass('saved')) {
						$this.removeClass('saved');
						$this.attr('data-title', 'Add to Playlist');
						$this.attr('data-original-title', 'Add to Playlist');
						jQuery('.genre_widget').html(data.genres);
						jQuery('.playlist_matches_count').html(data.count);
						jQuery('.playlist_matches_length').html(data.length);
						ajax_playlist_remove_sidebar($, object_id);
						ajax_playlist_remove_track($, object_id);
					} else {	
						$this.addClass('saved');
						$this.attr('data-title', 'Remove');
						$this.attr('data-original-title', 'Remove');
						jQuery('.genre_widget').html(data.genres);
						jQuery('.playlist_matches_count').html(data.count);		
						jQuery('.playlist_matches_length').html(data.length);	
						ajax_playlist($, object_id);
						ajax_playlist_add_sidebar($, object_id);					
					}
				},
				error: function(error) {
					console.log(error);
				}
			});
		});
	}

}

function rs_remove_all($) {

	jQuery('a.rs-save-for-later-remove-all').on('click', function(event) {
        event.preventDefault();
        event.stopPropagation();
		event.stopImmediatePropagation();

		jQuery.ajax({
			type: 'post',
			url: rs_save_for_later_ajax,
			data: {
				'action': 'save_for_later_remove_all'
			},
			success: function(data) {
				jQuery(".genre_widget").html('<li style="text-align: center; padding:15px 0; list-style-type:none;">Nothing in the playlist</li>');
				jQuery("#rs-saved-for-later").html('<li id="rs-saved-for-later-nothing" style="text-align: center; padding:15px 0;">Nothing in the playlist</li>');
				jQuery(".playlist_matches_count").html(0);
				jQuery(".playlist_matches_length").html('0m0s');
				jQuery( ".entry-save-for-later a" ).each(function() {
					jQuery(this).removeClass("saved");
				});		
				jQuery( ".rs-save-for-later-button" ).each(function() {
					jQuery(this).removeClass("saved");
				});
				jQuery( ".rs-save-for-later-button-album" ).each(function() {
					jQuery(this).removeClass("saved");
				});
				jQuery( ".add-play-now-button" ).each(function() {
					jQuery(this).removeClass("onplay");
					jQuery(this).addClass("onpause");
				});

				jQuery("#player56s-removetracks-all").html("1");
				jQuery(".player56s").player56s(jQuery);
				jQuery("#player56s-removetracks-all").html(null);

				if (jQuery.isFunction($.fn.theiaStickySidebar)){ 
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
			error: function(error) {
				console.log(error);
			}
		});
	});
}

jQuery(document).ready(function($) {
	rs_save_for_later($);
	rs_remove_all($);
});