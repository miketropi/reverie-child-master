<?php
/**
 * Header old
 */ 
?>
<header>
	<section class="main">
		<div class="row">
			<div class="small-12 medium-12 large-8 columns right">				 			
				<div class="needHelpHolder show-for-large-up">
					 <div class="needHelpBlock">
<!-- 					 	<a href="tel:1300 402 518">Need Help?<span>1300 402 518</span></a> -->
						 <a href="/contact-us/">Need Help?</a>
					 </div>	
					<div class="tradeBlock">
					 	<img src="/wp-content/uploads/2020/03/trade-pricing-direct-to-the-public.jpg" />
					 </div>	
				</div>	
			</div>

			<div class="small-12 medium-12 large-4 columns left">
				<a class="mobile-menu hide-for-large-up" href="#"><span></span></a>
				<a class="search-btn hide-for-large-up" href="#"><i class="fa fa-search" aria-hidden="true"></i></a>
				<a class="logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/right-choice-logo.png"></a>	
				<a class="email-btn hide-for-large-up" href="mailto:support@rightchoicecoatings.com.au"><i class="fa fa-envelope" aria-hidden="true"></i></a>	
				<a class="cart-btn hide-for-large-up" href="<?php echo wc_get_cart_url(); ?>"><i class="fa fa-shopping-cart"></i>Cart</a>	
			</div>			
		</div>
	</section>
    <nav>	    
		<div class="cartHolder"><a class="cart-btn show-for-large-up" href="<?php echo wc_get_cart_url(); ?>" title="<?php _e( 'View your shopping cart' ); ?>"><span class="number"><?php echo sprintf ( _n( '%d', '%d', WC()->cart->get_cart_contents_count() ), WC()->cart->get_cart_contents_count() ); ?></span><i class="fa fa-shopping-cart"></i>Cart</a></div>
	    <?php
	        wp_nav_menu( array(
	            'theme_location' => 'primary',
	            'container' => false,
	            'depth' => 0,
	            'items_wrap' => '<ul class="main-menu">%3$s</ul>',
	            'fallback_cb' => 'reverie_menu_fallback',
	            'walker' => new reverie_walker( array(
	                'in_top_bar' => true,
	                'item_type' => 'li',
	                'menu_type' => 'main-menu'
	            ) ),
	        ) );
	    ?> 
	</nav>
</header>