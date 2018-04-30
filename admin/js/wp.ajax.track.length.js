function ajax_track_length($, object_id) {
    $.ajax({    
        url : wp_ajax_track_length,
        type: 'post',
        data : {
            'object_id': object_id,
            'action': 'track_length'
        },
        dataType: 'JSON',
        success: function(data) {
            $( '#track-length-value' ).attr('value', data);
            console.log(data);
        },
        error: function(errorThrown){
            //error stuff here
        }
    });
}   