<?php /* Template Name: calendar template */ ?>
<?php get_header(); ?>
<?php get_seafood_scotland_global_header(get_the_title(), get_field('header_text')); ?>
<div class="container brd-1-db">
		<!-- section -->

		<div class="col-md-12 standard-page">
			<h3 style="margin-top: px;">Find out what seafood events are happening nationally and internationally</h2>

		<?php if (have_posts()): while (have_posts()) : the_post(); ?>
			<!-- article -->
			<article style="margin-top: -20px;" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				
				<?php echo do_shortcode('[wcs-schedule id=3]'); ?>
				
				
			</article>
			<div class="row">

				<div class=" col-lg-4 col-md-4 col-sm-8 col-xs-12 box seablue">
					<div  class="col-md-12 col-xs-12 col-lg-12 col-sm-12">
						<div id="calendar"  class="offset"><h2>Contact the team</h2>
							<div>
								<div class="simple-content">
									<p>If you have an event you would like to be featured on this calendar, please contact the team.</p>
								</div>
								<div style="margin-top: -10px;" class="row contact-header">
									<div style="margin-right: 20px;" class="pull-right">
										<img src="/wp-content/themes/seafood-scotland/img/phone-icon.png"> <h3 class="number">+44 (0)131 557 9344</h3><br><br>
										<img src="/wp-content/themes/seafood-scotland/img/mail-icon.png"><a href="mailto:enquiries@seafoodscotland.org" target="_top"> enquiries@seafoodscotland.org</a>
									</div>
								</div>
							</div><br style="clear:both">
						</div>				
					</div>
				</div>

				<div id="events" class=" col-lg-8 col-md-8 col-sm-12 col-xs-12 red">
					<h3><img src="http://seafood-scotland.palmerminto.com/wp-content/uploads/2017/12/latest-events-icon.png">Upcoming Events</h3>
					<div class="row">
						<div class="hidden-xl-down">
							<a href="http://seafood-scotland.palmerminto.com/?p=38"><img class="feature-image" src="http://seafood-scotland.palmerminto.com/wp-content/uploads/2017/12/Feroxcharr1.jpg" width="360" height="150"></a>
							<div class="module-title">
								<a href="http://seafood-scotland.palmerminto.com/event/seafood-for-scotland-launch/">Fish! Fish! Fish!</a>
							</div>
							<span class="date">December, 29 2017</span>
							<p>Curabitur eu mi accumsan, lobortis ex vel, faucibus tortor. Duis nec iaculis elit. Cras sed vestibulum ligula. Praesent sagittis volutpat quam ac ullamcorper. Mauris eu tortor tellus. In…</p>
							<a class="btn btn-primary pull-right" href="http://seafood-scotland.palmerminto.com/event/seafood-for-scotland-launch/">Read more <span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span></a>
						</div>
						<div class="col-md-12">
							<table id="event_list" class="table articles ">
								<thead>
									<tr>
										<th>Item date</th>
										<th>Latest events</th>
									</tr>
								</thead>
								<tbody>
									<?php $posts = get_posts(array('post_type'=> 'upcoming_event','posts_per_page'	=> 10,'order'=> 'ASC')); 
									if( $posts ):
										foreach( $posts as $post ):
											setup_postdata( $post )
											?>
									<tr>
										<td class="title"><?php echo the_field('date'); ?></td>
										<td class="item"><a href="<?php echo the_field('event_link'); ?>" alt="Fish! Fish! Fish!" target="_blank"><?php the_title(); ?></a></td>
									</tr>
								<?php endforeach; ?>
								<?php wp_reset_postdata(); ?>
							<?php endif; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

			<br><br>
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

	</div>


<?php get_footer(); ?>
