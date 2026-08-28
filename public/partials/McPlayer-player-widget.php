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

		$shuffle = get_user_meta( user_if_login(), 'user_playlist_shuffle', true );

		if ( $shuffle == 1 ) {
			$shuffle_toggle = "<div style='padding-right: 5px; right: 40px; float: right;' ><i class='shuffle_player_toggle material-icons' style='box-shadow: 2.5px 2.5px 2.5px #000'>shuffle</i></div>";
		} else {
			$shuffle_toggle = "<div style='padding-right: 5px; right: 40px; float: right;' ><i class='shuffle_player_toggle material-icons'>shuffle</i></div>";
		}

		$btn_toggle_up = "<div id='btn_player_toggle_up' class='player_widget_name_up_btn' style='padding-right: 5px' ><i class='material-icons'>keyboard_arrow_up</i></div>";	

		$btn_toggle_down = "<div id='btn_player_toggle' class='player_widget_name_hide_btn' style='padding-right: 5px' ><i class='material-icons'>keyboard_arrow_down</i></div>";	

		$add_count_toggle = "<div id='add_count' style='display: inline;right: 105px;position: absolute;'></div>";

		// before and after widget arguments are defined by themes
		echo $args['before_widget']; 
		echo $args['before_title'] . '<span style="display: flex;"><span class="player-widget-title">' .$title .  '</span><span class="widget_after_title" style="margin-left: auto;">' . $add_count_toggle . $timer_track . $btn_toggle_down .  $btn_toggle_up . $shuffle_toggle . '</span></span>' . $args['after_title'];

		// Saved objects
		$matches = get_user_meta( user_if_login(), 'rs_saved_for_later', true );

		echo '<div id="player-container">';

    		if ( $shuffle == 1 ) {
			$saved_args = array(
				'post_type'      => 'music',
				'posts_per_page' => -1,
				'orderby' 	=> 'rand',
				'order' 	=> 'rand',
				'post__in'       => $matches,
			);
		} else {
			$saved_args = array(
				'post_type'      => 'music',
				'posts_per_page' => -1,
				'orderby' 	=> 'post__in',
				'order' 	=> 'DESC',
				'post__in'       => $matches,
			);
		}

		$loop = new WP_Query( $saved_args );

		if ($loop->have_posts()) :

			while ($loop->have_posts()) : $loop->the_post();

				$music_playlist = wp_get_attachment_url(get_post_meta( get_the_ID(), 'music_link_', true ));

				$urllocal = realpath(ABSPATH.explode(site_url(), $music_playlist )[1]); 

				$plugin_dir = site_url().'/wp-content/plugins/McPlayer/includes/download.php';
	
				$terms = wp_get_post_terms( get_the_ID(), 'artist' );

				$name = esc_attr( 'meta-box-media-cover_' );
				$value = $rawvalue = get_post_meta( get_the_ID(), $name, true );
				$attachment_title = get_the_title($value);
				$delimeter_player56s = esc_attr(' || ');

				$get_music_meta_length = get_post_meta( get_the_ID(), "meta-box-track-length", true );

				$get_music_meta_length_str = explode(":", $get_music_meta_length);

				$get_music_meta_length_str_minute = $get_music_meta_length_str[0]*60;
		
				$get_music_meta_length_str_seconde = $get_music_meta_length_str[1];
		
				$get_music_meta_length_str_full = $get_music_meta_length_str_minute+$get_music_meta_length_str_seconde;
				
				?><audio href="<?php echo $plugin_dir.'?path='.$urllocal; ?>" class="player56s" rel="playlist" data-length="<?php echo $get_music_meta_length_str_full; ?>" postid="<?php echo get_the_ID(); ?>"><?php
					echo $attachment_title;
					echo $delimeter_player56s;
					echo $terms[0]->name;
					echo $delimeter_player56s;
					echo get_the_title();
					echo $delimeter_player56s;
					echo wp_get_attachment_image_url( $value , 'full' );
				?></audio><?php 
									
			endwhile;
			
		else:
			echo '<audio href="#" class="player56s" rel="playlist" data-length="0" postid="0">Just another WordPress site || McPlayer || Nothing in the playlist || https://'. $_SERVER['SERVER_NAME'] .'/wp-content/plugins/McPlayer/public/css/blue-note.png</audio>';
		
		endif;
		
		wp_reset_postdata();
	
		echo '</div>';

		echo '<div id="player56s-ajax-wrap" style="display: none;">';
			echo '<div id="player56s-currenttrack"></div>';
			echo '<div id="player56s-addtrack"></div>';
			echo '<div id="player56s-removetrack"></div>';
			echo '<div id="player56s-removetracks-all"></div>';
			echo '<div id="player56s-playnow"></div>';
			echo '<div id="player56s-seek-percent"></div>';
			echo '<div id="player56s-seek-current-percent"></div>';
			echo '<div id="player56s-play-timer"></div>';
			echo '<div id="player56s-shuffle"></div>';
			echo '<div id="player56s-no-shuffle"></div>';
			echo '<div id="player56s-pause"></div>';
			echo '<div id="player56s-userid">' . user_if_login() . '</div>';
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