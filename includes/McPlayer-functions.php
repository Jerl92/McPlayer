<?php 

/////////////////////////////
//
//	wp-a11y
//	WP stuff
//
/////////////////////////////
add_action( 'wp_enqueue_scripts', 'yourprefix_a11y' );
function yourprefix_a11y() {
	wp_enqueue_script( 'wp-a11y' );
}

	/**
 * Disable the emoji's
 */
function disable_emojis() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' ); 
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' ); 
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
	add_filter( 'wp_resource_hints', 'disable_emojis_remove_dns_prefetch', 10, 2 );
}
add_action( 'init', 'disable_emojis' );
   
/**
* Filter function used to remove the tinymce emoji plugin.
* 
* @param array $plugins 
* @return array Difference betwen the two arrays
*/
function disable_emojis_tinymce( $plugins ) {
	if ( is_array( $plugins ) ) {
		return array_diff( $plugins, array( 'wpemoji' ) );
			} else {
		return array();
	}
}
   
/**
* Remove emoji CDN hostname from DNS prefetching hints.
*
* @param array $urls URLs to print for resource hints.
* @param string $relation_type The relation type the URLs are printed for.
* @return array Difference betwen the two arrays.
*/
function disable_emojis_remove_dns_prefetch( $urls, $relation_type ) {
	if ( 'dns-prefetch' == $relation_type ) {
		/** This filter is documented in wp-includes/formatting.php */
		$emoji_svg_url = apply_filters( 'emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/' );
    	$urls = array_diff( $urls, array( $emoji_svg_url ) );
	}
   return $urls;
}
		
	/////////////////////////////
	//
	//	Produces cleaner filenames for uploads
	//	@param  string $filename
	//	@return string
	//
	///////////////////////////////
	function wpartisan_sanitize_file_name( $filename ) {

		$sanitized_filename = remove_accents( $filename ); // Convert to ASCII

		// Standard replacements
		$invalid = array(
			' '   => '-',
			'%20' => '-',
			'_'   => '-',
		);
		$sanitized_filename = str_replace( array_keys( $invalid ), array_values( $invalid ), $sanitized_filename );

		$sanitized_filename = preg_replace('/[^A-Za-z0-9-\. ]/', '', $sanitized_filename); // Remove all non-alphanumeric except .
		$sanitized_filename = preg_replace('/\.(?=.*\.)/', '', $sanitized_filename); // Remove all but last .
		$sanitized_filename = preg_replace('/-+/', '-', $sanitized_filename); // Replace any more than one - in a row
		$sanitized_filename = str_replace('-.', '.', $sanitized_filename); // Remove last - if at the end
		$sanitized_filename = strtolower( $sanitized_filename ); // Lowercase

		return $sanitized_filename;
	}
	add_filter( 'sanitize_file_name', 'wpartisan_sanitize_file_name', 10, 1 );
	
	/**
	* Prevent duplicates
	*
	* http://codex.wordpress.org/Plugin_API/Filter_Reference/posts_distinct
	*/
	function cf_search_distinct( $where ) {
		global $wpdb;

		if ( is_search() ) {
			return "DISTINCT";
		}

		return $where;
	}
	add_filter( 'posts_distinct', 'cf_search_distinct' );

// http://www.webdeveloper.com/forum/showthread.php?212775-Converting-03-45-54-format-time-into-seconds-quick-way-to-do-it

function seconds_from_time($time) {
		list($m, $s) = explode(':', $time);
		return ($h * 3600) + ($m * 60) + $s;
} 

function time_from_seconds($seconds) {
	if ($seconds >= 3600) {
		$h = floor($seconds / 3600);
		$m = floor(($seconds % 3600) / 60);
		$s = $seconds - ($h * 3600) - ($m * 60);
		return sprintf('%01dh%01dm%01ds', $h, $m, $s);
	} else {
		$m = floor(($seconds % 3600) / 60);
		$s = $seconds - ($h * 3600) - ($m * 60);
		return sprintf('%01dm%01ds', $m, $s);
	} 
} 

function user_if_login() {
	if(get_current_user_id()) {
		return get_current_user_id();
	} else {
		if(isset($_COOKIE['userid'])) {
			return $_COOKIE['userid'];
		} else {
			header('Refresh: 0');
		}
	}
}

