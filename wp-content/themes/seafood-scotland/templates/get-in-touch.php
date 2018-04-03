<?php /* Template Name: Get in touch template */ ?>
<?php get_header(); ?>
<?php get_seafood_scotland_global_header(get_the_title(), get_field('header_text')); ?>
<script defer src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>
<div class="container brd-1-db">
	<!-- section -->
	<div class="row">
		<div class="col-lg-12">
			<div class="col-lg-8">

				<?php if (have_posts()): while (have_posts()) : the_post(); ?>
					<?php if( have_rows('people') ): ?>
						<?php

						while( have_rows('people') ): the_row();
							$name = get_sub_field('name');
							$title = get_sub_field('title');
							$bio = get_sub_field('bio');
							$image = get_sub_field('image');
							$colour = get_sub_field('colour');
							$office_number = get_sub_field('office_number');
							$mobile_number = get_sub_field('mobile_number');
							$email_address = get_sub_field('email_address');
							?>

							<div style="margin-top:20px;" class="col-lg-4 col-md-4 col-sm-4 col-xs-6">
								<div style="background:<?php echo $colour; ?>" class="hovereffect">
									<img class="img-responsive" src="<?php echo $image ?>" alt="">
									<div class="overlay">
										<a href="mailto:<?php echo $email_address ?>"><p style="margin-top: 200px;" class="align-bottom">
											Contact <?php $first = explode(" ", $name); echo $first[0]; ?> here
											<i style=" margin-left: 10px; font-size:20px;" class=" far fa-envelope"></i>
										</p></a>
									</div>
								</div>
									<p> <strong style="color: black;font: arial;"><?php echo $name ?></strong>
										<br>
										<sup style="color: black;">
											<?php echo $title ?>
											<br>
											<sup style=" color: black; font-size: 11px;">
											<?php if ($name == "Clare MacDougall") 
											echo "North America & UK";
											?>
											</sup>
											<sup style="font-size: 11px;">
											<?php if ($name == "Natalie Bell") 
											echo "Asia, Middle East & Europe";
											?>
											</sup>
										</sup>
										<br>
									</p>
								</div>
	

							<?php endwhile; ?>
						<?php endif; ?>

					<div id="board_members" style="margin-top: 40px;" class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
						<h3>Board Members</h3>				
						<div class="" style="padding:2px;">
							<div class="board_members">
								<?php the_content(); ?>
									
								</div>
							</div>
						</div>	
					</div>

					<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
						<?php $git_block_1 = get_field('git_block_1');
						if( $git_block_1 ): ?>
						<div id="first"  class="col-md-12  box red">
							<div style="  height: 630px !important;" class="offset">
								<h3><img src="<?php echo $git_block_1['icon']; ?>"/><?php echo $git_block_1['title']; ?></h3>
								<div>
									<div  class="simple-content">
										<?php echo $git_block_1['content']; ?>
										<iframe  src="<?php echo $git_block_1['google_map']; ?>" width="100%" height="400" frameborder="0" style="border:0" allowfullscreen></iframe>
									</div>
								</div>
							</div>
						</div>
					<?php endif; ?>
				</div>

				<?php
				$git_block_2 = get_field('git_block_2');
				if( $git_block_2 ): ?>
				<div  class="col-lg-4 col-md-12 col-sm-12 col-xs-12 box seablue">
					<div class="col-md-12" style="">
						<div style="margin-top: 90px;" class="offset">
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
		</div>
	</div>
</div>
</div>
</div>


		<?php endwhile; ?>
		<?php endif; ?>

		<br>
		<br>


<?php get_footer(); ?>
