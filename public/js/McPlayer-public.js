

jQuery(document).ready(function() {      
    var header = jQuery("#wpadminbar").height();

    jQuery('#btn_player_toggle').click(function() {
        if(jQuery('#wrap-player').hasClass('full-player')){
            jQuery('#wrap-player').removeClass('full-player');
            jQuery('.player_widget_name_up_btn').css('display', 'block');
            jQuery('#wrap-player').css('top', 'auto');
        } else {
            jQuery('#player56s-ui-zone').addClass('hide-player');
            jQuery('.player_widget_name_hide_btn').css('display', 'none');
            jQuery('#page').css('padding-bottom', jQuery('#wrap-player').height() +'px');
            jQuery('.shuffle_player_toggle').css('display', 'none');
        }

    });
    jQuery('#btn_player_toggle_up').click(function() {
        if(jQuery('#player56s-ui-zone').hasClass('hide-player')) {
            jQuery('#player56s-ui-zone').removeClass('hide-player');
            jQuery('.player_widget_name_hide_btn').css('display', 'block');
            jQuery('#page').css('padding-bottom', jQuery('#wrap-player').height() +'px');
            jQuery('.shuffle_player_toggle').css('display', 'block');
        } else {
            if(header){
                jQuery('#wrap-player').css('top', '47.5px');
            } else {
                //
            }
            jQuery('#wrap-player').addClass('full-player');
            jQuery('.player_widget_name_up_btn').css('display', 'none');
        }
    });
});

// Use jQuery via jQuery(...)
jQuery(document).ready(function() {
    jQuery('#menu-open-link').click(function() {
        jQuery('.menu-off').toggleClass('opened');
    });
});

function footer_stick() {
    var windowHeight_ = jQuery(window).height();
    var documentHeight_ = jQuery(document).height();
    var colophonHeight_ = jQuery('#colophon').height();
    var playerHeight_ = jQuery('#wrap-player').height();

    jQuery('#page').css('padding-bottom', jQuery('#wrap-player').height() +'px');

    if ( windowHeight_ >= documentHeight_ ) {
        jQuery('#colophon').css('position', 'fixed');
        jQuery('#colophon').css('bottom', playerHeight_+'px');
        jQuery('#colophon').css('width', '100%');
        jQuery('#colophon').css('display', 'grid');
    } else {
        jQuery('#colophon').css('position', 'static');
        jQuery('#colophon').css('bottom', '0');
        jQuery('#colophon').css('width', '100%');
        jQuery('#colophon').css('display', 'grid');
    }
}

jQuery(window).resize(function () {
    var windowHeight_ = jQuery(window).height();
    var documentHeight_ = jQuery(document).height();
    var playerHeight_ = jQuery('#wrap-player').height();
    

    if ( windowHeight_ >= documentHeight_ ) {
        jQuery('#colophon').css('position', 'fixed');
        jQuery('#colophon').css('bottom', playerHeight_+'px');
        jQuery('#colophon').css('width', '100%');
        jQuery('#colophon').css('display', 'grid');
    } else {
        jQuery('#colophon').css('position', 'static');
        jQuery('#colophon').css('bottom', '0');
        jQuery('#colophon').css('width', '100%');
        jQuery('#colophon').css('display', 'grid');
    }

});

function sleep(milliseconds) {
    var start = new Date().getTime();
    for (var i = 0; i < 1e7; i++) {
        if ((new Date().getTime() - start) > milliseconds){
            break;
        }
    }
}

var intervalSideBar;
jQuery(document).ready(function($){
	intervalSideBar = setInterval(function(){
	    sidebarheight($);
	}, 250);
});

function sidebarheight($) {
    var windowwidth = jQuery(window).width();
    var windowheight = jQuery(window).height();
    var primaryheight = jQuery('#primary').height();

    if (windowwidth >= 720) {
        if(primaryheight >= windowheight){
	        jQuery('#primary').css('height', '100%');
	        jQuery('#secondary').css('height', primaryheight);
        }
        if (primaryheight < windowheight){
            var windowheight_ = parseInt(windowheight) - 250;
            jQuery('#primary').css('height', windowheight_);
            jQuery('#secondary').css('height', primaryheight);
        }
        if(jQuery('#hwm-area')){
            jQuery('#primary').css('height', '100%');
        }
    } else {
        jQuery('#primary').css('height', '100%');
        jQuery('#secondary').css('height', '100%');
    }
    
	if (jQuery.isFunction($.fn.theiaStickySidebar)){ 
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
    
    footer_stick($);
}

jQuery(document).ready(function($){	
    var max=0;
    jQuery("entry-meta-cover img").each(function(index, el) {
    
        if( jQuery(el).height() > max ){
            max = jQuery(el).height();
        }
    });
    jQuery("entry-meta-cover img").css('height', max);
});

jQuery( window ).bind('beforeunload', function(){
    var Player56sCurrentTrack = jQuery("#player56s-currenttrack");
    Cookies.set('Player56sCurrentTrack', parseInt(Player56sCurrentTrack[0].innerText), { path: '/' });
    var Player56sCurrentSeek = jQuery("#player56s-seek-current-percent");
    Cookies.set('Player56sSeek', parseInt(Player56sCurrentSeek[0].innerText) + 1, { path: '/' });
    var Player56sPlayTimer = jQuery("#player56s-play-timer");
    Cookies.set('Player56sPlayTimer', parseInt(Player56sPlayTimer[0].innerText), { path: '/' });
});

var id;
var timer = 0;

function countdown() {
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

jQuery(document).ready(function(){	
    countdown();
});

jQuery(document).ready(function(){	
    var intervalAJAXwrap = setInterval(function() {
    	jQuery("#player56s-ajax-wrap").css('display', 'none');
    }, 500);
});
