<?php
/**
 * Functions
 */

{
    /**
     * Define
     */
    define('CCS_THEME_VER', '1.0.0');
    define('CCS_THEME_URI', get_stylesheet_directory_uri());
    define('CCS_THEME_DIR', get_stylesheet_directory());
}

{
    /**
     * Inc
     */
    require(CCS_THEME_DIR . '/inc/static.php');
    require(CCS_THEME_DIR . '/inc/helpers.php');
    require(CCS_THEME_DIR . '/inc/ajax.php');
    require(CCS_THEME_DIR . '/inc/hooks.php');
    require(CCS_THEME_DIR . '/inc/options.php');
    require(CCS_THEME_DIR . '/inc/acf-options.php');

    if(class_exists('WooCommerce')) {
        require(CCS_THEME_DIR . '/inc/woo-helpers.php');
    }
}

function ccs_boot() {
    $defaults = array(
        'height'               => 100,
        'width'                => 400,
        'flex-height'          => true,
        'flex-width'           => true,
        'header-text'          => ['Right Choice Coatings & Sealers', '...'],
        'unlink-homepage-logo' => true,
    );

    add_theme_support( 'custom-logo', $defaults );
}

add_action('after_setup_theme', 'ccs_boot');

function my_deregister_scripts() {
    wp_dequeue_script('wp-embed');
}

add_action('wp_footer', 'my_deregister_scripts');

function mytheme_add_woocommerce_support() {
    add_theme_support('woocommerce');
}

add_action('after_setup_theme', 'mytheme_add_woocommerce_support');

/* * Enqueue * */

function cook_scripts() {
    wp_register_script('scripts', get_stylesheet_directory_uri() . '/js/scripts.js', array('jquery'), '1.1', false);
    wp_enqueue_script('scripts');
}

add_action('wp_enqueue_scripts', 'cook_scripts');

##########################################################################
/* Search Results Grouped by type */
add_filter('posts_orderby', 'group_by_post_type', 10, 2);

function group_by_post_type($orderby, $query) {
    global $wpdb;
    if ($query->is_search) {
        return $wpdb->posts . '.post_type DESC';
    }
    return $orderby;
}

function search_excerpt_highlight() {
    $excerpt = get_the_excerpt();
    $keys = implode('|', explode(' ', get_search_query()));
    $excerpt = preg_replace('/(' . $keys . ')/iu', '<strong class="search-highlight">\0</strong>', $excerpt);
    echo '<p>' . $excerpt . '</p>';
}

function search_title_highlight() {
    $title = get_the_title();
    $keys = implode('|', explode(' ', get_search_query()));
    $title = preg_replace('/(' . $keys . ')/iu', '<strong class="search-highlight">\0</strong>', $title);
    echo $title;
}

/* * Responsible to modify the fonts list in the font control * */

function modify_controls($controls_registry) {
    $fonts = $controls_registry->get_control('font')->get_settings('options');
    $new_fonts = array_merge(['Gotham Book' => 'system', 'Gotham Medium' => 'system', 'Gotham Bold' => 'system', 'Gotham Black' => 'system'], $fonts);
    $controls_registry->get_control('font')->set_settings('options', $new_fonts);
}

add_action('elementor/controls/controls_registered', 'modify_controls', 10, 1);

function do_page_title_shortcode() {
    if (is_product_category()) {
        $current_category = single_cat_title("", false);
    } else if (is_front_page()) {
        $current_category = "Make the Right Choice, The First Time";
    } else {
        $current_category = "Make the Right Choice, The First Time";
    }
    return '<h1>' . $current_category . '</h1>';
}

add_shortcode('do_page_title', 'do_page_title_shortcode');

function copyright_shortcode() {
    return '<p>&copy; Right Choice ' . date('Y') . ' All Rights Reserved. <br>Website by <a href="https://www.juicemarketing.com.au/" target="_blank">Juice Marketing</a>';
}

add_shortcode('copyright', 'copyright_shortcode');

function woo_breads_shortcode() {
    ob_start();
    woocommerce_breadcrumb();
    $output_string = ob_get_contents();
    ob_end_clean();
    return $output_string;
}

add_shortcode('woo_breads', 'woo_breads_shortcode');

add_filter('woocommerce_show_variation_price', '__return_true');

/* * Show cart contents / total Ajax * */
add_filter('woocommerce_add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment');

function woocommerce_header_add_to_cart_fragment($fragments) {
    global $woocommerce;
    ob_start();
    ?>
    <a class="cart-customlocation" href="<?php echo esc_url(wc_get_cart_url()); ?>" title="<?php _e('View your shopping cart', 'woothemes'); ?>"><?php echo sprintf(_n('%d item', '%d items', $woocommerce->cart->cart_contents_count, 'woothemes'), $woocommerce->cart->cart_contents_count); ?> - <?php echo $woocommerce->cart->get_cart_total(); ?></a>
    <?php
    $fragments['a.cart-customlocation'] = ob_get_clean();
    return $fragments;
}

