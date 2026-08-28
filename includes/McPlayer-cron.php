<?php

 
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
    add_action( 'artist_count_shortcode_hook', 'artist_count_shortcode_function' );

    //Schedule an action if it's not already scheduled
    if ( ! wp_next_scheduled( 'artist_count_shortcode_hook' ) ) {
        wp_schedule_event( time(), 'every_week', 'artist_count_shortcode_hook' );
    }
});

//create your function, that runs on cron
function artist_count_shortcode_function() {

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

        $x = 0;
        $sum_count_play = [];
        foreach($get_songs as $get_song){
            $sum_count_play[$x++] = get_post_meta( $get_song->ID , 'count_play_loop' , true );
        }

        update_term_meta( $term->term_id, 'count_play_loop' , array_sum($sum_count_play));

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

       		$get_songs[$term->slug] = get_posts($get_songs_args);
        }

	$i = 0;
	foreach($get_songs as $get_song){
		foreach($get_song as $get_song_unique){
			$cover_media_id = get_post_meta( $get_song_unique->ID, "meta-box-media-cover_", true );
            $get_songs_scores_ = get_post_meta($get_song_unique->ID , 'song_score_unique' , true );
            if($get_songs_scores_ == ''){
                $get_songs_scores_ = array(1, 0);
            }
			$cover_media_ids[$cover_media_id][$i] = $get_songs_scores_;
			$i++;
		}
	}
	
	foreach($cover_media_ids as $key => $value){
		$i = 0;
		$calc_value_album = 0;
		foreach($value as $value_){
			foreach($value_ as $value__){
				$calc_value_album = $calc_value_album + $value__[1];
				$i++;
			}
		}
		$album_score_unique = get_post_meta( $key, "album_score_unique", true );
		if(is_array($album_score_unique)){
			$current_time = current_time( 'timestamp' );
			$calc_value_sum_album = $calc_value_album / $i;
			$calc_value_sum_album_round = number_format($calc_value_sum_album, 2);
			$new_array = array($current_time, $calc_value_sum_album_round);
			array_push($album_score_unique, $new_array);
			update_post_meta( $key, "album_score_unique", $album_score_unique );	
		} else {
			$current_time = current_time( 'timestamp' );
			$calc_value_sum_album = $calc_value_album / $i;
			$calc_value_sum_album_round = number_format($calc_value_sum_album, 2);
			$new_array = array($current_time, $calc_value_sum_album_round);
			update_post_meta( $key, "album_score_unique", [$new_array] );	
		}
	}
}

add_action( 'init', function () {

    ///Hook into that action that'll fire every six hours
    add_action( 'album_count_hook', 'album_count_function' );

    //Schedule an action if it's not already scheduled
    if ( ! wp_next_scheduled( 'album_count_hook' ) ) {
        wp_schedule_event( time(), 'every_week', 'album_count_hook' );
    }
});

//create your function, that runs on cron
function album_count_function() {

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
        
        $i = 0;
	foreach($get_songs as $get_song_){
        	foreach($get_song_ as $get_song){
	        
	        	$get_cover_id = get_post_meta($get_song->ID, 'meta-box-media-cover_', true);
	        	$get_cover_ids[$get_cover_id][$i] = $get_song->ID;
	        	$i++;
	        	
        	}
        }
        
        $i = 0;
        foreach($get_cover_ids as $key => $value){
        	foreach($value as $value_){
			$count_play_loops[$key][$i] = get_post_meta( $value_, "count_play_loop", true);
			$i++;
		}
		        
        }
        
        foreach($count_play_loops as $key => $value){

		$count_play_sum = array_sum($value);
		$count_play_loop_sum[$key] = $count_play_sum;

	}
	
	foreach($count_play_loop_sum as $key => $value){
	
		$current_time = current_time( 'timestamp' );
	
		$album_count_play_loop = get_post_meta($key, 'album_count_play_loop', true);
	
		if(is_array($album_count_play_loop)){
			$new_array = array($current_time, $value);
			array_push($album_count_play_loop, $new_array);
			update_post_meta($key, 'album_count_play_loop', $album_count_play_loop);
		} else {
			$new_array = array($current_time, $value);
			update_post_meta($key, 'album_count_play_loop', [$new_array]);
		}
		       
	}   
}

add_action( 'init', function () {

    ///Hook into that action that'll fire every six hours
    add_action( 'unique_score_hook', 'unique_score_function' );

    //Schedule an action if it's not already scheduled
    if ( ! wp_next_scheduled( 'unique_score_hook' ) ) {
        wp_schedule_event( time(), 'every_week', 'unique_score_hook' );
    }
});

//create your function, that runs on cron
function unique_score_function() {

        $get_songs_args = array(
            'post_type' => 'music',
            'posts_per_page' => -1,
            'order' => 'ASC',
        );

        $get_songs = get_posts($get_songs_args);

	foreach($get_songs as $get_song){
		$i = 0;
		$calcvalue = 0;
		$unique_score_unique = get_post_meta( $get_song->ID , "unique_score_array", true );
		$song_score_uniques = get_post_meta($get_song->ID, 'song_score_unique', true);
		foreach($song_score_uniques as $key => $value){
			$calcvalue = $calcvalue + $value[1];
			$i++;
		}
		if($i == 0){
			$calcvaluemoyenne = 0;
		} else {
			$calcvaluemoyenne = $calcvalue / $i;
		}
		$calcvaluemoyenne_format = number_format($calcvaluemoyenne, 2);
		$current_time = current_time( 'timestamp' );
		$new_array = array($current_time, $calcvaluemoyenne_format);
		if(is_array($unique_score_unique)){
			array_push($unique_score_unique, $new_array);
			update_post_meta( $get_song->ID , "unique_score_array", $unique_score_unique );
		} else {
			update_post_meta( $get_song->ID , "unique_score_array", [$new_array] );
		}
	}
}

