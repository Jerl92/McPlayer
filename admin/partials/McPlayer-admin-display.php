<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       jerl92.tk
 * @since      1.0.0
 *
 * @package    Mcplayer
 * @subpackage Mcplayer/admin/partials
 */

 /*
 * @param string $name Name of option or name of post custom field.
 * @param string $value Optional Attachment ID
 * @return string HTML of the Upload Button
 */

    // The JavaScript
    add_action( 'wp_ajax_track_length', 'ajax_track_length_json' );
    add_action( 'wp_ajax_nopriv_track_length', 'ajax_track_length_json' );
    // The function that handles the AJAX request
    function ajax_track_length_json() {
        $matche = $_POST['object_id'];
       
        $value = $rawvalue = esc_attr(get_post_meta( $post->ID, 'music_link_', true ));		
        $image = ! $rawvalue ? '' : get_attached_file( $rawvalue );

        $metadata = wp_read_audio_metadata( $image );
        $track_length = gmdate( "i:s", $metadata['length'] );
        $html = $track_length;

        $name = esc_attr('music_link_');
        $link = get_post_meta( $matche, $name, true );
        echo $link;
        return wp_send_json ( $link );
    }
?>
