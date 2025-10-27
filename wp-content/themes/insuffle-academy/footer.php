<?php
/**
 * The template for displaying the footer
 *
 * @package Insuffle_Academy
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>

    </div><!-- #content -->

    <footer id="colophon" class="site-footer">
        <div class="container">
            <div class="footer-content">
                <?php
                // Footer widget areas
                for ( $i = 1; $i <= 4; $i++ ) {
                    if ( is_active_sidebar( 'footer-' . $i ) ) {
                        echo '<div class="footer-section">';
                        dynamic_sidebar( 'footer-' . $i );
                        echo '</div>';
                    }
                }

                // Default footer content if no widgets
                if ( ! is_active_sidebar( 'footer-1' ) && ! is_active_sidebar( 'footer-2' ) && ! is_active_sidebar( 'footer-3' ) && ! is_active_sidebar( 'footer-4' ) ) :
                ?>
                    <div class="footer-section">
                        <h3><?php echo esc_html( get_theme_mod( 'insuffle_footer_emoji', '🎮' ) ); ?> <?php bloginfo( 'name' ); ?></h3>
                        <p style="opacity: 0.8; line-height: 1.8;">
                            <?php
                            $description = get_bloginfo( 'description', 'display' );
                            echo $description ? esc_html( $description ) : esc_html__( 'La formation facilitateur gamifiée qui change tout.', 'insuffle-academy' );
                            ?>
                        </p>
                    </div>

                    <div class="footer-section">
                        <h3><?php esc_html_e( 'Liens Rapides', 'insuffle-academy' ); ?></h3>
                        <?php
                        wp_nav_menu(
                            array(
                                'theme_location' => 'footer',
                                'menu_class'     => 'footer-links',
                                'container'      => false,
                                'depth'          => 1,
                                'fallback_cb'    => false,
                            )
                        );
                        ?>
                    </div>

                    <div class="footer-section">
                        <h3><?php esc_html_e( 'Contact', 'insuffle-academy' ); ?></h3>
                        <ul class="footer-links">
                            <?php if ( $email = get_theme_mod( 'insuffle_contact_email' ) ) : ?>
                            <li><a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a></li>
                            <?php endif; ?>

                            <?php if ( $phone = get_theme_mod( 'insuffle_contact_phone' ) ) : ?>
                            <li><a href="tel:<?php echo esc_attr( str_replace( ' ', '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a></li>
                            <?php endif; ?>

                            <?php if ( $website = get_theme_mod( 'insuffle_website_url' ) ) : ?>
                            <li><a href="<?php echo esc_url( $website ); ?>" target="_blank"><?php echo esc_html( parse_url( $website, PHP_URL_HOST ) ); ?></a></li>
                            <?php endif; ?>
                        </ul>
                    </div>

                    <div class="footer-section">
                        <h3><?php esc_html_e( 'Suivez-Nous', 'insuffle-academy' ); ?></h3>
                        <ul class="footer-links">
                            <?php if ( $linkedin = get_theme_mod( 'insuffle_social_linkedin' ) ) : ?>
                            <li><a href="<?php echo esc_url( $linkedin ); ?>" target="_blank" rel="noopener">LinkedIn</a></li>
                            <?php endif; ?>

                            <?php if ( $instagram = get_theme_mod( 'insuffle_social_instagram' ) ) : ?>
                            <li><a href="<?php echo esc_url( $instagram ); ?>" target="_blank" rel="noopener">Instagram</a></li>
                            <?php endif; ?>

                            <?php if ( $facebook = get_theme_mod( 'insuffle_social_facebook' ) ) : ?>
                            <li><a href="<?php echo esc_url( $facebook ); ?>" target="_blank" rel="noopener">Facebook</a></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>

            <div class="footer-bottom">
                <p>
                    &copy; <?php echo esc_html( date( 'Y' ) ); ?>
                    <?php bloginfo( 'name' ); ?> -
                    <?php esc_html_e( 'Tous droits réservés', 'insuffle-academy' ); ?>
                    <?php if ( $certification = get_theme_mod( 'insuffle_certification_text' ) ) : ?>
                        | <?php echo esc_html( $certification ); ?>
                    <?php endif; ?>
                </p>
                <p style="margin-top: 10px;">
                    <?php
                    // Footer menu links
                    $footer_links = array(
                        'mentions' => __( 'Mentions Légales', 'insuffle-academy' ),
                        'cgv'      => __( 'CGV', 'insuffle-academy' ),
                        'privacy'  => __( 'Politique de Confidentialité', 'insuffle-academy' ),
                    );

                    $links_output = array();
                    foreach ( $footer_links as $key => $label ) {
                        $url = get_theme_mod( 'insuffle_footer_link_' . $key );
                        if ( $url ) {
                            $links_output[] = '<a href="' . esc_url( $url ) . '" style="color: var(--light); opacity: 0.7; text-decoration: none; margin: 0 10px;">' . esc_html( $label ) . '</a>';
                        }
                    }

                    if ( ! empty( $links_output ) ) {
                        echo implode( ' | ', $links_output );
                    }
                    ?>
                </p>
            </div>
        </div><!-- .container -->
    </footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
