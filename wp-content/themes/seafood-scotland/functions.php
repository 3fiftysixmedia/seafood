<?php
/*
 *  Author: Todd Motto | @toddmotto
 *  URL: html5blank.com | @html5blank
 *  Custom functions, support, custom post types and more.
 */

/*------------------------------------*\
	External Modules/Files
\*------------------------------------*/

// Load any external files you have here

/*------------------------------------*\
	Theme Support
\*------------------------------------*/

if (!isset($content_width))
{
    $content_width = 900;
}

function get_the_logo() {
  echo '<a href="/"><img height="75px" src="/wp-content/themes/seafood-scotland/img/logo.png" alt="Seafood Scotland"></a>';
}

if (function_exists('add_theme_support'))
{
    // Add Menu Support
    add_theme_support('menus');

    // Add Thumbnail Theme Support
    add_theme_support('post-thumbnails');
    add_image_size('large', 700, '', true); // Large Thumbnail
    add_image_size('medium', 250, '', true); // Medium Thumbnail
    add_image_size('small', 120, '', true); // Small Thumbnail
    add_image_size('custom-size', 700, 200, true); // Custom Thumbnail Size call using the_post_thumbnail('custom-size');

    // Add Support for Custom Backgrounds - Uncomment below if you're going to use
    /*add_theme_support('custom-background', array(
	'default-color' => 'FFF',
	'default-image' => get_template_directory_uri() . '/img/bg.jpg'
    ));*/

    // Add Support for Custom Header - Uncomment below if you're going to use
    /*add_theme_support('custom-header', array(
	'default-image'			=> get_template_directory_uri() . '/img/headers/default.jpg',
	'header-text'			=> false,
	'default-text-color'		=> '000',
	'width'				=> 1000,
	'height'			=> 198,
	'random-default'		=> false,
	'wp-head-callback'		=> $wphead_cb,
	'admin-head-callback'		=> $adminhead_cb,
	'admin-preview-callback'	=> $adminpreview_cb
    ));*/

    // Enables post and comment RSS feed links to head
    add_theme_support('automatic-feed-links');

    // Localisation Support
    load_theme_textdomain('html5blank', get_template_directory() . '/languages');
}

/*------------------------------------*\
	Functions
\*------------------------------------*/

// HTML5 Blank navigation
function html5blank_nav()
{
	wp_nav_menu(
	array(
		'theme_location'  => 'header-menu',
		'menu'            => '',
		'container'       => 'div',
		'container_class' => 'menu-{menu slug}-container',
		'container_id'    => '',
		'menu_class'      => 'menu',
		'menu_id'         => '',
		'echo'            => true,
		'fallback_cb'     => 'wp_page_menu',
		'before'          => '',
		'after'           => '',
		'link_before'     => '',
		'link_after'      => '',
		'items_wrap'      => '<ul>%3$s</ul>',
		'depth'           => 0,
		'walker'          => ''
		)
	);
}

// Load HTML5 Blank scripts (header.php)
function html5blank_header_scripts()
{
    if ($GLOBALS['pagenow'] != 'wp-login.php' && !is_admin()) {

    	wp_register_script('conditionizr', get_template_directory_uri() . '/js/lib/conditionizr-4.3.0.min.js', array(), '4.3.0'); // Conditionizr
        wp_enqueue_script('conditionizr'); // Enqueue it!

        wp_register_script('modernizr', get_template_directory_uri() . '/js/lib/modernizr-2.7.1.min.js', array(), '2.7.1'); // Modernizr
        wp_enqueue_script('modernizr'); // Enqueue it!

        wp_register_script('html5blankscripts', get_template_directory_uri() . '/js/scripts.js', array('jquery'), '1.0.0'); // Custom scripts
        wp_enqueue_script('html5blankscripts'); // Enqueue it!
    }
}

// Load HTML5 Blank conditional scripts
function html5blank_conditional_scripts()
{
    if (is_page('pagenamehere')) {
        wp_register_script('scriptname', get_template_directory_uri() . '/js/scriptname.js', array('jquery'), '1.0.0'); // Conditional script(s)
        wp_enqueue_script('scriptname'); // Enqueue it!
    }
}

// Load HTML5 Blank styles
function html5blank_styles()
{
    wp_register_style('normalize', get_template_directory_uri() . '/normalize.css', array(), '1.0', 'all');
    wp_enqueue_style('normalize'); // Enqueue it!

    wp_register_style('bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css', array(), '1.0', 'all');
    wp_enqueue_style('bootstrap'); // Enqueue it!

    wp_register_style('slick', get_template_directory_uri() . '/plugins/slick/slick.css', array(), '1.0', 'all');
    wp_enqueue_style('slick'); // Enqueue it!

    wp_register_style('slick-theme', get_template_directory_uri() . '/plugins/slick/slick-theme.css', array(), '1.0', 'all');
    wp_enqueue_style('slick-theme'); // Enqueue it!

    wp_register_style('html5blank', get_template_directory_uri() . '/style.css', array(), '1.1', 'all');
    wp_enqueue_style('html5blank'); // Enqueue it!
}

