<?php
/**
Plugin Name: Directorist - Business Directory Plugin
Plugin URI: https://aazztech.com/product/directorist-business-directory-plugin
Description: Create a professional directory listing website like Yelp by a few clicks only. You can list place, any business etc.  with this plugin very easily.
Version: 2.0.0
Author: AazzTech
Author URI: https://aazztech.com
License: GPLv2 or later
Text Domain: directorist
Domain Path: /languages
*/
/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

Copyright 2017 AazzTech.com.
*/
// prevent direct access to the file
defined( 'ABSPATH' ) || die( 'No direct script access allowed!' );
/**
 * Main Directorist_Base Class.
 *
 * @since 1.0
 */
final class Directorist_Base {
    /** Singleton *************************************************************/

    /**
     * @var Directorist_Base The one true Directorist_Base
     * @since 1.0
     */
    private static $instance;


    /**
     * ATBDP_Metabox Object.
     *
     * @var object|ATBDP_Metabox
     * @since 1.0
     */
    public $metabox;


    /**
     * ATBDP_Custom_Post Object.
     *
     * @var object|ATBDP_Custom_Post
     * @since 1.0
     */
    public $custom_post;

    /**
     * ATBDP_Custom_Taxonomy Object.
     *
     * @var object|ATBDP_Custom_Taxonomy
     * @since 1.0
     */
    public $taxonomy;

    /**
     * ATBDP_Enqueuer Object.
     *
     * @var object|ATBDP_Enqueuer
     * @since 1.0
     */
    public $enquirer;


    /**
     * ATBDP_Ajax_Handler Object.
     *
     * @var object|ATBDP_Ajax_Handler
     * @since 1.0
     */
    public $ajax_handler;

    /**
     * ATBDP_Settings Object.
     *
     * @var object|ATBDP_Settings
     * @since 1.0
     */
    public $settings;

    /**
     * ATBDP_Shortcode Object.
     *
     * @var object|ATBDP_Shortcode
     * @since 1.0
     */
    public $shortcode;

    /**
     * ATBDP_Helper Object.
     *
     * @var object|ATBDP_Helper
     * @since 1.0
     */
    public $helper;


    /**
     * ATBDP_Review_Rating Object.
     *
     * @var object|ATBDP_Review_Rating
     * @since 1.0
     */
    public $review;

    /**
     * ATBDP_Listing Object.
     *
     * @var object|ATBDP_Listing
     * @since 1.0
     */
    public $listing;

    /**
     * ATBDP_User Object.
     *
     * @var object|ATBDP_User
     * @since 1.0
     */
    public $user;

