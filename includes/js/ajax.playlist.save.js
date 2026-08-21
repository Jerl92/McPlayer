
function mcplayer_save_playlist($) {    
    jQuery('.rs-save-for-later-save-playlist').on('click', function(event) {
        event.preventDefault();
        event.stopPropagation();
        event.stopImmediatePropagation();
        
        jQuery('#subnav-content-save').toggleClass('subnav-content-display');
        jQuery("#subnav-content-load").removeClass("subnav-content-display");

    });

    jQuery('.save-playlist').on('click', function(event) {
        event.preventDefault();
        event.stopPropagation();
        event.stopImmediatePropagation();

        var inputVal = jQuery(".save-playlist-text").val();
    
        jQuery.ajax({
            type: 'post',
            url: save_playlist_ajax_url,
            data: {
                'inputVal': inputVal,
                'action': 'save_playlist'
            },
            dataType: 'json',
            success: function(data){
                jQuery('.save-playlist-text').val('');
                jQuery('#subnav-content-save').toggleClass('subnav-content-display');
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