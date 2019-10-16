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
			add_action( 'init', array( $this, 'opd_register_taxonomy_course' ) );
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
		 * Taxonomy "Course Added"
		 */
		public function opd_register_taxonomy_course() {
			
			$labels = [
				'name'              => __( 'Courses', 'optionsdemo' ),
				'singular_name'     => __( 'Course', 'optionsdemo' ),
				'search_items'      => __( 'Search Courses' ),
				'all_items'         => __( 'All Courses' ),
				'parent_item'       => __( 'Parent Course' ),
				'parent_item_colon' => __( 'Parent Course:' ),
				'edit_item'         => __( 'Edit Course' ),
				'update_item'       => __( 'Update Course' ),
				'add_new_item'      => __( 'Add New Course' ),
				'new_item_name'     => __( 'New Course Name' ),
				'menu_name'         => __( 'Course' ),
			];
			$args   = [
				'hierarchical'      => true,
				'labels'            => $labels,
				'show_ui'           => true,
				'show_admin_cloumn' => true,
				'query_var'         => true,
				'rewrite'           => [ 'slug' => 'course' ],
			];
			
			register_taxonomy( 'course', [ 'optiondemo' ], $args );
		}
		//End method opd_register_taxonomy_course
		
		
		/**
		 * Load Metabox & setting options
		 */
		public function ClassInitiate() {
			if (file_exists(dirname(__FILE__).'/inc/MetaBox.php')) {
				require_once( dirname(__FILE__).'/inc/MetaBox.php' );
			}
			if (file_exists(dirname(__FILE__).'/inc/SettingOptions.php')) {
				require_once( dirname(__FILE__).'/inc/SettingOptions.php' );
			}
			if (file_exists(dirname(__FILE__).'/inc/UsersProfile.php')) {
				require_once( dirname(__FILE__).'/inc/UsersProfile.php' );
			}
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
			global $pagenow;
			$page = isset( $_REQUEST['page'] ) ? esc_attr( wp_unslash( $_REQUEST['page'] ) ) : '';
			
			
			if ( $page == 'optionsdemo' || $post_type == 'optiondemo'  ) {
				
				wp_enqueue_media();
				wp_enqueue_style('bootstrap-css','//stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css',null,time());
				wp_enqueue_style('jquery-ui-css','//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css',null,time());
				
				wp_enqueue_script( 'customscript-js', plugins_url( '/assets/js/custom.js', __FILE__ ),
					array( 'jquery','jquery-ui-datepicker' ), time(), true );
			}elseif( $pagenow == 'profile.php'){
				wp_enqueue_style('jquery-ui-css','//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css',null,time());
				
				wp_enqueue_script( 'customscript-js', plugins_url( '/assets/js/custom.js', __FILE__ ),
					array( 'jquery','jquery-ui-datepicker' ), time(), true );
			}
		}
		// End method optionsdemo_assets
		
		
	}//end OptionDemo_Setting_Page class
	
	
	new OptionDemo_Setting_Page();