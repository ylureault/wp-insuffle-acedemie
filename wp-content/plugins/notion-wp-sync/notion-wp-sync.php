<?php
/**
 * Plugin Name: Notion WordPress Sync
 * Plugin URI: https://insuffle-academy.com
 * Description: Synchronise automatiquement les formations depuis une base de données Notion vers WordPress
 * Version: 1.0.0
 * Author: Insuffle Academy
 * Author URI: https://insuffle-academy.com
 * License: GPL v2 or later
 * Text Domain: notion-wp-sync
 */

// Sécurité : empêcher l'accès direct
if (!defined('ABSPATH')) {
    exit;
}

// Définir les constantes du plugin
define('NOTION_WP_SYNC_VERSION', '1.0.0');
define('NOTION_WP_SYNC_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('NOTION_WP_SYNC_PLUGIN_URL', plugin_dir_url(__FILE__));

/**
 * Classe principale du plugin
 */
class Notion_WP_Sync {

    /**
     * Instance unique du plugin (Singleton)
     */
    private static $instance = null;

    /**
     * Retourne l'instance unique du plugin
     */
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Constructeur privé (Singleton)
     */
    private function __construct() {
        $this->load_dependencies();
        $this->init_hooks();
    }

    /**
     * Charge les dépendances du plugin
     */
    private function load_dependencies() {
        require_once NOTION_WP_SYNC_PLUGIN_DIR . 'includes/class-notion-api.php';
        require_once NOTION_WP_SYNC_PLUGIN_DIR . 'includes/class-formation-post-type.php';
        require_once NOTION_WP_SYNC_PLUGIN_DIR . 'includes/class-sync-manager.php';
        require_once NOTION_WP_SYNC_PLUGIN_DIR . 'admin/class-admin-settings.php';
    }

    /**
     * Initialise les hooks WordPress
     */
    private function init_hooks() {
        // Hooks d'activation/désactivation
        register_activation_hook(__FILE__, array($this, 'activate'));
        register_deactivation_hook(__FILE__, array($this, 'deactivate'));

        // Hook d'initialisation
        add_action('init', array($this, 'init'));

        // Hook admin
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_assets'));
    }

    /**
     * Initialise le plugin
     */
    public function init() {
        // Initialiser le Custom Post Type
        Notion_Formation_Post_Type::get_instance();

        // Initialiser le gestionnaire de synchronisation
        Notion_Sync_Manager::get_instance();
    }

    /**
     * Ajoute le menu d'administration
     */
    public function add_admin_menu() {
        Notion_Admin_Settings::get_instance()->add_menu();
    }

    /**
     * Charge les assets admin
     */
    public function enqueue_admin_assets($hook) {
        // Charger uniquement sur la page du plugin
        if ('toplevel_page_notion-wp-sync' !== $hook) {
            return;
        }

        wp_enqueue_style(
            'notion-wp-sync-admin',
            NOTION_WP_SYNC_PLUGIN_URL . 'admin/css/admin.css',
            array(),
            NOTION_WP_SYNC_VERSION
        );
    }

    /**
     * Actions lors de l'activation du plugin
     */
    public function activate() {
        // Créer les tables si nécessaire
        $this->create_tables();

        // Flush rewrite rules
        Notion_Formation_Post_Type::get_instance();
        flush_rewrite_rules();

        // Planifier le cron de synchronisation
        if (!wp_next_scheduled('notion_wp_sync_cron')) {
            wp_schedule_event(time(), 'hourly', 'notion_wp_sync_cron');
        }
    }

    /**
     * Actions lors de la désactivation du plugin
     */
    public function deactivate() {
        // Supprimer le cron
        $timestamp = wp_next_scheduled('notion_wp_sync_cron');
        if ($timestamp) {
            wp_unschedule_event($timestamp, 'notion_wp_sync_cron');
        }

        // Flush rewrite rules
        flush_rewrite_rules();
    }

    /**
     * Crée les tables nécessaires
     */
    private function create_tables() {
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();
        $table_name = $wpdb->prefix . 'notion_sync_log';

        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            notion_id varchar(100) NOT NULL,
            wp_post_id bigint(20) NOT NULL,
            action varchar(50) NOT NULL,
            status varchar(50) NOT NULL,
            message text,
            synced_at datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
            PRIMARY KEY  (id),
            KEY notion_id (notion_id),
            KEY wp_post_id (wp_post_id)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
}

/**
 * Démarre le plugin
 */
function notion_wp_sync() {
    return Notion_WP_Sync::get_instance();
}

// Démarrer le plugin
notion_wp_sync();
