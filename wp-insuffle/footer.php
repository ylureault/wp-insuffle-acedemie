<?php
/**
 * The footer for WP Insuffle theme
 *
 * @package WP_Insuffle
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>

    </div><!-- #content -->

    <footer id="colophon" class="site-footer">
        <div class="container">
            <div class="footer-content">
                <?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
                    <div class="footer-column">
                        <?php dynamic_sidebar( 'footer-1' ); ?>
                    </div>
                <?php else : ?>
                    <div class="footer-column">
                        <h3><?php bloginfo( 'name' ); ?></h3>
                        <ul class="footer-links">
                            <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Notre approche</a></li>
                            <li><a href="<?php echo esc_url( home_url( '/formations' ) ); ?>">Nos formations</a></li>
                            <li><a href="<?php echo esc_url( home_url( '/temoignages' ) ); ?>">Témoignages</a></li>
                            <li><a href="<?php echo esc_url( home_url( '/contact' ) ); ?>">Contact</a></li>
                        </ul>
                    </div>
                <?php endif; ?>

                <?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
                    <div class="footer-column">
                        <?php dynamic_sidebar( 'footer-2' ); ?>
                    </div>
                <?php else : ?>
                    <div class="footer-column">
                        <h3>Nos formations</h3>
                        <ul class="footer-links">
                            <li><a href="https://www.insuffle.com/formation/facilitation-bootcamp-formation-facilitation/">Facilitation Bootcamp</a></li>
                            <li><a href="https://www.insuffle.com/formation/formation-manager-facilitateur/">Manager Facilitateur</a></li>
                            <li><a href="https://www.insuffle.com/formation/formation-sketchnote/">Sketchnote</a></li>
                            <li><a href="https://www.insuffle.com/formation/formation-facilitation/">Les fondamentaux</a></li>
                        </ul>
                    </div>
                <?php endif; ?>

                <?php if ( is_active_sidebar( 'footer-3' ) ) : ?>
                    <div class="footer-column">
                        <?php dynamic_sidebar( 'footer-3' ); ?>
                    </div>
                <?php else : ?>
                    <div class="footer-column">
                        <h3>Informations légales</h3>
                        <ul class="footer-links">
                            <li><a href="<?php echo esc_url( home_url( '/mentions-legales' ) ); ?>">Mentions légales</a></li>
                            <li><a href="<?php echo esc_url( home_url( '/politique-confidentialite' ) ); ?>">Politique de confidentialité</a></li>
                            <li><a href="<?php echo esc_url( home_url( '/conditions-generales' ) ); ?>">Conditions générales</a></li>
                            <li><a href="<?php echo esc_url( home_url( '/accessibilite' ) ); ?>">Accessibilité</a></li>
                        </ul>
                    </div>
                <?php endif; ?>

                <?php if ( is_active_sidebar( 'footer-4' ) ) : ?>
                    <div class="footer-column">
                        <?php dynamic_sidebar( 'footer-4' ); ?>
                    </div>
                <?php else : ?>
                    <div class="footer-column">
                        <h3>Contact</h3>
                        <div class="footer-contact">
                            <p><strong>Insuffle Académie</strong></p>
                            <p>410 RUE DE LA PRINCESSE TROUBETSKOI</p>
                            <p>14800 Deauville, France</p>
                            <p>Tél: <a href="tel:+33980808962">09 80 80 89 62</a></p>
                            <p>Email: <a href="mailto:contact@insuffle-academie.com">contact@insuffle-academie.com</a></p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <div class="footer-bottom">
                <?php if ( has_custom_logo() ) : ?>
                    <?php the_custom_logo(); ?>
                <?php else : ?>
                    <img src="https://www.insuffle-academie.com/img/Logo-Insuffle-Academie.png"
                         alt="<?php bloginfo( 'name' ); ?>"
                         class="footer-logo">
                <?php endif; ?>

                <p class="copyright">
                    &copy; <?php echo date( 'Y' ); ?> <?php bloginfo( 'name' ); ?> -
                    <?php esc_html_e( 'Organisme de formation professionnelle certifié Qualiopi - Tous droits réservés.', 'wp-insuffle' ); ?>
                </p>

                <?php
                if ( has_nav_menu( 'footer' ) ) {
                    wp_nav_menu(
                        array(
                            'theme_location' => 'footer',
                            'menu_id'        => 'footer-menu',
                            'menu_class'     => 'footer-menu',
                            'container'      => 'nav',
                            'depth'          => 1,
                        )
                    );
                }
                ?>
            </div>
        </div>
    </footer>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
