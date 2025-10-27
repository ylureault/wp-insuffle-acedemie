<?php
/**
 * Insuffle Academy Theme Functions
 *
 * @package Insuffle_Academy
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

// Theme constants
define( 'INSUFFLE_THEME_VERSION', '1.0.0' );
define( 'INSUFFLE_THEME_DIR', get_template_directory() );
define( 'INSUFFLE_THEME_URI', get_template_directory_uri() );

/**
 * Theme Setup
 */
function insuffle_academy_setup() {
    // Add default posts and comments RSS feed links to head
    add_theme_support( 'automatic-feed-links' );

    // Let WordPress manage the document title
    add_theme_support( 'title-tag' );

    // Enable support for Post Thumbnails
    add_theme_support( 'post-thumbnails' );

    // Add custom image sizes
    add_image_size( 'insuffle-hero', 1920, 1080, true );
    add_image_size( 'insuffle-card', 800, 600, true );
    add_image_size( 'insuffle-avatar', 200, 200, true );

    // Register navigation menus
    register_nav_menus( array(
        'primary' => __( 'Menu Principal', 'insuffle-academy' ),
        'footer'  => __( 'Menu Footer', 'insuffle-academy' ),
    ) );

    // Switch default core markup to output valid HTML5
    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ) );

    // Add theme support for selective refresh for widgets
    add_theme_support( 'customize-selective-refresh-widgets' );

    // Add support for custom background
    add_theme_support( 'custom-background', array(
        'default-color' => 'ffffff',
    ) );

    // Add support for custom logo
    add_theme_support( 'custom-logo', array(
        'height'      => 100,
        'width'       => 400,
        'flex-height' => true,
        'flex-width'  => true,
    ) );

    // Add support for editor styles
    add_theme_support( 'editor-styles' );
    add_editor_style( 'assets/css/editor-style.css' );

    // Add support for responsive embeds
    add_theme_support( 'responsive-embeds' );

    // Add support for wide alignment
    add_theme_support( 'align-wide' );

    // Add support for block styles
    add_theme_support( 'wp-block-styles' );

    // Add support for full and wide align images
    add_theme_support( 'align-full' );
    add_theme_support( 'align-wide' );
}
add_action( 'after_setup_theme', 'insuffle_academy_setup' );

/**
 * Set the content width in pixels
 */
function insuffle_academy_content_width() {
    $GLOBALS['content_width'] = apply_filters( 'insuffle_academy_content_width', 1200 );
}
add_action( 'after_setup_theme', 'insuffle_academy_content_width', 0 );

/**
 * Enqueue scripts and styles
 */
function insuffle_academy_scripts() {
    // Google Fonts
    wp_enqueue_style(
        'insuffle-google-fonts',
        'https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800;900&family=Press+Start+2P&display=swap',
        array(),
        null
    );

    // Main stylesheet
    wp_enqueue_style(
        'insuffle-main-style',
        INSUFFLE_THEME_URI . '/assets/css/main.css',
        array(),
        INSUFFLE_THEME_VERSION
    );

    // Theme stylesheet (for WordPress metadata)
    wp_enqueue_style(
        'insuffle-style',
        get_stylesheet_uri(),
        array( 'insuffle-main-style' ),
        INSUFFLE_THEME_VERSION
    );

    // Main JavaScript
    wp_enqueue_script(
        'insuffle-main-js',
        INSUFFLE_THEME_URI . '/assets/js/main.js',
        array(),
        INSUFFLE_THEME_VERSION,
        true
    );

    // Smooth scroll and animations
    wp_enqueue_script(
        'insuffle-animations',
        INSUFFLE_THEME_URI . '/assets/js/animations.js',
        array(),
        INSUFFLE_THEME_VERSION,
        true
    );

    // Comment reply script
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'insuffle_academy_scripts' );

/**
 * Register widget areas
 */
function insuffle_academy_widgets_init() {
    register_sidebar( array(
        'name'          => __( 'Sidebar', 'insuffle-academy' ),
        'id'            => 'sidebar-1',
        'description'   => __( 'Add widgets here to appear in your sidebar.', 'insuffle-academy' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );

    register_sidebar( array(
        'name'          => __( 'Footer 1', 'insuffle-academy' ),
        'id'            => 'footer-1',
        'description'   => __( 'Footer widget area 1', 'insuffle-academy' ),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="footer-widget-title">',
        'after_title'   => '</h3>',
    ) );

    register_sidebar( array(
        'name'          => __( 'Footer 2', 'insuffle-academy' ),
        'id'            => 'footer-2',
        'description'   => __( 'Footer widget area 2', 'insuffle-academy' ),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="footer-widget-title">',
        'after_title'   => '</h3>',
    ) );

    register_sidebar( array(
        'name'          => __( 'Footer 3', 'insuffle-academy' ),
        'id'            => 'footer-3',
        'description'   => __( 'Footer widget area 3', 'insuffle-academy' ),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="footer-widget-title">',
        'after_title'   => '</h3>',
    ) );

    register_sidebar( array(
        'name'          => __( 'Footer 4', 'insuffle-academy' ),
        'id'            => 'footer-4',
        'description'   => __( 'Footer widget area 4', 'insuffle-academy' ),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="footer-widget-title">',
        'after_title'   => '</h3>',
    ) );
}
add_action( 'widgets_init', 'insuffle_academy_widgets_init' );

/**
 * Include required files
 */
require_once INSUFFLE_THEME_DIR . '/inc/customizer.php';
require_once INSUFFLE_THEME_DIR . '/inc/template-functions.php';
require_once INSUFFLE_THEME_DIR . '/inc/blocks-registration.php';

/**
 * Custom template tags for this theme
 */
require_once INSUFFLE_THEME_DIR . '/inc/template-tags.php';
