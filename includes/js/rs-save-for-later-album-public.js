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

			$.ajax({
				type: 'post',
				url: rs_save_for_later_album_ajax,
				data: {
					'object_id': object_id,
					'action': 'save_unsave_for_later_album'
                },
                dataType: 'JSON',
				success: function(data) {
					if($this.hasClass('saved')) {
						$this.removeClass('saved');
						$this.attr('data-title', rs_save_for_later_ajax.save_txt);
						$this.attr('data-original-title', rs_save_for_later_ajax.save_txt);
						$('.rs-save-for-later-button-album').each(function() {
							var data_id = $(this).data("object-id");
							if(data_id == object_id){
								$(this).removeClass('saved');
							}
						});     
						$this.parent().find('.rs-see-saved').remove();
						$('.playlist_matches_count').text('');
						$('.playlist_matches_count').text(data);
						ajax_playlist_remove_album($, object_id);
					} else {	
						$this.addClass('saved');
						$('.rs-save-for-later-button-album').each(function() {
                            var data_id = $(this).data("object-id");
                            if(data_id == object_id){
                                $(this).addClass("saved");
                            }
                        });     
						$this.attr('data-title', rs_save_for_later_ajax.unsave_txt);
						$this.attr('data-original-title', rs_save_for_later_ajax.unsave_txt);
						$('.playlist_matches_count').text('');
						$('.playlist_matches_count').text(data);
						ajax_playlist_add_album($, object_id);
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