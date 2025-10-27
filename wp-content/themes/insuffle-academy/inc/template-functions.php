<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Insuffle_Academy
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Adds custom classes to the array of body classes.
 */
function insuffle_academy_body_classes( $classes ) {
    // Adds a class of hfeed to non-singular pages.
    if ( ! is_singular() ) {
        $classes[] = 'hfeed';
    }

    // Adds a class of no-sidebar when there is no sidebar present.
    if ( ! is_active_sidebar( 'sidebar-1' ) ) {
        $classes[] = 'no-sidebar';
    }

    return $classes;
}
add_filter( 'body_class', 'insuffle_academy_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function insuffle_academy_pingback_header() {
    if ( is_singular() && pings_open() ) {
        printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
    }
}
add_action( 'wp_head', 'insuffle_academy_pingback_header' );

/**
 * Add custom menu item class for CTA button
 */
function insuffle_academy_nav_menu_css_class( $classes, $item, $args ) {
    if ( 'primary' === $args->theme_location ) {
        // Check if menu item has 'cta' in custom CSS classes
        if ( in_array( 'cta', $classes ) || in_array( 'nav-cta', $classes ) ) {
            $classes[] = 'nav-cta';
        }
    }
    return $classes;
}
add_filter( 'nav_menu_css_class', 'insuffle_academy_nav_menu_css_class', 10, 3 );
