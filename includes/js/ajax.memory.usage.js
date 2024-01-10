var memory_usage = setInterval(function(){
    $.ajax({    
        type: 'post',
        url: memory_usage_ajax_url,
        data: {
            'object_id': '',
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
},2500);