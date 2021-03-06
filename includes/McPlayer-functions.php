<?php 

	/////////////////////////////
	//
	//	wp-a11y
	//	WP stuff
	//
	/////////////////////////////
	add_action( 'wp_enqueue_scripts', 'yourprefix_a11y' );
	function yourprefix_a11y() {
	//	wp_enqueue_script( 'wp-a11y' );
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


	//////////////////
	//
	//	add_ogg_attachment($attachment_ID)
	//	Automaticly convert the uploded audio file to OGG format for less LTE data use.
	//	Because of Chrome for android 60+ the conection.state set the player to use OGG file. MP3 = 6MB => OGG = 1.3MB
	//
	//////////////////
	function add_ogg_attachment($attachment_ID)
	{          
		global $current_user;
		get_currentuserinfo();

		$sox_file = '/usr/bin/sox';

		$attachment_post = get_post( $attachment_ID );

		$type = get_post_mime_type($attachment_ID);

		$musics_option = get_option( 'musics_option_name' ); // Array

		$rate_value =  $musics_option ['audio_rate']; // Option value

		$channel_value =  $musics_option ['audio_channel']; // Option value

		$codec_value =  $musics_option ['audio_codec']; // Option value
		
		if ($rate_value == null) {
			$channel_value = 3200;
		} else {
			$channel_value = $rate_value;
		}

		if ($channel_value == 1) {
			$channel_value = 1;
		} elseif ($channel_value == 2 || $channel_value == null) {
			$channel_value = 2;
		}	
		
		$norm_ = ' ';
		if ($codec_value == 1) {
			$codec_value = '.ogg';
			$norm_ = ' --norm -C -1 ';
		} elseif ( $codec_value == 2 ) {
			$codec_value = '.wma';
		} elseif ( $codec_value == 3 ) {
			$codec_value = '.mp3';
		} elseif ( $codec_value == 4 ) {
			$codec_value = '.acc';
		}

		if(strpos($type, 'audio') === 0)
		{
			if (file_exists($sox_file)) {
				echo exec('sox ' . get_attached_file($attachment_ID) . ' -r ' . $rate_value . ' -c ' . $channel_value . $norm_ . get_attached_file($attachment_ID) . $codec_value);
				chmod( get_attached_file($attachment_ID) . $codec_value , 0666 );
			}
		}
	}
	add_action('add_attachment', 'add_ogg_attachment');


	//////////////////
	//
	//	Automaticly remove the OGG audio file if the original is removed.
	//
	//////////////////
	function remove_ogg_attachment( $attachment_ID )
	{          
		global $current_user;

		get_currentuserinfo();

		$attachment_post = get_post( $attachment_ID );

		$type = get_post_mime_type($attachment_ID);
		
		$musics_option = get_option( 'musics_option_name' ); // Array

		$codec_value =  $musics_option ['audio_codec']; // Option value

		if ($codec_value == null || $codec_value == 1) {
			$codec_value = '.ogg';
		} elseif ( $codec_value == 2 ) {
			$codec_value = '.wma';
		} elseif ( $codec_value == 3 ) {
			$codec_value = '.mp3';
		} elseif ( $codec_value == 4 ) {
			$codec_value = '.acc';
		}

		if(strpos($type, 'audio') === 0)
		{
			echo exec('rm -f ' . get_attached_file($attachment_ID) . $codec_value);
		}
	}
	add_action('delete_attachment', 'remove_ogg_attachment');
	
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

/////////////////////////////
//
//	Costom box for taxonomy Artists.
//	WIP
//
/////////////////////////////

function add_book_place_column_content($content,$column_name,$term_id){
    $term= get_term($term_id, 'artist');
    switch ($column_name) {
        case 'foo':
            //do your stuff here with $term or $term_id
            $content = 'test';
            break;
        default:
            break;
    }
    return $content;
}
add_filter('manage_artist_custom_column', 'add_book_place_column_content',10,3);

function SearchFilter($query) {
	if ($query->is_search) {
	   $query->set('post_type', 'music');
	}
	return $query;
 }
 add_filter('pre_get_posts','SearchFilter');

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

add_action('wp_head', 'your_function_name');
function your_function_name(){
	echo '<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">';
};

?>