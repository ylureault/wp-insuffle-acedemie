</main>

<!-- Footer -->
<footer>
    <div class="container">
        <div class="footer-content">
            <!-- Colonne 1 - Widget Zone -->
            <div class="footer-column">
                <?php if (is_active_sidebar('footer-1')) : ?>
                    <?php dynamic_sidebar('footer-1'); ?>
                <?php else : ?>
                    <h3>Insuffle Académie</h3>
                    <p>Organisme de formation spécialisé en facilitation et intelligence collective. Basé à Deauville, nous formons les professionnels aux techniques collaboratives qui transforment les organisations.</p>
                    <?php if (has_custom_logo()) : ?>
                        <div class="footer-logo">
                            <?php the_custom_logo(); ?>
                        </div>
                    <?php else : ?>
                        <img src="<?php echo get_template_directory_uri(); ?>/img/Logo-Insuffle-Academie.png"
                             alt="<?php bloginfo('name'); ?>"
                             class="footer-logo">
                    <?php endif; ?>
                <?php endif; ?>
            </div>

            <!-- Colonne 2 - Widget Zone ou Menu Navigation -->
            <div class="footer-column">
                <?php if (is_active_sidebar('footer-2')) : ?>
                    <?php dynamic_sidebar('footer-2'); ?>
                <?php else : ?>
                    <h3>Navigation</h3>
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'footer',
                        'container'      => false,
                        'menu_class'     => 'footer-links',
                        'fallback_cb'    => 'insuffle_fallback_footer_menu',
                        'depth'          => 1,
                    ));
                    ?>
                <?php endif; ?>
            </div>

            <!-- Colonne 3 - Widget Zone ou Formations -->
            <div class="footer-column">
                <?php if (is_active_sidebar('footer-3')) : ?>
                    <?php dynamic_sidebar('footer-3'); ?>
                <?php else : ?>
                    <h3>Nos formations</h3>
                    <ul class="footer-links">
                        <?php
                        // Récupérer les formations pour le footer
                        $formations = insuffle_get_formations(array('posts_per_page' => 5));

                        if ($formations) :
                            foreach ($formations as $formation) :
                        ?>
                            <li><a href="<?php echo get_permalink($formation->ID); ?>"><?php echo get_the_title($formation->ID); ?></a></li>
                        <?php
                            endforeach;
                        else :
                        ?>
                            <li><a href="<?php echo home_url('/formations/'); ?>">Voir toutes nos formations</a></li>
                        <?php endif; ?>
                    </ul>
                <?php endif; ?>
            </div>

            <!-- Colonne 4 - Widget Zone ou Contact -->
            <div class="footer-column footer-contact">
                <?php if (is_active_sidebar('footer-4')) : ?>
                    <?php dynamic_sidebar('footer-4'); ?>
                <?php else : ?>
                    <h3>Contact</h3>
                    <p>
                        <span>📍</span>
                        <span>Deauville, Normandie<br>France</span>
                    </p>
                    <p>
                        <span>📞</span>
                        <a href="tel:+33980808962">09 80 80 89 62</a>
                    </p>
                    <p>
                        <span>✉️</span>
                        <a href="mailto:contact@insuffle-academie.com">contact@insuffle-academie.com</a>
                    </p>
                    <p style="margin-top: 20px;">
                        <strong>Organisme de formation certifié</strong><br>
                        <small>N° de déclaration d'activité : XXXXXXXX</small>
                    </p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Footer bottom -->
        <div class="footer-bottom">
            <p class="copyright">
                &copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?> -
                Tous droits réservés |
                <a href="<?php echo home_url('/mentions-legales/'); ?>">Mentions légales</a> |
                <a href="<?php echo home_url('/politique-de-confidentialite/'); ?>">Politique de confidentialité</a> |
                <a href="<?php echo home_url('/cgv/'); ?>">CGV</a>
            </p>
            <p style="margin-top: 10px; font-size: 0.85rem; color: rgba(255, 255, 255, 0.5);">
                Conçu avec ❤️ par Insuffle | Propulsé par WordPress
            </p>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>

</body>
</html>