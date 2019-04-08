<?php get_header(); ?>

<section class='blog'>
	<div class='blog__banner'>
		<h1 class='blog__title' itemprop='headline'><?php the_title(); ?></h1>
		<?php if (get_field('blog_post_featured_image')): ?>
			<?php $img = get_field('blog_post_featured_image'); ?>
			<img src='<?php echo $img['sizes']['large']; ?>' alt='<?php echo $img['alt']; ?>' />
		<?php endif; ?>
	</div>
	<div class='blog__info'>
		<?php if (get_field('blog_post_featured_image_text')): ?>
			<div class='blog__info-credits'>
				<?php the_field('blog_post_featured_image_text'); ?>
			</div>
		<?php endif; ?>
		<?php if (get_field('blog_sub_heading')): ?>
			<div class='blog__info-sub-heading'>
				<?php the_field('blog_sub_heading'); ?>
			</div>
		<?php endif; ?>
	</div>
	<?php if (have_rows('blog_post')): foreach (get_field('blog_post') as $row): ?>
		<?php $type = $row['blog_section_type']; ?>
		<section class='blog__section <?php echo 'blog__section--' . $type; ?>'>
			<?php if ($type == 'text'): ?>
				<?php $place = $row['blog_text_placement']; ?>
				<?php $snap = $row['blog_text_snap'] ? 'snap' : 'nosnap'; ?>
				<div class='blog__text blog__text--<?php echo $place; ?> blog__text--<?php echo $snap; ?>'>
					<?php echo $row['blog_section_text']; ?>
				</div>
			<?php elseif ($type == 'image' && $row['blog_section_images']): ?>
				<div class='blog__images'>
					<?php
						$len = sizeof($row['blog_section_images']);
						$column = 'blog__image--' . ($len > 3 ? '3' : $len);
						foreach ($row['blog_section_images'] as $img):
							$src = $img['image']['sizes']['large'];
							$alt = $img['image']['alt'] ? $img['placement_image']['alt'] : 'Blog Image';
							$hori = $img['image_horizontal_align'];
							$vert = $img['image_vertical_align'];
							$x = 'blog__image--x-' . $hori;
							$y = 'blog__image--y-' . $vert;
							$pos = ($hori == 'middle' ? 'center' : $hori) . ' ' . ($vert == 'middle' ? 'center' : $vert);
						?>
						<div class="blog__image <?php echo $column; ?> <?php echo $x; ?> <?php echo $y; ?>">
							<div class="blog__image-inner">
								<img src="<?php echo $src; ?>" style="object-position:<?php echo $pos; ?>;" alt="<?php echo $alt; ?>" />
								<?php if ($img['image_text']): ?>
									<?php echo $img['image_text']; ?>
								<?php endif; ?>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			<?php elseif ($type == 'video'): ?>
				<?php echo $row['video_embed']; ?>
			<?php endif; ?>
		</section>
	<?php endforeach; endif; ?>
</section>

<?php get_footer(); ?>
