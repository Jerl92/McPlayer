<?php

// A callback function to add a custom field to our "presenters" taxonomy  
function presenters_taxonomy_custom_fields($tag) { 
    // Check for existing taxonomy meta for the term you're editing  
     $t_id = $tag->term_id; // Get the ID of the term you're editing
     $get_term_color = get_term_meta($t_id, 'meta_count_earn', true);
 ?>  
	
	<tr class="form-field">  
		<th scope="row" valign="top">  
		 	<label for="presenter_id"><?php _e('Earn for each play'); ?></label>  
		</th>  
		<td>  
			<?php if(current_user_can('artist')) {
				echo '<input type="text" name="none" id="none" value="'. $get_term_color .'" class="my-color-field" style="width: 75px;" step="0.0001" disabled></input>';
			} else {
				if($get_term_color == ''){
					echo '<input type="text" name="meta_color" id="meta_color" value="0.047" class="my-color-field" style="width: 75px;" step="0.0001"></input>';
				} else {
					echo '<input type="text" name="meta_color" id="meta_color" value="'. $get_term_color .'" class="my-color-field" style="width: 75px;" step="0.0001"></input>';
				} 
			} ?>
		</td>  
	</tr>
	
	<?php
 }  

 // A callback function to save our extra taxonomy field(s)  
 function save_taxonomy_custom_meta( $term_id ) {
	if(current_user_can('artist')) {
		return null;
	} elseif ( isset($_POST['meta_color']) && is_numeric($_POST['meta_color']) ) {
        	update_term_meta( $term_id, 'meta_count_earn', $_POST['meta_color'] );
    	} else {
    		if(!isset($_POST['meta_color']) && !is_numeric($_POST['meta_color'])) {
    			update_term_meta( $term_id, 'meta_count_earn', '0' );
    		} else {
    			wp_die('Not a valide numeric number for Earn for each play');
    		}
    	} 
} 

// Add the fields to the "presenters" taxonomy, using our callback function  
add_action( 'artist_edit_form_fields', 'presenters_taxonomy_custom_fields', 50, 2 );  
add_action( 'artist_add_form_fields', 'presenters_taxonomy_custom_fields', 50, 2 ); 

// Save the changes made on the "presenters" taxonomy, using our callback function  
add_action( 'edited_artist', 'save_taxonomy_custom_meta', 50, 2 ); 
add_action( 'create_artist', 'save_taxonomy_custom_meta', 50, 2 ); 

// A callback function to add a custom field to our "presenters" taxonomy  
function artist_count_taxonomy_custom_fields($tag) { 
 if($_GET['tag_ID']){
	?>  
	
	<tr class="form-field">  
	<th scope="row" valign="top">  
	 <label for="presenter_id"><?php _e('Total Earn'); ?></label>  
	</th>  
	<td>  
	<?php 
	
    	$args = array(
		'post_type' => 'music',
		'posts_per_page'  => -1,
		'tax_query' => array(
	            array(
	                'taxonomy' => 'artist',
	                'field' => 'term_id',
	                'terms' => $tag->term_id,
	            )
	        )
	);
	
	$get_posts = get_posts($args);
	
	$earn_play_loops = [];
	foreach($get_posts as $post){
       		$earn_play_loops_array = get_post_meta($post->ID, 'earn_play_loop', true );
	        if($earn_play_loops_array != '' || $earn_play_loops_array != null){
	            $earn_play_loops[] = get_post_meta($post->ID, 'earn_play_loop', true );
	        }
	}
	
	$loop = 0;
	foreach($earn_play_loops as $earn_play_loop){
		foreach ($earn_play_loop as $earn_play_loop_){
			$loop++;
		}
	}
	echo $loop . ' Plays';
	echo '<br>';
	echo '<br>';
	
	$i = 0;
	$userid = [];
	$ifpay = [];
	$earn = [];
	$ip = [];
	foreach ($earn_play_loops as $earn_play_loop){
	        foreach ($earn_play_loop as $earn_play_loop_){
		        $userid[$i] = $earn_play_loop_['userid'];
		        $postid = $earn_play_loop_['postid'];
		        $ifpay[$postid] = $earn_play_loop_['ifpay'];
		        $earn[$postid] = $earn_play_loop_['earn'];
		        $ip[$i] = $earn_play_loop_['ip'];
		        $i++;
	        }
	}
	
    $x = 0;
    $count_earn = 0;
    foreach ($ifpay as $key => $value){
        if($value == 'no'){
            $count_earn = $count_earn + $earn[$key];
            //$earn_play_loops[$x][0]['ifpay'] = 'yes';
        }
        $x++;
    }
    
    echo $count_earn.'$';
    echo '<br>';
    echo '<br>';
	
    $userid_count = array_count_values($userid);
    $ip_count = array_count_values($ip);
    arsort($userid_count);
    arsort($ip_count);
    foreach ($userid_count as $key => $value){
        $user = get_user_by( 'id', $key );
        if ( $user ) {
            $username = $user->user_login;
            $user_email = $user->user_email;
            $first_name = $user->user_firstname;
            $last_name  = $user->user_lastname;
            if($first_name == '' && $last_name == ''){
            	echo $username .' - '. $user_email . ' - ' . $value . ' Plays';
            } else {
            	echo $username .' - '. $first_name . ' '. $last_name . ' - ' . $user_email . ' - ' . $value . ' Plays';
            }
            echo '<br>';
        } else {
            $username = $key;
            echo $username . ' - ' . $value . ' Plays';
            echo '<br>';
        }
    }
    echo '<br>';
    foreach ($ip_count as $key => $value){
    	echo $key . ' - ' . $value . ' Plays';
    	echo '<br>';
    }
  }	
}  

// Add the fields to the "presenters" taxonomy, using our callback function  
add_action( 'artist_edit_form_fields', 'artist_count_taxonomy_custom_fields', 60, 2 );  
add_action( 'artist_add_form_fields', 'artist_count_taxonomy_custom_fields', 60, 2 ); 

?>