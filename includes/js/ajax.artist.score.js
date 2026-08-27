function artist_score($){
    
        if (jQuery('#artist-scores-chart').length > 0) {
    
            var artistid = jQuery('#artist-id').html();
            
            jQuery.ajax({
                type: 'post',
                url: artist_score_ajax_url,
                data: {
                    'artistid': artistid,
                    'action': 'artist_score'
                },
                dataType: 'json',
                success: function(data){
                    var ctx = $('#artist-scores-chart').get(0).getContext('2d');
    
                    var myChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: data[0],
                            datasets: [{
                                label: 'Artist Scores',
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
    artist_score($);
});