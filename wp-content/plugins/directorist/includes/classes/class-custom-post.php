<?php

if ( ! defined('ABSPATH') ) { die( ATBDP_ALERT_MSG ); }

if(!class_exists('ATBDP_Custom_Post')):

    /**
     * Class ATBDP_Custom_Post
     */
    class ATBDP_Custom_Post {
        public function __construct() {
            // Add the listing post type and taxonomies
            add_action( 'init', array( $this, 'register_new_post_types' ) );



            // add new columns for ATBDP_SHORT_CODE_POST_TYPE
            add_filter('manage_'.ATBDP_POST_TYPE.'_posts_columns', array($this, 'add_new_listing_columns'));
            add_action('manage_'.ATBDP_POST_TYPE.'_posts_custom_column', array($this, 'manage_listing_columns'), 10, 2);
            /*make column sortable*/
            add_filter( 'manage_edit-'.ATBDP_POST_TYPE.'_sortable_columns', array($this, 'make_sortable_column'), 10, 1 );



            add_filter( 'enter_title_here', array($this, 'change_title_text') );

        }




        /**
         * This function will register our custom post(s)
         * Initiate registrations of post types and taxonomies.
         *
         */
        public function register_new_post_types() {
            $this->register_post_type();
        }

        /**
         * Register the custom post type.
         *
         * @link http://codex.wordpress.org/Function_Reference/register_post_type
         */
        protected function register_post_type() {
            // Args for ATBDP_POST_TYPE
            $labels = array(
                'name'                => _x( 'Directory listings', 'Plural Name of Directory listing', ATBDP_TEXTDOMAIN ),
                'singular_name'       => _x( 'Directory listing', 'Singular Name of Directory listing', ATBDP_TEXTDOMAIN ),
                'menu_name'           => __( 'Directory listings', ATBDP_TEXTDOMAIN ),
                'name_admin_bar'      => __( 'Directory listing', ATBDP_TEXTDOMAIN ),
                'parent_item_colon'   => __( 'Parent Directory listing:', ATBDP_TEXTDOMAIN ),
                'all_items'           => __( 'All listings', ATBDP_TEXTDOMAIN ),
                'add_new_item'        => __( 'Add New listing', ATBDP_TEXTDOMAIN ),
                'add_new'             => __( 'Add New listing', ATBDP_TEXTDOMAIN ),
                'new_item'            => __( 'New listing', ATBDP_TEXTDOMAIN ),
                'edit_item'           => __( 'Edit listing', ATBDP_TEXTDOMAIN ),
                'update_item'         => __( 'Update listing', ATBDP_TEXTDOMAIN ),
                'view_item'           => __( 'View listing', ATBDP_TEXTDOMAIN ),
                'search_items'        => __( 'Search listing', ATBDP_TEXTDOMAIN ),
                'not_found'           => __( 'No listings found', ATBDP_TEXTDOMAIN ),
                'not_found_in_trash'  => __( 'Not listings found in Trash', ATBDP_TEXTDOMAIN ),
            );

            $args = array(
                'label'               => __( 'Directory Listing', ATBDP_TEXTDOMAIN ),
                'description'         => __( 'Directory listings', ATBDP_TEXTDOMAIN ),
                'labels'              => $labels,
                'supports'            => array('title', 'editor'),
                'taxonomies'          => array(),
                'hierarchical'        => false,
                'public'              => true,
                'rewrite'			  => array('slug' => ATBDP_POST_TYPE),
                'show_ui'             => true,
                'show_in_menu'        => true,
                'menu_position'       => 20,
                'menu_icon'			=> ATBDP_ADMIN_ASSETS.'images/menu_icon.png',
                'show_in_admin_bar'   => true,
                'show_in_nav_menus'   => true,
                'can_export'          => true,
                'has_archive'         => false,
                'exclude_from_search' => false,
                'publicly_queryable'  => true,
                'capability_type'     => 'post',
            );

            register_post_type( ATBDP_POST_TYPE, $args );
            flush_rewrite_rules();
        }


        public function add_new_listing_columns($columns){
            $columns = array();
            $columns['cb']   = '<input type="checkbox" />';
            $columns['title']   = __('Listing Name', ATBDP_TEXTDOMAIN);
            $columns['atbdp_list_2']   = __('Location', ATBDP_TEXTDOMAIN);
            $columns['atbdp_list_3']   = __('Categories', ATBDP_TEXTDOMAIN);
            $columns['atbdp_list_4']   = __('Type', ATBDP_TEXTDOMAIN);
            $columns['atbdp_list_5']   = __('Author', ATBDP_TEXTDOMAIN);
            $columns['date']   = __('Created at', ATBDP_TEXTDOMAIN);
            return $columns;
        }
        public function manage_listing_columns( $column_name, $post_id ) {
            /*global $ATBDP;
            $g_info = get_post_meta( $post_id, 'general' , true); // return serialized and encoded string of array value
            $general_info = (!empty($g_info) ? unserialize( base64_decode( $g_info )) : array());
            $post_link = admin_url( 'post.php?post='.$post_id.'&action=edit');*/
            /*@TODO; Next time we can add image column too. */
            switch($column_name){
                case 'atbdp_list_1':
                    break;
                case 'atbdp_list_2':
                    $terms = wp_get_post_terms($post_id, ATBDP_LOCATION);
                    if (!empty($terms) && is_array($terms)){
                        foreach ($terms as $term){
                            // link the tax term to the search page with custom query string so that plugin can show correct data from database
                            ?>
                            <a href="<?= get_home_url('', '/'); ?>?s=&at_biz_dir-location=<?=  $term->name; ?>&post_type=at_biz_dir">

                                <p><?= $term->name; ?></p>
                            </a>
                            <?php
                        }
                    }
                    break;
                case 'atbdp_list_3':
                    $cats = wp_get_post_terms($post_id, ATBDP_CATEGORY);
                    if (!empty($cats) && is_array($cats)){
                        foreach ($cats as $c){
                    ?>
                    <a href="<?= get_home_url('', '/'); ?>?s=&at_biz_dir-category=<?=  $c->name; ?>&post_type=at_biz_dir">

                        <p><?= $c->name; ?></p>
                    </a>
                    <?php
                        }
                    }
                    break;
                case 'atbdp_list_4':
                    $type = wp_get_post_terms($post_id, ATBDP_TYPE);
                    if (!empty($type) && is_array($type)){
                        foreach ($type as $types){
                    ?>
                    <a href="<?= get_home_url('', '/'); ?>?s=&at_biz_dir-types=<?=  $types->name; ?>&post_type=at_biz_dir">

                        <p><?= $types->name; ?></p>
                    </a>
                    <?php
                        }
                    }
                    break;

                case 'atbdp_list_5':
                    the_author_posts_link();
                    break;
                default:
                    break;

            }
        }

        public function make_sortable_column( $columns)
        {
            $columns['atbdp_list_4'] = 'author';
            return $columns;

        }




        /**
         * Change the placeholder of title input box
         * @param string $title Name of the Post Type
         *
         * @return string Returns modified title
         */
        public function change_title_text( $title ){
           global $typenow;
            if ( ATBDP_POST_TYPE == $typenow ) {
                $title = 'Enter your listing name';
            }
            return $title;

        }




    }

endif;
