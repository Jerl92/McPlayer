( function( $ ) {

	function addBlacklistClass() { 
		$( "a" ).each( function() {
			if ( this.href.indexOf("/wp-admin/") !== -1 || 
				 this.href.indexOf("/wp-login.php") !== -1 ) {
				$( this ).addClass( "no-smoothState" );
			}
        });
	}

	$( function() {

		addBlacklistClass();

		var settings = { 
			anchors: "a",
			blacklist: ".no-smoothState",
			cache: true,
			prefetchOn: $.fn.aim,
			locationHeader: "X-SmoothState-Location",
			scroll: true,
			onAfter: function( $container , $newcontainer ) {
																
				stickIt_($);	
				
				mysticky($);

				tooltip($);	
				
				scroll_to_album($);
				
				play_now($);
                    
				rs_save_for_later($);
				
				rs_save_for_later_album($); 

				ajax_playlist_add_sidebar($);

				sortable_playlist($);
				
			}
		};

		if (!$("body").hasClass("elementor-editor-active")) {
			console.log(	$( "#page" ).smoothState( settings ).data("smoothState") );
		}

	});

})(jQuery);	