// Register HTML5 Blank Navigation
function register_html5_menu()
{
    register_nav_menus(array( // Using array to specify more menus if needed
        'header-menu' => __('Header Menu', 'html5blank'), // Main Navigation
        'sidebar-menu' => __('Sidebar Menu', 'html5blank'), // Sidebar Navigation
        'extra-menu' => __('Extra Menu', 'html5blank') // Extra Navigation if needed (duplicate as many as you need!)
    ));
}

// Remove the <div> surrounding the dynamic navigation to cleanup markup
function my_wp_nav_menu_args($args = '')
{
    $args['container'] = false;
    return $args;
}

// Remove Injected classes, ID's and Page ID's from Navigation <li> items
function my_css_attributes_filter($var)
{
    return is_array($var) ? array() : '';
}

// Remove invalid rel attribute values in the categorylist
function remove_category_rel_from_category_list($thelist)
{
    return str_replace('rel="category tag"', 'rel="tag"', $thelist);
}

// Add page slug to body class, love this - Credit: Starkers Wordpress Theme
function add_slug_to_body_class($classes)
{
    global $post;
    if (is_home()) {
        $key = array_search('blog', $classes);
        if ($key > -1) {
            unset($classes[$key]);
        }
    } elseif (is_page()) {
        $classes[] = sanitize_html_class($post->post_name);
    } elseif (is_singular()) {
        $classes[] = sanitize_html_class($post->post_name);
    }

    return $classes;
}

// If Dynamic Sidebar Exists
if (function_exists('register_sidebar'))
{
    // Define Sub Footer Widget Area 1
    register_sidebar(array(
        'name' => __('Footer 3', 'html5blank'),
        'description' => __('Description for this widget-area...', 'html5blank'),
        'id' => 'widget-area-5',
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => ''
    ));

    // Define Sub Footer Widget Area 2
    register_sidebar(array(
        'name' => __('Footer 2', 'html5blank'),
        'description' => __('Description for this widget-area...', 'html5blank'),
        'id' => 'widget-area-4',
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => ''
    ));

    // Define Sub Footer Widget Area 3
    register_sidebar(array(
        'name' => __('Footer 1', 'html5blank'),
        'description' => __('Description for this widget-area...', 'html5blank'),
        'id' => 'widget-area-3',
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => ''
    ));

    // Define Sub Footer Widget Area 2
    register_sidebar(array(
        'name' => __('Support Sub Area', 'html5blank'),
        'description' => __('Description for this widget-area...', 'html5blank'),
        'id' => 'widget-area-2',
        'before_widget' => '<div id="%1$s" class="%2$s widgets ss col-md-4">',
        'after_widget' => '</div>',
        'before_title' => '',
        'after_title' => ''
    ));

    register_sidebar(array(
        'name' => __('Support sidebar', 'html5blank'),
        'description' => __('Description for this widget-area...', 'html5blank'),
        'id' => 'widget-area-1',
        'before_widget' => '<div id="%1$s" class="%2$s widgets">',
        'after_widget' => '</div>',
        'before_title' => '',
        'after_title' => ''
    ));
}

// Remove wp_head() injected Recent Comment styles
function my_remove_recent_comments_style()
{
    global $wp_widget_factory;
    remove_action('wp_head', array(
        $wp_widget_factory->widgets['WP_Widget_Recent_Comments'],
        'recent_comments_style'
    ));
}

// Pagination for paged posts, Page 1, Page 2, Page 3, with Next and Previous Links, No plugin
function html5wp_pagination()
{
    global $wp_query;
    $big = 999999999;
    echo paginate_links(array(
        'base' => str_replace($big, '%#%', get_pagenum_link($big)),
        'format' => '?paged=%#%',
        'current' => max(1, get_query_var('paged')),
        'total' => $wp_query->max_num_pages
    ));
}

// Custom Excerpts
function html5wp_index($length) // Create 20 Word Callback for Index page Excerpts, call using html5wp_excerpt('html5wp_index');
{
    return 20;
}

// Create 40 Word Callback for Custom Post Excerpts, call using html5wp_excerpt('html5wp_custom_post');
function html5wp_custom_post($length)
{
    return 40;
}








// Register and load the widget
function sfs_signup_load_widget() {
    register_widget( 'sfs_signup_widget' );
}
add_action( 'widgets_init', 'sfs_signup_load_widget' );

// Creating the widget
class sfs_signup_widget extends WP_Widget {

    function __construct() {
    parent::__construct(

    // Base ID of your widget
    'sfs_signup_widget',

    // Widget name will appear in UI
    __('Seafood Scotland Sign up widget', 'sfs_signup_widget_domain'),

    // Widget description
    array( 'description' => __( '', 'sfs_signup_widget_domain' ), )
    );
    }

