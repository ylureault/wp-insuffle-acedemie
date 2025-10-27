<?php
/**
 * Page d'administration du plugin
 */

if (!defined('ABSPATH')) {
    exit;
}

class Notion_Admin_Settings {

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
        add_action('admin_init', array($this, 'register_settings'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'));
    }

    /**
     * Ajoute le menu d'administration
     */
    public function add_menu() {
        add_menu_page(
            'Notion WordPress Sync',
            'Notion Sync',
            'manage_options',
            'notion-wp-sync',
            array($this, 'render_settings_page'),
            'dashicons-update',
            30
        );

        add_submenu_page(
            'notion-wp-sync',
            'Paramètres',
            'Paramètres',
            'manage_options',
            'notion-wp-sync',
            array($this, 'render_settings_page')
        );

        add_submenu_page(
            'notion-wp-sync',
            'Logs de synchronisation',
            'Logs',
            'manage_options',
            'notion-sync-logs',
            array($this, 'render_logs_page')
        );
    }

    /**
     * Enregistre les paramètres
     */
    public function register_settings() {
        register_setting('notion_wp_sync_settings', 'notion_wp_sync_api_token');
        register_setting('notion_wp_sync_settings', 'notion_wp_sync_database_id');
        register_setting('notion_wp_sync_settings', 'notion_wp_sync_auto_sync');
    }

    /**
     * Charge les scripts admin
     */
    public function enqueue_scripts($hook) {
        if ('toplevel_page_notion-wp-sync' !== $hook && 'notion-sync_page_notion-sync-logs' !== $hook) {
            return;
        }

        wp_enqueue_script(
            'notion-wp-sync-admin',
            NOTION_WP_SYNC_PLUGIN_URL . 'admin/js/admin.js',
            array('jquery'),
            NOTION_WP_SYNC_VERSION,
            true
        );

        wp_localize_script('notion-wp-sync-admin', 'notionSyncAjax', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('notion_sync_nonce')
        ));
    }

