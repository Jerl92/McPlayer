<?php

/* Enqueue Script */
add_action( 'wp_enqueue_scripts', 'wp_playlist_ajax_scripts' );

/**
 * Scripts
 */
function wp_playlist_ajax_scripts() {
	/* Plugin DIR URL */
	$url = trailingslashit( plugin_dir_url( __FILE__ ) );

	wp_enqueue_script( 'tooltip', $url . "js/tooltip.js", array( 'jquery' ), '1.0.0' );

	/* Save-unsave */
	wp_register_script( 'rs-save-for-later', $url . "js/rs-save-for-later-public.js", array( 'jquery' ), '1.0.0', true );
	wp_localize_script( 'rs-save-for-later', 'rs_save_for_later_ajax', admin_url( 'admin-ajax.php' ) );
	wp_enqueue_script( 'rs-save-for-later' );	
		
	/* AJAX Play now */
	wp_register_script( 'wp-playlist-ajax-play-now', $url . "js/ajax.playlist.play.now.js", array( 'jquery' ), '1.0.0', true );
	wp_localize_script( 'wp-playlist-ajax-play-now', 'play_now_ajax_url', admin_url( 'admin-ajax.php' ) );
	wp_enqueue_script( 'wp-playlist-ajax-play-now' );	

	/* Add album */
	wp_register_script( 'rs-save-for-later-album', $url . "js/rs-save-for-later-album-public.js", array( 'jquery' ), '1.0.0', true );
	wp_localize_script( 'rs-save-for-later-album', 'rs_save_for_later_album_ajax', admin_url( 'admin-ajax.php' ) );
	wp_enqueue_script( 'rs-save-for-later-album' );	
	
	/* AJAX add track to playlist */
	wp_register_script( 'wp-playlist-ajax-add-track-scripts', $url . "js/ajax.playlist.add.js", array( 'jquery' ), '1.0.0', true );
	wp_localize_script( 'wp-playlist-ajax-add-track-scripts', 'add_track_ajax_url', admin_url( 'admin-ajax.php' ) );
	wp_enqueue_script( 'wp-playlist-ajax-add-track-scripts' );

	/* AJAX add track to playlist */
	wp_register_script( 'wp-playlist-ajax-add-track-playlist-scripts', $url . "js/ajax.playlist.add.js", array( 'jquery' ), '1.0.0', true );
	wp_localize_script( 'wp-playlist-ajax-add-track-playlist-scripts', 'add_track_playlist_ajax_url', admin_url( 'admin-ajax.php' ) );
	wp_enqueue_script( 'wp-playlist-ajax-add-track-playlist-scripts' );

	/* Ajax remove track from playlist */
	wp_register_script( 'wp-playlist-ajax-remove-track-scripts', $url . "js/ajax.playlist.remove.js", array( 'jquery' ), '1.0.0', true );
	wp_localize_script( 'wp-playlist-ajax-remove-track-scripts', 'remove_track_ajax_url', admin_url( 'admin-ajax.php' ) );
	wp_enqueue_script( 'wp-playlist-ajax-remove-track-scripts' );

	/* Ajax remove all track from playlist */
	wp_register_script( 'wp-playlist-ajax-push-track-sidebar-scripts', $url . "js/ajax.playlist.plush.sidebar.js", array( 'jquery' ), '1.0.0', true );
	wp_localize_script( 'wp-playlist-ajax-push-track-sidebar-scripts', 'add_track_sidebar_ajax_url', admin_url( 'admin-ajax.php' ) );
	wp_enqueue_script( 'wp-playlist-ajax-push-track-sidebar-scripts' );

	/* Ajax remove all track from playlist */
	wp_register_script( 'wp-playlist-ajax-remove-track-sidebar-scripts', $url . "js/ajax.playlist.remove.sidebar.js", array( 'jquery' ), '1.0.0', true );
	wp_localize_script( 'wp-playlist-ajax-remove-track-sidebar-scripts', 'remove_track_sidebar_ajax_url', admin_url( 'admin-ajax.php' ) );
	wp_enqueue_script( 'wp-playlist-ajax-remove-track-sidebar-scripts' );

	/* AJAX add track to playlist */
	wp_register_script( 'wp-playlist-ajax-add-album-scripts', $url . "js/ajax.playlist.add.album.js", array( 'jquery' ), '1.0.0', true );
	wp_localize_script( 'wp-playlist-ajax-add-album-scripts', 'add_album_ajax_url', admin_url( 'admin-ajax.php' ) );
	wp_enqueue_script( 'wp-playlist-ajax-add-album-scripts' );

	/* AJAX add track to playlist */
	wp_register_script( 'wp-playlist-ajax-remove-album-scripts', $url . "js/ajax.playlist.remove.album.js", array( 'jquery' ), '1.0.0', true );
	wp_localize_script( 'wp-playlist-ajax-remove-album-scripts', 'remove_album_ajax_url', admin_url( 'admin-ajax.php' ) );
	wp_enqueue_script( 'wp-playlist-ajax-remove-album-scripts' );	

	/* AJAX add track to playlist and play now */
	wp_register_script( 'wp-playlist-ajax-add-play-now-scripts', $url . "js/ajax.playlist.add.play.now.js", array( 'jquery' ), '1.0.0', true );
	wp_localize_script( 'wp-playlist-ajax-add-play-now-scripts', 'add_play_now_ajax_url', admin_url( 'admin-ajax.php' ) );
	wp_enqueue_script( 'wp-playlist-ajax-add-play-now-scripts' );	

	/* AJAX playlist */
	wp_register_script( 'wp-playlist-ajax-shuffle-scripts', $url . "js/ajax.playlist.shuffle.js", array( 'jquery' ), '1.0.0', true );
	wp_localize_script( 'wp-playlist-ajax-shuffle-scripts', 'shuffle_ajax_url', admin_url( 'admin-ajax.php' ) );
	wp_enqueue_script( 'wp-playlist-ajax-shuffle-scripts' );

	/* Save AJAX playlist */
	wp_register_script( 'wp-playlist-ajax-save-playlist-scripts', $url . "js/ajax.playlist.save.js", array( 'jquery' ), '1.0.0', true );
	wp_localize_script( 'wp-playlist-ajax-save-playlist-scripts', 'save_playlist_ajax_url', admin_url( 'admin-ajax.php' ) );
	wp_enqueue_script( 'wp-playlist-ajax-save-playlist-scripts' );

	/* Load AJAX playlist */
	wp_register_script( 'wp-playlist-ajax-load-playlist-scripts', $url . "js/ajax.playlist.load.js", array( 'jquery' ), '1.0.0', true );
	wp_localize_script( 'wp-playlist-ajax-load-playlist-scripts', 'load_playlist_ajax_url', admin_url( 'admin-ajax.php' ) );
	wp_enqueue_script( 'wp-playlist-ajax-load-playlist-scripts' );

	/* Count play AJAX playlist */
	wp_register_script( 'wp-playlist-ajax-count-playlist-scripts', $url . "js/ajax.playlist.count.js", array( 'jquery' ), '1.0.0', true );
	wp_localize_script( 'wp-playlist-ajax-count-playlist-scripts', 'count_playlist_ajax_url', admin_url( 'admin-ajax.php' ) );
	wp_enqueue_script( 'wp-playlist-ajax-count-playlist-scripts' );

	/* Memory usage AJAX playlist */
	wp_register_script( 'wp-playlist-ajax-memory-usage-scripts', $url . "js/ajax.memory.usage.js", array( 'jquery' ), '1.0.0', true );
	wp_localize_script( 'wp-playlist-ajax-memory-usage-scripts', 'memory_usage_ajax_url', admin_url( 'admin-ajax.php' ) );
	wp_enqueue_script( 'wp-playlist-ajax-memory-usage-scripts' );

	/* Search AJAX playlist */
	wp_register_script( 'wp-ajax-search-get-scripts', $url . "js/ajax.search.get.js", array( 'jquery' ), '1.0.0', true );
	wp_localize_script( 'wp-ajax-search-get-scripts', 'search_get_ajax_url', admin_url( 'admin-ajax.php' ) );
	wp_enqueue_script( 'wp-ajax-search-get-scripts' );

	/* Load current added album to add saved on pâge load */
	wp_register_script( 'wp-ajax-current-album', $url . "js/ajax.current.album.js", array( 'jquery' ), '1.0.0', true );
	wp_localize_script( 'wp-ajax-current-album', 'current_album_ajax_url', admin_url( 'admin-ajax.php' ) );
	wp_enqueue_script( 'wp-ajax-current-album' );

	/*  */
	wp_register_script( 'wp-ajax-update-playlist', $url . "js/ajax.update.playlist.js", array( 'jquery' ), '1.0.0', true );
	wp_localize_script( 'wp-ajax-update-playlist', 'update_playlist_ajax_url', admin_url( 'admin-ajax.php' ) );
	wp_enqueue_script( 'wp-ajax-update-playlist' );

}