    // Creating widget front-end

    public function widget( $args, $instance ) {
    $title = apply_filters( 'widget_title', $instance['title'] );
    $iconurl = apply_filters( 'widget_iconurl', $instance['iconurl'] );
    $secondardytitle = apply_filters( 'widget_secondardytitle', $instance['secondardytitle'] );
    $text = apply_filters( 'widget_title', $instance['text'] );
    $url = apply_filters( 'widget_title', $instance['url'] );
    $link_text = apply_filters( 'widget_title', $instance['link_text'] );

    // before and after widget arguments are defined by themes
    echo $args['before_widget'];
    if ( ! empty( $title ) )

    // This is where you run the code and display the output
    ?>
          <div class="box silver">
            <div class="offset">
              <h3><img src="<?php echo $iconurl ?>"><?php echo $title ?></h3>
              <div>
                <div class="simple-content">
                  <h4><?php echo $secondardytitle ?></h4>
                  <p style="font-size: 18px;color:black;"><?php echo $text ?></p>
                </div>
                <a href="<?php echo $url ?>" class="btn btn-primary pull-right"><?php echo $link_text ?> <span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span></a>
                <br style="clear:both" />
              </div>
            </div>
          </div>
        </div>
        <?php
    }

    // Widget Backend
    public function form( $instance ) {
    if ( isset( $instance[ 'title' ] ) ) {
    $title = $instance[ 'title' ];
    $iconurl = $instance[ 'iconurl' ];
    $secondardytitle = $instance[ 'secondardytitle' ];
    $text = $instance[ 'text' ];
    $url = $instance[ 'url' ];
    $link_text = $instance[ 'link_text' ];
    }
    else {
    $title = __( 'Sign up', 'sfs_signup_widget_domain' );
    $iconurl = __( '/wp-content/uploads/2017/12/latest-events-icon.png', 'sfs_signup_widget_domain' );
    $secondardytitle = __( 'Do we have the right email address for your business and current product range?', 'sfs_signup_widget_domain' );
    $text = __( 'Make sure you stay in touch and receive our industry updates. Complete this short survey to ensure we can get in touch with you to share news, supply enquiries or market development opportunities to further your business needs.', 'sfs_signup_widget_domain' );
    $url = __( '/about-us/', 'sfs_signup_widget_domain' );
    $link_text = __( 'Sign up now', 'sfs_signup_widget_domain' );
    }
    // Widget admin form
    ?>
    <p>
    <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
    </p>
    <p>
    <label for="<?php echo $this->get_field_id( 'iconurl' ); ?>"><?php _e( 'Icon URL:' ); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'iconurl' ); ?>" name="<?php echo $this->get_field_name( 'iconurl' ); ?>" type="text" value="<?php echo esc_attr( $iconurl ); ?>" />
    </p>
    <p>
    <label for="<?php echo $this->get_field_id( 'secondardytitle' ); ?>"><?php _e( 'Secondardy Title:' ); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'secondardytitle' ); ?>" name="<?php echo $this->get_field_name( 'secondardytitle' ); ?>" type="text" value="<?php echo esc_attr( $secondardytitle ); ?>" />
    </p>
    <p>
    <label for="<?php echo $this->get_field_id( 'text' ); ?>"><?php _e( 'Text:' ); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'text' ); ?>" name="<?php echo $this->get_field_name( 'text' ); ?>" type="text" value="<?php echo esc_attr( $text ); ?>" />
    </p>
    <p>
    <label for="<?php echo $this->get_field_id( 'url' ); ?>"><?php _e( 'URL:' ); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'url' ); ?>" name="<?php echo $this->get_field_name( 'url' ); ?>" type="text" value="<?php echo esc_attr( $url ); ?>" />
    </p>
    <p>
    <label for="<?php echo $this->get_field_id( 'link_text' ); ?>"><?php _e( 'Link text:' ); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'link_text' ); ?>" name="<?php echo $this->get_field_name( 'link_text' ); ?>" type="text" value="<?php echo esc_attr( $link_text ); ?>" />
    </p>
    <?php
    }

    // Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {
    $instance = array();
    $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
    $instance['iconurl'] = ( ! empty( $new_instance['iconurl'] ) ) ? strip_tags( $new_instance['iconurl'] ) : '';
    $instance['secondardytitle'] = ( ! empty( $new_instance['secondardytitle'] ) ) ? strip_tags( $new_instance['secondardytitle'] ) : '';
    $instance['text'] = ( ! empty( $new_instance['text'] ) ) ? strip_tags( $new_instance['text'] ) : '';
    $instance['url'] = ( ! empty( $new_instance['url'] ) ) ? strip_tags( $new_instance['url'] ) : '';
    $instance['link_text'] = ( ! empty( $new_instance['link_text'] ) ) ? strip_tags( $new_instance['link_text'] ) : '';


    return $instance;
    }
} // Class sfs_signup_widget ends here