/* * Woo Stuff & Things * */
add_filter('woocommerce_show_page_title', 'woo_hide_page_title');

function woo_hide_page_title() {
    return false;
}

remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30); //Remove "Default Sorting" Dropdown @ WooCommerce Shop & Archive Pages
remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10); // remove sidebar
remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0); // remove breadcrumbs
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40); // Remove meta from single product page



/* Bulk Discount Price */
/*
  add_action( 'woocommerce_single_product_summary', 'discount_message', 11 );
  function discount_message() {
  global $product;
  echo '<div class="bulk-message"><p><a href="#bulk-table">See our Bulk Pricing for '.$product->get_name().'</a></p></div>';
  }
 */

function do_shipping_calculator() {
    return '<form action="#">
	<div id="result"></div>
	<input type="text" id="suburb" name="suburb" value="" placeholder="Enter Your Suburb">
	<input type="text" id="postcode" name="postcode" value="" placeholder="Enter Your Postcode">
	<input type="text" id="weight" name="weight" value="" placeholder="Enter the litres you want to ship">
	<a class="button shipping_calc" href="#" id="calc">Calculate</a>
	</form> ';
}

add_shortcode('shipping_calculator', 'do_shipping_calculator');

add_filter('gform_validation_7', 'gf_fail_for_total_zero');

function gf_fail_for_total_zero($validation_result) {
    $form = $validation_result['form'];

    if (get_post_type(rgpost('input_6')) == "shop_order") {
        // do nothing
    } else {
        $validation_result['is_valid'] = false;
        // Find Total field, set failed validation and message.
        foreach ($form['fields'] as &$field) {
            if ($field->type == 'text') {
                $field->failed_validation = true;
                $field->validation_message = 'You must enter a valid order number';
                break;
            }
        }
    }

    // Assign modified $form object back to the validation result.
    $validation_result['form'] = $form;
    return $validation_result;
}

add_filter('woocommerce_before_add_to_cart_quantity', 'woocommerce_product_TEMP', 0);

function woocommerce_product_TEMP() {
    echo do_shortcode('[adp_product_bulk_rules_table]');
}

// Start of product calculator
add_action('wp_enqueue_scripts', 'themeEnqueueHook');

function themeEnqueueHook() {
    wp_enqueue_script('jquery-function', get_stylesheet_directory_uri() . '/js/function.js');
}

add_filter('woocommerce_after_add_to_cart_form', 'woocommerce_product_quote', 0);

function woocommerce_product_quote() {
    global $product;
    $post_id = $product->get_id();

    $area_cover = get_post_meta($post_id, '_area_cover', TRUE);
    $area_cover_coat = get_post_meta($post_id, '_area_cover_coat', TRUE);

    if ($area_cover == "" && $area_cover_coat == "") {

    } else {
        ?>
        <div class="quote-btn">
            <div class="btn">
                <a href="#coverage-rates" id="to-estimator" class="single_add_to_cart_button button">How Much Do I Need?</a>
            </div>
        </div>
        <?php
    }
}

/**
 * wc_direct_link_to_product_tabs
 *
 * Allows you to create custom URLs to activate product tabs by default, directly from the URL
 * ex: http://mysite.com/my-product-name#reviews
 */
function wc_direct_link_to_product_tabs() {
    if (is_product()) {
        ?>
        <script type="text/javascript">
            jQuery(document).ready(function ($) {
                $('#to-estimator').click(function (e) {
                    e.preventDefault();

                    $('html, body').animate({
                        scrollTop: $('#reviews').offset().top - 400
                    }, 2000);

                    $('.wc-tabs li').each(function () {
                        if ($(this).hasClass('active')) {
                            $(this).removeClass('active');
                        }
                    });

                    $('.wc-tabs li#tab-title-coverage-rates').addClass('active');
                    $('#tab-coverage-rates').addClass('active');
                    $('.woocommerce-Tabs-panel').css('display', 'none');
                    $('#tab-coverage-rates').css('display', 'block');
                });

                $('.woocommerce-Tabs-panel--product-description a,.woocommerce-Tabs-panel--information-guide a').on('click',function(event){
                    event.preventDefault();
                    var href = $(this).attr('href');
                    var target = $(this).attr('target');
                    if(target == '_blank'){
                      window.open(href);
                    }else{
                      window.location.href = href;
                    }
                    return false;
                });

            });
        </script>
        <?php
    }
}

add_action('wp_footer', 'wc_direct_link_to_product_tabs', 30);

