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
			cache: false,
			prefetch: true,
			prefetchOn: "aim",
			scroll: true,
			locationHeader: "X-SmoothState-Location",
			onAfter: function( $container , $newcontainer ) {

				stickIt_($);

				stickysidebar($);

				ajax_playlist_add_sidebar($);
								
				play_now($);

				play_pause($);

//				tooltip($);	
				
				scroll_to_album($);
				
				footer_stick($);
                    
				rs_save_for_later($);
				
				rs_save_for_later_album($); 

				sortable_playlist($);
				
			}
		};

		if (!$("body").hasClass("elementor-editor-active")) {
			console.log(	$( "#page" ).smoothState( settings ).data("smoothState") );
		}

	});

})(jQuery);	