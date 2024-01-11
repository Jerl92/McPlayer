 
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
                    $("#widget-mcplayer-search-result").css("border","0.05px solid #000");
                    $("#widget-mcplayer-search-result").css("background","#fff");
                    $("#widget-mcplayer-search-result").css("width","82.5%");
                    $("#widget-mcplayer-search-result").html(data);
                } else {
                    $("#widget-mcplayer-search-result").css("display","none");
                }
            },
            error: function(errorThrown){
                //error stuff here.text
            }
        });
    });
    $('#mcplayer-search-get').on('click', function(event) {
        event.preventDefault();
        event.stopPropagation();
        $("#widget-mcplayer-search-result").css("display","none");
    });
}

jQuery(document).ready(function($) {
    mcplayer_search_ajax($);
});