/* 3. AJAX CALLBACK
------------------------------------------ */
/* AJAX action callback */
add_action( 'wp_ajax_add_track', 'ajax_add_track' );
add_action( 'wp_ajax_nopriv_add_track', 'ajax_add_track' );

function ajax_add_track($post) {
		$posts  = array();
		
		$matche = $_POST['object_id'];
		$posts = wp_get_attachment_url( get_post_meta( $matche , 'music_link_', true) );
		$urllocal = realpath(ABSPATH.explode(site_url(), $posts )[1]);
        $plugin_dir = site_url().'/wp-content/plugins/McPlayer/includes/download.php';

		$terms = wp_get_post_terms( $matche, 'artist' );

		$name = esc_attr( 'meta-box-media-cover_' );
		$value = $rawvalue = get_post_meta( $matche, $name, true );
		$attachment_title = get_the_title($value);
		$delimeter_player56s = esc_attr(' || ');		
		
		$get_music_meta_length = get_post_meta( $matche, 'meta-box-track-length', true );

		$get_music_meta_length_str = explode(":", $get_music_meta_length);

		$get_music_meta_length_str_minute = $get_music_meta_length_str[0]*60;

		$get_music_meta_length_str_seconde = $get_music_meta_length_str[1];

		$get_music_meta_length_str__ = $get_music_meta_length_str_minute+$get_music_meta_length_str_seconde;
		
		foreach($terms as $term) {
			$html[] = '<ul><li>' . $plugin_dir.'?path='.$urllocal . '</li><li>' . $attachment_title . $delimeter_player56s . $term->name . $delimeter_player56s . get_the_title( $matche ) . $delimeter_player56s . wp_get_attachment_image_url( $value , 'full' ) . '</li><li>' . $matche . '</li><li>' . $get_music_meta_length_str__ . '</li></ul>';
		}
		return wp_send_json ( $html );	 
}	

