<?php
/*
Template Name: Blog
*/
get_header();
?>

<div class='row margin-fix'>
	<article id="post-<?php the_ID(); ?>" <?php post_class('sm-12 clearfix post'); ?>>
		<h1 itemprop="headline"><?php the_title(); ?></h1>
    <div class='blog-filter'>
      <div class='blog-filter__item' data-filter='english'>English</div>
      &nbsp;|&nbsp;
      <div class='blog-filter__item' data-filter='deutsch'>Deutsch</div>
    </div>
		<div class='blog-grid'>
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<?php
					$query = new WP_Query(array('post_type' => 'post', 'post_count' => -1));
					if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post(); ?>
            <?php $cats = get_the_category(); ?>
            <?php $catString = join(',', array_map(function($cat) { return($cat->name); }, $cats)); ?>
						<div class='blog-grid__item' data-filter='<?php echo $catString; ?>'>
							<a href='<?php the_permalink(); ?>'>
								<div class='blog-grid__item-image'>
									<?php if (get_field('blog_post_featured_image')): ?>
										<?php $img = get_field('blog_post_featured_image'); ?>
										<img src='<?php echo $img['sizes']['large']; ?>' alt='<?php echo $img['alt']; ?>' />
									<?php endif; ?>
								</div>
								<h3 class='blog-grid__item-title'>
                  <?php the_title(); ?>
                </h3>
							</a>
						</div>
				<?php endwhile; endif; ?>
				<?php wp_reset_query(); ?>
			<?php endwhile; endif; ?>
		</div>
	</article>
</div>

<?php get_footer(); ?>
