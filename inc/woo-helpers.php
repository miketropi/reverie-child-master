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
      value="<?php if (! empty( $_POST['billing_first_name'])) esc_attr_e($_POST['billing_first_name']); ?>" required/>
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
      value="<?php if ( ! empty( $_POST['billing_last_name'] ) ) esc_attr_e( $_POST['billing_last_name'] ); ?>" required/>
  </p>

  <p class="form-row form-row-wide">

    <label for="reg_billing_abn">
      <?php _e('ABN', 'woocommerce'); ?><span class="required">*</span>
    </label>
    <input
      type="number"
      class="input-text"
      name="billing_abn"
      min="0"
      max="99999999999"
      maxlength="11"
      oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
      id="reg_billing_abn"
      value="<?php if ( ! empty( $_POST['billing_abn'] ) ) esc_attr_e( $_POST['billing_abn'] ); ?>" required/>
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

  if (isset($_POST['billing_abn']) && empty($_POST['billing_abn']) ) {
    $validation_errors->add('billing_last_name_error', __('ABN is required!', 'woocommerce'));
  }

  return $validation_errors;
}

add_action('woocommerce_register_post', 'ccs_validate_extra_register_fields', 10, 3);

function ccs_save_extra_register_fields($customer_id) {

  if (isset($_POST['billing_first_name'])) {
    update_user_meta($customer_id, 'billing_first_name', wc_clean($_POST['billing_first_name']));
  }

  if (isset($_POST['billing_last_name'])) {
    update_user_meta($customer_id, 'billing_last_name', wc_clean($_POST['billing_last_name']));
  }

  if (isset($_POST['billing_abn'])) {
    update_user_meta($customer_id, 'billing_abn', wc_clean($_POST['billing_abn']));
  }

}

add_action('wwp_wholesale_new_request_submitted', 'ccs_save_extra_register_fields');


add_action( 'show_user_profile', 'extra_user_profile_fields' );
add_action( 'edit_user_profile', 'extra_user_profile_fields' );
function extra_user_profile_fields( $user ) {

  ?>
    <table class="form-table">
      <tr>
          <th><label for="billing_abn"><?php _e("ABN (Australian Business Number)"); ?></label></th>
          <td>
              <input type="text" name="billing_abn" id="billing_abn" value="<?php echo esc_attr( get_the_author_meta( 'billing_abn', $user->ID ) ); ?>" class="regular-text" />
          </td>
      </tr>
    </table>
  <?php

}

add_action( 'personal_options_update', 'save_extra_user_profile_fields' );
add_action( 'edit_user_profile_update', 'save_extra_user_profile_fields' );
function save_extra_user_profile_fields( $user_id ) {
    if ( !current_user_can( 'edit_user', $user_id ) ) {
        return false;
    }
    update_user_meta( $user_id, 'billing_abn', $_POST['billing_abn'] );
}
