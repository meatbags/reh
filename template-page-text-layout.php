<?php
/*
Template Name: Text layout
*/
get_header();

?>

<div class="row margin-fix" style="text-align: justify;">
  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class('xs-12 sm-10 sm-offset-1 md-8 md-offset-2 clearfix post'); ?>>
      <h1 itemprop="headline"><?php the_title(); ?></h1>
      <?php the_content(); ?>
      </div>
    </article>
  <?php endwhile; endif; ?>
</div>

<?php get_footer(); ?>
