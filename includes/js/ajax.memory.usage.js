function memory_ajax($)  {

        $.ajax({    
            type: 'post',
            url: memory_usage_ajax_url,
            data: {
                'action': 'memory_usage'
            },
            dataType: 'JSON',
            success: function(data){
                $('.memory-usage').html(null);
                $('.memory-usage').html(data);
            },
            error: function(errorThrown){
                //error stuff here.text
            }
        });
}