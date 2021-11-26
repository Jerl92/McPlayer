<?php
//Example from Codex page : http://codex.wordpress.org/Function_Reference/add_submenu_page
//Add this in your functions.php file, or use it in your plugin

add_action('admin_menu', 'register_my_custom_submenu_page');

function register_my_custom_submenu_page() {
  add_submenu_page( 'edit.php?post_type=music', 'Bulk add album', 'Bulk add album', 'manage_options', 'bulk-add-album', 'bulk_add_album_submenu_page_callback' ); 
}

function bulk_add_album_submenu_page_callback() {
        echo '<div class="wrap">';
        echo '<div style="width: 50%; float: left;">';
		echo '<h2>Bulk add album</h2>';
        echo '</br>';
        $i = 1;
        $upload_dir = wp_upload_dir();
        $path_implode = $upload_dir['basedir'] . '/youtube-dl/';
        $allFiles = scandir($path_implode, SCANDIR_SORT_DESCENDING);
        $files = array_diff($allFiles, array('.', '..'));
        $files_ = array_reverse($files);
        echo '<table>';
        foreach ($files_ as $file) {
            $realpath = realpath($path_implode.'/'.$file);
            $pathinfo = pathinfo($realpath);
            if($pathinfo['extension'] == 'mp4') {
                echo '<tr><td>';
                echo '<input type="number" class="tracknumber" name="'.$realpath.'" value="'.$i.'" >';
                echo '</td>';
                echo '<td>';
                echo $file;
                echo '</tr></td>';
                $i++;
            }
        }
        echo '</table>';
        wp_nonce_field('artist-dropdown', 'dropdown-artist-nonce');
        $terms = get_terms( 'artist', 'hide_empty=0');
        if ( is_a( $terms, 'WP_Error' ) ) {
            $terms = array();
        }

        $object_terms = wp_get_object_terms( $post->ID, 'artist' );
        if ( is_a( $object_terms, 'WP_Error' ) ) {
            $object_terms = array();
        }
        echo '</br>';
        echo '<input type="submit" value="Convert" id="yblinksubmit">';
        echo '</br>';
        echo '</div>';
        echo '<div style="width: 50%; display: table; padding-top: 5%;">';
        echo "Artist:";
        echo '</br>';
        echo "<select id='artistoptions' name='customartist[]'>";
        foreach ( $terms as $term ) {
            if ( $term->parent == 0) {
                if ( in_array($term->term_id, $object_terms) ) {
                    echo "<option value='$term->term_id' selected='selected'>$term->name</option>";
                } else {
                    echo "<option value='$term->term_id'>$term->name</option>";
                }
            }
        }

        echo "</select><br />";
        echo '</br>';
        echo "Album:";
        echo '<div id="metabox_album_upload">';
        echo "<div class='image-preview'>$image</div>";
        echo '<br />';
        echo "<input type='hidden' id='cover'  class='small-text'       name='meta-box-media[$name]'            value='$value' />";
        echo "<input type='button' id='$name'        class='button meta-box-upload-button'        value='Upload' />";
        echo "<input type='button' id='$name-remove' class='button meta-box-upload-button-remove' value='Remove' />";
        echo '</div>';
        echo '</div>';
        

        echo '<div id="result"></div>';
	echo '</div>';
}

add_action( 'admin_footer', 'my_action_javascript' ); // Write our JS below here
function my_action_javascript() { ?>
	<script type="text/javascript" >
    function add_chart_data($) {

        $("#yblinksubmit").on( "click", function(event) {
		    event.preventDefault();
            

            $('input[type="number"].tracknumber').each(function () {
                console.log($(this).val());

                var path = $(this).attr('name');
                var number = $(this).val();
                var artist = $('#artistoptions').find(":selected").val(); 
                var cover = $('#cover').val();
                var data = {
                    'action': 'my_action',
                    'path': path,
                    'number': number,
                    'artist': artist,
                    'cover': cover
                };

                // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
                jQuery.post(ajaxurl, data, function(response) {
                    console.log(response);
                    $("#result").append(response);
                });
            });

        });

    }
    jQuery(document).ready(function($) {
        add_chart_data($);
    });
	</script> <?php
}

