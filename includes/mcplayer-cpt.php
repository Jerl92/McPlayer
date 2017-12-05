<?php

// Add Music Support
add_theme_support( 'music' );

/////////////////////////////
//
//	MCPlayer costom post type (music) and taxonomy for Artists and Genres.
//	Use Image for albums (attachement ID).
//
/////////////////////////////

if ( ! function_exists('music_file') ) {

	// Register Custom Post Type
	function music_file() {

		//one song = one post, media is other thing.
		$labels = array(
			'name'                  => _x( 'Musics', 'Post Type General Name', 'mcplayer' ),
			'singular_name'         => _x( 'Music', 'Post Type Singular Name', 'mcplayer' ),
			'menu_name'             => __( 'Musics', 'mcplayer' ),
			'name_admin_bar'        => __( 'Music', 'mcplayer' ),
			'archives'              => __( 'Music Archives', 'mcplayer' ),
			'attributes'            => __( 'Music Attributes', 'mcplayer' ),
			'parent_item_colon'     => __( 'Parent Item:', 'mcplayer' ),
			'all_items'             => __( 'All Musics', 'mcplayer' ),
			'add_new_item'          => __( 'Add New Music', 'mcplayer' ),
			'add_new'               => __( 'Add Music', 'mcplayer' ),
			'new_item'              => __( 'New Music', 'mcplayer' ),
			'edit_item'             => __( 'Edit Music', 'mcplayer' ),
			'update_item'           => __( 'Update Music', 'mcplayer' ),
			'view_item'             => __( 'View Music', 'mcplayer' ),
			'view_items'            => __( 'View Musics', 'mcplayer' ),
			'search_items'          => __( 'Search Music', 'mcplayer' ),
			'not_found'             => __( 'Not found', 'mcplayer' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'mcplayer' ),
			'featured_image'        => __( 'Featured Image', 'mcplayer' ),
			'set_featured_image'    => __( 'Set featured image', 'mcplayer' ),
			'remove_featured_image' => __( 'Remove featured image', 'mcplayer' ),
			'use_featured_image'    => __( 'Use as featured image', 'mcplayer' ),
			'insert_into_item'      => __( 'Insert into Music', 'mcplayer' ),
			'uploaded_to_this_item' => __( 'Uploaded to this Music', 'mcplayer' ),
			'items_list'            => __( 'Musics list', 'mcplayer' ),
			'items_list_navigation' => __( 'Musics list navigation', 'mcplayer' ),
			'filter_items_list'     => __( 'Filter Musics list', 'mcplayer' ),
		);
		$args = array(
			'label'                 => __( 'Music', 'mcplayer' ),
			'description'           => __( 'music', 'mcplayer' ),
			'labels'                => $labels,
			'supports'              => array( 'title', 'page-attributes',' attachment',),
			'taxonomies'             => array( 'artist', 'genre', 'attachment', ),
			'hierarchical'          => true,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 5,
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => true,		
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'capability_type'       => 'page'
		);

		register_post_type( 'music', $args );

		$labels = array(
			'name'				    => __( 'Artists' ),
			'singular_name'			=> __( 'Artist' ),
			'search_items'			=> __( 'Search Artists' ),
			'popular_items'			=> __( 'Popular Artists' ),
			'all_items'			    => __( 'All Artists' ),
			'parent_item'			=> __( 'Parent Artist' ),
			'parent_item_colon'		=> __( 'Parent Artist'  ),
			'edit_item'			    => __( 'Edit Artist' ),
			'update_item'			=> __( 'Update Artist'),
			'add_new_item'			=> __( 'Add New Artist'),
			'new_item_name'			=> __( 'New Artist'),
			'add_or_remove_items'	=> __( 'Add or remove Artists'),
			'choose_from_most_used'	=> __( 'Choose from most used Artists'),
			'menu_name'			    => __( 'Artists'),
		);

		register_taxonomy(
			'artist',
			'music',
			array(
				'labels'            => $labels,
				'public'            => true,
				'taxonomies'        => array( 'album' ),
				'show_in_nav_menus'	=> true,
				'hierarchical'		=> true,
				'query_var'		    => true,
				'rewrite'		    => true,
				'show_admin_column' => true ,
				'exclude_from_search'  => false,
			)
		);

		register_taxonomy_for_object_type('artist', 'attachment');
		add_post_type_support('attachment', 'artist');
		
		$labels = array(
			'name'				    => __( 'Genres' ),
			'singular_name'			=> __( 'Genre' ),
			'search_items'			=> __( 'Search Genres' ),
			'popular_items'			=> __( 'Popular Genres' ),
			'all_items'			    => __( 'All Genres' ),
			'parent_item'			=> __( 'Parent Genre' ),
			'parent_item_colon'		=> __( 'Parent Genre'  ),
			'edit_item'			    => __( 'Edit Genre' ),
			'update_item'			=> __( 'Update Genre'),
			'add_new_item'			=> __( 'Add New Genre'),
			'new_item_name'			=> __( 'New Genre'),
			'add_or_remove_items'	=> __( 'Add or remove Genres'),
			'choose_from_most_used'	=> __( 'Choose from most used Genres'),
			'menu_name'			    => __( 'Genres'),
		);

		register_taxonomy(
			'genre',
			'music',
			array(
				'labels'            => $labels,
				'public'            => true,
				'taxonomies'        => array( 'genre' ),
				'show_in_nav_menus'	=> true,
				'hierarchical'		=> true,
				'show_ui'		    => true,
				'query_var'		    => true,
				'rewrite'		    => true,
				'show_admin_column' => true,
				'exclude_from_search'   => false,
				'show_admin_column' => true,
			)
		);

	}
	add_action( 'init', 'music_file', 0 );

}

