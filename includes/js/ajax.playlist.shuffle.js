function ajax_shuffle($)  {

    jQuery('.shuffle_player_toggle').on('click', function(event) {

        jQuery.ajax({    
            type: 'post',
            url: shuffle_ajax_url,
            data: {
                'object_id': null,
                'action': 'shuffle_playlist'
            },
            dataType: 'JSON',
            success: function(data){
                //print stuff heres
                jQuery("#player56s-shuffle").html(data);

                if (data == 0){
                    jQuery(".shuffle_player_toggle").css("box-shadow", "");
                    ajax_no_shuffle($);
                }

                if (data == 1){
                    jQuery(".shuffle_player_toggle").css("box-shadow", "2.5px 2.5px 2.5px #000");
                    jQuery(".player56s").player56s($);
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

    jQuery.ajax({    
        type: 'post',
        url: shuffle_ajax_url,
        data: {
            'object_id': null,
            'action': 'no_shuffle'
        },
        dataType: 'JSON',
        success: function(data){
            //print stuff heres
            jQuery("#player56s-no-shuffle").html(data);
            jQuery("#player56s-shuffle").html('0');
            jQuery(".player56s").player56s($);  
        },
        error: function(errorThrown){
            //error stuff here.text
        }
});

}

jQuery(document).ready(function($) {
    ajax_shuffle($);
});