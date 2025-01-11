function rs_save_for_later_album($) {
	
	if(jQuery('.rs-save-for-later-button-album').length) {
		jQuery('.rs-save-for-later-button-album[data-toggle="tooltip"]').tooltip();
		jQuery('.rs-save-for-later-button-album').on('click', function(event) {
			event.preventDefault();
			event.stopPropagation();
			event.stopImmediatePropagation();

			jQuery('.rs-save-for-later-button-album[data-toggle="tooltip"]').tooltip('hide');

			var $this = jQuery(this),
				object_id = $this.data('object-id');

			jQuery.ajax({
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
						jQuery('.rs-save-for-later-button-album').each(function() {
							var data_id = jQuery(this).data("object-id");
							if(data_id == object_id){
								jQuery(this).removeClass('saved');
							}
						});     
						jQuery('.genre_widget').html(data.genres);
						jQuery('.playlist_matches_count').html(data.count);		
						jQuery('.playlist_matches_length').html(data.length);
						$this.attr('data-title', 'Add to Playlist');
						$this.attr('data-original-title', 'Add to Playlist');
						ajax_playlist_remove_album($, data);
					} else {	
						$this.addClass('saved');
						jQuery('.rs-save-for-later-button-album').each(function() {
                            var data_id = jQuery(this).data("object-id");
                            if(data_id == object_id){
                                jQuery(this).addClass("saved");
                            }
                        });     
						jQuery('.genre_widget').html(data.genres);
						jQuery('.playlist_matches_count').html(data.count);		
						jQuery('.playlist_matches_length').html(data.length);
						$this.attr('data-title', 'Remove');
						$this.attr('data-original-title', 'Remove');
						ajax_playlist_add_album($, data);
					}
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