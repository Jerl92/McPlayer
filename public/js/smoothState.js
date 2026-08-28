function countdown($) {
    jQuery('a').click(function($){
        timer = 0;
        if(id){
            clearInterval(id);
        }
        id = setInterval(frame, 1000);
    });
    jQuery('div').click(function($){
        timer = 0;
        if(id){
            clearInterval(id);
        }
        id = setInterval(frame, 1000);
    })
    jQuery('#page').click(function($){
        timer = 0;
        if(id){
            clearInterval(id);
        }
        id = setInterval(frame, 1000);
    })
}

function frame($) {
    if (timer == 5400) {
		jQuery('#player56s-pause').html('1');
		jQuery('.player56s').player56s($);
		jQuery('#player56s-pause').html(null);
		clearInterval(id);
    } else {
      	timer++;
    }
}

var doVisualUpdates = true;
function update_wakelock() {
    if (!doVisualUpdates) {
        console.log("Tab not visible");
    }
    if(doVisualUpdates) {
        navigator.wakeLock.request('screen')
        .then((wakeLock) => {
            console.log(wakeLock);
            console.log('acquired');
        })
    }
}

jQuery(document).on('visibilitychange', function() {
    doVisualUpdates = !document.hidden;
    update_wakelock();
});

( function( $ ) {

	jQuery( function() {
	    
		var settings = { 
			anchors: "a",
			cache: false,
			cacheLength: false,
			prefetch: true,
			prefetchOn: 'mouseover touchstart',
			scroll: true,
			locationHeader: "X-SmoothState-Location",
			blacklist: ".no-smoothState",
			onStart: {
				duration: 250, // Duration of our animation
				render: function ($container) {

					// Add your CSS animation reversing class
					jQuery('#main').removeClass('is-onready');

					// Add your CSS animation reversing class
					jQuery('#main').addClass('is-onstart');

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
					jQuery('#main').removeClass('is-onstart');

					// Add your CSS animation reversing class
					jQuery('#main').addClass('is-onready');
						
					// Trigger load functions
					jQuery(document).ready();
                			jQuery(window).trigger('load');
					
				}
		    },
			onAfter: function( $container , $newcontainer ) {
				
				tooltip($);	
				
				topmenu($);

				scrolltosecondary($);
                    
				rs_save_for_later($);
				
				rs_save_for_later_album($);

				mcplayer_load_playlist($);
				
				mcplayer_load_saved_playlist($);

				mcplayer_save_playlist($);

				mcplayer_search_ajax($);
				
				topmenucontainer($);

				rs_remove_all($);

				memory_ajax($);

				current_album($);

				ajax_playlist_add_sidebar_load($);

				mcplayer_load_genre($);

				play_now($);

				play_pause($);

				add_comment($);

				delete_comment($);
				
				save_score($);
				
				send_form($);
				
				album_count_play($);
				
				album_score($);
				
				unique_score($);
				
				unique_count_play($);
				
				artist_score($);
				
				artist_count_play($);
				
				update_wakelock($);
				
				countdown($);

				intervalSideBar = setInterval(function($){
				    sidebarheight($);
				}, 1000);
				
				if (jQuery.isFunction(jQuery.fn.theiaStickySidebar)){
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
		
					jQuery(mysticky_sidebar_id).theiaStickySidebar({
						containerSelector: mystickyside_content_id,
						additionalMarginTop: mystickyside_margin_top,
						additionalMarginBottom: mystickyside_margin_bot,
						updateSidebarHeight: mystickyside_update_sidebar_height,
						minWidth: mystickyside_min_width
					});  
				}

			}
		};

		if (!jQuery("body").hasClass("elementor-editor-active")) {
			jQuery( "#page" ).smoothState( settings ).data("smoothState");
		}

	});

})(jQuery);	