<?php

// Debug
require_once 'modules/is-debug.php';

// Versioning
$json = get_theme_root() . "/REPLACEMEPLEASE/package.json";
$the_version = json_decode( file_get_contents( $json ), true );
$the_version = $the_version["version"];
define("THE_VERSION_NUMBER", $the_version);

// Content Width
if ( ! isset( $content_width ) ) {
    $content_width = 900;
}

// Theme Support
if ( function_exists( 'add_theme_support' ) ) {

    // Add Thumbnail Theme Support.
    add_theme_support( 'post-thumbnails' );
    add_image_size( 'large', 700, '', true ); // Large Thumbnail.
    add_image_size( 'medium', 250, '', true ); // Medium Thumbnail.
    add_image_size( 'small', 120, '', true ); // Small Thumbnail.
    add_image_size( 'custom-size', 700, 200, true ); // Custom Thumbnail Size call using the_post_thumbnail('custom-size');
    add_image_size( 'custom-full', 1200, '', true ); // Custom Thumbnail Size call using the_post_thumbnail('custom-size');

    // Enables post and comment RSS feed links to head.
    add_theme_support( 'automatic-feed-links' );

    // Enable HTML5 support.
    add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption' ) );

    // Localisation Support.
    load_theme_textdomain( 'html5blank', get_template_directory() . '/languages' );
}

/*------------------------------------*\
    Functions
\*------------------------------------*/

// HTML5 Blank navigation
function html5blank_nav() {
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
        'walker'          => '',
        )
    );
}

// Load HTML5 Blank scripts (header.php)
function html5blank_header_scripts() {
    if ( $GLOBALS['pagenow'] != 'wp-login.php' && ! is_admin() ) {
        if ( HTML5_DEBUG ) {
            // jQuery
            wp_deregister_script( 'jquery' );
            wp_register_script( 'jquery', get_template_directory_uri() . '/bower_components/jquery/dist/jquery.js', array(), '3.2.1' );

            // Font Awesome
            wp_register_script('font-awesome', 'https://use.fontawesome.com/ac964b0016.js', array(), '4.7.0');

            // Webfont Loader
            wp_register_script('webfont-loader', 'https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js', array(), '2.8.3');

            // Font Face Observer
            wp_register_script('font-face-observer', get_theme_root_uri() . '/REPLACEMEPLEASE/node_modules/fontfaceobserver/fontfaceobserver.js', array(), '2.0.13');

            // Slick Slider
            wp_register_script('slick', get_theme_root_uri() . '/REPLACEMEPLEASE/node_modules/slick-carousel/slick/slick.js', array(), '1.8.1');

            // Font Awesome
            wp_register_script(
                'html5blankscripts',
                get_template_directory_uri() . '/js/scripts.js',
                array(
                    'webfont-loader',
                    'font-face-observer',
                    'jquery',
                    'font-awesome',
                    'slick'
                ),
                THE_VERSION_NUMBER );

            // Enqueue Scripts
            wp_enqueue_script( 'html5blankscripts' );

        // If production
        } else {
            // Scripts minify
            wp_register_script( 'html5blankscripts-min', get_template_directory_uri() . '/js/scripts.min.js', array(), THE_VERSION_NUMBER );
            // Font Awesome
            wp_register_script( 'font-awesome', 'https://use.fontawesome.com/ac964b0016.js', array(), '4.7.0' );
            // Enqueue Scripts
            wp_enqueue_script( 'html5blankscripts-min' );
        }
    }
}

// Load HTML5 Blank conditional scripts
function html5blank_conditional_scripts() {
    if ( is_page( 'pagenamehere' ) ) {
        // Conditional script(s)
        wp_register_script( 'scriptname', get_template_directory_uri() . '/js/scriptname.js', array( 'jquery' ), THE_VERSION_NUMBER );
        wp_enqueue_script( 'scriptname' );
    }
}

// Load HTML5 Blank styles
function html5blank_styles() {
    if ( HTML5_DEBUG ) {
        // normalize-css
        // wp_register_style( 'normalize', get_template_directory_uri() . '/bower_components/normalize.css/normalize.css', array(), '3.0.1' );

        // Slick
        wp_register_style( 'slick', get_theme_root_uri() . '/REPLACEMEPLEASE/node_modules/slick-carousel/slick/slick.css', array(), '1.8.1' );
        wp_register_style( 'slick-theme', get_theme_root_uri() . '/REPLACEMEPLEASE/node_modules/slick-carousel/slick/slick-theme.css', array(), '1.8.1' );

        // Custom CSS
        wp_register_style( 'html5blank', get_template_directory_uri() . '/style.css', array(), THE_VERSION_NUMBER );

        // Register CSS
        wp_enqueue_style( 'slick' );
        wp_enqueue_style( 'slick-theme' );
        wp_enqueue_style( 'html5blank' );
    } else {

        // Custom CSS
        wp_register_style( 'html5blankcssmin', get_template_directory_uri() . '/style.css', array(), THE_VERSION_NUMBER );

        // Register CSS
        wp_enqueue_style( 'html5blankcssmin' );
    }
}

