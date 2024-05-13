

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

var interval;
jQuery(document).ready(function($){
    interval = setInterval(function($){sidebarheight($);}, 250);
});

function sidebarheight($) {
    var windowwidth = jQuery(window).width();
    var windowheight = jQuery(window).height();
    var primaryheight = jQuery('#primary').height();

    if (windowwidth >= 720) {
        if(primaryheight >= windowheight){
            jQuery('#primary').height('100%');
            jQuery('#secondary').height(primaryheight);
        }
        if (primaryheight < windowheight){
            jQuery('#primary').height(windowheight-285);
            jQuery('#secondary').height(windowheight-285);
        }
        if(jQuery('#hwm-area')){
            jQuery('#primary').css('height', '100%');
        }
    } else {
        jQuery('#primary').css('height', '100%');
        jQuery('#secondary').css('height', '100%');
    }
    footer_stick($);
}

window.addEventListener("orientationchange", (event) => {
    $( "#player56s-orientation" ).text( `${event.target.screen.orientation.angle}` );
});

jQuery(document).ready(function($){	
    var max=0;
    jQuery("entry-meta-cover img").each(function(index, el) {
    
        if( jQuery(el).height() > max ){
            max = jQuery(el).height();
        }
    });
    jQuery("entry-meta-cover img").css('height', max);
});


function setCookie(c_name, value, exdays) {
    var exdate = new Date();
    exdate.setDate(exdate.getDate() + exdays);
    var c_value = escape(value) + ((exdays == null) ? "" : "; expires=" + exdate.toUTCString());
    document.cookie = c_name + "=" + c_value;
}

jQuery( window ).bind('beforeunload', function(){
    var player56scurrenttrack = $("#player56s-currenttrack");
    setCookie("Player56sCurrentTrack", parseInt(player56scurrenttrack[0].innerText), 64);
    var player56scurrentseek = $("#player56s-seek-current-percent");
    setCookie("Player56sSeek", parseInt(player56scurrentseek[0].innerText), 64);
    return confirm("Confirm refresh");
});

var interval = null;
function startTimer(duration) {
    var timer = duration
      
      interval = setInterval(function() {
  
      if (--timer < 0) {
        play_pause($);
        clearInterval(interval);
      }
      
    }, 1000);
}

var doVisualUpdates = true;
function update() {
    var windowwidth = jQuery(window).width();
    if (!doVisualUpdates) {
          var fiveMinutes = 216000
          startTimer(fiveMinutes);
    } else {
        clearInterval(interval);
        if (windowwidth <= 720) {
            navigator.wakeLock.request('screen')
            .then((wakeLock) => {
                screenLock = wakeLock; 
            })
        }
    }
}

document.addEventListener('visibilitychange', function(){
    doVisualUpdates = !document.hidden;
    update();
});

jQuery(window).on('load', function() {
    doVisualUpdates = !document.hidden;
    update();
});
