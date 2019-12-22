/* jQuery(document).ready(function() {
    jQuery('#menu-off').bigSlide();
    jQuery('.menu-link').bigSlide();
}); */

var jQuery = jQuery.noConflict();


jQuery(document).ready(function() {      
    jQuery('#btn_player_reload').click(function() {
        location.reload();
    });
    jQuery('#btn_player_toggle').click(function() {
        jQuery('#player56s-ui-zone').toggleClass('hide-player');
        jQuery('#page').css('padding-bottom', jQuery('#wrap-player').height() +'px');
        jQuery('#btn_player_toggle').toggleClass('up-arrow');
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

    $(function() {
        $( "#rs-saved-for-later" ).sortable({    
            start: function(e, ui) {
                // creates a temporary attribute on the element with the old index
                $(this).attr('data-previndex', ui.item.index());
                ui.item.index();
            },
            update: function(e, ui) {
                // gets the new and old index then removes the temporary attribute
                var newIndex = ui.item.index();
                var oldIndex = $(this).attr('data-previndex');
                $("#player56s-sortable").html('<ul><li>' + oldIndex + '</li><li>' + newIndex + '</li></ul>');

                $(".player56s").player56s($);
                
                $("#player56s-sortable").html(null);      

                $(this).removeAttr('data-previndex');
            }
        });
        $( "#rs-saved-for-later" ).disableSelection();
    }); 
}

function sleep(milliseconds) {
    var start = new Date().getTime();
    for (var i = 0; i < 1e7; i++) {
        if ((new Date().getTime() - start) > milliseconds){
            break;
        }
    }
}

function stickysidebar($) {
    var sidebar = new StickySidebar('#secondary', {
        containerSelector: '#content',
        resizeSensor: true,
        minWidth: 630,
        topSpacing: 75,
        bottomSpacing: 200
    });
}

jQuery(document).ready(function($) {
    scroll_to_album($);
    sortable_playlist($);
    footer_stick($);
    stickysidebar($)
  });

  var doVisualUpdates = true;

  function update() {
    if (!doVisualUpdates) {
        console.log("Tab not visible");
      return;
    }
    console.log("Tab visible");
  }

  document.addEventListener('visibilitychange', function(){
    doVisualUpdates = !document.hidden;
    update();
  });