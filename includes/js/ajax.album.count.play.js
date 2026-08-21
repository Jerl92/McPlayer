function album_count_play($){
    
        if (jQuery('#album-count-play-chart').length > 0) {
    
        var albumid = jQuery('#albumid').html();
        
            jQuery.ajax({
                type: 'post',
                url: album_count_play_ajax_url,
                data: {
                    'albumid': albumid,
                    'action': 'album_count_play'
                },
                dataType: 'json',
                success: function(data){
                    var ctx = $('#album-count-play-chart').get(0).getContext('2d');
    
                    var myChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: data[0],
                            datasets: [{
                                label: 'Count Plays',
                                backgroundColor: ['#000'],
                                data: data[1],
                            }]
                        },
                        options: {}
                    });
                },
                error: function(errorThrown){
                    console.log(errorThrown);
                }
            });
        
        }
}

jQuery(document).ready(function($) {
    album_count_play($);
});