/* add_filter('woocommerce_product_tabs', 'woocommerce_product_quote_caculator_tab');

  function woocommerce_product_quote_caculator_tab($tabs) {
  global $product;
  $post_id = $product->get_id();

  $area_cover = get_post_meta($post_id, '_area_cover', TRUE);
  $area_cover_coat = get_post_meta($post_id, '_area_cover_coat', TRUE);

  if ($area_cover == "" && $area_cover_coat == "") {

  } else {
  // Adds the Attribute Description tab
  $tabs['attrib_desc_tab'] = array(
  'title' => __('Calculate quantity', 'woocommerce'),
  'priority' => 0,
  'callback' => 'woocommerce_product_quote_caculator_content'
  );
  }

  return $tabs;
  } */

//add_filter('woocommerce_product_after_tabs', 'woocommerce_product_quote_caculator_content', 0);
add_filter('woocommerce_product_after_coveragerates', 'woocommerce_product_quote_caculator_content', 0);

function woocommerce_product_quote_caculator_content() {
    global $product;
    $post_id = $product->get_id();

    $area_cover = get_post_meta($post_id, '_area_cover', TRUE);
    $area_cover_coat = get_post_meta($post_id, '_area_cover_coat', TRUE);
    if ($area_cover == "" && $area_cover_coat == "") {

    } else {
        ?>
        <div id="tab-attrib_desc_tab" style="padding-top: 24px !important;">
            <h1 class="yikes-custom-woo-tab-title yikes-custom-woo-tab-title-calculate-quantity">Quantity Estimator</h1>
            <p>Enter the dimensions of your surface area to estimate how many tins of product you may need:</p>

            <form class="variations_form cart" action="" method="post">
                <div class="control-group input-width">
                    <label class="title">Width of Substrate (meters)</label>
                    <input type="number" name="calculate_width" id="calculate_width" value="" class="input-text qty text" onkeyup="setProductCalulator();"/>
                </div>
                <div class="control-group input-length">
                    <label class="title">Length of Substrate (meters)</label>
                    <input type="number" name="calculate_length" id="calculate_length" value="" class="input-text qty text" onkeyup="setProductCalulator();"/>
                </div>
                <div class="control-group input-cost">
                    <?php
                    if ($area_cover_coat != "") {
                        ?>
                        <label class="title">2nd Coat Required?</label>
                        <div>
                            <input type="radio" name="calculate_cost" id="calculate_cost" value="yes" class="input-text qty text" onchange="setProductCalulator();"/>
                            <label>Yes</label>
                        </div>
                        <div>
                            <input type="radio" name="calculate_cost" id="calculate_cost" value="no" class="input-text qty text" onchange="setProductCalulator();" checked/>
                            <label>No</label>
                        </div>
                        <?php
                    } else {
                        ?>
                        <input type="hidden" name="calculate_cost" id="calculate_cost" value="yes"/>
                        <?php
                    }
                    ?>
                </div>
                <div class="control-box-section">
                    <input type="hidden" name="calculate_area_cover" id="calculate_area_cover" value="<?php echo $area_cover; ?>"/>
                    <input type="hidden" name="calculate_area_cover_coat" id="calculate_area_cover_coat" value="<?php echo $area_cover_coat; ?>"/>
                    <div class="detail">Summary Estimation</div>
                    <div class="total" id="calculate-total"><span id="calculate-value">0</span> tins</div>
                </div>
                <div class="calculator-disclaimer">
                    * The estimated number of tins is based on the average coverage per square metre and is to be used as a guide only, as there are many variables when estimating (ie, porosity). Please ensure you check your calculations as Right Choice Coatings cannot be held responsible if the incorrect quantity.</div>
            </form>
        </div>
        <?php
    }
}

// End of calculator

add_action('woocommerce_product_options_sku', 'add_area_cover_custom_field');

function add_area_cover_custom_field() {
    woocommerce_wp_text_input(array(
        'id' => '_area_cover',
        //'type' => 'number',
        'label' => __('Area cover (m2) in 1 ltr.', 'woocommerce'),
        'placeholder' => '',
        'desc_tip' => 'true',
        'description' => __('', 'woocommerce')
    ));
}

add_action('woocommerce_process_product_meta', 'save_area_cover_custom_field', 10, 1);

function save_area_cover_custom_field($post_id) {
    if (isset($_POST['_area_cover']))
        update_post_meta($post_id, '_area_cover', esc_attr($_POST['_area_cover']));
}

add_action('woocommerce_product_options_sku', 'add_area_cover_coat_custom_field');

function add_area_cover_coat_custom_field() {
    woocommerce_wp_text_input(array(
        'id' => '_area_cover_coat',
        //'type' => 'number',
        'label' => __('Area cover for Coat (m2) in 1 ltr.', 'woocommerce'),
        'placeholder' => '',
        'desc_tip' => 'true',
        'description' => __('', 'woocommerce')
    ));
}

add_action('woocommerce_process_product_meta', 'save_area_cover_coat_custom_field', 10, 1);

function save_area_cover_coat_custom_field($post_id) {
    if (isset($_POST['_area_cover_coat']))
        update_post_meta($post_id, '_area_cover_coat', esc_attr($_POST['_area_cover_coat']));
}

remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
add_filter('woocommerce_after_add_to_cart_form', 'woocommerce_product_icons', 51);  // 2.1 +

function woocommerce_product_icons() {
    global $product;
    if (have_rows('icons')):
        echo '<ul class="icons">';
        while (have_rows('icons')) : the_row();
            echo '<li>';
            echo '<img src="' . get_sub_field('icon') . '" />';
            echo '<h4>' . get_sub_field('heading') . '</h4>';
            echo '<p>' . get_sub_field('text') . '</p>';
            echo '</li>';
        endwhile;
        echo '</ul>';
    else :
    // no rows found
    endif;
}

add_filter('woocommerce_after_add_to_cart_form', 'woocommerce_content', 51);

function woocommerce_content() {
    $content = apply_filters('the_content', get_the_content());
    echo '<div class="woocommerce-product-details__long-description tpx">' . $content;

    $data_sheet_link = get_field("download_data_sheet");

    if ($data_sheet_link) {
        echo '<div style= "float:left;" class="download-data-sheet">
		<a href="' . $data_sheet_link . '">Download Data Sheet Here</a></div>';
    } else {
        //do nothing
    }
    echo '</div>';
}

add_filter('wc_add_to_cart_message_html', 'custom_add_to_cart_message_html', 10, 2);

function custom_add_to_cart_message_html($message, $products) {
    $count = 0;
    foreach ($products as $product_id => $qty) {
        $count += $qty;
    }
    // The custom message is just below
    $added_text = sprintf(_n("%s item has %s", "%s items have %s", $count, "woocommerce"),
            $count, __("been added to your basket.", "woocommerce"));

    // Output success messages
    if ('yes' === get_option('woocommerce_cart_redirect_after_add')) {
        $return_to = apply_filters('woocommerce_continue_shopping_redirect', wc_get_raw_referer() ? wp_validate_redirect(wc_get_raw_referer(), false) : wc_get_page_permalink('shop'));
        $message = sprintf('<a href="%s" class="button wc-forward">%s</a> %s', esc_url($return_to), esc_html__('Continue shopping', 'woocommerce'), esc_html($added_text));
    } else {
        $message = sprintf('<a href="%s" class="button wc-forward">%s</a> %s', esc_url(wc_get_page_permalink('cart')), esc_html__('View cart', 'woocommerce'), esc_html($added_text));
    }
    return $message;
}

function woocommerce_after_shop_loop_item_title_short_description() {
    global $product;
    //echo do_shortcode('[adp_product_bulk_rules_table]');
    if (!$product->get_short_description())
        return;
    ?>
    <div itemprop="description" class="product-description">
        <?php echo apply_filters('woocommerce_short_description', $product->get_short_description()) ?>
    </div>
    <?php
    /* $cat = get_the_terms( $product->get_id(), 'product_cat' );
      if ($cat) {
      echo '<ul class="cats">';
      foreach ($cat as $categoria) {
      if($categoria->parent == 0){
      echo '<li class="'.$categoria->slug.'">'.$categoria->name.'</li>';
      }
      }
      echo '</ul>';
      } */
}

add_action('woocommerce_after_shop_loop_item_title', 'woocommerce_after_shop_loop_item_title_short_description', 5);

/* Disable Variable Product Price Range */
add_filter('woocommerce_variable_price_html', 'bbloomer_variation_price_format', 10, 3);

function bbloomer_variation_price_format($price, $product) {
    $min_var_reg_price = $product->get_variation_regular_price('min', true);
    $min_var_sale_price = $product->get_variation_sale_price('min', true);
    $max_var_reg_price = $product->get_variation_regular_price('max', true);
    $max_var_sale_price = $product->get_variation_sale_price('max', true);

    if (!( $min_var_reg_price == $max_var_reg_price && $min_var_sale_price == $max_var_sale_price )) {
        if ($min_var_sale_price < $min_var_reg_price) {
            $price = sprintf(__('<del>%1$s</del><ins>%2$s</ins>', 'woocommerce'), wc_price($min_var_reg_price), wc_price($min_var_sale_price));
            //echo 'test1';
        } else {
            $price = sprintf(__('%1$s', 'woocommerce'), wc_price($min_var_reg_price));
            //echo 'test2';
        }
    }
    return $price;
}

add_filter('woocommerce_product_description_heading', '__return_null'); // Remove Product Description heading


add_filter('woocommerce_product_tabs', 'bbloomer_remove_product_tabs', 98);

function bbloomer_remove_product_tabs($tabs) {
    //print_r($tabs);
    unset($tabs['description']);
    unset($tabs['additional_information']);
    return $tabs;
}

remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20); // Remove related products
// First, remove Add to Cart Button
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);

// Second, add View Product Button
add_action('woocommerce_after_shop_loop_item', 'bbloomer_view_product_button', 10);

function bbloomer_view_product_button() {
    global $product;
    $link = $product->get_permalink();
    echo '<a href="' . $link . '" class="button addtocartbutton">View Product</a>';
}

