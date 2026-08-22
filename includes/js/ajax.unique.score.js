function unique_score($){
    
        if (jQuery('#unique-score-chart').length > 0) {
    
            var postid = jQuery('#postid').html();
            
            jQuery.ajax({
                type: 'post',
                url: unique_score_ajax_url,
                data: {
                    'postid': postid,
                    'action': 'unique_score'
                },
                dataType: 'json',
                success: function(data){
                    var ctx = $('#unique-score-chart').get(0).getContext('2d');
    
                    var myChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: data[0],
                            datasets: [{
                                label: 'Unique Song Scores',
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
    unique_score($);
});