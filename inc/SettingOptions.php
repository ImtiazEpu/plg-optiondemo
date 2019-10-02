<?php
	
	/**
	 * Kick-in Class SettingOptions
	 */
	class SettingOptions {
		
		/**
		 * SettingOptions constructor.
		 */
		public function __construct() {
			add_action( 'admin_menu', array( $this, 'optionsdemo_create_settings' ) );
			//setting hooks
			add_action( 'admin_init', array( $this, 'optionsdemo_setup_sections' ) );
			add_action( 'admin_init', array( $this, 'optionsdemo_setup_fields' ) );
		}
		//End method constructor
		
		/**
		 * Initial settings
		 */
		public function optionsdemo_create_settings() {
			$parent_slug = 'edit.php?post_type=optiondemo';
			$page_title  = esc_html__( 'Settings', 'optionsdemo' );
			$menu_title  = esc_html__( 'Settings', 'optionsdemo' );
			$capability  = 'manage_options';
			$slug        = 'optionsdemo';
			$callback    = array( $this, 'optionsdemo_settings_content' );
			
			//add submenu to custom post
			add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $slug, $callback );
		}
		//End method optionsdemo_create_settings
		
		
		/**
		 * Option page callback function
		 */
		public function optionsdemo_settings_content() { ?>
            <div class="wrap">
                <div id="icon-themes" class="icon32"><br/></div>
                <h1>Options Demo</h1>
                <form action="options.php" method="POST">
					<?php
						settings_fields( "optionsdemo_general" );
						do_settings_sections( "optionsdemo_general" );
						
						
						submit_button( esc_html__( 'Save Setting', 'optionsdemo' ) )
					?>
                </form>
            </div>
		<?php }
		//end method optionsdemo_settings_content
		
		
		/**
		 * Initial Section
		 */
		public function optionsdemo_setup_sections() {
			add_settings_section( "optionsdemo_section", esc_html__( "Section Title One", "optionsdemo" ), array(),
				"optionsdemo_general" );
			
		}
		//end method optionsdemo_setup_sections
		
		
		/**
		 * Initial setting field
		 */
		public function optionsdemo_setup_fields() {
			
			$fields = array(
				array(
					'label'       => esc_html__( 'Text field', 'optionsdemo' ),
					'id'          => 'optionsdemo_textfield',
					'type'        => 'text',
					'section'     => 'optionsdemo_section',
					'placeholder' => esc_html__( 'Text field', 'optionsdemo' ),
					'option_name' => 'optionsdemo_general'
				),
				
				array(
					'label'       => esc_html__( 'Email field', 'optionsdemo' ),
					'id'          => 'optionsdemo_email',
					'type'        => 'email',
					'section'     => 'optionsdemo_section',
					'placeholder' => esc_html__( 'Email field', 'optionsdemo' ),
					'option_name' => 'optionsdemo_general'
				),
				
				array(
					'label'       => esc_html__( 'Password field', 'optionsdemo' ),
					'id'          => 'optionsdemo_password',
					'type'        => 'password',
					'section'     => 'optionsdemo_section',
					'placeholder' => esc_html__( 'Password field', 'optionsdemo' ),
					'option_name' => 'optionsdemo_general'
				),
				
				array(
					'label'       => esc_html__( 'Number field', 'optionsdemo' ),
					'id'          => 'optionsdemo_number',
					'type'        => 'number',
					'section'     => 'optionsdemo_section',
					'placeholder' => esc_html__( 'Number field', 'optionsdemo' ),
					'min'         => 1,
					'max'         => 5,
					'option_name' => 'optionsdemo_general'
				),
				
				array(
					'label'       => esc_html__( 'URL field', 'optionsdemo' ),
					'id'          => 'optionsdemo_url',
					'type'        => 'url',
					'section'     => 'optionsdemo_section',
					'placeholder' => esc_html__( 'URL field', 'optionsdemo' ),
					'option_name' => 'optionsdemo_general'
				),
				
				array(
					'label'       => esc_html__( 'Textarea', 'optionsdemo' ),
					'id'          => 'optionsdemo_textarea',
					'type'        => 'textarea',
					'section'     => 'optionsdemo_section',
					'placeholder' => esc_html__( 'Textarea', 'optionsdemo' ),
					'option_name' => 'optionsdemo_general'
				),
				
				array(
					'label'       => esc_html__( 'Multiple Checkbox', 'optionsdemo' ),
					'id'          => 'optionsdemo_checkbox',
					'type'        => 'checkbox',
					'section'     => 'optionsdemo_section',
					'countries'   => array(
						esc_html__( 'Afghanistan', 'optionsdemo' ),
						esc_html__( 'Bangladesh', 'optionsdemo' ),
						esc_html__( 'Bhutan', 'optionsdemo' ),
						esc_html__( 'India', 'optionsdemo' ),
						esc_html__( 'Maldives', 'optionsdemo' ),
						esc_html__( 'Nepal', 'optionsdemo' ),
						esc_html__( 'Pakistan', 'optionsdemo' ),
						esc_html__( 'Sri Lanka', 'optionsdemo' )
					),
					'option_name' => 'optionsdemo_general'
				),
				array(
					'label'       => esc_html__( 'Radio', 'optionsdemo' ),
					'id'          => 'optionsdemo_radio',
					'type'        => 'radio',
					'section'     => 'optionsdemo_section',
					'conditions'  => array(
						esc_html__( 'Yes', 'optionsdemo' ),
						esc_html__( 'No', 'optionsdemo' ),
					),
					'option_name' => 'optionsdemo_general'
				),
				
				array(
					'label'       => esc_html__( 'Select', 'optionsdemo' ),
					'id'          => 'optionsdemo_select',
					'type'        => 'select',
					'section'     => 'optionsdemo_section',
					'countries'   => array(
						esc_html__( 'Afghanistan', 'optionsdemo' ),
						esc_html__( 'Bangladesh', 'optionsdemo' ),
						esc_html__( 'Bhutan', 'optionsdemo' ),
						esc_html__( 'India', 'optionsdemo' ),
						esc_html__( 'Maldives', 'optionsdemo' ),
						esc_html__( 'Nepal', 'optionsdemo' ),
						esc_html__( 'Pakistan', 'optionsdemo' ),
						esc_html__( 'Sri Lanka', 'optionsdemo' )
					),
					'option_name' => 'optionsdemo_general'
				),
				
				array(
					'label'       => esc_html__( 'Multiple Select', 'optionsdemo' ),
					'id'          => 'optionsdemo_multi_select',
					'type'        => 'multiple',
					'section'     => 'optionsdemo_section',
					'countries'   => array(
						esc_html__( 'Afghanistan', 'optionsdemo' ),
						esc_html__( 'Bangladesh', 'optionsdemo' ),
						esc_html__( 'Bhutan', 'optionsdemo' ),
						esc_html__( 'India', 'optionsdemo' ),
						esc_html__( 'Maldives', 'optionsdemo' ),
						esc_html__( 'Nepal', 'optionsdemo' ),
						esc_html__( 'Pakistan', 'optionsdemo' ),
						esc_html__( 'Sri Lanka', 'optionsdemo' )
					),
					'option_name' => 'optionsdemo_general'
				),
				
				array(
					'label'       => esc_html__( 'File upload 1', 'optionsdemo' ),
					'id'          => 'optionsdemo_image',
					'type'        => 'file',
					'section'     => 'optionsdemo_section',
					'option_name' => 'optionsdemo_general'
				),
				
				array(
					'label'       => esc_html__( 'File upload 2', 'optionsdemo' ),
					'id'          => 'optionsdemo_image2',
					'type'        => 'file',
					'section'     => 'optionsdemo_section',
					'option_name' => 'optionsdemo_general'
				)
			);
			
			foreach ( $fields as $field ) {
				add_settings_field( $field['id'], $field['label'],
					array( $this, 'optionsdemo_field_callback' ),
					'optionsdemo_general', $field['section'], $field );
			}
			//Setting Register
			register_setting( 'optionsdemo_general', 'optionsdemo_general' );
		}
		//End method optionsdemo_setup_fields
		
		
		/**
		 * Setting field callback function
		 *
		 * @param $field
		 */
		public function optionsdemo_field_callback( $field ) {
			$option_name = $field['option_name'];
			$option      = get_option( $option_name );
			$value       = isset( $option[ $field['id'] ] ) ? $option[ $field['id'] ] : '';
			
			switch ( $field['type'] ) {
				
				case 'file':
					
					echo '<div class="optionsdemo-warp">';
					printf( '<input id="%1$s-%2$s" type="text" class="optionsdemo-input" name="%1$s[%2$s]" value="%3$s"/>',
						$option_name,
						$field['id'],
						$value
					);
					printf( '<input type="button" class="button-primary optionsdemo-btn " value="Insert Image"/>' );
					
					echo '</div>';
					break;
				
				
				// Multiple select render
				case 'multiple':
					
					$countries = $field['countries'];
					
					printf( '<select id="%1$s-%2$s" name="%1$s[%2$s][]" multiple="%3$s">',
						$option_name,
						$field['id'],
						$field['type']
					);
					
					foreach ( $countries as $key => $country ) {
						$selected = '';
						if ( is_array( $value ) && in_array( $key, $value ) ) {
							$selected = 'selected';
						}
						
						printf( '<option value="%1$s" %2$s >%3$s</option>',
							$key,
							$selected,
							$country
						);
					}
					echo "</select>";
					break;
				
				// Select filed render
				case 'select':
					
					$countries = $field['countries'];
					printf( '<select id="%1$s-%2$s" name="%1$s[%2$s]">',
						$option_name,
						$field['id']
					);
					
					foreach ( $countries as $country ) {
						$selected = '';
						if ( $value == $country ) {
							$selected = 'selected';
						}
						
						printf( '<option value="%1$s" %2$s >%3$s</option>',
							$country,
							$selected,
							$country
						);
					}
					break;
				
				// Radio filed render
				case 'radio':
					
					$conditions = $field['conditions'];
					
					foreach ( $conditions as $condition ) {
						$selected = '';
						if ( $value == $condition ) {
							$selected = 'checked';
						}
						
						printf( '<input id="%1$s-%2$s" name="%1$s[%2$s]" type="%3$s" value="%4$s" %5$s />%6$s<br>',
							$option_name,
							$field['id'],
							$field['type'],
							$condition,
							$selected,
							$condition
						);
					}
					break;
				
				
				case 'checkbox':
					
					$countries = $field['countries'];
					
					foreach ( $countries as $key => $country ) {
						$checked = '';
						if ( is_array( $value ) && in_array( $key, $value ) ) {
							$checked = 'checked';
						}
						
						printf( '<input id="%1$s-%2$s" name="%1$s[%2$s][%4$s]" type="%3$s" value="%4$s" %5$s />%6$s<br>',
							$option_name,
							$field['id'],
							$field['type'],
							$key,
							$checked,
							$country,
							$value
						);
					}
					break;
				
				
				case 'textarea':
					
					printf( '<textarea name="%1$s[%2$s]" id="%1$s-%2$s" placeholder="%3$s" rows="5" cols="50">%4$s</textarea>',
						$option_name,
						$field['id'],
						isset( $field['placeholder'] ) ? $field['placeholder'] : '',
						$value
					);
					break;
				
				
				case 'url':
					
					printf( '<input name="%1$s[%2$s]" id="%1$s-%2$s" type="%3$s" placeholder="%4$s" value="%5$s"/>',
						$option_name,
						$field['id'],
						$field['type'],
						isset( $field['placeholder'] ) ? $field['placeholder'] : '',
						$value
					);
					break;
				
				case 'number':
					
					printf( '<input name="%1$s[%2$s]" id="%1$s-%2$s" type="%3$s" placeholder="%4$s" value="%5$s" min="%6$s" max="%7$s"/>',
						$option_name,
						$field['id'],
						$field['type'],
						isset( $field['placeholder'] ) ? $field['placeholder'] : '',
						$value,
						$field['min'],
						$field['max']
					);
					break;
				
				case 'password':
					
					printf( '<input name="%1$s[%2$s]" id="%1$s-%2$s" type="%3$s" placeholder="%4$s" value="%5$s"/>',
						$option_name,
						$field['id'],
						$field['type'],
						isset( $field['placeholder'] ) ? $field['placeholder'] : '',
						$value
					);
					break;
				
				case 'email':
					
					printf( '<input name="%1$s[%2$s]" id="%1$s-%2$s" type="%3$s" placeholder="%4$s" value="%5$s"/>',
						$option_name,
						$field['id'],
						$field['type'],
						isset( $field['placeholder'] ) ? $field['placeholder'] : '',
						$value
					);
					break;
				
				default:
					
					printf( '<input name="%1$s[%2$s]" id="%1$s-%2$s" type="%3$s" placeholder="%4$s" value="%5$s"/>',
						$option_name,
						$field['id'],
						$field['type'],
						isset( $field['placeholder'] ) ? $field['placeholder'] : '',
						$value
					);
			}
			//End Switch case
		}
		// End method optionsdemo_field_callback
		
		
	}
	
	//End Class SettingOptions
	
	new SettingOptions();