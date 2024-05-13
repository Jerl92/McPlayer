 
function mcplayer_search_ajax($) {    
    $( "#target" ).on( "keyup", function(event) {
        var inputVal = document.getElementById("target").value;
        event.preventDefault();
        event.stopPropagation();
        event.stopImmediatePropagation();

        $.fn.ready();
        'use strict';

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
                    $("#widget-mcplayer-search-result").css("display","block");
                    $("#widget-mcplayer-search-result").css("position","absolute");
                    $("#widget-mcplayer-search-result").css("z-index","99");
                    $("#widget-mcplayer-search-result").css("margin-top","15px");
                    $("#widget-mcplayer-search-result").css("border","0.05px solid #000");
                    $("#widget-mcplayer-search-result").css("background","#fff");
                    $("#widget-mcplayer-search-result").css("width","98%");
                    $("#widget-mcplayer-search-result").css("overflow-y","scroll");
                    $("#widget-mcplayer-search-result").css("overflow-x","none");
                    $("#widget-mcplayer-search-result").html(data);
                    var windowheight = $(window).height();
                    var wrapplayer = $('#wrap-player').height();
                    var searchwrapper = $('#widget-mcplayer-search-wrapper').height();
                    if(windowheight >= searchwrapper){
                        $("#widget-mcplayer-search-result").css("height", searchwrapper+35);
                    } else {
                        $("#widget-mcplayer-search-result").css("height", windowheight-wrapplayer-250);
                    }
                    rs_save_for_later_album($);
                    rs_save_for_later($);
                    play_pause($);
                    play_now($);
                } else {
                    $("#widget-mcplayer-search-result").css("display","none");
                }
            },
            error: function(errorThrown){
                //error stuff here.text
            }
        });
        var base_url = window.location.origin;
        if(inputVal === ''){
            $(".widget-mcplayer-search-a").attr("href", base_url);
        } else {
            $(".widget-mcplayer-search-a").attr("href", base_url+"?s="+inputVal);
        }
    });
    $('#target').mouseup(function(event) {
        var inputVal = document.getElementById("target").value;
        event.preventDefault();
        event.stopPropagation();
        event.stopImmediatePropagation();

        $.fn.ready();
        'use strict';

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
                        $("#widget-mcplayer-search-result").css("display","block");
                        $("#widget-mcplayer-search-result").css("position","absolute");
                        $("#widget-mcplayer-search-result").css("z-index","99");
                        $("#widget-mcplayer-search-result").css("margin-top","15px");
                        $("#widget-mcplayer-search-result").css("border","0.05px solid #000");
                        $("#widget-mcplayer-search-result").css("background","#fff");
                        $("#widget-mcplayer-search-result").css("width","98%");
                        $("#widget-mcplayer-search-result").css("overflow-y","scroll");
                        $("#widget-mcplayer-search-result").css("overflow-x","none");
                        $("#widget-mcplayer-search-result").html(data);
                        var windowheight = $(window).height();
                        var wrapplayer = $('#wrap-player').height();
                        var searchwrapper = $('#widget-mcplayer-search-wrapper').height();
                        if(windowheight >= searchwrapper){
                            $("#widget-mcplayer-search-result").css("height", searchwrapper+35);
                        } else {
                            $("#widget-mcplayer-search-result").css("height", windowheight-wrapplayer-250);
                        }
                        rs_save_for_later_album($);
                        rs_save_for_later($);
                        play_pause($);
                        play_now($);
                    } else {
                        $("#widget-mcplayer-search-result").css("display","none");
                    }
                },
                error: function(errorThrown){
                    //error stuff here.text
                }
            });
        }
        var base_url = window.location.origin;
        if(inputVal === ''){
            $(".widget-mcplayer-search-a").attr("href", base_url);
        } else {
            $(".widget-mcplayer-search-a").attr("href", base_url+"?s="+inputVal);
        }
    });
    $('#widget-mcplayer-search-result').mouseup(function(event) {
        event.preventDefault();
        event.stopPropagation();
        event.stopImmediatePropagation();
        $("#widget-mcplayer-search-result").css("display","none");
    });
}

jQuery(document).on('click', function (event) {
    event.preventDefault();
    event.stopPropagation();
    event.stopImmediatePropagation();
    if ($(event.target).closest("#widget-mcplayer-search-result").length === 0) {
        $("#widget-mcplayer-search-result").hide();
    }
});

jQuery(document).on('keypress',function(event) {
    if(event.which == 13) {
        if($('#target').val() != ''){
            $( '.widget-mcplayer-search-button' ).click();
        }
    }
});

jQuery(document).ready(function($) {
    mcplayer_search_ajax($);
});