// Register and load the widget
function sfs_simple1_load_widget() {
    register_widget( 'sfs_simple1_widget' );
}
add_action( 'widgets_init', 'sfs_simple1_load_widget' );

// Creating the widget
class sfs_simple1_widget extends WP_Widget {

    function __construct() {
    parent::__construct(

    // Base ID of your widget
    'sfs_simple1_widget',

    // Widget name will appear in UI
    __('Seafood Scotland Simple Widget', 'sfs_simple1_widget_domain'),

    // Widget description
    array( 'description' => 'Widget 1', )
    );
    }

    // Creating widget front-end

    public function widget( $args, $instance ) {
    $title = apply_filters( 'widget_title', $instance['title'] );
    $iconurl = apply_filters( 'widget_iconurl', $instance['iconurl'] );
    $secondardytitle = apply_filters( 'widget_secondardytitle', $instance['secondardytitle'] );
    $text = apply_filters( 'widget_title', $instance['text'] );
    $url = apply_filters( 'widget_title', $instance['url'] );
    $link_text = apply_filters( 'widget_title', $instance['link_text'] );

    // before and after widget arguments are defined by themes
    echo $args['before_widget'];
    if ( ! empty( $title ) )

    // This is where you run the code and display the output
    ?>
      <div class="box purple">
        <img src="<?php echo $iconurl ?>">
        <h3 class="simple"><?php echo $title ?></h3>
          <div>
          <div class="simple-content">
            <p><?php echo $text ?></p>
          </div>
          <a href="<?php echo $url ?>" class="btn btn-primary pull-right"><?php echo $link_text ?> <span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span></a>
        </div>
      </div>
    </div>


        <?php
    }

    // Widget Backend
    public function form( $instance ) {
    if ( isset( $instance[ 'title' ] ) ) {
    $title = $instance[ 'title' ];
    $iconurl = $instance[ 'iconurl' ];
    $secondardytitle = $instance[ 'secondardytitle' ];
    $text = $instance[ 'text' ];
    $url = $instance[ 'url' ];
    $link_text = $instance[ 'link_text' ];
    }
    else {
    $title = __( 'Connect Local', 'sfs_signup_widget_domain' );
    $iconurl = __( '/wp-content/uploads/2017/12/350x1501.png', 'sfs_signup_widget_domain' );
    $text = __( 'Nam tempor ac nisi vel posuere. Maecenas eget aliquam erat. Quisque non ex neque. Suspendisse id pellentesque mauris.', 'sfs_signup_widget_domain' );
    $url = __( '/support-available/connect-local/', 'sfs_signup_widget_domain' );
    $link_text = __( 'Read more', 'sfs_signup_widget_domain' );
    }
    // Widget admin form
    ?>
    <p>
    <label for="<?php echo $this->get_field_id( 'iconurl' ); ?>"><?php _e( 'Image URL:' ); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'iconurl' ); ?>" name="<?php echo $this->get_field_name( 'iconurl' ); ?>" type="text" value="<?php echo esc_attr( $iconurl ); ?>" />
    </p>
    <p>
    <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
    </p>
    <p>
    <label for="<?php echo $this->get_field_id( 'text' ); ?>"><?php _e( 'Text:' ); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'text' ); ?>" name="<?php echo $this->get_field_name( 'text' ); ?>" type="text" value="<?php echo esc_attr( $text ); ?>" />
    </p>
    <p>
    <label for="<?php echo $this->get_field_id( 'url' ); ?>"><?php _e( 'URL:' ); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'url' ); ?>" name="<?php echo $this->get_field_name( 'url' ); ?>" type="text" value="<?php echo esc_attr( $url ); ?>" />
    </p>
    <p>
    <label for="<?php echo $this->get_field_id( 'link_text' ); ?>"><?php _e( 'Link text:' ); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'link_text' ); ?>" name="<?php echo $this->get_field_name( 'link_text' ); ?>" type="text" value="<?php echo esc_attr( $link_text ); ?>" />
    </p>
    <?php
    }

    // Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {
    $instance = array();
    $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
    $instance['iconurl'] = ( ! empty( $new_instance['iconurl'] ) ) ? strip_tags( $new_instance['iconurl'] ) : '';
    $instance['secondardytitle'] = ( ! empty( $new_instance['secondardytitle'] ) ) ? strip_tags( $new_instance['secondardytitle'] ) : '';
    $instance['text'] = ( ! empty( $new_instance['text'] ) ) ? strip_tags( $new_instance['text'] ) : '';
    $instance['url'] = ( ! empty( $new_instance['url'] ) ) ? strip_tags( $new_instance['url'] ) : '';
    $instance['link_text'] = ( ! empty( $new_instance['link_text'] ) ) ? strip_tags( $new_instance['link_text'] ) : '';


    return $instance;
    }
} // Class sfs_signup_widget ends here




// Register and load the widget
function sfs_simple2_load_widget() {
    register_widget( 'sfs_simple2_widget' );
}
add_action( 'widgets_init', 'sfs_simple2_load_widget' );