    /**
     * Affiche la page de paramètres
     */
    public function render_settings_page() {
        if (!current_user_can('manage_options')) {
            return;
        }

        // Sauvegarder les paramètres
        if (isset($_POST['notion_sync_save_settings']) && check_admin_referer('notion_sync_settings')) {
            update_option('notion_wp_sync_api_token', sanitize_text_field($_POST['notion_wp_sync_api_token']));
            update_option('notion_wp_sync_database_id', sanitize_text_field($_POST['notion_wp_sync_database_id']));
            update_option('notion_wp_sync_auto_sync', isset($_POST['notion_wp_sync_auto_sync']) ? '1' : '0');

            echo '<div class="notice notice-success is-dismissible"><p>Paramètres sauvegardés avec succès !</p></div>';
        }

        $api_token = get_option('notion_wp_sync_api_token', '');
        $database_id = get_option('notion_wp_sync_database_id', '');
        $auto_sync = get_option('notion_wp_sync_auto_sync', '1');

        // Tester la connexion si configuré
        $connection_status = null;
        if (!empty($api_token) && !empty($database_id)) {
            $notion_api = Notion_API::get_instance();
            $notion_api->set_credentials($api_token, $database_id);
            $connection_status = $notion_api->test_connection();
        }

        // Récupérer les statistiques
        $stats = $this->get_sync_stats();

        ?>
        <div class="wrap">
            <h1>Notion WordPress Sync - Configuration</h1>

            <div class="notion-sync-dashboard">
                <!-- Statut de la connexion -->
                <?php if ($connection_status): ?>
                    <div class="notice <?php echo $connection_status['success'] ? 'notice-success' : 'notice-error'; ?>">
                        <p><strong>Statut de la connexion :</strong> <?php echo esc_html($connection_status['message']); ?></p>
                        <?php if ($connection_status['success'] && isset($connection_status['database_name'])): ?>
                            <p>Base de données : <strong><?php echo esc_html($connection_status['database_name']); ?></strong></p>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <!-- Statistiques -->
                <div class="notion-sync-stats">
                    <h2>Statistiques de synchronisation</h2>
                    <div class="stats-grid">
                        <div class="stat-card">
                            <div class="stat-number"><?php echo esc_html($stats['total_formations']); ?></div>
                            <div class="stat-label">Formations synchronisées</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-number"><?php echo esc_html($stats['last_sync']); ?></div>
                            <div class="stat-label">Dernière synchronisation</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-number"><?php echo esc_html($stats['success_rate']); ?>%</div>
                            <div class="stat-label">Taux de succès</div>
                        </div>
                    </div>
                </div>

                <!-- Bouton de synchronisation manuelle -->
                <div class="notion-sync-actions">
                    <h2>Actions rapides</h2>
                    <button id="notion-sync-manual" class="button button-primary button-large">
                        <span class="dashicons dashicons-update"></span> Synchroniser maintenant
                    </button>
                    <div id="sync-result" style="margin-top: 10px;"></div>
                </div>

                <!-- Formulaire de configuration -->
                <div class="notion-sync-settings">
                    <h2>Configuration de l'API Notion</h2>

                    <form method="post" action="">
                        <?php wp_nonce_field('notion_sync_settings'); ?>

                        <table class="form-table">
                            <tr>
                                <th scope="row">
                                    <label for="notion_wp_sync_api_token">Token d'API Notion</label>
                                </th>
                                <td>
                                    <input type="text"
                                           id="notion_wp_sync_api_token"
                                           name="notion_wp_sync_api_token"
                                           value="<?php echo esc_attr($api_token); ?>"
                                           class="regular-text"
                                           placeholder="secret_xxxxx">
                                    <p class="description">
                                        Créez une intégration sur <a href="https://www.notion.so/my-integrations" target="_blank">Notion Integrations</a>
                                        et copiez le token ici.
                                    </p>
                                </td>
                            </tr>

                            <tr>
                                <th scope="row">
                                    <label for="notion_wp_sync_database_id">ID de la base de données</label>
                                </th>
                                <td>
                                    <input type="text"
                                           id="notion_wp_sync_database_id"
                                           name="notion_wp_sync_database_id"
                                           value="<?php echo esc_attr($database_id); ?>"
                                           class="regular-text"
                                           placeholder="xxxxx">
                                    <p class="description">
                                        L'ID se trouve dans l'URL de votre base Notion : notion.so/<strong>xxxxx</strong>?v=...
                                    </p>
                                </td>
                            </tr>

                            <tr>
                                <th scope="row">
                                    <label for="notion_wp_sync_auto_sync">Synchronisation automatique</label>
                                </th>
                                <td>
                                    <label>
                                        <input type="checkbox"
                                               id="notion_wp_sync_auto_sync"
                                               name="notion_wp_sync_auto_sync"
                                               value="1"
                                               <?php checked($auto_sync, '1'); ?>>
                                        Activer la synchronisation automatique toutes les heures
                                    </label>
                                </td>
                            </tr>
                        </table>

                        <p class="submit">
                            <button type="submit" name="notion_sync_save_settings" class="button button-primary">
                                Sauvegarder les paramètres
                            </button>
                        </p>
                    </form>
                </div>

                <!-- Instructions -->
                <div class="notion-sync-instructions">
                    <h2>Configuration de votre base Notion</h2>
                    <p>Votre base de données Notion doit contenir les propriétés suivantes pour une synchronisation optimale :</p>

                    <table class="widefat">
                        <thead>
                            <tr>
                                <th>Nom de la propriété</th>
                                <th>Type Notion</th>
                                <th>Description</th>
                                <th>Obligatoire</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>Nom</strong></td>
                                <td>Title</td>
                                <td>Titre de la formation</td>
                                <td>✓</td>
                            </tr>
                            <tr>
                                <td><strong>Identifiant</strong></td>
                                <td>Rich Text</td>
                                <td>Code court (ex: SKE, FAC)</td>
                                <td>✓</td>
                            </tr>
                            <tr>
                                <td><strong>Description</strong></td>
                                <td>Rich Text</td>
                                <td>Description courte de la formation</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><strong>Durée</strong></td>
                                <td>Rich Text</td>
                                <td>Durée (ex: "2 jours", "14 heures")</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><strong>Prix</strong></td>
                                <td>Number</td>
                                <td>Prix en euros HT</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><strong>Niveau</strong></td>
                                <td>Select</td>
                                <td>Niveau (Débutant, Intermédiaire, Avancé)</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><strong>Catégorie</strong></td>
                                <td>Select</td>
                                <td>Catégorie de formation</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><strong>Prérequis</strong></td>
                                <td>Rich Text</td>
                                <td>Prérequis de la formation</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><strong>Objectifs</strong></td>
                                <td>Rich Text</td>
                                <td>Objectifs pédagogiques</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><strong>Programme</strong></td>
                                <td>Rich Text</td>
                                <td>Programme détaillé</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><strong>Public cible</strong></td>
                                <td>Rich Text</td>
                                <td>À qui s'adresse la formation</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><strong>Méthodes pédagogiques</strong></td>
                                <td>Rich Text</td>
                                <td>Méthodes utilisées</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><strong>Statut</strong></td>
                                <td>Select</td>
                                <td>Publié, Brouillon, En cours, Archivé</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><strong>Image</strong></td>
                                <td>Files</td>
                                <td>Image de la formation</td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <style>
            .notion-sync-dashboard {
                max-width: 1200px;
            }

            .notion-sync-stats,
            .notion-sync-actions,
            .notion-sync-settings,
            .notion-sync-instructions {
                background: #fff;
                padding: 20px;
                margin: 20px 0;
                border: 1px solid #ccd0d4;
                box-shadow: 0 1px 1px rgba(0,0,0,.04);
            }

            .stats-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 20px;
                margin-top: 20px;
            }

