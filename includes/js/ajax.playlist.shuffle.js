function ajax_shuffle($)  {

    $('.shuffle_player_toggle').on('click', function(event) {

        $.ajax({    
            type: 'post',
            url: shuffle_ajax_url,
            data: {
                'object_id': null,
                'action': 'shuffle_playlist'
            },
            dataType: 'JSON',
            success: function(data){
                //print stuff heres
                $("#player56s-shuffle").html(data);

                if (data == 0){
                    $(".shuffle_player_toggle").css("box-shadow", "");
                    ajax_no_shuffle($);
                }

                if (data == 1){
                    $(".shuffle_player_toggle").css("box-shadow", "2.5px 2.5px 2.5px #000");
                    $(".player56s").player56s($);
                }

            },
            error: function(errorThrown){
                console.log(errorThrown);
                //error stuff here.text
            }
        });

    });

}

function ajax_no_shuffle($)  {

    $.ajax({    
        type: 'post',
        url: shuffle_ajax_url,
        data: {
            'object_id': null,
            'action': 'no_shuffle'
        },
        dataType: 'JSON',
        success: function(data){
            //print stuff heres
            $("#player56s-no-shuffle").html(data);
            $("#player56s-shuffle").html('0');
            $(".player56s").player56s($);  
            $("#player56s-no-shuffle").empty();
        },
        error: function(errorThrown){
            //error stuff here.text
        }
});

}

jQuery(document).ready(function($) {
    ajax_shuffle($);
});