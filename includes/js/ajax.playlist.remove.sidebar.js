function ajax_playlist_remove_sidebar($, object_id)  {
    
    $.fn.ready();
	'use strict';

    $("#rs-item-" + object_id).remove();            

}        

