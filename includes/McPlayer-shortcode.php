<?php

/***************************************************************************/
/***************************************************************************/
/******************** Short code to display single music *******************/

function woocommerce_get_pre_order_loop( $atts ) {
	// global $woocommerce_loop;
	if ( is_user_logged_in() ) {
		$atts = shortcode_atts( array(
		'per_page' => '12',
		'columns'  => '1',
		'orderby'  => 'rand',
		'order'    => 'rand'
		), $atts );
		
		$args = array( 
		'post_type' => 'music',
		// 'meta_key' => 'meta-box-artist',
		'orderby'    => $atts['orderby'],
		'order'      => $atts['order'],
		'columns'  => $atts['columns'],
		'posts_per_page'  => $atts['per_page']
		);
		
		$loop = new WP_Query( $args );
		$columns = absint( $args['columns'] );
		$woocommerce_loop['columns'] = $columns;

		ob_start();

		if ( $loop->have_posts() ) : ?>

			<?php // do_action( "woocommerce_shortcode_before_featured_products_loop" ); ?>

			<?php // woocommerce_product_loop_start(); ?>

				<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>

					<?php get_template_part( 'template-parts/page-music-archive', get_post_format() ); ?>

				<?php endwhile; // end of the loop. ?>

			<?php // woocommerce_product_loop_end(); ?>

			<?php  // do_action( "woocommerce_shortcode_after_featured_products_loop" ); ?>

		<?php endif;

		// woocommerce_reset_loop();
		wp_reset_postdata();

		return '<div class="columns-' . $columns . '">' . ob_get_clean() . '</div>';

	} else  {
		echo '<p id="notlogin" class="nothing-saved">You don’t have access, You need to <a href="';
		echo wp_login_url( home_url() );
		echo '" title="Login">Login</a></p>';
	}
	
}
add_shortcode('pre_order_products', 'woocommerce_get_pre_order_loop');

/***************************************************************************/
/***************************************************************************/
/******************** Short code to display artist list ********************/

function artist_get_loop( $atts ) {

	if ( is_user_logged_in() ) {

		// Gets every "category" (term) in this taxonomy to get the respective posts
		$terms = get_terms( 'artist' );
		
		if ($terms) {
			foreach($terms as $term) {

				$get_albums_args = array( 
					'post_type' => 'attachment',
					'posts_per_page' => -1,
					'post_mime_type' => 'image',
					'meta_key' => 'meta-box-year',
					'orderby' => 'meta_value_num',
					'order' => 'ASC',
					'tax_query' => array(
						array(
							'taxonomy' => 'artist',
							'field'    => 'name',
							'terms'    => $term->name
						)
					)
				); 

				$get_albums = get_posts( $get_albums_args );

				$get_songs_args = array( 
					'post_type' => 'music',
					'posts_per_page' => -1,
					'order' => 'ASC',
					'tax_query' => array(
						array(
							'taxonomy' => 'artist',
							'field'    => 'name',
							'terms'    => $term->name
						)
					)
				); 

				$get_songs = get_posts( $get_songs_args );

				
				if ( $get_songs ) {
					
					$i = 0; 
					$get_songs_calc = [];

					foreach ( $get_songs as $get_songs_time ) {
						$get_songs_calc[$i++] =  seconds_from_time( get_post_meta(  $get_songs_time->ID , 'meta-box-track-length' , true ));
					}
				}

				echo '<li style="list-style: none; text-align: center; width: 50%; float: left; border-bottom: .25px solid rgba(0,0,0,.75); border-right: .25px solid rgba(0,0,0,.75); padding: 10px 0;"><a href="' . esc_attr(get_term_link($term, $taxonomy)) . '" title="' . sprintf( __( "View all posts in %s" ), $term->name ) . '" ' . '><img style="height: 150px;" src="' . z_taxonomy_image_url($term->term_id) . '"><p style="margin: 0;">' . $term->name.'</p></img></a>';
					echo '<p style="margin: 0; float: left; padding-left: 2.5%;">';
						echo count($get_albums);
						echo ' albums - ';
						echo count($get_songs);
						echo ' songs - ';
						echo time_from_seconds ( array_sum($get_songs_calc) );
					echo '</p>';
					echo '<p style="margin: 0; padding-right: 2.5%; float: right;">';

						echo get_post_meta( $get_albums[0]->ID,  "meta-box-year", true); 
						echo ' - ';
						echo get_post_meta( $get_albums[count($get_albums) - 1]->ID,  "meta-box-year", true); 

				echo '</p></li>';

				wp_reset_postdata();
				
			}
			
		//	return ob_get_clean();
		}
	} else  {
		echo '<p id="notlogin" class="nothing-saved">You don’t have access to the artists list, You need to <a href="';
		echo wp_login_url( home_url() );
		echo '" title="Login">Login</a></p>';
	}
}