add_action( 'init', function () {

    ///Hook into that action that'll fire every six hours
    add_action( 'unique_count_hook', 'unique_count_function' );

    //Schedule an action if it's not already scheduled
    if ( ! wp_next_scheduled( 'unique_count_hook' ) ) {
        wp_schedule_event( time(), 'every_week', 'unique_count_hook' );
    }
});

//create your function, that runs on cron
function unique_count_function() {

	$get_songs_args = array(
            'post_type' => 'music',
            'posts_per_page' => -1,
            'order' => 'ASC',
        );

        $get_songs = get_posts($get_songs_args);

	foreach($get_songs as $get_song){
	
		$unique_count_play_loop = get_post_meta($get_song->ID, 'unique_count_play_loop', true);
		$count_play_loop = get_post_meta($get_song->ID, 'count_play_loop', true);
		$current_time = current_time( 'timestamp' );
		
		$new_array = array($current_time, $count_play_loop);
		if(is_array($unique_count_play_loop)) {
			array_push($unique_count_play_loop, $new_array);
			update_post_meta($get_song->ID, 'unique_count_play_loop', $unique_count_play_loop);
		} else {
			update_post_meta($get_song->ID, 'unique_count_play_loop', [$new_array]);
		}
	
	}
	
}

add_action( 'init', function () {

    ///Hook into that action that'll fire every six hours
    add_action( 'artist_score_hook', 'artist_score_function' );

    //Schedule an action if it's not already scheduled
    if ( ! wp_next_scheduled( 'artist_score_hook' ) ) {
        wp_schedule_event( time(), 'every_week', 'artist_score_hook' );
    }
});

//create your function, that runs on cron
function artist_score_function() {
	
	$terms = get_terms( array(
		'taxonomy'      => 'artist',
		'hide_empty'    => true,
	) );

	foreach($terms as $term) {
		$args = array(
			'post_type' => 'music',
			'posts_per_page' =>  -1,
			'tax_query' => array(
				array(
					'taxonomy' => 'artist',
					'field'    => 'name',
					'terms'    => $term->name,
				),
			
			),
		);
		
		$get_artists_posts[$term->term_id] = get_posts($args);	
	}
	
	foreach($get_artists_posts as $key => $value) {
		$i = 0;
		$get_songs_scores = [];
		foreach($value as $get_song) {
	                $get_songs_scores_ = get_post_meta($get_song->ID , 'song_score_unique' , true );
	                if($get_songs_scores_ == ''){
	                    $get_songs_scores_ = array(0, 0);
	                }
			$get_songs_scores[$i] = $get_songs_scores_;
			$i++;
		}
		$x = 0;
	    	$calcvalue = 0;
		foreach ($get_songs_scores as $score_song) {
			foreach ($score_song as $score) {
				$calcvalue = $calcvalue + $score[1];
				$x++;
			}
		}
		$artist_score_unique = get_term_meta( $key , "artist_score_array", true );
		$get_songs_scores_calc = $calcvalue / $x;
		$get_songs_scores_calc_round = number_format($get_songs_scores_calc, 2);
		$current_time = current_time( 'timestamp' );
		$new_array = array($current_time, $get_songs_scores_calc_round);
		if(is_array($artist_score_unique)){
			array_push($artist_score_unique, $new_array);
			update_term_meta( $key , "artist_score_array", $artist_score_unique );
		} else {
			update_term_meta( $key , "artist_score_array", [$new_array] );
		}
	}

}

add_action( 'init', function () {

    ///Hook into that action that'll fire every six hours
    add_action( 'artist_count_hook', 'artist_count_function' );

    //Schedule an action if it's not already scheduled
    if ( ! wp_next_scheduled( 'artist_count_hook' ) ) {
        wp_schedule_event( time(), 'every_week', 'artist_count_hook' );
    }
});

//create your function, that runs on cron
function artist_count_function() {

	$terms = get_terms( array(
		'taxonomy'      => 'artist',
		'hide_empty'    => true,
	) );

	foreach($terms as $term) {
		$args = array(
			'post_type' => 'music',
			'posts_per_page' =>  -1,
			'tax_query' => array(
				array(
					'taxonomy' => 'artist',
					'field'    => 'name',
					'terms'    => $term->name,
				),
			
			),
		);
		
		$get_artists_posts[$term->term_id] = get_posts($args);	
	}
	
	foreach($get_artists_posts as $key => $value) {
		$i = 0;
		$get_songs_count_play = [];
		foreach($value as $get_song) {
	                $get_songs_count_play_ = get_post_meta($get_song->ID , 'count_play_loop' , true );
	                if($get_songs_count_play_ == ''){
	                    $get_songs_count_play_ = 0;
	                }
			$get_songs_count_play[$i] = intval($get_songs_count_play_);
			$i++;
		}
	    	$countplay = 0;
		foreach ($get_songs_count_play as $count_play) {
			$countplay = $countplay + intval($count_play);
		}
		$artist_count_play = get_term_meta( $key , "artist_count_play_loop", true );
		$current_time = current_time( 'timestamp' );
		$new_array = array($current_time, intval($countplay));
		if(is_array($artist_count_play)){
			array_push($artist_count_play, $new_array);
			update_term_meta( $key , "artist_count_play_loop", $artist_count_play );
		} else {
			update_term_meta( $key , "artist_count_play_loop", [$new_array] );
		}
	}
	
}


?>