<?php
/**
 * Template for displaying the front page
 *
 * @package Insuffle_Academy
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();
?>

<main id="primary" class="site-main">
    <?php
    while ( have_posts() ) :
        the_post();

        // Display page content
        the_content();

    endwhile;
    ?>
</main><!-- #primary -->

<?php
get_footer();
