<?php
/**
 * Gestion des meta boxes pour les pages WordPress
 */

if (!defined('ABSPATH')) {
    exit;
}

class Notion_Page_Meta_Box {

    /**
     * Instance unique
     */
    private static $instance = null;

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
        add_action('add_meta_boxes', array($this, 'add_meta_boxes'));
        add_action('save_post_page', array($this, 'save_meta_box'), 10, 2);
        add_action('admin_notices', array($this, 'show_sync_notice'));
    }

    /**
     * Ajoute la meta box aux pages
     */
    public function add_meta_boxes() {
        add_meta_box(
            'notion_formation_sync',
            'Synchronisation Notion Formation',
            array($this, 'render_meta_box'),
            'page',
            'side',
            'high'
        );
    }

    /**
     * Affiche la meta box
     */
    public function render_meta_box($post) {
        wp_nonce_field('notion_formation_sync_nonce', 'notion_formation_sync_nonce');

        $formation_id = get_post_meta($post->ID, '_notion_formation_id', true);
        $auto_sync = get_post_meta($post->ID, '_notion_auto_sync', true);
        $last_sync = get_post_meta($post->ID, '_notion_last_sync', true);

        // Récupérer la formation depuis la base si un ID est défini
        $formation_info = null;
        if (!empty($formation_id)) {
            global $wpdb;
            $table_name = $wpdb->prefix . 'notion_formations';
            $formation_info = $wpdb->get_row($wpdb->prepare(
                "SELECT * FROM $table_name WHERE identifier = %s",
                $formation_id
            ));
        }

        ?>
        <style>
            .notion-sync-field {
                margin-bottom: 15px;
            }
            .notion-sync-field label {
                display: block;
                font-weight: 600;
                margin-bottom: 5px;
            }
            .notion-sync-field input[type="text"] {
                width: 100%;
            }
            .notion-sync-info {
                background: #f0f0f1;
                padding: 10px;
                border-radius: 4px;
                margin-top: 10px;
            }
            .notion-sync-info p {
                margin: 5px 0;
                font-size: 12px;
            }
            .notion-sync-status {
                display: inline-block;
                padding: 2px 8px;
                border-radius: 3px;
                font-size: 11px;
                font-weight: 600;
            }
            .status-active {
                background: #d4edda;
                color: #155724;
            }
            .status-inactive {
                background: #f8d7da;
                color: #721c24;
            }
            .sync-button {
                margin-top: 10px;
            }
        </style>

        <div class="notion-sync-field">
            <label for="notion_formation_id">Identifiant de formation Notion</label>
            <input type="text"
                   id="notion_formation_id"
                   name="notion_formation_id"
                   value="<?php echo esc_attr($formation_id); ?>"
                   placeholder="Ex: IC, SKE, FAC">
            <p class="description">
                Entrez l'identifiant de la formation dans Notion (ex: "IC" pour Intelligence Collective)
            </p>
        </div>

        <div class="notion-sync-field">
            <label>
                <input type="checkbox"
                       id="notion_auto_sync"
                       name="notion_auto_sync"
                       value="1"
                       <?php checked($auto_sync, '1'); ?>>
                Synchronisation automatique
            </label>
            <p class="description">
                Met à jour automatiquement le contenu de cette page lors des synchronisations
            </p>
        </div>

        <?php if ($formation_info): ?>
            <div class="notion-sync-info">
                <p><strong>Formation trouvée :</strong></p>
                <p><?php echo esc_html($formation_info->title); ?></p>
                <p>
                    <span class="notion-sync-status status-active">✓ Synchronisée</span>
                </p>
                <?php if ($last_sync): ?>
                    <p><strong>Dernière sync :</strong><br>
                    <?php echo esc_html(date_i18n('d/m/Y à H:i', strtotime($last_sync))); ?></p>
                <?php endif; ?>
                <button type="button" class="button button-small sync-button" id="notion-sync-now">
                    Synchroniser maintenant
                </button>
            </div>
        <?php elseif (!empty($formation_id)): ?>
            <div class="notion-sync-info">
                <p>
                    <span class="notion-sync-status status-inactive">⚠ Formation non trouvée</span>
                </p>
                <p class="description">
                    Aucune formation avec l'identifiant "<?php echo esc_html($formation_id); ?>"
                    n'a été trouvée dans Notion. Lancez une synchronisation depuis
                    <a href="<?php echo admin_url('admin.php?page=notion-wp-sync'); ?>">Notion Sync</a>.
                </p>
            </div>
        <?php endif; ?>

        <script>
        jQuery(document).ready(function($) {
            $('#notion-sync-now').on('click', function(e) {
                e.preventDefault();
                var $button = $(this);
                var postId = <?php echo $post->ID; ?>;

                $button.prop('disabled', true).text('Synchronisation...');

                $.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    data: {
                        action: 'notion_sync_single_page',
                        post_id: postId,
                        nonce: '<?php echo wp_create_nonce('notion_sync_single_page'); ?>'
                    },
                    success: function(response) {
                        if (response.success) {
                            alert('Synchronisation réussie ! Rechargement de la page...');
                            location.reload();
                        } else {
                            alert('Erreur : ' + response.data.message);
                            $button.prop('disabled', false).text('Synchroniser maintenant');
                        }
                    },
                    error: function() {
                        alert('Erreur de connexion');
                        $button.prop('disabled', false).text('Synchroniser maintenant');
                    }
                });
            });
        });
        </script>
        <?php
    }

    /**
     * Sauvegarde la meta box
     */
    public function save_meta_box($post_id, $post) {
        // Vérifications de sécurité
        if (!isset($_POST['notion_formation_sync_nonce']) ||
            !wp_verify_nonce($_POST['notion_formation_sync_nonce'], 'notion_formation_sync_nonce')) {
            return;
        }

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        // Sauvegarder l'identifiant de formation
        if (isset($_POST['notion_formation_id'])) {
            $formation_id = sanitize_text_field($_POST['notion_formation_id']);
            update_post_meta($post_id, '_notion_formation_id', $formation_id);

            // Si un ID est défini et que l'auto-sync est activé, synchroniser
            if (!empty($formation_id) && isset($_POST['notion_auto_sync'])) {
                update_post_meta($post_id, '_notion_auto_sync', '1');
                // La synchronisation sera faite après la sauvegarde
                set_transient('notion_sync_page_' . $post_id, true, 10);
            } else {
                update_post_meta($post_id, '_notion_auto_sync', '0');
            }
        }
    }

    /**
     * Affiche une notice après la synchronisation
     */
    public function show_sync_notice() {
        global $post;
        if (!$post || $post->post_type !== 'page') {
            return;
        }

        if (get_transient('notion_sync_page_' . $post->ID)) {
            delete_transient('notion_sync_page_' . $post->ID);
            echo '<div class="notice notice-info is-dismissible">';
            echo '<p>La page sera synchronisée avec Notion lors de la prochaine synchronisation automatique, ou vous pouvez cliquer sur "Synchroniser maintenant".</p>';
            echo '</div>';
        }
    }
}
