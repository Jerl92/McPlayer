

jQuery(document).ready(function() {      
    jQuery('#btn_player_toggle').click(function() {
        if(jQuery('#wrap-player').hasClass('full-player')){
            jQuery('#wrap-player').removeClass('full-player');
            jQuery('.player_widget_name_up_btn').css('display', 'block');
        } else {
            jQuery('#player56s-ui-zone').addClass('hide-player');
            jQuery('.player_widget_name_hide_btn').css('display', 'none');
            jQuery('#page').css('padding-bottom', jQuery('#wrap-player').height() +'px');
    
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

    });
    jQuery('#btn_player_toggle_up').click(function() {
        if(jQuery('#player56s-ui-zone').hasClass('hide-player')) {
            jQuery('#player56s-ui-zone').removeClass('hide-player');
            jQuery('.player_widget_name_hide_btn').css('display', 'block');
            jQuery('#page').css('padding-bottom', jQuery('#wrap-player').height() +'px');
        } else {
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

function footer_stick($) {
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

function sortable_playlist($) {

    $( "#rs-saved-for-later" ).sortable({    
        start: function(e, ui) {
            var i = 0;
            const playlist_array = [];
            $(".rs-item-saved-for-later").each(function () {
                playlist_array[i] = $(this);
                i++;
            });
            playlist_array.reverse();
            var array = playlist_array[ui.item.index()];
            $(this).attr('data-previndex', parseInt(array.index()-1));
        },
        update: function(e, ui) {
            var i = 0;
            const playlist_array = [];
            $(".rs-item-saved-for-later").each(function () {
                playlist_array[i] = $(this);
                i++;
            });
            playlist_array.reverse();
            var array = playlist_array[ui.item.index()];
            var newIndex = parseInt(array.index());
            var oldIndex = $(this).attr('data-previndex');
            $("#player56s-sortable").html('<ul><li>' + oldIndex + '</li><li>' + newIndex + '</li></ul>');

            $(".player56s").player56s($);
            
            $("#player56s-sortable").html(null);      

            $(this).removeAttr('data-previndex');

            sortable_playlist($);
        }
    });
    $("#rs-saved-for-later").disableSelection();
}

function sleep(milliseconds) {
    var start = new Date().getTime();
    for (var i = 0; i < 1e7; i++) {
        if ((new Date().getTime() - start) > milliseconds){
            break;
        }
    }
}


let lastHeight = $("#hwm-area").height(); 
  
function checkHeightChange() { 
    newHeight = $("#hwm-area").height(); 
    var colophon = jQuery('#colophon').height();
    var masthead = jQuery('#masthead').height();
  
    if (lastHeight != newHeight) { 
        var windowwidth = jQuery(window).width();
        var windowheight = jQuery(window).height();
        var primaryheight = jQuery('#primary').height();
        
        if (windowwidth > 720) {
            if(newHeight < 1080){
                newHeight = 1080;
            }
            if(primaryheight <= windowheight){
                jQuery('#content').height(newHeight+colophon+masthead);
                jQuery('#secondary').height(newHeight+colophon+masthead);
            }
            if(windowheight <= primaryheight){
                jQuery('#secondary').height(primaryheight);
            }
        }
        
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
} 
  
if($("#hwm-area")){
    var myTimer = setInterval(function(){
            checkHeightChange();
    }, 500);
}

function sidebarheight() {
    var windowwidth = jQuery(window).width();
    var windowheight = jQuery(window).height();
    var wrapplayer = jQuery('#wrap-player').height();
    var colophon = jQuery('#colophon').height();
    var masthead = jQuery('#masthead').height();
    var primaryheight = jQuery('#primary').height();
    var secondaryheight = jQuery('#secondary').height();
    
    if (windowwidth > 720) {
        if(primaryheight <= windowheight){
            jQuery('body').height(windowheight);
            jQuery('#primary').height(windowheight-colophon);
            jQuery('#secondary').height(windowheight-colophon);
        }
        if(windowheight <= primaryheight){
            jQuery('#secondary').height(primaryheight);
        }
    }
    
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

$( window ).bind('beforeunload', function(){
    var player56sMacAddr = $("#player56s-mac-address");
    var player56scurrenttrack = $("#player56s-currenttrack");
    setCookie(player56sMacAddr+"Player56sState", player56scurrenttrack[0].innerText, 1);
    var player56scurrentseek = $("#player56s-seek-current-percent");
    setCookie(player56sMacAddr+"Player56sSeek", player56scurrentseek[0].innerText, 1);
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
        if (windowwidth < 720) {
            navigator.wakeLock.request('screen')
            .then((wakeLock) => {
                //
            })
        }
    }
}

document.addEventListener('visibilitychange', function(){
    doVisualUpdates = !document.hidden;
    update();
});

jQuery(document).ready(function($) {
    doVisualUpdates = !document.hidden;
    update();
    sidebarheight($);
    sortable_playlist($);
    footer_stick($);
});