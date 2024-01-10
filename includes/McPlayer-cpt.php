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
			'name'                  => _x( 'Musics', 'Post Type General Name', 'McPlayer' ),
			'singular_name'         => _x( 'Music', 'Post Type Singular Name', 'McPlayer' ),
			'menu_name'             => __( 'Musics', 'McPlayer' ),
			'name_admin_bar'        => __( 'Music', 'McPlayer' ),
			'archives'              => __( 'Music Archives', 'McPlayer' ),
			'attributes'            => __( 'Music Attributes', 'McPlayer' ),
			'parent_item_colon'     => __( 'Parent Item:', 'McPlayer' ),
			'all_items'             => __( 'All Musics', 'McPlayer' ),
			'add_new_item'          => __( 'Add New Music', 'McPlayer' ),
			'add_new'               => __( 'Add Music', 'McPlayer' ),
			'new_item'              => __( 'New Music', 'McPlayer' ),
			'edit_item'             => __( 'Edit Music', 'McPlayer' ),
			'update_item'           => __( 'Update Music', 'McPlayer' ),
			'view_item'             => __( 'View Music', 'McPlayer' ),
			'view_items'            => __( 'View Musics', 'McPlayer' ),
			'search_items'          => __( 'Search Music', 'McPlayer' ),
			'not_found'             => __( 'Not found', 'McPlayer' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'McPlayer' ),
			'featured_image'        => __( 'Featured Image', 'McPlayer' ),
			'set_featured_image'    => __( 'Set featured image', 'McPlayer' ),
			'remove_featured_image' => __( 'Remove featured image', 'McPlayer' ),
			'use_featured_image'    => __( 'Use as featured image', 'McPlayer' ),
			'insert_into_item'      => __( 'Insert into Music', 'McPlayer' ),
			'uploaded_to_this_item' => __( 'Uploaded to this Music', 'McPlayer' ),
			'items_list'            => __( 'Musics list', 'McPlayer' ),
			'items_list_navigation' => __( 'Musics list navigation', 'McPlayer' ),
			'filter_items_list'     => __( 'Filter Musics list', 'McPlayer' ),
		);
		$args = array(
			'label'                 => __( 'Music', 'McPlayer' ),
			'description'           => __( 'music', 'McPlayer' ),
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

// A callback function to add a custom field to our "presenters" taxonomy  
function presenters_taxonomy_custom_fields($tag) { 
    // Check for existing taxonomy meta for the term you're editing  
     $t_id = $tag->term_id; // Get the ID of the term you're editing
     $get_term_color = get_term_meta($t_id, 'meta_count_earn', true);
 ?>  
   
 <tr class="form-field">  
     <th scope="row" valign="top">  
         <label for="presenter_id"><?php _e('Earn for eatch play'); ?></label>  
     </th>  
     <td>  
        <?php echo '<input type="number" step=".01" name="meta_color" id="meta_color" value="'. $get_term_color .'" class="my-color-field" style="width: 75px;"></input>' ?>
     </td>  
 </tr>
   
 <?php  
 }  

 // A callback function to save our extra taxonomy field(s)  
 function save_taxonomy_custom_meta( $term_id ) {
    if ( isset($_POST['meta_color']) ) {
        update_term_meta( $term_id, 'meta_count_earn', $_POST['meta_color'] );
    }
} 

// Add the fields to the "presenters" taxonomy, using our callback function  
add_action( 'artist_edit_form_fields', 'presenters_taxonomy_custom_fields', 10, 2 );  
add_action( 'artist_add_form_fields', 'presenters_taxonomy_custom_fields', 10, 2 ); 

// Save the changes made on the "presenters" taxonomy, using our callback function  
add_action( 'edited_artist', 'save_taxonomy_custom_meta', 10, 2 ); 
add_action( 'create_artist', 'save_taxonomy_custom_meta', 10, 2 ); 

?>