
<?php

$categories = get_terms(ATBDP_CATEGORY, array('hide_empty' => 0));
$locations = get_terms(ATBDP_LOCATION, array('hide_empty' => 0));
$type = get_terms(ATBDP_TYPE, array('hide_empty' => 0));

// get bg image if our directorist theme is active else, use the default bg.
// get search page title and sub title from the plugin settings page
$search_title = atbdp_get_option('search_title', 'atbdp_general', '');
$search_subtitle = atbdp_get_option('search_subtitle', 'atbdp_general', '');
$search_placeholder = atbdp_get_option('search_placeholder', 'atbdp_general', __('What are you looking for?', ATBDP_TEXTDOMAIN));

$show_popular_category = atbdp_get_option('show_popular_category', 'atbdp_general', 'yes');

$popular_cat_title = atbdp_get_option('popular_cat_title', 'atbdp_general', __('Browse by popular categories', ATBDP_TEXTDOMAIN));
$popular_cat_num = atbdp_get_option('popular_cat_num', 'atbdp_general', 10);

?>
<!-- start search section -->
<section class="directory_search_area single_area"  >
    <!-- start search area container -->
    <div class="<?php echo is_directoria_active() ? 'container': ' container-fluid'; ?>">

        <div class="row">
            <!-- start col-md-12 -->
            <div>
                <!-- start directory_main_area -->
                <div class="directory_main_content_area">
                    <!-- start search area -->
                    <div class="search_area">


                        <div class="search_form_wrapper">
                            <form action="<?php echo home_url();?>" method="get">

                                <div class="single_search_field  search_category">
                                    <select name="<?= ATBDP_CATEGORY ?>" class="directory_field" id="at_biz_dir-category">
                                        <option value=""><?php _e('Species', ATBDP_TEXTDOMAIN); ?></option>

                                        <?php
                                        foreach ($categories as $category) {
                                            echo "<option id='atbdp_category' value='$category->slug'>$category->name</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="single_search_field  search_type">
                                    <select name="<?= ATBDP_TYPE ?>" class="directory_field" id="at_biz_dir-type">
                                        <option value=""><?php _e('Product Type', ATBDP_TEXTDOMAIN); ?></option>

                                        <?php
                                        foreach ($type as $types) {
                                            echo "<option id='atbdp_type' value='$types->slug'>$types->name</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="single_search_field search_location">
                                    <select name="<?= ATBDP_LOCATION ?>" class="directory_field" id="at_biz_dir-location">
                                        <!--This text comes from js, translate them later @todo; translate js text-->
                                        <option value=""><?php _e('Region', ATBDP_TEXTDOMAIN); ?></option>

                                        <?php foreach ($locations as $location) {
                                            echo "<option id='atbdp_location' value='$location->slug'>$location->name</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                    <div class="single_search_field search_query">
                                        <input type="text" name="s" placeholder="Search term">
                                    </div>

                                <!--Hidden input fields for our custom post-->
                                <input type="hidden" name="post_type" value="<?= ATBDP_POST_TYPE; ?>">
                                <div class="single_search_field submit_btn">
                                  <button type="submit" style="border: 0; background: transparent">
                                    <img src="/wp-content/uploads/2017/12/directory-search.png" height="48" alt="Search" />
                                  </button>
                                  <button style="display:none" type="submit">Search</button>
                                </div>
                            </form>
                        </div><!-- end /.search_form_wrapper-->
                    </div><!-- end search area -->


                    <?php if ('yes'== $show_popular_category){ ?>
                    <div class="directory_home_category_area">

                        <span><?php _e('Or', ATBDP_TEXTDOMAIN); ?></span>
                        <p><?php echo esc_html($popular_cat_title); ?></p>

                        <?php

                        $args = array(
                            'type' => ATBDP_POST_TYPE,
                            'parent' => 0,          // Gets only top level categories
                            'orderby' => 'count',   // Orders the list by post count
                            'order' => 'desc',
                            'hide_empty' => 1,      // Hides categories with no posts
                            'number' => (int) $popular_cat_num,         // No of categories to return
                            'taxonomy' => ATBDP_CATEGORY
                        );
                        $top_categories = get_categories( $args );

                       ?>

                        <ul class="categories">
                            <?php
                            foreach ( $top_categories as $c ) { ?>
                                <li>
                                    <a href="<?= get_home_url('', '/'); ?>?s=&at_biz_dir-category=<?=  $c->name; ?>&post_type=at_biz_dir">
                                        <span class="fa <?= get_cat_icon($c->term_id); ?>" aria-hidden="true"></span>
                                        <p><?= $c->name; ?></p>
                                    </a>
                                </li>

                            <?php }
                            ?>

                        </ul>
                    </div><!-- End category area -->
                    <?php } ?>



                </div><!-- end directory_main_area -->
            </div><!--- end col-md-12  -->
        </div>
    </div><!-- end search area container -->
</section>
<!-- end search section -->
