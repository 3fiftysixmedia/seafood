<?php /* Template Name: Full Width Feature template */ ?>

<?php get_header(); ?>
<div class="container">
  <div class="row titles">
      <div class="col-sm-2 logo">
          <?php echo get_the_logo(); ?>
      </div>
      <div class="col-sm-8">
          <h1><?php echo get_the_title(); ?></h1>
          <?php echo get_field('header_text'); ?>
      </div>
  </div>
</div>
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
        <h3 class="module-title"><?php echo get_field('big_intro_right'); ?></h3>
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

<?php
$big_image = get_field('big_image');
if( $big_image ):
  if ($big_image['image'] != null) {
    if ($big_image['type'] == 'promo')  {?>
    <div class="bg-box" style="background-image:url('<?php echo $big_image['image']; ?>')">
        <div class="content <?php echo get_field('main_image_support_color'); ?>">
          <div class="row">
            <div class="col-md-10">
              <h2><?php echo  $big_image['title']; ?></h2>
              <?php  if ($big_image['text'] != null) { ?>
                <p><?php echo  $big_image['text']; ?></p>
              <?php }; ?>
            </div>
            <?php  if ($big_image['link_text'] != null) { ?>
              <div class="col-md-2">
                <a href="<?php echo $big_image['url']; ?>" class="btn"><?php echo $big_image['link_text']; ?> <span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span></a>
              </div>
            <?php }; ?>
          </div>
        </div>
    </div>
  <?php } elseif ($big_image['type'] == 'background')  {?>
    <div class="bg-box" style="background-image:url('<?php echo $big_image['image']; ?>')">
      <div class="col-md-6">
        <p class="bg-text"><?php echo  $big_image['text']; ?></p>
      </div>
    </div>
  <?php }; ?>
<?php }; ?>
<?php endif; ?>

<?php if (get_field('switch_on_news') == true) { ?>
  <div class="row boxes brd-1-db">
  <?php
  $args = array( 'numberposts' => '3' );
  $recent_posts = wp_get_recent_posts( $args );
  foreach( $recent_posts as $recent ):
    $randomcolour = array("red", "seablue", "silver", "gold", "seablue", "purple");
    $rand_colours = array_rand($randomcolour, 2);
  ?>
      <div class="col-sm-4 box  <?php echo $randomcolour[$rand_colours[0]] . "\n"; ?>">
        <img class="feature-image" src="\wp-content\uploads\2017\10\350x150.png" width="360" />
        <div class="module-title">
          <a href=""><?php echo wp_trim_words( $recent['post_title'], $num_words = 6, $more = null ); ?></a>
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
        <div class="col-sm-4 box <?php echo $block_1['colour']; ?>">
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

                $args = array( 'numberposts' => $number_of_articles, 'offset' => $offset_articles, );
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
        <div class="<?php if (get_field('block_3_required') == true) {echo "col-md-4";} else {echo "col-md-8";} ; ?> box <?php echo $block_2['colour']; ?>">
            <h3 <?php if ($block_2['type'] == 'simple') {?>class="simple"<?php }; ?>><?php if ($block_2['type'] != 'simple') {?><img src="<?php echo $block_2['icon']; ?>"/><?php }; echo $block_2['title']; ?></h3>
            <?php if ($block_2['type'] == 'events') { ?>
            <div class="row">
              <div class="<?php if (get_field('block_3_required') == true) {echo "hidden-xl-down";} else {echo "col-md-6";} ; ?>">
                <img class="feature-image" src="\wp-content\uploads\2017\10\350x150.png" width="360" />
                <div class="module-title">
                  <a href="">Events with Schoolchildren</a>
                </div>
                <span class="date">October, XX 2017</span>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin placerat quam ac mauris sagittis sollicitudin a sed tortor. Nullam condimentum semper purus, eu hendrerit eros mollis quis. Aliquam est lectus, consequat sed arcu ut, suscipit faucibus ex.</p>
                <a class="btn btn-primary pull-right"  href="<?php echo $key="events-url"; echo get_post_meta($post->ID, $key, true); ?>">Read more <span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></a>
              </div>
              <div class="<?php if (get_field('block_3_required') == true) {echo "col-md-12";} else {echo "col-md-6";} ; ?>">
                <table class="table articles ">
                  <thead>
                    <tr>
                      <th>Item date</th>
                      <th>Latest events</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                        <td class="title">01.01.2017s</td>
                        <td class="item"d>Lorem ipsum dolor sit amet, consectetur adipisicing elit</td>
                    </tr>
                    <tr>
                        <td class="title">01.01.2017</td>
                        <td class="item">Lorem ipsum dolor sit amet, consectetur adipisicing elit</td>
                    </tr>
                    <tr>
                        <td class="title">01.01.2017</td>
                        <td class="item">Lorem ipsum dolor sit amet, consectetur adipisicing elit</td>
                    </tr>
                    <tr>
                        <td class="title">01.01.2017</td>
                        <td class="item">Lorem ipsum dolor sit amet, consectetur adipisicing elit</td>
                    </tr>
                  </tbody>
                </table>
                <a class="btn btn-primary pull-right"  href="<?php echo $block_2['url'] ?>"><?php echo $block_2['link_text']; ?> <span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></a>
              </div>
            </div>
          <?php } else
                { ?>
                  <div>
                    <div class="simple-content">
                      <?php echo $block_2['content']; ?>
                    </div>
                    <?php  if ($block_2['link_text'] != null) { ?>
                      <a href="<?php echo $block_2['url']; ?>" class="btn btn-primary pull-right"><?php echo $block_2['link_text']; ?><span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span></a>
                    <?php }; ?>
                  </div>
          <?php }; ?>
        </div>
    <?php endif; ?>

        <?php
        $block_3 = get_field('block_3');
        if( $block_3 ):
           if (get_field('block_3_required') == true) { ?>
                <div class="col-sm-4 box <?php echo $block_3['block_3_colour'] ?>">

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
                <?php }; ?>
                </div>
            <?php }; ?>
        <?php endif; ?>
    </div><!-- /.row -->
</div>
</div><!-- /.container -->



</body>
<?php get_footer(); ?>
</html>
