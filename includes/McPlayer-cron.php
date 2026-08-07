<?php

 
function myprefix_custom_cron_schedule( $schedules ) {
    $schedules['every_six_hours'] = array(
        'interval' => 43200, // Every 6 hours
        'display'  => __( 'Every 12 hours' ),
    );
    return $schedules;
}
add_filter( 'cron_schedules', 'myprefix_custom_cron_schedule' );

function every_week_cron_schedule( $schedules ) {
    $schedules['every_week'] = array(
        'interval' => 604800, // Every week
        'display'  => __( 'Every week' ),
    );
    return $schedules;
}
add_filter( 'cron_schedules', 'every_week_cron_schedule' );

add_action( 'init', function () {

    ///Hook into that action that'll fire every six hours
    add_action( 'myfunc_cron_hook', 'myprefix_cron_function' );

    //Schedule an action if it's not already scheduled
    if ( ! wp_next_scheduled( 'myfunc_cron_hook' ) ) {
        wp_schedule_event( time(), 'every_six_hours', 'myfunc_cron_hook' );
    }
});

//create your function, that runs on cron
function myprefix_cron_function() {

    $posttags = get_terms( 'artist', 'hide_empty=0');
    print_r($posttags);
    if ($posttags) {
      foreach($posttags as $tag) {

        echo $tag->term_id;

        print_r( $tag );

        $tagtermkey = get_term_meta( $tag->term_id, "my_term_key", true);

        $get_artist_count_songs = array( 
            'post_type' => 'music',
            'posts_per_page' => -1,
            'order' => 'DESC',
            'tax_query' => array(
                array(
                    'taxonomy' => 'artist',
                    'field'    => 'term_id',
                    'terms'    => array( $tag->term_id )
                )
            )
        ); 
    
        $get_count_songs = get_posts( $get_artist_count_songs );
    
        $get_meta_count_play_count = 0;
        foreach($get_count_songs as $get_count_song) {
            $get_meta_count_play_count += intval(get_post_meta( $get_count_song->ID, "count_play_loop", true ));
        }
    
        $res['date'] = date('d/m/y');
        $res['count'] = $get_meta_count_play_count;
    
        if($tagtermkey == null){
            $tagtermkey = array();
        }

        array_push($tagtermkey, $res);
        update_term_meta( $tag->term_id, "my_term_key" , $tagtermkey );

        print_r( $res ); 

      }
    }

}

add_action( 'init', function () {

    ///Hook into that action that'll fire every six hours
    add_action( 'artist_count_cron_hook', 'artist_count_cron_function' );

    //Schedule an action if it's not already scheduled
    if ( ! wp_next_scheduled( 'artist_count_cron_hook' ) ) {
        wp_schedule_event( time(), 'every_six_hours', 'artist_count_cron_hook' );
    }
});

//create your function, that runs on cron
function artist_count_cron_function() {

	$terms = get_terms( array(
		'taxonomy'   => 'artist',
		'hide_empty' => true,
	) );
	
    foreach($terms as $term){
        $get_songs_args = array(
            'post_type' => 'music',
            'posts_per_page' => -1,
            'order' => 'ASC',
            'tax_query' => array(
                array(
                    'taxonomy' => 'artist',
                    'field'    => 'slug',
                    'terms'    => $term->slug
                )
            )
        );

        $get_songs = get_posts($get_songs_args);

        echo $term->slug;

        echo "\n";

        echo count($get_songs);

        echo "\n";

        $x = 0;
        $sum_count_play = array();
        foreach($get_songs as $get_song){
            $sum_count_play[$x++] = get_post_meta( $get_song->ID , 'count_play_loop' , true );
        }

        echo array_sum($sum_count_play);

        echo "\n";

        echo "\n";

        update_term_meta( $term->term_id, 'count_play_loop_' , array_sum($sum_count_play));

    }

}

add_action( 'init', function () {

    ///Hook into that action that'll fire every six hours
    add_action( 'count_cron_hook', 'count_cron_function' );

    //Schedule an action if it's not already scheduled
    if ( ! wp_next_scheduled( 'count_cron_hook' ) ) {
        wp_schedule_event( time(), 'every_six_hours', 'count_cron_hook' );
    }
});

//create your function, that runs on cron
function count_cron_function() {

    $terms = get_terms( 'artist', 'hide_empty=0');

    foreach ($terms as $term){
        echo $term->name;
        $get_counts = get_term_meta($term->term_id, 'count_play_loop', true);
        $get_earns = get_term_meta($term->term_id, 'earn_play_loop', true );
        if(!empty($get_earns)){
            foreach($get_earns as  $get_earn){
                $arrays_value += 1;
            }
        } else {
            $arrays_value = intval(0);
        }
        
        $get_counts_ = array(date( 'Y-m-d H:i:s', current_time( 'timestamp' ) ), arrays_value);
        if(is_array($get_counts)){
        	array_push($get_counts, $get_counts_);
	        update_term_meta($term->term_id, 'count_play_loop', $get_counts);
        } else {
        	update_term_meta($term->term_id, 'count_play_loop', array($get_counts_));
        }
   
    }
}

add_action( 'init', function () {

    ///Hook into that action that'll fire every six hours
    add_action( 'album_score_hook', 'album_score_function' );

    //Schedule an action if it's not already scheduled
    if ( ! wp_next_scheduled( 'album_score_hook' ) ) {
        wp_schedule_event( time(), 'every_week', 'album_score_hook' );
    }
});

//create your function, that runs on cron
function album_score_function() {

	
	$terms = get_terms( array(
		'taxonomy'   => 'artist',
		'hide_empty' => true,
	) );
	
	$i = 0;
    	foreach($terms as $term){
	        $get_songs_args = array(
	            'post_type' => 'music',
	            'posts_per_page' => -1,
	            'order' => 'ASC',
	            'tax_query' => array(
	                array(
	                    'taxonomy' => 'artist',
	                    'field'    => 'slug',
	                    'terms'    => $term->slug
	                )
	            )
	        );

       		$get_songs[$i] = get_posts($get_songs_args);
       		
       		$i++;
        
        }

	foreach($get_songs as $get_song){
		foreach($get_song as $get_song_unique){
			$cover_media_id = get_post_meta( $get_song_unique->ID, "meta-box-media-cover_", true );
			$cover_media_ids[$cover_media_id][] = get_post_meta($get_song_unique->ID, 'song_score_unique', true);
		}
	}
	
	foreach($cover_media_ids as $key => $value){
		$i = 0;
		$calc_value_album = 0;
		foreach($value as $value_){
			foreach($value_ as $value__){
				if($value__[1] != ''){
					$calc_value_album = $calc_value_album + $value__[1];
					$i++;
				}
			}
		}
		$current_time = current_time( 'timestamp' );
		$calc_value_sum_album = $calc_value_album / $i;
		$calc_value_sum_album_round = number_format($calc_value_sum_album, 2);
		$new_array = array($current_time, $calc_value_sum_album_round);
		$album_score_unique = get_post_meta( $key, "album_score_unique", true );
		if(is_array($album_score_unique)){
			array_push($album_score_unique, $new_array);
			update_post_meta( $key, "album_score_unique", $album_score_unique );	
		} else {
			update_post_meta( $key, "album_score_unique", [$new_array] );	
		}
	}

}


?>