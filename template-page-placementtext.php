<?php
/*
Template Name: Text and image placement
*/
get_header();

?>

	<?php if( have_rows('placementimagetext') ): ?>
		<section class="placement">
			<div class="placement__sizer"></div>
			<?php while( have_rows('placementimagetext') ): the_row(); ?>
				<?php $value = get_sub_field( "placementimagetext_paragraph_text" );
					if ($value): ?>
					<div style="height: auto !important" class="placement__item <?php if (get_sub_field('placementimagetext_width')): ?>placement__item--w-<?php the_sub_field('placementimagetext_width');?> <?php endif;?><?php if (get_sub_field('placementimagetext_height')): ?>placement__item--h-<?php the_sub_field('placementimagetext_height');?> <?php endif;?><?php if (get_sub_field('placementimagetext_align')): ?>placement__item--a-<?php the_sub_field('placementimagetext_align');?> <?php endif;?><?php if (get_sub_field('placementimagetext_offset')==true): ?>placement__item--o-x <?php endif;?><?php if (get_sub_field('placementimagetext_offset_y')==true): ?>placement__item--o-y<?php endif;?>">
						<?php echo the_sub_field('placementimagetext_paragraph_text'); ?>
					</div>
				<?php else: ?>
					<?php if (get_sub_field('placementimagetext_url')): ?>
						<a href="<?php echo the_sub_field('placementimagetext_url'); ?>">
					<?php endif; ?>
						<div class="placement__item <?php if (get_sub_field('placementimagetext_width')): ?>placement__item--w-<?php the_sub_field('placementimagetext_width');?> <?php endif;?><?php if (get_sub_field('placementimagetext_height')): ?>placement__item--h-<?php the_sub_field('placementimagetext_height');?> <?php endif;?><?php if (get_sub_field('placementimagetext_align')): ?>placement__item--a-<?php the_sub_field('placementimagetext_align');?> <?php endif;?><?php if (get_sub_field('placementimagetext_offset')==true): ?>placement__item--o-x <?php endif;?><?php if (get_sub_field('placementimagetext_offset_y')==true): ?>placement__item--o-y<?php endif;?>">
							<?php if (get_sub_field('placementimagetext_image')): ?>
								<img src="<?php echo get_sub_field('placementimagetext_image')['url']; ?>"<?php if (get_sub_field('placementimagetext_image')['alt'] !== ''): ?> alt="<?php echo get_sub_field('placementimagetext_image')['alt']; ?>"<?php else:?> alt="Journal image"<?php endif;?>>
							<?php endif; ?>
							<?php if (get_sub_field('placementimagetext_text')): ?>
								<p><?php echo the_sub_field('placement_text'); ?></p>
							<?php endif; ?>
						</div>
					<?php if (get_sub_field('placementimagetext_url')): ?>
						</a>
					<?php endif; ?>
				<?php endif; ?>
			<?php endwhile; ?>
		</section>
	<?php endif; ?>

<?php get_footer(); ?>