            .stat-card {
                background: #f0f0f1;
                padding: 20px;
                border-radius: 4px;
                text-align: center;
            }

            .stat-number {
                font-size: 36px;
                font-weight: bold;
                color: #2271b1;
                margin-bottom: 5px;
            }

            .stat-label {
                font-size: 14px;
                color: #646970;
            }

            #notion-sync-manual {
                display: inline-flex;
                align-items: center;
                gap: 8px;
            }

            #notion-sync-manual .dashicons {
                font-size: 20px;
                width: 20px;
                height: 20px;
            }

            #notion-sync-manual.loading .dashicons {
                animation: rotation 1s linear infinite;
            }

            @keyframes rotation {
                from { transform: rotate(0deg); }
                to { transform: rotate(360deg); }
            }

            .widefat tbody tr:nth-child(even) {
                background: #f9f9f9;
            }
        </style>
        <?php
    }

    /**
     * Affiche la page des logs
     */
    public function render_logs_page() {
        if (!current_user_can('manage_options')) {
            return;
        }

        global $wpdb;
        $table_name = $wpdb->prefix . 'notion_sync_log';

        // Pagination
        $per_page = 50;
        $page = isset($_GET['paged']) ? max(1, intval($_GET['paged'])) : 1;
        $offset = ($page - 1) * $per_page;

        $total_logs = $wpdb->get_var("SELECT COUNT(*) FROM $table_name");
        $logs = $wpdb->get_results($wpdb->prepare(
            "SELECT * FROM $table_name ORDER BY synced_at DESC LIMIT %d OFFSET %d",
            $per_page,
            $offset
        ));

        $total_pages = ceil($total_logs / $per_page);

        ?>
        <div class="wrap">
            <h1>Logs de synchronisation</h1>

            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Action</th>
                        <th>Statut</th>
                        <th>Notion ID</th>
                        <th>Post ID</th>
                        <th>Message</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($logs)): ?>
                        <tr>
                            <td colspan="6">Aucun log disponible</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($logs as $log): ?>
                            <tr>
                                <td><?php echo esc_html(date_i18n('d/m/Y H:i:s', strtotime($log->synced_at))); ?></td>
                                <td><?php echo esc_html($log->action); ?></td>
                                <td>
                                    <span class="status-badge status-<?php echo esc_attr($log->status); ?>">
                                        <?php echo esc_html($log->status); ?>
                                    </span>
                                </td>
                                <td><?php echo esc_html(substr($log->notion_id, 0, 12) . '...'); ?></td>
                                <td>
                                    <?php if ($log->wp_post_id): ?>
                                        <a href="<?php echo get_edit_post_link($log->wp_post_id); ?>" target="_blank">
                                            #<?php echo esc_html($log->wp_post_id); ?>
                                        </a>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>
                                <td><?php echo esc_html($log->message); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>

            <?php if ($total_pages > 1): ?>
                <div class="tablenav bottom">
                    <div class="tablenav-pages">
                        <?php
                        echo paginate_links(array(
                            'base' => add_query_arg('paged', '%#%'),
                            'format' => '',
                            'prev_text' => '&laquo;',
                            'next_text' => '&raquo;',
                            'total' => $total_pages,
                            'current' => $page
                        ));
                        ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <style>
            .status-badge {
                padding: 3px 8px;
                border-radius: 3px;
                font-size: 12px;
                font-weight: 600;
            }

            .status-success {
                background: #d4edda;
                color: #155724;
            }

            .status-error {
                background: #f8d7da;
                color: #721c24;
            }

            .status-info {
                background: #d1ecf1;
                color: #0c5460;
            }
        </style>
        <?php
    }

    /**
     * Récupère les statistiques de synchronisation
     */
    private function get_sync_stats() {
        global $wpdb;

        $stats = array(
            'total_formations' => 0,
            'last_sync' => 'Jamais',
            'success_rate' => 0
        );

        // Nombre total de formations synchronisées dans la table
        $formations_table = $wpdb->prefix . 'notion_formations';
        $stats['total_formations'] = $wpdb->get_var("SELECT COUNT(*) FROM $formations_table");

        // Dernière synchronisation
        $table_name = $wpdb->prefix . 'notion_sync_log';
        $last_sync = $wpdb->get_var("SELECT synced_at FROM $table_name ORDER BY synced_at DESC LIMIT 1");
        if ($last_sync) {
            $stats['last_sync'] = human_time_diff(strtotime($last_sync), current_time('timestamp')) . ' ago';
        }

        // Taux de succès (dernières 100 opérations)
        $total_ops = $wpdb->get_var("SELECT COUNT(*) FROM $table_name LIMIT 100");
        if ($total_ops > 0) {
            $success_ops = $wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE status = 'success' LIMIT 100");
            $stats['success_rate'] = round(($success_ops / $total_ops) * 100);
        }

        return $stats;
    }
}