// Register HTML5 Blank Navigation
function register_html5_menu() {
    register_nav_menus( array( // Using array to specify more menus if needed
        'header-menu'  => esc_html( 'Header Menu', 'html5blank' ), // Main Navigation
        'footer-menu' => esc_html( 'Footer Menu', 'html5blank' ), // Sidebar Navigation
    ) );
}

// Remove the <div> surrounding the dynamic navigation to cleanup markup
function my_wp_nav_menu_args( $args = '' ) {
    $args['container'] = false;
    return $args;
}

// Remove Injected classes, ID's and Page ID's from Navigation <li> items
function my_css_attributes_filter( $var ) {
    return is_array( $var ) ? array() : '';
}

// Remove invalid rel attribute values in the categorylist
function remove_category_rel_from_category_list( $thelist ) {
    return str_replace( 'rel="category tag"', 'rel="tag"', $thelist );
}

// Add page slug to body class, love this - Credit: Starkers Wordpress Theme
function add_slug_to_body_class( $classes ) {
    global $post;
    if ( is_home() ) {
        $key = array_search( 'blog', $classes, true );
        if ( $key > -1 ) {
            unset( $classes[$key] );
        }
    } elseif ( is_page() ) {
        $classes[] = sanitize_html_class( $post->post_name );
    } elseif ( is_singular() ) {
        $classes[] = sanitize_html_class( $post->post_name );
    }

    return $classes;
}

// Remove the width and height attributes from inserted images
function remove_width_attribute( $html ) {
    $html = preg_replace( '/(width|height)="\d*"\s/', "", $html );
    return $html;
}

// Remove wp_head() injected Recent Comment styles
function my_remove_recent_comments_style() {
    global $wp_widget_factory;

    if ( isset( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'] ) ) {
        remove_action( 'wp_head', array(
            $wp_widget_factory->widgets['WP_Widget_Recent_Comments'],
            'recent_comments_style'
        ) );
    }
}

// Pagination for paged posts, Page 1, Page 2, Page 3, with Next and Previous Links, No plugin
function html5wp_pagination() {
    global $wp_query;
    $big = 999999999;
    echo paginate_links( array(
        'base'    => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
        'format'  => '?paged=%#%',
        'current' => max( 1, get_query_var( 'paged' ) ),
        'total'   => $wp_query->max_num_pages,
    ) );
}

// Remove Admin bar
function remove_admin_bar() {
    return false;
}

// Remove 'text/css' from our enqueued stylesheet
function html5_style_remove( $tag ) {
    return preg_replace( '~\s+type=["\'][^"\']++["\']~', '', $tag );
}

// Remove thumbnail width and height dimensions that prevent fluid images in the_thumbnail
function remove_thumbnail_dimensions( $html ) {
    $html = preg_replace( '/(width|height)=\"\d*\"\s/', '', $html );
    return $html;
}

// Custom Gravatar in Settings > Discussion
function html5blankgravatar ( $avatar_defaults ) {
    $myavatar                   = get_template_directory_uri() . '/img/gravatar.jpg';
    $avatar_defaults[$myavatar] = 'Custom Gravatar';
    return $avatar_defaults;
}

/*------------------------------------*\
    Actions + Filters + ShortCodes
\*------------------------------------*/

// Add Actions
add_action( 'wp_enqueue_scripts', 'html5blank_header_scripts' ); // Add Custom Scripts to wp_head
add_action( 'wp_print_scripts', 'html5blank_conditional_scripts' ); // Add Conditional Page Scripts
add_action( 'wp_enqueue_scripts', 'html5blank_styles' ); // Add Theme Stylesheet
add_action( 'init', 'register_html5_menu' ); // Add HTML5 Blank Menu
add_action( 'widgets_init', 'my_remove_recent_comments_style' ); // Remove inline Recent Comment Styles from wp_head()
add_action( 'init', 'html5wp_pagination' ); // Add our HTML5 Pagination

// Remove Actions
remove_action( 'wp_head', 'feed_links_extra', 3 ); // Display the links to the extra feeds such as category feeds
remove_action( 'wp_head', 'feed_links', 2 ); // Display the links to the general feeds: Post and Comment Feed
remove_action( 'wp_head', 'rsd_link' ); // Display the link to the Really Simple Discovery service endpoint, EditURI link
remove_action( 'wp_head', 'wlwmanifest_link' ); // Display the link to the Windows Live Writer manifest file.
remove_action( 'wp_head', 'wp_generator' ); // Display the XHTML generator that is generated on the wp_head hook, WP version
remove_action( 'wp_head', 'rel_canonical' );
remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );

// Add Filters
add_filter( 'avatar_defaults', 'html5blankgravatar' ); // Custom Gravatar in Settings > Discussion
add_filter( 'body_class', 'add_slug_to_body_class' ); // Add slug to body class (Starkers build)
add_filter( 'widget_text', 'do_shortcode' ); // Allow shortcodes in Dynamic Sidebar
add_filter( 'widget_text', 'shortcode_unautop' ); // Remove <p> tags in Dynamic Sidebars (better!)
add_filter( 'wp_nav_menu_args', 'my_wp_nav_menu_args' ); // Remove surrounding <div> from WP Navigation
// add_filter( 'nav_menu_css_class', 'my_css_attributes_filter', 100, 1 ); // Remove Navigation <li> injected classes (Commented out by default)
// add_filter( 'nav_menu_item_id', 'my_css_attributes_filter', 100, 1 ); // Remove Navigation <li> injected ID (Commented out by default)
// add_filter( 'page_css_class', 'my_css_attributes_filter', 100, 1 ); // Remove Navigation <li> Page ID's (Commented out by default)
add_filter( 'the_category', 'remove_category_rel_from_category_list' ); // Remove invalid rel attribute
add_filter( 'the_excerpt', 'shortcode_unautop' ); // Remove auto <p> tags in Excerpt (Manual Excerpts only)
add_filter( 'the_excerpt', 'do_shortcode' ); // Allows Shortcodes to be executed in Excerpt (Manual Excerpts only)
add_filter( 'show_admin_bar', 'remove_admin_bar' ); // Remove Admin bar
add_filter( 'style_loader_tag', 'html5_style_remove' ); // Remove 'text/css' from enqueued stylesheet
add_filter( 'post_thumbnail_html', 'remove_thumbnail_dimensions', 10 ); // Remove width and height dynamic attributes to thumbnails
add_filter( 'post_thumbnail_html', 'remove_width_attribute', 10 ); // Remove width and height dynamic attributes to post images
add_filter( 'image_send_to_editor', 'remove_width_attribute', 10 ); // Remove width and height dynamic attributes to post images

// Remove Filters
remove_filter( 'the_excerpt', 'wpautop' ); // Remove <p> tags from Excerpt altogether

// Shortcodes
add_shortcode( 'html5_shortcode_demo', 'html5_shortcode_demo' ); // You can place [html5_shortcode_demo] in Pages, Posts now.
add_shortcode( 'html5_shortcode_demo_2', 'html5_shortcode_demo_2' ); // Place [html5_shortcode_demo_2] in Pages, Posts now.

/*------------------------------------*\
    ShortCode Functions
\*------------------------------------*/

// Shortcode Demo with Nested Capability
function html5_shortcode_demo( $atts, $content = null ) {
    return '<div class="shortcode-demo">' . do_shortcode( $content ) . '</div>'; // do_shortcode allows for nested Shortcodes
}

// Demo Heading H2 shortcode, allows for nesting within above element. Fully expandable.
function html5_shortcode_demo_2( $atts, $content = null ) {
    return '<h2>' . $content . '</h2>';
}

/*------------------------------------*\
    Create Pages
\*------------------------------------*/

function do_pages_exist() {
    // Home
    if ( get_page_by_title( 'Home' ) == NULL ) create_page( 'Home' );
}
add_action('init', 'do_pages_exist');

function create_page( $name ) {
    $createPage = array(
        'post_title'    => $name,
        'post_content'  => '',
        'post_status'   => 'publish',
        'post_author'   => 1,
        'post_type'     => 'page',
        'post_name'     => $name
    );

    // Insert the post into the database
    wp_insert_post( $createPage );
}

/*------------------------------------*\
    Create Page Templates
\*------------------------------------*/

function create_custom_page_templates() {
    $pages = array(
        array(
            'page' => get_page_by_title('Home'),
            'template' => 'page-home.php'
        ),
        // array(
        //     'page' => get_page_by_title('About'),
        //     'template' => 'page-about.php'
        // ),
    );

    foreach ($pages as $page) {
        if ($page) {
            update_post_meta( $page['page']->ID, '_wp_page_template', $page['template'] );

            if ($page['template'] === 'page-home.php') {
                update_option( 'page_on_front', $page['page']->ID );
                update_option( 'show_on_front', 'page' );
            }
        }
    }
}
add_action('init', 'create_custom_page_templates');

/*------------------------------------*\
    ACF Options Page
\*------------------------------------*/

if ( function_exists('acf_add_options_page') ) {
    acf_add_options_page(array(
        'page_title'    => 'Theme Settings',
        'menu_title'    => 'Theme Settings',
        'menu_slug'     => 'theme-settings',
        'capability'    => 'edit_posts',
        'redirect'      => false
    ));
}

/*------------------------------------*
    Includes
\*------------------------------------*/

// Disable Comments
require_once 'inc/disable-comments.php';

// Custom Functions
require_once 'inc/custom-functions.php';
