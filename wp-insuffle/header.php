<?php
/**
 * The header for WP Insuffle theme
 *
 * @package WP_Insuffle
 * @version 1.0.0
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

<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Aller au contenu principal', 'wp-insuffle' ); ?></a>

<div id="page" class="site">
    <header id="masthead" class="site-header">
        <div class="container">
            <nav class="site-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Menu principal', 'wp-insuffle' ); ?>">
                <div class="site-branding">
                    <?php
                    if ( has_custom_logo() ) {
                        the_custom_logo();
                    } else {
                        ?>
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                            <img src="https://www.insuffle-academie.com/img/Logo-Insuffle-Academie.png"
                                 alt="<?php bloginfo( 'name' ); ?>"
                                 class="site-logo">
                        </a>
                        <?php
                    }
                    ?>
                </div>

                <?php
                if ( has_nav_menu( 'primary' ) ) {
                    wp_nav_menu(
                        array(
                            'theme_location' => 'primary',
                            'menu_id'        => 'primary-menu',
                            'menu_class'     => 'main-menu',
                            'container'      => false,
                            'fallback_cb'    => false,
                        )
                    );
                } else {
                    // Fallback menu if no menu is set
                    ?>
                    <ul class="main-menu">
                        <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Accueil</a></li>
                        <li><a href="<?php echo esc_url( home_url( '/formations' ) ); ?>">Formations</a></li>
                        <li><a href="<?php echo esc_url( home_url( '/a-propos' ) ); ?>">À Propos</a></li>
                        <li><a href="<?php echo esc_url( home_url( '/blog' ) ); ?>">Blog</a></li>
                        <li class="menu-cta"><a href="<?php echo esc_url( home_url( '/contact' ) ); ?>">Contact</a></li>
                    </ul>
                    <?php
                }
                ?>

                <button class="mobile-menu-toggle" aria-controls="primary-menu" aria-expanded="false">
                    <span class="screen-reader-text"><?php esc_html_e( 'Menu', 'wp-insuffle' ); ?></span>
                    <span class="menu-icon">☰</span>
                </button>
            </nav>
        </div>
    </header>

    <?php
    // Rank Math Breadcrumbs (if plugin is active)
    if ( function_exists( 'rank_math_the_breadcrumbs' ) && ! is_front_page() ) {
        ?>
        <div class="breadcrumbs-container">
            <div class="container">
                <?php rank_math_the_breadcrumbs(); ?>
            </div>
        </div>
        <?php
    }
    ?>

    <div id="content" class="site-content">
