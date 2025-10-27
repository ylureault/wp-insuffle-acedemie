<?php
/**
 * Template part for displaying posts
 *
 * @package WP_Insuffle
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'info-card' ); ?>>
    <?php if ( has_post_thumbnail() ) : ?>
        <div class="post-thumbnail">
            <a href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail( 'wp-insuffle-card' ); ?>
            </a>
        </div>
    <?php endif; ?>

    <header class="entry-header">
        <?php
        if ( is_singular() ) :
            the_title( '<h1 class="entry-title">', '</h1>' );
        else :
            the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
        endif;
        ?>

        <?php if ( 'post' === get_post_type() ) : ?>
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
            </div>
        <?php endif; ?>
    </header>

    <div class="entry-content">
        <?php
        if ( is_singular() ) {
            the_content();

            wp_link_pages(
                array(
                    'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'wp-insuffle' ),
                    'after'  => '</div>',
                )
            );
        } else {
            the_excerpt();
            ?>
            <a href="<?php the_permalink(); ?>" class="btn btn-secondary">
                <?php esc_html_e( 'Lire la suite', 'wp-insuffle' ); ?>
            </a>
            <?php
        }
        ?>
    </div>

    <?php if ( is_singular() && get_the_tags() ) : ?>
        <footer class="entry-footer">
            <?php the_tags( '<div class="tags-links">' . esc_html__( 'Tags: ', 'wp-insuffle' ), ', ', '</div>' ); ?>
        </footer>
    <?php endif; ?>
</article>
