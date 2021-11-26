<?php

/***************************************************************************/
/***************************************************************************/
/******************** Short code to display single music *******************/

function woocommerce_get_pre_order_loop($atts) {

	$atts = shortcode_atts(array(
		'per_page' => '12',
		'columns'  => '1',
		'orderby'  => 'rand',
		'order'    => 'rand'
	), $atts);

	$args = array(
		'post_type' => 'music',
		// 'meta_key' => 'meta-box-artist',
		'orderby'    => $atts['orderby'],
		'order'      => $atts['order'],
		'columns'  => $atts['columns'],
		'posts_per_page'  => $atts['per_page']
	);

	$loop = new WP_Query($args);
	$columns = absint($args['columns']);
	$woocommerce_loop['columns'] = $columns;

	ob_start();

	if ($loop->have_posts()) : ?>

		<?php // do_action( "woocommerce_shortcode_before_featured_products_loop" ); 
		?>

		<?php // woocommerce_product_loop_start(); 
		?>

		<?php while ($loop->have_posts()) : $loop->the_post(); ?>

			<?php get_template_part('template-parts/page-music-archive', get_post_format()); ?>

		<?php endwhile; // end of the loop. 
		?>

		<?php // woocommerce_product_loop_end(); 
		?>

		<?php  // do_action( "woocommerce_shortcode_after_featured_products_loop" ); 
		?>

	<?php endif;

	// woocommerce_reset_loop();
	wp_reset_postdata();

	return '<div class="columns-' . $columns . '">' . ob_get_clean() . '</div>';
}
add_shortcode('pre_order_products', 'woocommerce_get_pre_order_loop');

add_filter( 'terms_clauses', 'terms_clauses_47840519', 10, 3 );
function terms_clauses_47840519( $clauses, $taxonomies, $args ){
    global $wpdb;

    if( !isset( $args['__first_letter'] ) ){
        return $clauses;
    }

    $clauses['where'] .= ' AND ' . $wpdb->prepare( "t.name LIKE %s", $wpdb->esc_like( $args['__first_letter'] ) . '%' );

    return $clauses;

}

/***************************************************************************/
/***************************************************************************/
/******************** Short code to display artist list ********************/

function artist_get_loop($atts) {

	$curenturl = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
	foreach (range('a', 'z') as $alphabet) {
		echo "<a class='letterartist' href='" . $curenturl . "?char=" . $alphabet . "'>" . strtoupper($alphabet) . "</a>";
	}
	foreach (range('0', '9') as $number) {
		echo "<a class='letterartist' href='" . $curenturl . "?char=" . $number . "'>" . strtoupper($number) . "</a>";
	}

	if($_GET['char']) {
		$terms = get_terms( array(
			'taxonomy' => 'artist',
			'__first_letter' => $_GET['char']
		) );
	} else {
		$terms_ = get_terms( array(
			'taxonomy'      => 'artist',
			'hide_empty'    => true,
			'orderby' => 'name',
            'order' => 'rand',
		) );

		shuffle($terms_);
			
		// Grab Indices 0 - 5, 6 in total
		$terms = array_slice( $terms_, 0, 8 );
	}

	if ($terms) {
		foreach ($terms as $term) {

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

			$get_albums = get_posts($get_albums_args);

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

			$get_songs = get_posts($get_songs_args);


			if ($get_songs) {

				$i = 0;
				$get_songs_calc = [];

				foreach ($get_songs as $get_songs_time) {
					$get_songs_calc[$i++] =  seconds_from_time(get_post_meta($get_songs_time->ID, 'meta-box-track-length', true));
				}
			}

			echo '<li style="list-style: none; text-align: center; width: 50%; float: left; border-bottom: .25px solid rgba(0,0,0,.75); border-right: .25px solid rgba(0,0,0,.75); padding: 10px 0;"><a href="' . esc_attr(get_term_link($term, $taxonomy)) . '" title="' . sprintf(__("View all posts in %s"), $term->name) . '" ' . '><img style="height: 150px; display: flex; margin-left: auto; margin-right: auto;" src="' . z_taxonomy_image_url($term->term_id) . '"><p style="margin: 0;">' . $term->name . '</p></img></a>';
			echo '<p style="margin: 0; float: left; padding-left: 2.5%;">';
			echo count($get_albums);
			echo ' albums - ';
			echo count($get_songs);
			echo ' songs - ';
			echo time_from_seconds(array_sum($get_songs_calc));
			echo '</p>';
			echo '<p style="margin: 0; padding-right: 2.5%; float: right;">';

			echo get_post_meta($get_albums[0]->ID,  "meta-box-year", true);
			echo ' - ';
			echo get_post_meta($get_albums[count($get_albums) - 1]->ID,  "meta-box-year", true);

			echo '</p></li>';

			wp_reset_postdata();
		}
		//	return ob_get_clean();

	}
}

