/* jQuery(document).ready(function() {
    jQuery('#menu-off').bigSlide();
    jQuery('.menu-link').bigSlide();
}); */

var jQuery = jQuery.noConflict();


jQuery(document).ready(function() {      
    jQuery('#btn_player_toggle').click(function() {
        jQuery('#player56s-ui-zone').toggleClass('hide-player');
        jQuery('#page').css('padding-bottom', jQuery('#wrap-player').height() +'px');
        jQuery('#btn_player_toggle').toggleClass('up-arrow');
        stickysidebar($);
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
    } else {
        jQuery('#colophon').css('position', 'static');
        jQuery('#colophon').css('bottom', '0');
        jQuery('#colophon').css('width', '100%');
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
    } else {
        jQuery('#colophon').css('position', 'static');
        jQuery('#colophon').css('bottom', '0');
        jQuery('#colophon').css('width', '100%');
    }

});

function scroll_to_album($) {
    
    $.fn.ready();
    'use strict';

//    if ($('#idalbum')) {

        // to top right away
        if ( window.location.hash ) scroll(0,0);
        // void some browsers issue
        setTimeout( function() { scroll(0,0); }, 1);

        // jQuery('.saved').css("padding-bottom", "20px");    

        // any position
        $(function() {
            windowwidth = $(window).width();
            // *only* if we have anchor on the url
            if(window.location.hash) {
                if (windowwidth >= 450) {
                    // smooth scroll to the anchor id
                    $('html, body').animate({
                        scrollTop: ($(window.location.hash).offset().top - 55) + 'px'
                    }, 1000, 'swing');
                } else  {
                    $('html, body').animate({
                        scrollTop: $(window.location.hash).offset().top + 'px'
                    }, 1000, 'swing');
                }
            }
        });

  //  }
}

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

function sidebarheight($) {
    var windowwidth = jQuery(window).width();
    var windowheight = jQuery(window).height();
    var wrapplayer = jQuery('#wrap-player').height();
    var colophon = jQuery('#colophon').height();
    var masthead = jQuery('#masthead').height();
    if (windowwidth > 720) {
        var primaryHeight = jQuery('#primary').height();
        jQuery('#secondary').css('min-height', windowheight-(160+colophon+100));
        jQuery('#secondary').css('height', primaryHeight);
        jQuery('#secondary').css('overflow', 'hidden scroll');
        jQuery('#secondary').css('display', 'block');
    }
}

var doVisualUpdates = true;

function update() {
    if (!doVisualUpdates) {
        console.log("Tab not visible");
    }
    navigator.wakeLock.request('screen')
    .then((wakeLock) => {
        console.log(wakeLock);
        console.log('acquired');
    })
}

document.addEventListener('visibilitychange', function(){
    doVisualUpdates = !document.hidden;
    update();
});

jQuery(document).ready(function($) {
    doVisualUpdates = !document.hidden;
    update();
    scroll_to_album($);
    sortable_playlist($);
    footer_stick($);
    //stickysidebar($);
    sidebarheight($);
  });