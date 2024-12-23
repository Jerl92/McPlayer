<?php
//Example from Codex page : http://codex.wordpress.org/Function_Reference/add_submenu_page
//Add this in your functions.php file, or use it in your plugin

add_action('admin_menu', 'register_my_custom_submenu_page');

function register_my_custom_submenu_page() {
  add_submenu_page( 'edit.php?post_type=music', 'Bulk add album', 'Bulk add album', 'manage_options', 'bulk-add-album', 'bulk_add_album_submenu_page_callback' ); 
}

function bulk_add_album_submenu_page_callback() {
    echo '<div class="wrap">';
        echo '<div style="width: 100%; float: left;">';
		echo '<h2>Bulk add album</h2>';
        echo '</br>';
        $youtube_file = '/usr/local/bin/youtube-dl';

        if (file_exists($youtube_file)) {
            echo '<br />';
            print "youtube-dl is install";
            echo '<br />';
            print 'If youtube-dl is installed, you can download msuic.youtube.com full album playlist';
            echo '<br />';
            print 'https://music.youtube.com/playlist?list=#';
            echo '<br />';
        } else {
            echo '<br />';
            print "youtube-dl is not install";
            print '<br />';
            print "Go see https://github.com/ytdl-org/youtube-dl/ for more info";
            print '<br />';
        }

        $ffmpeg_file = '/usr/bin/ffmpeg';

        if (file_exists($ffmpeg_file)) {
            echo '<br />';
            print "FFMPEG is install: Conversion to MP3 enable";
            echo '<br />';
        } else {
            echo '<br />';
            print "FFMPEG is not install";
            print '<br />';
            print "Go see https://linuxize.com/post/how-to-install-ffmpeg-on-ubuntu-20-04/ for more info";
            print '<br />';
        }

        print '<br />';

        echo '<input type="text" class="yturl" name="yturl" value=""><br>';
        echo '<input type="submit" id="yburlsubmit">';

        print '<br />';
        print '<br />';

        echo '<div class="block">';
            echo 'Result:';
            print '<br />';
            echo '<div id="result" style="height: 250px;overflow-y: scroll;"></div>';
            echo '</div>';
            print '<br />';
            echo '<div id="filetable"></div>';
            echo '</br>';
            echo '</div>';
            echo '<div style="width: 100%; display: table; padding-top: 5%;">';
            echo 'Artist:';
            print '<br />';
            echo '<div id="artistdiv"></div>';
            echo '</br>';
            echo "Album:";
            echo '<div id="metabox_album_upload">';
            echo '<div class="image-preview">';
            echo '<img id="image-preview" src="" style="max-width:100%;">';
            echo '</div></br>';
            echo '<input type="hidden" id="cover" class="small-text" name="meta-box-media[]" value="">';
            echo '<input type="hidden" id="" class="button meta-box-upload-button" value="Upload">';
            echo '<input type="hidden" id="-remove" class="button meta-box-upload-button-remove" value="Remove">';
            echo '</div>';
        echo '</div>';
}