add_shortcode('artist_get_shortcode', 'artist_get_loop');

/***************************************************************************/
/***************************************************************************/
/******************** Short code to display new artist list ********************/

function artist_new_get_loop($atts) {

	$terms_ = get_terms( array(
		'taxonomy'      => 'artist',
		'hide_empty'    => true,
		'orderby' => 'ID',
		'order' => 'DESC',
	) );

	// Grab Indices 0 - 5, 6 in total
	$terms = array_slice( $terms_, 0, 6 );

	if ($terms) {
		foreach ($terms as $term) {

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

			$get_albums = get_posts($get_albums_args);

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

			$get_songs = get_posts($get_songs_args);


			if ($get_songs) {

				$i = 0;
				$get_songs_calc = [];

				foreach ($get_songs as $get_songs_time) {
					$get_songs_calc[$i++] =  seconds_from_time(get_post_meta($get_songs_time->ID, 'meta-box-track-length', true));
				}
			}

			echo '<li style="list-style: none; text-align: center; width: 50%; float: left; border-bottom: .25px solid rgba(0,0,0,.75); border-right: .25px solid rgba(0,0,0,.75); padding: 10px 0;"><a href="' . esc_attr(get_term_link($term, $taxonomy)) . '" title="' . sprintf(__("View all posts in %s"), $term->name) . '" ' . '><img style="height: 150px; display: flex; margin-left: auto; margin-right: auto;" src="' . z_taxonomy_image_url($term->term_id) . '"><p style="margin: 0;">' . $term->name . '</p></img></a>';
			echo '<p style="margin: 0; float: left; padding-left: 2.5%;">';
			echo count($get_albums);
			echo ' albums - ';
			echo count($get_songs);
			echo ' songs - ';
			echo time_from_seconds(array_sum($get_songs_calc));
			echo '</p>';
			echo '<p style="margin: 0; padding-right: 2.5%; float: right;">';

			echo get_post_meta($get_albums[0]->ID,  "meta-box-year", true);
			echo ' - ';
			echo get_post_meta($get_albums[count($get_albums) - 1]->ID,  "meta-box-year", true);

			echo '</p></li>';

			wp_reset_postdata();
		}
		//	return ob_get_clean();

	}
}

add_shortcode('artist_new_get_shortcode', 'artist_new_get_loop');


/***************************************************************************/
/***************************************************************************/
/******************** Short code to display year list ********************/
function get_albums_loop($end)
{
	$get_songs_args = array(
		'post_type' => 'attachment',
		'posts_per_page' => -1,
		'post_mime_type' => 'image',
		'meta_query' => array(
			array(
				'key' => 'meta-box-year',
				'value' => $end
			)
		),
		'orderby' => 'meta_value_num',
		'order' => 'ASC'
	);
	$get_songs_cover = get_posts($get_songs_args);

	foreach ($get_songs_cover as $get_song_cover) {
		$getslugid = wp_get_post_terms($get_song_cover->ID, 'artist');
		foreach ($getslugid as $thisslug) {
			$artist_slug_name = $thisslug->name; // Added a space between the slugs with . ' '
		}


		$get_songs_args = array(
			'post_type' => 'music',
			'posts_per_page' => -1,
			'meta_key' => 'meta-box-media-cover_',
			'meta_value' => $get_song_cover->ID,
			'order' => 'DESC',
			'tax_query' => array(
				array(
					'taxonomy' => 'artist',
					'field'    => 'name',
					'terms'    => $artist_slug_name
				)
			)
		);

		$get_songs = get_posts($get_songs_args);

		$i = 0;
		$get_songs_calc = [];

		foreach ($get_songs as $get_songs_time) {
			$get_songs_calc[$i++] =  seconds_from_time(get_post_meta($get_songs_time->ID, 'meta-box-track-length', true));
		}

		?>
		<article id="album-class-year" class="page-music music type-music status-publish hentry">
			<div class="entry-header">
				<h2 style="margin: 0;"><a href="?album=<?php echo $get_song_cover->ID; ?>" rel="bookmark">
						<?php echo get_the_title($get_song_cover->ID); ?>
					</a></h2>
				<a href="?album=<?php echo $get_song_cover->ID; ?>"><?php echo wp_get_attachment_image($get_song_cover->ID, array('350', '350')); ?></a>
				<div style="float: left; max-width: calc(100% - 40px);">
					<?php echo $artist_slug_name ?>
					</br>
					<?php echo count($get_songs); ?>
					</br>
					<?php echo time_from_seconds(array_sum($get_songs_calc)); ?>
				</div>
				<div style="float: right; margin: 25px 15px 0 0;">
					<?php echo do_shortcode('[simplicity-save-for-later-loop-album album_id="' . $get_song_cover->ID . '"]'); ?>
				</div>
			</div>
		</article>
	<?php

	}
}

