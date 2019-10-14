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
			add_action( 'save_post', array( $this, 'opd_save_img_metabox' ) );
			add_action( 'save_post', array( $this, 'opd_save_gallery_metabox' ) );
			
			add_filter( 'user_contactmethods', array( $this, 'opd_user_contact_methods' ) );
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
			add_meta_box(
				'opd_meta_img_field',
				__( 'Image Field', 'optionsdemo' ),
				array( $this, 'opd_display_meta_img_field_location' ),
				array( 'optiondemo' )
			);
			add_meta_box(
				'opd_gallery_info',
				__( 'Gallery Info', 'optionsdemo' ),
				array( $this, 'opd_gallery_info' ),
				array( 'optiondemo' )
			);
			add_meta_box(
				'repeatable_fields',
				__( 'Repeatable field', 'optiondemo' ),
				array( $this, 'opd_repeatable_meta_fields_display' ),
				array( 'optiondemo' )
			);
		}
		//End method opd_add_metabox
		
		
		/**
		 * Initial Secured method
		 *
		 * @param $nonce_field
		 * @param $action
		 * @param $post_id
		 *
		 * @return bool
		 */
		private function is_secured( $nonce_field, $action, $post_id ) {
			
			$nonce = isset( $_POST[ $nonce_field ] ) ? $_POST[ $nonce_field ] : '';
			
			if ( $nonce == '' ) {
				return false;
			}
			if ( ! wp_verify_nonce( $nonce, $action ) ) {
				return false;
			}
			if ( ! current_user_can( 'edit.php', $post_id ) ) {
				return false;
			}
			if ( wp_is_post_autosave( $post_id ) ) {
				return false;
			}
			if ( wp_is_post_revision( $post_id ) ) {
				return false;
			}
			
		}
		// End private method is_secured
		
		
		/**
		 * Save image meta value
		 *
		 * @param $post_id
		 *
		 * @return mixed
		 */
		public function opd_save_img_metabox( $post_id ) {
			
			/*if ( ! $this->is_secured( 'opd_meta_field', 'meta_field', $post_id ) ) {
				return $post_id;
			}*/
			
			$opdimg      = isset( $_POST['opdimg'] ) ? $_POST['opdimg'] : array();
			$opd_img_id  = isset( $opdimg['opd_image_id'] ) ? $opdimg['opd_image_id'] : '';
			$opd_img_url = isset( $opdimg['opd_image_url'] ) ? $opdimg['opd_image_url'] : '';
			
			$opdimg_id_url                  = array();
			$opdimg_id_url['opd_image_id']  = $opd_img_id;
			$opdimg_id_url['opd_image_url'] = $opd_img_url;
			
			update_post_meta( $post_id, '_opd_img_id_url', $opdimg_id_url );
		}
		
		// End method opd_save_img_metabox
		
		
		/**
		 * @param $post_id
		 */
		public function opd_save_gallery_metabox( $post_id ) {
			$opdimgs      = isset( $_POST['opdimgs'] ) ? $_POST['opdimgs'] : array();
			$opd_imgs_id  = isset( $opdimgs['opd_images_id'] ) ? $opdimgs['opd_images_id'] : '';
			$opd_imgs_url = isset( $opdimgs['opd_images_url'] ) ? $opdimgs['opd_images_url'] : '';
			
			$opdimgs_id_url                   = array();
			$opdimgs_id_url['opd_images_id']  = $opd_imgs_id;
			$opdimgs_id_url['opd_images_url'] = $opd_imgs_url;
			
			update_post_meta( $post_id, '_opd_gallery_id_url', $opdimgs_id_url );
		}
		//End method opd_save_gallery_metabox
		
		/**
		 * Save meta value
		 *
		 * @param $post_id
		 *
		 * @return mixed
		 */
		public function opd_save_metabox( $post_id ) {
			
			/*if ( ! $this->is_secured( 'opd_meta_field', 'meta_field', $post_id ) ) {
				return $post_id;
			}*/
			
			$opdonmeta   = isset( $_POST['opdmeta'] ) ? $_POST['opdmeta'] : array();
			$text_field  = isset( $opdonmeta['opd_text'] ) ? $opdonmeta['opd_text'] : '';
			$email_field = isset( $opdonmeta['opd_email'] ) ? $opdonmeta['opd_email'] : '';
			$date_field  = isset( $opdonmeta['opd_date'] ) ? $opdonmeta['opd_date'] : '';
			$is_favorite = isset( $opdonmeta['opd_is_favorite'] ) ? $opdonmeta['opd_is_favorite'] : 0;
			$colors      = isset( $opdonmeta['opd_color'] ) ? $opdonmeta['opd_color'] : array();
			$color       = isset( $opdonmeta['opd_clr'] ) ? $opdonmeta['opd_clr'] : '';
			$fav_color   = isset( $opdonmeta['opd_fav_color'] ) ? $opdonmeta['opd_fav_color'] : '';
			$multi_color = isset( $opdonmeta['opd_multi_color'] ) ? $opdonmeta['opd_multi_color'] : array();
			
			
			$text_field  = sanitize_text_field( $text_field );
			$email_field = sanitize_text_field( $email_field );
			
			$multi_select_checked                    = array();
			$multi_select_checked['opd_is_favorite'] = $is_favorite;
			$multi_select_checked['opd_color']       = $colors;
			$multi_select_checked['opd_clr']         = $color;
			$multi_select_checked['opd_fav_color']   = $fav_color;
			$multi_select_checked['opd_multi_color'] = $multi_color;
			
			update_post_meta( $post_id, '_opd_text_field', $text_field );
			update_post_meta( $post_id, '_opd_email_field', $email_field );
			update_post_meta( $post_id, '_opd_date_field', $date_field );
			//update_post_meta( $post_id, '_opd_is_favorite', $is_favorite );
			//update_post_meta( $post_id, '_opd_color', $colors );
			//update_post_meta( $post_id, '_opd_clr', $color );
			//update_post_meta( $post_id, '_opd_fav_color', $fav_color );
			//update_post_meta( $post_id, '_opd_multi_color', $multi_color );
			
			update_post_meta( $post_id, '_opd_select_checked', $multi_select_checked );
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
			$date_field  = get_post_meta( $post_id, '_opd_date_field', true );
			$is_favorite = get_post_meta( $post_id, '_opd_select_checked', true );
			$save_colors = get_post_meta( $post_id, '_opd_select_checked', true );
			$save_color  = get_post_meta( $post_id, '_opd_select_checked', true );
			$fav_color   = get_post_meta( $post_id, '_opd_select_checked', true );
			$multi_color = get_post_meta( $post_id, '_opd_select_checked', true );
			
			$text_label     = __( 'Text field', 'optionsdemo' );
			$email_label    = __( 'Email field', 'optionsdemo' );
			$checkbox_label = __( 'Is Favorite', 'optionsdemo' );
			$color_label    = __( 'Colors', 'optionsdemo' );
			$select_color   = __( 'Favorite Color', 'optionsdemo' );
			$select_colors  = __( 'Favorite Colors', 'optionsdemo' );
			$date_label     = __( 'Years', 'optionsdemo' );
			
			$colors = [
				'red',
				'green',
				'blue',
				'yellow',
				'magenta',
				'pink',
				'black'
			];
			
			$checked = ( isset( $is_favorite['opd_is_favorite'] ) && intval( $is_favorite['opd_is_favorite'] ) == 1 ) ? 'checked' : '';
			
			wp_nonce_field( 'meta_field', 'opd_meta_field' );
			
			$metabox_html = <<<EOD
			<!--Text field-->
            <p>
                <label for="opd_text">{$text_label}:</label>
                <input type="text" name="opdmeta[opd_text]" id="opd_text" value="{$text_field}">
            </p>
            <br/>
            <!--email field-->
            <p>
                <label for="opd_email">{$email_label}:</label>
                <input type="email" name="opdmeta[opd_email]" id="opd_email" value="{$email_field}">
            </p>
            <br/>
            <p>
                <label for="opd_date">{$date_label}:</label>
                
                <input type="text" name="opdmeta[opd_date]" id="opd_date" value="{$date_field}" placeholder="mm/dd/yy">
            </p>
            <!--checkbox field-->
            <p>
                <label for="opd_is_favorite">{$checkbox_label}:</label>
                
                <input type="checkbox" name="opdmeta[opd_is_favorite]" id="opd_is_favorite" value="1" {$checked}>
            </p>
<br/>
	<!--Multiple check fields-->
<p>
<label>{$color_label}: </label>
EOD;
			
			/*if ( ! is_array( $save_colors ) ) {
				$save_colors = array();
			}*/
			foreach ( $colors as $key => $color ) {
				$_color       = ucwords( $color );
				$checked      = is_array( $save_colors['opd_color'] ) && in_array( $key,
					$save_colors['opd_color'] ) ? 'checked' : '';
				$metabox_html .= <<<EOD
         
                <input type="checkbox" name="opdmeta[opd_color][]" id="opd_color_{$_color}" value="{$key}" {$checked}>
                <label for="opd_color_{$_color}">{$_color}</label>
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
				$checked      = ( $color == $save_color['opd_clr'] ) ? "checked='checked'" : '';
				$metabox_html .= <<<EOD
         
                
                <input type="radio" name="opdmeta[opd_clr]" id="opd_clr_{$color}" value="{$color}" {$checked}>
                <label for="opd_clr_{$color}">{$color} </label>
EOD;
			}
			$metabox_html .= "</p>";
			
			
			//Select Field
			
			$dropdown_html = '<option value="0">' . __( "Select a color", "optionsdemo" ) . '</option>';
			foreach ( $colors as $color ) {
				$selected = '';
				if ( $color == $fav_color['opd_fav_color'] ) {
					$selected = 'selected';
				}
				$dropdown_html .= sprintf( '<option value="%s" %s>%s</option>', $color, $selected, $color );
			}
			
			$metabox_html .= <<<EOD
			<br/>
			<p>
				<label for="opd_fav_color">{$select_color}</label>
				<select name="opdmeta[opd_fav_color]" id="opd_fav_color">
				{$dropdown_html}
				</select>
			</p>
EOD;
			
			
			//Multiple Select Fields
			
			$dropdown_html = '<option value="0">' . __( "Select a colors", "optionsdemo" ) . '</option>';
			foreach ( $colors as $key => $color ) {
				$selected = '';
				if ( is_array( $multi_color['opd_multi_color'] ) && in_array( $key,
						$multi_color['opd_multi_color'] ) ) {
					$selected = 'selected';
				}
				$dropdown_html .= sprintf( '<option value="%s" %s>%s</option>', $key, $selected, $color );
			}
			
			$metabox_html .= <<<EOD
			<br/>
			<p>
				<label for="opd_multi_color">{$select_colors}</label>
				<select name="opdmeta[opd_multi_color][]" id="opd_multi_color" multiple>
				{$dropdown_html}
				</select>
			</p>
EOD;
			echo $metabox_html;
		}
		//End method opd_display_meta_field_location
		
		
		/**
		 * Meta Box callback function for rendering Image field output
		 *
		 * @param $post
		 */
		public function opd_display_meta_img_field_location( $post ) {
			$post_id      = $post->ID;
			$opd_img      = get_post_meta( $post_id, '_opd_img_id_url', true );
			$metabox_html = <<<EOD
			<div>
				<button class="button" id="upload_image">Upload Image</button>
				<input type="hidden" name="opdimg[opd_image_id]" id="opd_image_id" value="{$opd_img['opd_image_id']}" >
				<input type="hidden" name="opdimg[opd_image_url]" id="opd_image_url" value="{$opd_img['opd_image_url']}" >
				<div class="border" style="width:100%;height:auto;" id="image_container"></div>
			</div>
EOD;
			echo $metabox_html;
		}
		//End method opd_display_meta_img_field_location
		
		
		/**
		 * Meta Box callback function for rendering Image gallery field output
		 *
		 * @param $post
		 */
		public function opd_gallery_info( $post ) {
			$post_id      = $post->ID;
			$opd_imgs     = get_post_meta( $post_id, '_opd_gallery_id_url', true );
			$metabox_html = <<<EOD
			<div>
				<button class="button" id="upload_images">Upload Images</button>
				<input type="hidden" name="opdimgs[opd_images_id]" id="opd_images_id" value="{$opd_imgs['opd_images_id']}" >
				<input type="hidden" name="opdimgs[opd_images_url]" id="opd_images_url" value="{$opd_imgs['opd_images_url']}" >
				<div class="border" style="width:100%;height:auto;" id="images_container"></div>
			</div>
EOD;
			echo $metabox_html;
		}
		//Emd Method opd_gallery_info
		
		
		/**
		 * Add user social contact info
		 *
		 * @param $method
		 *
		 * @return mixed
		 */
		public function opd_user_contact_methods( $method ) {
			$method['facebook'] = __( 'Facebook', 'optionsdemo' );
			$method['twitter']  = __( 'Twitter', 'optionsdemo' );
			$method['linkedin'] = __( 'Linkedin', 'optionsdemo' );
			
			return $method;
		}
		
		//End method opd_user_contact_methods
		
		
		/**
		 * Repeatable field display
		 */
		public function opd_repeatable_meta_fields_display() {
			?>
            <table id="repeatable-fieldset-one" width="100%">
                <thead>
                <tr>
                    <th width="33%">Name</th>
                    <th width="20%">Select</th>
                    <th width="33%">Url</th>
                    <th width="8%"></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td style="padding-right:10px"><input class="form-control form-control-lg" type="text" name="url"
                                                          placeholder="Your Name"></td>
                    <td style="padding-right:10px">
                        <select style="height: calc(1.5em + 1rem + 2px);" class="form-control form-control-lg"
                                name="select">
                            <option value="">Red</option>
                            <option value="">Green</option>
                            <option value="">Blue</option>
                            <option value="">Black</option>
                            <option value="">White</option>
                        </select>
                    </td>
                    <td style="padding-right:10px"><input class="form-control form-control-lg" type="text" name="url"
                                                          placeholder="Website"></td>
                    <td><a class="btn btn-danger remove-row" href="">Remove</a></td>
                </tr>
                <tr class="empty-row screen-reader-text">
                    <td style="padding-right:10px"><input class="form-control form-control-lg" type="text" name="url"
                                                          placeholder="Your Name"></td>
                    <td style="padding-right:10px">
                        <select style="height: calc(1.5em + 1rem + 2px);" class="form-control form-control-lg"
                                name="select">
                            <option value="">Red</option>
                            <option value="">Green</option>
                            <option value="">Blue</option>
                            <option value="">Black</option>
                            <option value="">White</option>
                        </select>
                    </td>
                    <td style="padding-right:10px"><input class="form-control form-control-lg" type="text" name="url"
                                                          placeholder="Website"></td>
                    <td><a class="btn btn-danger remove-row" href="">Remove</a></td>
                </tr>
                </tbody>
            </table>
            <p style="padding-top:10px"><a id="add-row" class="btn btn-success" href="#">Add New</a></p>
			<?php
		}
		//End method opd_repeatable_meta_fields_display
  
  
	}
	
	// End Class MetaBox
	
	new MetaBox();