add_action( 'admin_footer', 'my_action_javascript' ); // Write our JS below here
function my_action_javascript() { ?>
	<script type="text/javascript" >

    function wake_lock_stop($) {
        
    }

    var doVisualUpdates = true;
    function update() {
        if (!doVisualUpdates) {
            console.log("Tab not visible");
        }
        navigator.wakeLock.request('screen')
        .then((wakeLock) => {
            console.log(wakeLock);
            console.log('acquired');
        })
    }

    document.addEventListener('visibilitychange', function(){
        doVisualUpdates = !document.hidden;
        update();
    });

    function add_chart_data($) {
        $('input[type="number"].tracknumber').each(function () {
            var path = $(this).attr('name');
            var number = $(this).val();
            var artist = $('#artistoptions').find(":selected").val(); 
            var cover = $('#cover').val();
            var url = $('input[type="text"].yturl').val();
            var data = {
                'action': 'my_action',
                'path': path,
                'number': number,
                'artist': artist,
                'cover': cover,
                'url': url
            };

            // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
            jQuery.post(ajaxurl, data, function(response) {
                $("#result").append(response);
            });
        });
        setTimeout(function(){ yt_url_fetch($); }, 10000);
    }

    function yt_table($) {
        $('input[type="text"].yturl').each(function () {

            var url = $(this).val();
            var data = {
                'action': 'my_table',
                'url': url,
            };

            // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
            jQuery.post(ajaxurl, data, function(response) {
                $("#filetable").html("");
                $("#filetable").append(response);                         
            });
        });
    }

    function yt_url_error($) {
        $('input[type="text"].yturl').each(function () {
                    var url = $(this).val();
                    var data = {
                        'action': 'my_url',
                        'url': url
                    };

                    // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
                    jQuery.post(ajaxurl, data, function(response) {
                        $("#result").append(response);
                    });
                });
    }

    function yt_artist($) {
        $('input[type="text"].yturl').each(function () {
            var url = $(this).val();
            var data = {
                'action': 'my_artist',
                'url': url
            };

            // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
            jQuery.post(ajaxurl, data, function(response) {
                console.log(response);
                $('#artistdiv').append(response[0]);
                // $('#artistoptions').val(response[1]);   
            });
        });
    }

    function yt_album($) {
        $('input[type="text"].yturl').each(function () {

            var url = $(this).val();
            var data = {
                'action': 'my_album',
                'url': url
            };

            // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
            jQuery.post(ajaxurl, data, function(response) {
                console.log(response);
                $("#image-preview").attr("src", response[1]);
                $("#cover").val(response[0]);
                // $('#artistdiv').append(response[0]);
                // $('#artistoptions').val(response[1]);   
            });
        });
    }

    function yt_dl($) {
        $('input[type="text"].yturl').each(function () {

            var url = $(this).val();
            var data = {
                'action': 'my_dl',
                'url': url
            };

            // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
            jQuery.post(ajaxurl, data, function(response) {
                $("#result").html("");
                jQuery.each( response[0], function( i, val ) {
                    $("#result").append('</br>');
                    $("#result").append(val);
                });
                if(response[1] != '0'){
                    var chatHistory = document.getElementById("result");
                    chatHistory.scrollTop = chatHistory.scrollHeight;
                    setTimeout(function(){ yt_dl($); }, 5000);   
                }        
                if(response[1] == '0'){
                    yt_album($);
                    yt_artist($);
                    yt_table($);
                    setTimeout(function(){ add_chart_data($); }, 7500);  
                    // setTimeout(function(){ yt_url_fetch($); }, 10000);
                    // $('input[type="text"].yturl').val(''); 
                }
                if(response[1] == '1'){
                    yt_url_error($);
                }
            });
        });
    }

    function yt_url($) {

        $('input[type="text"].yturl').each(function () {

            var url = $(this).val();
            var data = {
                'action': 'my_url',
                'url': url
            };

            // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
            jQuery.post(ajaxurl, data, function(response) {
                console.log(response);
                $("#result").append(response);
                yt_dl($);
            });
        });

    }

    function yt_url_fetch($) {

        $("#filetable").html("");
        $('#artistdiv').html("");
        $("#image-preview").attr("src", '');
        $("#cover").val('');

        var url = $('input[type="text"].yturl').val();

        var data = {
            'action': 'my_url_fetch',
            'url': url
        };

        // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
        jQuery.post(ajaxurl, data, function(response) {
            console.log(response);
            if(response != 'Finish'){
                $('input[type="text"].yturl').val();
                setTimeout(function(){ yt_url($); }, 5000);
            }
            if(response == 'Finish'){
                wake_lock_stop($);
            }
        });
        
    }

    jQuery(document).ready(function($) {
        $("#yburlsubmit").on( "click", function(event) {
            yt_url_fetch($);
            update();
        });
    });
	</script> <?php
}

function slugify($text, string $divider = '-')
{
  // replace non letter or digits by divider
  $text = preg_replace('~[^\pL\d]+~u', $divider, $text);

  // transliterate
  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

  // remove unwanted characters
  $text = preg_replace('~[^-\w]+~', '', $text);

  // trim
  $text = trim($text, $divider);

  // remove duplicate divider
  $text = preg_replace('~-+~', $divider, $text);

  // lowercase
  $text = strtolower($text);

  if (empty($text)) {
    return 'n-a';
  }

  return $text;
}