/*
  add_action('woocommerce_cart_totals_after_shipping', 'wc_shipping_insurance_note_after_cart');
  function wc_shipping_insurance_note_after_cart() {

  global $woocommerce;
  $product_id = 1790;
  foreach ( $woocommerce->cart->get_cart() as $cart_item_key => $values ) {
  $_product = $values['data'];
  if ( $_product->id == $product_id ) {
  $found = true;
  }
  }

  $product = wc_get_product( $product_id );
  $price = $product->get_price();
  // if product not found, add it
  if ( ! $found ): ?>
  <tr class="shipping">
  <th><?php _e( 'Shipping Insurance', 'woocommerce' ); ?></th>
  <td><a href="<?php echo do_shortcode('[add_to_cart_url id="1790"]'); ?>"><?php _e( 'Add shipping insurance (+$'.$price.')' ); ?> </a></td>
  </tr>
  <?php else: ?>
  <tr class="shipping">
  <th><?php _e( 'Shipping Insurance', 'woocommerce' ); ?></th>
  <td>$<?php echo $price; ?></td>
  </tr>
  <?php endif;
  }
 */




// Display Radio Buttons
add_action('woocommerce_review_order_before_payment', 'bbloomer_checkout_radio_choice');

function bbloomer_checkout_radio_choice() {

    global $woocommerce;
    $product_id = 1790;
    $product = wc_get_product($product_id);
    $price = $product->get_price();

    $chosen = WC()->session->get('radio_chosen');
    $chosen = empty($chosen) ? WC()->checkout->get_value('radio_choice') : $chosen;
    //$chosen = empty($chosen) ? '5.00' : $chosen;
    //Changes
    $chosen = empty($chosen) ? $price : $chosen;

    $args = array(
        'type' => 'radio',
        'class' => array('form-row-wide', 'update_totals_on_change'),
        'options' => array(
            $price => 'Yes, cover my order',
            '0' => 'No Thanks'
        ),
        'default' => $chosen
    );

    echo '<div id="checkout-radio" class="insurance">';
    echo '<h3>Shipping Protection</h3>';
    echo '<p class="intro">from Damage, Loss & Theft for $' . $price . '</p>';
    woocommerce_form_field('radio_choice', $args, $chosen);
    echo '<p class="disclaimer">*By deselecting shipping protection, Right Choice is not liable for lost, damaged, or stolen items</p>';
    echo '</div>';
}

// Part 2
// Add Fee and Calculate Total
add_action('woocommerce_cart_calculate_fees', 'bbloomer_checkout_radio_choice_fee', 20, 1);

function bbloomer_checkout_radio_choice_fee($cart) {
    if (is_admin() && !defined('DOING_AJAX'))
        return;
    $radio = WC()->session->get('radio_chosen');
    if ($radio) {
        $cart->add_fee('Shipping Protection', $radio);
    }
}

// Part 3
// Add Radio Choice to Session
add_action('woocommerce_checkout_update_order_review', 'bbloomer_checkout_radio_choice_set_session');

function bbloomer_checkout_radio_choice_set_session($posted_data) {
    parse_str($posted_data, $output);
    if (isset($output['radio_choice'])) {
        WC()->session->set('radio_chosen', $output['radio_choice']);
    }
}

function woo_in_cart($product_id) {
    global $woocommerce;

    foreach ($woocommerce->cart->get_cart() as $key => $val) {
        $_product = $val['data'];

        if ($product_id == $_product->id) {
            return true;
        }
    }
    return false;
}

/* Disclaimer shortcode */

function colour_disclaimer_shortcode() {
    return '<p><em>Please ensure to check the colour of the sealer prior to installation. Once the product has been applied, Right Choice can take no responsibility for any discrepancies in colour variations.</em></p>';
}

add_shortcode('colour_disclaimer', 'colour_disclaimer_shortcode');

/* Disclaimer Terms in Checkout */
add_action('woocommerce_review_order_before_submit', 'bbloomer_add_checkout_per_product_terms', 9);

function bbloomer_add_checkout_per_product_terms() {
    if (woo_in_cart(43) || woo_in_cart(537) || woo_in_cart(155) || woo_in_cart(142) || woo_in_cart(146) || woo_in_cart(141) || woo_in_cart(143) || woo_in_cart(1514) || woo_in_cart(1409) || woo_in_cart(1388) || woo_in_cart(1318)) {
        ?>
        <p class="form-row terms wc-terms-and-conditions validate-required cus_terms">
            <label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
                <input type="checkbox" class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" name="terms-1" <?php checked(apply_filters('woocommerce_terms_is_checked_default', isset($_POST['terms-1'])), true); ?> id="terms-1">
                <span class="woocommerce-terms-and-conditions-checkbox-text">I agree that once sealer is applied, Right Choice can take no responsibility for any discrepancies in colour variation</span> <span class="required">*</span>
            </label>
            <input type="hidden" name="terms-1-field" value="true">
        </p>
        <?php
    }
}

