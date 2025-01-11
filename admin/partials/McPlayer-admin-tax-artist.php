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
 ?>  

 <tr class="form-field">  
     <th scope="row" valign="top">  
         <label for="presenter_id"><?php _e('Total Earn'); ?></label>  
     </th>  
     <td>  
     <?php 

    $t_id = $tag->term_id; // Get the ID of the term you're editing
    $get_counts = get_term_meta($t_id, 'count_play_loop', true);
    $get_earn_counts = get_term_meta($t_id, 'earn_play_loop', true);

    $i = 0;
    foreach($get_earn_counts as $get_earn_count){
        $count_earn[$i] = $get_earn_count['earn'];
        $user_count[$i] = $get_earn_count['userid'];
        $ipv4_count[$i] = $get_earn_count['ipv4'];
        $loc_count[$i] = $get_earn_count['loc'];
        $postid_count[$i] = $get_earn_count['postid'];
        $i++;
    }
    echo array_sum($count_earn).'$';

    echo '<input type="submit" id="withdraw" value="withdraw">';

    echo '<div id="paypal"></div>';

     echo '<br>';
     $user_count_arrays = array_count_values($user_count);
     foreach($user_count_arrays as $user_count_array){
         $arrays_value += $user_count_array;
     }
     arsort($user_count_arrays);
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
                echo $user_count_key;
                echo ' - Plays: ';
                echo $user_count_arrays[$user_count_key];
                echo '<br>';   
            }
            next($user_count_arrays);
        }
    }
    echo '<br>';
    echo '<canvas id="myChart" style="width:100%;"></canvas>';
    $y = 0;
    foreach($loc_count as $loc){
        if(isset($loc['country'])){
            $locs[$y] = $loc['country'];
            $y++;
        }
    }
    $i = 0;
    foreach($locs as $loc){
        if($loc = $locs[$i]){
            $locs_array[$loc] += 1;
        }
        $i++;
    }
    print_r($locs_array);
    echo '<br>';
    echo ' <div id="regions_div" style="width: 100%; height: 1200px;"></div>';
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
     });</script><script>
      google.charts.load('current', {
        'packages':['geochart'],
      });
      google.charts.setOnLoadCallback(drawRegionsMap);

      var key_country = [];
      var key_value = [];
      var i = 0;

      var get_locs_value = <?php echo json_encode($locs); ?>;
     const counts = [];
    get_locs_value.forEach(function (x) { counts[x] = (counts[x] || 0) + 1; });
    Object.entries(counts).forEach(([key, value]) => {
        key_country[i] = key;
        key_value[i] = value;
        i++;
    })

      function drawRegionsMap() {

        var data = google.visualization.arrayToDataTable([
            ['Country', 'Popularity'],
            [key_country[0], key_value[0]],
            [key_country[1], key_value[1]],
            [key_country[2], key_value[2]],
            [key_country[3], key_value[3]],
            [key_country[4], key_value[4]],
            [key_country[5], key_value[5]],
            [key_country[6], key_value[6]],
            [key_country[7], key_value[7]],
            [key_country[8], key_value[8]],
            [key_country[9], key_value[9]],
            [key_country[10], key_value[10]],
        ]);

        var options = {};

        var chart = new google.visualization.GeoChart(document.getElementById('regions_div'));

        chart.draw(data, options);
      }
    </script><?php
     ?>
     </td>  
 </tr>

 <?php  
}  

// Add the fields to the "presenters" taxonomy, using our callback function  
add_action( 'artist_edit_form_fields', 'artist_count_taxonomy_custom_fields', 60, 2 );  
add_action( 'artist_add_form_fields', 'artist_count_taxonomy_custom_fields', 60, 2 ); 


add_action( 'admin_footer', 'my_paypal_javascript' ); // Write our JS below here
function my_paypal_javascript() { ?>
	<script type="text/javascript" >

    function withdraw_fetch($) {

        var data = {
            'action': 'my_paypal_fetch'
        };

        // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
        jQuery.post(ajaxurl, data, function(response) {
            $("#paypal").html(response);
        });
        
    }

    jQuery(document).ready(function($) {
        $("#withdraw").on( "click", function(event) {
            event.preventDefault();
            withdraw_fetch($);
        });
    });
	</script> <?php
}

add_action( 'wp_ajax_my_paypal_fetch', 'my_paypal_fetch' );
function my_paypal_fetch() {

    $curl = curl_init();

    $url = "https://api.sandbox.paypal.com/v1/oauth2/token";
    $clientId = "AXUR-qsubY11BcbY5BDvcB9OQXbqqYfa5N4r3x3QTGDckgMeRfwvfthfBB4_99wbXSVhQY9xmElSFuC0";
    $secret = "EAEshZBm33rQLPXkS4lYqpAFUZqGmSFisqA9uUcxCwgUhvUAVS5N8q5q1lJTFlGS8Fb9r6ll5SZlOeVb";

    curl_setopt_array($curl, array(
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    //We need to send grant_type=client_credentials in POST Request Body
    CURLOPT_POSTFIELDS => "grant_type=client_credentials",
    //Setting Basic Authentication using Client ID and Secret
    CURLOPT_USERPWD => $clientId.":".$secret,
    // This specific header needs to be set for the API call to work
    CURLOPT_HTTPHEADER => array("Content-Type: application/x-www-form-urlencoded"),)
    ); 

    //make API request
    $result = curl_exec($curl);
    $json = json_decode($result);
    $access_token = $json->access_token;

    return wp_send_json ($access_token);

}

?>