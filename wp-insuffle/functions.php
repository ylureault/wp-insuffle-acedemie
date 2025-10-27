<?php
/**
 * WP Insuffle Theme Functions
 *
 * @package WP_Insuffle
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
 * Theme Setup
 */
function wp_insuffle_setup() {
    // Add default posts and comments RSS feed links to head
    add_theme_support( 'automatic-feed-links' );

    // Let WordPress manage the document title
    add_theme_support( 'title-tag' );

    // Enable support for Post Thumbnails
    add_theme_support( 'post-thumbnails' );
    set_post_thumbnail_size( 1200, 630, true ); // 1200x630 for social sharing
    add_image_size( 'wp-insuffle-card', 600, 400, true );
    add_image_size( 'wp-insuffle-hero', 1920, 800, true );

    // Register navigation menus
    register_nav_menus( array(
        'primary' => __( 'Menu Principal', 'wp-insuffle' ),
        'footer'  => __( 'Menu Footer', 'wp-insuffle' ),
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

    // Add support for Block Styles (Gutenberg)
    add_theme_support( 'wp-block-styles' );

    // Add support for full and wide align images (Gutenberg)
    add_theme_support( 'align-wide' );

    // Add support for editor styles (Gutenberg)
    add_theme_support( 'editor-styles' );

    // Add support for responsive embedded content (Gutenberg)
    add_theme_support( 'responsive-embeds' );

    // Add custom editor font sizes (Gutenberg)
    add_theme_support( 'editor-font-sizes', array(
        array(
            'name' => __( 'Petit', 'wp-insuffle' ),
            'size' => 14,
            'slug' => 'small',
        ),
        array(
            'name' => __( 'Normal', 'wp-insuffle' ),
            'size' => 16,
            'slug' => 'normal',
        ),
        array(
            'name' => __( 'Moyen', 'wp-insuffle' ),
            'size' => 20,
            'slug' => 'medium',
        ),
        array(
            'name' => __( 'Grand', 'wp-insuffle' ),
            'size' => 28,
            'slug' => 'large',
        ),
        array(
            'name' => __( 'Très Grand', 'wp-insuffle' ),
            'size' => 40,
            'slug' => 'huge',
        ),
    ) );

    // Add support for custom color palette (Gutenberg & Central Color Palette plugin)
    add_theme_support( 'editor-color-palette', array(
        array(
            'name'  => __( 'Insuffle Primaire', 'wp-insuffle' ),
            'slug'  => 'insuffle-primary',
            'color' => '#1f3a8b',
        ),
        array(
            'name'  => __( 'Insuffle Secondaire', 'wp-insuffle' ),
            'slug'  => 'insuffle-secondary',
            'color' => '#FFD466',
        ),
        array(
            'name'  => __( 'Insuffle Accent', 'wp-insuffle' ),
            'slug'  => 'insuffle-accent',
            'color' => '#5a7fc7',
        ),
        array(
            'name'  => __( 'Blanc', 'wp-insuffle' ),
            'slug'  => 'white',
            'color' => '#FFFFFF',
        ),
        array(
            'name'  => __( 'Gris Clair', 'wp-insuffle' ),
            'slug'  => 'grey-light',
            'color' => '#F5F5F5',
        ),
        array(
            'name'  => __( 'Gris Foncé', 'wp-insuffle' ),
            'slug'  => 'grey-dark',
            'color' => '#333333',
        ),
        array(
            'name'  => __( 'Succès', 'wp-insuffle' ),
            'slug'  => 'success',
            'color' => '#4caf50',
        ),
        array(
            'name'  => __( 'Alerte', 'wp-insuffle' ),
            'slug'  => 'warning',
            'color' => '#ff9800',
        ),
        array(
            'name'  => __( 'Erreur', 'wp-insuffle' ),
            'slug'  => 'error',
            'color' => '#f44336',
        ),
        array(
            'name'  => __( 'Info', 'wp-insuffle' ),
            'slug'  => 'info',
            'color' => '#2196f3',
        ),
        array(
            'name'  => __( 'Or', 'wp-insuffle' ),
            'slug'  => 'gold',
            'color' => '#ffd700',
        ),
    ) );

    // Disable custom colors in Gutenberg (use only theme colors)
    add_theme_support( 'disable-custom-colors' );

    // Add support for custom line height
    add_theme_support( 'custom-line-height' );

    // Add support for custom spacing
    add_theme_support( 'custom-spacing' );

    // Add support for custom units
    add_theme_support( 'custom-units', 'px', 'rem', 'em', 'vh', 'vw' );

    // Add support for link color
    add_theme_support( 'link-color' );
}
add_action( 'after_setup_theme', 'wp_insuffle_setup' );

/**
 * Set the content width in pixels
 */
function wp_insuffle_content_width() {
    $GLOBALS['content_width'] = apply_filters( 'wp_insuffle_content_width', 1200 );
}
add_action( 'after_setup_theme', 'wp_insuffle_content_width', 0 );

/**
 * Register Widget Areas
 */
function wp_insuffle_widgets_init() {
    register_sidebar( array(
        'name'          => __( 'Sidebar Principal', 'wp-insuffle' ),
        'id'            => 'sidebar-1',
        'description'   => __( 'Zone de widgets pour la sidebar principale', 'wp-insuffle' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );

    register_sidebar( array(
        'name'          => __( 'Footer Zone 1', 'wp-insuffle' ),
        'id'            => 'footer-1',
        'description'   => __( 'Zone de widgets pour le footer (colonne 1)', 'wp-insuffle' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );

    register_sidebar( array(
        'name'          => __( 'Footer Zone 2', 'wp-insuffle' ),
        'id'            => 'footer-2',
        'description'   => __( 'Zone de widgets pour le footer (colonne 2)', 'wp-insuffle' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );

    register_sidebar( array(
        'name'          => __( 'Footer Zone 3', 'wp-insuffle' ),
        'id'            => 'footer-3',
        'description'   => __( 'Zone de widgets pour le footer (colonne 3)', 'wp-insuffle' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );

    register_sidebar( array(
        'name'          => __( 'Footer Zone 4', 'wp-insuffle' ),
        'id'            => 'footer-4',
        'description'   => __( 'Zone de widgets pour le footer (colonne 4)', 'wp-insuffle' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );
}
add_action( 'widgets_init', 'wp_insuffle_widgets_init' );

/**
 * Enqueue Scripts and Styles
 */
function wp_insuffle_scripts() {
    // Google Fonts
    wp_enqueue_style(
        'wp-insuffle-fonts',
        'https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;800&family=Press+Start+2P&display=swap',
        array(),
        null
    );

    // Main stylesheet
    wp_enqueue_style(
        'wp-insuffle-style',
        get_stylesheet_uri(),
        array(),
        wp_get_theme()->get( 'Version' )
    );

    // Additional CSS file if needed
    if ( file_exists( get_template_directory() . '/assets/css/custom.css' ) ) {
        wp_enqueue_style(
            'wp-insuffle-custom',
            get_template_directory_uri() . '/assets/css/custom.css',
            array( 'wp-insuffle-style' ),
            wp_get_theme()->get( 'Version' )
        );
    }

    // Main JavaScript
    wp_enqueue_script(
        'wp-insuffle-script',
        get_template_directory_uri() . '/assets/js/main.js',
        array( 'jquery' ),
        wp_get_theme()->get( 'Version' ),
        true
    );

    // Smooth scroll script
    wp_enqueue_script(
        'wp-insuffle-smooth-scroll',
        get_template_directory_uri() . '/assets/js/smooth-scroll.js',
        array(),
        wp_get_theme()->get( 'Version' ),
        true
    );

    // Localize script for AJAX
    wp_localize_script( 'wp-insuffle-script', 'wpInsuffleAjax', array(
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'nonce'   => wp_create_nonce( 'wp-insuffle-nonce' ),
    ) );

    // Comments reply script
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'wp_insuffle_scripts' );

/**
 * Enqueue Block Editor Assets
 */
function wp_insuffle_editor_assets() {
    // Editor styles
    wp_enqueue_style(
        'wp-insuffle-editor-style',
        get_template_directory_uri() . '/assets/css/editor-style.css',
        array(),
        wp_get_theme()->get( 'Version' )
    );

    // Google Fonts in editor
    wp_enqueue_style(
        'wp-insuffle-editor-fonts',
        'https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;800&family=Press+Start+2P&display=swap',
        array(),
        null
    );
}
add_action( 'enqueue_block_editor_assets', 'wp_insuffle_editor_assets' );

/**
 * Performance Optimizations
 */

// Remove jQuery Migrate
function wp_insuffle_remove_jquery_migrate( $scripts ) {
    if ( ! is_admin() && isset( $scripts->registered['jquery'] ) ) {
        $script = $scripts->registered['jquery'];
        if ( $script->deps ) {
            $script->deps = array_diff( $script->deps, array( 'jquery-migrate' ) );
        }
    }
}
add_action( 'wp_default_scripts', 'wp_insuffle_remove_jquery_migrate' );

// Defer JavaScript loading
function wp_insuffle_defer_scripts( $tag, $handle, $src ) {
    $defer_scripts = array( 'wp-insuffle-script', 'wp-insuffle-smooth-scroll' );

    if ( in_array( $handle, $defer_scripts ) ) {
        return '<script src="' . $src . '" defer></script>' . "\n";
    }

    return $tag;
}
add_filter( 'script_loader_tag', 'wp_insuffle_defer_scripts', 10, 3 );

// Add preconnect for Google Fonts
function wp_insuffle_resource_hints( $urls, $relation_type ) {
    if ( 'preconnect' === $relation_type ) {
        $urls[] = array(
            'href' => 'https://fonts.googleapis.com',
            'crossorigin',
        );
        $urls[] = array(
            'href' => 'https://fonts.gstatic.com',
            'crossorigin',
        );
    }
    return $urls;
}
add_filter( 'wp_resource_hints', 'wp_insuffle_resource_hints', 10, 2 );

// Remove WordPress version from head
remove_action( 'wp_head', 'wp_generator' );

// Remove WLW Manifest
remove_action( 'wp_head', 'wlwmanifest_link' );

// Remove RSD Link
remove_action( 'wp_head', 'rsd_link' );

// Remove Shortlink
remove_action( 'wp_head', 'wp_shortlink_wp_head' );

// Disable embeds (if not needed)
function wp_insuffle_disable_embeds() {
    if ( ! is_admin() ) {
        wp_dequeue_script( 'wp-embed' );
    }
}
add_action( 'wp_footer', 'wp_insuffle_disable_embeds' );

/**
 * Plugin Compatibility & Integrations
 */

// Contact Form 7 - Remove default styles and scripts, load only on pages with forms
function wp_insuffle_cf7_conditional_load() {
    if ( ! is_page() || ! has_shortcode( get_post()->post_content, 'contact-form-7' ) ) {
        wp_dequeue_style( 'contact-form-7' );
        wp_dequeue_script( 'contact-form-7' );
    }
}
add_action( 'wp_enqueue_scripts', 'wp_insuffle_cf7_conditional_load', 20 );

// Rank Math SEO - Breadcrumbs support
function wp_insuffle_breadcrumbs() {
    if ( function_exists( 'rank_math_the_breadcrumbs' ) ) {
        rank_math_the_breadcrumbs();
    }
}

// Advanced WordPress Backgrounds - Add theme support
add_theme_support( 'awb-backgrounds' );

// Twentig - Add compatibility
add_theme_support( 'twentig' );

// Redux Framework - Integrate if needed
if ( class_exists( 'Redux' ) ) {
    require_once get_template_directory() . '/inc/redux-config.php';
}

// Central Color Palette - Register theme colors
function wp_insuffle_central_color_palette( $colors ) {
    return array(
        array(
            'name'  => 'Insuffle Primaire',
            'slug'  => 'insuffle-primary',
            'color' => '#1f3a8b',
        ),
        array(
            'name'  => 'Insuffle Secondaire',
            'slug'  => 'insuffle-secondary',
            'color' => '#FFD466',
        ),
        array(
            'name'  => 'Insuffle Accent',
            'slug'  => 'insuffle-accent',
            'color' => '#5a7fc7',
        ),
        array(
            'name'  => 'Blanc',
            'slug'  => 'white',
            'color' => '#FFFFFF',
        ),
        array(
            'name'  => 'Gris',
            'slug'  => 'grey',
            'color' => '#F5F5F5',
        ),
        array(
            'name'  => 'Noir',
            'slug'  => 'black',
            'color' => '#333333',
        ),
    );
}
add_filter( 'central_color_palette_colors', 'wp_insuffle_central_color_palette' );

// YARPP - Custom template filter
function wp_insuffle_yarpp_template( $template ) {
    $custom_template = get_template_directory() . '/template-parts/yarpp-template.php';
    if ( file_exists( $custom_template ) ) {
        return $custom_template;
    }
    return $template;
}
add_filter( 'yarpp_get_template', 'wp_insuffle_yarpp_template' );

/**
 * Custom Excerpt Length
 */
function wp_insuffle_excerpt_length( $length ) {
    return 30;
}
add_filter( 'excerpt_length', 'wp_insuffle_excerpt_length' );

/**
 * Custom Excerpt More
 */
function wp_insuffle_excerpt_more( $more ) {
    return '...';
}
add_filter( 'excerpt_more', 'wp_insuffle_excerpt_more' );

/**
 * Add body classes
 */
function wp_insuffle_body_classes( $classes ) {
    // Add class if sidebar is active
    if ( is_active_sidebar( 'sidebar-1' ) ) {
        $classes[] = 'has-sidebar';
    } else {
        $classes[] = 'no-sidebar';
    }

    // Add class for page templates
    if ( is_page_template() ) {
        $classes[] = 'page-template';
    }

    // Add class for singular posts
    if ( is_singular() ) {
        $classes[] = 'singular';
    }

    return $classes;
}
add_filter( 'body_class', 'wp_insuffle_body_classes' );

/**
 * Custom Logo Support
 */
function wp_insuffle_custom_logo_setup() {
    add_theme_support( 'custom-logo', array(
        'height'      => 100,
        'width'       => 300,
        'flex-height' => true,
        'flex-width'  => true,
        'header-text' => array( 'site-title', 'site-description' ),
    ) );
}
add_action( 'after_setup_theme', 'wp_insuffle_custom_logo_setup' );

/**
 * Schema.org Structured Data for SEO
 */
function wp_insuffle_schema_organization() {
    if ( ! is_front_page() ) {
        return;
    }

    $schema = array(
        '@context' => 'https://schema.org',
        '@type'    => 'Organization',
        'name'     => get_bloginfo( 'name' ),
        'url'      => home_url(),
        'logo'     => array(
            '@type' => 'ImageObject',
            'url'   => get_theme_mod( 'custom_logo' ) ? wp_get_attachment_url( get_theme_mod( 'custom_logo' ) ) : '',
        ),
        'address'  => array(
            '@type'           => 'PostalAddress',
            'streetAddress'   => '410 RUE DE LA PRINCESSE TROUBETSKOI',
            'addressLocality' => 'Deauville',
            'postalCode'      => '14800',
            'addressCountry'  => 'FR',
        ),
        'telephone'      => '+33980808962',
        'email'          => 'contact@insuffle-academie.com',
        'sameAs'         => array(),
    );

    echo '<script type="application/ld+json">' . wp_json_encode( $schema ) . '</script>' . "\n";
}
add_action( 'wp_head', 'wp_insuffle_schema_organization' );

/**
 * Security Enhancements
 */

// Remove WordPress version from RSS
function wp_insuffle_remove_version_rss() {
    return '';
}
add_filter( 'the_generator', 'wp_insuffle_remove_version_rss' );

// Disable XML-RPC
add_filter( 'xmlrpc_enabled', '__return_false' );

// Remove WordPress version from scripts and styles
function wp_insuffle_remove_version_from_assets( $src ) {
    if ( strpos( $src, 'ver=' . get_bloginfo( 'version' ) ) ) {
        $src = remove_query_arg( 'ver', $src );
    }
    return $src;
}
add_filter( 'style_loader_src', 'wp_insuffle_remove_version_from_assets', 9999 );
add_filter( 'script_loader_src', 'wp_insuffle_remove_version_from_assets', 9999 );

/**
 * Custom Functions
 */

// Get reading time
function wp_insuffle_reading_time() {
    $content = get_post_field( 'post_content', get_the_ID() );
    $word_count = str_word_count( strip_tags( $content ) );
    $reading_time = ceil( $word_count / 200 );

    return sprintf(
        _n( '%s minute de lecture', '%s minutes de lecture', $reading_time, 'wp-insuffle' ),
        $reading_time
    );
}

// Check if page has blocks
function wp_insuffle_has_blocks() {
    if ( function_exists( 'has_blocks' ) ) {
        return has_blocks();
    }
    return false;
}

/**
 * Customizer Settings
 */
require_once get_template_directory() . '/inc/customizer.php';

/**
 * Template Tags
 */
require_once get_template_directory() . '/inc/template-tags.php';

/**
 * Custom Header
 */
require_once get_template_directory() . '/inc/custom-header.php';

/**
 * Navigation Walker (for mobile menu)
 */
if ( file_exists( get_template_directory() . '/inc/class-nav-walker.php' ) ) {
    require_once get_template_directory() . '/inc/class-nav-walker.php';
}
