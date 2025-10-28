<?php
/**
 * Optimisations SEO pour Insuffle Académie
 *
 * Ajoute les balises meta, Open Graph, Schema.org et autres optimisations SEO
 */

if (!defined('ABSPATH')) exit;

// ========================================
// META DESCRIPTIONS DYNAMIQUES
// ========================================

function insuffle_add_meta_description() {
    if (is_singular()) {
        global $post;

        // Meta description depuis l'extrait ou le contenu
        if (has_excerpt()) {
            $description = get_the_excerpt();
        } else {
            $description = wp_trim_words(strip_shortcodes($post->post_content), 30, '...');
        }

        echo '<meta name="description" content="' . esc_attr(wp_strip_all_tags($description)) . '">' . "\n";

    } elseif (is_home() || is_front_page()) {
        echo '<meta name="description" content="' . esc_attr(get_bloginfo('description')) . '">' . "\n";
    } elseif (is_category()) {
        $description = category_description();
        if ($description) {
            echo '<meta name="description" content="' . esc_attr(wp_strip_all_tags($description)) . '">' . "\n";
        }
    } elseif (is_archive()) {
        echo '<meta name="description" content="Archive de ' . esc_attr(get_the_archive_title()) . ' - ' . esc_attr(get_bloginfo('name')) . '">' . "\n";
    }
}
add_action('wp_head', 'insuffle_add_meta_description', 1);

// ========================================
// BALISES OPEN GRAPH (FACEBOOK)
// ========================================

function insuffle_add_opengraph() {
    global $post;

    // OG: Site name
    echo '<meta property="og:site_name" content="' . esc_attr(get_bloginfo('name')) . '">' . "\n";

    // OG: Locale
    echo '<meta property="og:locale" content="fr_FR">' . "\n";

    if (is_singular()) {
        // OG: Type
        echo '<meta property="og:type" content="article">' . "\n";

        // OG: Title
        echo '<meta property="og:title" content="' . esc_attr(get_the_title()) . '">' . "\n";

        // OG: Description
        if (has_excerpt()) {
            $og_description = get_the_excerpt();
        } else {
            $og_description = wp_trim_words(strip_shortcodes($post->post_content), 30, '...');
        }
        echo '<meta property="og:description" content="' . esc_attr(wp_strip_all_tags($og_description)) . '">' . "\n";

        // OG: URL
        echo '<meta property="og:url" content="' . esc_url(get_permalink()) . '">' . "\n";

        // OG: Image
        if (has_post_thumbnail()) {
            $og_image = get_the_post_thumbnail_url($post->ID, 'large');
            echo '<meta property="og:image" content="' . esc_url($og_image) . '">' . "\n";
            echo '<meta property="og:image:width" content="1200">' . "\n";
            echo '<meta property="og:image:height" content="630">' . "\n";
        }

        // Article: Published Time
        echo '<meta property="article:published_time" content="' . esc_attr(get_the_date('c')) . '">' . "\n";

        // Article: Modified Time
        echo '<meta property="article:modified_time" content="' . esc_attr(get_the_modified_date('c')) . '">' . "\n";

    } else {
        // OG: Type
        echo '<meta property="og:type" content="website">' . "\n";

        // OG: Title
        echo '<meta property="og:title" content="' . esc_attr(get_bloginfo('name')) . '">' . "\n";

        // OG: Description
        echo '<meta property="og:description" content="' . esc_attr(get_bloginfo('description')) . '">' . "\n";

        // OG: URL
        echo '<meta property="og:url" content="' . esc_url(home_url('/')) . '">' . "\n";
    }
}
add_action('wp_head', 'insuffle_add_opengraph', 2);

// ========================================
// BALISES TWITTER CARD
// ========================================

function insuffle_add_twitter_card() {
    global $post;

    echo '<meta name="twitter:card" content="summary_large_image">' . "\n";

    if (is_singular()) {
        echo '<meta name="twitter:title" content="' . esc_attr(get_the_title()) . '">' . "\n";

        if (has_excerpt()) {
            $twitter_description = get_the_excerpt();
        } else {
            $twitter_description = wp_trim_words(strip_shortcodes($post->post_content), 30, '...');
        }
        echo '<meta name="twitter:description" content="' . esc_attr(wp_strip_all_tags($twitter_description)) . '">' . "\n";

        if (has_post_thumbnail()) {
            $twitter_image = get_the_post_thumbnail_url($post->ID, 'large');
            echo '<meta name="twitter:image" content="' . esc_url($twitter_image) . '">' . "\n";
        }
    } else {
        echo '<meta name="twitter:title" content="' . esc_attr(get_bloginfo('name')) . '">' . "\n";
        echo '<meta name="twitter:description" content="' . esc_attr(get_bloginfo('description')) . '">' . "\n";
    }
}
add_action('wp_head', 'insuffle_add_twitter_card', 3);

