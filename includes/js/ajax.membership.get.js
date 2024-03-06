function ajax_membership_get($)  {
    var result = null;
    $.ajax({    
        type: 'post',
        url: membership_ajax_url,
        data: {
            'action': 'get_membership'
        },
        dataType: 'JSON',
        success: function(data){
            result = data; 
        },
        error: function(errorThrown){
            console.log(errorThrown);
        }
}); 
return result;
}