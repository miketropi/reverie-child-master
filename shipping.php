<?php	

if(isset($_POST['suburb'])) {
	$suburb = $_POST['suburb'];
}
	
if(isset($_POST['postcode'])) {
	$postcode = $_POST['postcode'];
}

if(isset($_POST['quantity'])) {
	$quantity = $_POST['quantity'];
}

$api = 'bf941f7d53ea1166b1b8c58a630ed017';

if (is_product()) {

	global $product;
	
	if (isset($_POST["suburb"]) && !empty($_POST["postcode"])) {

		$totalprice = 0;
		$total_weight = 0;	
		$price = 0;
			
		$product_one_weight = $product->get_weight(); 
		if (get_post_meta( $product->get_id(), '_product_two_weight', true )) {
			$product_two_weight = get_post_meta( $product->get_id(), '_product_two_weight', true );
		}
		if (!empty($product_two_weight)) {
			$total_weight = $product_one_weight + $product_two_weight;	
		} else {
			$total_weight = $product_one_weight;
		}
		$total_weight = $total_weight * $quantity;
	
		$total_boxes = floor($total_weight/20);
		$remainder = $total_weight % 20;
		
		if ($total_boxes == 0) {
			
			if ($total_weight > 18) {
				$weights[0]['weight'] = 18;
				$weights[0]['quantity'] = 1;
			} else {
				$weights[0]['weight'] = $total_weight;
				$weights[0]['quantity'] = 1;
			}
		} else {
			$weights[0]['weight'] = 18;
			$weights[0]['quantity'] = $total_boxes;
			
			if ($remainder > 0) {
				if ($remainder > 18) {
					$weights[1]['weight'] = 18;
					$weights[1]['quantity'] = 1;
				} else {
					$weights[1]['weight'] = $remainder;
					$weights[1]['quantity'] = 1;
				}
			}
		}
	
		
		foreach ($weights as $weight) {

			$url = "https://au.api.fastway.org/v3/psc/lookup/BRI/".urlencode($suburb)."/".urlencode($postcode)."/".$weight['weight']."?api_key=".$api.'&showboxproduct=true';
			$url = str_replace ( '+', '%20', $url );
			$content = file_get_contents( $url );
			$result = json_decode( $content, true);
			
			/*echo "<pre>";
			print_r($result);
			echo "</pre>";*/
					
			if(isset($result['error'])){				
				
				$error = "<p class='error'>Please check your Suburb and Postcode are correct.</p>";	
				//exit('variables are not equal');  		
			
			} else {
		
			    if(isset($result['result'])){
					if(count($result['result']['services']) > 0){
			
						if ( $result['result']['services'][0]['labelcolour'] == "BROWN" ) {
						
							foreach($result['result']['services'] as $k => $r){
								if($r['labelcolour'] == "YELLOW"){
					            	$price = $r['totalprice_normal'];	
					            }  
					        }//foreach
					        
						} else if ( $result['result']['services'][0]['labelcolour'] == "LIME" ) {
			
							foreach($result['result']['services'] as $k => $r){
								if($r['labelcolour'] == "LIME"){
					            	$price = $r['totalprice_frequent'];	
					            }  
					        }//foreach
					   
						} else if ( $result['result']['services'][0]['labelcolour'] == "ORANGE" ) {
								
							foreach($result['result']['services'] as $k => $r){
								if($r['labelcolour'] == "LRG-FLAT-RATE-PARCEL"){
					            	$price = $r['totalprice_normal'];	
					            }  
					        }//foreach
							
						} else if ( $result['result']['services'][0]['labelcolour'] == "PINK" ) {
								
							foreach($result['result']['services'] as $k => $r){
								if($r['labelcolour'] == "LRG-FLAT-RATE-PARCEL"){
					            	$price = $r['totalprice_normal'];	
					            }  
					        }//foreach
							
						} else if ( $result['result']['services'][0]['labelcolour'] == "RED" ) {
								
							foreach($result['result']['services'] as $k => $r){
								if($r['labelcolour'] == "LRG-FLAT-RATE-PARCEL"){
					            	$price = $r['totalprice_normal'];	
					            }  
					        }//foreach
							
						} else if ( $result['result']['services'][0]['labelcolour'] == "GREEN" ) {
								
							foreach($result['result']['services'] as $k => $r){
								if($r['labelcolour'] == "LRG-FLAT-RATE-PARCEL"){
					            	$price = $r['totalprice_normal'];	
					            }  
					        }//foreach
							
						} else if ( $result['result']['services'][0]['labelcolour'] == "WHITE" ) {
								
							foreach($result['result']['services'] as $k => $r){
								if($r['labelcolour'] == "LRG-FLAT-RATE-PARCEL"){
					            	$price = $r['totalprice_normal'];	
					            }  
					        }//foreach
							
						} else if ( $result['result']['services'][0]['labelcolour'] == "GREY" ) {
								
							foreach($result['result']['services'] as $k => $r){
								if($r['labelcolour'] == "LRG-FLAT-RATE-PARCEL"){
					            	$price = $r['totalprice_normal'];	
					            }  
					        }//foreach
							
						}
			
					} //if count
				} // if result
			
				$price = $price * $weight['quantity'];
				$totalprice += $price;
		
			} // else
	
		} // foreach 
	
		$totalprice = round($totalprice , 2);
		$totalprice = number_format($totalprice, 2);
		
	} else {
		
		//$error = "<p class='error'>Please enter a Suburb and Postcode.</p>";	
		
	} // if isset suburb and postcode ?>
		
		<div class="shipping-calc<?php if (isset($_POST["suburb"]) && isset($_POST["postcode"])) {echo ' active';} ?>">
			<a href="#" class="close">x</a>
			<form action="#" method="post">
				<h3>Shipping Estimate for <?php echo $product->get_title(); ?></h3>
				<input type="text" name="suburb" placeholder="Suburb" value="<?php if(!empty($suburb)){echo $suburb;}?>">
				<input type="text" name="postcode" placeholder="Postcode" value="<?php if(!empty($postcode)){echo $postcode;}?>">
				<input type="hidden" name="quantity" class="quantity" placeholder="Quantity" value="<?php if(!empty($quantity)){echo $quantity;}?>">
				<input type="submit" name="submit" id="submit" value="Estimate">
			</form>
			<div class="message">
				<?php
					if (!empty($error)) {
						echo $error;	
					} else {
						if (!empty($totalprice)) {
							echo '<p class="price">$'.$totalprice.' for '.$quantity.' item(s) to '.$suburb.'.</p>';
							echo '<p><i>Estimate only. Exact shipping will be calculated at checkout.</i></p>';
						}
					}
				?>			
			</div>	
		</div>		
		
		
<?php } // if is product ?>