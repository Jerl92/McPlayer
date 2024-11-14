<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       jerl92.tk
 * @since      1.0.0
 *
 * @package    Mcplayer
 * @subpackage Mcplayer/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Mcplayer
 * @subpackage Mcplayer/admin
 * @author     jerl92 <jeremie.langevin@outlook.com>
 */
class Mcplayer_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $Mcplayer    The ID of this plugin.
	 */
	private $Mcplayer;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $Mcplayer       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $Mcplayer, $version ) {

		$this->Mcplayer = $Mcplayer;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Mcplayer_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Mcplayer_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->Mcplayer, plugin_dir_url( __FILE__ ) . 'css/McPlayer-admin.css', array(), $this->version, 'all' );

		wp_enqueue_style( 'McPlayer-public', plugin_dir_url( __FILE__ ) . 'css/McPlayer-public.css', array(), $this->version, 'all' );

		wp_enqueue_style( 'rs-save-for-later-public', plugin_dir_url( __FILE__ ) . 'css/rs-save-for-later-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Mcplayer_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Mcplayer_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		/* Ajax remove all track from playlist */

		wp_enqueue_script( 'wp-media-uploader', plugin_dir_url( __FILE__ ) . 'js/wp-media-uploader.js', array( 'jquery' ), $this->version, false );

		wp_enqueue_script( $this->Mcplayer, plugin_dir_url( __FILE__ ) . 'js/McPlayer-admin.js', array( 'jquery' ), $this->version, false );

		wp_enqueue_script( 'chart', plugin_dir_url( __FILE__ ) . 'js/chart.js', array( 'jquery' ), $this->version, false );

		wp_enqueue_script( 'loader', plugin_dir_url( __FILE__ ) . 'js/loader.js', array( 'jquery' ), $this->version, false );

	}

}