/* 3. AJAX CALLBACK
------------------------------------------ */
/* AJAX action callback */
add_action( 'wp_ajax_add_track_album', 'ajax_add_track_album' );
add_action( 'wp_ajax_nopriv_add_track_album', 'ajax_add_track_album' );

function ajax_add_track_album($post) {
	$posts = array();

	$object_id = $_POST['object_id'];

	$get_songs_args = array( 
		'post_type' => 'music',
		'posts_per_page' => -1,
		'meta_query' => array(
			array(
				'key' => 'meta-box-media-cover_',
				'value'   => $object_id,
				'compare' => 'IN'
			)
		)
	); 

	$loop = get_posts( $get_songs_args );

	$x = 0;
	foreach($loop as $post){
		$posts[$x][0] = get_post_meta( $post->ID, "meta-box-track-number", true );
		$posts[$x][1] = $post->ID;
		$x++;
	}

	asort($posts);

	$i = 0;
	foreach($posts as $post_){
		$html[$i] = $post_[1];
		$i++;
	}

	return wp_send_json ( $html );

}	

add_action( 'wp_ajax_remove_track_album', 'ajax_remove_track_album' );
add_action( 'wp_ajax_nopriv_remove_track_album', 'ajax_remove_track_album' );

function ajax_remove_track_album($post) {
	$posts  = array();

	$object_id = $_POST['object_id'];

	$matches = get_user_meta( user_if_login(), 'rs_saved_for_later', true );

	$matches_album = get_user_meta( user_if_login(), 'rs_saved_for_later_album', true );
	
	$get_songs_args = array( 
		'post_type' => 'music',
		'posts_per_page' => -1,
		'meta_key' => 'meta-box-media-cover_',
		'meta_value' => $object_id
	); 

	$get_songs = get_posts( $get_songs_args );

	if ( in_array( $object_id, $matches_album ) ) {
		unset( $matches_album[array_search( $object_id, $matches_album )] );
	}

	foreach($get_songs as $get_song){
		if ( empty( $matches ) ) {
			$matches = array();
		}
		if ( in_array( $get_song->ID, $matches ) ) {
			unset( $matches[array_search( $get_song->ID, $matches )] );
		} 
		$html[] = $get_song->ID;
	}

	update_user_meta( user_if_login(), 'rs_saved_for_later', $matches );	
	update_user_meta( user_if_login(), 'rs_saved_for_later_album', $matches_album );			

	return wp_send_json ( $html ); 
}	

