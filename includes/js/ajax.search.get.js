 
function mcplayer_search_ajax($) {    
    jQuery( "#target" ).on( "keyup", function(event) {
        var inputVal = document.getElementById("target").value;
        event.preventDefault();
        event.stopPropagation();
        event.stopImmediatePropagation();

        jQuery.ajax({
            type: 'post',
            url: search_get_ajax_url,
            data: {
                'inputVal': inputVal,
                'action': 'search_ajax_get'
            },
            dataType: 'json',
            success: function(data){
                if(inputVal != '' && data != ''){
                    jQuery("#widget-mcplayer-search-result").css("display","block");
                    jQuery("#widget-mcplayer-search-result").css("position","absolute");
                    jQuery("#widget-mcplayer-search-result").css("z-index","99");
                    jQuery("#widget-mcplayer-search-result").css("margin-top","15px");
                    jQuery("#widget-mcplayer-search-result").css("border","0.05px solid #000");
                    jQuery("#widget-mcplayer-search-result").css("background","#fff");
                    jQuery("#widget-mcplayer-search-result").css("width","98%");
                    jQuery("#widget-mcplayer-search-result").css("overflow-y","scroll");
                    jQuery("#widget-mcplayer-search-result").css("overflow-x","none");
                    jQuery("#widget-mcplayer-search-result").html(data);
                    var windowheight = jQuery(window).height();
                    var wrapplayer = jQuery('#wrap-player').height();
                    var searchwrapper = jQuery('#widget-mcplayer-search-wrapper').height();
                    if(windowheight >= searchwrapper){
                        jQuery("#widget-mcplayer-search-result").css("height", searchwrapper+35);
                    } else {
                        jQuery("#widget-mcplayer-search-result").css("height", windowheight-wrapplayer-250);
                    }
                    rs_save_for_later_album($);
                    rs_save_for_later($);
                    play_pause($);
                    play_now($);
                } else {
                    jQuery("#widget-mcplayer-search-result").css("display","none");
                }
            },
            error: function(errorThrown){
                //error stuff here.text
            }
        });
        var base_url = window.location.origin;
        if(inputVal === ''){
            jQuery(".widget-mcplayer-search-a").attr("href", base_url);
        } else {
            jQuery(".widget-mcplayer-search-a").attr("href", base_url+"?s="+inputVal);
        }
    });
    jQuery('#target').mouseup(function(event) {
        var inputVal = document.getElementById("target").value;
        event.preventDefault();
        event.stopPropagation();
        event.stopImmediatePropagation();

        if(inputVal != ''){
            jQuery.ajax({
                type: 'post',
                url: search_get_ajax_url,
                data: {
                    'inputVal': inputVal,
                    'action': 'search_ajax_get'
                },
                dataType: 'json',
                success: function(data){
                    if(inputVal != '' && data != ''){
                        jQuery("#widget-mcplayer-search-result").css("display","block");
                        jQuery("#widget-mcplayer-search-result").css("position","absolute");
                        jQuery("#widget-mcplayer-search-result").css("z-index","99");
                        jQuery("#widget-mcplayer-search-result").css("margin-top","15px");
                        jQuery("#widget-mcplayer-search-result").css("border","0.05px solid #000");
                        jQuery("#widget-mcplayer-search-result").css("background","#fff");
                        jQuery("#widget-mcplayer-search-result").css("width","98%");
                        jQuery("#widget-mcplayer-search-result").css("overflow-y","scroll");
                        jQuery("#widget-mcplayer-search-result").css("overflow-x","none");
                        jQuery("#widget-mcplayer-search-result").html(data);
                        var windowheight = jQuery(window).height();
                        var wrapplayer = jQuery('#wrap-player').height();
                        var searchwrapper = jQuery('#widget-mcplayer-search-wrapper').height();
                        if(windowheight >= searchwrapper){
                            jQuery("#widget-mcplayer-search-result").css("height", searchwrapper+35);
                        } else {
                            jQuery("#widget-mcplayer-search-result").css("height", windowheight-wrapplayer-250);
                        }
                        rs_save_for_later_album($);
                        rs_save_for_later($);
                        play_pause($);
                        play_now($);
                    } else {
                        jQuery("#widget-mcplayer-search-result").css("display","none");
                    }
                },
                error: function(errorThrown){
                    //error stuff here.text
                }
            });
        }
        var base_url = window.location.origin;
        if(inputVal === ''){
            jQuery(".widget-mcplayer-search-a").attr("href", base_url);
        } else {
            jQuery(".widget-mcplayer-search-a").attr("href", base_url+"?s="+inputVal);
        }
    });
}

jQuery(document).on('click', function (event) {
    event.preventDefault();
    event.stopPropagation();
    event.stopImmediatePropagation();
    if (jQuery(event.target).closest("#widget-mcplayer-search-result").length === 0) {
        jQuery("#widget-mcplayer-search-result").hide();
    }
});

jQuery(document).on('keypress',function(event) {
    if(event.which == 13) {
        if(jQuery('#target').val() != ''){
            jQuery( '.widget-mcplayer-search-button' ).click();
        }
    }
});

jQuery(document).ready(function($) {
    mcplayer_search_ajax($);
});