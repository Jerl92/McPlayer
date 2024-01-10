
function mcplayer_save_playlist($) {    
    $('.rs-save-for-later-save-playlist').on('click', function(event) {
        event.preventDefault();
        event.stopPropagation();
        
        $('#subnav-content-save').toggleClass('subnav-content-display');
        $("#subnav-content-load").removeClass("subnav-content-display");
    });

    $('.save-playlist').on('click', function(event) {
        event.preventDefault();
        event.stopPropagation();

        var inputVal = document.getElementById("lnamesave").value;
    
        jQuery.ajax({
            type: 'post',
            url: save_playlist_ajax_url,
            data: {
                'inputVal': inputVal,
                'action': 'save_playlist'
            },
            dataType: 'json',
            success: function(data){
                $('#subnav-content-save').toggleClass('subnav-content-display');
                $('#lnamesave').val('');
            },
            error: function(errorThrown){
                //error stuff here.text
            }
        });
    });
}

jQuery(document).ready(function($) {
    mcplayer_save_playlist($);
});