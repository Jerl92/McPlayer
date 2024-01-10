<?php

    /*
    * Add a meta box
    */
    function playlist_meta_box_add() {
            wp_enqueue_media();
        add_meta_box('playlistbox', // meta box ID
            'Add musics to playlist', // meta box title
            'playlist_print_box', // callback function that prints the meta box HTML 
            'playlist', // post type where to add it
            'normal', // priority
            'high' ); // position
    }
    add_action( 'admin_menu', 'playlist_meta_box_add' );
    

    // Function that returns post titles from specific post type as form select element
    // returns null if found no results.
    function output_projects_list() {

    }

    /*
    * Meta Box HTML
    */
    function playlist_print_box( $post ) {

        $matches = get_post_meta($post->ID, 'rs_saved_for_later');

        foreach ($matches as $matche) {
            foreach ($matche as $matche_) {
                foreach ($matche_ as $matche__) {
                    $matches___[] .= $matche__;
                }  
            }      
        }

        $args = array( 
            'posts_per_page' => -1,	
            'post_type' => 'music',
            'post__in' => $matches___,
            'order'   => 'DESC',
            'orderby'   => 'post__in',
        );
		
		$loop = new WP_Query( $args );

		if ( $loop->have_posts() ) : ?>

			<?php ob_start(); ?>
			
			<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
					
					<?php get_template_part( 'template-parts/page-music-archive-sidebar', get_post_format() ); ?>
			
			<?php endwhile; // end of the loop. ?>
	
			<?php wp_reset_postdata(); ?>

			<?php echo '<div id="rs-saved-for-later-wrapper" class="noselect"><ul id="rs-saved-for-later" class="rs-saved-for-later">' . ob_get_clean() . '</ul></div>'; ?>

		<?php else : ?>

			<?php echo '<div id="rs-saved-for-later-wrapper" class="noselect"><ul id="rs-saved-for-later" class="rs-saved-for-later"><li style="text-align: center; padding:15px 0;">Nothing in the playlist</li></ul></div>'; ?>

		<?php endif;

    }

    /**
    * Add Photographer Name and URL fields to media uploader
    *
    * @param $form_fields array, fields to include in attachment form
    * @param $post object, attachment record in database
    * @return $form_fields, modified form fields
    */
    
    function be_attachment_field_credit( $form_fields, $post ) {
        $type = get_post_mime_type($post->ID);
        
        if(strpos($type, 'image') === 0) {

            $getslugid = wp_get_post_terms( $post->ID, 'artist' );

            $userid = get_current_user_id();                
            $terms = get_terms("artist", "orderby=name&hide_empty=0");
            $artist = get_user_meta( $userid, '_artist_role_set', true );

            $html[] = "<select id='artistoptions' name='customartist[]'>";
            if ( !is_wp_error( $terms ) ) {
                if($artist){
                    foreach ( $terms as $term ) {
                        if($artist == $term->term_id) {
                            $html[] .= "<option value='{$term->term_id}'>";
                            $html[] .= $term->name . ' '; // Added a space between the slugs with . ' '
                            $html[] .= "</option>";
                        }
                    }
                } else {

                    foreach( $getslugid as $thisslug ) {
                        $html[] .= "<option value='$thisslug->term_id'>";
                        $html[] .= $thisslug->name . ' '; // Added a space between the slugs with . ' '
                        $html[] .= "</option>";
                    }
    
                    foreach ( $terms as $term ) {
                        if ( $term->parent == 0) {
                            if ( in_array($term->term_id, $object_terms) ) {
                                $parent_id = $term->term_id;
                                $html[] .= "<option value='{$term->term_id}' selected='selected'>{$term->name}</option>";
                            } else {
                                $html[] .= "<option value='{$term->term_id}'>{$term->name}</option>";
                            }
                        }
                    }

                }
            }

            $html[] .= "</select><br />";
            
            $form_fields['meta-box-artist'] = array(
                'label' => 'Artist',
                'input' => 'html',
                'html' => implode($html),
                'helps' => 'Artist of the album',
            );
            $form_fields['meta-box-year'] = array(
                'label' => 'Year',
                'input' => 'text',
                'value' => get_post_meta( $post->ID, 'meta-box-year', true ),
                'helps' => 'Year of the album',
            );
            $form_fields['meta-box-label'] = array(
                'label' => 'Label',
                'input' => 'text',
                'value' => get_post_meta( $post->ID, 'meta-box-label', true ),
                'helps' => 'label of the album',
            );
            $form_fields['meta-box-producer'] = array(
                'label' => 'Producer',
                'input' => 'text',
                'value' => get_post_meta( $post->ID, 'meta-box-producer', true ),
                'helps' => 'Producer of the album',
            );    
            $form_fields['meta-box-editor'] = array(
                'label' => 'Editor',
                'input' => 'text',
                'value' => get_post_meta( $post->ID, 'meta-box-editor', true ),
                'helps' => 'editor of the album',
            );

            return $form_fields;
        } 
    }
    
    add_filter( 'attachment_fields_to_edit', 'be_attachment_field_credit', 10, 2 );
    
    /**
    * Save values of Photographer Name and URL in media uploader
    *
    * @param $post array, the post data for database
    * @param $attachment array, attachment fields from $_POST form
    * @return $post array, modified post data
    */
    
    function be_attachment_field_credit_save( $post, $attachment ) {       
        $artist = array_map('intval', $_POST['customartist']);
        wp_set_object_terms($post['ID'], $artist, 'artist');
        $term_obj_list = get_the_terms( $post['ID'], 'artist' );
        foreach ($term_obj_list as $taxonomy) {
            update_post_meta($post['ID'], 'meta-box-artist', $taxonomy->slug);
        } 
        if( isset( $attachment['meta-box-year'] ) )
            update_post_meta( $post['ID'], 'meta-box-year', $attachment['meta-box-year'] );
        if( isset( $attachment['meta-box-producer'] ) )
            update_post_meta( $post['ID'], 'meta-box-producer', $attachment['meta-box-producer'] );
        if( isset( $attachment['meta-box-editor'] ) )
            update_post_meta( $post['ID'], 'meta-box-editor', $attachment['meta-box-editor'] );
        if( isset( $attachment['meta-box-label'] ) )
            update_post_meta( $post['ID'], 'meta-box-label', $attachment['meta-box-label'] );

        return $post;
    }
    
    add_filter( 'attachment_fields_to_save', 'be_attachment_field_credit_save', 10, 2 );

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
            // 'feat' => __( 'Feat.' ),
            'album' => __( 'Album' ),
            'year' => __( 'Year' ),
            'cover' => __( 'Cover' ),
            'ifaudio' => __( 'File' ),
            'time' => __( 'Time' ),
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
        echo '.column-track { display: table-cell; width: 75px; }';
        echo '@media only screen and (max-width: 782px) {';
        echo 'td:not(.column-primary)::before { display: none !important; }';
        echo '.column-track { display: none !important; }';
        echo '}';
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
                echo wp_get_attachment_image( $cover_media_id, 'thumbnail', false, array('style' => 'max-width:100%;height:auto;') );
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

            case 'time' :
                echo get_post_meta( $post->ID, 'meta-box-track-length', true );
            break;

            /* Just break out of the switch statement for everything else. */
            default :
                break;
        }
    }
    add_action( 'manage_music_posts_custom_column', 'my_manage_music_columns', 10, 2 );

    ////////////////////////////
    //
    //  Filter Music admin colums 
    //  by artist and genre
    //
    ///////////////////////////
    function filter_cars_by_taxonomies( $post_type, $which ) {
        
        // Apply this only on a specific post type
        if ( 'music' !== $post_type )
            return;
    
        // A list of taxonomy slugs to filter by
        $taxonomies = array( 'artist', 'genre' );
    
        foreach ( $taxonomies as $taxonomy_slug ) {
    
            // Retrieve taxonomy data
            $taxonomy_obj = get_taxonomy( $taxonomy_slug );
            $taxonomy_name = $taxonomy_obj->labels->name;
    
            // Retrieve taxonomy terms
            $terms = get_terms( $taxonomy_slug );
    
            // Display filter HTML
            echo "<select name='{$taxonomy_slug}' id='{$taxonomy_slug}' class='postform'>";
            echo '<option value="">' . sprintf( esc_html__( 'Show All %s', 'text_domain' ), $taxonomy_name ) . '</option>';
            foreach ( $terms as $term ) {
                printf(
                    '<option value="%1$s" %2$s>%3$s (%4$s)</option>',
                    $term->slug,
                    ( ( isset( $_GET[$taxonomy_slug] ) && ( $_GET[$taxonomy_slug] == $term->slug ) ) ? ' selected="selected"' : '' ),
                    $term->name,
                    $term->count
                );
            }
            echo '</select>';
        }
    
    }
    add_action( 'restrict_manage_posts', 'filter_cars_by_taxonomies' , 10, 2);

    function my_column_register_sortable( $columns ) {
        $columns['track'] = 'track';
        $columns['artist'] = 'artist';
        $columns['album'] = 'album';
        $columns['year'] = 'year';
        $columns['time'] = 'time';
        return $columns;
    }

    add_filter("manage_edit-music_sortable_columns", "my_column_register_sortable" );

    add_action( 'pre_get_posts', 'my_slice_orderby' );
    function my_slice_orderby( $query ) {
        if( ! is_admin() )
            return;

        $orderby = $query->get( 'orderby');
        $order = $query->get( 'order');

        if( 'track' == $orderby ) {
            $query->set('meta_key','meta-box-track-number');
            $query->set('orderby','meta_value_num');
            if($order == 'asc') {
                $query->set('order','ASC');
            }
            if($order == 'desc') {
                $query->set('order','DESC');
            }
        } elseif('artist' == $orderby) {
            $query->set('meta_key','meta-box-artist');
            $query->set('orderby','meta_value');
            if($order == 'asc') {
                $query->set('order','ASC');
            }
            if($order == 'desc') {
                $query->set('order','DESC');
            }
        } elseif('year' == $orderby) {
            $query->set('meta_key','meta-box-year');
            $query->set('orderby','meta_value_num');
            if($order == 'asc') {
                $query->set('order','ASC');
            }
            if($order == 'desc') {
                $query->set('order','DESC');
            }
        } elseif('album' == $orderby) {
            $query->set('meta_key','meta-box-media-cover-name');
            $query->set('orderby','meta_value');
            if($order == 'asc') {
                $query->set('order','ASC');
            }
            if($order == 'desc') {
                $query->set('order','DESC');
            }
        } elseif('time' == $orderby) {
            $query->set('meta_key','meta-box-track-length');
            $query->set('orderby','meta_value');
            if($order == 'asc') {
                $query->set('order','ASC');
            }
            if($order == 'desc') {
                $query->set('order','DESC');
            }
        }
    }

?>