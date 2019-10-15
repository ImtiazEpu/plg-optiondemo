<?php
	/**
	 * The field on the editing screens.
	 *
	 * @param $user WP_User user object
	 */
	
	Class UsersProfile {
		
		public function __construct() {
			
			//add_action( 'init', array( $this, 'add_new_role_cap' ) );
			// add the field to user's own profile editing screen
			add_action( 'edit_user_profile', array( $this, 'opd_usermeta_form_field_birthday' ) );
			
			// add the field to user profile editing screen
			add_action( 'show_user_profile', array( $this, 'opd_usermeta_form_field_birthday' ) );
			
			// add the save action to user's own profile editing screen update
			add_action( 'personal_options_update', array( $this, 'opd_usermeta_form_field_birthday_update' ) );
			
			// add the save action to user profile editing screen update
			add_action( 'edit_user_profile_update', array( $this, 'opd_usermeta_form_field_birthday_update' ) );
		}
		
		
		/*public function add_new_role_cap() {
			add_role( 'plugin_managers', __( 'Plugin manager' ), array(
			
			) );
		}*/
		
		public function opd_usermeta_form_field_birthday( $user ) {
			?>
            <h3>It's Your Birthday</h3>
            <table class="form-table">
                <tr>
                    <th>
                        <label for="birthday">Birthday</label>
                    </th>
                    <td>
                        <input type="date"
                               class="regular-text ltr"
                               id="birthday"
                               name="birthday"
                               value="<?= esc_attr( get_user_meta( $user->ID, 'birthday', true ) ); ?>"
                               title="Please use YYYY-MM-DD as the date format."
                               pattern="(19[0-9][0-9]|20[0-9][0-9])-(1[0-2]|0[1-9])-(3[01]|[21][0-9]|0[1-9])"
                               required>
                        <p class="description">
                            Please enter your birthday date.
                        </p>
                    </td>
                </tr>
            </table>
			<?php
		}
		
		
		/**
		 * The save action.
		 *
		 * @param $user_id int the ID of the current user.
		 *
		 * @return bool Meta ID if the key didn't exist, true on successful update, false on failure.
		 */
		public function opd_usermeta_form_field_birthday_update( $user_id ) {
			// check that the current user have the capability to edit the $user_id
			if ( ! current_user_can( 'edit_user', $user_id ) ) {
				return false;
			}
			
			// create/update user meta for the $user_id
			return update_user_meta(
				$user_id,
				'birthday',
				$_POST['birthday']
			);
		}
		
	}
	
	new UsersProfile();
	