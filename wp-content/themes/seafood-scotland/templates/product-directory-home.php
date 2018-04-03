<?php /* Template Name: Product Directory Home template */ ?>
<?php get_header(); ?>
<?php get_seafood_scotland_global_header(get_the_title(), get_field('header_text')); ?>
<div class="container  brd-1-db">
		<P style="font-size: 20px;width: 900px;margin-bottom: 20px;">This tool allows you to find information on a varied catalogue of Scotland’s seafood producers. 
<BR>Refine your supplier search using options below.
</P>
		<!-- section -->
			<?php if (have_posts()): while (have_posts()) : the_post(); ?>
		<?php $big_image = get_field('search_box'); ?>
  <div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="5000">
	<?php the_content(); ?>
    <!-- Wrapper for slides -->
    <div class="carousel-inner">
      <div class="item active">
        <img src="http://seafood-scotland.palmerminto.com/wp-content/uploads/2018/03/Producer-Directory-Carousel-Images_1.jpg" alt="fish" style="width:100%; height: 400px;">
      </div>

      <div class="item">
        <img src="http://seafood-scotland.palmerminto.com/wp-content/uploads/2018/03/Producer-Directory-Carousel-Images_2.jpg" alt="fish" style="width:100%; height: 400px;">
      </div>
    
      <div class="item">
        <img src="http://seafood-scotland.palmerminto.com/wp-content/uploads/2018/03/Producer-Directory-Carousel-Images_3.jpg" alt="fish" style="width:100%; height: 400px;">
      </div>

            <div class="item">
        <img src="http://seafood-scotland.palmerminto.com/wp-content/uploads/2018/03/Producer-Directory-Carousel-Images_4.jpg" alt="fish" style="width:100%; height: 400px;">
      </div>

            <div class="item">
        <img src="http://seafood-scotland.palmerminto.com/wp-content/uploads/2018/03/Producer-Directory-Carousel-Images_5.jpg" alt="fish" style="width:100%; height: 400px;">
      </div>

            <div class="item">
        <img src="http://seafood-scotland.palmerminto.com/wp-content/uploads/2018/03/Producer-Directory-Carousel-Images_6.jpg" alt="fish" style="width:100%; height: 400px;">
      </div>
    </div>

  </div>
	

			<!-- article -->
	
    </div>
	</div>
	<div class="container">
	<?php include( get_template_directory() . '/templates/product-directory-boxes.php'); ?>
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

	</div>



<?php get_footer(); ?>
