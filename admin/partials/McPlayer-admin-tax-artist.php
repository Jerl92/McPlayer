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
	
	$i = 0;
	$earn_play_loops = [];
	foreach($get_posts as $post){
       		$earn_play_loops_array = get_post_meta($post->ID, 'earn_play_loop', true );
	        if($earn_play_loops_array != '' || $earn_play_loops_array != null){
	            $earn_play_loops[$i] = get_post_meta($post->ID, 'earn_play_loop', true );
	            $i++;
	        }
	}
	
	$loop = 0;
	foreach ($earn_play_loops as $earn_play_loop_){
		foreach ($earn_play_loop_ as $earn_play_loop){
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
	$earn_ = [];
	$ip = [];
	foreach ($earn_play_loops as $earn_play_loop_){
		foreach ($earn_play_loop_ as $earn_play_loop){
		        $userid[$i] = $earn_play_loop['userid'];
		        $postid = $earn_play_loop['postid'];
		        $ifpay[$i] = array($postid, $earn_play_loop['ifpay']);
		        $earn[$i] = array($postid, $earn_play_loop['earn']);
		        $earn_[$i] = $earn_play_loop['earn'];
		        $ip[$i] = $earn_play_loop['ip'];
		        $i++;
	        }
        }
	
    $x = 0;
    $i = 0;
    $count_earn = 0;
    $count_earn_ = 0;
    foreach ($ifpay as $key => $value){
        if($value[1] == 'no'){
            $count_earn = $count_earn + $earn[$key][1];
            $x++;
        }
        if($value[1] == 'yes'){
            $count_earn_ = $count_earn_ + $earn[$key][1];
            $i++;
        }
    }
    
    echo $x . ' Plays';
    echo '<br>';
    echo $count_earn.'$';
    echo '<br>';
    echo '<br>';
    
    echo $i . ' Plays';
    echo '<br>';
    echo $count_earn_.'$';
    echo '<br>';
    echo '<br>';
	
    $userid_count = array_count_values($userid);
    $ip_count = array_count_values($ip);
    $earn_count = array_count_values($earn_);
    arsort($userid_count);
    arsort($ip_count);
    arsort($earn_count);
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
    echo '<br>';
    foreach ($earn_count as $key => $value){
    	echo $key . '$ - ' . $value . ' Plays';
    	echo '<br>';
    }
  }	
}  

// Add the fields to the "presenters" taxonomy, using our callback function  
add_action( 'artist_edit_form_fields', 'artist_count_taxonomy_custom_fields', 60, 2 );  
add_action( 'artist_add_form_fields', 'artist_count_taxonomy_custom_fields', 60, 2 ); 

?>