add_action( 'wp_ajax_remove_track', 'ajax_remove_track' );
add_action( 'wp_ajax_nopriv_remove_track', 'ajax_remove_track' );

function ajax_remove_track($post) {
	$posts  = array();
	$html = $_POST['object_id'];
	return wp_send_json ( $html );
}

add_action( 'wp_ajax_add_track_sidebar', 'ajax_add_track_sidebar' );
add_action( 'wp_ajax_nopriv_add_track_sidebar', 'ajax_add_track_sidebar' );

function ajax_add_track_sidebar($post) {	

	$matches = $_POST['object_id'];

	$matchesenarray = array($matches);
		
	if ( ! empty( $matches ) ) {
		$args = array( 
			'posts_per_page' => '-1',	
			'post_type' => 'music',
			'post__in' => $matchesenarray,
			'orderby'   => 'post__in'
		);
	} else {
		$args = null;
	}		

	$loop = new WP_Query( $args );

	if ( $loop->have_posts() ) : ?>

		<?php ob_start(); ?>

		<?php // do_action( "woocommerce_shortcode_before_featured_products_loop" ); ?>

		<?php // woocommerce_product_loop_start(); ?>

		<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>

			<?php echo get_template_part( 'template-parts/page-music-archive-sidebar', get_post_format() ); ?>

		<?php endwhile; // end of the loop. ?>

		<?php // woocommerce_product_loop_end(); ?>

		<?php  wp_reset_postdata(); ?>

		<?php $html[0] = ob_get_clean(); ?>

		<?php $html[1] = $matches; ?>

		<?php else : ?>

		<?php $html[0] = ''; ?>
		
		<?php $html[1] = null; ?>

		<?php endif;
	
	return wp_send_json ( $html );

}

add_action( 'wp_ajax_remove_track_sidebar', 'ajax_remove_track_sidebar' );
add_action( 'wp_ajax_nopriv_remove_track_sidebar', 'ajax_remove_track_sidebar' );

function ajax_remove_track_sidebar($post) {		
	$posts  = array();
	$html[] = $_POST['object_id'];
	return wp_send_json ( $html );
}

add_action( 'wp_ajax_nopriv_save_unsave_for_later', 'save_unsave_for_later' );
add_action( 'wp_ajax_save_unsave_for_later', 'save_unsave_for_later' );

/**
* Save/Unsave for Later
*
* @since    1.0.0
* @version  1.0.6
*/
function save_unsave_for_later() {

	$matches = get_user_meta( user_if_login(), 'rs_saved_for_later', true );

	if ( empty( $matches ) ) {
		$matches = array();
	}
	$count = count( $matches );

	$no_content = '<li style="text-align: center; padding: 15px 0;">Nothing in the playlist</li>';

	// Object ID
	$object_id = isset( $_REQUEST['object_id'] ) ? intval( $_REQUEST['object_id'] ) : 0;

	if ( empty( $matches ) ) {
		$matches = array();
	}

	if ( in_array( $object_id, $matches ) ) {
		$saved = true;
		unset( $matches[array_search( $object_id, $matches )] );
	} else {
		$saved = false;
		array_unshift( $matches, $object_id );
	}

	update_user_meta( user_if_login(), 'rs_saved_for_later', $matches );

	if ( $saved == true ) {
		$count = $count - 1;
	} else {
		$count = $count + 1;
	}

	$return = array(
		'status'  => user_if_login(),
		'update'  => $saved,
		'message' => $no_content,
		'count'   => esc_attr( $count )
	);

	return wp_send_json( $return );

}
			
add_action( 'wp_ajax_nopriv_save_and_play_now', 'save_and_play_now' );
add_action( 'wp_ajax_save_and_play_now', 'save_and_play_now' );

/**
* Save and play now/pause
*
* @since    1.0.0
* @version  1.0.6
*/
function save_and_play_now() {

	$matches = get_user_meta( user_if_login(), 'rs_saved_for_later', true );

	if ( empty( $matches ) ) {
		$matches = array();
	}
	$count = count( $matches );

	$no_content = '<li id="rs-saved-for-later-nothing" style="text-align: center; padding: 15px 0;">Nothing in the playlist</li>';

	// Object ID
	$object_id = isset( $_REQUEST['object_id'] ) ? intval( $_REQUEST['object_id'] ) : 0;

	$matches = get_user_meta( user_if_login(), 'rs_saved_for_later', true );
	if ( empty( $matches ) ) {
		$matches = array();
	}
	
	if ( ! in_array( $object_id, $matches ) ) {
		$saved = false;
		array_unshift( $matches, $object_id );
		$count = $count + 1;
		update_user_meta( user_if_login(), 'rs_saved_for_later', $matches );
	}

	$return = array(
		'status'  => user_if_login(),
		'update'  => $saved,
		'message' => $no_content,
		'count'   => esc_attr( $count )
	);

	return wp_send_json( $return );

}

