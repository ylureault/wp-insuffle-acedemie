<?php
/**
 * The template for displaying all single posts
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
        <?php
        while ( have_posts() ) :
            the_post();

            get_template_part( 'template-parts/content', 'single' );

            // Post navigation
            the_post_navigation(
                array(
                    'prev_text' => '<span class="nav-subtitle">' . esc_html__( 'Précédent:', 'wp-insuffle' ) . '</span> <span class="nav-title">%title</span>',
                    'next_text' => '<span class="nav-subtitle">' . esc_html__( 'Suivant:', 'wp-insuffle' ) . '</span> <span class="nav-title">%title</span>',
                )
            );

            // YARPP Related Posts (if plugin is active)
            if ( function_exists( 'yarpp_related' ) ) {
                yarpp_related();
            }

            // If comments are open or we have at least one comment, load up the comment template.
            if ( comments_open() || get_comments_number() ) :
                comments_template();
            endif;

        endwhile;
        ?>
    </div>
</main>

<?php
get_sidebar();
get_footer();
