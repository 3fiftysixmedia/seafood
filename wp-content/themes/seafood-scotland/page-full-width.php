<?php /* Template Name: Full width template */ ?>

<?php get_header(); ?>
<?php get_seafood_scotland_global_header(get_the_title(), get_field('header_text')); ?>
<div class="container">

<?php if (get_field('switch_on_about_us') == true) { ?>
  <div class="boxes brd-1-db">
    <h2 class="massive-text silver"><?php echo get_field('big_header'); ?></h2>
    <div class="row">
      <div class="col-md-3 pod">
        <div class="<?php echo get_field('big_intro_left_colour'); ?>">
          <h3><?php echo get_field('big_intro_left'); ?></h3>
        </div>
      </div>
      <div class="col-md-9">
        <h3 class="module-title line"><?php echo get_field('big_intro_right'); ?></h3>
      </div>
    </div>
  </div>
<?php }; ?>

<?php if (get_field('do_you_want_a_basic_page') == true) { ?>
  <div class="boxes brd-1-db">
      <div class="row">
        <div class="col-md-12">
          <?php get_the_content(); ?>
        </div>
    </div>
  </div>
<?php }; ?>



<?php if( have_rows('big_image') ):

  while( have_rows('big_image') ): the_row();
    $numberofslide ++;
  endwhile;
  ?>
  <div class="jcarousel-wrapper">
      <div class="jcarousel">
          <?php if($numberofslide != 1) { echo '<ul>'; };


  while( have_rows('big_image') ): the_row();
		// vars
    $type = get_sub_field('type');
		$image = get_sub_field('image');
    $title = get_sub_field('title');
    $text = get_sub_field('text');
    $link = get_sub_field('link');
    $link_text = get_sub_field('link_text');
    $main_image_support_color = get_sub_field('main_image_support_color');

    if ($type == 'promo')  {?>
      <?php if($numberofslide != 1) { echo '<li>'; };?>
            <div class="bg-box " style="background-image:url('<? echo $image; ?>')">
              <div class="content <? echo $main_image_support_color; ?>">
                <div class="row">
                    <div class="col-md-10 col-sm-12 col-xs-12 col-lg-10">
                      
                      <?php  if ($link != null) { ?>
              <h2><a href="<? echo $link; ?>"><? echo $title.$text; ?></a></h2>
                      <?php } else echo $title.$text; ; ?>
                    </div>
                    <?php  if ($link_text != null) { ?>
                      <div class="col-md-2 col-sm-12 col-xs-12 col-lg-2">
                        <a href="<?php echo $link; ?>" class="btn"><?php echo $link_text; ?> <span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span></a>
                      </div>
                    <?php }; ?>
                </div>
              </div>
            <?php if($numberofslide != 1) { echo '</li>'; };?>


      <?php } elseif ($type == 'background')  {?>
        <div class="bg-box-not" style="background-image:url('<? echo $image; ?>')">
          <div class="col-md-6 col-sm-12 col-xs-12 col-lg-6">
            <p class="bg-text"><?php echo  $text; ?></p>
          </div>
        </div>
      <?php };
endwhile; ?>
<?php if($numberofslide != 1) { echo '</ul>'; };?>
</div>
 <?php if ($numberofslide != 1) {?>
   <p class="jcarousel-pagination">

   </p>
 <?php };?>

</div>
<link rel="stylesheet" type="text/css" href="/wp-content/themes/seafood-scotland/js/lib/jcarousel.basic.css">
<script type="text/javascript" src="/wp-content/themes/seafood-scotland/js/lib/jquery.jcarousel.min.js"></script>
<script type="text/javascript" src="/wp-content/themes/seafood-scotland/js/lib/jcarousel.basic.js"></script>
<?php endif; ?>



