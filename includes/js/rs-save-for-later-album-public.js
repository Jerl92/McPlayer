function rs_save_for_later_album($) {
    
    $.fn.ready();
	'use strict';


    /**
	 * Save/Unsave for Later
	 */
	if($('.rs-save-for-later-button-album').length) {
		$('.rs-save-for-later-button-album[data-toggle="tooltip"]').tooltip();
		if($('.rs-see-saved').length) {
			$('.rs-see-saved[data-toggle="tooltip"]').tooltip();
		}
		if($('.rs-saved-trigger').length) {
			$('.rs-saved-trigger[data-toggle="tooltip"]').tooltip();
		}
		$('.rs-save-for-later-button-album').on('click', function(event) {
			event.preventDefault();

			$('.rs-save-for-later-button-album[data-toggle="tooltip"]').tooltip('hide');
			
			var anchor = $(this);
			if(anchor.data('disabled')) {
				return false;
			}
			anchor.data('disabled', 'disabled');

			var $this = $(this),
				object_id = $this.data('object-id');
				// nonce = $this.data('nonce');

			$.ajax({
				type: 'post',
				url: rs_save_for_later_album_ajax,
				data: {
					// 'nonce': nonce,
					'object_id': object_id,
					'action': 'save_unsave_for_later_album'
                },
                dataType: 'JSON',
				success: function(data) {
					if(data.status == false) {
						console.log("coolies");
                        Cookies.set('rs_save_for_later', data.cookie, { expires: 365 });
					}
					if($this.hasClass('saved')) {
						if($this.hasClass('saved-in-list')) {
							var $parent = $this.parent().parent().parent();
							var $parent_deeper = $this.parent().parent().parent().parent();
							$parent.delay(200).fadeOut(300).remove();
					//		ajax_playlist_remove_sidebar($, object_id);
					//		ajax_playlist_remove_sidebar_btn($, object_id);
						} else {
							$this.removeClass('saved');
							$this.attr('data-title', rs_save_for_later_ajax.save_txt);
							$this.attr('data-original-title', rs_save_for_later_ajax.save_txt);
					//			ajax_playlist_remove_sidebar($, object_id);
				//			ajax_playlist_remove_page_btn($, object_id);
						}
						ajax_playlist_remove_album($, object_id);
					//	ajax_playlist_remove_album_sidebar($, object_id);
						$this.parent().find('.rs-see-saved').remove();
						$('.rs-saved-trigger span').text(data.count);
						$('.rs-saved-trigger').addClass('empty');	
					} else {	
						$this.addClass('saved');
						$this.attr('data-title', rs_save_for_later_ajax.unsave_txt);
						$this.attr('data-original-title', rs_save_for_later_ajax.unsave_txt);
						$('.rs-saved-trigger span').text(data.count);
						$('.rs-saved-trigger').removeClass('empty');	
						ajax_playlist_add_album($, object_id);	
						ajax_playlist_add_sidebar($, object_id);
					}
					anchor.removeData('disabled');
				},
				error: function(error) {
					console.log(error);
				}
			});
		});
    }
}

jQuery(document).ready(function($) {
	rs_save_for_later_album($);
});