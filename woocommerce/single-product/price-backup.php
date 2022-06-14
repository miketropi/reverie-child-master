<?php
/**
 * Single Product Price
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/price.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product; 
 
$varP = 0;
if( $product->is_type( 'variable' ) ) {
 	$min_var_reg_price = wc_trim_zeros($product->get_variation_regular_price( 'min', true ));
	$min_var_sale_price = $product->get_variation_sale_price( 'min', true );
	$max_var_reg_price = $product->get_variation_regular_price( 'max', true );
	$max_var_sale_price = $product->get_variation_sale_price( 'max', true );
 
	if ( ! ( $min_var_reg_price == $max_var_reg_price && $min_var_sale_price == $max_var_sale_price ) ) {   
	    if ( $min_var_sale_price < $min_var_reg_price ) {
	         $price = sprintf( __( '%1$s - %2$s', 'woocommerce' ), 'From', wc_price( $min_var_sale_price ) );	 
	    } else if(!empty($min_var_reg_price) && !empty($min_var_sale_price)) {
	         $price = sprintf( __( '%1$s %2$s', 'woocommerce' ), 'From', wc_price( $min_var_reg_price ) );	 
	    } 		 
	} else {
		$book = new WDP_Price_Display();
        $price = sprintf( __( '%1$s %2$s', 'woocommerce' ), 'From', wc_price( $min_var_reg_price ) );
        $originalPrice = $price;
	    $price = apply_filters( 'woocommerce_get_price_html', $price, $product);
	    $calculatedPrice = $price;
	} ?>
	<p class="fromPrice <?php echo esc_attr( apply_filters( 'woocommerce_product_price_class', 'price' ) );?>">  <?php echo $price; ?>
 		<span class="save-total-price" style="display:none;">Save up to <span class="saved-price">0</span></span>
 	</p>
<?php } else {
?>

<p class="<?php echo esc_attr( apply_filters( 'woocommerce_product_price_class', 'price' ) );?>"><?php echo $product->get_price_html($price);  ?>  </p>
<?php } ?>
 <script>
 
    setTimeout(function () { 
		if (jQuery('.wdp_pricing_table').length > 0) {
			var originalPrice = jQuery(".bulk_table>table>tbody>tr:first>td:last").html();
			var calculatedPrice = jQuery(".bulk_table>table>tbody>tr:last>td:last").html();
			
			 //var calculatedPrice = jQuery(".calculatedPrice .woocommerce-Price-amount").html(); 
			 //var originalPrice = jQuery(".originalPrice .woocommerce-Price-amount").html();
			
			var calculated_Price = calculatedPrice.split("</span>");
			var original_Price = originalPrice.split("</span>");
			 
			var savedTotal = ((original_Price[1])*1)-((calculated_Price[1])*1);
			if(savedTotal>0){
				jQuery('.saved-price').html("$"+savedTotal.toFixed(2));
				jQuery('.save-total-price').show();
			}
	  }
}, 1000);

</script> 
 