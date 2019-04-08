<?php
/*
Template Name: Journal layout
*/
get_header();

?>
	<h1 itemprop="headline"><?php the_title(); ?></h1>
	<?php if( have_rows('placement') ): ?>
		<section class="placement">
			<div class="placement__sizer"></div>
			<?php while( have_rows('placement') ): the_row(); ?>
				<?php if (get_sub_field('placement_video_embed')): ?>
					<div class="placement__item <?php if (get_sub_field('placement_width')): ?>placement__item--w-<?php the_sub_field('placement_width');?> <?php endif;?><?php if (get_sub_field('placement_height')): ?>placement__item--h-<?php the_sub_field('placement_height');?> <?php endif;?><?php if (get_sub_field('placement_align')): ?>placement__item--a-<?php the_sub_field('placement_align');?> <?php endif;?><?php if (get_sub_field('placement_offset')==true): ?>placement__item--o-x <?php endif;?><?php if (get_sub_field('placement_offset_y')==true): ?>placement__item--o-y<?php endif;?>">
						<div class="video-embed"><?php echo the_sub_field('placement_video_embed'); ?></div>
					</div>
				<?php else: ?>
					<?php if (get_sub_field('placement_url')): ?>
						<a href="<?php echo the_sub_field('placement_url'); ?>">
					<?php endif; ?>
						<div class="placement__item <?php if (get_sub_field('placement_width')): ?>placement__item--w-<?php the_sub_field('placement_width');?> <?php endif;?><?php if (get_sub_field('placement_height')): ?>placement__item--h-<?php the_sub_field('placement_height');?> <?php endif;?><?php if (get_sub_field('placement_align')): ?>placement__item--a-<?php the_sub_field('placement_align');?> <?php endif;?><?php if (get_sub_field('placement_offset')==true): ?>placement__item--o-x <?php endif;?><?php if (get_sub_field('placement_offset_y')==true): ?>placement__item--o-y<?php endif;?>">
							<?php if (get_sub_field('placement_image')): ?>
								<img src="<?php echo get_sub_field('placement_image')['url']; ?>"<?php if (get_sub_field('placement_image')['alt'] !== ''): ?> alt="<?php echo get_sub_field('placement_image')['alt']; ?>"<?php else:?> alt="Journal image"<?php endif;?>>
							<?php endif; ?>
							<?php if (get_sub_field('placement_text')): ?>
								<p><?php echo the_sub_field('placement_text'); ?></p>
							<?php endif; ?>
						</div>
					<?php if (get_sub_field('placement_url')): ?>
						</a>
					<?php endif; ?>
				<?php endif;?>
			<?php endwhile; ?>
		</section>
	<?php endif; ?>

<?php get_footer(); ?>