<?php if (get_field('switch_on_news') == true) { ?>
  <div class="row boxes brd-1-db">
  <?php


  $args = array( 'numberposts' => '3', 'order'=> 'ASC', 'post_status' => array( 'publish' ) );
  $recent_posts = wp_get_recent_posts( $args );
  foreach( $recent_posts as $recent ):
    $randomcolour = array( "darkblue", "purple");
    $rand_colours = array_rand($randomcolour, 2);
  ?>
      <div class="col-md-6 col-sm-6 col-xs-12 col-lg-4 box  <?php echo $randomcolour[$rand_colours[0]] . "\n"; ?>">
        <a href="<?php echo $recent['guid']; ?>"><img class="feature-image"  width="360" height="150" src="<?php echo get_the_post_thumbnail_url($recent['ID']); ?>"/></a>
        <div class="module-title">
          <a href="<?php echo $recent['guid']; ?>"><?php echo wp_trim_words( $recent['post_title'], $num_words = 6, $more = null ); ?></a>
        </div>
        <span class="date"><?php echo date('F, j Y', strtotime($recent['post_date'])); ?></span>
        <p><?php echo wp_trim_words( $recent['post_content'], $num_words = 28, $more = null ); ?></p>
        <a class="btn btn-primary pull-right"  href="<?php echo $recent['guid']; ?>">Read more <span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></a>
      </div>
  <?php endforeach ?>

</div>
<?php }; ?>

    <div id="latest-block" class="row boxes">

      <?php
      $block_1 = get_field('block_1');
      if( $block_1 ): ?>
        <div class=" col-md-4 col-sm-12 col-xs-12 col-lg-4 box <?php echo $block_1['colour']; ?>">
            <h3 <?php if ($block_1['type'] == 'simple') {?>class="simple"<?php }; ?>><?php if ($block_1['type'] != 'simple') {?><img src="<?php echo $block_1['icon']; ?>"/><?php }; echo $block_1['title']; ?></h3>
            <?php if ($block_1['type'] == 'news') { ?>

            <table class="table articles ">
              <thead>
                <tr>
                  <th>Item date</th>
                  <th>Latest news article</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if (get_field('switch_on_news') == true)  {
                  $number_of_articles = '6';
                  $offset_articles = '3';
                }
                else {
                  $number_of_articles = '4';
                  $offset_articles = 'o';
                };

                $args = array( 'numberposts' => $number_of_articles);
                $recent_posts = wp_get_recent_posts( $args );
                foreach( $recent_posts as $recent ):
                ?>
                    <tr>
                        <td class="title"><?php echo date('d.m.Y', strtotime($recent['post_date'])); ?></td>
                        <td class="item"><a href="<?php echo $recent['guid']; ?>"><?php echo wp_trim_words( $recent['post_title'], $num_words = 12, $more = null ); ?></a></td>
                    </tr>
                <?php endforeach ?>
              </tbody>
            </table>
          <?php } elseif ($block_1['type'] == 'publications') { ?>
            <h4 style="margin-top:20px">Free to Download</h4>
            <table class="table articles ">
              <thead>
                <tr>
                  <th>Item date</th>
                  <th>Latest news article</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $posts = get_posts(array('post_type'=> 'industry_publication','posts_per_page'	=> 10,'order'=> 'DESC'));
                if( $posts ):
                  foreach( $posts as $post ):
                  setup_postdata( $post ) ?>
                      <tr>
                          <td class="title"><?php echo get_the_date( 'd.m.Y' ); ?></td>
                          <td class="item"><a href="<?php echo the_field('uploaded_document'); ?>" alt="<?php the_title(); ?>" target="_blank"><?php the_title(); ?></a></td>
                      </tr>
                  <?php endforeach; ?>
                  <?php wp_reset_postdata(); ?>
                <?php endif; ?>

              </tbody>
            </table>
          <?php } else { ?>
                <div>
                  <div class="simple-content">
                    <?php echo $block_1['content']; ?>
                  </div>

                </div>
        <?php }; ?>



          <?php  if ($block_1['link_text'] != null) { ?>
            <a href="<?php echo $block_1['url']; ?>" class="btn btn-primary pull-right"><?php echo $block_1['link_text']; ?><span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span></a>
          <?php }; ?>
        </div>
    <?php endif; ?>

        <?php
        $block_2 = get_field('block_2');
        if( $block_2 ): ?>
        <div class="<?php if (get_field('block_3_required') == true) {echo "col-md-4 col-sm-12 col-xs-12 col-lg-4";} else {echo "col-md-8 col-sm-12 col-xs-12 col-lg-8";} ; ?> box <?php echo $block_2['colour']; ?>">
            <h3 <?php if ($block_2['type'] == 'simple') {?>class="simple"<?php }; ?>><?php if ($block_2['type'] != 'simple') {?><img src="<?php echo $block_2['icon']; ?>"/><?php }; echo $block_2['title']; ?></h3>
            <?php if ($block_2['type'] == 'events') { ?>
            <div class="row">
              <div class="<?php if (get_field('block_3_required') == true) {echo "hidden-xl-down";} else {echo "col-md-6 col-sm-12 col-xs-12 col-lg-6";} ; ?>">
                  <?php $posts = get_posts(array('post_type'=> 'upcoming_event','posts_per_page'  => 1,'order'=> 'ASC')); 
                if( $posts ):
                  foreach( $posts as $post ):
                  setup_postdata( $post ) ?>
                    <a href="<?php echo $recent['guid']; ?>"><img class="feature-image" src="<?php echo get_the_post_thumbnail_url(); ?>" width="360" height="120" /></a>
                    <div class="module-title">
                      <a href="<?php echo the_field('event_link'); ?>"><?php the_title(); ?></a>
                    </div>
                    <span class="date"><?php echo the_field('date'); ?></span>
                    <p><?php echo wp_trim_words( get_the_content(), $num_words = 128, $more = null ); ?></p>
                    <a class="btn btn-primary pull-right"  href="<?php  echo the_field('event_link');  ?>">Read more <span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></a>
                  <?php endforeach; ?>
                  <?php wp_reset_postdata(); ?>
                <?php endif; ?>
              </div>
              <div class="<?php if (get_field('block_3_required') == true) {echo "col-md-12 col-sm-12 col-xs-12 col-lg-12";} else {echo "col-md-6 col-sm-12 col-xs-12 col-lg-6";} ; ?>">
                <?php if (get_field('block_3_required') == true) {
                  $event_offset = 0;
                  $event_number = 4;
                } else {
                  $event_offset = 1;
                  $event_number = 5;

                  if (!empty($block_2['events_calendar_image'])) { ?>
                    <a href="/events/list/"><img src="<?php echo $block_2['events_calendar_image']; ?>" width="360" height="75"/></a><?php
                  };

                } ?>
                  <?php if(is_page(6)): ?>
                  <div style="background-color: #c45141;">
                    <h4 style="color:white; padding: 10px 10px 0px 10px;"> Events Calendar <img class="pull-right" style="margin: -2px 0px 0px 0px;" src="http://seafood-scotland.palmerminto.com/wp-content/uploads/2018/03/Calendar-Icon_White.png" height="30" width="30"></h4>
                      <div style="border: 2px solid #c45141; padding: 0px; color: #c45141;" class="well"> 
                        <a href="http://seafood-scotland.palmerminto.com/780-2/"><h4 style="padding: 0px 10px 0px 10px;">Click through for at a glance planning of our upcoming events...</h4></a>
                      </div>
                  </div>
                <?php endif ?>


                <table class="table articles ">
                  <thead>
                    <tr>
                      <th>Item date</th>
                      <th>Latest events</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $posts = get_posts(array('post_type'=> 'upcoming_event','posts_per_page'	=> 5,'order'=> 'ASC',));
                    if( $posts ):
                      foreach( $posts as $post ):
                      setup_postdata( $post ) ?>
                          <tr>
                            <td class="title"><?php echo the_field('date'); ?></td>
                            <td class="item"><a href="<?php  echo the_field('event_link'); ?>" alt="<?php the_title(); ?>" target="_blank"><?php the_title(); ?></a></td>
                          </tr>
                      <?php endforeach; ?>
                      <?php wp_reset_postdata(); ?>
                    <?php endif; ?>
                  </tbody>
                </table>
              </div>
            </div>
          <?php } else
                { ?>
                  <div>
                    <div class="simple-content">
                      <?php echo $block_2['content']; ?>
                    </div>
                    <?php  if ($block_2['link_text'] != null) { ?>
                      <a target="_blank" href="<?php echo $block_2['url']; ?>" class="btn btn-primary pull-right"><?php echo $block_2['link_text']; ?><span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span></a>
                    <?php }; ?>
                  </div>
          <?php }; ?>
        </div>
    <?php endif; ?>

        <?php
        $block_3 = get_field('block_3');
        if( $block_3 ):
           if (get_field('block_3_required') == true) { ?>
                <div class="col-md-4 col-sm-12 col-xs-12 col-lg-4 box <?php echo $block_3['block_3_colour'] ?>">
                <div class="col-md-12">
                <div class="offset">
                    <?php if ($block_3['block_3_title'] != null) { ?><h3><img src="<?php echo $block_3['block_3_icon']; ?>"/><?php echo $block_3['block_3_title']; ?></h3><?php };?>
                    <?php if ($block_3['block_3_type'] == 'useful_link') { ?>
                      <?php include( get_template_directory() . '/templates/boxes-useful-links.php'); ?>
                    <?php } else { ?>
                   
                   
                    <div>
                      <div class="simple-content">
                        <?php echo $block_3['block_3_content']; ?>
                      </div>
                      <?php  if ($block_3['block_3_link_text'] != null) { ?>
                      <a href="<?php echo $block_3['block_3_url']; ?>" class="btn btn-primary pull-right"><?php echo $block_3['block_3_link_text']; ?><span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span></a>
                      <?php }; ?>
                    </div>
                    <br style="clear:both">
                    </div>
                <?php }; ?>
               
                </div>
                </div>
            <?php }; ?>
        <?php endif; ?>
    </div><!-- /.row -->
</div>
</div><!-- /.container -->



</body>
<?php get_footer(); ?>
</html>
