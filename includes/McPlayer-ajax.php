<?php

/* Enqueue Script */
add_action( 'wp_enqueue_scripts', 'wp_playlist_ajax_scripts' );

/**
 * Scripts
 */
function wp_playlist_ajax_scripts() {
	/* Plugin DIR URL */
	$url = trailingslashit( plugin_dir_url( __FILE__ ) );
	//
	if ( is_user_logged_in() ) {
		/* JS + Localize */
		$save = __( 'Add to Playlist', 'rs-save-for-later' );
		$unsave = __( 'Remove', 'rs-save-for-later' );
		$saved = __( 'See Playlist', 'rs-save-for-later' );
		$number = __( 'Playlist: ', 'rs-save-for-later' );
		$onpause = __( 'Pause', 'rs-save-for-later' );

		/* AJAX Play now */
		wp_enqueue_script( 'tooltip', $url . "js/tooltip.js", array( 'jquery' ), '1.0.0' );

		wp_enqueue_script( 'rs-save-for-later', plugin_dir_url( __FILE__ ) . 'js/rs-save-for-later-public.js', array( 'jquery' ), '1.0.0', false );
		wp_localize_script(
			'rs-save-for-later',
			'rs_save_for_later_ajax',
			array(
				'ajax_url'          => admin_url( 'admin-ajax.php', 'relative' ),
				'save_txt'          => $save,
				'unsave_txt'        => $unsave,
				'saved_txt'         => $saved,
				'number_txt'        => $number
			)
		);
			
		/* AJAX Play now */
		wp_register_script( 'wp-playlist-ajax-play-now', $url . "js/ajax.playlist.play.now.js", array( 'jquery' ), '1.0.0', true );
		wp_localize_script( 'wp-playlist-ajax-play-now', 'play_now_ajax_url', 			array(
			'ajax_url'          => admin_url( 'admin-ajax.php', 'relative' ),
			'save_txt'          => $save,
			'unsave_txt'        => $onpause,
			'saved_txt'         => $saved,
			'number_txt'        => $number
		) );
		wp_enqueue_script( 'wp-playlist-ajax-play-now' );
		/* AJAX add track to playlist */
		wp_register_script( 'wp-playlist-ajax-add-track-scripts', $url . "js/ajax.playlist.add.js", array( 'jquery' ), '1.0.0', true );
		wp_localize_script( 'wp-playlist-ajax-add-track-scripts', 'add_track_ajax_url', admin_url( 'admin-ajax.php' ) );
		wp_enqueue_script( 'wp-playlist-ajax-add-track-scripts' );
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

		/* album */
		/* Ajax remove all track from playlist */
		wp_register_script( 'rs-save-for-later-album', $url . "js/rs-save-for-later-album-public.js", array( 'jquery' ), '1.0.0', true );
		wp_localize_script( 'rs-save-for-later-album', 'rs_save_for_later_album_ajax', admin_url( 'admin-ajax.php' ) );
		wp_enqueue_script( 'rs-save-for-later-album' );	
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
		
	}

}

/* 3. AJAX CALLBACK
------------------------------------------ */
/* AJAX action callback */
add_action( 'wp_ajax_add_track', 'ajax_add_track' );
add_action( 'wp_ajax_nopriv_add_track', 'ajax_add_track' );

function ajax_add_track($post) {
	  // $posts = get_posts('numberposts='.$count.'&post_status=publish');
	 
	// Saved objects
		$posts  = array();
		if ( is_user_logged_in() ) {
		
			$matche = $_POST['object_id'];
			$posts = wp_get_attachment_url( get_post_meta( $matche , 'music_link_', true) );

			$terms = wp_get_post_terms( $matche, 'artist' );

			$name = esc_attr( 'meta-box-media-cover_' );
			$value = $rawvalue = get_post_meta( $matche, $name, true );
			$attachment_title = get_the_title($value);
			$delimeter_player56s = esc_attr(' | ');		
			
			$get_music_meta_length = get_post_meta( $matche, "meta-box-track-length", true );
			
			foreach($terms as $term) {
				$html[] = '<ul><li>' . $posts . '</li><li>' . $attachment_title . $delimeter_player56s . $term->name . $delimeter_player56s . get_the_title( $matche ) . $delimeter_player56s . wp_get_attachment_image_url( $value , 'thumbnail' ) . '</li><li>' . $matche . '</li><li>' . $get_music_meta_length . '</li></ul>';
			}
			return wp_send_json ( $html );	 
		} 
}	

