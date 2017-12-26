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

		$attachment_post = get_post( $attachment_ID );

		$type = get_post_mime_type($attachment_ID);

		if(strpos($type, 'audio') === 0)
		{
			echo exec('sox ' . get_attached_file($attachment_ID) . ' -r 32000 -c 1 --norm -C -1 ' . get_attached_file($attachment_ID) . '.ogg' );
			chmod( get_attached_file($attachment_ID) . '.ogg', 0666 );
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

		if(strpos($type, 'audio') === 0)
		{
			echo exec('rm -f ' . get_attached_file($attachment_ID) . '.ogg' );
		}
	}
	add_action('delete_attachment', 'remove_ogg_attachment');

	/**
	* Join posts and postmeta tables
	*
	* http://codex.wordpress.org/Plugin_API/Filter_Reference/posts_join
	*/
	function cf_search_join( $join ) {
		global $wpdb;

		if ( is_search() ) {    
			$join .=' LEFT JOIN '.$wpdb->postmeta. ' ON '. $wpdb->posts . '.ID = ' . $wpdb->postmeta . '.post_id ';
		}

		return $join;
	}
	add_filter('posts_join', 'cf_search_join' );

	/**
	* Modify the search query with posts_where
	*
	* http://codex.wordpress.org/Plugin_API/Filter_Reference/posts_where
	*/
	function cf_search_where( $where ) {
		global $pagenow, $wpdb;

		if ( is_search() ) {
			$where = preg_replace(
				"/\(\s*".$wpdb->posts.".post_title\s+LIKE\s*(\'[^\']+\')\s*\)/",
				"(".$wpdb->posts.".post_title LIKE $1) OR (".$wpdb->postmeta.".meta_value LIKE $1)", $where );
		}

		return $where;
	}
	add_filter( 'posts_where', 'cf_search_where' );

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

?>