    /**
     * Main Directorist_Base Instance.
     *
     * Insures that only one instance of Directorist_Base exists in memory at any one
     * time. Also prevents needing to define globals all over the place.
     *
     * @since 1.0
     * @static
     * @static_var array $instance
     * @uses Directorist_Base::setup_constants() Setup the constants needed.
     * @uses Directorist_Base::includes() Include the required files.
     * @uses Directorist_Base::load_textdomain() load the language files.
     * @see ATBDP()
     * @return object|Directorist_Base The one true Directorist_Base
     */
    public static function instance() {
        if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Directorist_Base ) ) {
            self::$instance = new Directorist_Base;
            self::$instance->setup_constants();

            add_action( 'plugins_loaded', array( self::$instance, 'load_textdomain' ) );
            add_action( 'widgets_init', array( self::$instance, 'register_widgets' ) );

            self::$instance->includes();
            self::$instance->custom_post = new ATBDP_Custom_Post; // create custom post
            self::$instance->settings       = new ATBDP_Settings(new ATBDP_Settings_API); // create admin panel settings
            self::$instance->taxonomy       = new ATBDP_Custom_Taxonomy;
            self::$instance->enquirer       = new ATBDP_Enqueuer;
            self::$instance->metabox        = new ATBDP_Metabox;
            self::$instance->ajax_handler   = new ATBDP_Ajax_Handler;
            self::$instance->shortcode      = new ATBDP_Shortcode;
            self::$instance->helper         = new ATBDP_Helper;
            self::$instance->listing        = new ATBDP_Listing;
            self::$instance->user           = new ATBDP_User;
            /*Extensions Link*/
            /*initiate extensions link*/
            new ATBDP_Extensions();
            /*Initiate Review and Rating Features*/
            self::$instance->review         = new ATBDP_Review_Rating;
            // display related listings
            add_action('atbdp_after_single_listing', array(self::$instance, 'show_related_listing'));

            //review and rating
            add_action('bdrl_after_listing_tagline', array(self::$instance, 'show_review_after_tagliine')); // show rating after the tagline of related listing
            add_action('atbdp_after_listing_tagline', array(self::$instance, 'show_review_after_tagliine')); // show rating after the tagline of the normal post on single page and also the search result page.
            add_action('atbdp_after_map', array(self::$instance, 'show_review'));



        }

        return self::$instance;
    }

    /**
     * Throw error on object clone.
     *
     * The whole idea of the singleton design pattern is that there is a single
     * object therefore, we don't want the object to be cloned.
     *
     * @since 1.0
     * @access public
     * @return void
     */
    public function __clone() {
        // Cloning instances of the class is forbidden.
        _doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', ATBDP_TEXTDOMAIN ), '1.0' );
    }

    /**
     * Disable unserializing of the class.
     *
     * @since 1.0
     * @access public
     * @return void
     */
    public function __wakeup() {
        // Unserializing instances of the class is forbidden.
        _doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', ATBDP_TEXTDOMAIN ), '1.0' );
    }

    /**
     * It registers widgets and sidebar support
     *
     * @since 1.0
     * @access public
     * @return void
     */
    public function register_widgets()
    {
        if (!is_registered_sidebar('right-sidebar-listing') ) {
            register_sidebar( array(
                'name'          => __( 'Listing Right Sidebar', 'directorist' ),
                'id'            => 'right-sidebar-listing',
                'description'   => __( 'Add widgets for the right sidebar on single listing page', 'directorist' ),
                'before_widget' => '<div class="widget default">',
                'after_widget'  => '</div>',
                'before_title'  => '<div class="widget_title"><h4>',
                'after_title'  => '</h4></div>',

            ) );
        }

        register_widget('BD_Popular_Listing_Widget');

    }

    /**
     * Setup plugin constants.
     *
     * @access private
     * @since 1.0
     * @return void
     */
    private function setup_constants() {
        // test
        require_once plugin_dir_path(__FILE__).'/config.php'; // loads constant from a file so that it can be available on all files.
    }

    /**
     * Include required files.
     *
     * @access private
     * @since 1.0
     * @return void
     */
    private function includes() {
        require_once ATBDP_INC_DIR . 'helper-functions.php';
        require_once ATBDP_INC_DIR . 'login-register.php';
        load_dependencies('all', ATBDP_CLASS_DIR); // load all php files from ATBDP_CLASS_DIR
        load_dependencies('all', ATBDP_LIB_DIR); // load all php files from ATBDP_LIB_DIR
        /*LOAD Rating and Review functionality*/
        load_dependencies('all', ATBDP_INC_DIR . 'review-rating/');
    }

    public function load_textdomain()
    {
        load_plugin_textdomain(ATBDP_TEXTDOMAIN, false, ATBDP_LANG_DIR);
    }


    /**
     * It  loads a template file from the Default template directory.
     * @param string $name Name of the file that should be loaded from the template directory.
     * @param array $args Additional arguments that should be passed to the template file for rendering dynamic  data.
     */
    public function load_template($name, $args = array() ){
        $ATBDP = ATBDP();
        global $post, $ATBDP;
        include(ATBDP_TEMPLATES_DIR.$name.'.php');
    }

    public static function prepare_plugin()
    {
        include ATBDP_INC_DIR.'classes/class-installation.php';
        ATBDP_Installation::install();
    }

    /**
     * It displays popular listings
     * @param int $count Number of popular listing to show.
     * If the count is more than one then it uses it, else the function will use the value from the settings page.
     * Count variable is handy if we want to show different number of popular listings on different pages. For example, on different widgets place
     */
    public function show_popular_listing($count=0)
    {

        $enable_pop_listing = atbdp_get_option('enable_pop_listing', 'atbdp_general', 'yes');
        if ('yes' !== trim($enable_pop_listing) ) return; // vail if popular listing is not enabled
        $popular_listings = $this->get_popular_listings($count);

        if ($popular_listings->have_posts()){ ?>
            <div class="categorized_listings">


                <ul class="listings">
                    <?php foreach ($popular_listings->posts as $pop_post) {

                        /*RATING RELATED STUFF ENDS*/
                        $info = ATBDP()->metabox->get_listing_info($pop_post->ID); // get all post meta and extract it.
                        // get only one parent or high level term object
                        $single_parent = ATBDP()->taxonomy->get_one_high_level_term($pop_post->ID, ATBDP_CATEGORY);

                        ?>
                        <li>
                            <div class="left_img">
                                <?= (!empty($info['attachment_id'][0])) ? '<img src="'.esc_url(wp_get_attachment_image_url($info['attachment_id'][0],  array(90,90))).'" alt="listing image">' : '' ?>
                            </div>
                            <div class="right_content">
                                <div class="cate_title">
                                    <h4><a href="<?= esc_url(get_post_permalink($pop_post->ID)); ?>"><?= esc_html($pop_post->post_title); ?></a></h4>
                                </div>
                                <p class="directory_tag">
                                    <span> <?php if (is_object($single_parent)) { ?>
                                            <a href="<?= esc_url(get_category_link($single_parent->term_id)); ?>"> <?= esc_html($single_parent->name); ?> </a>
                                        <?php } else {
                                            echo esc_html__('Others', ATBDP_TEXTDOMAIN);
                                        } ?>
                                        </span>
                                </p>
                                <!--write code in a way that this extension works regardless of review extension-->
                                <?php
                                    ATBDP()->show_static_rating($pop_post);

                                ?>
                            </div>
                        </li>
                    <?php } ?>

                </ul>
            </div> <!--ends .categorized_listings-->
        <?php }

    }


    /**
     * It gets the popular listings of the given listing/post
     * @param int $count Number of popular listing to show.  If the count is more than one then it uses it, else the function will use the value from the settings page. Count variable is handy if we want to show different number of popular listings on different pages. For example, on different widgets place
     * @return object|WP_Query It returns the popular listings if found.
     */
    private function get_popular_listings($count=0)
    {
        /*Popular post related stuff*/
        $p_count = atbdp_get_option('pop_listing_num', 'atbdp_general', 5);
        // use $count from args if available, else use the count from the database option
        $p_count = !empty($count) ? $count : $p_count;

        /**
         * It filters the number of the popular listing to display
         * @since 1.0.0
         * @param int $p_count The number of popular listing  to show
         */
        $p_count = apply_filters('bdpl_popular_listing_number', $p_count);

        $args = array(
            'post_type'  => ATBDP_POST_TYPE,
            'meta_key'   => '_atbdp_post_views_count',
            'orderby'    => 'meta_value_num',
            'order'      => 'DESC',
            'posts_per_page' => (int) $p_count,
            'meta_query' => array(
                array(
                    'key'     => '_atbdp_post_views_count',
                    'value'   => 0,
                    'compare' => '>',
                ),
            ),
        );
        return new WP_Query( $args );

    }

    /**
     * It displays related listings of the given post
     * @param object|WP_Post $post The current post object
     */
    public function show_related_listing($post)
    {

        $enable_rel_listing = atbdp_get_option('enable_rel_listing', 'atbdp_general', 'yes');
        if ('yes' !== trim($enable_rel_listing) ) return; // vail if related listing is not enabled
        $related_listings = $this->get_related_listings($post);




        if ($related_listings->have_posts()){
            ?>
            <!--Related Listings starts-->
            <div class="related_listings">
                <div class="related_listing_title">
                    <p><?php _e('Related Items', ATBDP_TEXTDOMAIN); ?></p>
                </div>
                <div class="row">
                    <?php foreach ($related_listings->posts as $r_post) {
                        /*RATING RELATED STUFF STARTS*/
                        //$reviews = ATBDP()->review->db->count(array('post_id' => $r_post->ID));
                        //$average = ATBDP()->review->get_average($r_post->ID);

                        /*RATING RELATED STUFF ENDS*/
                        $info = ATBDP()->metabox->get_listing_info($r_post->ID); // get all post meta and extract it.
                        // this will have all vars like attachment etc
                        // get only one parent or high level term object
                        $single_parent = ATBDP()->taxonomy->get_one_high_level_term($r_post->ID, ATBDP_CATEGORY);
                        ?>
                        <div class="col-md-6">
                            <div class="single_direcotry_post">
                                <article>
                                    <figure>
                                        <div class="post_img_wrapper">
                                            <?= (!empty($info['attachment_id'][0])) ? '<img src="'.esc_url(wp_get_attachment_image_url($info['attachment_id'][0],  array(432,400))).'" alt="listing image">' : '' ?>
                                        </div>

                                        <figcaption>
                                            <p><?= !empty($info['excerpt']) ? esc_html(stripslashes($info['excerpt'])) : ''; ?></p>
                                        </figcaption>
                                    </figure>

                                    <div class="article_content">
                                        <div class="content_upper">
                                            <h4 class="post_title">
                                                <a href="<?= esc_url(get_post_permalink($r_post->ID)); ?>"><?php echo esc_html($r_post->post_title); ?></a>
                                            </h4>
                                            <p><?= (!empty($info['tagline'])) ? esc_html(stripslashes($info['tagline'])) : '' ?></p>
                                            <?php
                                            /**
                                             * Fires after the title and sub title of the listing is rendered
                                             *
                                             *
                                             * @since 1.0.0
                                             */

                                            do_action('bdrl_after_listing_tagline');

                                            ?>
                                        </div>

                                        <div class="general_info">
                                            <ul>
                                                <!--Category Icons should be replaced later -->
                                                <li>
                                                    <p class="info_title">Category:</p>
                                                    <p class="directory_tag">
                                                        <span class="fa fa-desktop" area-hidden="true"></span>
                                                        <span> <?php if (is_object($single_parent)) { ?>
                                                                <a href="<?= esc_url(get_category_link($single_parent->term_id)); ?>"> <?= esc_html($single_parent->name); ?> </a>
                                                            <?php } else {
                                                                _e('Others', ATBDP_TEXTDOMAIN);
                                                            } ?>
                                                        </span>
                                                    </p>
                                                </li>
                                                <li><p class="info_title"><?php _e('Location: ', ATBDP_TEXTDOMAIN);?></p>
                                                    <span><?= !empty($info['address']) ? esc_html(stripslashes($info['address'])) : 'unknown'; ?></span>
                                                </li>
                                            </ul>
                                        </div>

                                        <div class="read_more_area">
                                            <a class="btn btn-default " href="<?= get_post_permalink($r_post->ID); ?>">
                                                <?php _e('Read More', ATBDP_TEXTDOMAIN); ?>
                                            </a>
                                        </div>
                                    </div>
                                </article>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div> <!--ends .related_listings-->
        <?php }

    }


    /**
     * It gets the related listings of the given listing/post
     * @param object|WP_Post $post  The WP Post Object of whose related listing we would like to show
     * @return object|WP_Query It returns the related listings if found.
     */
    private function get_related_listings($post)
    {
        $rel_listing_num = atbdp_get_option('rel_listing_num', 'atbdp_general', 2);
        $atbd_cats = get_the_terms($post, ATBDP_CATEGORY);
        $atbd_tags = get_the_terms($post, ATBDP_TAGS);
        // get the tag ids of the listing post type
        $atbd_cats_ids = [];
        $atbd_tags_ids = [];

        if (!empty($atbd_cats)) {
            foreach ($atbd_cats as $atbd_cat) {
                $atbd_cats_ids[]= $atbd_cat->term_id;
            }
        }
        if (!empty($atbd_tags)) {
            foreach ($atbd_tags as $atbd_tag) {
                $atbd_tags_ids[]= $atbd_tag->term_id;
            }
        }
        $args = array(
            'post_type' => ATBDP_POST_TYPE,
            'tax_query' => array(
                'relation' => 'OR',
                array(
                    'taxonomy' => ATBDP_CATEGORY,
                    'field'    => 'term_id',
                    'terms'    => $atbd_cats_ids,
                ),
                array(
                    'taxonomy' => ATBDP_TAGS,
                    'field'    => 'term_id',
                    'terms'    => $atbd_tags_ids,
                ),
            ),
            'posts_per_page' => (int) $rel_listing_num ,
            'post__not_in' => array($post->ID),
        );

        return new WP_Query( $args );

    }

    public function show_review_after_tagliine()
    {
        $enable_review = atbdp_get_option('enable_review', 'atbdp_general', 'yes');
        if ('yes' !== trim($enable_review) ) return; // vail if review is not enabled
        global $post;
        $average =ATBDP()->review->get_average($post->ID);
        $reviews_count =ATBDP()->review->db->count(array('post_id' => $post->ID)); // get total review count for this post

        ?>
        <div class="br-theme-css-stars-static">
            <?= ATBDP()->review->print_static_rating($average); ?>
        </div>
        <div class="directory_review_info"><span class="rating"><?= ( !empty( $average ) ) ? esc_html( round( floatval( $average ), 1 ) ) : '';?></span>
            <span class="rating_num">
                                (<?= (!empty($reviews_count)) ? $reviews_count : 0?>
                <?= ($reviews_count>1) ? __('reviews', ATBDP_TEXTDOMAIN): __('review', ATBDP_TEXTDOMAIN); ?>)
                            </span>
        </div>
        <?php
    }

    /**
     * It displays reviews of the given post
     * @param object|WP_Post $post The current post object
     */
    public function show_review($post)
    {

        $enable_review = atbdp_get_option('enable_review', 'atbdp_general', 'yes');
        if ('yes' !== trim($enable_review) ) return; // vail if review is not enabled

        $reviews = ATBDP()->_get_reviews($post, 3);
        $reviews_count = ATBDP()->review->db->count(array('post_id' => $post->ID)); // get total review count for this post

        ?>

        <!-- Review_area Section-->
        <div class="review_area">
            <?php if (is_user_logged_in()) {
                global $wpdb;
                // if user has a review then fetch it.
                $cur_user_review = ATBDP()->review->db->get_user_review_for_post(get_current_user_id(), get_the_ID());
                ?>
                <div class="review_form">
                    <div class="directory_are_title">
                        <h4><span class="fa fa-star" aria-hidden="true"></span><?= !empty($cur_user_review)? __('Update Review', ATBDP_TEXTDOMAIN) : __('Leave a Review', ATBDP_TEXTDOMAIN);?></h4>
                    </div>

                    <form action="" id="atbdp_review_form" method="post">
                        <?php wp_nonce_field( 'atbdp_review_action_form', 'atbdp_review_nonce_form' ); ?>
                        <input type="hidden" name="post_id" value="<?php the_ID(); ?>">
                        <!--<input type="email" name="email" class="directory_field" placeholder="Your email" required>-->
                        <input type="hidden" name="name" class="directory_field" value="<?= wp_get_current_user()->display_name; ?>" placeholder="Your name" id="reviewer_name">

                        <div class="rating clearfix"> <!--It should be displayed on the left side -->
                            <?php
                            // color the stars if user has rating
                            if (!empty($cur_user_review)){

                                ?>

                                <div class="pull-left">
                                    <p class="rating_label"><?php _e('Current Rating:', ATBDP_TEXTDOMAIN); ?></p>
                                    <div class="br-theme-css-stars-static">
                                        <?= ATBDP()->review->print_static_rating($cur_user_review->rating); ?>
                                    </div>
                                </div>
                            <?php } ?>

                            <div class="pull-right">
                                <p class="rating_label"><?= !empty($cur_user_review)? __('Give New Rating:', ATBDP_TEXTDOMAIN) : __('Your Rating:', ATBDP_TEXTDOMAIN);?></p>
                                <div class="br-theme-css-stars">
                                    <select class="stars" name="rating" id="review_rating">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <textarea name="content" id="review_content" class="directory_field" cols="20" rows="10" placeholder="<?= !empty($cur_user_review)? __('Update your review.....', ATBDP_TEXTDOMAIN): __('Write your review.....', ATBDP_TEXTDOMAIN);?>"><?= !empty($cur_user_review)? $cur_user_review->content:'';?></textarea>
                        <!--If current user has a review then show him update and delete button-->
                        <?php if (!empty($cur_user_review)){ ?>
                            <button class="directory_btn" type="submit" id="atbdp_review_form_submit"><?php _e('Update', ATBDP_TEXTDOMAIN); ?></button> <!-- ends update  button -->
                            <button class="directory_btn" type="button" id="atbdp_review_remove" data-review_id="<?= $cur_user_review->id; ?>"><?php _e('Remove', ATBDP_TEXTDOMAIN); ?></button> <!-- ends delete button -->
                        <?php }else{ ?>
                            <button class="directory_btn" type="submit" id="atbdp_review_form_submit"><?php _e('Submit Review', ATBDP_TEXTDOMAIN); ?></button> <!-- submit button -->
                        <?php } ?>

                    </form>
                </div> <!--ends .review_form-->
            <?php }else{ ?>
                <p class="notice">
                    <span class="fa fa-info" aria-hidden="true"></span>
                    <?php
                    // get the custom registration page id from the db and create a permalink
                    $reg_link_custom = atbdp_get_registration_page_url();
                    //if we have custom registration page, use it, else use the default registration url.
                    $reg_link = !empty($reg_link_custom) ? $reg_link_custom : wp_registration_url();

                    $login_url = '<a href="'. esc_url(wp_login_url()) .'">'. __('Login', ATBDP_TEXTDOMAIN). '</a>';
                    $register_url = '<a href="'.esc_url($reg_link).'">'. __('Register', ATBDP_TEXTDOMAIN). '</a>';

                    printf(__('You need to %s or %s to submit a review', ATBDP_TEXTDOMAIN), $login_url, $register_url );
                    ?>
                </p>

            <?php } ?>




            <div class="client_reviews" id="client_reviews">
                <?php if (!empty($reviews)) {
                    ?>
                    <?php foreach ($reviews as $review) { ?>
                        <div class="single_review" id="single_review_<?= $review->id; ?>">
                            <div class="review_top">
                                <div class="reviewer"><i class="fa fa-user" aria-hidden="true"></i><p><?= esc_html($review->name); ?></p></div>
                                <p class="review_time"><?= date("d/m/Y", strtotime($review->date_created)) ?></p>
                                <div class="br-theme-css-stars-static">
                                    <?= ATBDP()->review->print_static_rating($review->rating); ?>
                                </div>
                            </div>
                            <div class="review_content">
                                <p><?= esc_html($review->content); ?></p>
                            </div>
                        </div>

                    <?php }  } ?>
            </div> <!--ends .client_reviews-->


        </div> <!--end .review_area-->
        <?php

        // if the count of review is more than the number of showing reviews then show the more review button, eg. here we will show the read more button  if the number of the review in the database is more than 3
        if (!empty($reviews_count) && $reviews_count > 3){
            echo "<button class='directory_btn' type='button' id='load_more_review' data-id='{$post->ID}''>".__('View More Review', ATBDP_TEXTDOMAIN)."</button>";
        }
        ?>

        <?php


    }


    /**
     * It gets the reviews of the given listing/post
     * @param object|WP_Post $post  The WP Post Object of whose review we would like to show
     * @param int $review_number  The number of reviews to return, Default 5
     * @return object|WP_Query It returns the reviews if found.
     */
    private function _get_reviews($post, $review_number=5)
    {

        return ATBDP()->review->db->get_reviews_by('post_id', $post->ID, 0,  $review_number); // get the amount of reviews set by $review_number
    }


    /**
     * It displays static rating of the given post
     * @param object|WP_Post $post The current post object
     */
    public function show_static_rating($post)
    {
        $enable_review = atbdp_get_option('enable_review', 'atbdp_general', 'yes');
        if ('yes' !== trim($enable_review) ) return; // vail if review is not enabled
        $average = ATBDP()->review->get_average($post->ID);
        ?>
        <div class="br-theme-css-stars-static">
            <?= ATBDP()->review->print_static_rating($average); ?>
        </div>
        <?php

    }



} // ends Directorist_Base












/**
 * The main function for that returns Directorist_Base
 *
 * The main function responsible for returning the one true Directorist_Base
 * Instance to functions everywhere.
 *
 * Use this function like you would a global variable, except without needing
 * to declare the global.
 *
 * Example: <?php $ATBDP = ATBDP(); ?>
 *
 * @since 1.0
 * @return object|Directorist_Base The one true Directorist_Base Instance.
 */
function ATBDP() {
    return Directorist_Base::instance();
}

// Get ATBDP ( AazzTech Business Directory Plugin) Running.
ATBDP();

register_activation_hook(__FILE__, array('Directorist_Base', 'prepare_plugin'));
