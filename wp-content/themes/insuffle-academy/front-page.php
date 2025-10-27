<?php
/**
 * Template for displaying the front page
 *
 * @package Insuffle_Academy
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Check if the current page has a custom template
$template = get_page_template_slug();

// If a custom template is assigned, use it instead
if ( ! empty( $template ) ) {
    // Include the custom template file
    include( locate_template( $template ) );
    return; // Stop execution here to prevent loading header/footer twice
}

// Otherwise, use the default front page layout
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
