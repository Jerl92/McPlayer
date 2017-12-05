<?php

///////////////////////////////////
//
//  MetaBox for select a audio file from media libray.
//  Because one post = one song.
//  And one image can be set for one album.
//
///////////////////////////////////
$meta_box_media_upload = new Meta_Box_Media_Upload();
class Meta_Box_Media_Upload {
    
	function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'setup_box' ) );
		add_action( 'save_post', array( $this, 'save_box' ), 10, 2 );
    }
    
	function setup_box() {
		add_meta_box( 'meta_box_id', __( 'Select a audio file to link to the music post', 'mcplayer' ), array( $this, 'meta_box_contents' ), 'music', 'normal' );
    }
    
	function meta_box_contents() {
		wp_enqueue_media();
		wp_nonce_field( 'nonce_action', 'nonce_name' );

        $name = esc_attr('music_link_');
        
        $value = $rawvalue = esc_attr(get_post_meta( get_the_id(), $name, true ));

        $image = ! $rawvalue ? '' : get_attached_file( $rawvalue );
        $link_url = wp_get_attachment_url( get_post_meta( get_the_id(), $name, true ));

        echo '<br />';

        echo "<div class='audio-preview'>$link_url</div>";

        echo '<br />';
                
        $attr = array(
            'src'      => $link_url,
            'loop'     => '',
            'autoplay' => '',
            'preload' => 'metadata',
        );

        echo wp_audio_shortcode( $attr );

        echo '<br />';
        echo "<input type='hidden' id='$name-value'  class='small-text'       name='meta-box-media[$name]'            value='$value' />";
        echo "<input type='button' id='$name'        class='button meta-box-upload-button-audio'        value='Upload' />";
        echo "<input type='button' id='$name-remove' class='button meta-box-upload-button-audio-remove' value='Remove' />";
        echo '<br />';

        $metadata = array();

        $metadata = wp_read_audio_metadata( $image );

        echo '<br />';

        // track_length
        $track_length = get_post_meta( get_the_id(), "meta-box-track-length", true );
        if ( $track_length == null || $track_length != gmdate( "i:s", $metadata['length'] ) )
            $track_length = gmdate( "i:s", $metadata['length'] );
        
        echo '<ul><li style="float: right;">';
        echo '<label for="meta-box-track-number">Track length</label>';
        echo '<br />';
        echo "<input type='text' readonly='readonly' id='track-length-value' class='text' name='meta-box-media-track-length'  value='$track_length' />";

        // track_number
        $track_number = get_post_meta(get_the_id(), "meta-box-track-number", true ); 
        if ( !$track_number )
            $track_number = esc_attr($metadata['track_number']);

        echo '</li><li>';
        echo '<label for="meta-box-track-number">Track number</label>';
        echo '<br />';
        echo "<input type='number' id='meta-box-track-number' class='text' name='meta-box-track-number'  value='$track_number' />";

        echo '</ul></li>';

        $post_title = get_the_title();
        if ( $post_title = '' )
            $post_title = $metadata['title'];

        echo '<br />';
    }



	function save_box( $post_id, $post ) {
		if ( ! isset( $_POST['nonce_name'] ) ) //make sure our custom value is being sent
			return;
		if ( ! wp_verify_nonce( $_POST['nonce_name'], 'nonce_action' ) ) //verify intent
			return;
		if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) //no auto saving
			return;
		if ( ! current_user_can( 'edit_post', $post_id ) ) //verify permissions
			return;
        if ( ! isset( $_POST['meta-box-media'] ) ) //make sure our custom value is being sent
			return; 

		$new_value = array_map( 'intval', $_POST['meta-box-media'] ); //sanitize
		foreach ( $new_value as $k => $v ) {
			update_post_meta( $post_id, $k, $v ); //save
        }

        if( ! isset( $_POST['meta-box-media-track-length'] ) )
            return; 

        update_post_meta( $post_id, "meta-box-track-length", $_POST['meta-box-media-track-length'] ); 

        
        if( ! isset( $_POST['meta-box-track-number'] ) )
            return; 
        
        update_post_meta( $post_id, "meta-box-track-number", $_POST['meta-box-track-number'] );
        
	}
}


