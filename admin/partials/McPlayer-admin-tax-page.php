<?php

function timeToSeconds(string $time): int
{
    $arr = explode(':', $time);
    if (count($arr) === 3) {
        return $arr[0] * 3600 + $arr[1] * 60 + $arr[2];
    }
    return $arr[0] * 60 + $arr[1];
}

function counttime($time) {
    
    $totaltime = 0;
    
    foreach( $time as $element ) {
        
        // Converting the time into seconds
        $timeinsec = timeToSeconds($element);
        
        // Sum the time with previous value
        $totaltime = $totaltime + $timeinsec;
    }

    return date(" H:i:s", $totaltime);
}

add_action('admin_init', 'artist_admin_init');

function artist_admin_init() {
    $artist_taxonomies = get_taxonomies();
    if (is_array($artist_taxonomies)) {
        foreach ($artist_taxonomies as $artist_taxonomy) {
            add_filter('manage_edit-'.$artist_taxonomy.'_columns', 'artistTaxonomyColumns');
            add_filter('manage_'.$artist_taxonomy.'_custom_column', 'artistTaxonomyColumn', 10, 3 );
        }
    }
}

/**
 * Thumbnail column added to category admin.
 *
 * @access public
 * @param mixed $columns
 * @return void
 */
function artistTaxonomyColumns( $columns ) {
    $new_columns = array();
    unset($columns['cb']);
    unset($columns['thumb']);
    unset($columns['name']);
    unset($columns['description']);
    unset($columns['slug']);
    $new_columns['cb'] = __('Checkbox', 'McPlayer');
    $new_columns['thumb'] = __('Image', 'McPlayer');
    $new_columns['name'] = __('Name', 'McPlayer');
    $new_columns['description'] = __('Description', 'McPlayer');
    $new_columns['slug'] = __('slug', 'McPlayer');
    $new_columns['link'] = __('Private Page', 'McPlayer');

    return array_merge( $new_columns, $columns );
}

/**
 * Thumbnail column value added to category admin.
 *
 * @access public
 * @param mixed $columns
 * @param mixed $column
 * @param mixed $id
 * @return void
 */
function artistTaxonomyColumn( $columns, $column, $id ) {
    if ( $column == 'link' )
        $columns = '<a href="'.admin_url('edit.php?post_type=music&taxonomy=artist&tag_ID='.$id.'&page=artist-private-page').'" alt="' . __('Artist Private Page', 'McPayer') . '" class="wp-post-artist">Private Page</a>';
    
    return $columns;
}


add_action('admin_menu', 'register_artist_private_submenu_page');

function register_artist_private_submenu_page() {
  add_submenu_page( 'edit.php?post_type=music', 'Artist Private Page', 'Artist private page', 'manage_options', 'artist-private-page', 'artist_private_submenu_page_callback' ); 
  remove_submenu_page( 'edit.php?post_type=music', 'artist-private-page' );
}