// Creating the widget
class sfs_simple2_widget extends WP_Widget {

    function __construct() {
    parent::__construct(

    // Base ID of your widget
    'sfs_simple2_widget',

    // Widget name will appear in UI
    __('Seafood Scotland Simple Widget', 'sfs_simple2_widget_domain'),

    // Widget description
    array( 'description' => 'Widget 2', )
    );
    }

    // Creating widget front-end

    public function widget( $args, $instance ) {
    $title = apply_filters( 'widget_title', $instance['title'] );
    $iconurl = apply_filters( 'widget_iconurl', $instance['iconurl'] );
    $secondardytitle = apply_filters( 'widget_secondardytitle', $instance['secondardytitle'] );
    $text = apply_filters( 'widget_title', $instance['text'] );
    $url = apply_filters( 'widget_title', $instance['url'] );
    $link_text = apply_filters( 'widget_title', $instance['link_text'] );

    // before and after widget arguments are defined by themes
    echo $args['before_widget'];
    if ( ! empty( $title ) )

    // This is where you run the code and display the output
    ?>
      <div class="box darkblue">
        <img src="<?php echo $iconurl ?>">
        <h3 class="simple"><?php echo $title ?></h3>
          <div>
          <div class="simple-content">
            <p><?php echo $text ?></p>
          </div>
          <a href="<?php echo $url ?>" class="btn btn-primary pull-right"><?php echo $link_text ?> <span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span></a>
        </div>
      </div>
    </div>


        <?php
    }

    // Widget Backend
    public function form( $instance ) {
    if ( isset( $instance[ 'title' ] ) ) {
    $title = $instance[ 'title' ];
    $iconurl = $instance[ 'iconurl' ];
    $secondardytitle = $instance[ 'secondardytitle' ];
    $text = $instance[ 'text' ];
    $url = $instance[ 'url' ];
    $link_text = $instance[ 'link_text' ];
    }
    else {
    $title = __( 'Export', 'sfs_signup_widget_domain' );
    $iconurl = __( '/wp-content/uploads/2017/12/350x1501.png', 'sfs_signup_widget_domain' );
    $text = __( 'Nam tempor ac nisi vel posuere. Maecenas eget aliquam erat. Quisque non ex neque. Suspendisse id pellentesque mauris.', 'sfs_signup_widget_domain' );
    $url = __( '/support-available/export/', 'sfs_signup_widget_domain' );
    $link_text = __( 'Read more', 'sfs_signup_widget_domain' );
    }
    // Widget admin form
    ?>
    <p>
    <label for="<?php echo $this->get_field_id( 'iconurl' ); ?>"><?php _e( 'Image URL:' ); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'iconurl' ); ?>" name="<?php echo $this->get_field_name( 'iconurl' ); ?>" type="text" value="<?php echo esc_attr( $iconurl ); ?>" />
    </p>
    <p>
    <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
    </p>
    <p>
    <label for="<?php echo $this->get_field_id( 'text' ); ?>"><?php _e( 'Text:' ); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'text' ); ?>" name="<?php echo $this->get_field_name( 'text' ); ?>" type="text" value="<?php echo esc_attr( $text ); ?>" />
    </p>
    <p>
    <label for="<?php echo $this->get_field_id( 'url' ); ?>"><?php _e( 'URL:' ); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'url' ); ?>" name="<?php echo $this->get_field_name( 'url' ); ?>" type="text" value="<?php echo esc_attr( $url ); ?>" />
    </p>
    <p>
    <label for="<?php echo $this->get_field_id( 'link_text' ); ?>"><?php _e( 'Link text:' ); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'link_text' ); ?>" name="<?php echo $this->get_field_name( 'link_text' ); ?>" type="text" value="<?php echo esc_attr( $link_text ); ?>" />
    </p>
    <?php
    }

    // Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {
    $instance = array();
    $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
    $instance['iconurl'] = ( ! empty( $new_instance['iconurl'] ) ) ? strip_tags( $new_instance['iconurl'] ) : '';
    $instance['secondardytitle'] = ( ! empty( $new_instance['secondardytitle'] ) ) ? strip_tags( $new_instance['secondardytitle'] ) : '';
    $instance['text'] = ( ! empty( $new_instance['text'] ) ) ? strip_tags( $new_instance['text'] ) : '';
    $instance['url'] = ( ! empty( $new_instance['url'] ) ) ? strip_tags( $new_instance['url'] ) : '';
    $instance['link_text'] = ( ! empty( $new_instance['link_text'] ) ) ? strip_tags( $new_instance['link_text'] ) : '';


    return $instance;
    }
} // Class sfs_signup_widget ends here




// Register and load the widget
function sfs_simple3_load_widget() {
    register_widget( 'sfs_simple3_widget' );
}
add_action( 'widgets_init', 'sfs_simple3_load_widget' );

// Creating the widget
class sfs_simple3_widget extends WP_Widget {