add_shortcode('artist_get_shortcode', 'artist_get_loop');

/***************************************************************************/
/***************************************************************************/
/******************** Short code to display genre list ********************/

function genre_get_loop( $atts ) {
	
	// Gets every "category" (term) in this taxonomy to get the respective posts
	$terms = get_terms( 'genre' );
	
	if ($terms) {
		foreach($terms as $term) {
			echo '<li style="list-style: none; text-align: center; width: 50%; float: left;"><a href="' . esc_attr(get_term_link($term, $taxonomy)) . '" title="' . sprintf( __( "View all posts in %s" ), $term->name ) . '" ' . '><img src="' . z_taxonomy_image_url($term->term_id) . '"><p>' . $term->name.'</p></img></a></li>';
			wp_reset_postdata();
		}
	}

	return ob_get_clean();
}

add_shortcode('genre_get_shortcode', 'genre_get_loop');

/***************************************************************************/
/***************************************************************************/
/******************** Short code to display genre list ********************/

function btn_remove_sidebar_loop( $atts ) {


	if (  is_user_logged_in() ) {
			return '<a href="#" class="rs-save-for-later-button saved saved-in-list" data-toggle="tooltip" data-placement="top" data-title="' . esc_attr( "remove" ) . '" data-nonce="' . wp_create_nonce( 'rs_object_save_for_later' ) . '" data-object-id="' . $atts['id'] . '"></a>';			
	} 
	


}

add_shortcode('simplicity-save-for-later-remove-sidebar', 'btn_remove_sidebar_loop');

/***************************************************************************/
/***************************************************************************/
/******************** Short code to play now ********************/

function play_now_sidebar_loop( $atts ) {
	
	
		if (  is_user_logged_in() ) {
				return '<a href="#" id="play-now-id-' . $atts['id'] . '" class="play-now-button onpause" data-toggle="tooltip" data-placement="top" data-title="' . esc_attr( "Play now" ) . '" data-nonce="' . wp_create_nonce( 'play_now_object' ) . '" data-object-id="' . $atts['id'] . '"></a>';			
		} 
		
	
	
	}
	
	add_shortcode('play-now', 'play_now_sidebar_loop');

	
/***************************************************************************/
/***************************************************************************/
/******************** Short code to add and play now ********************/

function add_play_now_loop( $atts ) {
	
	
		if (  is_user_logged_in() ) {
				return '<a href="#" id="add-play-now-id-' . $atts['id'] . '" class="add-play-now-button onpause" data-toggle="tooltip" data-placement="top" data-title="' . esc_attr( "Play now" ) . '" data-nonce="' . wp_create_nonce( 'add_play_now_object' ) . '" data-object-id="' . $atts['id'] . '"></a>';			
		} 
		
	
	
	}
	
	add_shortcode('add-play-now', 'add_play_now_loop');

/***************************************************************************/
/***************************************************************************/
/******************** Short code to display genre list ********************/

