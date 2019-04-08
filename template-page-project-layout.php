<?php
/*
Template Name: Project layout
*/
get_header();

?>

<?php if (get_field('project_banner_desktop') && get_field('project_banner_mobile')) : ?>
	<div class="project-banner">
		<img alt="<?php the_title(); ?>" src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-desktop="<?php echo the_field('project_banner_desktop'); ?>" data-mobile="<?php echo the_field('project_banner_mobile'); ?>" alt="Banner image for R.EH philanthropic projects in Peru">
	</div>
<?php endif; ?>

<?php if( have_rows('project_imagetext') ): ?>
	<section class="imagetext row">
		<div class="imagetext__sizer"></div>
		<?php while( have_rows('project_imagetext') ): the_row(); ?>
			<?php if (get_sub_field('project_imagetext_image')): ?>
				<div class="imagetext__item sm-6">
					<img src="<?php echo get_sub_field('project_imagetext_image')['url']; ?>"<?php if (get_sub_field('project_imagetext_image')['alt'] !== ''): ?> alt="<?php echo get_sub_field('project_imagetext_image')['alt']; ?>"<?php else:?> alt="Journal image"<?php endif;?>>
				</div>
			<?php elseif (get_sub_field('project_imagetext_text')): ?>
				<div class="imagetext__item sm-10 sm-offset-1">
					<?php echo get_sub_field('project_imagetext_text'); ?>
				</div>
			<?php endif; ?>
		<?php endwhile; ?>
	</section>
<?php endif; ?>

<?php get_footer(); ?>
