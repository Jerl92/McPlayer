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
                    //print stuff heres

                    sleep(100);

                    $("#player56s-addtrack").html(data);

                    $(".player56s").player56s($);
                    
                    $("#player56s-addtrack").html(null);
                },
                error: function(errorThrown){
                    //error stuff here.text
                }
        });

}