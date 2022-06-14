<?php
/*
Template Name: Shipping Calculations
*/
get_header();

echo '<br><br><br><br><br><br><br><br><br><br>';

global $woocommerce;
$items = $woocommerce->cart->get_cart();

$weight = 0;
$cost = 0;
$totalprice = 0;
$price = 0;
$total_weight = 0;

$c_suburb = 'Surfers Paradise';
$d_suburb = str_replace(' ', '%20', $c_suburb);
$d_postcode = '4217';

foreach ( $items as $item => $values ) { 	
	$_product = $values['data'];
	$shippable_product['quantity'] = $values['quantity'];
    $i = $shippable_product['quantity'];
	while ($i > 0) {
		$shippable_product = [];
	    $shippable_product['id'] = $_product->get_id();
	    $shippable_product['quantity'] = $values['quantity'];
	    $shippable_product['weight'] = $_product->get_weight(); 
	    $shippable_product['length'] = $_product->get_length();
	    $shippable_product['width'] = $_product->get_width();
		$shippable_product['height'] = $_product->get_height(); 
		$allshippableproducts[] = $shippable_product;
		if (get_post_meta( $values['product_id'], '_product_two_weight', true )) {
		    $shippable_product = [];   
			$shippable_product['id'] = $values['product_id'].'-2';
			$shippable_product['quantity'] = $values['quantity'];
		    $shippable_product['weight'] = get_post_meta( $values['product_id'], '_product_two_weight', true );
		    $shippable_product['length'] = get_post_meta( $values['product_id'], '_product_two_length', true );
		    $shippable_product['width'] = get_post_meta( $values['product_id'], '_product_two_width', true );
		    $shippable_product['height'] = get_post_meta( $values['product_id'], '_product_two_height', true );
		    $allshippableproducts[] = $shippable_product;
		    echo $shippable_product['weight'];
		    echo '<br>';
		}  
	    $i--;
	}
} // END LOOP THROUGH CART

//echo "<pre>";
//   print_r($allshippableproducts);
//echo "</pre>";

foreach ($allshippableproducts as $shippableproduct) {
	$total_weight += $shippableproduct['weight'];	
}





$url = 'https://idserv.airroad.com.au/connect/token';
$data = array(
	"grant_type" => "password",
	"username" => "RCCOATINGS",
	"password" => "RCCSEALERS",
	"Client_id" => "AirRoad_Web",
	"client_secret" => "hHQyfi0uNKmHomqystOa",
	"scope" => "openid profile connoteservice transitcalcservice postcodeservice holidayservice quoteservice"
);
$options = array(
	'http' => array(
		'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
		'method'  => 'POST',
		'content' => http_build_query($data)
	)
);
$context = stream_context_create($options);
$result = file_get_contents($url, false, $context);
if ($result === FALSE) {
	// Handle error
	console.log("ERROR");
}
$result = json_decode($result, true);


$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://my.airroad.com.au/api/v2/quote?fromcode=4129&tocode='.$d_postcode.'&wgt=40&fromsub=LOGANHOLME&tosub='.$d_suburb);
//curl_setopt($ch, CURLOPT_URL, 'https://my.airroad.com.au/api/v2/quote?fromcode=4129&tocode=4570&wgt=40&fromsub=LOGANHOLME&tosub=CANINA');
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded', 'Authorization: Bearer '. $result["access_token"]));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$result = curl_exec($ch);
curl_close($ch);
$result = json_decode($result, true);


echo "<pre>";
   print_r($result);
echo "</pre>";


if ($result['message']) {
	// error?
	echo $result['message'];
} elseif ($result == '') {
	// error?
	echo 'Nothing';
} else {
	//echo 'Total Weight: '.$total_weight;
	//echo '<br>';
	echo 'Sending '.$total_weight.'kg from Loganholme 4129 to '.$c_suburb.' '.$d_postcode;
	echo '<br>';
	
	if ($result['surcharge']) {
		echo $result['amount'].' + '.$result['fuelLevy'].' + '.$result['gst'].' + '.$result['surcharge'];
		$temp_subtotal = $result['amount']+$result['fuelLevy']+$result['gst']+$result['surcharge'];
		echo '<br>';
		echo 'SubTotal '.$temp_subtotal;
		echo '<br>';
	} else {
		echo $result['amount'].' + '.$result['fuelLevy'].' + '.$result['gst'];
		$temp_subtotal = $result['amount']+$result['fuelLevy']+$result['gst'];
		echo '<br>';
		echo 'SubTotal '.$temp_subtotal;
		echo '<br>';
	}
	
	
	$subtotal = round($temp_subtotal, 2);
	echo 'sub '.$subtotal;
	
}


echo '<br><br><br><br><br><br><br><br><br><br>';

get_footer(); ?>