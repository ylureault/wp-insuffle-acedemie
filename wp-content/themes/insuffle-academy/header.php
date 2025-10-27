<?php
/**
 * The header for our theme
 *
 * @package Insuffle_Academy
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'insuffle-academy' ); ?></a>

    <!-- Navigation -->
    <nav id="site-navigation" class="main-navigation" role="navigation">
        <div class="container">
            <div class="nav-container">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="nav-logo">
                    <?php
                    if ( has_custom_logo() ) {
                        the_custom_logo();
                    } else {
                        ?>
                        <span><?php echo esc_html( get_theme_mod( 'insuffle_logo_emoji', '🎮' ) ); ?></span>
                        <span><?php bloginfo( 'name' ); ?></span>
                        <?php
                    }
                    ?>
                </a>

                <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
                    <span class="screen-reader-text"><?php esc_html_e( 'Menu', 'insuffle-academy' ); ?></span>
                    <span>☰</span>
                </button>

                <?php
                wp_nav_menu(
                    array(
                        'theme_location' => 'primary',
                        'menu_id'        => 'primary-menu',
                        'menu_class'     => 'nav-menu',
                        'container'      => false,
                        'fallback_cb'    => false,
                    )
                );
                ?>
            </div>
        </div>
    </nav><!-- #site-navigation -->

    <?php
    // Display urgence banner if enabled in customizer
    if ( get_theme_mod( 'insuffle_show_urgence_banner', true ) ) :
        $urgence_text = get_theme_mod( 'insuffle_urgence_text', __( 'PLACES LIMITÉES : Seulement 16 places par session | Prochaine session bientôt !', 'insuffle-academy' ) );
        if ( ! empty( $urgence_text ) ) :
    ?>
    <div class="urgence-banner">
        <?php echo wp_kses_post( $urgence_text ); ?>
    </div>
    <?php
        endif;
    endif;
    ?>

    <div id="content" class="site-content">
