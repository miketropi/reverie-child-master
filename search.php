<?php get_header(); ?>

<div id="main">
	<div class="row">
		<div class="small-12 medium-12 large-12 columns">
			
			<?php if ( have_posts() ) : 
				$last_type="";
				$typecount = 0;
				while (have_posts()) : the_post();
					if ($last_type != $post->post_type) {
						$typecount = $typecount + 1;
						if ($typecount > 1){
							echo '</div><!-- close container -->'; //close type container
    					}
						// save the post type.
						$last_type = $post->post_type;
						//open type container
						switch ($post->post_type) {
							case 'post':
								echo "<div class=\"postsearch container\"><ul class='posts'>";
								break;
							case 'page':
								echo "<div class=\"pagesearch container\"><ul class='pages'>";
								break;
							case 'product':
								echo "<div class=\"productsearch container\"><h2 class='searchTitle'>Shop for ".get_search_query() ."</h2><ul class='products'>";
								break;
						}
					} 
					?>

					<?php if('post' == get_post_type()) : ?>
					    <li class="post"><?php the_title(); ?></li>
					<?php endif; ?>
					
					<?php if('page' == get_post_type()) : ?>
					    <li class="page"><h3><a href="<?php the_permalink(); ?>"><?php search_title_highlight(); ?></a></h3><a class="permalink" href="<?php the_permalink(); ?>"><?php the_permalink(); ?></a><?php search_excerpt_highlight(); ?></li>
					<?php endif; ?>
					
					<?php if('product' == get_post_type()) : ?>
						<!--<li class="product"><?php the_title(); ?></li>-->						
						<li class="product">
							<a href="<?php the_permalink(); ?>" class="">
								<?php the_post_thumbnail('full'); ?>
								<h2 class="woocommerce-loop-product__title"><?php search_title_highlight(); ?></h2>
								<!--<span class="price">From <span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">$</span>2.00</span></span>-->
							</a>
							<a href="<?php the_permalink(); ?>" class="button add_to_cart_button">View Product</a>
						</li>
					<?php endif; ?>
					
				<?php endwhile; ?>

			<?php else : ?>

				<div class="open-a-div">
					<p>No results found.</p>    
			
			<?php endif; ?>       

		</div><!-- throw a closing div in --> 

	</ul></div>
	<?php //get_sidebar(); ?>
	
</div>


</div>


<?php get_footer(); ?>