<?php /* Template Name: Full Width Simple template */ ?>
<?php get_header(); ?>
<div class="container">
  <div class="row titles">
      <div class="col-sm-2 logo">
          <?php echo get_the_logo(); ?>
      </div>
      <div class="col-sm-8">
          <h1><?php echo get_the_title(); ?></h1>
          <?php if (get_field('header_text') != null) { echo get_field('header_text'); }; ?>
      </div>
  </div>
</div>
<div class="container brd-1-db">
		<!-- section -->
		<div class="col-md-12 standard-page">
		<?php if (have_posts()): while (have_posts()) : the_post(); ?>

			<!-- article -->
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

				<?php the_content(); ?>

				<?php comments_template( '', true ); // Remove if you don't want comments ?>

				<br class="clear">

				<?php edit_post_link(); ?>

			</article>
    </div>

			<!-- /article -->

		<?php endwhile; ?>

		<?php else: ?>

			<!-- article -->
			<article>

				<h2><?php _e( 'Sorry, nothing to display.', 'html5blank' ); ?></h2>

			</article>
			<!-- /article -->

		<?php endif; ?>
		<div class="col-md-4" style="margin-bottom:40px">
			<?php get_sidebar(); ?>
		</div>
	</div>
	<div class="container" style="margin-bottom:40px">
		<?php if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('widget-area-2')) ?>
		<!-- /section -->
	</div>


<?php get_footer(); ?>
