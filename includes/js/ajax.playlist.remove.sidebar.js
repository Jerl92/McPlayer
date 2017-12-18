function ajax_playlist_remove_sidebar($, object_id)  {
    
    $.ajax({    
        url: remove_track_sidebar_ajax_url,
        type: 'post',
        data: {
            'object_id': object_id,
            'action': 'remove_track_sidebar',
        },
        dataType: 'JSON',
        success: function(data){
           $("#rs-item-" + data).remove(); 
        },
        error: function(errorThrown){
            //error stuff here
        },
});
            

}

function ajax_playlist_remove_page_btn($, object_id)  {

    $.ajax({    
        url: remove_track_ajax_url,
        type: 'post',
        data: {
            'object_id': object_id,
            'action': 'remove_track_sidebar',
        },
        dataType: 'JSON',
        success: function(data){
           
            $("#rs-item-" + data).remove(); 
        },
        error: function(errorThrown){
            //error stuff here
        },
});

}
            

