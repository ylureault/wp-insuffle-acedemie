<?php
/**
 * Template part for displaying single posts
 *
 * @package WP_Insuffle
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php if ( has_post_thumbnail() ) : ?>
        <div class="post-thumbnail">
            <?php the_post_thumbnail( 'wp-insuffle-hero' ); ?>
        </div>
    <?php endif; ?>

    <header class="entry-header">
        <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

        <div class="entry-meta">
            <span class="posted-on">
                <time class="entry-date published" datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>">
                    <?php echo esc_html( get_the_date() ); ?>
                </time>
            </span>
            <span class="byline">
                <?php esc_html_e( 'par', 'wp-insuffle' ); ?>
                <span class="author vcard">
                    <a class="url fn n" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
                        <?php echo esc_html( get_the_author() ); ?>
                    </a>
                </span>
            </span>
            <?php if ( function_exists( 'wp_insuffle_reading_time' ) ) : ?>
                <span class="reading-time">
                    <?php echo wp_insuffle_reading_time(); ?>
                </span>
            <?php endif; ?>
            <?php if ( has_category() ) : ?>
                <span class="cat-links">
                    <?php esc_html_e( 'dans', 'wp-insuffle' ); ?>
                    <?php the_category( ', ' ); ?>
                </span>
            <?php endif; ?>
        </div>
    </header>

    <div class="entry-content">
        <?php
        the_content();

        wp_link_pages(
            array(
                'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'wp-insuffle' ),
                'after'  => '</div>',
            )
        );
        ?>
    </div>

    <footer class="entry-footer">
        <?php if ( get_the_tags() ) : ?>
            <?php the_tags( '<div class="tags-links">' . esc_html__( 'Tags: ', 'wp-insuffle' ), ', ', '</div>' ); ?>
        <?php endif; ?>

        <?php
        edit_post_link(
            sprintf(
                wp_kses(
                    /* translators: %s: Name of current post. Only visible to screen readers */
                    __( 'Modifier <span class="screen-reader-text">%s</span>', 'wp-insuffle' ),
                    array(
                        'span' => array(
                            'class' => array(),
                        ),
                    )
                ),
                wp_kses_post( get_the_title() )
            ),
            '<span class="edit-link">',
            '</span>'
        );
        ?>
    </footer>
</article>
