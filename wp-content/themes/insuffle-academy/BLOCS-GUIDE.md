# 🧩 Guide des Blocs Gutenberg - Insuffle Academy

Ce document explique comment créer et utiliser des blocs Gutenberg personnalisés pour le thème Insuffle Academy.

## 📋 Table des Matières

1. [Structure d'un Bloc](#structure-dun-bloc)
2. [Blocs Disponibles](#blocs-disponibles)
3. [Comment Créer un Nouveau Bloc](#comment-créer-un-nouveau-bloc)
4. [Exemples de Blocs](#exemples-de-blocs)

## Structure d'un Bloc

Chaque bloc personnalisé suit cette structure :

```
blocks/
└── nom-du-bloc/
    ├── block.json        # Métadonnées du bloc
    ├── index.php         # Rendu côté serveur
    ├── style.css         # Styles front-end
    ├── editor.css        # Styles éditeur
    └── script.js         # JavaScript (optionnel)
```

## Blocs Disponibles

### 🦸 Hero Block
**Catégorie** : Insuffle Blocks
**Description** : Section hero avec animations gamifiées

**Attributs** :
- `emoji` : Emoji principal (défaut: 🎮)
- `badge` : Texte du badge supérieur
- `title` : Titre principal
- `subtitle` : Sous-titre
- `description` : Description
- `primaryButtonText` : Texte bouton primaire
- `primaryButtonUrl` : URL bouton primaire
- `secondaryButtonText` : Texte bouton secondaire
- `secondaryButtonUrl` : URL bouton secondaire

**Usage** :
```
<!-- wp:insuffle/hero {
    "title": "FACILIT'ACADEMY",
    "subtitle": "Devenez Facilitateur Légendaire"
} /-->
```

### 📊 Stats Block
**Catégorie** : Insuffle Blocks
**Description** : Affichage de statistiques animées

**Attributs** :
- `stats` : Array de statistiques avec `number`, `label`

**Usage** :
```
<!-- wp:insuffle/stats {
    "stats": [
        {"number": "96%", "label": "Satisfaction"},
        {"number": "6", "label": "Badges"}
    ]
} /-->
```

### 🏅 Badges Block
**Catégorie** : Insuffle Blocks
**Description** : Grille de badges de compétences

**Attributs** :
- `badges` : Array de badges avec `icon`, `name`, `skills[]`

### 📅 Timeline Block
**Catégorie** : Insuffle Blocks
**Description** : Timeline de programme

**Attributs** :
- `days` : Array de journées avec `title`, `subtitle`, `items[]`

### 💬 Testimonials Block
**Catégorie** : Insuffle Blocks
**Description** : Témoignages clients

**Attributs** :
- `testimonials` : Array avec `text`, `author`, `role`, `avatar`

### 💰 Pricing Block
**Catégorie** : Insuffle Blocks
**Description** : Carte de tarification

**Attributs** :
- `badge` : Badge urgent
- `title` : Titre
- `priceText` : Texte du prix
- `pricePeriod` : Période
- `includes` : Array d'inclusions

### 📆 Dates Block
**Catégorie** : Insuffle Blocks
**Description** : Dates de sessions

**Attributs** :
- `dates` : Array avec `month`, `days`, `location`, `spots`, `status`

### ❓ FAQ Block
**Catégorie** : Insuffle Blocks
**Description** : Questions/réponses accordéon

**Attributs** :
- `faqs` : Array avec `question`, `answer`

## Comment Créer un Nouveau Bloc

### 1. Créer la Structure

```bash
mkdir -p blocks/mon-bloc
cd blocks/mon-bloc
```

### 2. Créer block.json

```json
{
    "$schema": "https://schemas.wp.org/trunk/block.json",
    "apiVersion": 2,
    "name": "insuffle/mon-bloc",
    "title": "Mon Bloc",
    "category": "insuffle-blocks",
    "icon": "star-filled",
    "description": "Description de mon bloc",
    "supports": {
        "html": false,
        "align": ["wide", "full"]
    },
    "attributes": {
        "title": {
            "type": "string",
            "default": ""
        }
    },
    "textdomain": "insuffle-academy",
    "editorScript": "file:./index.js",
    "editorStyle": "file:./editor.css",
    "style": "file:./style.css"
}
```

### 3. Créer index.php (Rendu Serveur)

```php
<?php
/**
 * Mon Bloc - Rendu serveur
 */

$title = isset($attributes['title']) ? esc_html($attributes['title']) : '';

?>
<div <?php echo get_block_wrapper_attributes(); ?>>
    <h2><?php echo $title; ?></h2>
</div>
```

### 4. Créer style.css

```css
.wp-block-insuffle-mon-bloc {
    padding: 40px;
    background: #f5f5f5;
    border-radius: 20px;
}
```

### 5. Créer editor.css

```css
.wp-block-insuffle-mon-bloc {
    border: 2px dashed #8E2183;
}
```

### 6. Enregistrer le Bloc

Dans `inc/blocks-registration.php` :

```php
function insuffle_academy_register_blocks() {
    if (!function_exists('register_block_type')) {
        return;
    }

    register_block_type(INSUFFLE_THEME_DIR . '/blocks/mon-bloc');
}
add_action('init', 'insuffle_academy_register_blocks');
```

## Exemples de Blocs

### Exemple 1 : Bloc Simple

**blocks/simple-card/block.json**
```json
{
    "name": "insuffle/simple-card",
    "title": "Carte Simple",
    "category": "insuffle-blocks",
    "attributes": {
        "title": {"type": "string"},
        "content": {"type": "string"}
    }
}
```

**blocks/simple-card/index.php**
```php
<div <?php echo get_block_wrapper_attributes(['class' => 'simple-card']); ?>>
    <h3><?php echo esc_html($attributes['title']); ?></h3>
    <p><?php echo esc_html($attributes['content']); ?></p>
</div>
```

### Exemple 2 : Bloc avec JavaScript

**blocks/animated-counter/index.js**
```javascript
const { registerBlockType } = wp.blocks;
const { useBlockProps, InspectorControls } = wp.blockEditor;
const { PanelBody, TextControl } = wp.components;

registerBlockType('insuffle/animated-counter', {
    edit: (props) => {
        const { attributes, setAttributes } = props;
        const blockProps = useBlockProps();

        return (
            <>
                <InspectorControls>
                    <PanelBody title="Paramètres">
                        <TextControl
                            label="Nombre"
                            value={attributes.number}
                            onChange={(value) => setAttributes({ number: value })}
                        />
                    </PanelBody>
                </InspectorControls>
                <div {...blockProps}>
                    <div className="stat-number">{attributes.number}</div>
                </div>
            </>
        );
    },
    save: () => null // Rendu serveur
});
```

## 🎨 Styles CSS Réutilisables

Classes CSS disponibles dans le thème :

- `.hero` - Section hero
- `.why-card` - Carte pourquoi
- `.badge-card` - Carte badge
- `.testimonial-card` - Carte témoignage
- `.pricing-card` - Carte tarification
- `.timeline-item` - Élément timeline
- `.btn` - Bouton de base
- `.btn-primary` - Bouton primaire
- `.btn-secondary` - Bouton secondaire
- `.fade-in-up` - Animation fade in up

## 📚 Ressources

- [Block Editor Handbook](https://developer.wordpress.org/block-editor/)
- [Block API Reference](https://developer.wordpress.org/block-editor/reference-guides/block-api/)
- [WordPress Components](https://developer.wordpress.org/block-editor/reference-guides/components/)

---

**Besoin d'aide ?** Consultez la documentation WordPress ou contactez l'équipe Insuffle Académie.