/* 3. AJAX CALLBACK
------------------------------------------ */
/* AJAX action callback */
add_action( 'wp_ajax_add_track_album', 'ajax_add_track_album' );
add_action( 'wp_ajax_nopriv_add_track_album', 'ajax_add_track_album' );

function ajax_add_track_album($post) {
		$posts  = array();

		if ( is_user_logged_in() ) {

			$object_id = $_POST['object_id'];

			// $matches = get_user_meta( get_current_user_id(), 'rs_saved_for_later', true );			

			$get_songs_args = array( 
				'post_type' => 'music',
				'posts_per_page' => -1,
				'meta_key' => 'meta-box-track-number',
				'orderby' => 'meta_value_num',
				'order' => 'ASC',
				'meta_query' => array(
					array(
						'key' => 'meta-box-media-cover_',
						'value'   => ($object_id),
						'compare' => 'IN'
					)
				)
			); 

			$get_songs = get_posts( $get_songs_args );

			foreach($get_songs as $get_song) {
				$html[] = $get_song->ID;
			}

			return wp_send_json ( $html ); 
			
		} 
	 
}	

add_action( 'wp_ajax_remove_track_album', 'ajax_remove_track_album' );
add_action( 'wp_ajax_nopriv_remove_track_album', 'ajax_remove_track_album' );

function ajax_remove_track_album($post) {
		$posts  = array();

		if ( is_user_logged_in() ) {

			$object_id = $_POST['object_id'];

		 	$matches = get_user_meta( get_current_user_id(), 'rs_saved_for_later', true );

			$matches_album = get_user_meta( get_current_user_id(), 'rs_saved_for_later_album', true );
			

			$get_songs_args = array( 
				'post_type' => 'music',
				'posts_per_page' => -1,
				'post__in' => $matches,
				'meta_key' => 'meta-box-media-cover_',
				'meta_value' => $object_id
			); 

			$get_songs = get_posts( $get_songs_args );

			if ( in_array( $object_id, $matches_album ) ) {
				unset( $matches_album[array_search( $object_id, $matches_album )] );
			}

			foreach($get_songs as $get_song) {
				if ( empty( $matches ) ) {
					$matches = array();
				}
				// array_reverse($matches);
				if ( in_array( $get_song->ID, $matches ) ) {
					unset( $matches[array_search( $get_song->ID, $matches )] );
				} 
				$html[] = $get_song->ID;

			}

			update_user_meta( get_current_user_id(), 'rs_saved_for_later', $matches );	
			update_user_meta( get_current_user_id(), 'rs_saved_for_later_album', $matches_album );			

			return wp_send_json ( $html ); 
			
		} 
	 
}	

add_action( 'wp_ajax_remove_track', 'ajax_remove_track' );
add_action( 'wp_ajax_nopriv_remove_track', 'ajax_remove_track' );

function ajax_remove_track($post) {
	$posts  = array();
	if ( is_user_logged_in() ) {
		$html = $_POST['object_id'];
		return wp_send_json ( $html );
	} 	
}

add_action( 'wp_ajax_add_track_sidebar', 'ajax_add_track_sidebar' );
add_action( 'wp_ajax_nopriv_add_track_sidebar', 'ajax_add_track_sidebar' );

