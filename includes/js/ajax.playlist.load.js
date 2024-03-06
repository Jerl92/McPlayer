
function mcplayer_load_saved_playlist($) {    
    $('.rs-save-for-later-load-playlist').on('click', function(event) {
        event.preventDefault();
        event.stopPropagation();

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
                data.forEach(function(element, index) {
                    const chars = element.split('</li><li>');
                    rs_save_for_later($, chars[2]);
                    ajax_playlist_add_sidebar($, chars[2]);
                    $("#player56s-addtrack").html(element);
                    $(".player56s").player56s($);   
                    $(".playlist_matches_count").text(index+1);
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