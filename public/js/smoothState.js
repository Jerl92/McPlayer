( function( $ ) {

	$( function() {

		var $body = $('body');
		var settings = { 
			anchors: "a",
			cache: false,
			cacheLength: 0,
			prefetch: true,
			prefetchOn: 'touchstart',
			scroll: true,
			locationHeader: "X-SmoothState-Location",
			onStart: {
				duration: 250, // Duration of our animation
				render: function ($container) {

				// Remove your CSS animation reversing class
					$('body').removeClass('on-scroll');

					// Add your CSS animation reversing class
					$('body').addClass('no-scroll');

					// Add your CSS animation reversing class
					$('#main').removeClass('is-onready');

					// Add your CSS animation reversing class
					$('#main').addClass('is-onstart');

					$('.loader').css('display', 'table');

					// Scroll user to the top, this is very important, transition may not work without this
					$body.scrollTop(0);

					// Restart your animation
					// smoothState.restartCSSAnimations();
				}
	        },
			onReady: {
				duration: 250,
				render: function ($container, $newContent) {
									
					// Inject the new content
					$container.html($newContent);

					// Remove your CSS animation reversing class
					$('#main').removeClass('is-onstart');

					// Add your CSS animation reversing class
					$('#main').addClass('is-onready');

					$('.loader').css('display', 'none');

					// Trigger load functions
					$(document).ready();
                	$(window).trigger('load');
				}
		    },
			onAfter: function( $container , $newcontainer ) {

				$('body').removeClass('no-scroll');

				$('body').addClass('on-scroll');
								
				play_now($);

				play_pause($);

				tooltip($);	
                    
				rs_save_for_later($);
				
				rs_save_for_later_album($);

				ajax_playlist_update_sidebar($);

				mcplayer_load_playlist($);
				
				mcplayer_load_saved_playlist($);

				mcplayer_save_playlist($);

				mcplayer_search_ajax($);

				scrolltosecondary($);
				
				topmenucontainer($);

				rs_remove_all($);

				memory_ajax($);

				current_album($);

				var interval_hw;
				hw_info = document.getElementById("hwm-area");
				if (hw_info) {					
					ajax_get_hw_shortcode($);
					ajax_get_hw($);
					hw_info.innerHTML = '';
					getData();
					interval_hw = setInterval(getData, parseInt($('#interval').val(), 10) * 1000);
				} else {
					clearInterval(interval_hw);
				}
				
				interval = setInterval(function(){sidebarheight();},250);

			}
		};

		if (!$("body").hasClass("elementor-editor-active")) {
			$( "#page" ).smoothState( settings ).data("smoothState");
		}

	});

})(jQuery);	