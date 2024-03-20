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

                    sleep(50);
                },
                error: function(errorThrown){
                    //error stuff here.text
                }
        });

}