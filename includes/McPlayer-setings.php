<?php
class MusicSettingsPage
{
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    /**
     * Start up
     */
    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
    }

    /**
     * Add options page
     */
    public function add_plugin_page()
    {
        // This page will be under "Settings"
        add_options_page(
            'Music Settings', 
            'Music', 
            'manage_options', 
            'my-setting-admin', 
            array( $this, 'create_admin_page' )
        );
    }

    /**
     * Options page callback
     */
    public function create_admin_page()
    {
        // Set class property
        $this->options = get_option( 'musics_option_name' );
        ?>
        <div class="wrap">
            <h1>Music Settings</h1>
            <form method="post" action="options.php">
            <?php
                // This prints out all hidden setting fields
                settings_fields( 'musics_option_group' );
                do_settings_sections( 'my-setting-admin' );
                submit_button();
            ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function page_init()
    {        
        register_setting(
            'musics_option_group', // Option group
            'musics_option_name', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            'setting_section_id', // ID
            'Settings', // channel
            array( $this, 'print_section_info' ), // Callback
            'my-setting-admin' // Page
        );  

        add_settings_field(
            'audio_rate', // ID
            'Sample rate of audio', // channel 
            array( $this, 'audio_rate_callback' ), // Callback
            'my-setting-admin', // Page
            'setting_section_id' // Section           
        );      

        add_settings_field(
            'audio_channel', 
            'Channel Stereo or mono', 
            array( $this, 'channel_callback' ), 
            'my-setting-admin', 
            'setting_section_id'
        );      
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input )
    {
        $new_input = array();
        if( isset( $input['audio_rate'] ) )
            $new_input['audio_rate'] = sanitize_text_field( $input['audio_rate'] );

        if( isset( $input['audio_channel'] ) )
            $new_input['audio_channel'] = sanitize_text_field( $input['audio_channel'] );

        return $new_input;
    }

    /** 
     * Print the Section text
     */
    public function print_section_info()
    {
        $sox_file = '/usr/bin/sox';

        print 'If SOX is istalled on the host, you can change audio encoding settings';

        echo '<br /><br />';

        if (file_exists($sox_file)) {
            print "SOX is install";
        } else {
            print "SOX is not install";
            print "apt-get install sox";
        }
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function audio_rate_callback()
    {
        printf(
            '<input type="text" id="audio_rate" name="musics_option_name[audio_rate]" value="%s" />',
            isset( $this->options['audio_rate'] ) ? esc_attr( $this->options['audio_rate']) : ''
        );
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function channel_callback()
    {
        printf(
            '<input type="text" id="audio_channel" name="musics_option_name[audio_channel]" value="%s" />',
            isset( $this->options['audio_channel'] ) ? esc_attr( $this->options['audio_channel']) : ''
        );
    }
}

if( is_admin() )
    $music_settings_page = new MusicSettingsPage();