    function __construct() {
    parent::__construct(

    // Base ID of your widget
    'sfs_simple3_widget',

    // Widget name will appear in UI
    __('Seafood Scotland Simple Widget', 'sfs_simple3_widget_domain'),

    // Widget description
    array( 'description' => 'Widget 3', )
    );
    }

    // Creating widget front-end

    public function widget( $args, $instance ) {
    $title = apply_filters( 'widget_title', $instance['title'] );
    $iconurl = apply_filters( 'widget_iconurl', $instance['iconurl'] );
    $text = apply_filters( 'widget_title', $instance['text'] );
    $url = apply_filters( 'widget_title', $instance['url'] );
    $link_text = apply_filters( 'widget_title', $instance['link_text'] );

    // before and after widget arguments are defined by themes
    echo $args['before_widget'];
    if ( ! empty( $title ) )

    // This is where you run the code and display the output
    ?>
      <div class="box seablue">
        <img src="<?php echo $iconurl ?>">
        <h3 class="simple"><?php echo $title ?></h3>
          <div>
          <div class="simple-content">
            <p><?php echo $text ?></p>
          </div>
          <a href="<?php echo $url ?>" class="btn btn-primary pull-right"><?php echo $link_text ?> <span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span></a>
        </div>
      </div>
    </div>


        <?php
    }

    // Widget Backend
    public function form( $instance ) {
    if ( isset( $instance[ 'title' ] ) ) {
    $title = $instance[ 'title' ];
    $iconurl = $instance[ 'iconurl' ];
    $secondardytitle = $instance[ 'secondardytitle' ];
    $text = $instance[ 'text' ];
    $url = $instance[ 'url' ];
    $link_text = $instance[ 'link_text' ];
    }
    else {
    $title = __( 'Seafood from Scotland', 'sfs_signup_widget_domain' );
    $iconurl = __( '/wp-content/uploads/2017/12/350x1501.png', 'sfs_signup_widget_domain' );
    $text = __( 'Nam tempor ac nisi vel posuere. Maecenas eget aliquam erat. Quisque non ex neque. Suspendisse id pellentesque mauris.', 'sfs_signup_widget_domain' );
    $url = __( '/support-available/seafood-from-scotland/', 'sfs_signup_widget_domain' );
    $link_text = __( 'Read more', 'sfs_signup_widget_domain' );
    }
    // Widget admin form
    ?>
    <p>
    <label for="<?php echo $this->get_field_id( 'iconurl' ); ?>"><?php _e( 'Image URL:' ); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'iconurl' ); ?>" name="<?php echo $this->get_field_name( 'iconurl' ); ?>" type="text" value="<?php echo esc_attr( $iconurl ); ?>" />
    </p>
    <p>
    <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
    </p>
    <p>
    <label for="<?php echo $this->get_field_id( 'text' ); ?>"><?php _e( 'Text:' ); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'text' ); ?>" name="<?php echo $this->get_field_name( 'text' ); ?>" type="text" value="<?php echo esc_attr( $text ); ?>" />
    </p>
    <p>
    <label for="<?php echo $this->get_field_id( 'url' ); ?>"><?php _e( 'URL:' ); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'url' ); ?>" name="<?php echo $this->get_field_name( 'url' ); ?>" type="text" value="<?php echo esc_attr( $url ); ?>" />
    </p>
    <p>
    <label for="<?php echo $this->get_field_id( 'link_text' ); ?>"><?php _e( 'Link text:' ); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'link_text' ); ?>" name="<?php echo $this->get_field_name( 'link_text' ); ?>" type="text" value="<?php echo esc_attr( $link_text ); ?>" />
    </p>
    <?php
    }

    // Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {
    $instance = array();
    $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
    $instance['iconurl'] = ( ! empty( $new_instance['iconurl'] ) ) ? strip_tags( $new_instance['iconurl'] ) : '';
    $instance['secondardytitle'] = ( ! empty( $new_instance['secondardytitle'] ) ) ? strip_tags( $new_instance['secondardytitle'] ) : '';
    $instance['text'] = ( ! empty( $new_instance['text'] ) ) ? strip_tags( $new_instance['text'] ) : '';
    $instance['url'] = ( ! empty( $new_instance['url'] ) ) ? strip_tags( $new_instance['url'] ) : '';
    $instance['link_text'] = ( ! empty( $new_instance['link_text'] ) ) ? strip_tags( $new_instance['link_text'] ) : '';


    return $instance;
    }
} // Class sfs_signup_widget ends here







// Create the Custom Excerpts callback
function html5wp_excerpt($length_callback = '', $more_callback = '')
{
    global $post;
    if (function_exists($length_callback)) {
        add_filter('excerpt_length', $length_callback);
    }
    if (function_exists($more_callback)) {
        add_filter('excerpt_more', $more_callback);
    }
    $output = get_the_excerpt();
    $output = apply_filters('wptexturize', $output);
    $output = apply_filters('convert_chars', $output);
    $output = '<p>' . $output . '</p>';
    echo $output;
}

