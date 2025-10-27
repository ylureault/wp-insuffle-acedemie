<?php
/**
 * The main template file
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
        if ( have_posts() ) :

            if ( is_home() && ! is_front_page() ) :
                ?>
                <header class="page-header">
                    <h1 class="page-title"><?php single_post_title(); ?></h1>
                </header>
                <?php
            endif;

            echo '<div class="posts-grid">';

            while ( have_posts() ) :
                the_post();
                get_template_part( 'template-parts/content', get_post_type() );
            endwhile;

            echo '</div>';

            // Pagination
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
