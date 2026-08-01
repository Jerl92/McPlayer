function save_score($){
    var typingTimer;
    var doneTypingInterval = 1000;
    jQuery('.song-unique-score-input').on('input', function() {
        clearTimeout(typingTimer);
        var input = jQuery(this);
        typingTimer = setTimeout(function() {
            var finalNumber = input.val();
            var postid = jQuery('.postid').html();
            var userid = jQuery('.userid').html();
            jQuery.ajax({
                type: 'post',
                url: save_score_ajax_url,
                data: {
                    'userid':userid,
                    'postid': postid,
    		        'value': finalNumber,
                    'action': 'save_score'
                },
                dataType: 'json',
                success: function(data){
    		        jQuery('.newarray').html(data);
                },
                error: function(errorThrown){
                    console.log(errorThrown);
                }
            });
            
        }, doneTypingInterval);
    });
}

jQuery(document).ready(function($) {
    save_score($);
});