// Custom View Article link to Post
function html5_blank_view_article($more)
{
    global $post;
    return '... <a class="view-article" href="' . get_permalink($post->ID) . '">' . __('View Article', 'html5blank') . '</a>';
}

// Remove Admin bar
function remove_admin_bar()
{
    return false;
}

// Remove 'text/css' from our enqueued stylesheet
function html5_style_remove($tag)
{
    return preg_replace('~\s+type=["\'][^"\']++["\']~', '', $tag);
}

// Remove thumbnail width and height dimensions that prevent fluid images in the_thumbnail
function remove_thumbnail_dimensions( $html )
{
    $html = preg_replace('/(width|height)=\"\d*\"\s/', "", $html);
    return $html;
}

// Custom Gravatar in Settings > Discussion
function html5blankgravatar ($avatar_defaults)
{
    $myavatar = get_template_directory_uri() . '/img/gravatar.jpg';
    $avatar_defaults[$myavatar] = "Custom Gravatar";
    return $avatar_defaults;
}

// Threaded Comments
function enable_threaded_comments()
{
    if (!is_admin()) {
        if (is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
            wp_enqueue_script('comment-reply');
        }
    }
}

// Custom Comments Callback
function html5blankcomments($comment, $args, $depth)
{
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);

	if ( 'div' == $args['style'] ) {
		$tag = 'div';
		$add_below = 'comment';
	} else {
		$tag = 'li';
		$add_below = 'div-comment';
	}
