<?php 
/**
 * WooCommerce Helpers Functions 
 */

function ccs_woo_add_custom_fields_register_form() {
  ?>
  <p class="form-row form-row-wide">

    <label for="reg_billing_first_name">
      <?php _e('First name', 'woocommerce'); ?><span class="required">*</span>
    </label>
    <input 
      type="text" 
      class="input-text" 
      name="billing_first_name" 
      id="reg_billing_first_name" 
      value="<?php if (! empty( $_POST['billing_first_name'])) esc_attr_e($_POST['billing_first_name']); ?>" />
  </p>

  <p class="form-row form-row-wide">

    <label for="reg_billing_last_name">
      <?php _e('Last name', 'woocommerce'); ?><span class="required">*</span>
    </label>
    <input 
      type="text" 
      class="input-text" 
      name="billing_last_name" 
      id="reg_billing_last_name" 
      value="<?php if ( ! empty( $_POST['billing_last_name'] ) ) esc_attr_e( $_POST['billing_last_name'] ); ?>" />
  </p>
  <?php
}

add_action('woocommerce_register_form_start', 'ccs_woo_add_custom_fields_register_form');

function ccs_validate_extra_register_fields($username, $email, $validation_errors) {
  if (isset($_POST['billing_first_name']) && empty($_POST['billing_first_name']) ) {
    $validation_errors->add('billing_first_name_error', __('First Name is required!', 'woocommerce'));
  }

  if (isset($_POST['billing_last_name']) && empty($_POST['billing_last_name']) ) {
    $validation_errors->add('billing_last_name_error', __('Last Name is required!', 'woocommerce'));
  }
  
  return $validation_errors;
}

add_action('woocommerce_register_post', 'ccs_validate_extra_register_fields', 10, 3);

function ccs_save_extra_register_fields($customer_id) {
  if (isset($_POST['billing_first_name'])) {
    update_user_meta($customer_id, 'billing_first_name', sanitize_text_field($_POST['billing_first_name']));
  }
  
  if (isset($_POST['billing_last_name'])) {
    update_user_meta($customer_id, 'billing_last_name', sanitize_text_field($_POST['billing_last_name']));
  }
}

add_action('woocommerce_created_customer', 'ccs_save_extra_register_fields');