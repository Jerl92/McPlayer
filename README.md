# McPlayer-Core</br>

Tags: Music Player, Full Width, Playlist,</br>
Requires at least: 4.9</br>
Tested up to: 4.9.1</br>
Stable tag: 4.9</br>
License: GPLv2 or later</br>
License URI: http://www.gnu.org/licenses/gpl-2.0.html</br>

## A Full-width Audio Player With Playlist, Plugin for WordPress.</br>

<img style="max-width: 100%;" src="https://image.ibb.co/iJoftS/mcplayer_index.gif" alt="MCPlayer" data-canonical-src="https://image.ibb.co/iJoftS/mcplayer_index.gif" />

McPlayer is a full-width HTML5/JS/AJAX audio Player with Playlist, Plugin for WordPress.</br>

Why McPlayer instead of WP-Player, WPPlayer, WpPlayer or Wp-Player. Good question?</br>
Maybe because of girlfriend, or maybe Mc more like rapper, or Mc like McDonald's ?</br>
NO... Mc is for "Media Center". That It !</br>
Someday the name of the plugin will change, because McPlayer is more like a beta code name.</br>

## Description</br>

McPlayer is build with JS from</br>

https://github.com/miguel-perez/smoothState.js</br>
Unobtrusive page transitions with jQuery.</br>

https://github.com/jplayer/jPlayer</br>
HTML5 Audio & Video for jQuery</br>

https://github.com/dymio/player-56s</br>
Web audio-player with playlist and minimalistic view as option.</br>

https://WordPress.org/plugins/rs-save-for-later/</br>
Simplicity Save for Later will add a button to your posts/pages/custom post types so users can save that content so they can access it later.</br>

https://github.com/cihadturhan/jquery-aim</br>
jQuery plugin anticipates on which element user is going to hover/click.</br>

https://github.com/jquery/jquery-ui</br>
Interactions and Widgets for the web. jQuery UI is a curated set of user interface interactions, effects, widgets, and themes built on top of jQuery.</br>

https://WordPress.org/plugins/categories-images/</br>
This plugin is dependency for McPlayer-Core</br>

## Installation

This section describes how to install the plugin and get it working.

1. Your server need to have SOX installed on it. apt-get install sox http://sox.sourceforge.net/</br>
<code>sox ' . get_attached_file($attachment_ID) . ' -r 32000 -c 1 --norm -C -1 ' . get_attached_file($attachment_ID) . '.ogg</code>
2. Upload `McPlayer.php` to the `/wp-content/plugins/` directory
3. Activate the plugin through the 'Plugins' menu in WordPress
4. Set shortcode in page ['artist_get_shortcode'] [pre_order_products per_page="50" columns="5" order="'rand" orderby="rand"]
5. Don't froget to add the player and playlist widget with the child theme.

## Frequently Asked Questions

Help! My $(document).ready() plugins work fine when I refresh but break on the second page load.

```js
function myFonction($) {

    $.fn.ready();
      'use strict';

      // js Code using $ as usual goes here
}

jQuery(document).ready(function($) {
  myFonction($);
});
```

https://github.com/miguel-perez/smoothState.js#faq

## Changelog

### 0.1 - iPhone/Safari is working with some few issue, no device to test with.

Init version of this plugin, a lots of QA hours have been done with Chrome and Firefox, both work great.

## Screenshots
<img style="max-width: 100%;" src="https://img15.hostingpics.net/pics/809953mcplayer1.jpg" alt="MCPlayer" data-canonical-src="https://img15.hostingpics.net/pics/809953mcplayer1.jpg" />
<img style="max-width: 100%;" src="https://img15.hostingpics.net/pics/797972mcplayer2.jpg" alt="MCPlayer" data-canonical-src="https://img15.hostingpics.net/pics/797972mcplayer2.jpg" />
<img style="max-width: 100%;" src="https://img15.hostingpics.net/pics/971888mcplayeradmin2.jpg" alt="MCPlayer" data-canonical-src="https://img15.hostingpics.net/pics/971888mcplayeradmin2.jpg" />
<img style="max-width: 100%;" src="https://img15.hostingpics.net/pics/499681mcplayeradmin1.jpg" alt="MCPlayer" data-canonical-src="https://img15.hostingpics.net/pics/499681mcplayeradmin1.jpg" />
= Without cache =
<img style="max-width: 100%;" src="https://img15.hostingpics.net/pics/608363waterfall.gif" alt="No cache" data-canonical-src="https://img15.hostingpics.net/pics/608363waterfall.gif" />
= With cache =
<img style="max-width: 100%;" src="https://img15.hostingpics.net/pics/713595waterfall2.gif" alt="With cache" data-canonical-src="https://img15.hostingpics.net/pics/713595waterfall2.gif" />
= AJAX Requests =
<img style="max-width: 100%;" src="https://img15.hostingpics.net/pics/323462console.png" alt="MCPlayer" data-canonical-src="https://img15.hostingpics.net/pics/323462console.png" />
= Partial Content =
<img style="max-width: 100%;" src="https://img15.hostingpics.net/pics/878297console2.png" alt="MCPlayer" data-canonical-src="https://img15.hostingpics.net/pics/878297console2.png" />

