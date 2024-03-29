
function mcplayer_load_saved_playlist($) {    
    $('.rs-save-for-later-load-playlist').on('click', function(event) {
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
                $("#subnav-content-load").html(null);
                data.forEach(function(element, index) {
                    $("#subnav-content-load").append(element);
                }, this); 
                mcplayer_load_playlist($);
            },
            error: function(errorThrown){
                console.log(errorThrown);
            }
        });
        $("#subnav-content-load").toggleClass("subnav-content-display");
        $("#subnav-content-save").removeClass("subnav-content-display");
    });
}
    
function mcplayer_load_playlist($) { 
    $('.playlist-load-loop').on('click', function(event) {
        event.preventDefault();
        event.stopPropagation();
        event.stopImmediatePropagation();

        var $this = $(this),
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
				$("#player56s-removetracks-all").html("1");  
				$(".player56s").player56s($);
				$("#player56s-removetracks-all").html(null);
                links = data.playlist.reverse();
                links.forEach(function(element, index) {
                    $('.rs-save-for-later-button').each(function(){
                        if($(this).data('object-id') == element){
                            $(this).addClass('saved');
                            $(this).attr('data-title', 'Remove');
                            $(this).attr('data-original-title', 'Remove');
                        }
                    });
                    setTimeout(function() {
                        $('.playlist_matches_count').html(null);
                        $('.playlist_matches_count').html(index+1);
                        ajax_playlist($, element);
                        ajax_playlist_add_sidebar($, element);
                    }, index*100);
                }, this);  
                data.playlist_album.forEach(function(element) {
                    $('.rs-save-for-later-button-album').each(function() {
                        var data_id = $(this).data("object-id");
                        if(data_id == element){
                            $(this).addClass('saved');
                        }
                    }); 
                }, this);  
            },
            error: function(errorThrown){
                console.log(errorThrown);
            }
        });
        $("#subnav-content-load").toggleClass("subnav-content-display");
    });
}

jQuery(document).ready(function($) {
    mcplayer_load_playlist($);
    mcplayer_load_saved_playlist($);
});