function album_score($){
         var albumid = jQuery('#albumid').html();
        
        jQuery.ajax({
            type: 'post',
            url: album_score_ajax_url,
            data: {
                'albumid': albumid,
                'action': 'album_score'
            },
            dataType: 'json',
            success: function(data){
                var ctx = $('#album-score-chart').get(0).getContext('2d');

                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: data[0],
                        datasets: [{
                            label: 'Album Scores',
                            data: data[1],
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            },
            error: function(errorThrown){
                console.log(errorThrown);
            }
        });
}

jQuery(document).ready(function($) {
    album_score($);
});