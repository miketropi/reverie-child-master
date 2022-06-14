<?php get_header(); ?>
</div><!-- end row -->

	<?php while (have_posts()) : the_post(); ?>
		<?php the_content(); ?>
	<?php endwhile; ?>

<div class="row">	
<?php get_footer(); ?>