## Admin Columns
```js
    ////////////////////////////
    //
    //  my_edit_music_columns( $columns )
    //  Music CPT admin colums
    //
    ///////////////////////////
    function my_edit_music_columns( $columns ) {
        $columns = array(
            'cb' => '<input type="checkbox" />',
            'track' => __( 'Track' ),
            'title' => __( 'Music' ),
            'artist' => __( 'Artist' ),
            'feat' => __( 'Feat.' ),
            'album' => __( 'Album' ),
            'year' => __( 'Year' ),
            'cover' => __( 'Cover' ),
            'ifaudio' => __( 'File' ),
            'date' => __( 'Date' )
        );
        return $columns;
    }
    add_filter( 'manage_edit-music_columns', 'my_edit_music_columns' ) ;
    ////////////////////////////
    //
    //  Style for admin CPT music colums track
    //  width 50px
    //
    ///////////////////////////
    function my_column_width() {
        echo '<style type="text/css">';
        echo '.column-track { display: block; width:50px; }';
        echo '</style>';
    }
    add_action('admin_head', 'my_column_width');
    ////////////////////////////
    //
    //  my_manage_music_columns( $column, $post_id )
    //  Music CPT admin colums, case
    //
    ///////////////////////////
    function my_manage_music_columns( $column, $post_id ) {
        global $post;
        $cover_media_id = get_post_meta( get_the_id(), "meta-box-media-cover_", true );
        switch( $column ) {
            case 'track' :
            // Retrieve post meta
            $tracknb = get_post_meta( $post->ID, 'meta-box-track-number', true );
            
            // Echo output and then include break statement
            echo '#' . $tracknb;
            break;
            /* If displaying the 'duration' column. */
            case 'artist' :
                /* Get the genres for the post. */
                $terms = get_the_terms( $post_id, 'artist' );
                /* If terms were found. */
                if ( !empty( $terms ) ) {
                    $out = array();
                    /* Loop through each term, linking to the 'edit posts' page for the specific term. */
                    foreach ( $terms as $term ) {
                        $out[] = sprintf( '<a href="%s">%s</a>',
                            esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'artist' => $term->slug ), 'edit.php' ) ),
                            esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'artist', 'display' ) )
                        );
                    }
                    /* Join the terms, separating them with a comma. */
                    echo join( ', ', $out );
                }
                /* If no terms were found, output a default message. */
                else {
                    _e( 'No artists' );
                }
            break;
            case 'feat' :
                // Retrieve post meta
                $feat_meta = get_post_meta( $post->ID, 'meta-box-artist-feat', true );
                
                // Echo output and then include break statement
                echo $feat_meta;
            break;
            case 'album' :
                echo get_the_title( $cover_media_id );
            break;
            case 'year' :
                echo get_post_meta( $cover_media_id, 'meta-box-year', true );
            break;
            case 'cover' :
                echo wp_get_attachment_image( $cover_media_id, 'thumbnail', false, array('style' => 'max-width:450px;height:auto;') );
            break;
            case 'ifaudio' :
                // echo wp_get_attachment_image( $cover_media_id, 'thumbnail', false, array('style' => 'max-width:450px;height:auto;') );
                $get_music_link_id = get_post_meta( $post->ID, 'music_link_', true );
                if ($get_music_link_id != '' && $get_music_link_id != '0') {
                    echo '✔️';
                    echo '</br>';
                    echo $get_music_link_id;
                    echo '</br>';
                    echo get_the_title( $get_music_link_id );
                } else {
                    echo '❌️️';
                }
            break;
            /* Just break out of the switch statement for everything else. */
            default :
                break;
        }
    }
    add_action( 'manage_music_posts_custom_column', 'my_manage_music_columns', 10, 2 );
   ```
