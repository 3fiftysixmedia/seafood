<?php
/**
 * Template Name: Custom search result
 **/
get_header();
?>
<?php get_seafood_scotland_global_header('Product Directory', get_field('header_text')); ?>

<?php
$ATBDP = ATBDP();
global $query_string;
global $wp_query;

$query_args = explode("&", $query_string);
$search_query = array();

if( strlen($query_string) > 0 ) {
    foreach($query_args as $key => $string) {
        $query_split = explode("=", $string);
        $search_query[$query_split[0]] = urldecode($query_split[1]);
    } // foreach
} //if
/*
 * NOTES: if user provide any invalid term of a taxonomy then the WordPress will generate notice about accessing the property of non object.
 * Because the taxonomy must exist and should have terms no matter it has posts or items attached to that
 * for example. Location Taxonomy May have Term Like Sylhet. and Sylhet may or may not have any posts attached to it
 *
 *
 *
 * */
$search = new WP_Query($search_query);


//for pagination
if ( get_query_var('paged') ) {
    $paged = get_query_var('paged');
} elseif ( get_query_var('page') ) {
    $paged = get_query_var('page');
} else {
    $paged = 1;
}
$in_cat = get_query_var(ATBDP_CATEGORY) ? get_query_var(ATBDP_CATEGORY) : '';
$in_loc = get_query_var(ATBDP_LOCATION) ? get_query_var(ATBDP_LOCATION) : '';
$in_type = get_query_var(ATBDP_TYPE) ? get_query_var(ATBDP_TYPE) : '';

$s_string = get_search_query(false) ? get_search_query() : '';
?>


    <section class="directory_wrapper single_area ">

        <div class="container brd-1-db">
            <div class="row" data-uk-grid>


                <?php if ( have_posts() ) {
                    while ( have_posts() ) { the_post(); ?>
                        <?php
                        /*RATING RELATED STUFF STARTS*/

                        /*RATING RELATED STUFF ENDS*/
                        $info = $ATBDP->metabox->get_listing_info(get_the_ID()); // get all post meta and extract it.
                        extract($info);
                        // get only one parent or high level term object
                        $single_parent = $ATBDP->taxonomy->get_one_high_level_term(get_the_ID(), ATBDP_CATEGORY);
                        ?>

                        <div class="col-md-4 col-sm-6">
                            <div class="single_directory_post skyblue">
                                <article>

                                    <div class="article_content">
                                        <div class="title">
                                          <?php the_title('<h3>', '</h3>'); ?>

                                          <div class="result-line">
                                              <?php the_content(); ?>

                                          <?php if (!empty($phone)) { ?>
                                              <p><?= esc_html( $phone[0]); ?></p>
                                          <?php }?>
                                          </div>
                                        </div>

                                        <div class="result-line">
                                          <p class="result-label">Species Category</p>
                                          <p class="result-value">
                                              <?php
                                                  $cats = get_the_terms(get_the_ID(), ATBDP_CATEGORY);
                                                  if (!empty($cats)) {
                                                      foreach ($cats as $cat) {
                                                        echo $cat->name;
                                                        if ($cat !== end($cats)) {
                                                          echo ', ';
                                                        };
                                                       }
                                                     }
                                              ?>
                                            </p>
                                          </div>
                                            <span style="clear:both" />
                                            <div class="result-line">
                                              <p class="result-label">Product Type</p>
                                              <p class="result-value">
                                                <?php
                                                    $type = get_the_terms(get_the_ID(), ATBDP_TYPE);
                                                    if (!empty($type)) {
                                                        foreach ($type as $types) {
                                                          echo $types->name;
                                                          if ($types !== end($type)) {
                                                            echo ', ';
                                                          };
                                                         }
                                                       }
                                                ?>
                                              </p>
                                            </div>
                                            <span style="clear:both" />
                                            <div class="result-line">
                                              <p class="result-label">Area</p>
                                              <p class="result-value">
                                                <?php
                                                    $locations = get_the_terms(get_the_ID(), ATBDP_LOCATION);
                                                    if (!empty($locations)) {
                                                        foreach ($locations as $location) {
                                                          echo $location->name;
                                                          if ($location !== end($locations)) {
                                                            echo ', ';
                                                          };
                                                         }
                                                       }
                                                ?>
                                              </p>
                                          </div>
                                            <span style="clear:both" />
                                            <div class="result-line">
                                            <? if (!empty($excerpt)) {
                                              ?>
                                              <p class="result-label">Accreditations:</p>
                                              <p class="result-value"><?
                                              echo $excerpt;
                                            }   ?></p>
                                          </div>
                                            <span style="clear:both" />

                                        </div>
                                    </div>
                                </article>
                            </div>
                        </div>

                    <?php }
                    } else {?>
                            <p><?php _e('No listing found.', ATBDP_TEXTDOMAIN); ?></p>
                <?php } ?>



            </div> <!--ends .row -->

            <div class="row">
                <div class="col-md-12">
                    <?php
                    the_posts_pagination(
                            array('mid_size'  => 2,
                            'prev_text' => '<span class="fa fa-chevron-left"></span>',
                            'next_text' => '<span class="fa fa-chevron-right"></span>',
                        ));
                    ?>
                </div>
            </div>
        </div>
    </section>

<div class="container">
<?php include( get_template_directory() . '/templates/product-directory-boxes.php'); ?>
</div>
<?php get_footer(); ?>