function year_get_loop($atts)
{

	// Gets every "category" (term) in this taxonomy to get the respective posts
	$get_years_args = array(
		'post_type' => 'attachment',
		'posts_per_page' => -1,
		'post_mime_type' => 'image',
		'meta_key' => 'meta-box-year',
		'orderby' => 'meta_value_num',
		'order' => 'ASC'
	);

	$get_years = get_posts($get_years_args);

	$i = -1;

	$classes = array(
		'page-music',
	);

	echo '<div style="display: table;">';
	foreach ($get_years as $get_year) {
		$last_year = get_post_meta($get_years[$i++]->ID, "meta-box-year", true);
		if ($last_year != get_post_meta($get_year->ID,  "meta-box-year", true)) {
			global $wp;
			echo '<li style="float: left;list-style: none;margin: 15px;font-weight: 600;font-size: 25px;">';
			echo '<a href="' . home_url( $wp->request ).'/?y='.get_post_meta($get_year->ID,  "meta-box-year", true) . '">';
			echo get_post_meta($get_year->ID,  "meta-box-year", true);
			echo '</a>';
			echo '<br>';
			echo '</li>';
			wp_reset_postdata();
		}
	}
	echo '</div>';

	$get_songs_args = array(
		'post_type' => 'attachment',
		'posts_per_page' => -1,
		'post_mime_type' => 'image',
		'meta_query' => array(
			array(
				'key' => 'meta-box-year',
				'value' => $_GET['y']
			)
		),
		'orderby' => 'meta_value_num',
		'order' => 'ASC'
	);
	$get_songs_cover = get_posts($get_songs_args);

	foreach ($get_songs_cover as $get_song_cover) {
		$getslugid = wp_get_post_terms($get_song_cover->ID, 'artist');
		foreach ($getslugid as $thisslug) {
			$artist_slug_name = $thisslug->name; // Added a space between the slugs with . ' '
		}


		$get_songs_args = array(
			'post_type' => 'music',
			'posts_per_page' => -1,
			'meta_key' => 'meta-box-media-cover_',
			'meta_value' => $get_song_cover->ID,
			'order' => 'DESC',
			'tax_query' => array(
				array(
					'taxonomy' => 'artist',
					'field'    => 'name',
					'terms'    => $artist_slug_name
				)
			)
		);

		$get_songs = get_posts($get_songs_args);

		$i = 0;
		$get_songs_calc = [];

		foreach ($get_songs as $get_songs_time) {
			$get_songs_calc[$i++] =  seconds_from_time(get_post_meta($get_songs_time->ID, 'meta-box-track-length', true));
		}

		?>
		<article id="album-class-year" class="page-music music type-music status-publish hentry">
			<div class="entry-header">
				<h2 style="margin: 0;"><a href="?album=<?php echo $get_song_cover->ID; ?>" rel="bookmark">
						<?php echo get_the_title($get_song_cover->ID); ?>
					</a></h2>
				<a href="?album=<?php echo $get_song_cover->ID; ?>"><?php echo wp_get_attachment_image($get_song_cover->ID, array('350', '350')); ?></a>
				<div style="float: left; max-width: calc(100% - 40px);">
					<?php echo $artist_slug_name ?>
					</br>
					<?php echo count($get_songs); ?>
					</br>
					<?php echo time_from_seconds(array_sum($get_songs_calc)); ?>
				</div>
				<div style="float: right; margin: 25px 15px 0 0;">
					<?php echo do_shortcode('[simplicity-save-for-later-loop-album album_id="' . $get_song_cover->ID . '"]'); ?>
				</div>
			</div>
		</article>
	<?php

	}

	if ($_GET['album']) {

		$args = array(
			'post_type' => 'music',
			'meta_query' => array(
				array(
					'key' => 'meta-box-media-cover_',
					'value' => $_GET['album'],
				)
			),
			'orderby' => 		'meta_value_num',
			'order' => 			'ASC',
			'posts_per_page'  => -1
		);

		$loop = new WP_Query($args);
		$columns = absint($args['columns']);
		$woocommerce_loop['columns'] = $columns;

		echo '<div style="float: left;">';

		$post = get_post($_GET['album']);
		$title = $post->post_title;

		echo $title;

		echo '<br>';

		$getslugid = wp_get_post_terms($_GET['album'], 'artist');
		foreach ($getslugid as $thisslug) {
			echo $thisslug->name; // Added a space between the slugs with . ' '
		}

		echo '<br>';

		echo get_post_meta($_GET['album'], "meta-box-year", true);

		echo '</div>';

		?> <div class="entry-meta-cover">
			<?php echo wp_get_attachment_image($_GET['album'], 'full', false, array('style' => 'max-width:450px;height:auto;margin-left: auto;display: grid;margin-right: 15px;')); ?>
		</div> <?php

		echo "<table id='album-class-artist-list'>";

			while ($loop->have_posts()) : $loop->the_post();

			$posts[$x][0] = get_post_meta( get_the_id(), "meta-box-track-number", true );
			$posts[$x][1] = get_the_id();
			$x++;

			endwhile;
			wp_reset_postdata();

			asort($posts);

			if ($_GET['album'] != '') { 

				foreach($posts as $post) { ?>
					<tr style='width: 100%; height: 60px;'>
					<td id="album-class-artist-list-id-<?php echo $post[1]; ?>" style='text-align: center; width: 30px; padding: 0 10px;'>
						<?php echo do_shortcode( '[simplicity-save-for-later-loop id="' . $post[1] . '"]' ); ?>
					</td>
					<td style='width: 30px; display: inline-flex; text-align: center; margin auto 0; padding: 0 5px;'>
						<?php echo do_shortcode( '[add-play-now id="' . $post[1] . '"]' ); ?>
					</td>
					<td style='text-align: center; padding: 0 5px; width: 30px;'>
						<?php echo get_post_meta( $post[1], "meta-box-track-number", true ); ?>
					</td>
					<td style='text-align: left; font-size: 18px; font-weight: 400; width: 100%; padding 0 25px;'>
						<a href="<?php echo get_permalink( $post[1] ) ?>" class='entry-title'><?php echo get_the_title($post[1]) ?></a>	
						<?php $if_feat = get_post_meta( $post[1], "meta-box-artist-feat", true);
							if ($if_feat != '') {
							?>
								<?php echo      " Feat. "; ?>
								<?php echo $if_feat; ?>
							<br />
							<?php } ?>
					</td>
					<td style="">
						<?php echo get_post_meta( $post[1], "meta-box-track-length", true ); ?>
					</td>
				</tr>	
				<?php }
			} 

		echo "</table>";
	}
}

