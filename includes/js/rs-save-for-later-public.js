function rs_save_for_later($) {
    
    $.fn.ready();
	'use strict';


   	/**
	 * Save/Unsave for Later
	 */
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

			var anchor = $(this);
			if(anchor.data('disabled')) {
				return false;
			}
			anchor.data('disabled', 'disabled');

			$('.rs-save-for-later-button[data-toggle="tooltip"]').tooltip('hide');

			var $this = $(this),
				object_id = $this.data('object-id');
				// once = $this.data('nonce');

			$.ajax({
				type: 'post',
				url: rs_save_for_later_ajax.ajax_url,
				data: {
				//	'nonce': nonce,
					'object_id': object_id,
					'action': 'save_unsave_for_later'
				},
				success: function(data) {
					if($this.hasClass('saved')) {
						ajax_playlist_remove_sidebar($, object_id);
						ajax_playlist_remove_track($, object_id);
						$this.removeClass('saved');
						$this.attr('data-title', rs_save_for_later_ajax.save_txt);
						$this.attr('data-original-title', rs_save_for_later_ajax.save_txt);
						$this.parent().find('.rs-see-saved').remove();
						$('.rs-saved-trigger span').text(data.count);
						$('.rs-saved-trigger').addClass('empty');	
					} else {	
						ajax_playlist($, object_id);
						ajax_playlist_add_sidebar($, object_id);
						$this.addClass('saved');
						$this.attr('data-title', rs_save_for_later_ajax.unsave_txt);
						$this.attr('data-original-title', rs_save_for_later_ajax.unsave_txt);
						$('.rs-saved-trigger').removeClass('empty');									
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
				$(".entry-save-for-later a").removeClass("saved");
				$(".rs-save-for-later-button").removeClass("saved");
				$(".rs-save-for-later-button-album").removeClass("saved");

				ajax_playlist_flush_sidebar($);

				$("#player56s-removetracks-all").html("1");  
				$(".player56s").player56s($);
				$("#player56s-removetracks-all").html(null);
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