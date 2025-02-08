<?php

 
function myprefix_custom_cron_schedule( $schedules ) {
    $schedules['every_six_hours'] = array(
        'interval' => 43200, // Every 6 hours
        'display'  => __( 'Every 12 hours' ),
    );
    return $schedules;
}
add_filter( 'cron_schedules', 'myprefix_custom_cron_schedule' );

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

        $getcountplay = get_term_meta( $term->term_id, 'count_play_loop_' , true );
        if($getcountplay == null) {
            add_term_meta( $term->term_id, 'count_play_loop_' , array_sum($sum_count_play) );
        } else {
            update_term_meta( $term->term_id, 'count_play_loop_' , array_sum($sum_count_play) );
        }

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
        $get_earn_counts = get_term_meta($term->term_id, 'earn_play_loop', true);
        if(!empty($get_earn_counts)){
            foreach($get_earn_counts as $get_earn_count){
                $arrays_value += 1;
            }
        } else {
            $arrays_value = intval(0);
        }

        if(empty($get_counts)){
            $get_counts = [time() => $arrays_value];
            add_term_meta($term->term_id, 'count_play_loop', $get_counts);
        } else {
            $get_counts[time()] = $arrays_value;
            update_term_meta($term->term_id, 'count_play_loop', $get_counts);
        }
    }
}


?>