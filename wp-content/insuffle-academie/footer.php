</main>

<!-- Footer -->
<footer>
    <div class="container">
        <div class="footer-content">
            <!-- Colonne 1 - À propos -->
            <div class="footer-column">
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
            </div>
            
            <!-- Colonne 2 - Navigation -->
            <div class="footer-column">
                <h3>Navigation</h3>
                <ul class="footer-links">
                    <li><a href="<?php echo home_url('/'); ?>">Accueil</a></li>
                    <li><a href="<?php echo home_url('/#about'); ?>">Notre approche</a></li>
                    <li><a href="<?php echo home_url('/#formations'); ?>">Nos formations</a></li>
                    <li><a href="<?php echo home_url('/blog/'); ?>">Blog</a></li>
                    <li><a href="<?php echo home_url('/#testimonials'); ?>">Témoignages</a></li>
                    <li><a href="<?php echo home_url('/#contact'); ?>">Contact</a></li>
                </ul>
            </div>
            
            <!-- Colonne 3 - Formations -->
            <div class="footer-column">
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
            </div>
            
            <!-- Colonne 4 - Contact -->
            <div class="footer-column footer-contact">
                <h3>Contact</h3>
                <p>
                    <span>📍</span>
                    <span>Deauville, Normandie<br>France</span>
                </p>
                <p>
                    <span>📞</span>
                    <a href="tel:+33123456789">01 23 45 67 89</a>
                </p>
                <p>
                    <span>✉️</span>
                    <a href="mailto:contact@insuffle-academie.com">contact@insuffle-academie.com</a>
                </p>
                <p style="margin-top: 20px;">
                    <strong>Organisme de formation certifié</strong><br>
                    <small>N° de déclaration d'activité : XXXXXXXX</small>
                </p>
            </div>
        </div>
        
        <!-- Widgets footer si actifs -->
        <?php if (is_active_sidebar('footer-widgets')) : ?>
            <div class="footer-widgets">
                <?php dynamic_sidebar('footer-widgets'); ?>
            </div>
        <?php endif; ?>
        
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