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

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header( 'shop' ); ?>

	<?php
		/**
		 * woocommerce_before_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
		do_action( 'woocommerce_before_main_content' );
	?>

		<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>

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

		<?php if ( have_posts() ) : ?>

			<?php
				/**
				 * woocommerce_before_shop_loop hook.
				 *
				 * @hooked woocommerce_result_count - 20
				 * @hooked woocommerce_catalog_ordering - 30
				 */
				do_action( 'woocommerce_before_shop_loop' );
			
				/* Category - SubCategory START */
				$term 			= get_queried_object();
				$parent_id 		= empty( $term->term_id ) ? 0 : $term->term_id;

				$product_categories = get_categories( array( 'taxonomy' => 'product_cat', 'child_of' => $parent_id) );

				$i = 1;
				foreach ($product_categories as $product_category) {
					//print_r($product_category);
					if ($product_category->parent != 0) {
					echo '<h2 class="sub-cat-heading">'.$product_category->name.'</h2>';
					woocommerce_product_loop_start(); //open ul
					
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
					$cat_query = new WP_Query( $args );

					while ( $cat_query->have_posts() ) : $cat_query->the_post();
						wc_get_template_part( 'content', 'product' );
					endwhile; // end of the loop.
				wp_reset_postdata();
				woocommerce_product_loop_end(); //close ul
				}
				if ( $i < count($product_categories) )
					echo '<div class="content-seperator"></div>';
				$i++;
				}//foreach

				/* Category - SubCategory END */

				/**
				 * woocommerce_after_shop_loop hook.
				 *
				 * @hooked woocommerce_pagination - 10
				 */
				do_action( 'woocommerce_after_shop_loop' );
			?>

		<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

			<?php wc_get_template( 'loop/no-products-found.php' ); ?>

		<?php endif; ?>

	<?php
		/**
		 * woocommerce_after_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action( 'woocommerce_after_main_content' );
	?>

	<?php
		/**
		 * woocommerce_sidebar hook.
		 *
		 * @hooked woocommerce_get_sidebar - 10
		 */
		do_action( 'woocommerce_sidebar' );
	?>

<?php get_footer( 'shop' ); ?>
