function rs_save_for_later($) {

	if($('.rs-save-for-later-button').length) {
		$('.rs-save-for-later-button[data-toggle="tooltip"]').tooltip();
		if($('.rs-see-saved').length) {
			$('.rs-see-saved[data-toggle="tooltip"]').tooltip();
		}
		if($('.rs-saved-trigger').length) {
			$('.rs-saved-trigger[data-toggle="tooltip"]').tooltip();
		}
		$('.rs-save-for-later-button').on('click', function(event) {
			event.preventDefault();
			event.stopPropagation();
			event.stopImmediatePropagation();

			var anchor = $(this);
			if(anchor.data('disabled')) {
				return false;
			}
			anchor.data('disabled', 'disabled');

			$('.rs-save-for-later-button[data-toggle="tooltip"]').tooltip('hide');

			var $this = $(this),
				object_id = $this.data('object-id');

			console.log(object_id);

			$.ajax({
				type: 'post',
				url: rs_save_for_later_ajax.ajax_url,
				data: {
					'object_id': object_id,
					'action': 'save_unsave_for_later'
				},
				success: function(data) {
					if($this.hasClass('saved')) {
						$this.removeClass('saved');
						$this.attr('data-title', rs_save_for_later_ajax.save_txt);
						$this.attr('data-original-title', rs_save_for_later_ajax.save_txt);
						$this.parent().find('.rs-see-saved').remove();	
						$('.playlist_matches_count').text('');
						$('.playlist_matches_count').text(data.count);
						ajax_playlist_remove_sidebar($, object_id);
						ajax_playlist_remove_track($, object_id);
						sidebarheight($);
					} else {	
						$this.addClass('saved');
						$this.attr('data-title', rs_save_for_later_ajax.unsave_txt);
						$this.attr('data-original-title', rs_save_for_later_ajax.unsave_txt);
						$('.playlist_matches_count').text('');
						$('.playlist_matches_count').text(data.count);			
						ajax_playlist($, object_id);
						ajax_playlist_add_sidebar($, object_id);	
						sidebarheight($);				
					}
					anchor.removeData('disabled');
				},
				error: function(error) {
					console.log(error);
				}
			});
		});
	}

	/**
	 * Remove All from Saved for Later
	 */
	$('a.rs-save-for-later-remove-all').on('click', function(event) {
        event.preventDefault();
        event.stopPropagation();
        event.stopImmediatePropagation();

		var $this = $(this);
		nonce = $this.data('nonce');

		$.ajax({
			type: 'post',
			url: rs_save_for_later_ajax.ajax_url,
			data: {
				'nonce': nonce,
				'action': 'save_for_later_remove_all'
			},
			success: function(data) {
				$(".playlist_matches_count").text("0");
				$( ".entry-save-for-later a" ).each(function() {
					$(this).removeClass("saved");
				});		
				$( ".rs-save-for-later-button" ).each(function() {
					$(this).removeClass("saved");
				});
				$( ".rs-save-for-later-button-album" ).each(function() {
					$(this).removeClass("saved");
				});

				ajax_playlist_flush_sidebar($);

				$("#player56s-removetracks-all").html("1");  
				$(".player56s").player56s($);
				$("#player56s-removetracks-all").html(null);

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
			error: function(error) {
				console.log(error);
			}
		});
	});
}

jQuery(document).ready(function($) {
	rs_save_for_later($);
});