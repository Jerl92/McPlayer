<?php

// A callback function to add a custom field to our "presenters" taxonomy  
function presenters_taxonomy_custom_fields($tag) { 
    // Check for existing taxonomy meta for the term you're editing  
     $t_id = $tag->term_id; // Get the ID of the term you're editing
     $get_term_color = get_term_meta($t_id, 'meta_count_earn', true);
 ?>  

 <tr class="form-field">  
     <th scope="row" valign="top">  
         <label for="presenter_id"><?php _e('Earn for eatch play'); ?></label>  
     </th>  
     <td>  
		<?php if(current_user_can('artist')) {
        	echo '<input type="text" name="none" id="none" value="'. $get_term_color .'" class="my-color-field" style="width: 75px;" disabled></input>';
		} else {
			echo '<input type="text" name="meta_color" id="meta_color" value="'. $get_term_color .'" class="my-color-field" style="width: 75px;"></input>';
		} ?>
     </td>  
 </tr>

 <?php  
 }  

 // A callback function to save our extra taxonomy field(s)  
 function save_taxonomy_custom_meta( $term_id ) {
	if(current_user_can('artist')) {
		return null;
	} elseif ( isset($_POST['meta_color']) ) {
        update_term_meta( $term_id, 'meta_count_earn', $_POST['meta_color'] );
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
    // Check for existing taxonomy meta for the term you're editing  
     $t_id = $tag->term_id; // Get the ID of the term you're editing
     $get_earn_counts = get_term_meta($t_id, 'earn_play_loop', true);
     $get_counts = get_term_meta($t_id, 'count_play_loop', true);
 ?>  

 <tr class="form-field">  
     <th scope="row" valign="top">  
         <label for="presenter_id"><?php _e('Total Earn'); ?></label>  
     </th>  
     <td>  
     <?php 
     $i = 0;
     foreach($get_earn_counts as $get_earn_count){
            $count_earn[$i] = $get_earn_count['earn'];
            $user_count[$i] = $get_earn_count['userid'];
            $i++;
     }
     echo array_sum($count_earn).'$';
     echo '<br>';
     $user_count_arrays = array_count_values($user_count);
     $user_count_arrays_values = array_values($user_count_arrays);
     foreach($user_count_arrays_values as $user_count_arrays_value){
        $arrays_value += $user_count_arrays_value;
     }
     echo $arrays_value . ' Total Plays';
     echo '<br>';
     for ($x = 0; $x <= 25; $x++) {
        if(intval(key($user_count_arrays)) != 0){
            $user_count_key = key($user_count_arrays);
            $author_obj = get_user_by('id', intval($user_count_key));
            if($author_obj != null){
                echo $author_obj->user_login;
                echo ' - ';
                echo $author_obj->user_nicename;
                echo ' - ';
                echo $author_obj->user_email;
                echo ' - Plays: ';
                echo $user_count_arrays[$user_count_key];
                echo '<br>';   
            } else {
                echo intval($user_count_key);
                echo ' - Plays: ';
                echo $user_count_arrays[$user_count_key];
                echo '<br>';   
            }
            next($user_count_arrays);
        }
    }
    echo '<br>';
    echo '<canvas id="myChart" style="width:100%;"></canvas>';
    for ($x = 0; $x <= count($get_counts)-1; $x++) {
       $get_counts_key[$x] = date('d/m/Y H:i:s', key($get_counts));
       next($get_counts);
    }
    $x = 0;
    foreach($get_counts as $get_count){
       $get_counts_value[$x] = $get_count;
       $x++;
    }
    ?><script>
    var get_counts_key = <?php echo json_encode($get_counts_key); ?>;
    var get_counts_value = <?php echo json_encode($get_counts_value); ?>;
    const myChart = new Chart("myChart", {
       type: "bar",
       data: {
           labels: get_counts_key,
           datasets: [
               {
               label: "Plays",
               backgroundColor: '#26B99A', 
               data: get_counts_value
               }
           ]
       },
       options: {}
     });</script><?php
     ?>
     </td>  
 </tr>

 <?php  
}  

// Add the fields to the "presenters" taxonomy, using our callback function  
add_action( 'artist_edit_form_fields', 'artist_count_taxonomy_custom_fields', 60, 2 );  
add_action( 'artist_add_form_fields', 'artist_count_taxonomy_custom_fields', 60, 2 ); 

?>