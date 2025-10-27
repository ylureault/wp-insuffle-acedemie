<?php
/**
 * Template part for displaying a message when no content is found
 *
 * @package WP_Insuffle
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>

<section class="no-results not-found">
    <header class="page-header">
        <h1 class="page-title"><?php esc_html_e( 'Aucun contenu trouvé', 'wp-insuffle' ); ?></h1>
    </header>

    <div class="page-content">
        <?php
        if ( is_home() && current_user_can( 'publish_posts' ) ) :

            printf(
                '<p>' . wp_kses(
                    /* translators: 1: link to WP admin new post page. */
                    __( 'Prêt à publier votre premier article ? <a href="%1$s">Commencez ici</a>.', 'wp-insuffle' ),
                    array(
                        'a' => array(
                            'href' => array(),
                        ),
                    )
                ) . '</p>',
                esc_url( admin_url( 'post-new.php' ) )
            );

        elseif ( is_search() ) :
            ?>

            <p><?php esc_html_e( 'Désolé, aucun résultat ne correspond à votre recherche. Essayez avec d\'autres mots-clés.', 'wp-insuffle' ); ?></p>
            <?php
            get_search_form();

        else :
            ?>

            <p><?php esc_html_e( 'Il semblerait qu\'aucun contenu ne soit disponible. Essayez une recherche ?', 'wp-insuffle' ); ?></p>
            <?php
            get_search_form();

        endif;
        ?>
    </div>
</section>