// Show notice if customer does not tick either terms
add_action('woocommerce_checkout_process', 'bbloomer_not_approved_terms_1');

function bbloomer_not_approved_terms_1() {
    if ($_POST['terms-1-field'] == true) {
        if (empty($_POST['terms-1'])) {
            wc_add_notice(__('Please accept sealer colour terms to proceed with your order'), 'error');
        }
    }
}

add_action('woocommerce_product_thumbnails', 'woo_show_sizes', 20);

function woo_show_sizes() {
    echo '<div class="sizes">';
    global $product;
    $taxonomy = 'pa_size';
    if ($product->get_type() == 'variable') {
        $output = array();
        foreach ($product->get_available_variations() as $values) {
            foreach ($values['attributes'] as $attr_variation => $term_slug) {
                // Targetting "Size" attribute only
                if ($attr_variation === 'attribute_' . $taxonomy) {
                    // Add the size attribute term name value to the array (avoiding repetitions)
                    $output[$term_slug] = '<span>' . get_term_by('slug', $term_slug, $taxonomy)->name . '</span>';
                }
            }
        }
        if (sizeof($output) > 0) {
            echo '<div class="' . $taxonomy . '-variations-terms">' . implode('', $output) . '</div>';
        }
    }
    echo '</div>';
}

function md_custom_woocommerce_checkout_fields($fields) {
    $fields['order']['order_comments']['label'] = 'Order notes (Optional) - Couriers do <b>NOT</b> call prior to arrival & <b>ALL</b> deliveries are <b>Authority To Leave.</b>';
    return $fields;
}

add_filter('woocommerce_checkout_fields', 'md_custom_woocommerce_checkout_fields');

// Add custom fields to product shipping tab
add_action('woocommerce_product_options_shipping', 'add_custom_shipping_option_to_products');

function add_custom_shipping_option_to_products() {
    global $post, $product;
    echo '</div><div class="options_group">'; // New option group
    // Weight for 2nd box */
    woocommerce_wp_text_input(array(
        'id' => '_product_two_weight',
        'label' => __('Weight (kg)', 'woocommerce'),
        'placeholder' => '',
        'description' => __('For second box', 'woocommerce'),
        'type' => 'number',
        'custom_attributes' => array(
            'step' => 'any',
            'min' => '1'
        )
    ));

    // Length for 2nd box */
    woocommerce_wp_text_input(array(
        'id' => '_product_two_length',
        'label' => __('Length (cm)', 'woocommerce'),
        'placeholder' => '',
        'description' => __('For second box', 'woocommerce'),
        'type' => 'number',
        'custom_attributes' => array(
            'step' => 'any',
            'min' => '1'
        )
    ));

    // Width for 2nd box */
    woocommerce_wp_text_input(array(
        'id' => '_product_two_width',
        'label' => __('Width (cm)', 'woocommerce'),
        'placeholder' => '',
        'description' => __('For second box', 'woocommerce'),
        'type' => 'number',
        'custom_attributes' => array(
            'step' => 'any',
            'min' => '1'
        )
    ));

    // Height for 2nd box */
    woocommerce_wp_text_input(array(
        'id' => '_product_two_height',
        'label' => __('Height (cm)', 'woocommerce'),
        'placeholder' => '',
        'description' => __('For second box', 'woocommerce'),
        'type' => 'number',
        'custom_attributes' => array(
            'step' => 'any',
            'min' => '1'
        )
    ));

    // echo '</div>'; // New option group
}

// Save the custom fields values as meta data
add_action('woocommerce_process_product_meta', 'save_custom_shipping_option_to_products');

function save_custom_shipping_option_to_products($post_id) {

    // Save product two weight Field
    $number_field = $_POST['_product_two_weight'];
    //if( ! empty( $number_field ) ) {
    update_post_meta($post_id, '_product_two_weight', esc_attr($number_field));
    //}
    // Save product two length Field
    $number_field = $_POST['_product_two_length'];
    //if( ! empty( $number_field ) ) {
    update_post_meta($post_id, '_product_two_length', esc_attr($number_field));
    //}
    // Save product two width Field
    $number_field = $_POST['_product_two_width'];
    //if( ! empty( $number_field ) ) {
    update_post_meta($post_id, '_product_two_width', esc_attr($number_field));
    //}
    // Save product two height Field
    $number_field = $_POST['_product_two_height'];
    //if( ! empty( $number_field ) ) {
    update_post_meta($post_id, '_product_two_height', esc_attr($number_field));
    //}
}

$labels = array(
    'name' => _x('Testimonials', 'post type general name'),
    'singular_name' => _x('Testimonials', 'post type singular name'),
    'add_new' => _x('Add New', 'Testimonials'),
    'add_new_item' => __('Add New Testimonials'),
    'edit_item' => __('Edit Testimonials'),
    'new_item' => __('New Testimonials'),
    'view_item' => __('View Testimonials'),
    'search_items' => __('Search Testimonials'),
    'not_found' => __('Nothing found'),
    'not_found_in_trash' => __('Nothing found in Trash'),
    'parent_item_colon' => ''
);

