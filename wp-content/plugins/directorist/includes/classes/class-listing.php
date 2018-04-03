<?php
/**
 * ATBDP Listing class
 *
 * This class is for interacting with Listing, eg, searching, displaying etc.
 *
 * @package     ATBDP
 * @subpackage  inlcudes/classes Listing
 * @copyright   Copyright (c) 2017, AazzTech
 * @since       1.0
 */

// Exit if accessed directly
if ( ! defined('ABSPATH') ) { die( 'You should not access this file directly...' ); }

if (!class_exists('ATBDP_Listing')):

class ATBDP_Listing{

    /**
     * ATBDP_Template Object.
     *
     * @var object|ATBDP_Template
     * @since 1.0
     */
    public $template;
    /**
     * ATBDP_Add_Listing Object.
     *
     * @var object|ATBDP_Add_Listing
     * @since 1.0
     */
    public $add_listing;

    /**
     * ATBDP_Add_Listing Object.
     *
     * @var object|ATBDP_Add_Listing
     * @since 1.0
     */
    public $db;

        public function __construct()
        {
            $this->include_files();
            $this->template = new ATBDP_Template;
            $this->add_listing = new ATBDP_Add_Listing;
            $this->db = new ATBDP_Listing_DB;
            // for search functionality
            add_action('pre_get_posts', array($this, 'modify_search_query'), 1, 10);
            // remove adjacent_posts_rel_link_wp_head for accurate post views
            remove_action( 'wp_head',  array($this, 'adjacent_posts_rel_link_wp_head', 10));
            add_action( 'wp_head',  array($this, 'track_post_views'));
        }



        public function modify_search_query(WP_Query $query)
        {
            global $wp_query;
            $post_type = get_query_var('post_type');
            $s = get_query_var('s');
            $post_type = (!empty( $post_type)) ?  $post_type : (!empty($query->post_type) ? $query->post_type : 'any');

            if( $query->is_search() && $post_type == ATBDP_POST_TYPE )
            {
                /*@TODO; make the number of items to show dynamic using setting panel*/
                $srch_p_num = atbdp_get_option('search_posts_num', 'atbdp_general', 6);
               $query->set('posts_per_page', absint($srch_p_num));

            }
            return $query;
        }

        public function include_files()
        {
            load_some_file(array('class-template'), ATBDP_CLASS_DIR);
            load_some_file(array('class-add-listing'), ATBDP_CLASS_DIR);
            load_some_file(array('class-listing-db'), ATBDP_CLASS_DIR);
        }



        public function set_post_views($postID) {
                $count_key = '_atbdp_post_views_count';
                $count = get_post_meta($postID, $count_key, true);
                if('' == $count){
                    delete_post_meta($postID, $count_key);
                    add_post_meta($postID, $count_key, '0');
                }else{
                    $count++;
                    update_post_meta($postID, $count_key, $count);
                }
            }


    /**
     * Track the posts view to show popular posts based on number of views
     * @param $postID
     */
    public function track_post_views ($postID) {
                // vail if user is logged in or if the post is not single.
                if ( !is_single() || is_user_logged_in() ) return;

                if ( empty ( $postID) ) {
                    global $post;
                    $postID = $post->ID;
                }
                $this->set_post_views($postID);
            }
    }

endif;









