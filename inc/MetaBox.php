<?php
	
	
	class MetaBox {
		public function __construct() {
			add_action( 'plugins_loaded', array( $this, 'optionsdemo_load_textdomain' ) );
			
			add_action( 'admin_menu', array( $this, 'cbx_add_metabox' ) );
			add_action( 'save_post', array( $this, 'cbx_save_metabox' ) );
		}
		
		/**
		 * Load Text Domain
		 */
		public function optionsdemo_load_textdomain() {
			load_plugin_textdomain( 'optionsdemo', false, dirname( __FILE__ ) . "/languages" );
		}
		//end method optionsdemo_load_textdomain
		
		/**
		 * Add metabox
		 */
		public function cbx_add_metabox() {
			add_meta_box(
				'cbx_meta_field',
				__( 'Meta Fields', 'optionsdemo' ),
				array( $this, 'cbx_display_meta_field_location' ),
				array( 'optiondemo' )
			);
		}
		//End method cbx_add_metabox
		
		/**
		 * Save meta value
		 *
		 * @param $post_id
		 *
		 * @return mixed
		 */
		public function cbx_save_metabox( $post_id ) {
			
			
			$text_field  = isset( $_POST['cbx_text'] ) ? $_POST['cbx_text'] : '';
			$email_field = isset( $_POST['cbx_email'] ) ? $_POST['cbx_email'] : '';
			$is_favorite = isset( $_POST['cbx_is_favorite'] ) ? $_POST['cbx_is_favorite'] : 0;
			$colors      = isset( $_POST['cbx_color'] ) ? $_POST['cbx_color'] : array();
			$color       = isset( $_POST['cbx_clr'] ) ? $_POST['cbx_clr'] : '';
			$fav_color   = isset( $_POST['cbx_fav_color'] ) ? $_POST['cbx_fav_color'] : '';
			
			
			$text_field  = sanitize_text_field( $text_field );
			$email_field = sanitize_text_field( $email_field );
			
			
			update_post_meta( $post_id, '_cbx_text_field', $text_field );
			update_post_meta( $post_id, '_cbx_email_field', $email_field );
			update_post_meta( $post_id, '_cbx_is_favorite', $is_favorite );
			update_post_meta( $post_id, '_cbx_color', $colors );
			update_post_meta( $post_id, '_cbx_clr', $color );
			update_post_meta( $post_id, '_cbx_fav_color', $fav_color );
			
			
		}
		//End method cbx_save_metabox
		
		/**
		 * Meta Box callback function for rendering output
		 *
		 * @param $post
		 */
		public function cbx_display_meta_field_location( $post ) {
			
			$post_id = $post->ID;
			
			$text_field  = get_post_meta( $post_id, '_cbx_text_field', true );
			$email_field = get_post_meta( $post_id, '_cbx_email_field', true );
			$is_favorite = get_post_meta( $post_id, '_cbx_is_favorite', true );
			$checked     = $is_favorite == 1 ? 'checked' : '';
			$save_colors = get_post_meta( $post_id, '_cbx_color', true );
			$save_color  = get_post_meta( $post_id, '_cbx_clr', true );
			$fav_color  = get_post_meta( $post_id, '_cbx_fav_color', true );
			
			$text_label     = __( 'Text field', 'optionsdemo' );
			$email_label    = __( 'Email field', 'optionsdemo' );
			$checkbox_label = __( 'Is Favorite', 'optionsdemo' );
			$color_label    = __( 'Colors', 'optionsdemo' );
			$select_color   = __( 'Favorite Color', 'optionsdemo' );
			
			$colors = [
				'red',
				'green',
				'blue',
				'yellow',
				'magenta',
				'pink',
				'black'
			];
			
			$metabox_html = <<<EOD
            <p>
                <label for="cbx_text">{$text_label}:</label>
                <input type="text" name="cbx_text" id="cbx_text" value="{$text_field}">
            </p>
            <br/>
            <p>
                <label for="cbx_email">{$email_label}:</label>
                <input type="email" name="cbx_email" id="cbx_email" value="{$email_field}">
            </p>
            <br/>
            <p>
                <label for="cbx_is_favorite">{$checkbox_label}:</label>
                <input type="checkbox" name="cbx_is_favorite" id="cbx_is_favorite" value="1" {$checked}>
            </p>
<br/>
<p>
<label>{$color_label}: </label>
EOD;
			
			if ( ! is_array( $save_colors ) ) {
				$save_colors = array();
			}
			foreach ( $colors as $color ) {
				$color        = ucwords( $color );
				$checked      = in_array( $color, $save_colors ) ? 'checked' : '';
				$metabox_html .= <<<EOD
         
                <input type="checkbox" name="cbx_color[]" id="cbx_color_{$color}" value="{$color}" {$checked}>
                <label for="cbx_color_{$color}">{$color}</label>
EOD;
			}
			
			$metabox_html .= "</p>";
			$metabox_html .= <<<EOD
			
			<br/>
<p>
<label>{$color_label}: </label>
EOD;
			
			foreach ( $colors as $color ) {
				$color        = ucwords( $color );
				$checked      = ( $color == $save_color ) ? "checked='checked'" : '';
				$metabox_html .= <<<EOD
         
                
                <input type="radio" name="cbx_clr" id="cbx_clr_{$color}" value="{$color}" {$checked}>
                <label for="cbx_clr_{$color}">{$color} </label>
EOD;
			}
			
			$metabox_html .= "</p>";
			
			$dropdown_html = '<option value="0">' . __( "Select a color", "optionsdemo" ) . '</option>';
			foreach ( $colors as $color ) {
				$selected      = '';
				if ($color == $fav_color){
					$selected ='selected';
				}
				$dropdown_html .= sprintf( '<option value="%s" %s>%s</option>', $color, $selected, $color );
			}
			
			$metabox_html .= <<<EOD
			<br/>
			<p>
				<label for="cbx_fav_color">{$select_color}</label>
				<select name="cbx_fav_color" id="cbx_fav_color">
					{$dropdown_html}
				</select>
			</p>
EOD;
			
			
			echo $metabox_html;
			
			
		}
		//End method cbx_display_meta_field_location
	}
	
	new MetaBox();