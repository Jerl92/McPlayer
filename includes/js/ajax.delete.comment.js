function delete_comment($){
    jQuery('.comment_delete').click(function($){

        var $this = jQuery(this),
        object_id = $this.data('object-id');

        jQuery.ajax({
            type: 'post',
            url: delete_comment_ajax_url,
            data: {
                'postid': object_id,
                'action': 'delete_comment'
            },
            dataType: 'json',
            success: function(data){
                jQuery('.comment_ID_'+object_id).html(null);
            },
            error: function(errorThrown){
                console.log(errorThrown);
            }
        });
    });
}

jQuery(document).ready(function($) {
    delete_comment($);
});