function album_count_play($){
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
    album_count_play($);
});