add_action( 'wp_ajax_nopriv_save_unsave_for_later_album', 'save_unsave_for_later_album' );
add_action( 'wp_ajax_save_unsave_for_later_album', 'save_unsave_for_later_album' );

/**
* Save/Unsave for Later
*
* @since    1.0.0
* @version  1.0.6
*/
function save_unsave_for_later_album($post) {
	
	$object_id = $_POST['object_id'];

	$get_songs_args = array( 
		'post_type' => 'music',
		'posts_per_page' => -1,
		'meta_key' => 'meta-box-track-number',
		'orderby' => 'meta_value_num',
		'order' => 'ASC',
		'meta_query' => array(
			array(
				'key' => 'meta-box-media-cover_',
				'value'   => $object_id,
				'compare' => 'IN'
			)
		)
	); 

	$get_songs = get_posts( $get_songs_args );

	$saved_album = false;

	if ($get_songs) {

		$matches_album = get_user_meta( user_if_login(), 'rs_saved_for_later_album', true );
		if ( empty( $matches_album ) ) {
			$matches_album = array();
		}
		$count_album =  count( $matches_album );
		if ( in_array( $object_id, $matches_album ) ) {
			$saved_album = true;
			unset( $matches_album[array_search( $object_id, $matches_album )] );
		} else {
			$saved_album = false;
			array_unshift( $matches_album, $object_id );
		}
		update_user_meta( user_if_login(), 'rs_saved_for_later_album', $matches_album );

		if ( $saved_album == true ) {
			$count_album = $count_album - 1;
		} else {
			$count_album = $count_album + 1;
		}

		$x = 0;
		$matches = get_user_meta( user_if_login(), 'rs_saved_for_later', true );
		foreach ($get_songs as $get_song ) {
			if ( empty( $matches ) ) {
				$matches = array();
			}
			$count = count( $matches );
			if ( in_array( $get_song->ID, $matches ) ) {
				if($saved_album == true){
					$saved = true;
					unset( $matches[array_search( $get_song->ID, $matches )] );
					$html[$x++] = $get_song->ID;
				}
			} else {
				$saved = false;
				array_unshift( $matches, $get_song->ID );
				$html[$x++] = $get_song->ID;
			}

			update_user_meta( user_if_login(), 'rs_saved_for_later', $matches );

			if ( $saved == true ) {
				$count = $count - 1;
			} else {
				$count = $count + 1;
			}
		}

		$return = array(
			'status'  => user_if_login(),
			'update'  => $saved_album,
			'postid' => $html,
			'postid_album' => $object_id,
			'count'   => esc_attr( $count ),
			'count_album'   => esc_attr( $count_album ),
		);
		
		return wp_send_json ( $return );

	} 

}

add_action( 'wp_ajax_nopriv_current_album', 'current_album' );
add_action( 'wp_ajax_current_album', 'current_album' );

function current_album() {

	$matches_album = get_user_meta( user_if_login(), 'rs_saved_for_later_album', false );

	if ( empty( $matches_album ) ) {
		$matches_album = array();
	}

	return wp_send_json ( $matches_album );
}

add_action( 'wp_ajax_nopriv_save_for_later_remove_all', 'save_for_later_remove_all' );
add_action( 'wp_ajax_save_for_later_remove_all', 'save_for_later_remove_all' );

/**
* Remove All
*
* @since    1.0.3
* @version  1.0.6
*/
function save_for_later_remove_all() {
	delete_user_meta( user_if_login(), 'rs_saved_for_later', null);
	delete_user_meta( user_if_login(), 'rs_saved_for_later_album', null);
}
	
/* AJAX action callback */
add_action( 'wp_ajax_play_now', 'ajax_play_now' );
add_action( 'wp_ajax_nopriv_play_now', 'ajax_play_now' );

function ajax_play_now($post) {
	$posts  = array();
	$html = $_POST['object_id'];
	return wp_send_json ( $html );
}	

	
/* AJAX action callback */
add_action( 'wp_ajax_add_play_now', 'ajax_add_play_now' );
add_action( 'wp_ajax_nopriv_add_play_now', 'ajax_add_play_now' );

