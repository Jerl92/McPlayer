<?php

add_action('admin_menu', 'register_genre_add_submenu_page');


function register_genre_add_submenu_page() {
  add_submenu_page( 'edit.php?post_type=music', 'Genre add Page', 'Genre add page', 'manage_options', 'genre-add-page', 'genre_add_submenu_page_callback' );
}


function genre_add_submenu_page_callback() {
        echo '<br>';
        echo '<button id="genreaddsubmit">start</button>';
        echo '<div id="genreaddbox"></div>';
}


add_action( 'admin_footer', 'my_javascript' ); // Write our JS below here
function my_javascript() { ?>
    <script>

    function url_error($, element) {

    $.ajax({
        url: '<?php echo admin_url("admin-ajax.php"); ?>', // or use a localized script variable
        type: 'POST',
        dataType: 'json', // Expecting a JSON response
        data: {
            action: 'url_error_genre', // The action hook name for PHP
            'postid': element
        },
        success: function(response) {
            console.log(response); // The 'response' will be a JSON object
            $('#genreaddbox').append(element);
            $('#genreaddbox').append(response);
            $('#genreaddbox').append('<br>');
        },
        error: function(xhr, textStatus, errorThrown) {
            $('#genreaddbox').append('AJAX error:'+ textStatus + errorThrown);
        }
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
        'order'             => 'DESC'
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

    // $result = shell_exec('sh ' . plugin_dir_path( __FILE__ ) . 'spotify.sh' . ' ' . $term_artist->slug);
    
    $response = file_get_contents('https://tivomusicapi-staging-elb.digitalsmiths.net/sd/tivomusicapi/taps/v3/search/artist?name=' . $term_artist->slug);

    $data = get_object_vars($response);

    // $artists_items = $data['hits']['musicGenres'];
    /*
    $x = 0;
    foreach($artists_items as $artists_item){
        $html[$x] = $artists_item['name'];
        $x++;
    }

    $terms = get_terms( 'genre', 'hide_empty=0');

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
    */
    wp_send_json($response);

}

?>