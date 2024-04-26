<?php

function McPlayer_register_widgets() {
	register_widget( 'MCPlayer_bottom_player_widget');
}
add_action( 'widgets_init', 'McPlayer_register_widgets' );

class MCPlayer_bottom_player_widget extends WP_Widget {
	public function __construct() {
		// Instantiate the parent object
		parent::__construct(

			// Base ID of your widget
			'MCPlayer_bottom_player_widget', 

			// Widget name will appear in UI
			__('MC Player Widget', 'McPlayer'), 

			// Widget description
			array( 'description' => __( 'Sample widget based on WPBeginner Tutorial', 'sidr_widget_domain' ), ) 
		);

	}

	function widget( $args, $instance ) {

		$title = apply_filters( 'widget_title', $instance['title'] );

		$title_i = "<div id='current_music_name'></div>";

		$shuffle = get_user_meta( user_if_login(), 'user_playlist_shuffle', true );

		if ( $shuffle == 1 ) {
			$shuffle_toggle = "<div style='padding-right: 5px; right: 40px; float: right;' ><i class='shuffle_player_toggle material-icons' style='box-shadow: 2.5px 2.5px 2.5px #000'>shuffle</i></div>";
		} else {
			$shuffle_toggle = "<div style='padding-right: 5px; right: 40px; float: right;' ><i class='shuffle_player_toggle material-icons'>shuffle</i></div>";
		}

		$btn_toggle_up = "<div id='btn_player_toggle_up' class='player_widget_name_up_btn' style='padding-right: 5px' ><i class='material-icons'>keyboard_arrow_up</i></div>";	

		$btn_toggle_down = "<div id='btn_player_toggle' class='player_widget_name_hide_btn' style='padding-right: 5px' ><i class='material-icons'>keyboard_arrow_down</i></div>";	

		$title_toggle = "<div id='title_player_toggle' class='player_widget_name' style='margin-left: auto; margin-right: auto;	display: inline;'>$title</div>";

		// before and after widget arguments are defined by themes
		echo $args['before_widget'];
		if ( ! empty( $title ) )
		echo $args['before_title'] . $title_toggle . $btn_toggle_down .  $btn_toggle_up . $shuffle_toggle . $args['after_title'];

		global $post;

		// Saved objects
		$matches = get_user_meta( user_if_login(), 'rs_saved_for_later', true );

		echo '<div id="player-container">';

		if ( ! empty( $matches ) ) {
			if ( $shuffle == 1 ) {
				$saved_args = array(
					'post_type'      => 'music',
					'posts_per_page' => -1,
					'orderby' => 'rand',
					'post__in'       => array_reverse( $matches, true )
				);
			} else {
				$saved_args = array(
					'post_type'      => 'music',
					'posts_per_page' => -1,
					'orderby' => 'post__in',
					'post__in'       => array_reverse( $matches, true )
				);
			}
		} else {
			$saved_args = 0;
		}

		$saved_loop = new WP_Query( $saved_args );

		if ( $saved_loop->have_posts() ) {

			while ( $saved_loop->have_posts() ) : $saved_loop->the_post();

				$music_playlist = wp_get_attachment_url(get_post_meta( $post->ID, 'music_link_', true ));

				$urllocal = realpath(ABSPATH.explode(site_url(), $music_playlist )[1]); 

				$plugin_dir = site_url().'/wp-content/plugins/McPlayer/includes/download.php';
	
				$terms = wp_get_post_terms( $post->ID, 'artist' );

				$name = esc_attr( 'meta-box-media-cover_' );
				$value = $rawvalue = get_post_meta( $post->ID, $name, true );
				$attachment_title = get_the_title($value);
				$get_feat = get_post_meta( get_the_id(), "meta-box-artist-feat", true);
				$delimeter_player56s = esc_attr(' || ');

				$get_music_meta_length = get_post_meta( $post->ID, "meta-box-track-length", true );

				$get_music_meta_length_str = explode(":", $get_music_meta_length);

				$get_music_meta_length_str_minute = $get_music_meta_length_str[0]*60;
		
				$get_music_meta_length_str_seconde = $get_music_meta_length_str[1];
		
				$get_music_meta_length_str__ = $get_music_meta_length_str_minute+$get_music_meta_length_str_seconde;
				
				?><audio href="<?php echo $plugin_dir.'?path='.$urllocal; ?>" class="player56s" rel="playlist" data-length="<?php echo $get_music_meta_length_str__; ?>" postid="<?php echo $post->ID; ?>"><?php
					echo $attachment_title;
					echo $delimeter_player56s;
					foreach($terms as $term) {
						echo $term->name;
					}
					if ($get_feat != '') {
						echo ' - Feat. ' . $get_feat;
					}
					echo $delimeter_player56s;
					echo get_the_title();
					echo $delimeter_player56s;
					echo wp_get_attachment_image_url( $value , 'full' );
				?></audio><?php 
									
			endwhile;

		wp_reset_postdata();
			
		} else {
			echo '<audio href="" class="player56s" rel="playlist" data-length="0" postid="0">Just another WordPress site || McPlayer || Nothing in the playlist || https://'. $_SERVER['SERVER_NAME'] .'/wp-content/plugins/McPlayer/public/css/blue-note.png</audio>';
		}
	
		echo '</div>';

		echo '<div id="player56s-ajax-wrap" style="display: none;">';
			echo '<div id="player56s-currenttrack"></div>';
			echo '<div id="player56s-addtrack"></div>';
			echo '<div id="player56s-removetrack"></div>';
			echo '<div id="player56s-removetracks-all"></div>';
			echo '<div id="player56s-playnow"></div>';
			echo '<div id="player56s-shuffle"></div>';
			echo '<div id="player56s-no-shuffle"></div>';
			echo '<div id="player56s-seek-percent"></div>';
			echo '<div id="player56s-seek-current-percent"></div>';
			echo '<div id="player56s-play-timer"></div>';
			echo '<div id="player56s-orientation"></div>';
			echo '<div id="player56s-load-playlist"></div>';
		echo '</div>';

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