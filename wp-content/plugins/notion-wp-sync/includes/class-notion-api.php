<?php
/**
 * Classe pour gérer la communication avec l'API Notion
 */

if (!defined('ABSPATH')) {
    exit;
}

class Notion_API {

    /**
     * Instance unique
     */
    private static $instance = null;

    /**
     * Token d'API Notion
     */
    private $api_token;

    /**
     * ID de la base de données Notion
     */
    private $database_id;

    /**
     * URL de base de l'API Notion
     */
    private $api_base_url = 'https://api.notion.com/v1';

    /**
     * Version de l'API Notion
     */
    private $notion_version = '2022-06-28';

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
        $this->api_token = get_option('notion_wp_sync_api_token', '');
        $this->database_id = get_option('notion_wp_sync_database_id', '');
    }

    /**
     * Configure les credentials API
     */
    public function set_credentials($api_token, $database_id) {
        $this->api_token = $api_token;
        $this->database_id = $database_id;
    }

    /**
     * Teste la connexion à l'API Notion
     */
    public function test_connection() {
        if (empty($this->api_token) || empty($this->database_id)) {
            return array(
                'success' => false,
                'message' => 'Token API ou ID de base de données manquant'
            );
        }

        $response = $this->make_request('GET', "databases/{$this->database_id}");

        if (is_wp_error($response)) {
            return array(
                'success' => false,
                'message' => $response->get_error_message()
            );
        }

        return array(
            'success' => true,
            'message' => 'Connexion réussie à Notion',
            'database_name' => $response['title'][0]['plain_text'] ?? 'Base de données'
        );
    }

    /**
     * Récupère toutes les formations depuis Notion
     */
    public function get_formations() {
        if (empty($this->api_token) || empty($this->database_id)) {
            return new WP_Error('missing_credentials', 'Configuration incomplète');
        }

        $all_results = array();
        $has_more = true;
        $start_cursor = null;

        // Pagination de l'API Notion
        while ($has_more) {
            $body = array(
                'page_size' => 100
            );

            if ($start_cursor) {
                $body['start_cursor'] = $start_cursor;
            }

            $response = $this->make_request(
                'POST',
                "databases/{$this->database_id}/query",
                $body
            );

            if (is_wp_error($response)) {
                return $response;
            }

            $all_results = array_merge($all_results, $response['results'] ?? array());
            $has_more = $response['has_more'] ?? false;
            $start_cursor = $response['next_cursor'] ?? null;
        }

        return $this->parse_formations($all_results);
    }

    /**
     * Parse les données Notion en format WordPress
     */
    private function parse_formations($notion_pages) {
        $formations = array();

        foreach ($notion_pages as $page) {
            $properties = $page['properties'];

            $formation = array(
                'notion_id' => $page['id'],
                'title' => $this->get_property_value($properties, 'Nom', 'title'),
                'identifier' => $this->get_property_value($properties, 'Identifiant', 'rich_text'),
                'description' => $this->get_property_value($properties, 'Description', 'rich_text'),
                'duration' => $this->get_property_value($properties, 'Durée', 'rich_text'),
                'price' => $this->get_property_value($properties, 'Prix', 'number'),
                'level' => $this->get_property_value($properties, 'Niveau', 'select'),
                'category' => $this->get_property_value($properties, 'Catégorie', 'select'),
                'prerequisites' => $this->get_property_value($properties, 'Prérequis', 'rich_text'),
                'objectives' => $this->get_property_value($properties, 'Objectifs', 'rich_text'),
                'program' => $this->get_property_value($properties, 'Programme', 'rich_text'),
                'public_target' => $this->get_property_value($properties, 'Public cible', 'rich_text'),
                'methods' => $this->get_property_value($properties, 'Méthodes pédagogiques', 'rich_text'),
                'status' => $this->get_property_value($properties, 'Statut', 'select'),
                'image_url' => $this->get_property_value($properties, 'Image', 'files'),
                'last_edited' => $page['last_edited_time'],
            );

            // Récupérer le contenu de la page si nécessaire
            $formation['content'] = $this->get_page_content($page['id']);

            $formations[] = $formation;
        }

        return $formations;
    }

    /**
     * Récupère la valeur d'une propriété Notion
     */
    private function get_property_value($properties, $property_name, $type) {
        if (!isset($properties[$property_name])) {
            return '';
        }

        $property = $properties[$property_name];

        switch ($type) {
            case 'title':
                return $property['title'][0]['plain_text'] ?? '';

            case 'rich_text':
                if (empty($property['rich_text'])) {
                    return '';
                }
                $texts = array_map(function($text) {
                    return $text['plain_text'] ?? '';
                }, $property['rich_text']);
                return implode('', $texts);

            case 'number':
                return $property['number'] ?? 0;

            case 'select':
                return $property['select']['name'] ?? '';

            case 'multi_select':
                if (empty($property['multi_select'])) {
                    return array();
                }
                return array_map(function($item) {
                    return $item['name'];
                }, $property['multi_select']);

            case 'files':
                if (empty($property['files'])) {
                    return '';
                }
                // Retourner l'URL du premier fichier
                $file = $property['files'][0];
                return $file['file']['url'] ?? $file['external']['url'] ?? '';

            case 'checkbox':
                return $property['checkbox'] ?? false;

            case 'date':
                return $property['date']['start'] ?? '';

            case 'url':
                return $property['url'] ?? '';

            default:
                return '';
        }
    }

    /**
     * Récupère le contenu d'une page Notion
     */
    public function get_page_content($page_id) {
        $response = $this->make_request('GET', "blocks/{$page_id}/children");

        if (is_wp_error($response)) {
            return '';
        }

        return $this->parse_blocks_to_html($response['results'] ?? array());
    }

    /**
     * Convertit les blocks Notion en HTML
     */
    private function parse_blocks_to_html($blocks) {
        $html = '';

        foreach ($blocks as $block) {
            $type = $block['type'];

            switch ($type) {
                case 'paragraph':
                    $text = $this->get_rich_text_content($block['paragraph']['rich_text']);
                    if (!empty($text)) {
                        $html .= '<p>' . $text . '</p>';
                    }
                    break;

                case 'heading_1':
                    $text = $this->get_rich_text_content($block['heading_1']['rich_text']);
                    $html .= '<h1>' . $text . '</h1>';
                    break;

                case 'heading_2':
                    $text = $this->get_rich_text_content($block['heading_2']['rich_text']);
                    $html .= '<h2>' . $text . '</h2>';
                    break;

                case 'heading_3':
                    $text = $this->get_rich_text_content($block['heading_3']['rich_text']);
                    $html .= '<h3>' . $text . '</h3>';
                    break;

                case 'bulleted_list_item':
                    $text = $this->get_rich_text_content($block['bulleted_list_item']['rich_text']);
                    $html .= '<li>' . $text . '</li>';
                    break;

                case 'numbered_list_item':
                    $text = $this->get_rich_text_content($block['numbered_list_item']['rich_text']);
                    $html .= '<li>' . $text . '</li>';
                    break;

                case 'quote':
                    $text = $this->get_rich_text_content($block['quote']['rich_text']);
                    $html .= '<blockquote>' . $text . '</blockquote>';
                    break;

                case 'code':
                    $text = $this->get_rich_text_content($block['code']['rich_text']);
                    $language = $block['code']['language'] ?? 'text';
                    $html .= '<pre><code class="language-' . esc_attr($language) . '">' . esc_html($text) . '</code></pre>';
                    break;

                case 'divider':
                    $html .= '<hr>';
                    break;
            }
        }

        return $html;
    }

    /**
     * Extrait le texte formaté depuis rich_text
     */
    private function get_rich_text_content($rich_text) {
        if (empty($rich_text)) {
            return '';
        }

        $html = '';
        foreach ($rich_text as $text) {
            $content = $text['plain_text'];
            $annotations = $text['annotations'];

            if ($annotations['bold']) {
                $content = '<strong>' . $content . '</strong>';
            }
            if ($annotations['italic']) {
                $content = '<em>' . $content . '</em>';
            }
            if ($annotations['strikethrough']) {
                $content = '<s>' . $content . '</s>';
            }
            if ($annotations['underline']) {
                $content = '<u>' . $content . '</u>';
            }
            if ($annotations['code']) {
                $content = '<code>' . $content . '</code>';
            }
            if (isset($text['href']) && !empty($text['href'])) {
                $content = '<a href="' . esc_url($text['href']) . '">' . $content . '</a>';
            }

            $html .= $content;
        }

        return $html;
    }

    /**
     * Effectue une requête à l'API Notion
     */
    private function make_request($method, $endpoint, $body = null) {
        $url = $this->api_base_url . '/' . ltrim($endpoint, '/');

        $args = array(
            'method' => $method,
            'headers' => array(
                'Authorization' => 'Bearer ' . $this->api_token,
                'Notion-Version' => $this->notion_version,
                'Content-Type' => 'application/json',
            ),
            'timeout' => 30,
        );

        if ($body !== null) {
            $args['body'] = wp_json_encode($body);
        }

        $response = wp_remote_request($url, $args);

        if (is_wp_error($response)) {
            return $response;
        }

        $status_code = wp_remote_retrieve_response_code($response);
        $body = wp_remote_retrieve_body($response);

        if ($status_code >= 400) {
            $error_data = json_decode($body, true);
            $error_message = $error_data['message'] ?? 'Erreur API Notion';
            return new WP_Error('notion_api_error', $error_message, array('status' => $status_code));
        }

        return json_decode($body, true);
    }
}
