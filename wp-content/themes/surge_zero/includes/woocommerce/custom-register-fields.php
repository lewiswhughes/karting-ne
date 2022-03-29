<?php

function custom_register_fields() {
?>
  <label for="reg_password_confirm">Confirm Password</label>
  <input type="password" name="reg_password_confirm" id="reg_password_confirm" required />

  <label for="reg_billing_first_name">First Name</label>
  <input type="text" name="billing_first_name" id="reg_billing_first_name" value="<?php esc_attr_e( $_POST['reg_billing_first_name'] ); ?>" required />

  <label for="reg_billing_last_name">Last Name</label>
  <input type="text" name="billing_last_name" id="reg_billing_last_name" value="<?php esc_attr_e( $_POST['reg_billing_last_name'] ); ?>" required />

  <input type="checkbox" name="reg_consent" id="reg_consent" required />
  <label for="reg_consent"><p>I have read and agree with the KNE <a href="/privacy-policy">privacy policy</a>.</p></label>

<?php
}

add_action( 'woocommerce_register_form', 'custom_register_fields', 10 );

//VALIDATION
function registration_errors_validation($reg_errors, $sanitized_user_login, $user_email) {
	global $woocommerce;
	extract( $_POST );
  $password = ( isset($_POST['password']) ) ? $_POST['password'] : false ;
  $password_confirm = ( isset($_POST['reg_password_confirm']) ) ? $_POST['reg_password_confirm'] : false ;
  if( $password && $password_confirm ){
  	if ( strcmp( $password, $password_confirm ) !== 0 ) {
  		return new WP_Error( 'registration-error', __( 'Passwords do not match.', 'woocommerce' ) );
  	}
  } else {
    return new WP_Error( 'registration-error', __( 'Please complete both password fields.', 'woocommerce' ) );
  }
	return $reg_errors;
}
add_filter('woocommerce_registration_errors', 'registration_errors_validation', 10,3);

//SAVE
function save_custom_register_fields( $customer_id ) {
  if ( isset( $_POST['billing_first_name'] ) ) {
    //First name field which is by default
    update_user_meta( $customer_id, 'first_name', sanitize_text_field( $_POST['billing_first_name'] ) );
    // First name field which is used in WooCommerce
    update_user_meta( $customer_id, 'billing_first_name', sanitize_text_field( $_POST['billing_first_name'] ) );
  }
  if ( isset( $_POST['billing_last_name'] ) ) {
    // Last name field which is by default
    update_user_meta( $customer_id, 'last_name', sanitize_text_field( $_POST['billing_last_name'] ) );
    // Last name field which is used in WooCommerce
    update_user_meta( $customer_id, 'billing_last_name', sanitize_text_field( $_POST['billing_last_name'] ) );
  }
}
add_action( 'woocommerce_created_customer', 'save_custom_register_fields' );

?>
