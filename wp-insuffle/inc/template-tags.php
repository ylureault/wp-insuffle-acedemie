<?php
/**
 * Custom template tags for this theme
 *
 * @package WP_Insuffle
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Prints HTML with meta information for the current post-date/time
 */
function wp_insuffle_posted_on() {
    $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
    if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
        $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
    }

    $time_string = sprintf(
        $time_string,
        esc_attr( get_the_date( DATE_W3C ) ),
        esc_html( get_the_date() ),
        esc_attr( get_the_modified_date( DATE_W3C ) ),
        esc_html( get_the_modified_date() )
    );

    $posted_on = sprintf(
        /* translators: %s: post date. */
        esc_html_x( 'Publié le %s', 'post date', 'wp-insuffle' ),
        '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
    );

    echo '<span class="posted-on">' . $posted_on . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

/**
 * Prints HTML with meta information for the current author
 */
function wp_insuffle_posted_by() {
    $byline = sprintf(
        /* translators: %s: post author. */
        esc_html_x( 'par %s', 'post author', 'wp-insuffle' ),
        '<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
    );

    echo '<span class="byline"> ' . $byline . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

/**
 * Prints HTML with meta information for the categories, tags and comments
 */
function wp_insuffle_entry_footer() {
    // Hide category and tag text for pages.
    if ( 'post' === get_post_type() ) {
        /* translators: used between list items, there is a space after the comma */
        $categories_list = get_the_category_list( esc_html__( ', ', 'wp-insuffle' ) );
        if ( $categories_list ) {
            /* translators: 1: list of categories. */
            printf( '<span class="cat-links">' . esc_html__( 'Catégories: %1$s', 'wp-insuffle' ) . '</span>', $categories_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        }

        /* translators: used between list items, there is a space after the comma */
        $tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'wp-insuffle' ) );
        if ( $tags_list ) {
            /* translators: 1: list of tags. */
            printf( '<span class="tags-links">' . esc_html__( 'Tags: %1$s', 'wp-insuffle' ) . '</span>', $tags_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        }
    }

    if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
        echo '<span class="comments-link">';
        comments_popup_link(
            sprintf(
                wp_kses(
                    /* translators: %s: post title */
                    __( 'Laisser un commentaire<span class="screen-reader-text"> sur %s</span>', 'wp-insuffle' ),
                    array(
                        'span' => array(
                            'class' => array(),
                        ),
                    )
                ),
                wp_kses_post( get_the_title() )
            )
        );
        echo '</span>';
    }

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
}

/**
 * Display post thumbnail
 */
function wp_insuffle_post_thumbnail() {
    if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
        return;
    }

    if ( is_singular() ) :
        ?>

        <div class="post-thumbnail">
            <?php the_post_thumbnail( 'wp-insuffle-hero' ); ?>
        </div>

    <?php else : ?>

        <a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
            <?php
            the_post_thumbnail(
                'wp-insuffle-card',
                array(
                    'alt' => the_title_attribute(
                        array(
                            'echo' => false,
                        )
                    ),
                )
            );
            ?>
        </a>

        <?php
    endif;
}

/**
 * Display navigation to next/previous set of posts when applicable
 */
function wp_insuffle_posts_pagination() {
    the_posts_pagination(
        array(
            'mid_size'           => 2,
            'prev_text'          => __( '&laquo; Précédent', 'wp-insuffle' ),
            'next_text'          => __( 'Suivant &raquo;', 'wp-insuffle' ),
            'screen_reader_text' => __( 'Navigation des articles', 'wp-insuffle' ),
        )
    );
}

/**
 * Get estimated reading time
 */
function wp_insuffle_get_reading_time( $post_id = null ) {
    if ( ! $post_id ) {
        $post_id = get_the_ID();
    }

    $content    = get_post_field( 'post_content', $post_id );
    $word_count = str_word_count( strip_tags( $content ) );
    $minutes    = ceil( $word_count / 200 );

    return sprintf(
        _n( '%s minute de lecture', '%s minutes de lecture', $minutes, 'wp-insuffle' ),
        $minutes
    );
}