add_action( 'wp_ajax_my_album', 'my_album' );
function my_album() {

    $x = 0;
    $url = $_POST['url'];
    $url_components = parse_url($url);
    parse_str($url_components['query'], $params);
    $playlist = $params['list'];

    $upload_dir = wp_upload_dir();
    $path_implode = $upload_dir['basedir'] . '/'.$playlist.'/';
    $allFiles = scandir($path_implode, SCANDIR_SORT_DESCENDING);
    $files = array_diff($allFiles, array('.', '..'));
    $files_ = array_reverse($files);    
    foreach ($files_ as $file) {
        $realpath = realpath($path_implode.'/'.$file);
        $pathinfo = pathinfo($realpath);
        if($pathinfo['extension'] == 'json') {
            $jsonfileget = file_get_contents($realpath);
            $jsonfile = json_decode($jsonfileget, true);
        }
    }

    $artist_multipe = explode(',', $jsonfile['artist']);
    $artists[] .= $artist_multipe[0];
    $albums[] .= $jsonfile['album'];
    $years[] .= $jsonfile['release_year'];

    $sanitized_filename = remove_accents( $jsonfile['id'] . '-' . $jsonfile['album'] . '.jpg' ); // Convert to ASCII

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

    $content = file_get_contents($jsonfile['thumbnails'][3]['url']);
    file_put_contents($path_implode.'/'.$sanitized_filename, $content);
    $cover_path = $path_implode.'/'.$sanitized_filename;
    $cover_url = get_site_url() .'/'. UPLOADS . '/'.$playlist.'/' . $sanitized_filename;
    $cover_filename = $file;

    $counted_artists = array_count_values($artists);

    $counted_max_artists = max($counted_artists); //get the key, as we are rewound it's the first key

    $key_artists = array_search(strval($counted_max_artists), $counted_artists);

    $str_artists = slugify(strtolower($key_artists));

    $counted = array_count_values($albums);

    $counted_max = max($counted); //get the key, as we are rewound it's the first key

    $key = array_search(strval($counted_max), $counted);

    $str = str_replace(" ", "-", strtolower($key));

    $str__ = str_replace("_", "+", $key);

    $counted_years = array_count_values($years);

    $counted_max_years = max($counted_years); //get the key, as we are rewound it's the first key

    $key_years = array_search(strval($counted_max_years), $counted_years);
    
    $image_data = file_get_contents( $cover_path );

    $filename = $str.'.jpg';

    $file = $upload_dir['path'] . '/' . $filename;

    $upload_dir = wp_upload_dir();

    file_put_contents( $file, $image_data );
    
    $wp_filetype = wp_check_filetype( $filename, null );
    
    $attachment = array(
      'post_mime_type' => $wp_filetype['type'],
      'post_title' => $str__,
      'post_content' => $url,
      'post_status' => 'inherit'
    );
    
    $attach_id = wp_insert_attachment( $attachment, $file );
    require_once( ABSPATH . 'wp-admin/includes/image.php' );
    $attach_data = wp_generate_attachment_metadata( $attach_id, $file );
    wp_update_attachment_metadata( $attach_id, $attach_data );

    $pathmedia = get_attached_file($attach_id);

    header('Content-type: image/jpeg');

    $terms = get_terms( 'artist', 'hide_empty=0');

    foreach ( $terms as $term ) {
        if ( $term->slug == $str_artists ) {
            $category_id = $term->term_id;
        }
    }

    wp_set_post_terms( $attach_id, $category_id, 'artist', true );

    $html[0] = $attach_id;
    $html[1] = wp_get_attachment_url($attach_id);
    $html[3] = $category_id;
    $html[4] = $file;
    $html[5] = $image_data;

    add_post_meta( $attach_id, 'meta-box-year', $key_years );

    return wp_send_json ( $html );

}

