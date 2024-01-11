( function( $ ) {

	function addBlacklistClass() { 
		$( "a" ).each( function() {
			if ( this.href.indexOf("/wp-admin/") !== -1 || 
				 this.href.indexOf("/wp-login.php") !== -1 ) {
				$( this ).addClass( "no-smoothState" );
			}
        });
	}

	$( function() {

		addBlacklistClass();
		var $body = $('html, body');
		var settings = { 
			anchors: "a",
			blacklist: ".no-smoothState",
			cache: false,
			cacheLength: 0,
			prefetch: true,
			prefetchOn: 'mouseover touchstart',
			scroll: false,
			locationHeader: "X-SmoothState-Location",
			onStart: {
				duration: 100, // Duration of our animation
				render: function ($container) {

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

					// Add your CSS animation reversing class
					$('#primary').addClass('is-onready');

					// Remove your CSS animation reversing class
					$('#primary').removeClass('is-onstart');

					// Trigger load functions
					$(document).ready();
                	$(window).trigger('load');
				}
		    },
			onAfter: function( $container , $newcontainer ) {

				// stickIt_($);

				// stickysidebar($);

				// ajax_playlist_add_sidebar($);

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
								
				play_now($);

				play_pause($);

				tooltip($);	
				
				// scroll_to_album($);
				
				footer_stick($);
                    
				rs_save_for_later($);
				
				rs_save_for_later_album($); 

				sortable_playlist($);

				sidebarheight($);

				mcplayer_load_playlist($);
				
				mcplayer_load_saved_playlist($);

				mcplayer_save_playlist($);

				mcplayer_search_ajax($);

				// Add your CSS animation reversing class
				$('#primary').removeClass('is-onready');
				
			}
		};

		if (!$("body").hasClass("elementor-editor-active")) {
			console.log(	$( "#page" ).smoothState( settings ).data("smoothState") );
		}

	});

})(jQuery);	