function ajax_add_play_now($post) {
	$posts  = array();
	$html = $_POST['object_id'];
	return wp_send_json ( $html );
}		

/* AJAX action callback */
add_action( 'wp_ajax_shuffle_playlist', 'shuffle_playlist' );
add_action( 'wp_ajax_nopriv_shuffle_playlist', 'shuffle_playlist' );

function shuffle_playlist($post) {
	$posts  = array();
	$shuffle = get_user_meta( user_if_login(), 'user_playlist_shuffle', true );
	if ( $shuffle == "1" ) {
		update_user_meta( user_if_login(), 'user_playlist_shuffle', 0 );
		$html = 0;
	} elseif ( $shuffle == "0" ) {
		update_user_meta( user_if_login(), 'user_playlist_shuffle', 1 );
		$html = 1;
	} elseif ( $shuffle == null ) {
		add_user_meta( user_if_login(), 'user_playlist_shuffle', 1, true );
		$html = 1;
	}
	return wp_send_json ($html);
}

/* AJAX action callback */
add_action( 'wp_ajax_no_shuffle', 'no_shuffle' );
add_action( 'wp_ajax_nopriv_no_shuffle', 'no_shuffle' );

function no_shuffle($post) {
	$posts  = array();

	$matches = get_user_meta( user_if_login(), 'rs_saved_for_later', true );
	
	if ( ! empty( $matches ) ) {
		$saved_args = array(
			'post_type'      => 'music',
			'posts_per_page' => -1,
			'orderby' => 'post__in',
			'post__in'       => array_reverse( $matches, true )
		);
	} else {
		$saved_args = null;
	}

	$saved_loop = get_posts( $saved_args );

	if ($saved_loop) {
		$html[] = '<ul>';
		foreach ($saved_loop as $post) {
			$html[] .= '<li>' . $post->ID . '</li>';
		}
		$html[] .= '</ul>';
	} else {
		$html = 0;
	}

	$arr = implode("", $html);

	return wp_send_json ($arr);
}

/* AJAX action callback */
add_action( 'wp_ajax_if_shuffle', 'if_shuffle' );
add_action( 'wp_ajax_nopriv_if_shuffle', 'if_shuffle' );

function if_shuffle($post) {
	$posts  = array();
	$shuffle = get_user_meta( user_if_login(), 'user_playlist_shuffle', true );
	if ( $shuffle == "1" ) {
		$html = 1;
	} elseif ( $shuffle == "0" ) {
		$html = 0;
	} elseif ( $shuffle == null ) {
		$html = 0;
	}
	return wp_send_json ($html);
}

/* AJAX action callback */
add_action( 'wp_ajax_new_order', 'ajax_new_order' );
add_action( 'wp_ajax_nopriv_new_order', 'ajax_new_order' );

function ajax_new_order($post) {
	$posts  = array();
	$i = 0;
	$posts = $_POST['object_id'];
	foreach ($posts as $post) {
		$postid[$i] = $post['postid'];
		$i++;
	}
	update_user_meta( user_if_login(), 'rs_saved_for_later', $postid );
	return wp_send_json ( $postid );
}	

/* AJAX action callback */
add_action( 'wp_ajax_save_playlist', 'save_playlist' );
add_action( 'wp_ajax_nopriv_save_playlist', 'save_playlist' );

function save_playlist($post) {
	$input = $_POST['inputVal'];

	$new_post = array(
		'post_title' => $input,
		'post_content' => '',
		'post_status' => 'publish',
		'post_author' => user_if_login(),
		'post_type' => 'playlist'
	);
	$post_id = wp_insert_post($new_post);
	$playlist = get_user_meta( user_if_login(), 'rs_saved_for_later', true);
	$playlist_album = get_user_meta( user_if_login(), 'rs_saved_for_later_album', true);
	add_post_meta($post_id, 'rs_saved_for_later', $playlist);
	add_post_meta($post_id, 'rs_saved_for_later_album', $playlist_album);

	$return = array(
		'playlist'   => $playlist,
		'playlist_album'   => $playlist_album
	);

	return wp_send_json ( $return );
}

/* AJAX action callback */
add_action( 'wp_ajax_load_playlist', 'load_playlist' );
add_action( 'wp_ajax_nopriv_load_playlist', 'load_playlist' );

