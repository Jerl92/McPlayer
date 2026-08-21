
function mcplayer_load_saved_playlist($) {    

    jQuery('.rs-save-for-later-load-playlist').on('click', function(event) {
        event.preventDefault();
        event.stopPropagation();
        event.stopImmediatePropagation();

        jQuery.ajax({
            type: 'post',
            url: save_playlist_ajax_url,
            data: {
                'action': 'load_saved_playlist'
            },
            dataType: 'json',
            success: function(data){
                jQuery("#subnav-content-load").html(null);
                data.forEach(function(element, index) {
                    jQuery("#subnav-content-load").append(element);
                }, this); 
                mcplayer_load_playlist($);
                
            },
            error: function(errorThrown){
                console.log(errorThrown);
            }
        });
        jQuery("#subnav-content-load").toggleClass("subnav-content-display");
        jQuery("#subnav-content-save").removeClass("subnav-content-display");
    });
}
    
function mcplayer_load_playlist($) { 

    jQuery('.playlist-load-loop').on('click', function(event) {
        event.preventDefault();
        event.stopPropagation();
        event.stopImmediatePropagation();

        var $this = jQuery(this),
        object_id = $this.data('id');
    
        jQuery.ajax({
            type: 'post',
            url: save_playlist_ajax_url,
            data: {
                'object_id': object_id,
                'action': 'load_playlist'
            },
            dataType: 'json',
            success: function(data){
                jQuery("#player56s-removetracks-all").html("1");
                jQuery(".player56s").player56s($);
                jQuery("#player56s-removetracks-all").html(null);
                links = data.playlist.reverse();
                var length = 0;
                var formattedHours = 0;
                var formattedMinutes = 0;
                var formattedSeconds = 0;
                links.forEach(function(element, index) {
                    setTimeout(function() {
                        ajax_playlist($, element);
                        ajax_playlist_add_sidebar($, element);
                        jQuery('.genre_widget').html(data.genres);
                        jQuery('.playlist_matches_count').html(index+1);
                        var timeParts = 0;
                        var totalSeconds = 0;
                        var hours = 0;
                        var minutes = 0;
                        var seconds = 0;
                        timeParts = data.length[index].split(':');
                        totalSeconds = (parseInt(timeParts[0]) * 60) + parseInt(timeParts[1]);
                        length = parseInt(length) + parseInt(totalSeconds);
                        hours = Math.floor(parseInt(length) / 3600);
                        minutes = Math.floor((parseInt(length) % 3600) / 60);
                        seconds = parseInt(length) % 60;
                        formattedHours = String(hours).padStart(2, '0');
                        formattedMinutes = String(minutes).padStart(2, '0');
                        formattedSeconds = String(seconds).padStart(2, '0');
                        jQuery(".playlist_matches_length").html(formattedHours + ':' + formattedMinutes + ':' + formattedSeconds);
                        
                        jQuery('.rs-save-for-later-button').each(function(){
                            if(jQuery(this).data('object-id') === element){
                                jQuery(this).addClass('saved');
                                jQuery(this).attr('data-original-title', 'Remove');
                            }
                        });
                    }, index*125);
                }, this);  
                data.playlist_album.forEach(function(element) {
                    jQuery('.rs-save-for-later-button-album').each(function() {
                        var data_id = jQuery(this).data("object-id");
                        if(data_id == element){
                            jQuery(this).addClass('saved');
                            jQuery(this).attr('data-original-title', 'Remove');
                        }
                    }); 
                }, this);
                
            },
            error: function(errorThrown){
                console.log(errorThrown);
            }
        });
        jQuery("#subnav-content-load").toggleClass("subnav-content-display");
    });
}

jQuery(document).ready(function($) {
    mcplayer_load_saved_playlist($);
});