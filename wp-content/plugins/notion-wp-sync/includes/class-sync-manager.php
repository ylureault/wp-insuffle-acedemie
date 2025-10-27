<?php
/**
 * Gestionnaire de synchronisation Notion vers WordPress
 */

if (!defined('ABSPATH')) {
    exit;
}

class Notion_Sync_Manager {

    /**
     * Instance unique
     */
    private static $instance = null;

    /**
     * Instance de l'API Notion
     */
    private $notion_api;

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
        $this->notion_api = Notion_API::get_instance();

        // Hook pour le cron de synchronisation
        add_action('notion_wp_sync_cron', array($this, 'run_sync'));

        // Hook AJAX pour la synchronisation manuelle
        add_action('wp_ajax_notion_sync_manual', array($this, 'ajax_manual_sync'));
        add_action('wp_ajax_notion_sync_single_page', array($this, 'ajax_sync_single_page'));
    }

    /**
     * Lance la synchronisation complète
     */
    public function run_sync() {
        $formations = $this->notion_api->get_formations();

        if (is_wp_error($formations)) {
            $this->log_sync('error', '', 0, 'sync_failed', $formations->get_error_message());
            return array(
                'success' => false,
                'message' => $formations->get_error_message()
            );
        }

        $results = array(
            'synced' => 0,
            'updated_pages' => 0,
            'errors' => 0,
        );

        foreach ($formations as $formation) {
            $result = $this->sync_formation($formation);

            if ($result['success']) {
                $results['synced']++;
                $results['updated_pages'] += $result['pages_updated'];
            } else {
                $results['errors']++;
            }
        }

        $message = sprintf(
            'Synchronisation terminée : %d formations synchronisées, %d pages mises à jour, %d erreurs',
            $results['synced'],
            $results['updated_pages'],
            $results['errors']
        );

        $this->log_sync('info', '', 0, 'sync_completed', $message);

        return array(
            'success' => true,
            'message' => $message,
            'results' => $results
        );
    }

    /**
     * Synchronise une formation
     */
    private function sync_formation($formation) {
        global $wpdb;

        $table_name = $wpdb->prefix . 'notion_formations';

        // Vérifier si la formation existe déjà
        $existing = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM $table_name WHERE identifier = %s",
            $formation['identifier']
        ));

        // Générer le contenu Gutenberg
        $content = $this->generate_gutenberg_content($formation);

        // Préparer les données
        $data = array(
            'notion_id' => $formation['notion_id'],
            'identifier' => $formation['identifier'],
            'title' => $formation['title'],
            'description' => $formation['description'],
            'duration' => $formation['duration'],
            'price' => $formation['price'],
            'level' => $formation['level'],
            'category' => $formation['category'],
            'prerequisites' => $formation['prerequisites'],
            'objectives' => $formation['objectives'],
            'program' => $formation['program'],
            'public_target' => $formation['public_target'],
            'methods' => $formation['methods'],
            'status' => $formation['status'],
            'image_url' => $formation['image_url'],
            'content' => $content,
            'last_edited' => $formation['last_edited'],
            'synced_at' => current_time('mysql'),
        );

        $format = array('%s', '%s', '%s', '%s', '%s', '%f', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s');

        // Insérer ou mettre à jour dans la base
        if ($existing) {
            $wpdb->update(
                $table_name,
                $data,
                array('identifier' => $formation['identifier']),
                $format,
                array('%s')
            );
        } else {
            $wpdb->insert($table_name, $data, $format);
        }

        // Mettre à jour les pages WordPress associées
        $pages_updated = $this->update_associated_pages($formation['identifier']);

        $this->log_sync(
            'success',
            $formation['notion_id'],
            0,
            'formation_synced',
            sprintf('Formation %s synchronisée, %d page(s) mise(s) à jour', $formation['identifier'], $pages_updated)
        );

        return array(
            'success' => true,
            'pages_updated' => $pages_updated
        );
    }

    /**
     * Met à jour toutes les pages WordPress associées à une formation
     */
    private function update_associated_pages($formation_id) {
        // Trouver toutes les pages qui ont cet identifiant de formation
        $args = array(
            'post_type' => 'page',
            'posts_per_page' => -1,
            'meta_query' => array(
                array(
                    'key' => '_notion_formation_id',
                    'value' => $formation_id,
                    'compare' => '='
                ),
                array(
                    'key' => '_notion_auto_sync',
                    'value' => '1',
                    'compare' => '='
                )
            )
        );

        $query = new WP_Query($args);
        $updated_count = 0;

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $post_id = get_the_ID();

                if ($this->update_page_content($post_id, $formation_id)) {
                    $updated_count++;
                }
            }
            wp_reset_postdata();
        }

        return $updated_count;
    }

    /**
     * Met à jour le contenu d'une page WordPress avec les données Notion
     */
    public function update_page_content($post_id, $formation_id) {
        global $wpdb;

        // Récupérer la formation depuis la base
        $table_name = $wpdb->prefix . 'notion_formations';
        $formation = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM $table_name WHERE identifier = %s",
            $formation_id
        ), ARRAY_A);

        if (!$formation) {
            return false;
        }

        // Mettre à jour le contenu de la page
        $post_data = array(
            'ID' => $post_id,
            'post_content' => $formation['content'],
        );

        $result = wp_update_post($post_data);

        if (is_wp_error($result)) {
            return false;
        }

        // Mettre à jour la meta de dernière synchronisation
        update_post_meta($post_id, '_notion_last_sync', current_time('mysql'));

        // Gérer l'image à la une si elle existe
        if (!empty($formation['image_url'])) {
            $this->set_featured_image($post_id, $formation['image_url']);
        }

        return true;
    }

    /**
     * Génère le contenu Gutenberg complet
     */
    private function generate_gutenberg_content($formation) {
        $blocks = array();

        // Section d'introduction
        $blocks[] = $this->create_section_grey(
            $this->create_heading($formation['title'], 2, 'center') .
            $this->create_paragraph($this->generate_excerpt($formation), 'center', 'medium') .
            $this->create_paragraph($formation['description'], 'center')
        );

        $blocks[] = $this->create_spacer('60px');

        // Informations pratiques
        $blocks[] = $this->create_info_pratiques($formation);

        $blocks[] = $this->create_spacer('60px');

        // Objectifs pédagogiques
        if (!empty($formation['objectives'])) {
            $blocks[] = $this->create_heading('Objectifs pédagogiques', 2, 'center');
            $blocks[] = $this->create_spacer('30px');
            $blocks[] = $this->create_objectives_section($formation['objectives']);
            $blocks[] = $this->create_spacer('60px');
        }

        // Public cible
        if (!empty($formation['public_target'])) {
            $blocks[] = $this->create_heading('À qui s\'adresse cette formation ?', 2, 'center');
            $blocks[] = $this->create_paragraph($formation['public_target'], 'center');
            $blocks[] = $this->create_spacer('40px');
        }

        // Prérequis
        if (!empty($formation['prerequisites'])) {
            $blocks[] = $this->create_section_grey(
                $this->create_heading('Prérequis', 3, 'center') .
                $this->create_paragraph($formation['prerequisites'], 'center')
            );
            $blocks[] = $this->create_spacer('60px');
        }

        // Programme détaillé
        if (!empty($formation['program'])) {
            $blocks[] = $this->create_heading('Programme détaillé', 2, 'center');
            $blocks[] = $this->create_spacer('30px');
            $blocks[] = $this->create_program_section($formation['program']);
            $blocks[] = $this->create_spacer('60px');
        }

        // Méthodes pédagogiques
        if (!empty($formation['methods'])) {
            $blocks[] = $this->create_heading('Méthodes pédagogiques', 2, 'center');
            $blocks[] = $this->create_spacer('30px');
            $blocks[] = $this->create_paragraph($formation['methods'], 'center');
            $blocks[] = $this->create_spacer('60px');
        }

        // Section d'inscription (CTA)
        $blocks[] = $this->create_cta_section($formation);

        return implode("\n\n", $blocks);
    }

    /**
     * Crée une section avec fond gris
     */
    private function create_section_grey($content) {
        return '<!-- wp:group {"className":"section-grey","layout":{"type":"constrained"}} -->
<div class="wp-block-group section-grey">' . $content . '</div>
<!-- /wp:group -->';
    }

    /**
     * Crée une section avec fond primary
     */
    private function create_section_primary($content) {
        return '<!-- wp:group {"className":"section-primary","layout":{"type":"constrained"}} -->
<div class="wp-block-group section-primary">' . $content . '</div>
<!-- /wp:group -->';
    }

    /**
     * Crée un heading
     */
    private function create_heading($text, $level = 2, $align = '') {
        $align_attr = $align ? ' {"textAlign":"' . $align . '"}' : '';
        $align_class = $align ? ' has-text-align-' . $align : '';
        return '<!-- wp:heading ' . $align_attr . ' -->
<h' . $level . ' class="wp-block-heading' . $align_class . '">' . esc_html($text) . '</h' . $level . '>
<!-- /wp:heading -->';
    }

    /**
     * Crée un paragraphe
     */
    private function create_paragraph($text, $align = '', $size = '') {
        $attrs = array();
        if ($align) $attrs[] = '"align":"' . $align . '"';
        if ($size) $attrs[] = '"fontSize":"' . $size . '"';

        $attr_string = !empty($attrs) ? ' {' . implode(',', $attrs) . '}' : '';

        $classes = array();
        if ($align) $classes[] = 'has-text-align-' . $align;
        if ($size) $classes[] = 'has-' . $size . '-font-size';

        $class_string = !empty($classes) ? ' class="' . implode(' ', $classes) . '"' : '';

        return '<!-- wp:paragraph' . $attr_string . ' -->
<p' . $class_string . '>' . wp_kses_post($text) . '</p>
<!-- /wp:paragraph -->';
    }

    /**
     * Crée un spacer
     */
    private function create_spacer($height = '60px') {
        return '<!-- wp:spacer {"height":"' . $height . '"} -->
<div style="height:' . $height . '" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer -->';
    }

    /**
     * Crée la section d'informations pratiques
     */
    private function create_info_pratiques($formation) {
        $duration = !empty($formation['duration']) ? $formation['duration'] : 'N/A';
        $price = !empty($formation['price']) ? number_format($formation['price'], 2, ',', ' ') . '€ HT' : 'Sur devis';

        return $this->create_section_primary(
            $this->create_heading('Informations pratiques', 2, 'center') .
            '<!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column -->
<div class="wp-block-column">' .
            $this->create_heading('Durée', 4, 'center') .
            $this->create_paragraph($duration, 'center') .
            '</div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column">' .
            $this->create_heading('Tarif', 4, 'center') .
            $this->create_paragraph($price, 'center') .
            '</div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column">' .
            $this->create_heading('Niveau', 4, 'center') .
            $this->create_paragraph($formation['level'] ?: 'Tous niveaux', 'center') .
            '</div>
<!-- /wp:column --></div>
<!-- /wp:columns -->'
        );
    }

    /**
     * Crée la section des objectifs
     */
    private function create_objectives_section($objectives_text) {
        // Convertir le texte en liste si ce n'est pas déjà fait
        $objectives = explode("\n", trim($objectives_text));
        $list_items = '';

        foreach ($objectives as $objective) {
            $objective = trim($objective);
            if (empty($objective)) continue;

            // Nettoyer les puces existantes
            $objective = preg_replace('/^[-•*]\s*/', '', $objective);

            $list_items .= '<!-- wp:list-item -->
<li>' . esc_html($objective) . '</li>
<!-- /wp:list-item -->

';
        }

        return '<!-- wp:list -->
<ul class="wp-block-list">' . $list_items . '</ul>
<!-- /wp:list -->';
    }

    /**
     * Crée la section du programme
     */
    private function create_program_section($program_text) {
        return $this->create_paragraph($program_text);
    }

    /**
     * Crée la section CTA d'inscription
     */
    private function create_cta_section($formation) {
        return $this->create_section_primary(
            $this->create_heading('Prêt à vous inscrire ?', 2, 'center') .
            $this->create_paragraph('Rejoignez ' . esc_html($formation['title']) . ' et développez vos compétences', 'center', 'large') .
            $this->create_spacer('30px') .
            '<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons"><!-- wp:button {"className":"is-style-fill"} -->
<div class="wp-block-button is-style-fill"><a class="wp-block-button__link wp-element-button" href="mailto:contact@insuffle-academie.com?subject=Inscription ' . esc_attr($formation['identifier']) . '">Je m\'inscris</a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="tel:+33980808962">☎ 09 80 80 89 62</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons -->'
        );
    }

    /**
     * Génère l'extrait de la formation
     */
    private function generate_excerpt($formation) {
        if (!empty($formation['description'])) {
            return wp_trim_words($formation['description'], 30, '...');
        }
        return '';
    }

    /**
     * Télécharge et définit l'image à la une
     */
    private function set_featured_image($post_id, $image_url) {
        // Vérifier si l'image est déjà définie
        $current_thumbnail = get_post_thumbnail_id($post_id);
        if ($current_thumbnail) {
            $current_url = wp_get_attachment_url($current_thumbnail);
            // Si c'est la même URL, ne pas re-télécharger
            if (strpos($image_url, basename($current_url)) !== false) {
                return;
            }
        }

        require_once(ABSPATH . 'wp-admin/includes/media.php');
        require_once(ABSPATH . 'wp-admin/includes/file.php');
        require_once(ABSPATH . 'wp-admin/includes/image.php');

        $image_id = media_sideload_image($image_url, $post_id, null, 'id');

        if (!is_wp_error($image_id)) {
            set_post_thumbnail($post_id, $image_id);
        }
    }

    /**
     * Enregistre un log de synchronisation
     */
    private function log_sync($level, $notion_id, $wp_post_id, $action, $message) {
        global $wpdb;

        $table_name = $wpdb->prefix . 'notion_sync_log';

        $wpdb->insert(
            $table_name,
            array(
                'notion_id' => $notion_id,
                'wp_post_id' => $wp_post_id,
                'action' => $action,
                'status' => $level,
                'message' => $message,
                'synced_at' => current_time('mysql'),
            ),
            array('%s', '%d', '%s', '%s', '%s', '%s')
        );

        // Logger aussi dans le log WordPress
        if ($level === 'error') {
            error_log("Notion Sync Error: $message");
        }
    }

    /**
     * AJAX: Synchronisation manuelle complète
     */
    public function ajax_manual_sync() {
        check_ajax_referer('notion_sync_nonce', 'nonce');

        if (!current_user_can('manage_options')) {
            wp_send_json_error(array('message' => 'Permissions insuffisantes'));
        }

        $result = $this->run_sync();

        if ($result['success']) {
            wp_send_json_success($result);
        } else {
            wp_send_json_error($result);
        }
    }

    /**
     * AJAX: Synchronisation d'une seule page
     */
    public function ajax_sync_single_page() {
        check_ajax_referer('notion_sync_single_page', 'nonce');

        if (!current_user_can('edit_posts')) {
            wp_send_json_error(array('message' => 'Permissions insuffisantes'));
        }

        $post_id = intval($_POST['post_id']);
        $formation_id = get_post_meta($post_id, '_notion_formation_id', true);

        if (empty($formation_id)) {
            wp_send_json_error(array('message' => 'Aucun identifiant de formation associé'));
        }

        if ($this->update_page_content($post_id, $formation_id)) {
            wp_send_json_success(array('message' => 'Page synchronisée avec succès'));
        } else {
            wp_send_json_error(array('message' => 'Erreur lors de la synchronisation'));
        }
    }
}
