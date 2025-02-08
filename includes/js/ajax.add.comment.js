function add_comment($){
    jQuery('#submit_comment').click(function($){

        var text = jQuery('#comment_text').val();
        var postid = jQuery('#comment_post_ID').val();
        var email = jQuery('#email_commnent').val();
        var author = jQuery('#author_comment').val();

        jQuery.ajax({
            type: 'post',
            url: add_comment_ajax_url,
            data: {
                'text': text,
                'postid': postid,
                'email': email,
                'author': author,
                'action': 'add_comment'
            },
            dataType: 'json',
            success: function(data){
                jQuery('#respond_comment').html(null);
                jQuery('#respond_comment').html('Thanks you for your comment!');
                get_comment($, postid);
            },
            error: function(errorThrown){
                console.log(errorThrown);
            }
        });
    });
}

jQuery(document).ready(function($) {
    add_comment($);
});