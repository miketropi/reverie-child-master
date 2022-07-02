<?php

/**
 * Header template
 * @return void
 */
add_action( 'ccs/after_header', 'css_header_cat_product_mobile' );
function css_header_cat_product_mobile() {
	require_once(CCS_THEME_DIR . '/templates/header/product-cat-mb.php');
	
}



add_filter( 'dgwt/wcas/form/magnifier_ico', function ( $html, $class ) {
	$html = ccs_icon('search');
	return $html;
  }, 10, 2 );

  add_filter( 'woocommerce_add_to_cart_fragments', 'rns_cart_count_fragments', 10, 1 );

function rns_cart_count_fragments( $fragments ) {
    
    $fragments['span.num-order'] = '<span class="num-order">' . count(WC()->cart->get_cart()) . '</span>';
    
    return $fragments;
    
}


function wpa_filter_list_comments($args){
  $args['reverse_top_level'] = false;
  return $args;
}
add_filter( 'woocommerce_product_review_list_args', 'wpa_filter_list_comments' );