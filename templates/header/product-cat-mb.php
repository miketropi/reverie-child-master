<?php
$prod_cat = get_field('prod_cat_mobile', 'option');
if (!$prod_cat && empty($prod_cat)) return;
?>

<div class="css-wrapper-prod-cat">
	<div class="css-wrapper-prod-cat-inner">
		<div class="list-prod-cat">
			<?php
			foreach ($prod_cat as $cat) {
				$thumbnail_id = get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id', true ); 
			?>
				<div class="prod-cat-item">
					<a class="img-prod-cat" href="<?= get_term_link( $cat->term_id, 'product_cat' );  ?>">
						<img src="<?= wp_get_attachment_url( $thumbnail_id );  ?>" alt="<?= $cat->name ?>" />
					</a>
					<h6><a href="<?= get_term_link( $cat->term_id, 'product_cat' ); ?>"><?= $cat->name ?></a></h6>
				</div>
			<?php
			}
			?>
		</div>
	</div>
</div>