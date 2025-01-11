function memory_ajax($)  {

        jQuery.ajax({    
            type: 'post',
            url: memory_usage_ajax_url,
            data: {
                'action': 'memory_usage'
            },
            dataType: 'JSON',
            success: function(data){
                jQuery('.memory-usage').html(null);
                jQuery('.memory-usage').html(data);
            },
            error: function(errorThrown){
                //error stuff here.text
            }
        });
}