add_action( 'wp_ajax_my_artist', 'my_artist' );
function my_artist() {
    $url = $_POST['url'];
    $url_components = parse_url($url);
    parse_str($url_components['query'], $params);
    $playlist = $params['list'];
    $upload_dir = wp_upload_dir();
    $path_implode = $upload_dir['basedir'] . '/'.$playlist.'/';
    $allFiles = scandir($path_implode, SCANDIR_SORT_DESCENDING);
    $files = array_diff($allFiles, array('.', '..'));
    $files_ = array_reverse($files);
    foreach ($files_ as $file) {
        $realpath = realpath($path_implode.'/'.$file);
        $pathinfo = pathinfo($realpath);
        if($pathinfo['extension'] == 'json') {
            $jsonfileget = file_get_contents($realpath);
            $jsonfiles[$x++] = json_decode($jsonfileget, true);
        }
    }
    foreach ($files_ as $file) {
        foreach($jsonfiles as $jsonfile) {
            $realpath = realpath($path_implode.'/'.$file);
            $pathinfo = pathinfo($realpath);
            if($pathinfo['extension'] == 'mp3'){
                if($pathinfo['filename'] == $jsonfile['id']) {
                    $artist_multipe = explode(',', $jsonfile['artist']);
                    if(isset($artist_multipe)){
                        $artists[] .= $artist_multipe[0];
                    } else {
                        $artists[] .= $jsonfile['artist'];
                    }
                    $albums[] .= $jsonfile['album'];
                    $years[] .= $jsonfile['release_year'];
                }
            }
        }
    }

    $x = 0;

    $terms = get_terms( 'artist', 'hide_empty=0');

    $counted = array_count_values($artists);

    $counted_max = max($counted); //get the key, as we are rewound it's the first key

    $key = array_search(strval($counted_max), $counted);

    $str = slugify(strtolower($key));
    
    foreach ( $terms as $term ) {
        if ( $term->slug === $str ) {
            $html[1] = $term->slug;
            $x = 1;
        }
    }

    if($x == 0){
        wp_create_term($key, 'artist');
        foreach ( $terms as $term ) {
            if ( $term->slug === $str ) {
                $html[1] = $term->slug;
            }
        }
    }

    $terms_ = get_terms( 'artist', 'hide_empty=0');
    $html[0] .= "<select id='artistoptions' name='customartist[]'>";
    foreach ( $terms_ as $term_ ) {
        if ($term_->slug === $str) {
            $html[0] .= "<option value='".$term_->term_id."' selected='selected'>".$term_->name."</option>";
        } else {
            $html[0] .= "<option value='".$term_->term_id."'>".$term_->name."</option>";
        }
    }

    $html[0] .= "</select><br />";

    return wp_send_json ( $html );
}

add_action( 'wp_ajax_my_url_fetch', 'my_url_fetch' );
function my_url_fetch() {
    $upload_dir = wp_upload_dir();
    $path_implode = $upload_dir['basedir'];
    $url = $_POST['url'];
    $url_components = parse_url($url);
    parse_str($url_components['query'], $params);
    $playlist = $params['list'];

    $path_implode_ytdl = $upload_dir['basedir'] . '/'.$playlist.'/';
    $allFiles = scandir($path_implode_ytdl, SCANDIR_SORT_DESCENDING);
    $files = array_diff($allFiles, array('.', '..'));
    $files_ = array_reverse($files);
    foreach ($files_ as $file) {
        unlink(realpath($path_implode_ytdl.'/'.$file));
    }

    $html = file_get_contents($path_implode.'/ytlink.txt');

    if($url != ''){
        $ytlinks = preg_split("/\r\n|\n|\r/", $url);
    }

    if($url == ''){
        $ytlinks = preg_split("/\r\n|\n|\r/", $html);
    }

    $attachments = get_posts( array(
        'post_type'   => 'attachment',
        'numberposts' => -1,
        'post_status' => null,
        'post_mime_type' => 'image'
    ) );

    if ( $attachments ) {
        foreach ( $attachments as $attachment ) {
            $attachment_content[] .= $attachment->post_content;
        }
    }

    foreach($ytlinks as $link) {
        if(in_array($link, $attachment_content)) {
            $allreadyindb = 1;
        } else {
            $allreadyindb = 0;
        }
        if($allreadyindb == 0){
            return wp_send_json ( $link );
        }
    }

    if($allreadyindb == 1){
        return wp_send_json ( 'Finish' );
    }
}

