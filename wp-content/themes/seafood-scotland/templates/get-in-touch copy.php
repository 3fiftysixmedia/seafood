<?php /* Template Name: Get in touch template */ ?>
<?php get_header(); ?>
<?php get_seafood_scotland_global_header(get_the_title(), get_field('header_text')); ?>
<div class="container brd-1-db">
		<!-- section -->
		<div class="row">
		<?php if (have_posts()): while (have_posts()) : the_post(); ?>

			<!-- article -->
			<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
			<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
				<script>
				$( function() {
					$( "#tabs" ).tabs();
				} );
				</script>
					<div class="col-md-8">

						<div id="tabs">
							<?php if( have_rows('people') ): ?>
							<ul class="tabs">
								<?php
								$tabnumber = 1;
								while( have_rows('people') ): the_row();

									$name = get_sub_field('name');
									$name_id = get_sub_field('name');

									if ($tabnumber == 1) {
										$is_current = 'current';
									} else {
										$is_current = '';
									};

									echo '<li  class="tab-link"><a href="#tabs-'.$tabnumber.'">'.$name.'</a></li>';
									$tabnumber++;
								 endwhile; ?>
							</ul>
			 			<?php endif; ?>

						<?php if( have_rows('people') ): ?>
							<?php
							$tabnumber = 1;
							while( have_rows('people') ): the_row();

								$name = get_sub_field('name');
								$title = get_sub_field('title');
								$bio = get_sub_field('bio');
								$image = get_sub_field('image');
								$office_number = get_sub_field('office_number');
								$mobile_number = get_sub_field('mobile_number');
								$email_address = get_sub_field('email_address');

								if ($tabnumber == 1) {
									$is_current = 'current';
								} else {
									$is_current = '';
								};

								?>

								<?php echo $name_id ?>

						<div id="tabs-<?php echo $tabnumber ?>" class="tab-content clearfix skyblue <?php echo $is_current ?>">
							<?php if ((!empty($image)) or (!empty($office_number)) or (!empty($mobile_number)) or (!empty($email_address))) { ?>
						<div class="col-md-3">
							<?php if (!empty($image)) {?>
							<img src="$image" height="175" width="135" />
							<?php };
							if (!empty($office_number)) {?><div>
								<p style="font-size:13px; margin:6px 0">Office: <?php echo $office_number ?></p>
							</div><?php };
							if (!empty($mobile_number)) {?>
							<div class="result-line"  style="padding:0">
								<p style="font-size:13px; margin:6px 0">Mobile: <?php echo $mobile_number ?></p>
							</div><?php };
							if (!empty($email_address)) {?>
							<div class="result-line" style="padding:0">
								<p style="margin:6px 0"><a style="font-size:9px" href="mailto:<?php echo $email_address ?>" target="_blank"><?php echo $email_address ?></a></p>
							</div><?php }; ?>
						</div>
					<?php }; ?>
						<div class="col-md-9">
							<h4><?php echo $name; if (!empty($title)) {?>,
							<br/><?php echo $title; ?></h4><?php }; ?>
							<p><?php echo $bio; ?>
						</div>

						</div>
						<?php
						$tabnumber++;
						endwhile; ?>
						<?php endif; ?>

					</div>

</div>
	<?php
	$git_block_1 = get_field('git_block_1');
	if( $git_block_1 ): ?>
					<div class="col-md-4 box red" style="margin-top:20px">
						<div class="offset">
							<h3><img src="<?php echo $git_block_1['icon']; ?>"/><?php echo $git_block_1['title']; ?></h3>
							<div>
								<div class="simple-content">
									<?php echo $git_block_1['content']; ?>
									<iframe src="<?php echo $git_block_1['google_map']; ?>" width="100%" height="150" frameborder="0" style="border:0" allowfullscreen></iframe>

								</div>
							</div>
						</div>
					</div>
	<?php endif; ?>

				<!-- container -->



			</div>
    </div>

		<div class="container" style="margin-top:24px;">
			<div class="row">
			<div class="col-md-8" style="padding:15px;">
				<div class="grey" style="padding:15px;">
					<div class="content">
						<?php the_content(); ?>
					</div>
			</div>
			</div>
			<?php
			$git_block_2 = get_field('git_block_2');
			if( $git_block_2 ): ?>
			<div class="col-md-4 box seablue" style="margin-top:-5px">
				<div class="offset">
					<h3><img src="<?php echo $git_block_2['icon']; ?>"/><?php echo $git_block_2['title']; ?></h3>
					<div>
						<div class="simple-content">
							<?php echo $git_block_2['content']; ?>
						</div>
						<?php  if ($git_block_2['link_title'] != null) { ?>
						<a href="<?php echo $git_block_2['link']; ?>" class="btn btn-primary pull-right"><?php echo $git_block_2['link_title']; ?><span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span></a>
					<?php }; ?>
					</div>
					<br style="clear:both" />
				</div>
			</div>

			<?php endif; ?>
		</div>
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
