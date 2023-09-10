<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       jerl92.tk
 * @since      1.0.0
 *
 * @package    Mcplayer
 * @subpackage Mcplayer/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Mcplayer
 * @subpackage Mcplayer/public
 * @author     jerl92 <jeremie.langevin@outlook.com>
 */
class Mcplayer_Public
{

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{

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

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/McPlayer-public.css', array(), $this->version, 'all');

		wp_enqueue_style('player56s', plugin_dir_url(__FILE__) . 'css/player56s.css', array(), $this->version, 'all');

		wp_enqueue_style('rs-save-for-later', plugin_dir_url(__FILE__) . 'css/rs-save-for-later-public.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{

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

		// wp_enqueue_script( 'aurora',  plugin_dir_url( __FILE__ ) . 'js/aurora.js/aurora.js', array( 'jquery' ), $this->version, false );

		// wp_enqueue_script( 'mp3',  plugin_dir_url( __FILE__ ) . 'js/aurora.js/mp3.js', array( 'jquery' ), $this->version, false );

		wp_enqueue_script('jquery-ui', plugin_dir_url(__FILE__) . 'js/jquery-ui.js', array('jquery'), $this->version, false);

		// wp_enqueue_script( 'aim',  plugin_dir_url( __FILE__ ) . 'js/jquery.aim.js', array( 'jquery' ), $this->version, false );

		//	wp_enqueue_script( 'network-information',  plugin_dir_url( __FILE__ ) . 'js/network-information.js', array( 'jquery' ), $this->version, false );	

		//	wp_enqueue_script( 'transition',  plugin_dir_url( __FILE__ ) . 'js/transition.js', array( 'jquery' ), $this->version, false );

		// wp_enqueue_script( 'resizesensor',  plugin_dir_url( __FILE__ ) . 'js/resizeSensor.js', array( 'jplayer' ), $this->version, false );

		wp_enqueue_script('jplayer',  plugin_dir_url(__FILE__) . 'js/jplayer.js', array('jquery'), $this->version, false);

		wp_enqueue_script('player56s',  plugin_dir_url(__FILE__) . 'js/player56s.js', array('jplayer'), $this->version, false);

		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/McPlayer-public.js', array('jquery'), $this->version, false);

		wp_enqueue_script('smoothState',  plugin_dir_url(__FILE__) . 'js/jquery.smoothState.js', array('jquery'), $this->version, false);

		wp_enqueue_script('smoothStatejs',  plugin_dir_url(__FILE__) . 'js/smoothState.js', array('smoothState'), $this->version, false);
	}
}
