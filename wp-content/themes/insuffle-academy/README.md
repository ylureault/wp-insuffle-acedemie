# Insuffle Academy - Thème WordPress

Un thème WordPress moderne, gamifié et totalement modulable pour les formations Insuffle Académie, basé sur le design de FACILIT'ACADEMY.

## 🎮 Caractéristiques

- **Design Gamifié** : Animations fluides, couleurs vibrantes, design inspiré des jeux vidéo
- **100% Responsive** : Optimisé pour tous les appareils (mobile, tablette, desktop)
- **Gutenberg Ready** : Support complet de l'éditeur Gutenberg avec blocs personnalisés
- **Performance** : Code optimisé, chargement rapide
- **SEO Friendly** : Structure HTML5 sémantique
- **Personnalisable** : Nombreuses options via le Customizer WordPress
- **Accessible** : Respecte les normes d'accessibilité WCAG

## 📦 Installation

1. Téléchargez le thème ou clonez le dépôt
2. Décompressez le fichier ZIP dans `/wp-content/themes/`
3. Activez le thème depuis l'administration WordPress
4. Configurez le thème via **Apparence > Personnaliser**

## 🎨 Structure des Fichiers

```
insuffle-academy/
├── assets/
│   ├── css/
│   │   ├── main.css           # Styles principaux
│   │   └── editor-style.css   # Styles éditeur Gutenberg
│   ├── js/
│   │   ├── main.js            # JavaScript principal
│   │   ├── animations.js      # Animations et effets
│   │   └── customizer.js      # Preview en direct du Customizer
│   └── images/                # Images du thème
├── blocks/                    # Blocs Gutenberg personnalisés
├── inc/
│   ├── customizer.php         # Configuration du Customizer
│   ├── template-functions.php # Fonctions de templates
│   ├── template-tags.php      # Tags de templates personnalisés
│   └── blocks-registration.php # Enregistrement des blocs
├── template-parts/            # Parties de templates réutilisables
│   ├── content.php
│   ├── content-page.php
│   └── content-none.php
├── functions.php              # Fonctions du thème
├── style.css                  # Métadonnées du thème
├── header.php                 # En-tête
├── footer.php                 # Pied de page
├── index.php                  # Template principal
├── front-page.php             # Page d'accueil
├── page.php                   # Template de page
├── single.php                 # Template d'article
└── README.md                  # Ce fichier
```

## ⚙️ Configuration

### Menus

Le thème supporte deux emplacements de menu :

1. **Menu Principal** : Navigation en haut de page
2. **Menu Footer** : Navigation dans le pied de page

Pour ajouter un bouton CTA dans le menu principal, ajoutez la classe CSS `cta` ou `nav-cta` à l'élément de menu.

### Widgets

Le thème propose 5 zones de widgets :

- **Sidebar** : Barre latérale
- **Footer 1, 2, 3, 4** : Quatre colonnes dans le pied de page

### Personnalisation (Customizer)

Accédez à **Apparence > Personnaliser** pour configurer :

#### Branding
- Logo Emoji (par défaut : 🎮)
- Footer Emoji

#### Bandeau d'Urgence
- Activer/désactiver le bandeau
- Personnaliser le texte

#### Informations de Contact
- Email
- Téléphone
- Site Web

#### Réseaux Sociaux
- LinkedIn
- Instagram
- Facebook

#### Footer
- Texte de certification (ex: "Certifié Qualiopi")
- Liens : Mentions Légales, CGV, Politique de Confidentialité

## 🎨 Palette de Couleurs

Le thème utilise une palette de couleurs gamifiée :

```css
--primary: #8E2183;        /* Violet principal */
--secondary: #FFD466;      /* Jaune secondaire */
--game-purple: #9c27b0;    /* Violet jeu */
--game-gold: #ffd700;      /* Or */
--game-orange: #ff9800;    /* Orange */
--game-green: #4caf50;     /* Vert */
--game-blue: #2196f3;      /* Bleu */
--game-red: #f44336;       /* Rouge */
--dark: #1a1a2e;           /* Sombre */
--light: #FFFFFF;          /* Clair */
--grey: #F5F5F5;           /* Gris */
```

## 🧩 Blocs Gutenberg Personnalisés

Le thème sera enrichi progressivement avec des blocs Gutenberg personnalisés :

- **Hero Block** : Section héro avec animations
- **Stats Block** : Affichage de statistiques animées
- **Badges Block** : Grille de badges/compétences
- **Timeline Block** : Timeline de programme
- **Testimonials Block** : Témoignages clients
- **Pricing Block** : Carte de tarification
- **Dates Block** : Dates de sessions
- **FAQ Block** : Questions/réponses accordéon

## 🚀 Optimisations

### Performance
- CSS et JS minifiés en production
- Images lazy-load
- Fonts préchargées
- Animations optimisées avec CSS et RequestAnimationFrame

### SEO
- Métadonnées structurées
- HTML5 sémantique
- Breadcrumbs ready
- Schema.org compatible

## 📱 Responsive Design

Le thème est entièrement responsive avec des breakpoints à :

- **Desktop** : > 1024px
- **Tablet** : 768px - 1024px
- **Mobile** : < 768px
- **Small Mobile** : < 480px

## 🛠️ Développement

### Prérequis
- WordPress 6.0+
- PHP 7.4+

### Development Setup

1. Clonez le dépôt
2. Naviguez dans le dossier du thème
3. Développez vos fonctionnalités
4. Testez sur différents navigateurs et appareils

### Build Assets (si nécessaire)

Si vous ajoutez des processeurs CSS/JS :

```bash
npm install
npm run build
```

## 📝 Changelog

### Version 1.0.0 (2025-01-27)
- Version initiale
- Design basé sur facilitacademy-irresistible.html
- Support complet de Gutenberg
- Customizer avec nombreuses options
- Animations et effets gamifiés
- Responsive design complet

## 🤝 Contribution

Les contributions sont les bienvenues ! Pour contribuer :

1. Forkez le projet
2. Créez une branche (`git checkout -b feature/AmazingFeature`)
3. Committez vos changements (`git commit -m 'Add some AmazingFeature'`)
4. Poussez vers la branche (`git push origin feature/AmazingFeature`)
5. Ouvrez une Pull Request

## 📄 Licence

Ce thème est sous licence GPL v2 ou ultérieure.

## 👨‍💻 Auteur

**Insuffle Académie**
- Website: https://insuffle-academie.com
- Email: contact@insuffle-academie.com

## 🙏 Remerciements

- Design inspiré de FACILIT'ACADEMY
- Fonts : Montserrat & Press Start 2P (Google Fonts)
- Icons : Emojis natifs

---

**Fait avec ❤️ pour l'apprentissage et la facilitation**
