<?php
/**
 * Insuffle Academy Theme Customizer
 *
 * @package Insuffle_Academy
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Add postMessage support for site title and description
 */
function insuffle_academy_customize_register( $wp_customize ) {
    $wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
    $wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
    $wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

    if ( isset( $wp_customize->selective_refresh ) ) {
        $wp_customize->selective_refresh->add_partial(
            'blogname',
            array(
                'selector'        => '.nav-logo',
                'render_callback' => 'insuffle_academy_customize_partial_blogname',
            )
        );
        $wp_customize->selective_refresh->add_partial(
            'blogdescription',
            array(
                'selector'        => '.site-description',
                'render_callback' => 'insuffle_academy_customize_partial_blogdescription',
            )
        );
    }

    // ===========================
    // Section: Branding
    // ===========================
    $wp_customize->add_section( 'insuffle_branding', array(
        'title'    => __( 'Insuffle Branding', 'insuffle-academy' ),
        'priority' => 30,
    ) );

    // Logo Emoji
    $wp_customize->add_setting( 'insuffle_logo_emoji', array(
        'default'           => '🎮',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'insuffle_logo_emoji', array(
        'label'    => __( 'Logo Emoji', 'insuffle-academy' ),
        'section'  => 'insuffle_branding',
        'type'     => 'text',
    ) );

    // Footer Emoji
    $wp_customize->add_setting( 'insuffle_footer_emoji', array(
        'default'           => '🎮',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'insuffle_footer_emoji', array(
        'label'    => __( 'Footer Emoji', 'insuffle-academy' ),
        'section'  => 'insuffle_branding',
        'type'     => 'text',
    ) );

    // ===========================
    // Section: Urgence Banner
    // ===========================
    $wp_customize->add_section( 'insuffle_urgence', array(
        'title'    => __( 'Bandeau d\'Urgence', 'insuffle-academy' ),
        'priority' => 40,
    ) );

    // Show Urgence Banner
    $wp_customize->add_setting( 'insuffle_show_urgence_banner', array(
        'default'           => true,
        'sanitize_callback' => 'insuffle_academy_sanitize_checkbox',
    ) );
    $wp_customize->add_control( 'insuffle_show_urgence_banner', array(
        'label'    => __( 'Afficher le bandeau d\'urgence', 'insuffle-academy' ),
        'section'  => 'insuffle_urgence',
        'type'     => 'checkbox',
    ) );

    // Urgence Text
    $wp_customize->add_setting( 'insuffle_urgence_text', array(
        'default'           => __( 'PLACES LIMITÉES : Seulement 16 places par session | Prochaine session bientôt !', 'insuffle-academy' ),
        'sanitize_callback' => 'wp_kses_post',
    ) );
    $wp_customize->add_control( 'insuffle_urgence_text', array(
        'label'    => __( 'Texte du bandeau', 'insuffle-academy' ),
        'section'  => 'insuffle_urgence',
        'type'     => 'textarea',
    ) );

    // ===========================
    // Section: Contact Info
    // ===========================
    $wp_customize->add_section( 'insuffle_contact', array(
        'title'    => __( 'Informations de Contact', 'insuffle-academy' ),
        'priority' => 50,
    ) );

    // Contact Email
    $wp_customize->add_setting( 'insuffle_contact_email', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_email',
    ) );
    $wp_customize->add_control( 'insuffle_contact_email', array(
        'label'    => __( 'Email', 'insuffle-academy' ),
        'section'  => 'insuffle_contact',
        'type'     => 'email',
    ) );

    // Contact Phone
    $wp_customize->add_setting( 'insuffle_contact_phone', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'insuffle_contact_phone', array(
        'label'    => __( 'Téléphone', 'insuffle-academy' ),
        'section'  => 'insuffle_contact',
        'type'     => 'text',
    ) );

    // Website URL
    $wp_customize->add_setting( 'insuffle_website_url', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    $wp_customize->add_control( 'insuffle_website_url', array(
        'label'    => __( 'Site Web', 'insuffle-academy' ),
        'section'  => 'insuffle_contact',
        'type'     => 'url',
    ) );

    // ===========================
    // Section: Social Media
    // ===========================
    $wp_customize->add_section( 'insuffle_social', array(
        'title'    => __( 'Réseaux Sociaux', 'insuffle-academy' ),
        'priority' => 60,
    ) );

    // LinkedIn
    $wp_customize->add_setting( 'insuffle_social_linkedin', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    $wp_customize->add_control( 'insuffle_social_linkedin', array(
        'label'    => __( 'LinkedIn URL', 'insuffle-academy' ),
        'section'  => 'insuffle_social',
        'type'     => 'url',
    ) );

    // Instagram
    $wp_customize->add_setting( 'insuffle_social_instagram', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    $wp_customize->add_control( 'insuffle_social_instagram', array(
        'label'    => __( 'Instagram URL', 'insuffle-academy' ),
        'section'  => 'insuffle_social',
        'type'     => 'url',
    ) );

    // Facebook
    $wp_customize->add_setting( 'insuffle_social_facebook', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    $wp_customize->add_control( 'insuffle_social_facebook', array(
        'label'    => __( 'Facebook URL', 'insuffle-academy' ),
        'section'  => 'insuffle_social',
        'type'     => 'url',
    ) );

    // ===========================
    // Section: Footer
    // ===========================
    $wp_customize->add_section( 'insuffle_footer', array(
        'title'    => __( 'Footer', 'insuffle-academy' ),
        'priority' => 70,
    ) );

    // Certification Text
    $wp_customize->add_setting( 'insuffle_certification_text', array(
        'default'           => 'Certifié Qualiopi',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'insuffle_certification_text', array(
        'label'    => __( 'Texte de Certification', 'insuffle-academy' ),
        'section'  => 'insuffle_footer',
        'type'     => 'text',
    ) );

    // Footer Link: Mentions Légales
    $wp_customize->add_setting( 'insuffle_footer_link_mentions', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    $wp_customize->add_control( 'insuffle_footer_link_mentions', array(
        'label'    => __( 'Lien Mentions Légales', 'insuffle-academy' ),
        'section'  => 'insuffle_footer',
        'type'     => 'url',
    ) );

    // Footer Link: CGV
    $wp_customize->add_setting( 'insuffle_footer_link_cgv', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    $wp_customize->add_control( 'insuffle_footer_link_cgv', array(
        'label'    => __( 'Lien CGV', 'insuffle-academy' ),
        'section'  => 'insuffle_footer',
        'type'     => 'url',
    ) );

    // Footer Link: Politique de Confidentialité
    $wp_customize->add_setting( 'insuffle_footer_link_privacy', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    $wp_customize->add_control( 'insuffle_footer_link_privacy', array(
        'label'    => __( 'Lien Politique de Confidentialité', 'insuffle-academy' ),
        'section'  => 'insuffle_footer',
        'type'     => 'url',
    ) );
}
add_action( 'customize_register', 'insuffle_academy_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 */
function insuffle_academy_customize_partial_blogname() {
    bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 */
function insuffle_academy_customize_partial_blogdescription() {
    bloginfo( 'description' );
}

/**
 * Sanitize checkbox
 */
function insuffle_academy_sanitize_checkbox( $checked ) {
    return ( ( isset( $checked ) && true === $checked ) ? true : false );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function insuffle_academy_customize_preview_js() {
    wp_enqueue_script( 'insuffle-customizer', get_template_directory_uri() . '/assets/js/customizer.js', array( 'customize-preview' ), INSUFFLE_THEME_VERSION, true );
}
add_action( 'customize_preview_init', 'insuffle_academy_customize_preview_js' );
