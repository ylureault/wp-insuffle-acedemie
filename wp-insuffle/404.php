<?php
/**
 * The template for displaying 404 pages
 *
 * @package WP_Insuffle
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();
?>

<main id="primary" class="site-main">
    <div class="container">
        <section class="error-404 not-found">
            <header class="page-header">
                <h1 class="page-title"><?php esc_html_e( 'Oups ! Cette page est introuvable.', 'wp-insuffle' ); ?></h1>
            </header>

            <div class="page-content">
                <p><?php esc_html_e( 'Il semblerait que rien n\'ait été trouvé à cet emplacement. Essayez peut-être une recherche ?', 'wp-insuffle' ); ?></p>

                <?php get_search_form(); ?>

                <div style="margin-top: 3rem;">
                    <h2><?php esc_html_e( 'Peut-être cherchez-vous...', 'wp-insuffle' ); ?></h2>

                    <div class="info-cards">
                        <div class="info-card">
                            <div class="info-card-icon">🏠</div>
                            <h3><?php esc_html_e( 'Page d\'accueil', 'wp-insuffle' ); ?></h3>
                            <p><?php esc_html_e( 'Retournez à notre page d\'accueil', 'wp-insuffle' ); ?></p>
                            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn"><?php esc_html_e( 'Accueil', 'wp-insuffle' ); ?></a>
                        </div>

                        <div class="info-card">
                            <div class="info-card-icon">📚</div>
                            <h3><?php esc_html_e( 'Nos formations', 'wp-insuffle' ); ?></h3>
                            <p><?php esc_html_e( 'Découvrez toutes nos formations', 'wp-insuffle' ); ?></p>
                            <a href="<?php echo esc_url( home_url( '/formations' ) ); ?>" class="btn"><?php esc_html_e( 'Formations', 'wp-insuffle' ); ?></a>
                        </div>

                        <div class="info-card">
                            <div class="info-card-icon">✉️</div>
                            <h3><?php esc_html_e( 'Contactez-nous', 'wp-insuffle' ); ?></h3>
                            <p><?php esc_html_e( 'Nous sommes là pour vous aider', 'wp-insuffle' ); ?></p>
                            <a href="<?php echo esc_url( home_url( '/contact' ) ); ?>" class="btn"><?php esc_html_e( 'Contact', 'wp-insuffle' ); ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</main>

<?php
get_footer();