function ip2int($ip){
	$chunks = explode(".", $ip);
	$i = 0;
	foreach($chunks as $chunk){
	  $int[$i] = $chunk;
	  $i++;
	}
	return implode($int);
}

function ip2long_v6($ip) {
    $ip_n = inet_pton($ip);
    $bin = '';
    for ($bit = strlen($ip_n) - 1; $bit >= 0; $bit--) {
        $bin = sprintf('%08b', ord($ip_n[$bit])) . $bin;
    }

    if (function_exists('gmp_init')) {
        return gmp_strval(gmp_init($bin, 2), 10);
    } elseif (function_exists('bcadd')) {
        $dec = '0';
        for ($i = 0; $i < strlen($bin); $i++) {
            $dec = bcmul($dec, '2', 0);
            $dec = bcadd($dec, $bin[$i], 0);
        }
        return $dec;
    } else {
        trigger_error('GMP or BCMATH extension not installed!', E_USER_ERROR);
    }
}
  
function set_userid_cookie() {
	$cookie_name = 'userid';
	if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} elseif (!empty($_SERVER["HTTP_CF_CONNECTING_IP"])) {
		$ip = $_SERVER["HTTP_CF_CONNECTING_IP"];
	} else {
		$ip = $_SERVER['REMOTE_ADDR'];
	}
    $output = rand(1,9);
    for($i=0; $i<12; $i++) {
        $output .= rand(0,9);
    }
	$isValid = filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
	if($isValid === false){
		$ip_ = ip2long_v6($ip);
	} else {
		$ip_ = ip2int($ip);
	}
	$cookie_value = $ip_.$output;
	if(!isset($_COOKIE[$cookie_name])) {
		setcookie($cookie_name, $cookie_value, time() + ((86400 * 30) * 12)); // 86400 = 1 day * 12 = 1 year
	}
}
add_action( 'init', 'set_userid_cookie');

// @see http://fr2.php.net/manual/en/function.mb-convert-encoding.php#103300
function memory_usage() {
	$mem_usage = memory_get_usage(false);
	if ($mem_usage < 1024) {
		$mem_usage .= ' B';
	} elseif ($mem_usage < 1048576) {
		$mem_usage = round($mem_usage/1024,2) . ' KB';
	} else {
		$mem_usage = round($mem_usage/1048576,2) . ' MB';
	}
	return $mem_usage;
}


	/////////////////////////////
	//
	//	Front end media page are disable.
	//	Hide media page for front end, use MCPlayer
	//
	/////////////////////////////
	function myprefix_redirect_attachment_page() {
		if ( is_attachment() ) {
			global $post;
			if ( $post && $post->post_parent ) {
				wp_redirect( esc_url( get_permalink( $post->post_parent ) ), 301 );
				exit;
			} else {
				wp_redirect( esc_url( home_url( '/' ) ), 301 );
				exit;
			}
		}
	}
	add_action( 'template_redirect', 'myprefix_redirect_attachment_page' );

add_action( 'show_user_profile', 'nopio_admin_user_profile_category_select' );
add_action( 'edit_user_profile', 'nopio_admin_user_profile_category_select' );

function nopio_admin_user_profile_category_select( $user ) {
	$taxonomy = get_taxonomy( USER_CATEGORY_NAME );

	if ( !user_can( $user, 'artist' ) ) {
		return;
	}
	?>
	<table class="form-table">
		<tr>
			<th>
				<label>Artist</label>
			</th>
			<td>
				<select name="artist" id="artist[]">
					<?php

					$terms = get_terms("artist", "orderby=name&hide_empty=0");
					$artist = get_user_meta( $user->id, '_artist_role_set', true );
					echo $artist;
					if ( !is_wp_error( $terms ) ) {
						if ( current_user_can('artist') ) {
							foreach ( $terms as $term ) {
								if($artist == $term->term_id) {
									echo "<option value='" . $term->term_id . "' selected='selected'>" . $term->name . "</option>";
								}
							}
						} else {
							foreach ( $terms as $term ) {
								if($artist == $term->term_id) {
									echo "<option value='" . $term->term_id . "' selected='selected'>" . $term->name . "</option>";
								} else {
									echo "<option value='" . $term->term_id . "'>" . $term->name . "</option>";
								}
							}
						}
					}

					?>
				</select>
			</td>
		</tr>
	</table>
	<?php
}

