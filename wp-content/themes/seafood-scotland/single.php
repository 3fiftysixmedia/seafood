<?php get_header(); ?>
<?php $cat = get_the_category(); $cat_name = $cat[0]->cat_name; ?>
<?php get_seafood_scotland_global_header($cat_name); ?>

<div style="padding-top:0 !important" class="container brd-1-db">
	<!-- section -->
	<section>

	<?php if (have_posts()): while (have_posts()) : the_post(); ?>

		<!-- article -->
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			
			<div class="row">
			   <!-- post title -->
			   <div class="col-md-12">
				<h2 style="font-size: 30px;letter-spacing: 1px;padding: 10px;margin-left: -25px;">
					<a style="color:#<?php the_field('colour') ?>" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
				</h2>
				<!-- /post title -->
    			<div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<?php if( get_field('top_image') ): ?>
                   <img style = "width: 1180px;" src="<?php the_field('top_image');  ?>" />
					<?php endif; ?>
					
				<?php $big_image = ( get_field('big_image_1') ) ?>	
				<?php if( !empty ($big_image['image'])): ?>
				<div class="bg-box " style="height:700px;background-image:url('<?php echo $big_image['image']; ?>')">
					<div class="col-md-6 mussel">
						<p class=""><?php echo $big_image['text']; ?></p>
					</div>
     		   </div>
				<?php endif; ?>

                </div>
				<div class="col-md-12">
					<?php if( get_field('text') ): ?>
							<div class="simple-content">
							<?php the_field('text'); ?>
							</div>
					<?php endif; ?>
				</div>
				<div class="col-md-12">
					<div>
						<?php if( get_field('middle_image') ): ?>
					<img style = "width: 1180px;margin-top:10px;" src="<?php the_field('middle_image'); ?>" />
						<?php endif; ?>
					</div>
				</div>
			</div>

  			<div id="" class="row">

			  <?php $single_block = get_field('single_block'); ?>
			  <?php if ( !empty($single_block['content']) ): ?>
			  <div style="margin-top:-20px;" class="col-md-12">
					  <?php echo $single_block['content']; ?>
			  <?php endif; ?>
			  </div>

				<?php $block_1 = get_field('block_1'); ?>
				<?php if ( !empty($block_1['content']) ): ?>
				<div class="col-md-4">
					<div class="simple-content">
						<?php echo $block_1['content']; ?>
					</div>
				<?php endif; ?>
				</div>


				<?php $block_2 = get_field('block_2'); ?>
				<?php if ( !empty($block_2['content']) ): ?>
				<div class="col-md-4">
					<div class="simple-content">
						<?php echo $block_2['content']; ?>
					</div>
				<?php endif; ?>
				</div>

				<?php $block_3 = get_field('block_3'); ?>
				<?php if ( !empty($block_3['block_3_content']) ): ?>
				<div class="col-md-4">
					<div class="simple-content">
						<?php echo $block_3['block_3_content']; ?>
					</div>
				<?php endif; ?>
				</div>

			</div>
		
			<div style="margin: 0 auto;" class="row container">
			<div style="margin-top: 15px;margin-left: -25px;" class=" col-md-12">
					<?php the_content('Read the rest of this entry &raquo;'); ?>
				</div>	
				</div>

		</article>
		<!-- /article -->
	<?php endwhile; ?>

	<?php else: ?>

		<!-- article -->
		<article>

			<h1><?php _e( 'Sorry, nothing to display.', 'html5blank' ); ?></h1>

		</article>
		<!-- /article -->

	<?php endif; ?>

	</section>
	<!-- /section -->
</div>


<?php get_footer(); ?>