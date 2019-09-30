<?php
	
	/**
	 * Kick-in Class MetaBox
	 */
	class MetaBox {
		/**
		 * MetaBox constructor.
		 */
		public function __construct() {
			add_action( 'admin_menu', array( $this, 'opd_add_metabox' ) );
			add_action( 'save_post', array( $this, 'opd_save_metabox' ) );
		}
		//End method constructor
		
		/**
		 * Add metabox
		 */
		public function opd_add_metabox() {
			add_meta_box(
				'opd_meta_field',
				__( 'Meta Fields', 'optionsdemo' ),
				array( $this, 'opd_display_meta_field_location' ),
				array( 'optiondemo' )
			);
		}
		//End method opd_add_metabox
		
		/**
		 * Save meta value
		 *
		 * @param $post_id
		 *
		 * @return mixed
		 */
		public function opd_save_metabox( $post_id ) {
			
			
			$text_field  = isset( $_POST['opd_text'] ) ? $_POST['opd_text'] : '';
			$email_field = isset( $_POST['opd_email'] ) ? $_POST['opd_email'] : '';
			$is_favorite = isset( $_POST['opd_is_favorite'] ) ? $_POST['opd_is_favorite'] : 0;
			$colors      = isset( $_POST['opd_color'] ) ? $_POST['opd_color'] : array();
			$color       = isset( $_POST['opd_clr'] ) ? $_POST['opd_clr'] : '';
			$fav_color   = isset( $_POST['opd_fav_color'] ) ? $_POST['opd_fav_color'] : '';
			$multi_color = isset( $_POST['opd_multi_color'] ) ? $_POST['opd_multi_color'] : '';
			
			
			$text_field  = sanitize_text_field( $text_field );
			$email_field = sanitize_text_field( $email_field );
			
			
			update_post_meta( $post_id, '_opd_text_field', $text_field );
			update_post_meta( $post_id, '_opd_email_field', $email_field );
			update_post_meta( $post_id, '_opd_is_favorite', $is_favorite );
			update_post_meta( $post_id, '_opd_color', $colors );
			update_post_meta( $post_id, '_opd_clr', $color );
			update_post_meta( $post_id, '_opd_fav_color', $fav_color );
			update_post_meta( $post_id, '_opd_multi_color', $multi_color );
			
			
		}
		//End method opd_save_metabox
		
		/**
		 * Meta Box callback function for rendering output
		 *
		 * @param $post
		 */
		public function opd_display_meta_field_location( $post ) {
			
			$post_id = $post->ID;
			
			$text_field  = get_post_meta( $post_id, '_opd_text_field', true );
			$email_field = get_post_meta( $post_id, '_opd_email_field', true );
			$is_favorite = get_post_meta( $post_id, '_opd_is_favorite', true );
			$save_colors = get_post_meta( $post_id, '_opd_color', true );
			$save_color  = get_post_meta( $post_id, '_opd_clr', true );
			$fav_color   = get_post_meta( $post_id, '_opd_fav_color', true );
			$multi_color = get_post_meta( $post_id, '_opd_multi_color', true );
			
			$text_label     = __( 'Text field', 'optionsdemo' );
			$email_label    = __( 'Email field', 'optionsdemo' );
			$checkbox_label = __( 'Is Favorite', 'optionsdemo' );
			$color_label    = __( 'Colors', 'optionsdemo' );
			$select_color   = __( 'Favorite Color', 'optionsdemo' );
			$select_colors  = __( 'Favorite Colors', 'optionsdemo' );
			
			$colors  = [
				'red',
				'green',
				'blue',
				'yellow',
				'magenta',
				'pink',
				'black'
			];
			$checked = $is_favorite == 1 ? 'checked' : '';
			
			$metabox_html = <<<EOD
			<!--Text field-->
            <p>
                <label for="opd_text">{$text_label}:</label>
                <input type="text" name="opd_text" id="opd_text" value="{$text_field}">
            </p>
            <br/>
            <!--email field-->
            <p>
                <label for="opd_email">{$email_label}:</label>
                <input type="email" name="opd_email" id="opd_email" value="{$email_field}">
            </p>
            <br/>
            <!--checkbox field-->
            <p>
                <label for="opd_is_favorite">{$checkbox_label}:</label>
                
                <input type="checkbox" name="opd_is_favorite" id="opd_is_favorite" value="1" {$checked}>
            </p>
<br/>



	<!--Multiple check fields-->
<p>
<label>{$color_label}: </label>
EOD;
			
			/*if ( ! is_array( $save_colors ) ) {
				$save_colors = array();
			}*/
			foreach ( $colors as $color ) {
				$color        = ucwords( $color );
				$checked      = is_array( $save_colors ) && in_array( $color, $save_colors ) ? 'checked' : '';
				$metabox_html .= <<<EOD
         
                <input type="checkbox" name="opd_color[]" id="opd_color_{$color}" value="{$color}" {$checked}>
                <label for="opd_color_{$color}">{$color}</label>
EOD;
			}
			
			$metabox_html .= "</p>";
			
			
			//Radio field
			
			$metabox_html .= <<<EOD
			<br/>
<p>
<label>{$color_label}: </label>
EOD;
			
			foreach ( $colors as $color ) {
				$color        = ucwords( $color );
				$checked      = ( $color == $save_color ) ? "checked='checked'" : '';
				$metabox_html .= <<<EOD
         
                
                <input type="radio" name="opd_clr" id="opd_clr_{$color}" value="{$color}" {$checked}>
                <label for="opd_clr_{$color}">{$color} </label>
EOD;
			}
			$metabox_html .= "</p>";
			
			
			//Select Field
			
			$dropdown_html = '<option value="0">' . __( "Select a color", "optionsdemo" ) . '</option>';
			foreach ( $colors as $color ) {
				$selected = '';
				if ( $color == $fav_color ) {
					$selected = 'selected';
				}
				$dropdown_html .= sprintf( '<option value="%s" %s>%s</option>', $color, $selected, $color );
			}
			
			$metabox_html .= <<<EOD
			<br/>
			<p>
				<label for="opd_fav_color">{$select_color}</label>
				<select name="opd_fav_color" id="opd_fav_color">
					{$dropdown_html}
				</select>
			</p>
EOD;
			
			
			//Multiple Select Fields
			
			$dropdown_html = '<option value="0">' . __( "Select a colors", "optionsdemo" ) . '</option>';
			foreach ( $colors as $color ) {
				$selected = '';
				if ( is_array( $multi_color ) && in_array( $color, $multi_color ) ) {
					$selected = 'selected';
				}
				$dropdown_html .= sprintf( '<option value="%s" %s>%s</option>', $color, $selected, $color );
			}
			
			$metabox_html .= <<<EOD
			<br/>
			<p>
				<label for="opd_multi_color">{$select_colors}</label>
				<select name="opd_multi_color[]" id="opd_multi_color" multiple>
					{$dropdown_html}
				</select>
			</p>
EOD;
			echo $metabox_html;
		}
		//End method opd_display_meta_field_location
	}
	
	// End Class MetaBox
	
	new MetaBox();