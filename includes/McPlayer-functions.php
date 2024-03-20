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
		}
	}
}

class GetMacAddr{

	var $return_array = array(); // ????MAC???????
	var $mac_addr;
	
	function __construct($os_type){
		switch ( strtolower($os_type) ){
			case "linux":
			$this->forLinux();
			break;
			case "solaris":
			break;
			case "unix":
			break;
			case "aix":
			break;
			default:
			$this->forWindows();
			break;
		}
		$temp_array = array();
		foreach ( $this->return_array as $value ){
			if (preg_match("/[0-9a-f][0-9a-f][:-]"."[0-9a-f][0-9a-f][:-]"."[0-9a-f][0-9a-f][:-]"."[0-9a-f][0-9a-f][:-]"."[0-9a-f][0-9a-f][:-]"."[0-9a-f][0-9a-f]/i",$value,
			$temp_array ) ){
				$this->mac_addr = $temp_array[0];
				break;
			}
			
		}
		unset($temp_array);
		return $this->mac_addr;
	}
	
	function forWindows(){
		@exec("ipconfig /all", $this->return_array);
		if ( $this->return_array )
		return $this->return_array;
		else{
			$ipconfig = $_SERVER["WINDIR"]."\system32\ipconfig.exe";
			if ( is_file($ipconfig) )
				@exec($ipconfig." /all", $this->return_array);
			else
			@exec($_SERVER["WINDIR"]."\system\ipconfig.exe /all", $this->return_array);
			return $this->return_array;
		}
	}
	
	function forLinux(){
		@exec("ifconfig -a", $this->return_array);
		return $this->return_array;
	}

}

function set_userid_cookie() {
	$cookie_name = 'userid';
	if(!isset($_COOKIE[$cookie_name])) {
		$mac = new GetMacAddr(PHP_OS);
		$str = str_replace(":", '', $mac=$mac->mac_addr);

		for ( $pos=0; $pos < strlen($str); $pos ++ ) {
			$byte = substr($str, $pos);
			$hash[] .=  ord($byte);
		}

		$cookie_value = implode($hash);
		setcookie($cookie_name, $cookie_value, time() + (86400 * 30)); // 86400 = 1 day
		return $cookie_value;
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

?>