function artist_private_submenu_page_callback() {
    $get_taxonomy = $_GET['taxonomy'];
    $Get_tag_ID = $_GET['tag_ID'];
    $posttype = $_GET['post_type'];
    $page = $_GET['page'];

    if($get_taxonomy == 'artist' && $posttype == 'music' && isset($Get_tag_ID)){
        ?><div class="full"><?php  
        echo '<div class="wraptax">';

                $i = 0;
                $x= 0;
                $sc = 0;
                $get_songs_args = array( 
                    'post_type' => 'music',
                    'posts_per_page' => -1,
                    'order' => 'DESC',
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'artist',
                            'field'    => 'term_id',
                            'terms'    => array( $Get_tag_ID )
                        )
                    )
                ); 

                $get_songs[$s++] = get_posts( $get_songs_args );


                if ( $get_songs ) {
                    foreach($get_songs as $get_song_){
                        $sc+= count($get_song_);
                        foreach ( $get_song_ as $get_song ) {
                            $get_songs_calc[$i++] =  seconds_from_time( get_post_meta(  $get_song->ID , 'meta-box-track-length' , true ));
                        }
                    }
                }

                $term = get_term( $Get_tag_ID );
                echo '<span class="artist_private_name">';
                    echo '<h1>'.$term->name.'</h1>';
                echo '</span>';

                echo '<div style="font-size: 16px;font-weight: 200;height: 30px;">';
                    echo 'Numbre of songs: ' . $sc;
                echo '</div>';
                echo '<div style="font-size: 16px;font-weight: 200;height: 30px;">';
                    echo 'Total time: ' . time_from_seconds ( array_sum($get_songs_calc) );
                echo '</div>';

            $get_artist_count_songs = array( 
                'post_type' => 'music',
                'posts_per_page' => -1,
                'order' => 'DESC',
                'tax_query' => array(
                    array(
                        'taxonomy' => 'artist',
                        'field'    => 'term_id',
                        'terms'    => array( $Get_tag_ID )
                    )
                )
            ); 

            $get_count_songs = get_posts( $get_artist_count_songs );

            $x = 0;
            $cpl = 0;
            $loop = 0;
            $get_meta_count_play = array();
            $get_meta_count_play_count = 0;
            foreach($get_count_songs as $get_count_song) {
                $get_meta_count_play_count += get_post_meta( $get_count_song->ID, "count_play_loop", true ); 
                $get_meta_count_play[$x] = get_post_meta( $get_count_song->ID, "count_play_loop", true ); 
                $get_meta_time_plays[$x] = get_post_meta( $get_count_song->ID, 'meta-box-track-length', true );
                $x++;
            }

            $x = 0;
            foreach($get_meta_time_plays as $get_meta_time_play) {
                for($i = 1; $i <= $get_meta_count_play[$x]; $i++){
                    $get_meta_time_play_array[] .= $get_meta_time_play;
                }
                $x++;
            }

            $my_term_money = get_term_meta( $Get_tag_ID, "my_term_money" , true );
            
            if($my_term_money != null){
                foreach($my_term_money as $tagmoney){
                    $tagmoneycount[] .= $tagmoney['count'];
                    if(isset($tagmoneycount)){
                        $my_term_money_end['count'] = array_sum($tagmoneycount);
                    }
                }   
            }

            $meta_count_earn = get_term_meta( $Get_tag_ID, 'meta_count_earn', true );

            echo '<h2>';
                echo 'Number of play: ';
                echo $get_meta_count_play_count;
            echo '</h2>';
            echo '<h2>';
                echo 'Played time: ';
                echo counttime($get_meta_time_play_array);
            echo '</h2>';
            echo '<h2>';
                echo 'Money earn: ';
                echo ($get_meta_count_play_count - $my_term_money_end['count'])*$meta_count_earn;
            echo '</h2>';
            if(($get_meta_count_play_count - $my_term_money_end['count']) != 0){
                echo "<input type='button' id='claimmoney'        class='button'        value='Claim Money' />";
            } else {
                echo "<input type='button' id='claimmoney_'        class='button'        value='Claim Money' disable />";
            }

            echo '<h2>';
                echo 'Total Money earn: ';
                foreach($my_term_money as $my_term_money_){
                    $termmoney[] .= $my_term_money_['money'];
                }
                echo array_sum($termmoney);
            echo '</h2>';

            $users = get_users();
            foreach($users as $user){
                if($user->user_login != ''){
                    $userid = $user->ID;
                    $get_saved_played = get_user_meta( $userid, 'rs_saved_played', true );
    
                    if($get_saved_played){
                        $get_songs_args = array(
                            'post_type' => 'music',
                            'posts_per_page' => -1,
                            'order' => 'ASC',
                            'orderby' => 'post__in',
                            'post__in' => $get_saved_played
                        );
            
                        $get_songs = get_posts($get_songs_args);
                    } else {
                        $get_songs = array();
                    }
    
                    $array_count_user_artist[] = null;
                    $count_artist_user_count = 0;
                    foreach($get_songs as $get_song) {
                        $term_names = wp_get_post_terms($get_song->ID, 'artist', array('fields' => 'ids'));
    
                        if ( ! empty( $term_names ) ) {
                            if( $term_names[0] == $Get_tag_ID ){
                                $count_artist_user_count += 1;
                            }
                        }
                    }
    
                    $res['count'] = intval($count_artist_user_count);
                    $res['id'] = intval($userid);
    
                    array_push($array_count_user_artist, $res);
                }
            }

            rsort($array_count_user_artist);

            foreach($array_count_user_artist as $res) {
                $user = get_user_by('id', $res['id']);
                if($user){
                    if($res['count'] != 0){
                        echo $user->user_login;
                        echo ' - ';
                        echo $res['count'];
                        echo '</br>';
                    }
                }
            }

            echo '</div>';

            ?><div id="chart-container">
                <canvas id="graphCanvas"></canvas>
                <canvas id="graphCanvasMoney"></canvas>
            </div><?php

        ?></div><?php


    } else {

    }

    }

        // Add the fields to the "presenters" taxonomy, using our callback function  
    add_action( 'artist_edit_form_fields', 'artist_private_submenu_page_callback', 1000, 1000 );  
    add_action( 'artist_add_form_fields', 'artist_private_submenu_page_callback', 1000, 1000 ); 

    add_action( 'admin_footer', 'my_chartContainer' ); // Write our JS below here
    function my_chartContainer() { ?>
        <script type="text/javascript" >

            jQuery.urlParam = function(name){
                var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
                if (results==null) {
                return null;
                }
                return decodeURI(results[1]) || 0;
            }

            jQuery(document).ready(function($) {
                $("#claimmoney").on( "click", function(event) {
                    var data = {
                        'tagid': jQuery.urlParam('tag_ID'),
                        'action': 'claim_money'
                    };
        
                    // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
                    jQuery.post(ajaxurl, data, function(response) {
                        console.log(response);
                    });
                });
            });

            jQuery(document).ready(function ($) {
                var data = {
                    'tagid': jQuery.urlParam('tag_ID'),
                    'action': 'fecth_graph'
                };
    
                // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
                jQuery.post(ajaxurl, data, function(response) {
                    console.log(response);
                    var datevalues = [];
                    var countvalues = [];
                    response.forEach(function(element, index) {
                        datevalues.push(element['date']);
                        countvalues.push(element['count']);
                    }, this); 
                    var chartdata = {
                        labels: datevalues,
                        datasets: [
                            {
                                label: 'Play counts',
                                backgroundColor: '#49e2ff',
                                borderColor: '#46d5f1',
                                hoverBackgroundColor: '#CCCCCC',
                                hoverBorderColor: '#666666',
                                data: countvalues
                            }
                        ]
                    };
        
                    var graphTarget = $("#graphCanvas");
        
                    var barGraph = new Chart(graphTarget, {
                        type: 'bar',
                        data: chartdata
                    });
                });

                var data = {
                    'tagid': jQuery.urlParam('tag_ID'),
                    'action': 'fecth_graph_money'
                };
    
                // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
                jQuery.post(ajaxurl, data, function(response) {
                    console.log(response);
                    var datevalues = [];
                    var countvalues = [];
                    response.forEach(function(element, index) {
                        datevalues.push(element['count']);
                        countvalues.push(element['money']);
                    }, this); 
                    var chartdatamoney = {
                        labels: datevalues,
                        datasets: [
                            {
                                label: 'Money Whitdraw',
                                backgroundColor: '#49e2ff',
                                borderColor: '#46d5f1',
                                hoverBackgroundColor: '#CCCCCC',
                                hoverBorderColor: '#666666',
                                data: countvalues
                            }
                        ]
                    };
        
                    var graphTargetMoney = $("#graphCanvasMoney");
        
                    var barGraph = new Chart(graphTargetMoney, {
                        type: 'bar',
                        data: chartdatamoney
                    });
                });
            });
        </script> <?php
    }

    add_action( 'wp_ajax_claim_money', 'claim_money' );
    function claim_money() {
        $Get_tag_ID  = $_POST['tagid'];

        $tagtermkeymoney = get_term_meta( $Get_tag_ID, "my_term_money", true);

        $get_artist_count_songs = array( 
            'post_type' => 'music',
            'posts_per_page' => -1,
            'order' => 'DESC',
            'tax_query' => array(
                array(
                    'taxonomy' => 'artist',
                    'field'    => 'term_id',
                    'terms'    => array( $Get_tag_ID )
                )
            )
        ); 

        $get_count_songs = get_posts( $get_artist_count_songs );

        $get_meta_count_play_count = 0;
        foreach($get_count_songs as $get_count_song) {
            $get_meta_count_play_count += get_post_meta( $get_count_song->ID, "count_play_loop", true ); 
        }

        if($tagtermkeymoney == null){
            $tagtermkeymoney = array();
        }

        $my_term_money_end = end($tagtermkeymoney);

        $meta_count_earn = get_term_meta( $Get_tag_ID, 'meta_count_earn', true );

        if($tagtermkeymoney != null){
            foreach($tagtermkeymoney as $tagmoney){
                $tagmoneycount[] .= $tagmoney['count'];
                if(isset($tagmoneycount)){
                    $res['count'] = $get_meta_count_play_count - array_sum($tagmoneycount);
                    $res['money'] = ($get_meta_count_play_count - array_sum($tagmoneycount))*$meta_count_earn;
                }
            }   
        } else {
            $res['count'] = $get_meta_count_play_count;
            $res['money'] = $get_meta_count_play_count*$meta_count_earn;
        }

        if($res['money'] != 0){
            array_push($tagtermkeymoney, $res);
            update_term_meta( $Get_tag_ID, "my_term_money" , $tagtermkeymoney );
        }

        // update_term_meta( $Get_tag_ID, "my_term_money" , null );

        return wp_send_json ( $tagtermkeymoney ); 
    }

    add_action( 'wp_ajax_fecth_graph_money', 'fecth_graph_money' );
    function fecth_graph_money() {
        $Get_tag_ID  = $_POST['tagid'];

        $tagtermkeymoney = get_term_meta( $Get_tag_ID, "my_term_money", true);

        return wp_send_json ( $tagtermkeymoney ); 
    }

    add_action( 'wp_ajax_fecth_graph', 'fecth_graph' );
    function fecth_graph() {
        $Get_tag_ID  = $_POST['tagid'];

        $tagtermkey = get_term_meta( $Get_tag_ID, "my_term_key", true);

        return wp_send_json ( $tagtermkey ); 
    }
?>