add_action( 'wp_ajax_my_action', 'my_action' );
function my_action() {
	global $wpdb; // this is how you get access to the database

    $link = $_POST['path'];
    $number = $_POST['number'];
    $artistid = $_POST['artist'];
    $cover = $_POST['cover'];

    $channel_value = 2;
    $rate_value = '44100';
    $codec_value = '.mp3';
    $norm_ = ' -c:a libvorbis -qscale:a 5 ';

    $path_parts = pathinfo($link);
    $upload_dir = wp_upload_dir();

    $sanitized_filename = remove_accents( $path_parts['basename'] ); // Convert to ASCII

    // Standard replacements
    $invalid = array(
        ' '   => '-',
        '%20' => '-',
        '_'   => '-',
    );
    $sanitized_filename = str_replace( array_keys( $invalid ), array_values( $invalid ), $sanitized_filename );

    $sanitized_filename = preg_replace('/[^A-Za-z0-9-\. ]/', '', $sanitized_filename); // Remove all non-alphanumeric except .
    $sanitized_filename = preg_replace('/\.(?=.*\.)/', '', $sanitized_filename); // Remove all but last .
    $sanitized_filename = preg_replace('/-+/', '-', $sanitized_filename); // Replace any more than one - in a row
    $sanitized_filename = str_replace('-.', '.', $sanitized_filename); // Remove last - if at the end
    $sanitized_filename = strtolower( $sanitized_filename ); // Lowercase

    $path_parts_sanitized = pathinfo($path_parts['dirname'].'/'.$sanitized_filename);

    copy($link, $path_parts['dirname'].'/'.$sanitized_filename);

    // $html = exec('ffmpeg -i ' . $link . ' ' .$path_parts['dirname'].'/'.$path_parts['filename'].'.'.$codec_value);

    shell_exec('ffmpeg -i '.$path_parts['dirname'].'/'.$sanitized_filename.' -vn -acodec libmp3lame -ac 2 -qscale:a 4 -ar 48000 '.$upload_dir['path'].'/'.$path_parts_sanitized['filename'].$codec_value); 
    
    $html[] .= $upload_dir['path'].'/'.$path_parts_sanitized['filename'].$codec_value;

    $image_url = $upload_dir['path'].'/'.$path_parts_sanitized['filename'].$codec_value;

    $upload_dir = wp_upload_dir();

    $image_data = file_get_contents( $image_url );

    $filename = basename( $image_url );

    if ( wp_mkdir_p( $upload_dir['path'] ) ) {
    $file = $upload_dir['path'] . '/' . $filename;
    }
    else {
    $file = $upload_dir['basedir'] . '/' . $filename;
    }

    file_put_contents( $file, $image_data );

    $wp_filetype = wp_check_filetype( $filename, null );

    $filename_strstr = explode('-', $path_parts['filename']);

    $attachment = array(
    'post_mime_type' => $wp_filetype['type'],
    'post_title' => sanitize_file_name( $filename_strstr[1] ),
    'post_content' => '',
    'post_status' => 'inherit'
    );

    $attach_id = wp_insert_attachment( $attachment, $file );
    require_once( ABSPATH . 'wp-admin/includes/image.php' );
    $attach_data = wp_generate_attachment_metadata( $attach_id, $file );
    wp_update_attachment_metadata( $attach_id, $attach_data );

    $html[] .= $attach_id;
    $html[] .= $attach_data;

    $new_post = array(
        'post_title' => $filename_strstr[1],
        'post_content' => '',
        'post_status' => 'publish',
        'post_author' => get_current_user_id(),
        'post_type' => 'music',
        'post_category' => array(0)
    );
    $post_id = wp_insert_post($new_post);

    $name = esc_attr('music_link_');
    add_post_meta( $post_id, $name, $attach_id);

    $value = $rawvalue = esc_attr(get_post_meta( $post_id, $name, true ));
    $image = ! $rawvalue ? '' : get_attached_file( $rawvalue );
    $metadata = wp_read_audio_metadata( $image );
    add_post_meta( $post_id, "meta-box-track-length", gmdate( "i:s", $metadata['length'] ) );

    add_post_meta($post_id, "meta-box-track-number", $number);

    $termartist = get_term_by('id', $artistid, 'artist');
    wp_set_object_terms($post_id, $termartist->slug, 'artist');

    update_post_meta( $post_id, 'meta-box-media-cover_', $cover);

    $term_obj_list = get_the_terms( $post_id, 'artist' );

    $cover_media_id = get_post_meta( $post_id, "meta-box-media-cover_", true );

    foreach ($term_obj_list as $taxonomy) {
        $html[] .= $taxonomy->slug;
        update_post_meta($post_id, 'meta-box-artist', $taxonomy->slug);
    }

    update_post_meta($post_id, "meta-box-media-cover-name", get_the_title($cover_media_id));

    $html[] .= '</br>';

    return wp_send_json ( $html );
}

?>