$args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true,
    'query_var' => true,
    'has_archive' => true,
    'capability_type' => 'post',
    'hierarchical' => true,
    'menu_position' => 20,
    'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'page-attributes', 'revisions')
);

register_post_type('testimonials', $args);

add_shortcode('testimonialslisting', 'testimonialslisting_func');

function testimonialslisting_func() {
    global $post;
    $testimonials = get_posts([
        'post_type' => 'testimonials',
        'posts_per_page' => '3',
        'post_status' => 'publish',
    ]);
    if (!empty($testimonials)) {

        echo '<div class="list" id="reviewstream">';
        foreach ($testimonials as $testimonial) {
            ?>

            <div class="review" itemprop="review" itemtype="https://schema.org/Review">
                <div class="review-meta">

                    <?php if (!empty(get_field('date', $testimonial->ID))) { ?>
                        <div class="review-date">
                            <?php echo $date = get_field('date', $testimonial->ID); ?>
                        </div>
                    <?php } ?>

                    <?php if (!empty(get_field('online_url', $testimonial->ID))) { ?>
                        <div class="review-rating">
                            <?php $stars = get_field('start_rating', $testimonial->ID); ?>
                            <span class="stars" style="white-space: nowrap;">
                                <?php for ($x = 1; $x <= $stars; $x++) { ?>
                                    <i class="star-sm"></i>
                                <?php } ?>
                            </span>
                        </div>
                    <?php } ?>

                </div>

                <?php if (!empty($testimonial->post_content)) { ?>
                    <div class="review-text">
                        <div class="review-text-inner" itemprop="reviewBody">
                            <?php echo $testimonial->post_content; ?>
                        </div>
                    </div>
                <?php } ?>

                <div class="review-attribution">
                    <?php if (!empty(get_field('source', $testimonial->ID))) { ?>
                        <div class="review-source">
                            <?php $source = get_field('source', $testimonial->ID); ?>
                            <?php if ($source == 'Google') { ?>
                                <i class="icon-link-google"></i>
                            <?php } ?>
                            <?php if ($source == 'Facebook') { ?>
                                <i class="icon-link-facebook"></i>
                            <?php } ?>
                            <?php if ($source == 'Linkdin') { ?>
                                <i class="icon-link-linkdin"></i>
                            <?php } ?>
                        </div>
                    <?php } ?>

                    <?php if (!empty(get_field('name', $testimonial->ID))) { ?>
                        <div class="review-name" itemprop="author">
                            <?php echo get_field('name', $testimonial->ID); ?>
                        </div>
                    <?php } ?>

                    <?php if (!empty(get_field('online_url', $testimonial->ID))) { ?>
                        <div class="review-link">
                            <a href="<?php echo get_field('online_url', $testimonial->ID); ?>" target="_blank">View review</a>
                        </div>
                    <?php } ?>
                </div>
            </div> <!-- .review -->

        <?php } // foreach    ?>

        <div class="footer">
            <a id="fullstream" href="https://www.contreat.com.au/all-testimonials/" style="cursor: pointer;">See more reviews</a>
            &nbsp;
        </div>

        <?php
        echo '</div>';
    }
}

add_shortcode('testimonialslistingfull', 'testimonialslistingfull_func');

function testimonialslistingfull_func() {
    global $post;
    $testimonials = get_posts([
        'post_type' => 'testimonials',
        'posts_per_page' => '100',
        'post_status' => 'publish',
        'orderby' => 'date',
        'order' => 'DESC'
    ]);

    if (!empty($testimonials)) {

        echo '<div class="list listingpage" id="reviewstream">';
        foreach ($testimonials as $testimonial) {
            ?>

            <div class="review" itemprop="review" itemtype="https://schema.org/Review">

                <div class="review-meta">
                    <?php if (!empty(get_field('date', $testimonial->ID))) { ?>
                        <div class="review-date">
                            <?php echo $date = get_field('date', $testimonial->ID); ?>
                        </div>
                    <?php } ?>

                    <?php if (!empty(get_field('online_url', $testimonial->ID))) { ?>
                        <div class="review-rating">
                            <?php $stars = get_field('start_rating', $testimonial->ID); ?>
                            <span class="stars" style="white-space: nowrap;">
                                <?php for ($x = 1; $x <= $stars; $x++) { ?>
                                    <i class="star-sm"></i>
                                <?php } ?>
                            </span>
                        </div>
                    <?php } ?>
                </div><!-- .review-meta -->

                <?php if (!empty($testimonial->post_content)) { ?>
                    <div class="review-text">
                        <div class="review-text-inner" itemprop="reviewBody">
                            <?php echo $testimonial->post_content; ?>
                        </div>
                    </div>
                <?php } ?>

                <div class="review-attribution">
                    <?php if (!empty(get_field('source', $testimonial->ID))) { ?>
                        <div class="review-source">
                            <?php $source = get_field('source', $testimonial->ID); ?>
                            <?php if ($source == 'Google') { ?>
                                <i class="icon-link-google"></i>
                            <?php } ?>
                            <?php if ($source == 'Facebook') { ?>
                                <i class="icon-link-facebook"></i>
                            <?php } ?>
                            <?php if ($source == 'Linkdin') { ?>
                                <i class="icon-link-linkdin"></i>
                            <?php } ?>
                        </div>
                    <?php } ?>

                    <?php if (!empty(get_field('name', $testimonial->ID))) { ?>
                        <div class="review-name" itemprop="author">
                            <?php echo get_field('name', $testimonial->ID); ?>
                        </div>
                    <?php } ?>

                    <?php if (!empty(get_field('online_url', $testimonial->ID))) { ?>
                        <div class="review-link">
                            <a href="<?php echo get_field('online_url', $testimonial->ID); ?>" target="_blank">View review</a>
                        </div>
                    <?php } ?>
                </div> <!-- .review-attribution -->

            </div> <!-- .review -->
            <?php
        }

        echo '</div>';
    }
}