add_action( 'wp_ajax_my_url', 'my_url' );
function my_url() {
    $url = $_POST['url'];
    $url_components = parse_url($url);
    parse_str($url_components['query'], $params);
    $playlist = $params['list'];
    $upload_dir = wp_upload_dir();
    $path_implode = $upload_dir['basedir'] . '/'.$playlist.'/';
    mkdir($path_implode, 0775);
    // shell_exec('rm '.$path_implode.'out.log');
    // $cmd = "youtube-dl -o '$path_implode%(playlist_index)s-|-%(title)s-|-%(artist)s-|-%(album)s-|-%(release_year)s.%(ext)s' -f 18 --extract-audio --audio-format mp3 --prefer-ffmpeg --write-thumbnail -k " . $url;
    $cmd = "yt-dlp -o '$path_implode%(id)s.%(ext)s' -f best --extract-audio --audio-format mp3 --prefer-avconv --write-info-json --embed-thumbnail -k " . $url;
    $res = shell_exec(''.$cmd.' > '.$path_implode.'out.log 2>&1 &');
    return wp_send_json ( $res );
}

add_action( 'wp_ajax_my_dl', 'my_dl' );
function my_dl() {
    $url = $_POST['url'];
    $url_components = parse_url($url);
    parse_str($url_components['query'], $params);
    $playlist = $params['list'];
    $upload_dir = wp_upload_dir();
    $path_implode = $upload_dir['basedir'] . '/'.$playlist.'/';
    $html = file_get_contents($path_implode.'out.log');
    $res[0] = preg_split("/\r\n|\n|\r/", $html);
    // $res[0] = array_slice($fruits, -50, 50, true);

    foreach ($res[0] as $string) {
        if (strpos($string, 'Finished downloading playlist') !== FALSE) { // Yoshi version
            $res[1] = 0;
        }
        if (strpos($string, 'ERROR') !== FALSE) { // Yoshi version
            $res[1] = 1;
        }
        if (strpos($string, 'youtube-dl: error:') !== FALSE) { // Yoshi version
            $res[1] = 1;
        }
    }

    return wp_send_json ( $res );
}

add_action( 'wp_ajax_my_table', 'my_table' );
function my_table() {
    $i = 1;
    $url = $_POST['url'];
    $url_components = parse_url($url);
    parse_str($url_components['query'], $params);
    $playlist = $params['list'];
    $upload_dir = wp_upload_dir();
    $path_implode = $upload_dir['basedir'] . '/'.$playlist.'/';
    $allFiles = scandir($path_implode, SCANDIR_SORT_DESCENDING);
    $files = array_diff($allFiles, array('.', '..'));
    $files_ = array_reverse($files);
    $html[] = '<table>';

    foreach ($files_ as $file) {
        $realpath = realpath($path_implode.'/'.$file);
        $pathinfo = pathinfo($realpath);
        if($pathinfo['extension'] == 'json') {
            $jsonfileget = file_get_contents($realpath);
            $jsonfiles[$x++] = json_decode($jsonfileget, true);
        }
    }
    foreach ($files_ as $file) {
        foreach($jsonfiles as $jsonfile) {
            $realpath = realpath($path_implode.'/'.$file);
            $pathinfo = pathinfo($realpath);
            if($pathinfo['extension'] == 'mp3'){
                if($pathinfo['filename'] == $jsonfile['id']) {
                    $playlist_index = $jsonfile['playlist_index'];
                    $html[] .= '<tr><td>';
                    $html[] .= '<input type="number" class="tracknumber" name="'.$realpath.'" value="'.$playlist_index.'" >';
                    $html[] .= '</td>';
                    $html[] .= '<td>';
                    $html[] .= $file;
                    $html[] .= '</tr></td>';
                }
            }
        }
    }
    $html[] .= '</table>';

    return wp_send_json ( implode($html) );
}

