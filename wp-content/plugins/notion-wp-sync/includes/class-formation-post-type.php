<?php
/**
 * Gestion du Custom Post Type "Formation"
 */

if (!defined('ABSPATH')) {
    exit;
}

class Notion_Formation_Post_Type {

    /**
     * Instance unique
     */
    private static $instance = null;

    /**
     * Nom du post type
     */
    const POST_TYPE = 'formation';

    /**
     * Retourne l'instance unique
     */
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Constructeur
     */
    private function __construct() {
        add_action('init', array($this, 'register_post_type'));
        add_action('init', array($this, 'register_taxonomies'));
        add_action('add_meta_boxes', array($this, 'add_meta_boxes'));
        add_action('save_post_' . self::POST_TYPE, array($this, 'save_meta_boxes'), 10, 2);
    }

    /**
     * Enregistre le Custom Post Type Formation
     */
    public function register_post_type() {
        $labels = array(
            'name'                  => 'Formations',
            'singular_name'         => 'Formation',
            'menu_name'             => 'Formations',
            'name_admin_bar'        => 'Formation',
            'add_new'               => 'Ajouter',
            'add_new_item'          => 'Ajouter une formation',
            'new_item'              => 'Nouvelle formation',
            'edit_item'             => 'Modifier la formation',
            'view_item'             => 'Voir la formation',
            'all_items'             => 'Toutes les formations',
            'search_items'          => 'Rechercher des formations',
            'parent_item_colon'     => 'Formation parente:',
            'not_found'             => 'Aucune formation trouvée.',
            'not_found_in_trash'    => 'Aucune formation dans la corbeille.',
        );

        $args = array(
            'labels'                => $labels,
            'public'                => true,
            'publicly_queryable'    => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'query_var'             => true,
            'rewrite'               => array('slug' => 'formations'),
            'capability_type'       => 'post',
            'has_archive'           => true,
            'hierarchical'          => false,
            'menu_position'         => 5,
            'menu_icon'             => 'dashicons-welcome-learn-more',
            'supports'              => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
            'show_in_rest'          => true, // Support Gutenberg
        );

        register_post_type(self::POST_TYPE, $args);
    }

    /**
     * Enregistre les taxonomies pour les formations
     */
    public function register_taxonomies() {
        // Taxonomie Catégorie
        $category_labels = array(
            'name'              => 'Catégories de formation',
            'singular_name'     => 'Catégorie',
            'search_items'      => 'Rechercher des catégories',
            'all_items'         => 'Toutes les catégories',
            'parent_item'       => 'Catégorie parente',
            'parent_item_colon' => 'Catégorie parente:',
            'edit_item'         => 'Modifier la catégorie',
            'update_item'       => 'Mettre à jour',
            'add_new_item'      => 'Ajouter une catégorie',
            'new_item_name'     => 'Nouvelle catégorie',
            'menu_name'         => 'Catégories',
        );

        register_taxonomy(
            'formation_category',
            self::POST_TYPE,
            array(
                'hierarchical'      => true,
                'labels'            => $category_labels,
                'show_ui'           => true,
                'show_admin_column' => true,
                'query_var'         => true,
                'rewrite'           => array('slug' => 'categorie-formation'),
                'show_in_rest'      => true,
            )
        );

        // Taxonomie Niveau
        $level_labels = array(
            'name'              => 'Niveaux',
            'singular_name'     => 'Niveau',
            'search_items'      => 'Rechercher des niveaux',
            'all_items'         => 'Tous les niveaux',
            'edit_item'         => 'Modifier le niveau',
            'update_item'       => 'Mettre à jour',
            'add_new_item'      => 'Ajouter un niveau',
            'new_item_name'     => 'Nouveau niveau',
            'menu_name'         => 'Niveaux',
        );

        register_taxonomy(
            'formation_level',
            self::POST_TYPE,
            array(
                'hierarchical'      => true,
                'labels'            => $level_labels,
                'show_ui'           => true,
                'show_admin_column' => true,
                'query_var'         => true,
                'rewrite'           => array('slug' => 'niveau'),
                'show_in_rest'      => true,
            )
        );
    }

    /**
     * Ajoute les meta boxes pour les formations
     */
    public function add_meta_boxes() {
        add_meta_box(
            'formation_details',
            'Détails de la formation',
            array($this, 'render_details_meta_box'),
            self::POST_TYPE,
            'normal',
            'high'
        );

        add_meta_box(
            'formation_notion_sync',
            'Synchronisation Notion',
            array($this, 'render_sync_meta_box'),
            self::POST_TYPE,
            'side',
            'default'
        );
    }