function load_playlist($post) {

	$object_id = $_POST['object_id'];

	$matches = get_post_meta($object_id, 'rs_saved_for_later', true);

	$matches_albums = get_post_meta($object_id, 'rs_saved_for_later_album', true);

	if ( empty( $matches_albums ) ) {
		$matches_albums = array();
	}
	update_user_meta( user_if_login(), 'rs_saved_for_later_album', $matches_albums );

	$return = array(
		'playlist'   => $matches,
		'playlist_album'   => $matches_albums
	);

	return wp_send_json ( $return );
}

/* AJAX action callback */
add_action( 'wp_ajax_add_track_playlist', 'add_track_playlist' );
add_action( 'wp_ajax_nopriv_add_track_playlist', 'add_track_playlist' );

function add_track_playlist($post) {

	$object_id = $_POST['object_id'];

	$matches = get_user_meta( user_if_login(), 'rs_saved_for_later', true);


	if ( empty( $matches ) ) {
		$matches = array();
	}

	array_unshift($matches, $object_id);

	update_user_meta( user_if_login(), 'rs_saved_for_later', $matches );

	return wp_send_json ( $matches );
}

/* AJAX action callback */
add_action( 'wp_ajax_load_saved_playlist', 'load_saved_playlist' );
add_action( 'wp_ajax_nopriv_load_saved_playlist', 'load_saved_playlist' );

function load_saved_playlist($post) {
	$object_id = $_POST['object_id'];

	$args = array(
		'post_type'      => 'playlist',
		'posts_per_page' => -1
	);

	$posts = get_posts($args);

	foreach ($posts as $post) {
		$matches = get_post_meta($post->ID, 'rs_saved_for_later', true);
		foreach($matches as $matche){
			$the_post = get_post( implode($matche) );
			if(!isset($post)){
				$key = array_search($matche, $matches);
				if (false !== $key) {
					unset($matches[$key]);
				}
			}
		}
		update_post_meta($post->ID, 'rs_saved_for_later', $matches);
		$matches_count = count($matches);
		$html[] .= "<div class='playlist-load-loop' data-id='".$post->ID."'>".get_the_title($post->ID)."<span style='text-align: right;right: 30px !important;float: right;'>".$matches_count."</span></div>";
	}

	return wp_send_json ( $html );
}

/* AJAX action callback */
add_action( 'wp_ajax_count_play', 'count_play' );
add_action( 'wp_ajax_nopriv_count_play', 'count_play' );

function count_play($post) {
	$i = 0;
	$object_id = $_POST['object_id'];
	$get_count_play = get_post_meta($object_id, 'count_play_loop', true);
	$get_saved_played = get_user_meta( user_if_login(), 'rs_saved_played', true );

	$date = date('m/d/Y h:i:s a', time());
	$strtodate = strtotime($date);

	if($get_saved_played != null){
		$get_saved_played_array[$i] = array($strtodate, $object_id);
		$i++;
		foreach($get_saved_played as $get_saved_played_){
			$get_saved_played_array[$i] = $get_saved_played_;
			$i++;
		}
	} else {
		$get_saved_played_array[$i] = array($strtodate, $object_id);
	}

	update_user_meta( user_if_login(), 'rs_saved_played', $get_saved_played_array );

	if($get_count_play) {
		$countplay = intval($get_count_play) + 1;
		update_post_meta($object_id, 'count_play_loop', $countplay);
	} else {
		$countplay = '1';
		add_post_meta($object_id, 'count_play_loop', 1);
	}

	return wp_send_json ($countplay);
}

// @see http://fr2.php.net/manual/en/function.mb-convert-encoding.php#103300
/* AJAX action callback */
add_action( 'wp_ajax_memory_usage', 'memory_usage_ajax' );
add_action( 'wp_ajax_nopriv_memory_usage', 'memory_usage_ajax' );

function memory_usage_ajax() {
	$mem_usage = memory_get_usage(false);
	if ($mem_usage < 1024) {
		$mem_usage .= ' B';
	} elseif ($mem_usage < 1048576) {
		$mem_usage = round($mem_usage/1024,2) . ' KB';
	} else {
		$mem_usage = round($mem_usage/1048576,2) . ' MB';
	}
	return wp_send_json ( $mem_usage );
}

add_action( 'wp_ajax_search_ajax_get', 'search_ajax_get' );
add_action( 'wp_ajax_nopriv_search_ajax_get', 'search_ajax_get' );