///////////////////////////////////
//
//  MetaBox for select a audio file from media libray.
//  Because one post = one song.
//  And one image can be set for one album.
//
///////////////////////////////////
$meta_box_cover_upload = new meta_box_cover_upload();
class meta_box_cover_upload {
	function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'setup_box_cover' ) );
		add_action( 'save_post', array( $this, 'save_box_cover' ), 10, 2 );
    }
    
	function setup_box_cover() {
		add_meta_box( 'meta_box_cover_id', __( 'Use a image to be set as the album', 'some-meta-box-cover' ), array( $this, 'meta_box_contents_cover' ), 'music', 'normal' );
    }
    
	function meta_box_contents_cover() {
		wp_enqueue_media();
        
        wp_nonce_field( 'nonce_action', 'nonce_name' );
        
        $name = esc_attr( 'meta-box-media-cover_' );

        $value = $rawvalue = get_post_meta( get_the_id(), $name, true );
        $attachment_title = get_the_title($value);
        
        echo '<div id="metabox_music_upload_wrapper">';
            echo '<div id="metabox_audio_upload">';
                echo $attachment_title;
                echo '</br>';
                echo '</br>';
                echo get_post_meta( $value, 'meta-box-year', true );
                echo '</br>';
                echo get_post_meta( $value, 'meta-box-producer', true );
                echo '</br>';
                echo get_post_meta( $value, 'meta-box-editor', true );
                echo '</br>';
                echo get_post_meta( $value, 'meta-box-label', true );
                echo '</br>';
                echo get_post_meta( $value, 'meta-box-album-artist', true );
                echo '</br>';
                echo '<a href="';
                echo get_edit_post_link( $rawvalue );
                echo '">Edit image</a>';
                echo '</br>';
                echo "<input type='hidden' id='$name-value'  class='small-text'       name='meta-box-media[$name]'            value='$value' />";
                echo "<input type='button' id='$name'        class='button meta-box-upload-button'        value='Upload' />";
                echo "<input type='button' id='$name-remove' class='button meta-box-upload-button-remove' value='Remove' />";
                echo '</div>';
                echo '<div id="metabox_album_upload">';

                $image = ! $rawvalue ? '' : wp_get_attachment_image( $rawvalue, 'full', false, array('style' => 'max-width:350px;height:auto;') );

                echo '<br />';

                echo "<div class='image-preview'>$image</div>";
                echo '<br />';
            echo '</div>';
        echo '</div>';
	}

	function save_box_cover( $post_id, $post ) {
		if ( ! isset( $_POST['nonce_name'] ) ) //make sure our custom value is being sent
			return;
		if ( ! wp_verify_nonce( $_POST['nonce_name'], 'nonce_action' ) ) //verify intent
			return;
		if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) //no auto saving
			return;
		if ( ! current_user_can( 'edit_post', $post_id ) ) //verify permissions
			return;
        if ( ! isset( $_POST['meta-box-media'] ) ) //make sure our custom value is being sent
			return; 
		$new_value = array_map( 'intval', $_POST['meta-box-media'] ); //sanitize
		foreach ( $new_value as $k => $v ) {
			update_post_meta( $post_id, $k, $v ); //save
		}
	}
}


///////////////////////////////////
//
//  custom_meta_box_markup
//  
//  
//
///////////////////////////////////
function custom_meta_box_markup($object)
{

wp_nonce_field(basename(__FILE__), "meta-box-nonce");

?>
    <div>
        <ul style="display: flex; text-align: center;">
            <li style="padding-right: 10px;">
                
                <?php
                wp_nonce_field('artist-dropdown', 'dropdown-artist-nonce');
                $terms = get_terms( 'artist', 'hide_empty=0');
                if ( is_a( $terms, 'WP_Error' ) ) {
                    $terms = array();
                }

                $object_terms = wp_get_object_terms( $post->ID, 'artist' );
                if ( is_a( $object_terms, 'WP_Error' ) ) {
                    $object_terms = array();
                }

                echo "Artist:";
                echo '</br>';
                echo "<select id='artistoptions' name='customartist[]'>";
                $getslugid = wp_get_post_terms( $object->ID, 'artist', $args );

                foreach( $getslugid as $thisslug ) {
                    echo "<option value='$thisslug->term_id'>";
                    echo $thisslug->name . ' '; // Added a space between the slugs with . ' '
                    echo "</option>";
                }

                foreach ( $terms as $term ) {
                    if ( $term->parent == 0) {
                        if ( in_array($term->term_id, $object_terms) ) {
                            $parent_id = $term->term_id;
                            echo "<option value='{$term->term_id}' selected='selected'>{$term->name}</option>";
                        } else {
                            echo "<option value='{$term->term_id}'>{$term->name}</option>";
                        }
                    }
                }

                echo "</select><br />"; ?>

            </li>

            <li>
                Feat
                </br>
                <input name="meta-box-artist-feat" type="text" id="meta-box-artist-feat" value="<?php echo get_post_meta($object->ID, "meta-box-artist-feat", true); ?>" size="30">
            </li>

            <li style="padding-right: 10px;">
                
                <?php
                wp_nonce_field('genre-dropdown', 'dropdown-genre-nonce');
                $terms = get_terms( 'genre', 'hide_empty=0');
                if ( is_a( $terms, 'WP_Error' ) ) {
                    $terms = array();
                }

                $object_terms = wp_get_object_terms( $post->ID, 'genre', array('fields'=>'ids'));
                if ( is_a( $object_terms, 'WP_Error' ) ) {
                    $object_terms = array();
                }
                // you can move the below java script to admin_head

                echo "Genre:";
                echo '</br>';
                echo "<select id='genreoptions' name='customgenre[]'>";
                $getslugid = wp_get_post_terms( $object->ID, 'genre', $args );

                foreach( $getslugid as $thisslug ) {
                    echo "<option value='$thisslug->term_id'>";
                    echo $thisslug->name . ' '; // Added a space between the slugs with . ' '
                    echo "</option>";
                }

                foreach ( $terms as $term ) {
                    if ( $term->parent == 0) {
                        if ( in_array($term->term_id, $object_terms) ) {
                            $parent_id = $term->term_id;
                            echo "<option value='{$term->term_id}' selected='selected'>{$term->name}</option>";
                        } else {
                            echo "<option value='{$term->term_id}'>{$term->name}</option>";
                        }
                    }
                }

                echo "</select><br />"; ?>

            </li>

        </ul>

    </div>

<?php  
}