    /**
     * Affiche la meta box des détails
     */
    public function render_details_meta_box($post) {
        wp_nonce_field('formation_details_nonce', 'formation_details_nonce');

        $identifier = get_post_meta($post->ID, '_formation_identifier', true);
        $duration = get_post_meta($post->ID, '_formation_duration', true);
        $price = get_post_meta($post->ID, '_formation_price', true);
        $prerequisites = get_post_meta($post->ID, '_formation_prerequisites', true);
        $objectives = get_post_meta($post->ID, '_formation_objectives', true);
        $program = get_post_meta($post->ID, '_formation_program', true);
        $public_target = get_post_meta($post->ID, '_formation_public_target', true);
        $methods = get_post_meta($post->ID, '_formation_methods', true);

        ?>
        <style>
            .formation-field {
                margin-bottom: 20px;
            }
            .formation-field label {
                display: block;
                font-weight: 600;
                margin-bottom: 5px;
            }
            .formation-field input[type="text"],
            .formation-field input[type="number"],
            .formation-field textarea {
                width: 100%;
                padding: 8px;
            }
            .formation-field textarea {
                min-height: 100px;
            }
        </style>

        <div class="formation-field">
            <label for="formation_identifier">Identifiant (ex: SKE pour Sketchnote)</label>
            <input type="text" id="formation_identifier" name="formation_identifier"
                   value="<?php echo esc_attr($identifier); ?>" placeholder="SKE">
        </div>

        <div class="formation-field">
            <label for="formation_duration">Durée</label>
            <input type="text" id="formation_duration" name="formation_duration"
                   value="<?php echo esc_attr($duration); ?>" placeholder="2 jours">
        </div>

        <div class="formation-field">
            <label for="formation_price">Prix (€)</label>
            <input type="number" id="formation_price" name="formation_price"
                   value="<?php echo esc_attr($price); ?>" step="0.01" min="0">
        </div>

        <div class="formation-field">
            <label for="formation_prerequisites">Prérequis</label>
            <textarea id="formation_prerequisites" name="formation_prerequisites"><?php echo esc_textarea($prerequisites); ?></textarea>
        </div>

        <div class="formation-field">
            <label for="formation_objectives">Objectifs pédagogiques</label>
            <textarea id="formation_objectives" name="formation_objectives"><?php echo esc_textarea($objectives); ?></textarea>
        </div>

        <div class="formation-field">
            <label for="formation_program">Programme</label>
            <textarea id="formation_program" name="formation_program"><?php echo esc_textarea($program); ?></textarea>
        </div>

        <div class="formation-field">
            <label for="formation_public_target">Public cible</label>
            <textarea id="formation_public_target" name="formation_public_target"><?php echo esc_textarea($public_target); ?></textarea>
        </div>

        <div class="formation-field">
            <label for="formation_methods">Méthodes pédagogiques</label>
            <textarea id="formation_methods" name="formation_methods"><?php echo esc_textarea($methods); ?></textarea>
        </div>
        <?php
    }

    /**
     * Affiche la meta box de synchronisation Notion
     */
    public function render_sync_meta_box($post) {
        $notion_id = get_post_meta($post->ID, '_notion_id', true);
        $last_sync = get_post_meta($post->ID, '_last_sync_date', true);

        ?>
        <style>
            .sync-info {
                padding: 10px;
                background: #f0f0f1;
                border-radius: 4px;
                margin-bottom: 10px;
            }
            .sync-info p {
                margin: 5px 0;
                font-size: 13px;
            }
            .sync-info strong {
                display: inline-block;
                width: 100px;
            }
        </style>

        <div class="sync-info">
            <?php if ($notion_id): ?>
                <p><strong>Notion ID:</strong> <?php echo esc_html(substr($notion_id, 0, 12) . '...'); ?></p>
                <?php if ($last_sync): ?>
                    <p><strong>Dernière sync:</strong> <?php echo esc_html(date_i18n('d/m/Y H:i', strtotime($last_sync))); ?></p>
                <?php endif; ?>
                <p style="color: #46b450;">✓ Synchronisé avec Notion</p>
            <?php else: ?>
                <p style="color: #999;">Création manuelle WordPress</p>
            <?php endif; ?>
        </div>
        <?php
    }

    /**
     * Sauvegarde les meta boxes
     */
    public function save_meta_boxes($post_id, $post) {
        // Vérifications de sécurité
        if (!isset($_POST['formation_details_nonce']) ||
            !wp_verify_nonce($_POST['formation_details_nonce'], 'formation_details_nonce')) {
            return;
        }

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        // Sauvegarder les champs
        $fields = array(
            'formation_identifier',
            'formation_duration',
            'formation_price',
            'formation_prerequisites',
            'formation_objectives',
            'formation_program',
            'formation_public_target',
            'formation_methods',
        );

        foreach ($fields as $field) {
            if (isset($_POST[$field])) {
                update_post_meta($post_id, '_' . $field, sanitize_text_field($_POST[$field]));
            }
        }
    }

    /**
     * Retourne le nom du post type
     */
    public static function get_post_type_name() {
        return self::POST_TYPE;
    }
}
