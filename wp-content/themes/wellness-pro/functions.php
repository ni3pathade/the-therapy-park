<?php
/**
 * Wellness Pro Theme Functions
 */

// Include sub-modules
require_once get_template_directory() . '/inc/custom-post-types.php';
require_once get_template_directory() . '/inc/ajax-handlers.php';
require_once get_template_directory() . '/inc/customizer.php';

/**
 * Enqueue assets
 */
function wellness_pro_assets() {
    $ver = wp_get_theme()->get( 'Version' );

    // Google Fonts
    wp_enqueue_style(
        'wellness-pro-fonts',
        'https://fonts.googleapis.com/css2?family=Zen+Old+Mincho:wght@400;600;700&family=Open+Sans:wght@400;500;600&display=swap',
        array(), null
    );

    // Main stylesheet
    wp_enqueue_style( 'wellness-pro-style', get_stylesheet_uri(), array(), $ver );

    // Main CSS
    wp_enqueue_style(
        'wellness-pro-main',
        get_template_directory_uri() . '/assets/css/main.css',
        array( 'wellness-pro-style' ), $ver
    );

    // Main JS
    wp_enqueue_script(
        'wellness-pro-script',
        get_template_directory_uri() . '/assets/js/main.js',
        array(), $ver, true
    );

    wp_localize_script( 'wellness-pro-script', 'wellnessPro', array(
        'ajaxUrl'        => admin_url( 'admin-ajax.php' ),
        'nonce'          => wp_create_nonce( 'wellness-pro-nonce' ),
        'filterAction'    => 'wellness_filter_posts',
        'loadMoreAction'  => 'wellness_load_more',
        'subscribeAction' => 'wellness_subscribe',
    ) );
}
add_action( 'wp_enqueue_scripts', 'wellness_pro_assets' );

/**
 * Theme setup
 */
function wellness_pro_setup() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', array( 'search-form','comment-form','comment-list','gallery','caption','style','script' ) );
    add_theme_support( 'responsive-embeds' );
    add_theme_support( 'custom-logo', array(
        'height'      => 60,
        'width'       => 200,
        'flex-height' => true,
        'flex-width'  => true,
    ) );

    register_nav_menus( array(
        'primary' => __( 'Primary Menu', 'wellness-pro' ),
        'footer'  => __( 'Footer Menu', 'wellness-pro' ),
    ) );

    add_image_size( 'wellness-hero',      1920, 700, true );
    add_image_size( 'wellness-card',       600, 400, true );
    add_image_size( 'wellness-thumbnail',  150, 150, true );
    add_image_size( 'wellness-team',       400, 480, true );
}
add_action( 'after_setup_theme', 'wellness_pro_setup' );

/**
 * Register sidebars
 */
function wellness_pro_sidebars() {
    register_sidebar( array(
        'name'          => __( 'Blog Sidebar', 'wellness-pro' ),
        'id'            => 'blog-sidebar',
        'before_widget' => '<div id="%1$s" class="sidebar-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="sidebar-widget__title">',
        'after_title'   => '</h3>',
    ) );
    register_sidebar( array(
        'name'          => __( 'Footer Widgets', 'wellness-pro' ),
        'id'            => 'footer-1',
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="footer-widget__title">',
        'after_title'   => '</h4>',
    ) );
}
add_action( 'widgets_init', 'wellness_pro_sidebars' );

/**
 * Helper: related posts by category
 */
function wellness_pro_related_posts( $post_id, $count = 3 ) {
    $cats = wp_get_post_categories( $post_id, array( 'fields' => 'ids' ) );
    $args = array(
        'post_type'      => 'post',
        'posts_per_page' => $count,
        'post__not_in'   => array( $post_id ),
        'post_status'    => 'publish',
        'orderby'        => 'rand',
    );
    if ( ! empty( $cats ) ) $args['category__in'] = $cats;
    return new WP_Query( $args );
}

/**
 * Allow SVG uploads in WordPress media library
 */
// Step 1: Add SVG to allowed mime types
add_filter( 'upload_mimes', function( $mimes ) {
    $mimes['svg']  = 'image/svg+xml';
    $mimes['svgz'] = 'image/svg+xml';
    return $mimes;
} );

// Step 2: Fix file type verification using extension (bypasses finfo detection issues)
add_filter( 'wp_check_filetype_and_ext', function( $data, $file, $filename, $mimes ) {
    $ext = strtolower( pathinfo( $filename, PATHINFO_EXTENSION ) );
    if ( 'svg' === $ext || 'svgz' === $ext ) {
        $data['ext']  = $ext;
        $data['type'] = 'image/svg+xml';
    }
    return $data;
}, 10, 4 );

// Step 3: Prevent SVG image processing error (GD/Imagick can't handle SVG)
add_filter( 'wp_generate_attachment_metadata', function( $metadata, $attachment_id ) {
    if ( 'image/svg+xml' === get_post_mime_type( $attachment_id ) ) {
        $svg = get_attached_file( $attachment_id );
        $w = 800; $h = 600;
        if ( $svg && file_exists( $svg ) ) {
            $xml = @simplexml_load_file( $svg );
            if ( $xml ) {
                $attr = $xml->attributes();
                $vb   = isset( $attr->viewBox ) ? preg_split( '/[\s,]+/', (string) $attr->viewBox ) : null;
                $w    = isset( $attr->width )  ? (int) $attr->width  : ( $vb ? (int) $vb[2] : 800 );
                $h    = isset( $attr->height ) ? (int) $attr->height : ( $vb ? (int) $vb[3] : 600 );
            }
        }
        $metadata['width']  = $w;
        $metadata['height'] = $h;
    }
    return $metadata;
}, 10, 2 );

/**
 * Fallback nav menu
 */
function wellness_pro_fallback_menu() {
    echo '<ul>';
    echo '<li><a href="' . esc_url( home_url('/') ) . '">Home</a></li>';
    echo '<li><a href="#">About Us</a></li>';
    echo '<li><a href="#">Services</a></li>';
    echo '<li><a href="' . esc_url( get_permalink( get_option('page_for_posts') ) ) . '">Blogs</a></li>';
    echo '</ul>';
}
