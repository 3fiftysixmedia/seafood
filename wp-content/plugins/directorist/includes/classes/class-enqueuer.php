<?php

if (!class_exists('ATBDP_Enqueuer')):
class ATBDP_Enqueuer {
    /**
     * Whether to enable multiple image upload feature on add listing page
     *
     * Default behavior is to not to show multiple image upload feature
     * evaluated to true.
     *
     * @since 1.2.2
     * @access public
     * @var bool
     */
    var $enable_multiple_image = false;

    public function __construct() {
        add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ), 999 );
        // best hook to enqueue scripts for front-end is 'template_redirect'
        // 'Professional WordPress Plugin Development' by Brad Williams
        add_action( 'template_redirect', array( $this, 'front_end_enqueue_scripts' ) );

        $this->enable_multiple_image = is_multiple_images_active();

        // We do not need to call the add_listing_scripts_styles() method on template redirect hook because
        // add_action( 'template_redirect' , array( $this, 'add_listing_scripts_styles' ) );
    }

    public function admin_enqueue_scripts( $page ) {
        global $pagenow, $typenow;

        if ( ATBDP_POST_TYPE == $typenow ) {

            // Styles
      //      wp_register_style( 'atbdp-bootstrap', ATBDP_ADMIN_ASSETS . 'css/bootstrap.min.css', false, ATBDP_VERSION);
            wp_register_style( 'atbdp-font-awesome', ATBDP_ADMIN_ASSETS . 'css/font-awesome.min.css', false, ATBDP_VERSION);



            // Scripts
            wp_register_script( 'atbdp-bootstrap', ATBDP_ADMIN_ASSETS . 'js/bootstrap.min.js', array( 'jquery' ), ATBDP_VERSION, true );
            wp_register_style( 'sweetalertcss', ATBDP_ADMIN_ASSETS.'css/sweetalert.min.css', false, ATBDP_VERSION );
            wp_register_script( 'sweetalert', ATBDP_ADMIN_ASSETS . 'js/sweetalert.min.js', array( 'jquery' ), ATBDP_VERSION, true );

            // get the map api from the user
            $map_api_key = atbdp_get_option('map_api_key','atbdp_general', false); // eg. zaSyBtTwA-Y_X4OMsIsc9WLs7XEqavZ3ocQLQ
            //Google map needs to be enqueued from google server with a valid API key. So, it is not possible to store map js file locally as this file will be unique for all users based on their MAP API key.
            wp_register_script( 'atbdp-google-map', 'https://maps.googleapis.com/maps/api/js?key='.$map_api_key.'&libraries=places', false, ATBDP_VERSION, true );


            wp_register_script( 'select2script', ATBDP_ADMIN_ASSETS . 'js/select2.min.js', array( 'jquery' ), ATBDP_VERSION, true );

            //wp_register_style( 'select2style', ATBDP_ADMIN_ASSETS.'css/select2.min.css', false, ATBDP_VERSION );
            // we need select2 js on taxonomy edit screen to let the use to select the fontsawesome icons ans search the icons easily



            wp_register_script( 'atbdp-admin-script', ATBDP_ADMIN_ASSETS . 'js/main.js', array(
                'jquery',
                'atbdp-bootstrap',
                'atbdp-google-map',
                'wp-color-picker',
                'sweetalert',
            ), ATBDP_VERSION, true );


            /* enqueue all styles*/
            wp_enqueue_style('select2style');
            wp_enqueue_style('atbdp-bootstrap');
            wp_enqueue_style('atbdp-font-awesome');
            wp_enqueue_style('atbdp-admin');
            //wp_enqueue_style('sweetalertcss');

            /* Enqueue all scripts */
            wp_enqueue_script('select2script');
            wp_enqueue_script('atbdp-bootstrap');
            wp_enqueue_script('sweetalert');
            wp_enqueue_script('atbdp-google-map');
            wp_enqueue_script('atbdp-admin-script');




            wp_enqueue_style('wp-color-picker');

            // Internationalization text for javascript file especially add-listing.js
            $i18n_text = array(
                'ask_confirmation' => __('Are you sure', ATBDP_TEXTDOMAIN),
                'ask_conf_sl_lnk_del' => __('Do you really want to remove this Social Link!', ATBDP_TEXTDOMAIN),
                'confirm_delete' => __('Yes, Delete it!', ATBDP_TEXTDOMAIN),
                'deleted' => __('Deleted!', ATBDP_TEXTDOMAIN),
                'location_selection' => __('Select a location', ATBDP_TEXTDOMAIN),
                'category_selection' => __('Select a category', ATBDP_TEXTDOMAIN),
                'type_selection' => __('Select a type', ATBDP_TEXTDOMAIN),
                'tag_selection' => __('Select or insert new tags separated by a comma, or space', ATBDP_TEXTDOMAIN),
                'upload_image' => __('Select or Upload Listing Image', ATBDP_TEXTDOMAIN),
                'choose_image' => __('Use this Image', ATBDP_TEXTDOMAIN),
            );

            // is MI extension active?
            $active_mi_extension = atbdp_get_option('enable_multiple_image', 'atbdp_multiple_image', 'no'); // yes or no


            $data = array(
                'nonce'             => wp_create_nonce('atbdp_nonce_action_js'),
                'ajaxurl'           => admin_url('admin-ajax.php'),
                'nonceName'         => 'atbdp_nonce_js',
                'AdminAssetPath'    => ATBDP_ADMIN_ASSETS,
                'i18n_text'        => $i18n_text,
                'active_mi_ext'        => $active_mi_extension, // yes or no
            );
            wp_localize_script( 'atbdp-admin-script', 'atbdp_admin_data', $data );


            wp_enqueue_media();

        }

    }

    /**
     * It loads all scripts for front end if the current post type is our custom post type
     * @param bool $force [optional] whether to load the style in the front end forcibly(even if the post type is not our custom post). It is needed for enqueueing file from a inside the short code call
     */
    public function front_end_enqueue_scripts($force=false) {
        global $typenow, $post;
        // enqueue the style and the scripts on the page when the post type is our registered post type.
        if ( (is_object($post) && ATBDP_POST_TYPE == $post->post_type) || $force) {

            $this->common_scripts_styles();

            wp_register_style( 'sweetalertcss', ATBDP_ADMIN_ASSETS.'css/sweetalert.min.css', false, ATBDP_VERSION );
            wp_register_script( 'sweetalert', ATBDP_ADMIN_ASSETS . 'js/sweetalert.min.js', array( 'jquery' ), ATBDP_VERSION, true );

            wp_enqueue_style('sweetalertcss' );
            wp_enqueue_script('sweetalert' );




            wp_enqueue_script( 'atbdp-public-script', ATBDP_PUBLIC_ASSETS . 'js/main.js', array(
                'jquery',
                'atbdp-google-map',
            ), ATBDP_VERSION, true );


            wp_enqueue_style('wp-color-picker');

            $data = array(
                'nonce'       => wp_create_nonce('atbdp_nonce_action_js'),
                'ajaxurl'       => admin_url('admin-ajax.php'),
                'nonceName'       => 'atbdp_nonce_js',
                'AdminAssetPath'  => ATBDP_ADMIN_ASSETS,
            );
            wp_localize_script( 'atbdp-public-script', 'atbdp_public_data', $data );
            wp_enqueue_media();

        }
    }

    public function common_scripts_styles()
    {
        // Styles
      //  wp_register_style( 'atbdp-bootstrap-style', ATBDP_PUBLIC_ASSETS . 'css/bootstrap.min.css', false, ATBDP_VERSION);
//        wp_register_style( 'atbdp-stars', ATBDP_PUBLIC_ASSETS . 'css/css-stars.css', false, ATBDP_VERSION);
  //      wp_register_style( 'atbdp-font-awesome', ATBDP_PUBLIC_ASSETS . 'css/font-awesome.min.css', false, ATBDP_VERSION);

    //    wp_register_style( 'atbdp-style', ATBDP_PUBLIC_ASSETS . 'css/style.css', array('atbdp-bootstrap-style', 'atbdp-font-awesome'), ATBDP_VERSION);
  //      wp_register_style( 'atbdp-responsive', ATBDP_PUBLIC_ASSETS . 'css/responsive.css', false, ATBDP_VERSION);


        // Scripts
        if ('yes' !== atbdp_get_option('fix_js_conflict', 'atbdp_general')) {
            wp_register_script('atbdp-bootstrap-script', ATBDP_PUBLIC_ASSETS . 'js/bootstrap.min.js', array('jquery'), ATBDP_VERSION, true);
        }

        wp_register_script( 'atbdp-rating', ATBDP_PUBLIC_ASSETS . 'js/jquery.barrating.min.js', array( 'jquery' ), ATBDP_VERSION, true );
        wp_register_script( 'atbdp-uikit', ATBDP_PUBLIC_ASSETS . 'js/uikit.min.js', array( 'jquery' ), ATBDP_VERSION, true );
        wp_register_script( 'atbdp-uikit-grid', ATBDP_PUBLIC_ASSETS . 'js/grid.min.js', array( 'jquery' ), ATBDP_VERSION, true );


        // get the map api from the user
        $map_api_key = atbdp_get_option('map_api_key','atbdp_general'); // eg. zaSyBtTwA-Y_X4OMsIsc9WLs7XEqavZ3ocQLQ
        wp_register_script( 'atbdp-google-map', 'https://maps.googleapis.com/maps/api/js?key='.$map_api_key.'&libraries=places', false, ATBDP_VERSION, true );

        wp_register_script( 'atbdp-all-listing', ATBDP_PUBLIC_ASSETS . 'js/all-listing.js', array(
            'jquery',
            'atbdp-google-map',
        ), ATBDP_VERSION, true );

        wp_register_script( 'atbdp-user-dashboard', ATBDP_PUBLIC_ASSETS . 'js/user-dashboard.js', array( 'jquery' ), ATBDP_VERSION, true );


        wp_register_script( 'select2script', ATBDP_ADMIN_ASSETS . 'js/select2.min.js', array( 'jquery' ), ATBDP_VERSION, true );

        wp_register_style( 'select2style', ATBDP_ADMIN_ASSETS.'css/select2.min.css', false, ATBDP_VERSION );
        // we need select2 js on taxonomy edit screen to let the use to select the fontsawesome icons ans search the icons easily
        wp_enqueue_style('select2style');
        wp_enqueue_script('select2script');

        /* Enqueue all styles*/
        wp_enqueue_style('atbdp-bootstrap-style');
        wp_enqueue_style('atbdp-stars');
        wp_enqueue_style('atbdp-font-awesome');
        wp_enqueue_style('atbdp-style');
        wp_enqueue_style('atbdp-responsive');

        /* Enqueue all scripts */
        wp_enqueue_script('atbdp-bootstrap-script');
        wp_enqueue_script('atbdp-rating');
        wp_enqueue_script('atbdp-google-map');
        wp_enqueue_script('atbdp-all-listing');
        wp_enqueue_script('atbdp-uikit');
        wp_enqueue_script('atbdp-uikit-grid');


        $data = array(
            'nonce'       => wp_create_nonce('atbdp_nonce'),
            'PublicAssetPath'  => ATBDP_PUBLIC_ASSETS,
        );
        wp_enqueue_style('wp-color-picker');
        wp_localize_script( 'atbdp-all-listing', 'atbdp_data', $data );
    }

    public function add_listing_scripts_styles()
    {
        $this->common_scripts_styles();
        wp_register_style( 'sweetalertcss', ATBDP_ADMIN_ASSETS.'css/sweetalert.min.css', false, ATBDP_VERSION );
        wp_register_script( 'sweetalert', ATBDP_ADMIN_ASSETS . 'js/sweetalert.min.js', array( 'jquery' ), ATBDP_VERSION, true );
        wp_enqueue_style('sweetalertcss');
        wp_enqueue_script('atbdp-bootstrap-script');

        wp_register_script('atbdp_add_listing_js', ATBDP_PUBLIC_ASSETS . 'js/add-listing.js', array(
            'jquery',
            'atbdp-rating',
            'atbdp-google-map',
            'sweetalert',
            'jquery-ui-sortable',
            'select2script'
        ), ATBDP_VERSION, true );
        wp_enqueue_script('atbdp_add_listing_js');

        // Internationalization text for javascript file especially add-listing.js
        $i18n_text = array(
            'ask_confirmation' => __('Are you sure', ATBDP_TEXTDOMAIN),
            'ask_conf_sl_lnk_del' => __('Do you really want to remove this Social Link!', ATBDP_TEXTDOMAIN),
            'confirm_delete' => __('Yes, Delete it!', ATBDP_TEXTDOMAIN),
            'deleted' => __('Deleted!', ATBDP_TEXTDOMAIN),
            'location_selection' => __('Select a location', ATBDP_TEXTDOMAIN),
            'category_selection' => __('Select a category', ATBDP_TEXTDOMAIN),
            'type_selection' => __('Select a type', ATBDP_TEXTDOMAIN),
            'tag_selection' => __('Select or insert new tags separated by a comma, or space', ATBDP_TEXTDOMAIN),
            'upload_image' => __('Select or Upload Listing Image', ATBDP_TEXTDOMAIN),
            'choose_image' => __('Use this Image', ATBDP_TEXTDOMAIN),
        );

        // is MI extension active?
        $active_mi_extension = atbdp_get_option('enable_multiple_image', 'atbdp_multiple_image', 'no'); // yes or no

        $data = array(
            'nonce'       => wp_create_nonce('atbdp_nonce_action_js'),
            'ajaxurl'       => admin_url('admin-ajax.php'),
            'nonceName'       => 'atbdp_nonce_js',
            'PublicAssetPath'  => ATBDP_PUBLIC_ASSETS,
            'i18n_text'        => $i18n_text,
            'active_mi_ext'        => $active_mi_extension, // yes or no

        );
        wp_localize_script( 'atbdp_add_listing_js', 'atbdp_add_listing', $data );

        wp_enqueue_media();

    }

    public function user_dashboard_scripts_styles()
    {
        /* Enqueue all styles*/
        wp_enqueue_style('atbdp-bootstrap-style');
        wp_enqueue_style('atbdp-stars');
        wp_enqueue_style('atbdp-font-awesome');
        wp_enqueue_style('atbdp-style');
        wp_enqueue_style('atbdp-responsive');

        /* Enqueue all scripts */
        wp_enqueue_script('atbdp-bootstrap-script');
        wp_enqueue_script('atbdp-rating');
//        wp_enqueue_script('atbdp-google-map');
        wp_enqueue_script('atbdp-user-dashboard');


        $data = array(
            'nonce'       => wp_create_nonce('atbdp_nonce'),
            'PublicAssetPath'  => ATBDP_PUBLIC_ASSETS,
        );
        wp_enqueue_style('wp-color-picker');
        wp_localize_script( 'atbdp-user-dashboard', 'atbdp_data', $data );

    }

    public function search_listing_scripts_styles(){
        wp_enqueue_script( 'atbdp_search_listing', ATBDP_PUBLIC_ASSETS . 'js/search-listing.js', array(
            'jquery',
            'select2script',
        ), ATBDP_VERSION, true );

        /*Internationalization*/
        $data = array(
            'i18n_text'        => array(
                'location_selection' => __('Select a location', ATBDP_TEXTDOMAIN),
                'category_selection' => __('Select a category', ATBDP_TEXTDOMAIN),
                'category_type' => __('Select a type', ATBDP_TEXTDOMAIN),

            )
        );
        wp_localize_script( 'atbdp_search_listing', 'atbdp_search_listing', $data );
    }
}



endif;
