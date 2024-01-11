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
    add_action( 'myprefix_cron_hook', 'myprefix_cron_function' );

    //Schedule an action if it's not already scheduled
    if ( ! wp_next_scheduled( 'myprefix_cron_hook' ) ) {
        wp_schedule_event( time(), 'every_six_hours', 'myprefix_cron_hook' );
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

?>