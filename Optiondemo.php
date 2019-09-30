<?php
	/*
	Plugin Name: Option Demo
	Plugin URL:
	Description: Demo of Plugin Options Page
	Version: 1.0
	Author: Imtiaz Epu
	Author URI: https://imtiazepu.com
	License: GPLv2 or later
	Text Domain:optionsdemo
	Domain Path: /languages/
	*/
	
	
	/**
	 * Kick-in Class OptionDemo_Setting_Page
	 */
	class OptionDemo_Setting_Page {
		
		/**
		 * OptionDemo_Setting_Page constructor.
		 */
		public function __construct() {
			add_action( 'init', array( $this, 'cbx_custom_post_type' ) );
			add_action( 'init', array( $this, 'ClassInitiate' ) );
			add_action( 'plugins_loaded', array( $this, 'optionsdemo_load_textdomain' ) );
		}
		//End method constructor
		
		
		/**
		 * Register Custom Post Type
		 */
		public function cbx_custom_post_type() {
			register_post_type( 'optiondemo',
				array(
					'labels'      => array(
						'name'          => 'Custom Post',
						'singular_name' => 'Custom Post'
					),
					'public'      => true,
					'has_archive' => true,
					'supports'    => array( 'title', 'editor', 'thumbnail' ),
				)
			);
		}
		
		//End method cbx_custom_post_type
		
		
		/**
		 * Class Initiate
		 */
		public function ClassInitiate() {
			require( "inc/Metabox.php" );
			require( "inc/SettingOptions.php" );
		}
		
		
		/**
		 * Load Text Domain
		 */
		public function optionsdemo_load_textdomain() {
			load_plugin_textdomain( 'optionsdemo', false, dirname( __FILE__ ) . "/languages" );
		}
		//end method optionsdemo_load_textdomain
		
	}//end OptionDemo_Setting_Page class
	
	
	new OptionDemo_Setting_Page();