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
    // Ensure $categories is an array
    if ( ! is_array( $categories ) ) {
        $categories = array();
    }

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

    // Verify block directory exists before registering
    $hero_block_path = INSUFFLE_THEME_DIR . '/blocks/hero';
    if ( file_exists( $hero_block_path . '/block.json' ) ) {
        register_block_type( $hero_block_path, array(
            'render_callback' => 'insuffle_academy_render_hero_block',
        ) );
    }
}
add_action( 'init', 'insuffle_academy_register_blocks' );

/**
 * Hero Block render callback
 */
function insuffle_academy_render_hero_block( $attributes, $content ) {
    // Ensure $attributes is an array
    if ( ! is_array( $attributes ) ) {
        $attributes = array();
    }

    $render_file = INSUFFLE_THEME_DIR . '/blocks/hero/render.php';
    if ( ! file_exists( $render_file ) ) {
        return '';
    }

    ob_start();
    include $render_file;
    return ob_get_clean();
}

/**
 * Enqueue block editor assets
 */
function insuffle_academy_block_editor_assets() {
    // Verify file exists before enqueuing
    $editor_style_path = INSUFFLE_THEME_DIR . '/assets/css/editor-style.css';
    if ( file_exists( $editor_style_path ) ) {
        wp_enqueue_style(
            'insuffle-block-editor-styles',
            INSUFFLE_THEME_URI . '/assets/css/editor-style.css',
            array(),
            INSUFFLE_THEME_VERSION
        );
    }
}
add_action( 'enqueue_block_editor_assets', 'insuffle_academy_block_editor_assets' );
