<?php

get_header();





//for pagination
if ( get_query_var('paged') ) {
    $paged = get_query_var('paged');
} elseif ( get_query_var('page') ) {
    $paged = get_query_var('page');
} else {
    $paged = 1;
}

$args = array(
        'post_type'=> ATBDP_POST_TYPE,
        'posts_per_page' => 6,
        'paged' => $paged
);

$all_listings = new WP_Query($args);
$all_listing_title = atbdp_get_option('all_listing_title', 'atbdp_general', __('All Items', ATBDP_TEXTDOMAIN));
?>


    <section class="directory_wrapper single_area">
        <div class="header_bar">
            <div class="<?php echo is_directoria_active() ? 'container': 'container-fluid'; ?>">
                <div class="row">
                    <div class="col-md-12">


                        <div class="header_form_wrapper">
                            <div class="directory_title">
                                <h3>
                                    <?php echo esc_html($all_listing_title); ?>
                                </h3>
                                <p><?php _e('Total Results Found: ', ATBDP_TEXTDOMAIN); echo $all_listings->found_posts; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="<?php echo is_directoria_active() ? 'container': 'container-fluid'; ?>">
            <div class="row" data-uk-grid>


                <?php if ( $all_listings->have_posts() ) {
                    while ( $all_listings->have_posts() ) { $all_listings->the_post(); ?>
                        <?php
                        /*RATING RELATED STUFF STARTS*/
                        $reviews = ATBDP()->review->db->count(array('post_id' => get_the_ID()));
                        $average = ATBDP()->review->get_average(get_the_ID());

                        /*RATING RELATED STUFF ENDS*/
                        $info = ATBDP()->metabox->get_listing_info(get_the_ID()); // get all post meta and extract it.
                        extract($info);
                        // get only one parent or high level term object
                        $single_parent = ATBDP()->taxonomy->get_one_high_level_term(get_the_ID(), ATBDP_CATEGORY);
                        ?>

                        <div class="col-md-4 col-sm-6">
                            <div class="single_direcotry_post">
                                <article>
                                    <figure>
                                        <div class="post_img_wrapper">
                                            <?= (!empty($attachment_id[0])) ? '<img src="'.esc_url(wp_get_attachment_image_url($attachment_id[0],  array(432,400))).'" alt="listing image">' : '' ?>
                                        </div>

                                        <figcaption>
                                            <p><?= !empty($excerpt) ? esc_html(stripslashes($excerpt)) : ''; ?></p>
                                        </figcaption>
                                    </figure>

                                    <div class="article_content">
                                        <div class="content_upper">
                                            <h4 class="post_title">
                                                <a href="<?= esc_url(get_post_permalink(get_the_ID())); ?>"><?php echo esc_html(stripslashes(get_the_title())); ?></a>
                                            </h4>
                                            <p><?= (!empty($tagline)) ? esc_html(stripslashes($tagline)) : ''; ?></p>
                                            <?php

                                            /**
                                             * Fires after the title and sub title of the listing is rendered on the single listing page
                                             *
                                             *
                                             * @since 1.0.0
                                             */

                                            do_action('atbdp_after_listing_tagline');

                                            ?>

                                        </div>

                                        <div class="general_info">
                                            <ul>
                                                <!--Category Icons should be replaced later -->
                                                <li>
                                                    <p class="info_title"><?php echo __('Category:', ATBDP_TEXTDOMAIN);?></p>
                                                    <p class="directory_tag">

                                                        <span> <?php if (is_object($single_parent)) { ?>
                                                                <a href="<?= get_home_url('', '/'); ?>?s=&at_biz_dir-category=<?=  $single_parent->name; ?>&post_type=at_biz_dir">
                                                                <?= $single_parent->name; ?>
                                                                </a>
                                                            <?php } else {
                                                               _e('Others', ATBDP_TEXTDOMAIN);
                                                            } ?>
                                                        </span>
                                                    </p>
                                                </li>
                                                <li><p class="info_title"><?php _e('Location:', ATBDP_TEXTDOMAIN);?></p>
                                                    <span><?= !empty($address) ? esc_html(stripslashes($address)) : ''; ?></span>
                                                </li>
                                            </ul>
                                        </div>

                                        <div class="read_more_area">
                                            <a class="btn btn-default" href="<?= get_post_permalink(get_the_ID()); ?>"><?php _e('Read More', ATBDP_TEXTDOMAIN); ?></a>
                                        </div>
                                    </div>
                                </article>
                            </div>
                        </div>

                    <?php }
                    wp_reset_postdata();
                    } else {?>
                            <p><?php _e('No listing found.', ATBDP_TEXTDOMAIN); ?></p>
                <?php } ?>



            </div> <!--ends .row -->

            <div class="row">
                <div class="col-md-12">
                    <?php
                    echo atbdp_pagination($all_listings, $paged);
                    ?>
                </div>
            </div>
        </div>
    </section>
<?php
?>
<?php get_footer(); ?>
