 
function mcplayer_search_ajax($) {    
    $( "#target" ).on( "keyup", function() {
        var inputVal = document.getElementById("target").value;
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
                    $("#widget-mcplayer-search-result").css("z-index","999");
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
                        $("#widget-mcplayer-search-result").css("height", searchwrapper+25);
                    } else {
                        $("#widget-mcplayer-search-result").css("height", windowheight-wrapplayer-350);
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
    });
    $('#target').mouseup(function(event) {
        var inputVal = document.getElementById("target").value;
        event.preventDefault();
        event.stopPropagation();
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
                        $("#widget-mcplayer-search-result").css("z-index","999");
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
                            $("#widget-mcplayer-search-result").css("height", searchwrapper+25);
                        } else {
                            $("#widget-mcplayer-search-result").css("height", windowheight-wrapplayer-350);
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
    });
    $('#widget-mcplayer-search-result').mouseup(function(event) {
        event.preventDefault();
        event.stopPropagation();
        $("#widget-mcplayer-search-result").css("display","none");
    });
    $( "#target" ).on( "keyup", function(event) {
        event.preventDefault();
        event.stopPropagation();
        var base_url = window.location.origin;
        var inputVal = document.getElementById("target").value;
        $(".widget-mcplayer-search-a").attr("href", base_url+"?s="+inputVal);
    });
}

jQuery(document).on('click', function (event) {
    event.preventDefault();
    event.stopPropagation();
    if ($(event.target).closest("#widget-mcplayer-search-result").length === 0) {
        $("#widget-mcplayer-search-result").hide();
    }
});

$(document).on('keypress',function(event) {
    if(event.which == 13) {
        if($('#target').val() != ''){
            $( '.widget-mcplayer-search-button' ).click();
        }
    }
});

jQuery(document).ready(function($) {
    mcplayer_search_ajax($);
});