/////////////////////////////
//
//	CPT Playlist. Save lots of playlist.
//	WIP
//
/////////////////////////////

if ( ! function_exists('playlist_file') ) {

	/**
	* Set up Custom Post Type "playlists."
	* Nothing significant here.
	*/
	add_action( 'init', 'create_post_type' );
	function create_post_type() {
		$labels = array(
			'name'               => _x( 'playlists', 'Plural Name' ),
			'singular_name'      => _x( 'playlist', 'Singular Name' ),
			'add_new'            => _x( 'Add New', 'playlist' ),
			'add_new_item'       => __( 'Add New playlist' ),
			'edit_item'          => __( 'Edit playlist' ),
			'new_item'           => __( 'New playlist' ),
			'all_items'          => __( 'All playlists' ),
			'view_item'          => __( 'View playlist' ),
			'search_items'       => __( 'Search playlists' ),
			'not_found'          => __( 'No playlists found' ),
			'not_found_in_trash' => __( 'No playlists found in the Trash' ),
			'parent_item_colon'  => '',
			'menu_name'          => 'playlists',
		);
		$args = array(
			'labels'      => $labels,
			'public'      => true,
			'has_archive' 			=> true,
			'hierarchical'          => true,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'supports'              => array( 'title', 'page-attributes', 'editor' ),
		);
		register_post_type( 'playlist', $args );
	}


	/////////////////////////////
	//
	//	Create the Submenu items containing redirects to the Custom Post Type Pages
	//	This is where the magic happens.
	//
	/////////////////////////////

	add_action( 'admin_menu', 'playlist_add_submenu_pages' );
	function playlist_add_submenu_pages() {
		add_submenu_page( 'edit.php?post_type=music', __( 'All playlists', 'playlists' ), __( 'All playlists', 'playlists' ), 'manage_options', 'playlist_plugin_show_posts', 'playlist_render_nerferhders' );
		add_submenu_page( 'edit.php?post_type=music', __( 'Add New playlist', 'playlists' ), __( 'Add New playlist', 'playlists' ), 'manage_options', 'playlist_plugin_add_post', 'playlist_render_new_nerferhders' );
	}

	function playlist_render_nerferhders(){
		$url = admin_url().'edit.php?post_type=playlist';
		?>
		<script>location.href='<?php echo $url;?>';</script>
		<?php
	}

	function playlist_render_new_nerferhders(){
		$url = admin_url().'post-new.php?post_type=playlist';
		?>
		<script>location.href='<?php echo $url;?>';</script>
		<?php
	}

	/**
	* Hide default Custom Post Type Menu Item from Admin Menu
	*/
	add_action( 'admin_menu', 'playlist_remove_cpt_menu_items' );
	function playlist_remove_cpt_menu_items() {
		remove_menu_page( 'edit.php?post_type=playlist' );
	}
	
	/**
	* Add/Remove appropriate CSS classes to Menu so Submenu displays open and the Menu link is styled appropriately.
	*/
	function playlist_correct_current_menu(){
		$screen = get_current_screen();
		if ( $screen->id == 'playlist' || $screen->id == 'edit-playlist' ) {
		?>
		<script type="text/javascript">
		jQuery(document).ready(function($) {
			$('#toplevel_page_playlist-plugin').addClass('wp-has-current-submenu wp-menu-open menu-top menu-top-first').removeClass('wp-not-current-submenu');
			$('#toplevel_page_playlist-plugin > a').addClass('wp-has-current-submenu').removeClass('wp-not-current-submenu');
		});
		</script>
		<?php
		}
		if ( $screen->id == 'playlist' ) {
		?>
		<script type="text/javascript">
		jQuery(document).ready(function($) {
			$('a[href$="playlist_plugin_add_post"]').parent().addClass('current');
			$('a[href$="playlist_plugin_add_post"]').addClass('current');
		});
		</script>
		<?php
		}
		if ( $screen->id == 'edit-playlist' ) {
		?>
		<script type="text/javascript">
		jQuery(document).ready(function($) {
			$('a[href$="playlist_plugin_show_posts"]').parent().addClass('current');
			$('a[href$="playlist_plugin_show_posts"]').addClass('current');
		});
		</script>
		<?php
		}
	}
	add_action('admin_head', 'playlist_correct_current_menu', 50);

}

?>