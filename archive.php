<?php get_header(); ?>

	<div class="page-header">
		<?php if (is_category()) { ?>
			<h1 class="archive_title h2">
				<span><?php _e("Posts Categorized:", "wpbootstrap"); ?></span> <?php single_cat_title(); ?>
			</h1>
		<?php } elseif (is_tag()) { ?>
			<h1 class="archive_title h2">
				<span><?php _e("Posts Tagged:", "wpbootstrap"); ?></span> <?php single_tag_title(); ?>
			</h1>
		<?php } elseif (is_author()) { ?>
			<h1 class="archive_title h2">
				<span><?php _e("Posts By:", "wpbootstrap"); ?></span> <?php get_the_author_meta('display_name'); ?>
			</h1>
		<?php } elseif (is_day()) { ?>
			<h1 class="archive_title h2">
				<span><?php _e("Daily Archives:", "wpbootstrap"); ?></span> <?php the_time('l, F j, Y'); ?>
			</h1>
		<?php } elseif (is_month()) { ?>
				<h1 class="archive_title h2">
					<span><?php _e("Monthly Archives:", "wpbootstrap"); ?>:</span> <?php the_time('F Y'); ?>
				</h1>
		<?php } elseif (is_year()) { ?>
				<h1 class="archive_title h2">
					<span><?php _e("Yearly Archives:", "wpbootstrap"); ?>:</span> <?php the_time('Y'); ?>
				</h1>
		<?php } ?>
	</div>

	<section id="main" class="clearfix">
		<div class="row">
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class('xs-4'); ?>>
					<a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail( 'featured-thumb' ); ?></a>
					<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
						<?php the_title(); ?>
					</a></h2>
				</article>
			<?php endwhile; ?>

			<?php else : ?>
				<article id="post-not-found">
					<section class="post_content">
						<p><?php _e("Sorry, What you were looking for is not here.", "wpbootstrap"); ?></p>
					</section>
				</article>
			<?php endif; ?>

			</div>

		</div>
	</div>
</div>

<?php get_footer(); ?>