function search_ajax_get() {

	$inputVal = $_POST['inputVal'];

	$args = array(
		'taxonomy'      => array( 'artist' ), // taxonomy name
		'orderby'       => 'id', 
		'order'         => 'ASC',
		'hide_empty'    => true,
		'fields'        => 'all',
		'name__like'    => $inputVal
	); 
	
	$terms = get_terms( $args );

	$html[] = "<div id='widget-mcplayer-search-wrapper'>";
	
	$count = count($terms);
	if($count > 0){
		$html[] .= "Artists";
		$html[] .= "<ul>";
		foreach ($terms as $term) {
			$html[] .= "<li><a id='mcplayer-search-get' href='".get_term_link( $term )."'>".$term->name."</a></li>";
	
		}
		$html[] .= "</ul>";
	}

	$args = array(
		'posts_per_page' => -1,
		'post_type'      => 'attachment',
		'post_mime_type' => 'image',
		's'           => $inputVal
	);

	$get_attachments = get_posts( $args );

	$count_attachments = count($get_attachments);
	if($count_attachments > 0){
		$html[] .= "Albums";
		$html[] .= "<ul>";
		foreach ($get_attachments as $get_attachment) {
			$getslugid = wp_get_post_terms( $get_attachment->ID, 'artist' );
			foreach( $getslugid as $thisslug ) {
				if($thisslug->name != null){
					$html[] .= "<div style='display: inline-flex; margin-bottom:15px; width: 100%;'>";
					$get_attachment_url = wp_get_attachment_url( $get_attachment->ID );
						$html[] .= "<div id='mcplayer-search-img'style=''>";
							$html[] .= "<img src='$get_attachment_url' style='width: 30px; margin:0px 2.5px;'></img>";
						$html[] .= "</div>";
						$html[] .= "<div id='mcplayer-search-get'style='width: 87.5%;'>";
							$html[] .= "<a href='".get_term_link( $thisslug ).'?album='.$get_attachment->ID."'>".$get_attachment->post_title.' - '. $thisslug->name ."</a>";
						$html[] .= "</div>";
						$html[] .= "<div>";
							$html[] .= do_shortcode( '[simplicity-save-for-later-loop-album album_id="' . $get_attachment->ID . '"]' );
						$html[] .= "</div>";
					$html[] .= "</div>";					
				}
			}
		}
		$html[] .= "</ul>";
	}

	$argc = array(
		'post_type' => 'music',
		'post_status' => 'publish',
		'posts_per_page' => -1,
		's'    			 => $inputVal
	);
	
	$posts = get_posts( $argc );
	$count_posts = count($posts);
	if($count_posts > 0){
		$html[] .= "Tracks";
		$html[] .= "<ul>";
		foreach ($posts as $post) {
			if (strpos(get_permalink($post->ID), "/music/") !== false) {
				$getslugid = wp_get_post_terms( $post->ID, 'artist' );
				foreach( $getslugid as $thisslug ) {
					if($thisslug->name != null){
						$html[] .= "<div style='display: flex; margin-bottom:15px; width: 100%;'>";
							$html[] .= "<div id='mcplayer-search-get' style='width: 85%;'>";
								$html[] .= "<a href='".get_permalink($post->ID)."'>".$post->post_title.' - '. $thisslug->name ."</a>";
							$html[] .= "</div>";
							$html[] .= "<div>";
								$html[] .= do_shortcode( '[add-play-now id="' . $post->ID . '"]' );
							$html[] .= "</div>";
							$html[] .= "<div style='padding-left: 42.5px;'>";
								$html[] .= do_shortcode( '[simplicity-save-for-later-loop id="' . $post->ID . '"]' );
							$html[] .= "</div>";
						$html[] .= '</div>';
					}
				}
			}
		}
		$html[] .= "</ul>";
	}

	if($count == 0 && $count_attachments == 0 && $count_posts == 0) {
		$html[] .= "<ul>";
			$html[] .= "<li>No music founds...</li>";
		$html[] .= "</ul>";
	}

	$html[] .= "</div>";

	return wp_send_json ( implode($html) );
}

add_action( 'wp_ajax_update_playlist', 'update_playlist' );
add_action( 'wp_ajax_nopriv_update_playlist', 'update_playlist' );

function update_playlist() {

	$matches = get_user_meta( user_if_login(), 'rs_saved_for_later', true );

	foreach($matches as $matche){
		$html[] .= $matche;
	}

	return wp_send_json ( $html );

}

?>
