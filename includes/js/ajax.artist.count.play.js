function artist_count_play($){
    
        if (jQuery('#artist-count-plays-chart').length > 0) {
    
        var artistid = jQuery('#artist-id').html();
        
            jQuery.ajax({
                type: 'post',
                url: artist_count_play_ajax_url,
                data: {
                    'artistid': artistid,
                    'action': 'artist_count_play'
                },
                dataType: 'json',
                success: function(data){
                    var ctx = $('#artist-count-plays-chart').get(0).getContext('2d');
    
                    var myChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: data[0],
                            datasets: [{
                                label: 'Artist Count Plays',
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
    artist_count_play($);
});