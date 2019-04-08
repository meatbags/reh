<?php get_header(); ?>

			<div class="row">
					<section id="main" class="col-sm-12 search">
						<div class="content-wrap">
							<div class="row search-row infinite equal-height">

					<div class="page-header"><h1><span><?php _e("Search Results for","wpbootstrap"); ?>:</span> <?php echo esc_attr(get_search_query()); ?></h1></div>

					<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

					<article id="post-<?php the_ID(); ?>" <?php post_class('col-sm-4 clearfix post'); ?>>
						<div class="row">
							<div class="col-sm-12">
								<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('featured', array( 'class'	=> "img-responsive")); ?></a>
								<a href="<?php the_permalink(); ?>">
									<div class="article-content equal">
										<span class="article-link">+</span>
										<h1 class="h4"><?php the_title(); ?></h1>
										<?php the_excerpt(); ?>
									</div>
								</a>
							</div>
						</div>
					</article>

					<?php endwhile; ?>

					<?php if (function_exists('page_navi')) { // if expirimental feature is active ?>

						<?php page_navi(); // use the page navi function ?>

					<?php } else { // if it is disabled, display regular wp prev & next links ?>
						<nav class="wp-prev-next">
							<ul class="clearfix">
								<li class="prev-link"><?php next_posts_link(_e('&laquo; Older Entries', "wpbootstrap")) ?></li>
								<li class="next-link"><?php previous_posts_link(_e('Newer Entries &raquo;', "wpbootstrap")) ?></li>
							</ul>
						</nav>
					<?php } ?>

					<?php else : ?>

					<!-- this area shows up if there are no results -->

					<article id="post-not-found">
					    <header>
					    	<h1><?php _e("Not Found", "wpbootstrap"); ?></h1>
					    </header>
					    <section class="post_content">
					    	<p><?php _e("Sorry, but the requested resource was not found on this site.", "wpbootstrap"); ?></p>
					    </section>
					    <footer>
					    </footer>
					</article>

					<?php endif; ?>

				</div> <!-- end #main -->

			</div> <!-- end #content -->
		</section>
	</div>

<?php get_footer(); ?>
