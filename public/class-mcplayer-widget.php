<?php 

function mcplayer_widgets_init() {
	register_sidebar( array(
		'name' => __( 'off Sidebar', 'mcplayer' ),
		'id' => 'left-menu-widget',
		'description' => __( 'Appears on posts and pages except the optional Front Page template, which has its own widgets', 'twentytwelve' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>'
	) );
}

add_action( 'widgets_init', 'mcplayer_widgets_init' );

?>