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
	<div id="term-id" style="display: none;"><?php echo $tag->term_id ?></div>
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
	
	$i = 0;
    	$userid_no = [];
	$ifpay_no = [];
	$earn_no = [];
	$earn__no = [];
    	$ip_no = [];
	$userid_yes = [];
	$ifpay_yes = [];
	$earn_yes = [];
	$earn__yes = [];
    	$ip_yes = [];
	$userid = [];
	$ifpay = [];
	$earn = [];
	$earn_ = [];
	$ip = [];
	foreach ($earn_play_loops as $earn_play_loop_){
		foreach ($earn_play_loop_ as $earn_play_loop){
                $postid = $earn_play_loop['postid'];
                $ifpay_loop = $earn_play_loop['ifpay'];
                if($ifpay_loop == 'no'){
		            $userid_no[$i] = $earn_play_loop['userid'];
		            $ifpay_no[$i] = array($postid, $earn_play_loop['ifpay']);
		            $earn_no[$i] = array($postid, $earn_play_loop['earn']);
		            $earn__no[$i] = $earn_play_loop['earn'];
		            $ip_no[$i] = $earn_play_loop['ip'];
                }
                if($ifpay_loop == 'yes'){
		            $userid_yes[$i] = $earn_play_loop['userid'];
		            $ifpay_yes[$i] = array($postid, $earn_play_loop['ifpay']);
		            $earn_yes[$i] = array($postid, $earn_play_loop['earn']);
		            $earn__yes[$i] = $earn_play_loop['earn'];
		            $ip_yes[$i] = $earn_play_loop['ip'];
		            $ifpaydatetime_yes[$i] = array($earn_play_loop['earn'], $earn_play_loop['ifpaydatetime']);
                }
                $userid[$i] = $earn_play_loop['userid'];
	        $ifpay[$i] = array($postid, $earn_play_loop['ifpay']);
	        $earn[$i] = array($postid, $earn_play_loop['earn']);
	        $earn_[$i] = $earn_play_loop['earn'];
	        $ip[$i] = $earn_play_loop['ip'];
	        $i++;
	        }
        }
	
    $x = 0;
    $count_earn_no = 0;
    foreach ($ifpay_no as $key => $value){
    	$count_earn_no = $count_earn_no + $earn_no[$key][1];
	$x++;
    }
    
    echo '<button id="withdraw">Withdraw</button>';
    echo '<br>';
    echo '<br>';
    
    echo '<div id="earn-play-loop"></div>';
    
    echo '<b>Not pay yet</b>';
    echo '<br>';
    echo $x . ' Plays';
    echo '<br>';
    echo $count_earn_no.'$';
    echo '<br>';
    echo '<br>';
	
    $userid_count_no = array_count_values($userid_no);
    $ip_count_no = array_count_values($ip_no);
    $earn_count_no = array_count_values($earn__no);
    arsort($userid_count_no);
    arsort($ip_count_no);
    arsort($earn_count_no);
    foreach ($userid_count_no as $key => $value){
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
    foreach ($ip_count_no as $key => $value){
    	echo $key . ' - ' . $value . ' Plays';
    	echo '<br>';
    }
    echo '<br>';
    foreach ($earn_count_no as $key => $value){
    	echo $key . '$ - ' . $value . ' Plays';
    	echo '<br>';
    }
    echo '<br>';
    
    $i = 0;
    $count_earn_yes = 0;
    foreach ($ifpay_yes as $key => $value){
	$count_earn_yes = $count_earn_yes + $earn_yes[$key][1];
	$i++;
    }
    
    echo '<b>Have been pay</b>';
    echo '<br>';
    echo $i . ' Plays';
    echo '<br>';
    echo $count_earn_yes.'$';
    echo '<br>';
    echo '<br>';
    
    $paycounttimes = [];
    foreach ($ifpaydatetime_yes as $ifpaydatetime){
    	$timepay = $ifpaydatetime[1];
	$paycounttimes[$timepay] = $paycounttimes[$timepay] + $ifpaydatetime[0];
    }
    
    foreach($paycounttimes as $key => $value){
    	echo  round($value, 2) . '$ - ' . date('m/d/Y H:i:s', $key);
    	echo '<br>';
    }
    echo '<br>';
	
    $userid_count_yes = array_count_values($userid_yes);
    $ip_count_yes = array_count_values($ip_yes);
    $earn_count_yes = array_count_values($earn__yes);
    arsort($userid_count_yes);
    arsort($ip_count_yes);
    arsort($earn_count_yes);
    foreach ($userid_count_yes as $key => $value){
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
    foreach ($ip_count_yes as $key => $value){
    	echo $key . ' - ' . $value . ' Plays';
    	echo '<br>';
    }
    echo '<br>';
    foreach ($earn_count_yes as $key => $value){
    	echo $key . '$ - ' . $value . ' Plays';
    	echo '<br>';
    }
    echo '<br>';
    
    $i = 0;
    $count_earn = 0;
    foreach ($ifpay as $key => $value){
        $count_earn = $count_earn + $earn[$key][1];
        $i++;
    }
    
    echo '<b>Total</b>';
    echo '<br>';
    echo $i . ' Plays';
    echo '<br>';
    echo $count_earn.'$';
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

add_action( 'admin_footer', 'my_withdraw' ); // Write our JS below here
function my_withdraw() { ?>
    <script type="text/javascript" >
        
    function withdraw($) {

	var term_id = jQuery('#term-id').html();

        var data = {
		'action': 'withdraw',
		'termid': term_id
        };


        // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
        jQuery.post(ajaxurl, data, function(response) {
		jQuery('#earn-play-loop').html(response);
		location.reload();
        });
        
    }


    jQuery(document).ready(function($) {
        jQuery("#withdraw").on( "click", function(event) {
            withdraw($);
        });
    });
    </script> <?php
}

add_action( 'wp_ajax_withdraw', 'withdraw' );
function withdraw() {

	$term_id = $_POST['termid'];

	$args = array(
		'post_type' => 'music',
		'posts_per_page'  => -1,
		'tax_query' => array(
	            array(
	                'taxonomy' => 'artist',
	                'field' => 'term_id',
	                'terms' => $term_id,
	            )
	        )
	);
	
	$get_posts = get_posts($args);
	
	$i = 0;
	$earn_play_loops = [];
	foreach($get_posts as $post){
       		$earn_play_loops_array = get_post_meta($post->ID, 'earn_play_loop', true );
	        if($earn_play_loops_array != '' || $earn_play_loops_array != null){
	            $earn_play_loops[$post->ID] = get_post_meta($post->ID, 'earn_play_loop', true );
	            $i++;
	        }
	}
	
	$x = 0;
	$current_time = current_time( 'timestamp' );
	foreach ($earn_play_loops as $key => $value){
		$i = 0;
		foreach ($value as $earn_play_loop){
			$ifpay = $earn_play_loop['ifpay'];
			if($ifpay == 'no'){
	                	$earn_play_loops[$key][$i]['earn'] = $earn_play_loop['earn'];
	                	$earn_play_loops[$key][$i]['userid'] = $earn_play_loop['userid'];
	                	$earn_play_loops[$key][$i]['ip'] = $earn_play_loop['ip'];
	                	$earn_play_loops[$key][$i]['loc'] = $earn_play_loop['loc'];
	                	$earn_play_loops[$key][$i]['postid'] = $earn_play_loop['postid'];
	                	$earn_play_loops[$key][$i]['datetime'] = $earn_play_loop['datetime'];
				$earn_play_loops[$key][$i]['ifpay'] = 'yes';
				$earn_play_loops[$key][$i]['ifpaydatetime'] = $current_time;
			}
			if($ifpay == 'yes'){
	                	$earn_play_loops[$key][$i]['earn'] = $earn_play_loop['earn'];
	                	$earn_play_loops[$key][$i]['userid'] = $earn_play_loop['userid'];
	                	$earn_play_loops[$key][$i]['ip'] = $earn_play_loop['ip'];
	                	$earn_play_loops[$key][$i]['loc'] = $earn_play_loop['loc'];
	                	$earn_play_loops[$key][$i]['postid'] = $earn_play_loop['postid'];
	                	$earn_play_loops[$key][$i]['datetime'] = $earn_play_loop['datetime'];
				$earn_play_loops[$key][$i]['ifpay'] = $earn_play_loop['ifpay'];
				$earn_play_loops[$key][$i]['ifpaydatetime'] = $earn_play_loop['ifpaydatetime'];
			}
	               	$i++;
	        }
	        update_post_meta($key, 'earn_play_loop', $earn_play_loops[$key]);
	        $x++;
        }
	

	return wp_send_json('Updated');

}



?>