function ajax_add_track_sidebar($post) {		

	if ( is_user_logged_in() ) {
		
		$matches = get_user_meta( get_current_user_id(), 'rs_saved_for_later', true );

		//	array_reverse($matches);
			
		if ( ! empty( $matches ) ) {
			$args = array( 
				'posts_per_page' => '-1',	
				'post_type' => 'music',
				'post__in' => ($matches),
				'orderby'   => 'post__in'
			);
		} else {
			$args = 0;
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

				<?php $html = ob_get_clean(); ?>

			<?php else : ?>

				<?php $html = '<li style="text-align: center; padding: 15px 0;">Nothing in the playlist</li>'; ?>

			<?php endif;
				
	}
	
	return wp_send_json ( $html );

}


add_action( 'wp_ajax_remove_track_sidebar', 'ajax_remove_track_sidebar' );
add_action( 'wp_ajax_nopriv_remove_track_sidebar', 'ajax_remove_track_sidebar' );

function ajax_remove_track_sidebar($post) {		
	$posts  = array();
	if ( is_user_logged_in() ) {
		$html[] = $_POST['object_id'];
		return wp_send_json ( $html );
	} 
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

	if ( ! wp_verify_nonce( $_REQUEST['nonce'], 'rs_object_save_for_later' ) ) {
	//	die;
	}
	
	$save = __( 'Save for Later', 'rs-save-for-later' );
	$unsave = __( 'Remove', 'rs-save-for-later' );
	$saved = __( 'See Saved', 'rs-save-for-later' );
	$number = __( 'Saved: ', 'rs-save-for-later' );

	if ( is_user_logged_in() ) {
		$matches = get_user_meta( get_current_user_id(), 'rs_saved_for_later', true );
		if ( empty( $matches ) ) {
			$matches = array();
		}
		$count = count( $matches );
	}

	$no_content = '<li style="text-align: center; padding: 15px 0;">Nothing in the playlist</li>';

	// Object ID
	$object_id = isset( $_REQUEST['object_id'] ) ? intval( $_REQUEST['object_id'] ) : 0;

	// Check cookie if object is saved
	$saved = false;

	if ( is_user_logged_in() ) {
		$matches = get_user_meta( get_current_user_id(), 'rs_saved_for_later', true );
		if ( empty( $matches ) ) {
			$matches = array();
		}
		// array_reverse($matches);
		if ( in_array( $object_id, $matches ) ) {
			$saved = true;
			unset( $matches[array_search( $object_id, $matches )] );
		} else {
			$saved = false;
			array_unshift( $matches, $object_id );
		}
		update_user_meta( get_current_user_id(), 'rs_saved_for_later', $matches );
	}

	if ( $saved == true ) {
		$count = $count - 1;
	} else {
		$count = $count + 1;
	}

	$return = array(
		'status'  => is_user_logged_in(),
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

	if ( ! wp_verify_nonce( $_REQUEST['nonce'], 'rs_object_save_for_later' ) ) {
	//	die;
	}
	
	$save = __( 'Save for Later', 'rs-save-for-later' );
	$unsave = __( 'Remove', 'rs-save-for-later' );
	$saved = __( 'See Saved', 'rs-save-for-later' );
	$number = __( 'Saved: ', 'rs-save-for-later' );

	if ( is_user_logged_in() ) {
		$matches = get_user_meta( get_current_user_id(), 'rs_saved_for_later', true );
		if ( empty( $matches ) ) {
			$matches = array();
		}
		$count = count( $matches );
	}

	$no_content = '<li style="text-align: center; padding: 15px 0;">Nothing in the playlist</li>';

	// Object ID
	$object_id = isset( $_REQUEST['object_id'] ) ? intval( $_REQUEST['object_id'] ) : 0;

	// Check cookie if object is saved
	$saved = false;

	if ( is_user_logged_in() ) {
		$matches = get_user_meta( get_current_user_id(), 'rs_saved_for_later', true );
		if ( empty( $matches ) ) {
			$matches = array();
		}
		
		// array_reverse($matches);
		if ( ! in_array( $object_id, $matches ) ) {
			$saved = false;
			array_unshift( $matches, $object_id );
			$count = $count + 1;
			update_user_meta( get_current_user_id(), 'rs_saved_for_later', $matches );
		}

	}

	$return = array(
		'status'  => is_user_logged_in(),
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
	
	if ( is_user_logged_in() ) {
	
		$object_id = $_POST['object_id'];

		// $matches_ = get_user_meta( get_current_user_id(), 'rs_saved_for_later', true );
	
		$get_songs_args = array( 
			'post_type' => 'music',
			'posts_per_page' => -1,
			'meta_key' => 'meta-box-track-number',
			'orderby' => 'meta_value_num',
			'order' => 'ASC',
			'meta_query' => array(
				array(
					'key' => 'meta-box-media-cover_',
					'value'   => ($object_id),
					'compare' => 'IN'
				)
			)
		); 

		$get_songs = get_posts( $get_songs_args );

		// Check cookie if object is saved
		$saved_album = false;

		if ($get_songs) {

			if ( is_user_logged_in() ) {
				$matches_album = get_user_meta( get_current_user_id(), 'rs_saved_for_later_album', true );
				$count_album =  count( $matches_album );
				if ( empty( $matches_album ) ) {
					$matches_album = array();
				}
				// array_reverse($matches);
				if ( in_array( $object_id, $matches_album ) ) {
				//	$saved_album = true;
				//	unset( $matches_album[array_search( $object_id, $matches_album )] );
				} else {
					$saved_album = false;
					array_unshift( $matches_album, $object_id );
				}
				update_user_meta( get_current_user_id(), 'rs_saved_for_later_album', $matches_album );

				if ( $saved_album == true ) {
					$count_album = $count_album - 1;
				} else {
					$count_album = $count_album + 1;
				}

			}
			
			$count = count( $get_songs );

			foreach ($get_songs as $get_song ) {

				if ( is_user_logged_in() ) {
					$matches = get_user_meta( get_current_user_id(), 'rs_saved_for_later', true );
					if ( empty( $matches ) ) {
						$matches = array();
					}
					// array_reverse($matches);
					if ( in_array( $get_song->ID, $matches ) ) {
					//	$saved = true;
					//	unset( $matches[array_search( $get_song->ID, $matches )] );
					} else {
						$saved = false;
						array_unshift( $matches, $get_song->ID );
					}
					update_user_meta( get_current_user_id(), 'rs_saved_for_later', $matches );

					if ( $saved == true ) {
						$count = $count - 1;
					} else {
						$count = $count + 1;
					}

				}

			}
			return wp_send_json ( $count );
		}

	} 

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

	if ( ! wp_verify_nonce( $_REQUEST['nonce'], 'rs_save_for_later_remove_all' ) ) {
			// die;
	}

	$no_content = '<li style="text-align: center; padding: 15px 0;">Nothing in the playlist</li>';

	if ( is_user_logged_in() ) {
		$saved_items = get_user_meta( get_current_user_id(), 'rs_saved_for_later', true );
		if ( ! empty( $saved_items ) ) {
				delete_user_meta( get_current_user_id(), 'rs_saved_for_later' );
				delete_user_meta( get_current_user_id(), 'rs_saved_for_later_album' );
		}
	}
	return wp_send_json( $no_content );
}
	
/* AJAX action callback */
add_action( 'wp_ajax_play_now', 'ajax_play_now' );
add_action( 'wp_ajax_nopriv_play_now', 'ajax_play_now' );

function ajax_play_now($post) {
	$posts  = array();
	if ( is_user_logged_in() ) {
		$html = $_POST['object_id'];
		return wp_send_json ( $html );
	} 
}	

	
/* AJAX action callback */
add_action( 'wp_ajax_add_play_now', 'ajax_add_play_now' );
add_action( 'wp_ajax_nopriv_add_play_now', 'ajax_add_play_now' );

function ajax_add_play_now($post) {
	$posts  = array();
	if ( is_user_logged_in() ) {
		$html = $_POST['object_id'];
		return wp_send_json ( $html );
	} 
}	

?>
