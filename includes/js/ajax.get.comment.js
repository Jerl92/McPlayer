function get_comment($, postid){

    jQuery.ajax({
        type: 'post',
        url: get_comment_ajax_url,
        data: {
            'postid': postid,
            'action': 'get_comment_ajax'
        },
        dataType: 'json',
        success: function(data){
            jQuery('#comments-wrapper').html(null);
            jQuery('#comments-wrapper').html(data);
            delete_comment($);
        },
        error: function(errorThrown){
            console.log(errorThrown);
        }
    });
}