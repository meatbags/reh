<?php get_header(); ?>

	<div class="row margin-fix">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class('sm-12 clearfix post'); ?>>
				<?php the_post_thumbnail('featured', array( 'class'	=> "info-img img-responsive")); ?>
				<h1 itemprop="headline"><?php the_title(); ?></h1>
				<?php the_content(); ?>
				</div>
			</article>
		<?php endwhile; endif; ?>
	</div>
</section>

<?php get_footer(); ?>
