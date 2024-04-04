<?php

function McPlayer_register_search_widgets() {
	register_widget( 'MCPlayer_search_widget');
}
add_action( 'widgets_init', 'McPlayer_register_search_widgets' );

class MCPlayer_search_widget extends WP_Widget {
	public function __construct() {
		// Instantiate the parent object
		parent::__construct(

			// Base ID of your widget
			'MCPlayer_search_widget', 

			// Widget name will appear in UI
			__('MC Seatch Widget', 'McPlayer'), 

			// Widget description
			array( 'description' => __( 'Sample widget based on WPBeginner Tutorial', 'sidr_widget_domain' ), ) 
		);

	}

	function widget( $args, $instance ) {

		$title = apply_filters( 'widget_title', $instance['title'] );

        echo $args['before_widget'];
		if ( ! empty( $title ) )
		echo $args['before_title'] . $title . $args['after_title'];
		
        echo '<section id="widget-mcplayer-search-ajax">';

        echo '<div class="search-container">';
            echo '<input id="target" type="text" placeholder="Search..." name="search" class="widget-mcplayer-search-input">';
            echo '<a href="" class="widget-mcplayer-search-a"><button type="submit" class="widget-mcplayer-search-button" style="min-width: 22.5%; margin-left: 2.5%;"><i class="fa fa-search"></i></button><a>';
        echo '</div>';

        echo '<div id="widget-mcplayer-search-result" style="display:none;"></div>';

		echo '</section>';
		
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
