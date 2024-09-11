
<?php

add_action('admin_menu', 'register_genre_add_submenu_page');


function register_genre_add_submenu_page() {
  add_submenu_page( 'edit.php?post_type=music', 'Genre add Page', 'Genre add page', 'manage_options', 'genre-add-page', 'genre_add_submenu_page_callback' ); 
  remove_submenu_page( 'edit.php?post_type=music', 'artist-private-page' );
}


function genre_add_submenu_page_callback() {
        echo '<input type="submit" id="genreaddsubmit">';
}


add_action( 'admin_footer', 'my_javascript' ); // Write our JS below here
function my_javascript() { ?>
    <script type="text/javascript" >


    function url_error($, element) {


        var data = {
            'action': 'url_error_genre',
            'postid': element
        };


        // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
        jQuery.post(ajaxurl, data, function(response) {
            console.log(response);
        });
    }


    function url_fetch($) {


        var data = {
            'action': 'my_fetch_genre'
        };


        // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
        jQuery.post(ajaxurl, data, function(response) {
            console.log(response);
            response.forEach(function(element, index) {
                setTimeout(function() {url_error($, element);}, index*500);
            }, this);
        });
        
    }


    jQuery(document).ready(function($) {
        $("#genreaddsubmit").on( "click", function(event) {
            url_fetch($);
        });
    });
    </script> <?php
}


add_action( 'wp_ajax_my_fetch_genre', 'my_fetch_genre' );
function my_fetch_genre() {




    $x = 0;
    $get_songs_args = array( 
        'post_type' => 'music',
        'posts_per_page' => 5000,
        'orderby'           => 'date',
        'order'             => 'ASC'
    ); 


    $posts = get_posts( $get_songs_args );


    foreach($posts as $post){


        $html[$x] = $post->ID;
        $x++;


    }


    return wp_send_json ( $html );
}

add_action( 'wp_ajax_url_error_genre', 'url_error_genre' );
function url_error_genre() {


    $postid = $_POST['postid'];

    $terms_obj_list = get_the_terms( $postid, 'artist' );

    foreach($terms_obj_list as $term_obj_list){
        $term_artist = $term_obj_list;
    }

    $result = shell_exec('sh /var/www/mcplayer.ca/wp-content/plugins/McPlayer/admin/partials/spotify.sh'.' '.$term_artist->slug);

    $json_decode = json_decode($result);

    $artists_items = $json_decode->artists->items;

    foreach($artists_items as $artists_item){
        $artist_item[] = $artists_item;
    }
    
    $terms = get_terms( 'genre', 'hide_empty=0');

    $html = $artist_item[0]->genres;

    foreach($html as $genre){
        $allready = 0;
        foreach($terms as $term){
            if ($genre === $term->name) {
                $allready = 1;
            } 
            if ($allready == 0) {
                $str = str_replace(" ", "-", $genre);
                $str_ = str_replace("/", "-", $str);
                wp_create_term($genre, 'genre');
            }
            if ($genre == $term->name) {
                $name_[$x] = $genre;
                $html_[$x] = $term->term_id;
            }
            $x++;
        }
    }

    wp_set_object_terms($postid, $html_, 'genre');

    return wp_send_json( $html );

}

?>