function add_custom_meta_box()
{
    add_meta_box("demo-meta-box", "Music Information", "custom_meta_box_markup", "music", "normal", "low", null);
}

add_action("add_meta_boxes", "add_custom_meta_box");


function save_custom_meta_box($post_id, $post, $update) {
    if (!isset($_POST["meta-box-nonce"]) || !wp_verify_nonce($_POST["meta-box-nonce"], basename(__FILE__)))
    return $post_id;

    if(!current_user_can("edit_post", $post_id))
        return $post_id;

    if(defined("DOING_AUTOSAVE") && DOING_AUTOSAVE)
        return $post_id;

    $slug = "music";
    if($slug != $post->post_type)
        return $post_id;

    if( ! isset( $_POST['meta-box-artist-feat'] ) )
    return; 
    
    update_post_meta( $post_id, "meta-box-artist-feat", $_POST['meta-box-artist-feat'] );

    if ( !wp_verify_nonce($_POST['dropdown-artist-nonce'], 'artist-dropdown'))
        return;
    $artist = array_map('intval', $_POST['customartist']);
    wp_set_object_terms($post_id, $artist, 'artist');

    if ( !wp_verify_nonce($_POST['dropdown-genre-nonce'], 'genre-dropdown') || !$_POST['customgenre'] )
        return;
        
    $genre = array_map('intval', $_POST['customgenre']);
    wp_set_object_terms($post_id, $genre, 'genre');
}

add_action("save_post", "save_custom_meta_box", 10, 3);

///////////////////////////////////
//
//  custom_meta_box_lyrics
//  
//  
//
///////////////////////////////////
function custom_meta_box_lyrics($object)
{

wp_nonce_field(basename(__FILE__), "meta-box-nonce");

?>
    <div style="text-align: center;">
        <textarea name="meta-box-music-lyric" id="meta-box-music-lyric" rows="15" cols="40" style="width: 95%; margin-left: 2.5%;" ><?php echo get_post_meta($object->ID, "meta-box-music-lyric", true); ?></textarea>
    </div>

<?php  
}

function add_lyrics_meta_box()
{
    add_meta_box("lyrics-meta-box", "Music lyrics", "custom_meta_box_lyrics", "music", "normal", "low", null);
}

add_action("add_meta_boxes", "add_lyrics_meta_box");


function save_lyrics_meta_box($post_id, $post, $update) {
    if (!isset($_POST["meta-box-nonce"]) || !wp_verify_nonce($_POST["meta-box-nonce"], basename(__FILE__)))
    return $post_id;

    if(!current_user_can("edit_post", $post_id))
        return $post_id;

    if(defined("DOING_AUTOSAVE") && DOING_AUTOSAVE)
        return $post_id;

    $slug = "music";
    if($slug != $post->post_type)
        return $post_id;

    if( ! isset( $_POST['meta-box-music-lyric'] ) )
    return; 
    
    update_post_meta( $post_id, "meta-box-music-lyric", $_POST['meta-box-music-lyric'] );

}

add_action("save_post", "save_lyrics_meta_box", 10, 3);

?>