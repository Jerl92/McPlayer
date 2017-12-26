<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       jerl92.tk
 * @since      1.0.0
 *
 * @package    Mcplayer
 * @subpackage Mcplayer/public/partials
 */

    function McPlayer_widgets_init() {
        register_sidebar( array(
            'name' => __( 'off Sidebar', 'McPlayer' ),
            'id' => 'left-menu-widget',
            'description' => __( 'Appears on posts and pages except the optional Front Page template, which has its own widgets', 'twentytwelve' ),
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => '</aside>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>'
        ) );
    }

    add_action( 'widgets_init', 'McPlayer_widgets_init' );
?>