function get_save_for_later_button_display() {

			global $post;
	
			// Object ID
			$object_id = get_queried_object_id();	
	
			// Check cookie if object is saved
			$saved = false;
	
			if ( is_user_logged_in() ) {
				$matches = get_user_meta( get_current_user_id(), 'rs_saved_for_later', true );
				if ( empty( $matches ) ) {
					$matches = array();
				}
				if ( in_array( get_the_ID(), $matches ) ) {
					$saved = true;
				} else {
					$saved = false;
				}
			}

			$save = __( 'Add to Playlist', 'rs-save-for-later' );
			$unsave = __( 'Remove', 'rs-save-for-later' );
			$saved_txt = __( 'See Playlist', 'rs-save-for-later' );
			$number = __( 'Playlist: ', 'rs-save-for-later' );
		
			if ( is_user_logged_in() ) {
				$matches = get_user_meta( get_current_user_id(), 'rs_saved_for_later', true );
				if ( empty( $matches ) ) {
					$matches = array();
				}
				$count = count( $matches );
			} else {
					$count = 0;
			}

			if (is_user_logged_in() ) {
				if ( $saved == true ) {
					return '<a href="#" class="rs-save-for-later-button saved" data-toggle="tooltip" data-placement="top" data-title="' . esc_attr( $unsave ) . '" data-nonce="' . wp_create_nonce( 'ajax_object_save_for_later' ) . '" data-object-id="' . esc_attr( get_the_ID() ) . '"></a>';
				} else {
					return '<a href="#" class="rs-save-for-later-button" data-toggle="tooltip" data-placement="top" data-title="' . esc_attr( $save ) . '" data-nonce="' . wp_create_nonce( 'rs_object_save_for_later' ) . '" data-object-id="' . esc_attr( get_the_ID() ) . '">️</a>';
				}
			} else {
				$login_url = wp_login_url( get_permalink() );
				$register_url = wp_registration_url();
				// $return = sprintf( __( '%1$sLog in%2$s or %3$sRegister%4$s to save this content for later.', 'rs-save-for-later' ), '<a href="' . esc_url( $login_url ) . '">', '</a>', '<a href="' . esc_url( $register_url ) . '">', '</a>' );
				return apply_filters( 'rs_save_for_later_message', $return );
			}
		}

add_shortcode('simplicity-save-for-later-loop', 'get_save_for_later_button_display');

function get_save_for_later_album_button_display($atts) {
	
				// Check cookie if object is saved
		
				if ( is_user_logged_in() ) {
					$saved_album = false;

					$save = __( 'Add to Playlist', 'rs-save-for-later' );
					$unsave = __( 'Remove', 'rs-save-for-later' );
					$saved_txt = __( 'See Playlist', 'rs-save-for-later' );
					$number = __( 'Playlist: ', 'rs-save-for-later' );

					$matches_album = get_user_meta( get_current_user_id(), 'rs_saved_for_later_album', true );
					if ( empty( $matches_album ) ) {
						$matches_album = array();
					}
					if ( in_array( esc_attr( $atts['album_id'] ), $matches_album ) ) {
						$saved_album = true;
					} else {
						$saved_album = false;
					}
				

					if ( empty( $matches_album ) ) {
						$matches_album = array();
					}
					$count = count( $matches_album );



		
			
											
						if ( $saved_album == true ) {
							return '<a href="#" class="rs-save-for-later-button-album saved" data-toggle="tooltip" data-placement="top" data-title="' . esc_attr( $unsave ) . '" data-nonce="' . wp_create_nonce( 'rs_object_save_for_later_album' ) . '" data-object-id="' . esc_attr( $atts['album_id'] ) . '"></a>';
						} else {
							return '<a href="#" class="rs-save-for-later-button-album" data-toggle="tooltip" data-placement="top" data-title="' . esc_attr( $save ) . '" data-nonce="' . wp_create_nonce( 'rs_object_save_for_later_album' ) . '" data-object-id="' . esc_attr( $atts['album_id'] ) . '">️</a>';
						} 
			
				} else  {
					$login_url = wp_login_url( get_permalink() );
					$register_url = wp_registration_url();
					// $return = sprintf( __( '%1$sLog in%2$s or %3$sRegister%4$s to save this content for later.', 'rs-save-for-later' ), '<a href="' . esc_url( $login_url ) . '">', '</a>', '<a href="' . esc_url( $register_url ) . '">', '</a>' );
					return apply_filters( 'rs_save_for_later_message', $return );
				}

			}

			add_shortcode('simplicity-save-for-later-loop-album', 'get_save_for_later_album_button_display');
?>