?>
    <!-- heads up: starting < for the html tag (li or div) in the next line: -->
    <<?php echo $tag ?> <?php comment_class(empty( $args['has_children'] ) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">
	<?php if ( 'div' != $args['style'] ) : ?>
	<div id="div-comment-<?php comment_ID() ?>" class="comment-body">
	<?php endif; ?>
	<div class="comment-author vcard">
	<?php if ($args['avatar_size'] != 0) echo get_avatar( $comment, $args['180'] ); ?>
	<?php printf(__('<cite class="fn">%s</cite> <span class="says">says:</span>'), get_comment_author_link()) ?>
	</div>
<?php if ($comment->comment_approved == '0') : ?>
	<em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.') ?></em>
	<br />
<?php endif; ?>

	<div class="comment-meta commentmetadata"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>">
		<?php
			printf( __('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?></a><?php edit_comment_link(__('(Edit)'),'  ','' );
		?>
	</div>

	<?php comment_text() ?>

	<div class="reply">
	<?php comment_reply_link(array_merge( $args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
	</div>
	<?php if ( 'div' != $args['style'] ) : ?>
	</div>
	<?php endif; ?>
<?php }

/*------------------------------------*\
	Actions + Filters + ShortCodes
\*------------------------------------*/

// Add Actions
add_action('init', 'html5blank_header_scripts'); // Add Custom Scripts to wp_head
add_action('wp_print_scripts', 'html5blank_conditional_scripts'); // Add Conditional Page Scripts
add_action('get_header', 'enable_threaded_comments'); // Enable Threaded Comments
add_action('wp_enqueue_scripts', 'html5blank_styles'); // Add Theme Stylesheet
add_action('init', 'register_html5_menu'); // Add HTML5 Blank Menu
add_action('widgets_init', 'my_remove_recent_comments_style'); // Remove inline Recent Comment Styles from wp_head()
add_action('init', 'html5wp_pagination'); // Add our HTML5 Pagination

// Remove Actions
remove_action('wp_head', 'feed_links_extra', 3); // Display the links to the extra feeds such as category feeds
remove_action('wp_head', 'feed_links', 2); // Display the links to the general feeds: Post and Comment Feed
remove_action('wp_head', 'rsd_link'); // Display the link to the Really Simple Discovery service endpoint, EditURI link
remove_action('wp_head', 'wlwmanifest_link'); // Display the link to the Windows Live Writer manifest file.
remove_action('wp_head', 'index_rel_link'); // Index link
remove_action('wp_head', 'parent_post_rel_link', 10, 0); // Prev link
remove_action('wp_head', 'start_post_rel_link', 10, 0); // Start link
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0); // Display relational links for the posts adjacent to the current post.
remove_action('wp_head', 'wp_generator'); // Display the XHTML generator that is generated on the wp_head hook, WP version
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
remove_action('wp_head', 'rel_canonical');
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

// Add Filters
add_filter('avatar_defaults', 'html5blankgravatar'); // Custom Gravatar in Settings > Discussion
add_filter('body_class', 'add_slug_to_body_class'); // Add slug to body class (Starkers build)
add_filter('widget_text', 'do_shortcode'); // Allow shortcodes in Dynamic Sidebar
add_filter('widget_text', 'shortcode_unautop'); // Remove <p> tags in Dynamic Sidebars (better!)
add_filter('wp_nav_menu_args', 'my_wp_nav_menu_args'); // Remove surrounding <div> from WP Navigation
// add_filter('nav_menu_css_class', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> injected classes (Commented out by default)
// add_filter('nav_menu_item_id', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> injected ID (Commented out by default)
// add_filter('page_css_class', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> Page ID's (Commented out by default)
add_filter('the_category', 'remove_category_rel_from_category_list'); // Remove invalid rel attribute
add_filter('the_excerpt', 'shortcode_unautop'); // Remove auto <p> tags in Excerpt (Manual Excerpts only)
add_filter('the_excerpt', 'do_shortcode'); // Allows Shortcodes to be executed in Excerpt (Manual Excerpts only)
add_filter('excerpt_more', 'html5_blank_view_article'); // Add 'View Article' button instead of [...] for Excerpts
add_filter('show_admin_bar', 'remove_admin_bar'); // Remove Admin bar
add_filter('style_loader_tag', 'html5_style_remove'); // Remove 'text/css' from enqueued stylesheet
add_filter('post_thumbnail_html', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to thumbnails
add_filter('image_send_to_editor', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to post images

// Remove Filters
remove_filter('the_excerpt', 'wpautop'); // Remove <p> tags from Excerpt altogether

// Shortcodes
add_shortcode('html5_shortcode_demo', 'html5_shortcode_demo'); // You can place [html5_shortcode_demo] in Pages, Posts now.
add_shortcode('html5_shortcode_demo_2', 'html5_shortcode_demo_2'); // Place [html5_shortcode_demo_2] in Pages, Posts now.

// Shortcodes above would be nested like this -
// [html5_shortcode_demo] [html5_shortcode_demo_2] Here's the page title! [/html5_shortcode_demo_2] [/html5_shortcode_demo]

/*------------------------------------*\
	Custom Post Types
\*------------------------------------*/

// Create 1 Custom Post type for a Demo, called HTML5-Blank
function create_post_type_html5()
{
    register_taxonomy_for_object_type('category', 'html5-blank'); // Register Taxonomies for Category
    register_taxonomy_for_object_type('post_tag', 'html5-blank');
    register_post_type('html5-blank', // Register Custom Post Type
        array(
        'labels' => array(
            'name' => __('HTML5 Blank Custom Post', 'html5blank'), // Rename these to suit
            'singular_name' => __('HTML5 Blank Custom Post', 'html5blank'),
            'add_new' => __('Add New', 'html5blank'),
            'add_new_item' => __('Add New HTML5 Blank Custom Post', 'html5blank'),
            'edit' => __('Edit', 'html5blank'),
            'edit_item' => __('Edit HTML5 Blank Custom Post', 'html5blank'),
            'new_item' => __('New HTML5 Blank Custom Post', 'html5blank'),
            'view' => __('View HTML5 Blank Custom Post', 'html5blank'),
            'view_item' => __('View HTML5 Blank Custom Post', 'html5blank'),
            'search_items' => __('Search HTML5 Blank Custom Post', 'html5blank'),
            'not_found' => __('No HTML5 Blank Custom Posts found', 'html5blank'),
            'not_found_in_trash' => __('No HTML5 Blank Custom Posts found in Trash', 'html5blank')
        ),
        'public' => true,
        'hierarchical' => true, // Allows your posts to behave like Hierarchy Pages
        'has_archive' => true,
        'supports' => array(
            'title',
            'editor',
            'excerpt',
            'thumbnail'
        ), // Go to Dashboard Custom HTML5 Blank post for supports
        'can_export' => true, // Allows export in Tools > Export
        'taxonomies' => array(
            'post_tag',
            'category'
        ) // Add Category and Post Tags support
    ));
}

/*------------------------------------*\
	ShortCode Functions
\*------------------------------------*/

// Shortcode Demo with Nested Capability
function html5_shortcode_demo($atts, $content = null)
{
    return '<div class="shortcode-demo">' . do_shortcode($content) . '</div>'; // do_shortcode allows for nested Shortcodes
}

// Shortcode Demo with simple <h2> tag
function html5_shortcode_demo_2($atts, $content = null) // Demo Heading H2 shortcode, allows for nesting within above element. Fully expandable.
{
    return '<h2>' . $content . '</h2>';
}

function get_seafood_scotland_global_header($title, $sub_header) {
?>
  <div class="container">
    <div class="row titles">
        <div class="col-md-2 col-sm-4 col-xs-4 col-lg-2 logo" >
            <?php echo get_the_logo(); ?>
        </div>
        <div class="col-md-7 col-sm-8 col-xs-8 col-lg-7" >
            <h1 <?php if (empty($sub_header)) {?>style="margin-top:24px"<?php } else {?>style="margin-top:10px"<?php };?>><?php echo $title; ?></h1>
            <?php
              if (!empty($sub_header)) {
                ?><p style="font-size: 19px;"><?php echo $sub_header; ?></p><?php
              }; ?>
        </div>
    </div>
  </div>
<?php
};


?>
