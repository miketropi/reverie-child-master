<?php

/**
 * Header template
 * @return void
 */
add_action( 'ccs/after_header', 'css_header_cat_product_mobile' );
function css_header_cat_product_mobile() {
	require_once(CCS_THEME_DIR . '/templates/header/product-cat-mb.php');
}