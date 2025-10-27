<?php
/**
 * Block Registration and Management
 *
 * @package Insuffle_Academy
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Register custom block categories
 */
function insuffle_academy_block_categories( $categories ) {
    return array_merge(
        $categories,
        array(
            array(
                'slug'  => 'insuffle-blocks',
                'title' => __( 'Insuffle Academy', 'insuffle-academy' ),
                'icon'  => 'welcome-learn-more',
            ),
        )
    );
}
add_filter( 'block_categories_all', 'insuffle_academy_block_categories', 10, 1 );

/**
 * Register custom blocks
 */
function insuffle_academy_register_blocks() {
    // Check if Gutenberg is active
    if ( ! function_exists( 'register_block_type' ) ) {
        return;
    }

    // Register Hero Block
    register_block_type( INSUFFLE_THEME_DIR . '/blocks/hero', array(
        'render_callback' => 'insuffle_academy_render_hero_block',
    ) );
}
add_action( 'init', 'insuffle_academy_register_blocks' );

/**
 * Hero Block render callback
 */
function insuffle_academy_render_hero_block( $attributes, $content ) {
    ob_start();
    include INSUFFLE_THEME_DIR . '/blocks/hero/render.php';
    return ob_get_clean();
}

/**
 * Enqueue block editor assets
 */
function insuffle_academy_block_editor_assets() {
    wp_enqueue_style(
        'insuffle-block-editor-styles',
        INSUFFLE_THEME_URI . '/assets/css/editor-style.css',
        array(),
        INSUFFLE_THEME_VERSION
    );
}
add_action( 'enqueue_block_editor_assets', 'insuffle_academy_block_editor_assets' );