add_shortcode('woo_featured', 'wb_woo_featured');

function wb_woo_featured() {

    $args = array(
        'post_type' => 'product',
        'posts_per_page' => 4,
        'post_status' => 'publish',
        'tax_query' => array(
            array(
                'taxonomy' => 'product_visibility',
                'field' => 'name',
                'terms' => 'featured',
                'operator' => 'IN'
            ),
        ),
    );
    $featured_product = new WP_Query($args);

    if ($featured_product->have_posts()) :

        ob_start();

        echo '<div class="woocommerce columns-4"><ul class="products">';
        while ($featured_product->have_posts()) : $featured_product->the_post();

            $product = wc_get_product($featured_product->post->ID);
            $post_thumbnail_id = get_post_thumbnail_id();
            $product_thumbnail = wp_get_attachment_image_src($post_thumbnail_id, $size = 'shop-feature');
            $product_thumbnail_alt = get_post_meta($post_thumbnail_id, '_wp_attachment_image_alt', true);
            $average = $product->get_average_rating();
            ?>

            <li class="product">
                <a href="<?php the_permalink(); ?>">
                    <img src="<?php echo $product_thumbnail[0]; ?>" alt="<?php echo $product_thumbnail_alt; ?>">
                    <h2 class="woocommerce-loop-product__title"><?php the_title(); ?></h2>
                    <?php echo '<div class="star-rating"><span style="width:' . ( ( $average / 5 ) * 100 ) . '%"><strong itemprop="ratingValue" class="rating">' . $average . '</strong> ' . __('out of 5', 'woocommerce') . '</span></div>'; ?>
                    <?php if (!$product->get_short_description()) return; ?>
                    <div itemprop="description" class="product-description">
                        <?php echo apply_filters('woocommerce_short_description', $product->get_short_description()) ?>
                    </div>
                    <?php
                    if ($product->is_type('variable')) {
                        $product_variations = $product->get_available_variations();
                        $variation_product_id = $product_variations [0]['variation_id'];
                        $variation_product = new WC_Product_Variation($variation_product_id);
                        ?>
                        <span class="price"><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">$</span><?php echo $variation_product->regular_price; ?></span></span></a>
                <?php } else { ?>
                    <span class="price"><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">$</span><?php echo $product->get_regular_price(); ?></span></span></a>
            <?php } ?>
            <a href="<?php the_permalink(); ?>" class="button addtocartbutton">View Product</a>
            </li>
            <?php
        endwhile;
        echo '</ul></div>';
    endif;
    wp_reset_query();
    return ob_get_clean();
}

/* Solutions Finder */

function solutions_product_shortcode($atts, $content = null) {
    $a = shortcode_atts(array(
        'id' => '0'
            ), $atts);

    $id = esc_attr($a['id']);
    $code = '<img src="' . get_the_post_thumbnail_url($id) . '" alt=""/>';
    $code .= '<h2>' . get_the_title($id) . '</h2>';

    return $code;
}

add_shortcode('solutions_product', 'solutions_product_shortcode');

/*
  add_filter( 'woocommerce_no_shipping_available_html', 'my_custom_no_shipping_message' );
  add_filter( 'woocommerce_cart_no_shipping_available_html', 'my_custom_no_shipping_message' );
  function my_custom_no_shipping_message( $message ) {
  return __( 'There are no shipping options available. Please ensure that your address has been entered correctly, or contact us if you need any help.' );
  }
 */

add_filter('gform_submit_button', 'form_reset_button', 13, 2);

function form_reset_button($button, $form) {
    $button .= '<input type="reset" value="Reset Form">';
    return $button;
}


