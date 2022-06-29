<?php

/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.4.0
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

get_header('shop'); ?>

<?php
/**
 * woocommerce_before_main_content hook.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 */
do_action('woocommerce_before_main_content');
?>

<?php if (apply_filters('woocommerce_show_page_title', true)) : ?>

	<h1 class="page-title"><?php woocommerce_page_title(); ?></h1>

<?php endif; ?>

<?php
/**
 * woocommerce_archive_description hook.
 *
 * @hooked woocommerce_taxonomy_archive_description - 10
 * @hooked woocommerce_product_archive_description - 10
 */
// do_action( 'woocommerce_archive_description' );
?>

<?php if (have_posts()) : ?>

	<?php
	/**
	 * woocommerce_before_shop_loop hook.
	 *
	 * @hooked woocommerce_result_count - 20
	 * @hooked woocommerce_catalog_ordering - 30
	 */
	do_action('woocommerce_before_shop_loop');

	/* Category - SubCategory START */
	$term 			= get_queried_object();
	$parent_id 		= empty($term->term_id) ? 0 : $term->term_id;

	$product_categories = get_categories(array('taxonomy' => 'product_cat', 'child_of' => $parent_id));

	?>
	<div class="wrapper-cat-product">
		<div class="wrapper-cat-product-inner">
			<div class="rows">
				<div class="csscols cols-md-3">
					<?php
					$cat_args = array(
						'orderby'    => 'name',
						'order'      => 'asc',
						'hide_empty' => false,
					);

					//$product_categories = get_terms('product_cat', $cat_args);
					$product_categories_menu = get_field('prod_cat_mobile', 'option');


					if (!empty($product_categories_menu)) {
					?>
						<div class="e-product-cate-menu__inner">
							<h4 class="hfp-widget__title">Categories</h4>
							<ul class="p-term-list">
								<?php $classes_all = 'all-products' == $term->slug ? 'active-item' : ''; ?>
								<?php if ($product_categories_menu && count($product_categories_menu) > 0) {
									foreach ($product_categories_menu as $key => $category) {
										$classes = $category->slug == $term->slug ? 'active-item' : '';
								?>
										<li class="p-term-list__item <?= $classes ?>">
											<a href="<?php echo  get_term_link($category) ?>">
												<span class="__icon-arrow"><?php echo hfp_icon('arrow_next'); ?></span>
												<?php echo $category->name ?>
											</a>
										</li>
								<?php }
								} ?>
								<li class="p-term-list__item <?= $classes_all ?>">
									<a href="/product-category/all-products/">
										<span class="__icon-arrow"><?php echo hfp_icon('arrow_next'); ?></span>
										All Products
									</a>
								</li>
							</ul>
						</div>
					<?php
					}
					?>
				</div>
				<div class="csscols cols-md-9">
					<?php
					echo '<div class="e-products-grid woocommerce">';
					$i = 1;
					foreach ($product_categories as $product_category) {
						if ($product_category->parent != 0) {
							echo '<h2 class="title-cat-heading">' . $product_category->name . '</h2>';
							echo '<div class="e-products-grid__inner">';
							$args = array(
								'posts_per_page' => -1,
								'tax_query' => array(
									'relation' => 'AND',
									array(
										'taxonomy' => 'product_cat',
										'field' => 'slug',
										'terms' => $product_category->slug
									),
								),
								'post_type' => 'product',
								'orderby' => 'title',
								'order' => 'ASC',
							);
							$cat_query = new WP_Query($args);
							$product_array = [];

							while ($cat_query->have_posts()) : $cat_query->the_post();
								array_push($product_array, $cat_query->post->ID);
							endwhile; // end of the loop.
							wp_reset_postdata();


							foreach (array_chunk($product_array, 3) as $key => $product_group) {
								echo '<div class="wrap-item">';
								foreach ($product_group as $key => $id) {
									
									$product = wc_get_product($id);
									$post_thumbnail_id = get_post_thumbnail_id($id);
									$product_thumbnail = wp_get_attachment_image_src($post_thumbnail_id, $size = 'shop-feature');
									$product_thumbnail_alt = get_post_meta($post_thumbnail_id, '_wp_attachment_image_alt', true);
									$average = $product->get_average_rating();

									$p_image = (($product_thumbnail && isset($product_thumbnail[0])) ? $product_thumbnail[0] : wc_placeholder_img_src());
								?>
									<div class="e-products-grid__item">
										<a class="thumb-prod" href="<?php echo get_permalink($id); ?>">
											<img src="<?php echo $p_image; ?>" alt="<?php echo $product_thumbnail_alt; ?>">
										</a>
										<h2 class="woocommerce-loop-product__title">
											<a href="<?php echo get_permalink($id); ?>"><?php echo  get_the_title($id); ?></a>
										</h2>
										<div class="prod-star-rating">
											<span class="prod-star prod-star-df"></span>
											<span class="prod-star prod-star-active" style="width:<?= (($average / 5) * 100) ?>%"><span></span></span>
										</div>
										<?php if (!$product->get_short_description()) return; ?>
										<div itemprop="description" class="product-description">
											<?php echo apply_filters('woocommerce_short_description', $product->get_short_description()) ?>
										</div>
										<?php
										if ($product->is_type('variable')) {
											$product_variations = $product->get_available_variations();
											$variation_product_id = $product_variations[0]['variation_id'];
											$variation_product = new WC_Product_Variation($variation_product_id);
										?>
											<span class="price"><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">$</span><?php echo $variation_product->regular_price; ?></span></span></a>
										<?php } else { ?>
											<span class="price"><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">$</span><?php echo $product->get_regular_price(); ?></span></span></a>
										<?php } ?>
										<a href="<?php echo get_permalink($id); ?>" class="btn-product-detail">View Product</a>
									</div>
					<?php
								}
								echo '</div>';
							}
							echo '</div>';
						}
						if ($i < count($product_categories))
							echo '<div class="content-seperator"></div>';
						$i++;
					} //foreach
					echo '</div>';
					?>
				</div>
			</div>
		</div>
	</div>
	<?php

	/* Category - SubCategory END */

	/**
	 * woocommerce_after_shop_loop hook.
	 *
	 * @hooked woocommerce_pagination - 10
	 */
	do_action('woocommerce_after_shop_loop');
	?>

<?php elseif (!woocommerce_product_subcategories(array('before' => woocommerce_product_loop_start(false), 'after' => woocommerce_product_loop_end(false)))) : ?>

	<?php wc_get_template('loop/no-products-found.php'); ?>

<?php endif; ?>

<?php
/**
 * woocommerce_after_main_content hook.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action('woocommerce_after_main_content');
?>

<?php
/**
 * woocommerce_sidebar hook.
 *
 * @hooked woocommerce_get_sidebar - 10
 */
do_action('woocommerce_sidebar');

?>

<?php get_footer('shop'); ?>