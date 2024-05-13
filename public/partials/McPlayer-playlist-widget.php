<?php

function McPlayer_register_playlist_widgets() {
	register_widget( 'MCPlayer_bottom_playlist_widget');
}
add_action( 'widgets_init', 'McPlayer_register_playlist_widgets' );

class MCPlayer_bottom_playlist_widget extends WP_Widget {
	public function __construct() {
		// Instantiate the parent object
		parent::__construct(

			// Base ID of your widget
			'MCPlayer_bottom_playlist_widget', 

			// Widget name will appear in UI
			__('MC Playlist Widget', 'McPlayer'), 

			// Widget description
			array( 'description' => __( 'Sample widget based on WPBeginner Tutorial', 'sidr_widget_domain' ), ) 
		);

	}

	function widget( $args, $instance ) {

		$title = apply_filters( 'widget_title', $instance['title'] );
		$matches = get_user_meta( user_if_login(), 'rs_saved_for_later', true );
		if ( ! empty( $matches ) ) {
			$matches_count = count($matches);
		} else {
			$matches_count = '0';
		}

		if ( ! empty( $matches ) ) {
			$argv = array( 
				'posts_per_page' => -1,	
				'post_type' => 'music',
				'post__in' => $matches,
				'order'   => 'DESC',
				'orderby'   => 'post__in',
			);
		} else {
			$argv = null;
		}

		$posts = get_posts($argv);

		$i = 0;
		foreach($posts as $post){
			$songs_length_calc[$i++] = seconds_from_time(get_post_meta($post->ID, 'meta-box-track-length', true));
		}

		echo $args['before_widget'];
		if ( ! empty( $title ) )
		echo $args['before_title'] . $title . ' - <span class="playlist_matches_count">' . $matches_count . '</span> - <span class="playlist_matches_length">' .  time_from_seconds(array_sum($songs_length_calc)) . '</span>' . $args['after_title'];
		
		if ( ! empty( $matches ) ) {
			$args = array( 
				'posts_per_page' => -1,	
				'post_type' => 'music',
				'post__in' => $matches,
				'order'   => 'DESC',
				'orderby'   => 'post__in',
			);
		} else {
			$args = 0;
		}
		
		$the_query = new WP_Query( $args );

		if ( $the_query->have_posts() ) {
			echo '<div id="rs-saved-for-later-wrapper" class="noselect"><ul id="rs-saved-for-later" class="rs-saved-for-later">' ;
			while ( $the_query->have_posts() ) {
				$the_query->the_post();
				echo get_template_part( 'template-parts/page-music-archive-sidebar', get_post_format() );
			}
			echo '</ul></div>';
		} else {
			echo '<div id="rs-saved-for-later-wrapper" class="noselect"><ul id="rs-saved-for-later" class="rs-saved-for-later"><li id="rs-saved-for-later-nothing" style="text-align: center; padding:15px 0;">Nothing in the playlist</li></ul></div>';
		}

		wp_reset_postdata();

		echo "<div id='subnav-content-save'>
			<span style='margin: 0px; width: 100%; display: table;'>
				<input type='text' id='lnamesave' name='lname' aria-labelledby='Save playlist'></input>
				<button class='save-playlist'>save</button>
			<span>
		</div>";

		$args = array( 
            'posts_per_page' => -1,
			'post_status' => 'publish',
			'post_type' => 'playlist'
        );
		
		$posts = get_posts( $args );

		echo "<div id='subnav-content-load'>";

		foreach ($posts as $post) {
			echo "<div class='playlist-load-loop' data-id='".$post->ID."'>".get_the_title($post->ID)."</div>";
		}

		echo "</div>";
			
		echo '<div id="playlist-btn">';
		
		echo '<div class="rs-save-for-later-save-playlist" data-nonce="' . wp_create_nonce( 'rs_save_for_later_save_playlist' ) . '">Save</div>';

		echo '<div class="rs-save-for-later-load-playlist" data-nonce="' . wp_create_nonce( 'rs_save_for_later_load_playlist' ) . '">Load</div></div>';

		echo '<div id="remove-all-btn"><a href="#" class="rs-save-for-later-remove-all" data-nonce="' . wp_create_nonce( 'rs_save_for_later_remove_all' ) . '">Flush Playlist</a></div>';
		
		echo $args['after_widget'];		

	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		// Fields
		$instance[ 'title' ] = strip_tags( $new_instance[ 'title' ] );
		return $instance;
	}

	// Widget form creation
	function form($instance) {
		$title = '';
	 	$link = '';
		$songinfo = '';

		// Check values
		if( $instance) {
			$title = ! empty( $instance['title'] ) ? $instance['title'] : '';
		} ?>
		 
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
			<input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		
	<?php }
}

?>
