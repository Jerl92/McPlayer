

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
            jQuery('#primary').height(windowheight-250);
            jQuery('#secondary').height(windowheight-250);
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

jQuery(document).ready(function($){	
    var max=0;
    jQuery("entry-meta-cover img").each(function(index, el) {
    
        if( jQuery(el).height() > max ){
            max = jQuery(el).height();
        }
    });
    jQuery("entry-meta-cover img").css('height', max);
});


function setCookie(cname, cvalue, exdays) {
  const d = new Date();
  d.setTime(d.getTime() + (exdays*24*60*60*1000));
  let expires = "expires="+ d.toUTCString();
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

jQuery( window ).bind('beforeunload', function(){
    var player56scurrenttrack = $("#player56s-currenttrack");
    setCookie("Player56sCurrentTrack", parseInt(player56scurrenttrack[0].innerText), 64);
    var player56scurrentseek = $("#player56s-seek-current-percent");
    setCookie("Player56sSeek", parseInt(player56scurrentseek[0].innerText), 64);
    var player56splaytimer = $("#player56s-play-timer");
    setCookie("player56splaytimer", parseInt(player56splaytimer[0].innerText), 64);
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
