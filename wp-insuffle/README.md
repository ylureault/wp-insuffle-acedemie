# WP Insuffle - Thème WordPress

Thème WordPress optimisé pour Insuffle Académie avec support complet de Gutenberg et des plugins essentiels.

## Caractéristiques

### Couleurs Insuffle
- **Primaire**: #1f3a8b (Bleu Insuffle)
- **Secondaire**: #FFD466 (Jaune doré)
- **Accent**: #5a7fc7 (Bleu clair)
- **Blanc**: #FFFFFF
- **Gris**: #F5F5F5
- **Noir**: #333333

### Support des Plugins

Le thème est parfaitement compatible avec :

#### Plugins fonctionnels
- **Advanced WordPress Backgrounds** - Fonds d'écran avancés
- **Central Color Palette** - Palette de couleurs centralisée
- **Duplicate Page** - Duplication de pages
- **Redux Framework** - Framework d'options
- **Twentig** - Personnalisation avancée

#### Formulaires
- **Contact Form 7** - Formulaires de contact
- **Contact Form 7 Extensions** (Dynamic Text, Post Fields, Captcha)
- **Contact Form CFDB7** - Base de données des soumissions

#### Sécurité & RGPD
- **Complianz** - Gestion des cookies RGPD
- **Really Simple SSL** - Configuration SSL
- **Disable Comments** - Désactivation des commentaires
- **W3 Total Cache** - Cache et performances

#### SEO & Analytics
- **Rank Math SEO** - Optimisation SEO complète
- **GA Google Analytics** - Suivi Analytics

#### Marketing
- **HubSpot All-In-One** - Intégration HubSpot CRM

#### Design & Blocs
- **Fonts Plugin** - Gestion des polices (Google Fonts, Adobe Fonts)
- **Spectra** - Blocs Gutenberg avancés
- **Options for Twenty Twenty** - Options de personnalisation

#### Contenus connexes
- **YARPP** - Articles similaires automatiques

## Installation

1. Téléchargez le thème
2. Allez dans **Apparence > Thèmes > Ajouter**
3. Cliquez sur **Téléverser un thème**
4. Sélectionnez le fichier ZIP du thème
5. Activez le thème

## Configuration

### Menus
Allez dans **Apparence > Menus** et créez deux menus :
- Menu Principal (emplacement: primary)
- Menu Footer (emplacement: footer)

### Widgets
Le thème propose 5 zones de widgets :
- Sidebar Principal
- Footer Zone 1, 2, 3, 4

### Personnalisation
Allez dans **Apparence > Personnaliser** pour :
- Modifier les couleurs Insuffle
- Ajouter un logo personnalisé
- Configurer l'en-tête
- Personnaliser le footer

### Images recommandées
- **Logo** : 300x100px (format PNG transparent)
- **Images héro** : 1920x800px
- **Images carte** : 600x400px
- **Miniatures** : 1200x630px

## Optimisations incluses

### Performance
- Chargement différé des scripts
- Preconnect pour Google Fonts
- Suppression des scripts inutiles
- Support du cache W3 Total Cache

### SEO
- Support complet de Rank Math
- Fil d'Ariane (breadcrumbs)
- Schema.org structured data
- Balises meta optimisées

### Accessibilité
- Support ARIA
- Navigation au clavier
- Contraste des couleurs respecté
- Skip links

### Sécurité
- Suppression de la version WordPress
- Désactivation XML-RPC
- Protection contre les attaques courantes

## Structure des fichiers

```
wp-insuffle/
├── assets/
│   ├── css/
│   │   └── custom.css
│   ├── js/
│   │   ├── main.js
│   │   ├── smooth-scroll.js
│   │   └── customizer.js
│   └── images/
├── inc/
│   ├── customizer.php
│   ├── template-tags.php
│   └── custom-header.php
├── template-parts/
│   ├── content.php
│   ├── content-page.php
│   ├── content-single.php
│   └── content-none.php
├── style.css
├── functions.php
├── header.php
├── footer.php
├── index.php
├── page.php
├── single.php
├── archive.php
├── search.php
├── 404.php
├── sidebar.php
├── searchform.php
├── comments.php
└── README.md
```

## Support Gutenberg

Le thème supporte pleinement l'éditeur de blocs Gutenberg :
- Largeur complète et large
- Styles de blocs
- Palette de couleurs personnalisée
- Tailles de police prédéfinies
- Styles d'éditeur

## Développement

### Prérequis
- WordPress 6.0+
- PHP 7.4+

### Personnalisation CSS
Ajoutez votre CSS personnalisé dans `assets/css/custom.css`

### Personnalisation JavaScript
Ajoutez votre JS personnalisé dans `assets/js/main.js`

## Support

Pour toute question ou problème :
- Email: contact@insuffle-academie.com
- Téléphone: 09 80 80 89 62

## Crédits

- Développé pour Insuffle Académie
- Basé sur le design formation-manager-facilitateur.html
- Polices : Montserrat (Google Fonts)

## Licence

GPL v2 or later

## Changelog

### Version 1.0.0
- Version initiale
- Support complet des plugins Insuffle
- Couleurs Insuffle (#1f3a8b)
- Optimisations de performance
- Support Gutenberg complet