// ========================================
// SCHEMA.ORG - ORGANISATION
// ========================================

function insuffle_add_schema_org() {
    if (is_front_page()) {
        $schema = array(
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => get_bloginfo('name'),
            'description' => get_bloginfo('description'),
            'url' => home_url('/'),
            'logo' => get_template_directory_uri() . '/img/Logo-Insuffle-Academie.png',
            'telephone' => '+33980808962',
            'email' => 'contact@insuffle-academie.com',
            'address' => array(
                '@type' => 'PostalAddress',
                'addressLocality' => 'Deauville',
                'addressRegion' => 'Normandie',
                'addressCountry' => 'FR'
            ),
            'sameAs' => array(
                // Ajoutez ici les liens vers les réseaux sociaux
            )
        );

        echo '<script type="application/ld+json">' . "\n";
        echo wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
        echo "\n" . '</script>' . "\n";
    }
}
add_action('wp_head', 'insuffle_add_schema_org', 4);

// ========================================
// SCHEMA.ORG - ARTICLE
// ========================================

function insuffle_add_article_schema() {
    if (is_single() && get_post_type() === 'post') {
        global $post;

        $schema = array(
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => get_the_title(),
            'description' => has_excerpt() ? get_the_excerpt() : wp_trim_words(strip_shortcodes($post->post_content), 30),
            'datePublished' => get_the_date('c'),
            'dateModified' => get_the_modified_date('c'),
            'author' => array(
                '@type' => 'Person',
                'name' => get_the_author()
            ),
            'publisher' => array(
                '@type' => 'Organization',
                'name' => get_bloginfo('name'),
                'logo' => array(
                    '@type' => 'ImageObject',
                    'url' => get_template_directory_uri() . '/img/Logo-Insuffle-Academie.png'
                )
            )
        );

        if (has_post_thumbnail()) {
            $schema['image'] = get_the_post_thumbnail_url($post->ID, 'large');
        }

        echo '<script type="application/ld+json">' . "\n";
        echo wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
        echo "\n" . '</script>' . "\n";
    }
}
add_action('wp_head', 'insuffle_add_article_schema', 5);

// ========================================
// SCHEMA.ORG - COURS/FORMATION
// ========================================

function insuffle_add_course_schema() {
    // Pour les pages enfants de "formations"
    if (is_page()) {
        $parent_id = wp_get_post_parent_id(get_the_ID());
        if ($parent_id) {
            $parent_slug = get_post_field('post_name', $parent_id);
            if (stripos($parent_slug, 'formation') !== false) {
                global $post;

                $schema = array(
                    '@context' => 'https://schema.org',
                    '@type' => 'Course',
                    'name' => get_the_title(),
                    'description' => has_excerpt() ? get_the_excerpt() : wp_trim_words(strip_shortcodes($post->post_content), 30),
                    'provider' => array(
                        '@type' => 'Organization',
                        'name' => get_bloginfo('name'),
                        'url' => home_url('/')
                    )
                );

                echo '<script type="application/ld+json">' . "\n";
                echo wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
                echo "\n" . '</script>' . "\n";
            }
        }
    }
}
add_action('wp_head', 'insuffle_add_course_schema', 6);

// ========================================
// URL CANONIQUE
// ========================================

function insuffle_add_canonical() {
    if (is_singular()) {
        echo '<link rel="canonical" href="' . esc_url(get_permalink()) . '">' . "\n";
    } elseif (is_home() || is_front_page()) {
        echo '<link rel="canonical" href="' . esc_url(home_url('/')) . '">' . "\n";
    }
}
add_action('wp_head', 'insuffle_add_canonical', 7);

// ========================================
// ROBOTS META
// ========================================

function insuffle_add_robots_meta() {
    if (is_search() || is_404()) {
        echo '<meta name="robots" content="noindex, follow">' . "\n";
    }
}
add_action('wp_head', 'insuffle_add_robots_meta', 1);
