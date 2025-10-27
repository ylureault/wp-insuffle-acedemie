<?php
/**
 * Custom Header feature
 *
 * @package WP_Insuffle
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Set up the WordPress core custom header feature
 */
function wp_insuffle_custom_header_setup() {
    add_theme_support(
        'custom-header',
        apply_filters(
            'wp_insuffle_custom_header_args',
            array(
                'default-image'      => '',
                'default-text-color' => '1f3a8b',
                'width'              => 1920,
                'height'             => 400,
                'flex-height'        => true,
                'wp-head-callback'   => 'wp_insuffle_header_style',
            )
        )
    );
}
add_action( 'after_setup_theme', 'wp_insuffle_custom_header_setup' );

/**
 * Styles the header image and text displayed on the blog
 */
function wp_insuffle_header_style() {
    $header_text_color = get_header_textcolor();

    if ( get_theme_support( 'custom-header', 'default-text-color' ) === $header_text_color ) {
        return;
    }

    ?>
    <style type="text/css">
        <?php if ( ! display_header_text() ) : ?>
            .site-title,
            .site-description {
                position: absolute;
                clip: rect(1px, 1px, 1px, 1px);
            }
        <?php else : ?>
            .site-title a,
            .site-description {
                color: #<?php echo esc_attr( $header_text_color ); ?>;
            }
        <?php endif; ?>
    </style>
    <?php
}
