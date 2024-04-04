function rs_save_for_later($) {

	if($('.rs-save-for-later-button').length) {
		$('.rs-save-for-later-button[data-toggle="tooltip"]').tooltip();
		$('.rs-save-for-later-button').on('click', function(event) {
			event.preventDefault();
			event.stopPropagation();
			event.stopImmediatePropagation();

			$('.rs-save-for-later-button[data-toggle="tooltip"]').tooltip('hide');

			var $this = $(this),
				object_id = $this.data('object-id');

			$.ajax({
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
						$('.playlist_matches_count').html(null);
						$('.playlist_matches_count').html(data.length);
						ajax_playlist_remove_sidebar($, object_id);
						ajax_playlist_remove_track($, object_id);
					} else {	
						$this.addClass('saved');
						$this.attr('data-title', 'Remove');
						$this.attr('data-original-title', 'Remove');
						$('.playlist_matches_count').html(null);
						$('.playlist_matches_count').html(data.length);			
						ajax_playlist($, object_id);
						ajax_playlist_add_sidebar($, object_id);					
					}
					sidebarheight($);
				},
				error: function(error) {
					console.log(error);
				}
			});
		});
	}

}

function rs_remove_all($) {
	/**
	 * Remove All from Saved for Later
	 */
	$('a.rs-save-for-later-remove-all').on('click', function(event) {
        event.preventDefault();
        event.stopPropagation();
		event.stopImmediatePropagation();

		$.ajax({
			type: 'post',
			url: rs_save_for_later_ajax,
			data: {
				'action': 'save_for_later_remove_all'
			},
			success: function(data) {
				$(".playlist_matches_count").html(0);
				$( ".entry-save-for-later a" ).each(function() {
					$(this).removeClass("saved");
				});		
				$( ".rs-save-for-later-button" ).each(function() {
					$(this).removeClass("saved");
				});
				$( ".rs-save-for-later-button-album" ).each(function() {
					$(this).removeClass("saved");
				});
				$( ".add-play-now-button" ).each(function() {
					$(this).removeClass("onplay");
					$(this).addClass("onpause");
				});

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
	rs_remove_all($);
});