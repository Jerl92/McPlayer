<?php
//Example from Codex page : http://codex.wordpress.org/Function_Reference/add_submenu_page
//Add this in your functions.php file, or use it in your plugin

add_action('admin_menu', 'register_artist_submenu_page');

function register_artist_submenu_page() {
  add_submenu_page( 'edit.php?post_type=music', 'Bulk add artist', 'Bulk add artist', 'manage_options', 'bulk-add-artist', 'bulk_add_artist_submenu_page_callback' ); 
}

function bulk_add_artist_submenu_page_callback() {
        echo '<div class="wrap">';
        echo '</br>';
        echo '<input type="submit" value="Convert" id="artistbtn">';
        $get_posts = array(
			'post_type' => 'music',
			'posts_per_page' => -1,
            'orderby'          => 'rand',
            'order'            => 'rand',
		);
        $posts = get_posts($get_posts);
        echo '<table style="display:none;">';
        foreach ($posts as $post) {
            echo '<tr>';
            echo '<td class="postid">';
            echo $post->ID;
            echo '</td>';
            echo '<td>';
            echo get_the_title($post->ID);
            echo '</td>';
            echo '</tr>';
        }
        echo '</table>';
        echo '<div id="result"></div>';
	echo '</div>';
}

add_action( 'admin_footer', 'add_artist_javascript' ); // Write our JS below here
function add_artist_javascript() { ?>
	<script type="text/javascript" >
    function add_artist_data($) {

        $("#artistbtn").on( "click", function(event) {
		    event.preventDefault();
            

            var yourArray = [];
            $('.postid').each(function () {

                var postid = $(this).html();
                yourArray.push(postid);

            });

            var i,j, temporary = [], chunk = 1000;
            for (i = 0,j = yourArray.length; i < j; i += chunk) {
                temporary.push(yourArray.slice(i, i + chunk));
            }

            $.each(temporary, function(i, temporary_) {
                $.ajax({
                    url : ajaxurl,
                    data : {
                        action : 'add_artist',
                        postid : temporary_
                    },
                    method : 'POST',
                    success : function( response ){ 
                        console.log(response);
                        $("#result").append(response);
                    },
                    error : function(error){ 
                        console.log(error)
                    }
                })
            });

        });

    }
    jQuery(document).ready(function($) {
        add_artist_data($);
    });
	</script> <?php
}

add_action( 'wp_ajax_add_artist', 'add_artist' );
function add_artist() {

    $postids = $_POST['postid'];

    foreach ( $postids as $postid ) {
        $term_obj_list = get_the_terms( $postid, 'artist' );

        $cover_media_id = get_post_meta( $postid, "meta-box-media-cover_", true );
    
        foreach ($term_obj_list as $taxonomy) {
            $html[] .= $taxonomy->slug;
            update_post_meta($postid, 'meta-box-artist', $taxonomy->slug);
        }
    
        $html[] .= get_the_title($cover_media_id);
        update_post_meta($postid, "meta-box-media-cover-name", get_the_title($cover_media_id));
    }

    return wp_send_json ( $html  );
}

?>