add_action( 'wp_ajax_my_action', 'my_action' );
function my_action() {
	global $wpdb; // this is how you get access to the database

    $link = $_POST['path'];
    $number = $_POST['number'];
    $artistid = $_POST['artist'];
    $cover = $_POST['cover'];

    $channel_value = 2;
    $rate_value = '44100';
    $codec_value = '.mp3';
    $norm_ = ' -c:a libvorbis -qscale:a 5 ';

    $path_parts = pathinfo($link);
    $upload_dir = wp_upload_dir();

    $sanitized_filename = remove_accents( $path_parts['basename'] ); // Convert to ASCII

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

    $path_parts_sanitized = pathinfo($path_parts['dirname'].'/'.$sanitized_filename);

    copy($link, $upload_dir['path'].'/'.$sanitized_filename);

    // $html = exec('ffmpeg -i ' . $link . ' ' .$path_parts['dirname'].'/'.$path_parts['filename'].'.'.$codec_value);

    // shell_exec('ffmpeg -i '.$path_parts['dirname'].'/'.$sanitized_filename.' -vn -acodec libmp3lame -ac 2 -qscale:a 4 -ar 48000 '.$upload_dir['path'].'/'.$path_parts_sanitized['filename'].$codec_value); 
    
    $html[] .= $upload_dir['path'].'/'.$path_parts_sanitized['filename'].$codec_value;

    $image_url = $upload_dir['path'].'/'.$path_parts_sanitized['filename'].$codec_value;

    $image_data = file_get_contents( $image_url );

    $filename = basename( $image_url );

    if ( wp_mkdir_p( $upload_dir['path'] ) ) {
    $file = $upload_dir['path'] . '/' . $filename;
    }
    else {
    $file = $upload_dir['basedir'] . '/' . $filename;
    }

    file_put_contents( $file, $image_data );

    $wp_filetype = wp_check_filetype( $filename, null );

    $url = $_POST['url'];
    $url_components = parse_url($url);
    parse_str($url_components['query'], $params);
    $playlist = $params['list'];
    $path_implode = $upload_dir['basedir'] . '/'.$playlist.'/';

    $jsonfileget = file_get_contents($path_implode.$path_parts['filename'].'.info.json');
    $jsonfile = json_decode($jsonfileget, true);

    $str_artists = str_replace("_", " ", $jsonfile['title']);

    $attachment = array(
    'post_mime_type' => $wp_filetype['type'],
    'post_title' => sanitize_file_name( $jsonfile['title'] ),
    'post_content' => '',
    'post_status' => 'inherit'
    );

    $attach_id = wp_insert_attachment( $attachment, $file );
    require_once( ABSPATH . 'wp-admin/includes/image.php' );
    $attach_data = wp_generate_attachment_metadata( $attach_id, $file );
    wp_update_attachment_metadata( $attach_id, $attach_data );

    $html[] .= $attach_id;
    $html[] .= $attach_data;

    $new_post = array(
        'post_title' => $str_artists,
        'post_content' => '',
        'post_status' => 'publish',
        'post_author' => get_current_user_id(),
        'post_type' => 'music',
        'post_category' => array(0)
    );
    $post_id = wp_insert_post($new_post);

    $name = esc_attr('music_link_');
    add_post_meta( $post_id, $name, $attach_id);

    $value = $rawvalue = esc_attr(get_post_meta( $post_id, $name, true ));
    $image = ! $rawvalue ? '' : get_attached_file( $rawvalue );
    $metadata = wp_read_audio_metadata( $image );
    add_post_meta( $post_id, "meta-box-track-length", gmdate( "i:s", $metadata['length'] ) );

    add_post_meta($post_id, "meta-box-track-number", $number);

    $termartist = get_term_by('id', $artistid, 'artist');
    wp_set_object_terms($post_id, $termartist->slug, 'artist');

    update_post_meta( $post_id, 'meta-box-media-cover_', $cover);

    $term_obj_list = get_the_terms( $post_id, 'artist' );

    $cover_media_id = get_post_meta( $post_id, "meta-box-media-cover_", true );

    foreach ($term_obj_list as $taxonomy) {
        $html[] .= $taxonomy->slug;
        update_post_meta($post_id, 'meta-box-artist', $taxonomy->slug);
    }

    update_post_meta($post_id, "meta-box-media-cover-name", get_the_title($cover_media_id));

    $html[] .= '</br>';

    rmdir($path_implode);

    return wp_send_json ( $html );
}

?>