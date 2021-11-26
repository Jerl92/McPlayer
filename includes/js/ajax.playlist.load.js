
function mcplayer_load_playlist($) {    
    $('.rs-save-for-later-load-playlist').on('click', function(event) {
        event.preventDefault();
        event.stopPropagation();
        event.stopImmediatePropagation();
        $("#subnav-content-load").toggleClass("subnav-content-display");
    });

    $('.playlist-load-loop').on('click', function(event) {
        event.preventDefault();
        event.stopPropagation();
        event.stopImmediatePropagation();

        var $this = $(this),
        object_id = $this.data('id');

        console.log(object_id);
    
        jQuery.ajax({
            type: 'post',
            url: save_playlist_ajax_url,
            data: {
                'object_id': object_id,
                'action': 'load_playlist'
            },
            dataType: 'json',
            success: function(data){
                console.log(data);
                ajax_playlist_flush_sidebar($);
				$("#player56s-removetracks-all").html("1");  
				$(".player56s").player56s($);
				$("#player56s-removetracks-all").html(null);
                data.forEach(function(element, index) {
                    $("#player56s-addtrack").html(element);
                    $(".player56s").player56s($);                    
                    $("#player56s-addtrack").html(null);
                }, this);   
                ajax_playlist_add_sidebar($, object_id);
            },
            error: function(errorThrown){
                //error stuff here.text
            }
        });
    });
}

jQuery(document).ready(function($) {
    mcplayer_load_playlist($);
});