add_shortcode('year_get_shortcode', 'year_get_loop');

/***************************************************************************/
/***************************************************************************/
/******************** Short code to display genre list ********************/

function genre_get_loop($atts)
{

	// Gets every "category" (term) in this taxonomy to get the respective posts
	$terms = get_terms('genre');

	if ($terms) {
		foreach ($terms as $term) {
			echo '<li style="list-style: none; text-align: center; width: 50%; float: left;"><a href="' . esc_attr(get_term_link($term, $taxonomy)) . '" title="' . sprintf(__("View all posts in %s"), $term->name) . '" ' . '><img src="' . z_taxonomy_image_url($term->term_id) . '"><p>' . $term->name . '</p></img></a></li>';
			wp_reset_postdata();
		}
	}

	return ob_get_clean();
}

add_shortcode('genre_get_shortcode', 'genre_get_loop');

/***************************************************************************/
/***************************************************************************/
/******************** Short code to display genre list ********************/

function btn_remove_sidebar_loop($atts) {
	return '<a href="#" class="rs-save-for-later-button saved saved-in-list" data-toggle="tooltip" data-placement="top" data-title="' . esc_attr("remove") . '" data-nonce="' . wp_create_nonce('rs_object_save_for_later') . '" data-object-id="' . $atts['id'] . '"></a>';
}

