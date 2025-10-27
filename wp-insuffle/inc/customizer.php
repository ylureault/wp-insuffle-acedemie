<?php
/**
 * WP Insuffle Theme Customizer
 *
 * @package WP_Insuffle
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Add postMessage support for site title and description
 */
function wp_insuffle_customize_register( $wp_customize ) {
    $wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
    $wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
    $wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

    if ( isset( $wp_customize->selective_refresh ) ) {
        $wp_customize->selective_refresh->add_partial(
            'blogname',
            array(
                'selector'        => '.site-title a',
                'render_callback' => 'wp_insuffle_customize_partial_blogname',
            )
        );
        $wp_customize->selective_refresh->add_partial(
            'blogdescription',
            array(
                'selector'        => '.site-description',
                'render_callback' => 'wp_insuffle_customize_partial_blogdescription',
            )
        );
    }

    // Add Insuffle Color Settings
    $wp_customize->add_section(
        'insuffle_colors',
        array(
            'title'    => __( 'Couleurs Insuffle', 'wp-insuffle' ),
            'priority' => 40,
        )
    );

    // Primary Color
    $wp_customize->add_setting(
        'insuffle_primary_color',
        array(
            'default'           => '#1f3a8b',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'refresh',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'insuffle_primary_color',
            array(
                'label'    => __( 'Couleur Primaire', 'wp-insuffle' ),
                'section'  => 'insuffle_colors',
                'settings' => 'insuffle_primary_color',
            )
        )
    );

    // Secondary Color
    $wp_customize->add_setting(
        'insuffle_secondary_color',
        array(
            'default'           => '#FFD466',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'refresh',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'insuffle_secondary_color',
            array(
                'label'    => __( 'Couleur Secondaire', 'wp-insuffle' ),
                'section'  => 'insuffle_colors',
                'settings' => 'insuffle_secondary_color',
            )
        )
    );

    // Footer Settings
    $wp_customize->add_section(
        'insuffle_footer',
        array(
            'title'    => __( 'Footer', 'wp-insuffle' ),
            'priority' => 120,
        )
    );

    $wp_customize->add_setting(
        'insuffle_footer_text',
        array(
            'default'           => '',
            'sanitize_callback' => 'wp_kses_post',
            'transport'         => 'refresh',
        )
    );

    $wp_customize->add_control(
        'insuffle_footer_text',
        array(
            'label'    => __( 'Texte du Footer', 'wp-insuffle' ),
            'section'  => 'insuffle_footer',
            'type'     => 'textarea',
            'settings' => 'insuffle_footer_text',
        )
    );
}
add_action( 'customize_register', 'wp_insuffle_customize_register' );

/**
 * Render the site title for the selective refresh partial
 */
function wp_insuffle_customize_partial_blogname() {
    bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial
 */
function wp_insuffle_customize_partial_blogdescription() {
    bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously
 */
function wp_insuffle_customize_preview_js() {
    wp_enqueue_script(
        'wp-insuffle-customizer',
        get_template_directory_uri() . '/assets/js/customizer.js',
        array( 'customize-preview' ),
        wp_get_theme()->get( 'Version' ),
        true
    );
}
add_action( 'customize_preview_init', 'wp_insuffle_customize_preview_js' );

/**
 * Output custom CSS for colors
 */
function wp_insuffle_customizer_css() {
    $primary_color   = get_theme_mod( 'insuffle_primary_color', '#1f3a8b' );
    $secondary_color = get_theme_mod( 'insuffle_secondary_color', '#FFD466' );

    ?>
    <style type="text/css">
        :root {
            --insuffle-primary: <?php echo esc_attr( $primary_color ); ?>;
            --insuffle-secondary: <?php echo esc_attr( $secondary_color ); ?>;
        }
    </style>
    <?php
}
add_action( 'wp_head', 'wp_insuffle_customizer_css' );