add_action( 'personal_options_update', 'nopio_admin_save_user_categories' );
add_action( 'edit_user_profile_update', 'nopio_admin_save_user_categories' );

function nopio_admin_save_user_categories( $user_id ) {
	$user = get_userdata( $user_id );

	$new_categories_ids = $_POST['artist'];

	if( current_user_can( 'administrator' ) ) {
		update_user_meta( $user_id, '_artist_role_set', $new_categories_ids );
	}
}

/**
 * Overwrite args of custom post type registered by plugin
 */
add_filter( 'register_post_type_args', 'change_capabilities_of_course_document' , 10, 2 );

function change_capabilities_of_course_document( $args, $post_type ){

 // Do not filter any other post type
 if ( 'music' !== $post_type ) {

     // Give other post_types their original arguments
     return $args;

 }

// Change the capabilities of the "course_document" post_type
$args['capabilities'] = array(
	'edit_post'          => 'edit_music', 
	'read_post'          => 'read_music', 
	'delete_post'        => 'delete_music', 
	'edit_posts'         => 'edit_musics', 
	'publish_posts'      => 'publish_musics',       
	'read_private_posts' => 'read_private_musics', 
	'create_posts'       => 'edit_musics', 
);

  // Give the course_document post type it's arguments
  return $args;

}

function kurse_role_caps() {
	global $pagenow;
	$artist = get_user_meta( get_current_user_id(), '_artist_role_set', true );
	if ($pagenow == 'edit-tags.php' && is_admin() && $_GET['taxonomy'] == 'artist' && $_GET['tag_ID'] == null && $artist != null) {
		if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
			$url = "https://";   
		else  
			$url = "http://"; 

		// Append the host(domain name, ip) to the URL.   
		$url.= $_SERVER['HTTP_HOST'];   

		$url.= "/wp-admin/term.php?taxonomy=artist&post_type=music&tag_ID=" . $artist;

		header('Location: '.$url);
	}
}
add_action('init', 'kurse_role_caps', 11);

function my_media_article_category_query( $query ) {
		$artist = get_user_meta( get_current_user_id(), '_artist_role_set', true );
		if (is_admin() && $query->query["post_type"] == "music" && $artist != null){
			$query->set( 'tax_query', array(
				array (
					'taxonomy' => 'artist',
					'field' => 'id',
					'terms' => array( $artist ),
				)
			) );
		}
}
add_filter( 'pre_get_posts', 'my_media_article_category_query' );


add_filter( 'ajax_query_attachments_args', 'role_external' );
function role_external( $query ) {
    $user_id = get_current_user_id();
    if ( $user_id && current_user_can('artist') ) {
        $query['author'] = $user_id;
    }
    return $query;
}

add_action('admin_init','rpt_add_role_caps',999);

    function rpt_add_role_caps() {

        // Add the roles you'd like to administer the custom post types
        $roles = array('artist');

        // Loop through each role and assign capabilities
        foreach($roles as $the_role) {    
             $role = get_role($the_role);               
             $role->add_cap( 'read' );
             $role->add_cap( 'read_music');
             $role->add_cap( 'edit_music' );
             $role->add_cap( 'edit_musics' );
             $role->add_cap( 'edit_published_musics' );
             $role->add_cap( 'publish_musics' );
             $role->add_cap( 'delete_published_musics' );
        }
	}

	add_action('admin_menu','rpt_remove_role_caps',999);
    function rpt_remove_role_caps() {
		if( !current_user_can( 'administrator' ) ):
			remove_menu_page('edit.php'); // Posts
			remove_menu_page('upload.php'); // Media
			remove_menu_page('link-manager.php'); // Links
			remove_menu_page('edit-comments.php'); // Comments
			remove_menu_page('edit.php?post_type=page'); // Pages
			remove_menu_page('plugins.php'); // Plugins
			remove_menu_page('themes.php'); // Appearance
			remove_menu_page('users.php'); // Users
			remove_menu_page('tools.php'); // Tools
			remove_menu_page('options-general.php'); // Settings
		endif;
	}

?>