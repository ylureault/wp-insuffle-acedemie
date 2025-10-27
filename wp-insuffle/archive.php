<?php
/**
 * The template for displaying archive pages
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
        <?php if ( have_posts() ) : ?>

            <header class="page-header">
                <?php
                the_archive_title( '<h1 class="page-title">', '</h1>' );
                the_archive_description( '<div class="archive-description">', '</div>' );
                ?>
            </header>

            <div class="posts-grid">
                <?php
                while ( have_posts() ) :
                    the_post();
                    get_template_part( 'template-parts/content', get_post_type() );
                endwhile;
                ?>
            </div>

            <?php
            the_posts_pagination(
                array(
                    'mid_size'  => 2,
                    'prev_text' => __( '&laquo; Précédent', 'wp-insuffle' ),
                    'next_text' => __( 'Suivant &raquo;', 'wp-insuffle' ),
                )
            );

        else :

            get_template_part( 'template-parts/content', 'none' );

        endif;
        ?>
    </div>
</main>

<?php
get_sidebar();
get_footer();