add_shortcode('simplicity-save-for-later-remove-sidebar', 'btn_remove_sidebar_loop');

/***************************************************************************/
/***************************************************************************/
/******************** Short code to play now ********************/

function play_now_sidebar_loop($atts) {
	return '<a href="#" id="play-now-id-' . $atts['id'] . '" class="play-now-button onpause" data-toggle="tooltip" data-placement="top" data-title="' . esc_attr("Play now") . '" data-nonce="' . wp_create_nonce('play_now_object') . '" data-object-id="' . $atts['id'] . '"></a>';
}

add_shortcode('play-now', 'play_now_sidebar_loop');


/***************************************************************************/
/***************************************************************************/
/******************** Short code to add and play now ********************/

function add_play_now_loop($atts) {
	return '<a href="#" id="add-play-now-id-' . $atts['id'] . '" class="add-play-now-button onpause" data-toggle="tooltip" data-placement="top" data-title="' . esc_attr("Play now") . '" data-nonce="' . wp_create_nonce('add_play_now_object') . '" data-object-id="' . $atts['id'] . '"></a>';
}

add_shortcode('add-play-now', 'add_play_now_loop');

/***************************************************************************/
/***************************************************************************/
/******************** Short code to display genre list ********************/

function get_save_for_later_button_display($atts)
{

	global $post;

	// Object ID
	$object_id = get_queried_object_id();

	// Check cookie if object is saved
	$saved = false;

	$matches = get_user_meta(user_if_login(), 'rs_saved_for_later', true);
	if (empty($matches)) {
		$matches = array();
	}
	if (in_array(esc_attr($atts['id']), $matches)) {
		$saved = true;
	} else {
		$saved = false;
	}

	$save = __('Add to Playlist', 'rs-save-for-later');
	$unsave = __('Remove', 'rs-save-for-later');
	$saved_txt = __('See Playlist', 'rs-save-for-later');
	$number = __('Playlist: ', 'rs-save-for-later');

	$matches = get_user_meta(user_if_login(), 'rs_saved_for_later', true);
	if (empty($matches)) {
		$matches = array();
	}
	$count = count($matches);

	if ($saved == true) {
		return '<a href="#" class="rs-save-for-later-button saved" data-toggle="tooltip" data-placement="top" data-title="' . esc_attr($unsave) . '" data-nonce="' . wp_create_nonce('rs_object_save_for_later') . '" data-object-id="' . esc_attr($atts['id']) . '"></a>';
	} else {
		return '<a href="#" class="rs-save-for-later-button" data-toggle="tooltip" data-placement="top" data-title="' . esc_attr($save) . '" data-nonce="' . wp_create_nonce('rs_object_save_for_later') . '" data-object-id="' . esc_attr($atts['id']) . '">️</a>';
	}
}

add_shortcode('simplicity-save-for-later-loop', 'get_save_for_later_button_display');

function get_save_for_later_album_button_display($atts)
{

	$saved_album = false;

	$save = __('Add to Playlist', 'rs-save-for-later');
	$unsave = __('Remove', 'rs-save-for-later');
	$saved_txt = __('See Playlist', 'rs-save-for-later');
	$number = __('Playlist: ', 'rs-save-for-later');

	$matches_album = get_user_meta(user_if_login(), 'rs_saved_for_later_album', true);
	if (empty($matches_album)) {
		$matches_album = array();
	}
	if (in_array(esc_attr($atts['album_id']), $matches_album)) {
		$saved_album = true;
	} else {
		$saved_album = false;
	}


	if (empty($matches_album)) {
		$matches_album = array();
	}
	$count = count($matches_album);

	if ($saved_album == true) {
		return '<a href="#" class="rs-save-for-later-button-album saved" data-toggle="tooltip" data-placement="top" data-title="' . esc_attr($unsave) . '" data-nonce="' . wp_create_nonce('rs_object_save_for_later_album') . '" data-object-id="' . esc_attr($atts['album_id']) . '"></a>';
	} else {
		return '<a href="#" class="rs-save-for-later-button-album" data-toggle="tooltip" data-placement="top" data-title="' . esc_attr($save) . '" data-nonce="' . wp_create_nonce('rs_object_save_for_later_album') . '" data-object-id="' . esc_attr($atts['album_id']) . '">️</a>';
	}
}

add_shortcode('simplicity-save-for-later-loop-album', 'get_save_for_later_album_button_display');
?>