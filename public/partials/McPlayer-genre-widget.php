<?php

function McPlayer_register_genre_widgets() {
	register_widget( 'MCPlayer_bottom_genre_widget');
}
add_action( 'widgets_init', 'McPlayer_register_genre_widgets' );

class MCPlayer_bottom_genre_widget extends WP_Widget {
	public function __construct() {
		// Instantiate the parent object
		parent::__construct(

			// Base ID of your widget
			'MCPlayer_bottom_genre_widget', 

			// Widget name will appear in UI
			__('MC genre Widget', 'McPlayer'), 

			// Widget description
			array( 'description' => __( 'Sample widget based on WPBeginner Tutorial', 'sidr_widget_domain' ), ) 
		);

	}

	function sort_cb($a, $b) {
		return count($b) - count($a);
	}

	function widget( $args, $instance ) {

		$title = apply_filters( 'widget_title', $instance['title'] );

        $matches = get_user_meta( user_if_login(), 'rs_saved_for_later', true );
		$matches = array_filter($matches);

		echo $args['before_widget'];
		if ( ! empty( $title ) )
		echo $args['before_title'] . $title . $args['after_title'];
		
		if ( ! empty( $matches ) ) {
			$args_ = array( 
				'posts_per_page' => -1,	
				'post_type' => 'music',
				'post__in' => $matches,
				'order'   => 'DESC',
				'orderby'   => 'post__in',
			);
		} else {
			$args_ = 0;
		}
		
		$the_query_posts = get_posts( $args_ );

		$x = 0;
		foreach($the_query_posts as $the_query_post){
			foreach ( get_the_terms( $the_query_post->ID, 'genre' ) as $tax ) {
				$taxname[$x] = $tax->name;
				$taxid[$x] = $tax->term_id;
				$x++;
			}
		}

		$taxname_count = array_count_values($taxname);
		$taxid_count = array_count_values($taxid);

		arsort($taxname_count);
		arsort($taxid_count);

		echo '<div class="genre_widget">';
        if ( ! empty( $matches ) ) {
            for ($x = 0; $x <= 12; $x++) {
				$value = get_term_link( key($taxid_count), 'genre' );
				if(!is_wp_error( $value )){
					echo '<a href="'.get_term_link( intval(key($taxid_count)), 'genre' ).'">'.key($taxname_count).'</a>'.' ';
					next($taxname_count);
					next($taxid_count);
				}
            }
        } else {
            echo '<li style="text-align: center; padding:15px 0; list-style-type:none;">Nothing in the playlist</li>';
        }
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
