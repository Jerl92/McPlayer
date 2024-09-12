
function mcplayer_load_genre($) {    

        jQuery.ajax({
            type: 'post',
            url: current_genre_ajax_url,
            data: {
                'action': 'load_genre_playlist'
            },
            dataType: 'json',
            success: function(data){
                $('.genre_widget').empty();
                $('.genre_widget').html(data);
            },
            error: function(errorThrown){
                console.log(errorThrown);
            }
        });
}

jQuery(document).ready(function($) {
    mcplayer_load_genre($);
});