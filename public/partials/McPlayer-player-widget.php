<?php

function McPlayer_register_widgets() {
	register_widget( 'MCPlayer_bottom_player_widget');
}
add_action( 'widgets_init', 'McPlayer_register_widgets' );

class MCPlayer_bottom_player_widget extends WP_Widget {
	 function MCPlayer_bottom_player_widget() {	
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

		$btn_toggle = "<div id='btn_player_toggle' class='player_widget_name_hide_btn' style='padding-right: 5px' >&#129035;</div>";	
		
		$ogg_toggle = "<div id='ogg_player_toggle' class='player_widget_name_ogg' style='padding-right: 10px' >.OGG</div>";	

		$title_toggle = "<div id='title_player_toggle' class='player_widget_name' style='margin-left: auto; margin-right: auto;	display: inline;'>$title</div>";

		// before and after widget arguments are defined by themes
		echo $args['before_widget'];
		if ( ! empty( $title ) )
		echo $args['before_title'] . $title_toggle . $btn_toggle . $ogg_toggle . $args['after_title'];

		// This is where you run the code and display the output
		if ( is_user_logged_in() ) {
			global $post;

			// Saved objects
			$matches = get_user_meta( get_current_user_id(), 'rs_saved_for_later', true );

			echo '<div id="player-container">';

			if ( ! empty( $matches ) ) {
				$saved_args = array(
					'post_type'      => 'music',
					'posts_per_page' => -1,
					'orderby' => 'post__in',
					'post__in'       => array_reverse( $matches, true )
				);
			} else {
				$saved_args = 0;
			}

			$saved_loop = new WP_Query( $saved_args );

			if ( $saved_loop->have_posts() ) {

				while ( $saved_loop->have_posts() ) : $saved_loop->the_post();

					$music_playlist = wp_get_attachment_url(get_post_meta( $post->ID, 'music_link_', true ));

					$terms = wp_get_post_terms( $post->ID, 'artist' );

					$name = esc_attr( 'meta-box-media-cover_' );
					$value = $rawvalue = get_post_meta( $post->ID, $name, true );
					$attachment_title = get_the_title($value);
					$get_feat = get_post_meta( get_the_id(), "meta-box-artist-feat", true);
					$delimeter_player56s = esc_attr(' || ');

					$get_music_meta_length = get_post_meta( $post->ID, "meta-box-track-length", true );
					
					?><audio href="<?php echo $music_playlist; ?>" class="player56s" rel="playlist" data-length="<?php echo esc_attr($get_music_meta_length); ?>" postid="<?php echo $post->ID; ?>"><?php
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
				echo '<audio href="" class="player56s" postid="0"></audio>';
			}
		
			echo '<div id="player56s-ajax-wrap" style="display: none;">';
				echo '<div id="player56s-currenttrack"></div>';
				echo '<div id="player56s-addtrack"></div>';
				echo '<div id="player56s-removetrack"></div>';
				echo '<div id="player56s-removetracks-all"></div>';
				echo '<div id="player56s-playnow"></div>';
				echo '<div id="player56s-sortable"></div>';
			echo '</div>';

			echo '</div>';

		} else {
			echo '<p id="notlogin" class="nothing-saved">You don’t have access to the Player, You need to <a href="';
			echo wp_login_url( home_url() );
			echo '" title="Login">Login</a></br>This site is for personal use and development purposes.</p>';
		}

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