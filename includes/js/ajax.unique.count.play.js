function unique_count_play($){
    
        if (jQuery('#unique-count-play-chart').length > 0) {
    
        var postid = jQuery('#postid').html();
        
            jQuery.ajax({
                type: 'post',
                url: unique_count_play_ajax_url,
                data: {
                    'postid': postid,
                    'action': 'unique_count_play'
                },
                dataType: 'json',
                success: function(data){
                    var ctx = $('#unique-count-play-chart').get(0).getContext('2d');
                    
                    var myChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: data[0],
                            datasets: [{
                                label: 'Unique Song Count Plays',
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
    unique_count_play($);
});