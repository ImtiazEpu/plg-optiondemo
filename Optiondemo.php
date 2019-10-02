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
			add_action( 'init', array( $this, 'opd_custom_post_type' ) );
			add_action( 'init', array( $this, 'ClassInitiate' ) );
			add_action( 'plugins_loaded', array( $this, 'optionsdemo_load_textdomain' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'optionsdemo_assets' ) );
		}
		//End method constructor
		
		
		/**
		 * Register Custom Post Type
		 */
		public function opd_custom_post_type() {
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
		//End method opd_custom_post_type
		
		
		/**
		 * Class Initiate
		 */
		public function ClassInitiate() {
			require( "inc/Metabox.php" );
			require( "inc/SettingOptions.php" );
		}
		//End method ClassInitiate
		
		
		/**
		 * Load Text Domain
		 */
		public function optionsdemo_load_textdomain() {
			load_plugin_textdomain( 'optionsdemo', false, dirname( __FILE__ ) . "/languages" );
		}
		//end method optionsdemo_load_textdomain
		
		/**
		 * Enqueue admin assets
		 */
		public function optionsdemo_assets() {
			global $post_type;
			$page = isset( $_REQUEST['page'] ) ? esc_attr( wp_unslash( $_REQUEST['page'] ) ) : '';
			
			
			if ( $page == 'optionsdemo' || $post_type == 'optiondemo' ) {
				wp_enqueue_media();
				wp_enqueue_script( 'customscript-js', plugins_url( '/assets/js/custom.js', __FILE__ ),
					array( 'jquery' ), '1.0.0', true );
			}
		}
		// End method optionsdemo_assets
		
		
	}//end OptionDemo_Setting_Page class
	
	
	new OptionDemo_Setting_Page();