( function( $ ) {

	$( function() {

		var $body = $('html, body');
		var settings = { 
			anchors: "a",
			cache: false,
			cacheLength: 0,
			prefetch: false,
			prefetchOn: 'mouseover touchstart',
			scroll: true,
			locationHeader: "X-SmoothState-Location",
			onStart: {
				duration: 100, // Duration of our animation
				render: function ($container) {

				// Remove your CSS animation reversing class
					$('body').removeClass('on-scroll');

					// Add your CSS animation reversing class
					$('body').addClass('no-scroll');

					// Add your CSS animation reversing class
					$('#primary').removeClass('is-onready');

					// Add your CSS animation reversing class
					$('#primary').addClass('is-onstart');

					$('#secondary').scrollTop(0);

					// Scroll user to the top, this is very important, transition may not work without this
					$body.scrollTop(0);

					// Restart your animation
					//smoothState.restartCSSAnimations();
				}
	        },
			onReady: {
				duration: 100,
				render: function ($container, $newContent) {
									
					// Inject the new content
					$container.html($newContent);

					// Remove your CSS animation reversing class
					$('#primary').removeClass('is-onstart');

					// Add your CSS animation reversing class
					$('#primary').addClass('is-onready');

					// Trigger load functions
					$(document).ready();
                	$(window).trigger('load');
				}
		    },
			onAfter: function( $container , $newcontainer ) {

				// Remove your CSS animation reversing class
				$('body').removeClass('no-scroll');
								
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

				hw_info = document.getElementById("hwm-area");
				if (hw_info) {					
					ajax_get_hw_shortcode($);
					ajax_get_hw($);
					hw_info.innerHTML = '';
					getData();
					setInterval(getData, parseInt($('#interval').val(), 10) * 5000);
				}

				loop = 0;
				interval = setInterval(function(){sidebarheight();},250);

				current_album($);
				
				// Add your CSS animation reversing class
				$('body').addClass('on-scroll');

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

			}
		};

		if (!$("body").hasClass("elementor-editor-active")) {
			$( "#page" ).smoothState( settings ).data("smoothState");
		}

	});

})(jQuery);	