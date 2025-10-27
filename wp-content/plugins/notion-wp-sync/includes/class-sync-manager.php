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
    }

    /**
     * Lance la synchronisation
     */
    public function run_sync() {
        $formations = $this->notion_api->get_formations();

        if (is_wp_error($formations)) {
            $this->log_sync('error', 0, 0, 'sync_failed', $formations->get_error_message());
            return array(
                'success' => false,
                'message' => $formations->get_error_message()
            );
        }

        $results = array(
            'created' => 0,
            'updated' => 0,
            'skipped' => 0,
            'errors' => 0,
        );

        foreach ($formations as $formation) {
            $result = $this->sync_formation($formation);

            if ($result['success']) {
                if ($result['action'] === 'created') {
                    $results['created']++;
                } elseif ($result['action'] === 'updated') {
                    $results['updated']++;
                } else {
                    $results['skipped']++;
                }
            } else {
                $results['errors']++;
            }
        }

        $message = sprintf(
            'Synchronisation terminée : %d créées, %d mises à jour, %d ignorées, %d erreurs',
            $results['created'],
            $results['updated'],
            $results['skipped'],
            $results['errors']
        );

        $this->log_sync('info', 0, 0, 'sync_completed', $message);

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
        // Vérifier si la formation existe déjà
        $existing_post = $this->find_existing_post($formation['notion_id']);

        if ($existing_post) {
            // Vérifier si une mise à jour est nécessaire
            $last_sync = get_post_meta($existing_post->ID, '_last_sync_date', true);
            $notion_last_edited = strtotime($formation['last_edited']);

            if ($last_sync && strtotime($last_sync) >= $notion_last_edited) {
                return array(
                    'success' => true,
                    'action' => 'skipped',
                    'post_id' => $existing_post->ID,
                    'message' => 'Aucune modification détectée'
                );
            }

            // Mettre à jour
            return $this->update_formation($existing_post->ID, $formation);
        } else {
            // Créer
            return $this->create_formation($formation);
        }
    }

    /**
     * Trouve un post existant par Notion ID
     */
    private function find_existing_post($notion_id) {
        $args = array(
            'post_type' => Notion_Formation_Post_Type::get_post_type_name(),
            'posts_per_page' => 1,
            'meta_query' => array(
                array(
                    'key' => '_notion_id',
                    'value' => $notion_id,
                    'compare' => '='
                )
            )
        );

        $query = new WP_Query($args);
        return $query->have_posts() ? $query->posts[0] : null;
    }

    /**
     * Crée une nouvelle formation
     */
    private function create_formation($formation) {
        // Générer le contenu Gutenberg
        $content = $this->generate_gutenberg_content($formation);

        $post_data = array(
            'post_title' => $formation['title'],
            'post_content' => $content,
            'post_status' => $this->get_post_status($formation['status']),
            'post_type' => Notion_Formation_Post_Type::get_post_type_name(),
            'post_excerpt' => $this->generate_excerpt($formation),
        );

        $post_id = wp_insert_post($post_data);

        if (is_wp_error($post_id)) {
            $this->log_sync('error', 0, 0, 'create_failed', $post_id->get_error_message());
            return array(
                'success' => false,
                'message' => $post_id->get_error_message()
            );
        }

        // Sauvegarder les métadonnées
        $this->save_formation_meta($post_id, $formation);

        // Définir les taxonomies
        $this->set_formation_taxonomies($post_id, $formation);

        // Télécharger et définir l'image à la une
        if (!empty($formation['image_url'])) {
            $this->set_featured_image($post_id, $formation['image_url']);
        }

        $this->log_sync('success', $formation['notion_id'], $post_id, 'created', 'Formation créée avec succès');

        return array(
            'success' => true,
            'action' => 'created',
            'post_id' => $post_id,
            'message' => 'Formation créée'
        );
    }

    /**
     * Met à jour une formation existante
     */
    private function update_formation($post_id, $formation) {
        // Générer le contenu Gutenberg
        $content = $this->generate_gutenberg_content($formation);

        $post_data = array(
            'ID' => $post_id,
            'post_title' => $formation['title'],
            'post_content' => $content,
            'post_status' => $this->get_post_status($formation['status']),
            'post_excerpt' => $this->generate_excerpt($formation),
        );

        $result = wp_update_post($post_data);

        if (is_wp_error($result)) {
            $this->log_sync('error', $formation['notion_id'], $post_id, 'update_failed', $result->get_error_message());
            return array(
                'success' => false,
                'message' => $result->get_error_message()
            );
        }

        // Mettre à jour les métadonnées
        $this->save_formation_meta($post_id, $formation);

        // Mettre à jour les taxonomies
        $this->set_formation_taxonomies($post_id, $formation);

        // Mettre à jour l'image à la une
        if (!empty($formation['image_url'])) {
            $this->set_featured_image($post_id, $formation['image_url']);
        }

        $this->log_sync('success', $formation['notion_id'], $post_id, 'updated', 'Formation mise à jour avec succès');

        return array(
            'success' => true,
            'action' => 'updated',
            'post_id' => $post_id,
            'message' => 'Formation mise à jour'
        );
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
     * Sauvegarde les métadonnées de la formation
     */
    private function save_formation_meta($post_id, $formation) {
        $meta_fields = array(
            '_notion_id' => $formation['notion_id'],
            '_formation_identifier' => $formation['identifier'],
            '_formation_duration' => $formation['duration'],
            '_formation_price' => $formation['price'],
            '_formation_prerequisites' => $formation['prerequisites'],
            '_formation_objectives' => $formation['objectives'],
            '_formation_program' => $formation['program'],
            '_formation_public_target' => $formation['public_target'],
            '_formation_methods' => $formation['methods'],
            '_last_sync_date' => current_time('mysql'),
        );

        foreach ($meta_fields as $key => $value) {
            update_post_meta($post_id, $key, $value);
        }
    }

    /**
     * Définit les taxonomies de la formation
     */
    private function set_formation_taxonomies($post_id, $formation) {
        // Catégorie
        if (!empty($formation['category'])) {
            $category_term = get_term_by('name', $formation['category'], 'formation_category');
            if (!$category_term) {
                $category_term = wp_insert_term($formation['category'], 'formation_category');
                if (!is_wp_error($category_term)) {
                    $category_term = get_term($category_term['term_id'], 'formation_category');
                }
            }
            if (!is_wp_error($category_term) && $category_term) {
                wp_set_object_terms($post_id, array($category_term->term_id), 'formation_category');
            }
        }

        // Niveau
        if (!empty($formation['level'])) {
            $level_term = get_term_by('name', $formation['level'], 'formation_level');
            if (!$level_term) {
                $level_term = wp_insert_term($formation['level'], 'formation_level');
                if (!is_wp_error($level_term)) {
                    $level_term = get_term($level_term['term_id'], 'formation_level');
                }
            }
            if (!is_wp_error($level_term) && $level_term) {
                wp_set_object_terms($post_id, array($level_term->term_id), 'formation_level');
            }
        }
    }

    /**
     * Télécharge et définit l'image à la une
     */
    private function set_featured_image($post_id, $image_url) {
        require_once(ABSPATH . 'wp-admin/includes/media.php');
        require_once(ABSPATH . 'wp-admin/includes/file.php');
        require_once(ABSPATH . 'wp-admin/includes/image.php');

        $image_id = media_sideload_image($image_url, $post_id, null, 'id');

        if (!is_wp_error($image_id)) {
            set_post_thumbnail($post_id, $image_id);
        }
    }

    /**
     * Convertit le statut Notion en statut WordPress
     */
    private function get_post_status($notion_status) {
        $status_map = array(
            'Publié' => 'publish',
            'Brouillon' => 'draft',
            'En cours' => 'draft',
            'Archivé' => 'draft',
        );

        return isset($status_map[$notion_status]) ? $status_map[$notion_status] : 'draft';
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
     * AJAX: Synchronisation manuelle
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
}
