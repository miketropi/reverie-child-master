	</div><!-- Row End -->
	</div><!-- Container End -->
<?php
	if ( is_product_category() || is_product() ) {
		//echo '<div class="cta-section">' . do_shortcode('[INSERT_ELEMENTOR id="29037"]') . '</div>';
	}
?>
	<!--
<div class="full-width footer-widget">
	<div class="row">
		<?php dynamic_sidebar("Footer"); ?>
	</div>
</div>
-->


	<footer>
		<div class="css-vector-footer-top"></div>
		<div class="css-vector-footer-bottom"></div>
		<?php echo do_shortcode('[INSERT_ELEMENTOR id="85"]'); ?>
	</footer>

	<!--
<footer class="full-width" role="contentinfo">
	<div class="row love-reverie">
		<div class="large-12 columns">
			<p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. <?php _e('Made with Love in', 'reverie'); ?> <a href="http://themefortress.com/reverie/" rel="nofollow" title="Reverie Framework">Reverie</a>.</p>
		</div>
	</div>
</footer>
-->

	<?php wp_footer(); ?>

	<script>
		(function($) {
			$(document).foundation();
		})(jQuery);
	</script>
	<style>
		img#loder_img {
			display: none;
		}
	</style>
	</body>

	</html>
