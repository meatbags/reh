<?php get_header(); ?>

	<section>
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(''); ?>>
				<header>
					<a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail( 'featured-thumb' ); ?></a>
					<div class="page-header"><h1 class="h2"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1></div>
				</header>
			</article>
		<?php endwhile; endif;?>
	</section>

<?php get_footer(); ?>
