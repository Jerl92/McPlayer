<?php

function mcplayer_register_playlist_widgets() {
	register_widget( 'MCPlayer_bottom_playlist_widget');
}
add_action( 'widgets_init', 'mcplayer_register_playlist_widgets' );

class MCPlayer_bottom_playlist_widget extends WP_Widget {
	 function MCPlayer_bottom_playlist_widget() {	
		// Instantiate the parent object
		parent::__construct(

			// Base ID of your widget
			'MCPlayer_bottom_playlist_widget', 

			// Widget name will appear in UI
			__('MC Playlist Widget', 'mcplayer'), 

			// Widget description
			array( 'description' => __( 'Sample widget based on WPBeginner Tutorial', 'sidr_widget_domain' ), ) 
		);

	}

	function widget( $args, $instance ) {

		$title = apply_filters( 'widget_title', $instance['title'] );

		echo $args['before_widget'];
		if ( ! empty( $title ) )
		echo $args['before_title'] . $title . $args['after_title'];
	
		if ( is_user_logged_in() ) {
	
			$matches = get_user_meta( get_current_user_id(), 'rs_saved_for_later', true );
			
			$args = array( 
				'posts_per_page' => -1,	
				'post_type' => 'music',
				'post__in' => $matches,
				'order'   => 'DESC',
				'orderby'   => 'post__in',
			);
			
			$loop = new WP_Query( $args );
	
			ob_start();

			if ( $loop->have_posts() ) : ?>
			
				<?php if ($matches) { ?>
				
					<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>

						<?php if ( in_array( get_the_ID(), $matches ) ) {  ?>
							
							<?php get_template_part( 'template-parts/page-music-archive-sidebar', get_post_format() ); ?>

						<?php } ?>
					
					<?php endwhile; // end of the loop. ?>
			
					<?php // woocommerce_product_loop_end(); ?>
			
					<?php wp_reset_postdata(); ?>

					<?php } ?>

				<?php echo '<div id="rs-saved-for-later-wrapper" class="noselect"><ul id="rs-saved-for-later" class="rs-saved-for-later">' . ob_get_clean() . '</ul></div>'; ?>

			<?php else : ?>

			<?php echo '<div id="rs-saved-for-later-wrapper" class="noselect"><ul id="rs-saved-for-later" class="rs-saved-for-later"><li style="text-align: center;">Nothing in the playlist</li></ul></div>'; ?>

			<?php endif;
			
			echo '<div id="remove-all-btn"><a href="#" class="rs-save-for-later-remove-all" data-nonce="' . wp_create_nonce( 'rs_save_for_later_remove_all' ) . '">Flush Playlist</a></div>';
			
			echo '</section>';
			
        } else {
			echo '<p class="nothing-saved">You don’t have access to the Playlist, You need to <a href="';
			echo wp_login_url( home_url() );
			echo '" title="Login">Login</a></p>';
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