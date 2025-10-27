<?php
/**
 * Script de migration pour supprimer l'ancien Custom Post Type Formation
 *
 * À exécuter UNE SEULE FOIS pour nettoyer WordPress
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Désactive l'ancien Custom Post Type Formation
 */
function notion_sync_remove_old_cpt() {
    // Désactiver le CPT en le rendant non public
    register_post_type('formation', array(
        'public' => false,
        'show_ui' => false,
        'show_in_menu' => false,
        'show_in_admin_bar' => false,
        'show_in_nav_menus' => false,
        'show_in_rest' => false,
        'rewrite' => false,
        'capabilities' => array(
            'create_posts' => false,
        ),
    ));

    // Désactiver les taxonomies
    register_taxonomy('formation_category', array(), array(
        'public' => false,
        'show_ui' => false,
    ));

    register_taxonomy('formation_level', array(), array(
        'public' => false,
        'show_ui' => false,
    ));

    // Flush rewrite rules
    flush_rewrite_rules();
}

// Exécuter au chargement de WordPress
add_action('init', 'notion_sync_remove_old_cpt', 999);
