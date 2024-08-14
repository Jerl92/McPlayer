function ajax_playlist($, object_id)  {

            $.ajax({    
                type: 'post',
                url: add_track_ajax_url,
                data: {
                    'object_id': object_id,
                    'action': 'add_track'
                },
                dataType: 'JSON',
                success: function(data){

                    $("#player56s-addtrack").html(data);

                    $(".player56s").player56s($);
                    
                    $("#player56s-addtrack").html(null);
                    
                },
                error: function(errorThrown){
                    //error stuff here.text
                }
        });

}

function ajax_playlist_add_playlist($)  {

    $.ajax({    
        type: 'post',
        url: add_track_playlist_ajax_url,
        data: {
            'action': 'add_track_playlist'
        },
        dataType: 'JSON',
        success: function(data){

            data.forEach(function(element, index) {
                $('.rs-save-for-later-button').each(function() {
                    var $this = $(this),
                    object_id = $this.data('object-id');
                    if(object_id === element){
                        $(this).addClass('saved');
                        $(this).attr('data-original-title', 'Remove');
                    }
                });
            }, this); 
            
        },
        error: function(errorThrown){
            //error stuff here.text
        }
});

}

function ajax_playlist_load_playlist($)  {

    $.ajax({    
        type: 'post',
        url: add_track_playlist_ajax_url,
        data: {
            'object_id': element,
            'action': 'load_track_playlist'
        },
        dataType: 'JSON',
        success: function(data){

            // console.log(data);
            
        },
        error: function(errorThrown){
            //error stuff here.text
        }
});

}