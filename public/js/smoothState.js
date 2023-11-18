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
				duration: 500, // Duration of our animation
				render: function ($container) {

					// Add your CSS animation reversing class
					$container.addClass('is-exiting');

					// Restart your animation
					//smoothState.restartCSSAnimations();
				}
	        },
			onReady: {
				duration: 0,
				render: function ($container, $newContent) {

					// Scroll user to the top, this is very important, transition may not work without this
					$body.scrollTop(0);

					// Remove your CSS animation reversing class
					$container.removeClass('is-exiting');

					// Inject the new content
					$container.html($newContent);

					// Trigger load functions
					$(document).ready();
                	$(window).trigger('load');
				}
		    },
			onAfter: function( $container , $newcontainer ) {

				// stickIt_($);

				// stickysidebar($);

				// ajax_playlist_add_sidebar($);
								
				play_now($);

				play_pause($);

				tooltip($);	
				
				scroll_to_album($);
				
				footer_stick($);
                    
				rs_save_for_later($);
				
				rs_save_for_later_album($); 

				sortable_playlist($);

				sidebarheight($);

				mcplayer_load_playlist($);
				
				mcplayer_load_saved_playlist($);
				
			}
		};

		if (!$("body").hasClass("elementor-editor-active")) {
			console.log(	$( "#page" ).smoothState( settings ).data("smoothState") );
		}

	});

})(jQuery);	