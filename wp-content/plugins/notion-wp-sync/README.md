# Notion WordPress Sync - Plugin de Synchronisation

## Description

Plugin WordPress qui synchronise automatiquement vos formations depuis une base de données Notion et met à jour le contenu de vos pages WordPress existantes.

**Cas d'usage** : Vous gérez votre catalogue de formations dans Notion (votre source unique de vérité), et ce plugin met à jour automatiquement le contenu de vos pages WordPress avec un formatage Gutenberg professionnel.

## Fonctionnalités

- ✅ **Synchronisation Notion → Pages WordPress** : Mise à jour automatique du contenu de vos pages
- ✅ **Génération automatique de blocs Gutenberg** formatés
- ✅ **Association flexible** : Associez un identifiant Notion à n'importe quelle page WordPress
- ✅ **Synchronisation automatique** (cron toutes les heures)
- ✅ **Synchronisation manuelle** via l'interface admin ou depuis la page elle-même
- ✅ **Gestion des images** (image à la une)
- ✅ **Logs détaillés** de toutes les opérations
- ✅ **Interface d'administration** intuitive
- ✅ **Détection des changements** (ne synchronise que si modifié)

## Fonctionnement

1. Vous créez une **page WordPress normale** (ex: `/formations/facilitation-intelligence-collective/`)
2. Dans la page, vous associez un **identifiant de formation Notion** (ex: "IC")
3. Le plugin récupère automatiquement les données de la formation "IC" depuis Notion
4. Il **met à jour le contenu de votre page** avec ces données formatées en Gutenberg

**Avantage** : Vous gardez le contrôle total de vos URLs et de votre structure de site, le plugin ne fait que mettre à jour le contenu !

## Structure des fichiers

```
notion-wp-sync/
├── notion-wp-sync.php              # Fichier principal du plugin
├── README.md                        # Cette documentation
├── includes/
│   ├── class-notion-api.php        # Gestion de l'API Notion
│   ├── class-page-meta-box.php     # Meta box pour associer ID formation
│   └── class-sync-manager.php      # Gestionnaire de synchronisation
└── admin/
    ├── class-admin-settings.php    # Interface d'administration
    ├── js/
    │   └── admin.js                # Scripts JavaScript
    └── css/
        └── admin.css               # Styles CSS
```

## Installation

### 1. Activer le plugin

1. Le plugin est dans `wp-content/plugins/notion-wp-sync/`
2. Connectez-vous à votre administration WordPress
3. Allez dans **Extensions** → **Extensions installées**
4. Trouvez "Notion WordPress Sync" et cliquez sur **Activer**

### 2. Créer une intégration Notion

1. Allez sur https://www.notion.so/my-integrations
2. Cliquez sur **+ New integration**
3. Donnez un nom (ex: "WordPress Sync")
4. Sélectionnez votre workspace
5. Copiez le **Internal Integration Token** (commence par `secret_`)

### 3. Connecter votre base de données Notion

1. Ouvrez votre base de données de formations dans Notion
2. Cliquez sur les 3 points en haut à droite → **Add connections**
3. Sélectionnez votre intégration créée à l'étape 2
4. Copiez l'ID de la base depuis l'URL :
   ```
   https://www.notion.so/VOTRE_WORKSPACE/XXXXX?v=...
                                          ↑
                                    Database ID
   ```

### 4. Configurer le plugin WordPress

1. Dans WordPress, allez dans **Notion Sync** → **Paramètres**
2. Collez votre **Token d'API Notion**
3. Collez l'**ID de la base de données**
4. Cochez **Synchronisation automatique** si souhaité
5. Cliquez sur **Sauvegarder les paramètres**
6. Testez en cliquant sur **Synchroniser maintenant**

## Configuration de votre base Notion

Votre base de données Notion doit contenir les propriétés suivantes :

| Nom de la propriété | Type Notion | Description | Obligatoire |
|---------------------|-------------|-------------|-------------|
| **Nom** | Title | Titre de la formation | ✓ |
| **Identifiant** | Rich Text | Code court (ex: IC, SKE) | ✓ |
| **Description** | Rich Text | Description courte | |
| **Durée** | Rich Text | Durée (ex: "2 jours") | |
| **Prix** | Number | Prix en euros HT | |
| **Niveau** | Select | Niveau (Débutant, etc.) | |
| **Catégorie** | Select | Catégorie de formation | |
| **Prérequis** | Rich Text | Prérequis nécessaires | |
| **Objectifs** | Rich Text | Objectifs pédagogiques | |
| **Programme** | Rich Text | Programme détaillé | |
| **Public cible** | Rich Text | À qui s'adresse la formation | |
| **Méthodes pédagogiques** | Rich Text | Méthodes utilisées | |
| **Statut** | Select | Publié, Brouillon, En cours | |
| **Image** | Files | Image de la formation | |

### Exemple de configuration Notion

Créez une base de données avec ces colonnes, puis ajoutez vos formations :

```
Nom: Facilit'Academy - Devenez Facilitateur
Identifiant: IC
Description: Formation facilitateur gamifiée certifiée Qualiopi
Durée: 2 jours (14 heures)
Prix: 2490
Niveau: Tous niveaux
Catégorie: Facilitation
Prérequis: Aucun prérequis technique requis
Objectifs:
- Développer la posture du facilitateur
- Maîtriser les outils de facilitation
- Gérer les situations difficiles
Programme: [Détails du programme...]
Public cible: Managers, consultants, RH, chefs de projet
Méthodes pédagogiques: Gamification, Training from the Back
Statut: Publié
Image: [Upload une image]
```

## Utilisation

### Créer une page de formation

1. Dans WordPress, créez une **nouvelle Page** (Pages → Ajouter)
2. Donnez-lui un titre et une URL (ex: `/formations/facilitation-intelligence-collective/`)
3. Dans la sidebar droite, trouvez la meta box **"Synchronisation Notion Formation"**
4. Entrez l'**Identifiant de formation Notion** (ex: "IC")
5. Cochez **"Synchronisation automatique"**
6. Cliquez sur **Publier**

### Première synchronisation

**Option 1 : Depuis la page elle-même**
- Après avoir associé l'identifiant, cliquez sur **"Synchroniser maintenant"** dans la meta box
- Le contenu de la page sera immédiatement mis à jour

**Option 2 : Synchronisation globale**
1. Allez dans **Notion Sync** → **Paramètres**
2. Cliquez sur **Synchroniser maintenant**
3. Toutes les pages avec synchronisation automatique seront mises à jour

### Synchronisation automatique

Si vous avez activé la synchronisation automatique dans les paramètres, le plugin vérifiera automatiquement toutes les heures s'il y a des changements dans Notion et les appliquera aux pages WordPress qui ont coché "Synchronisation automatique".

### Consulter les logs

1. Allez dans **Notion Sync** → **Logs**
2. Vous verrez l'historique complet de toutes les synchronisations
3. Chaque ligne indique :
   - Date et heure
   - Action effectuée
   - Statut (succès/erreur)
   - Message détaillé

## Format du contenu généré

Le plugin génère automatiquement du contenu Gutenberg structuré avec :

- **Section d'introduction** (fond gris) : Titre, description
- **Informations pratiques** (fond primary) : Durée, tarif, niveau en colonnes
- **Objectifs pédagogiques** : Liste à puces
- **Public cible** : Paragraphe
- **Prérequis** (fond gris) : Paragraphe
- **Programme détaillé** : Texte formaté
- **Méthodes pédagogiques** : Paragraphe
- **Section d'inscription** (CTA avec boutons email et téléphone)

Tous les blocs utilisent vos classes CSS personnalisées (`section-grey`, `section-primary`, etc.).

## Workflow complet

1. **Dans Notion** : Modifiez la formation "Intelligence Collective" (ID: "IC")
2. **Attendez la synchronisation automatique** (toutes les heures)
   - OU cliquez sur "Synchroniser maintenant" dans l'admin
   - OU cliquez sur "Synchroniser maintenant" dans la meta box de la page
3. **Résultat** : La page `/formations/facilitation-intelligence-collective/` est automatiquement mise à jour !

## Personnalisation

### Modifier le template Gutenberg

Pour personnaliser le template des formations générées, modifiez les méthodes dans `includes/class-sync-manager.php` :

- `generate_gutenberg_content()` : Structure globale
- `create_info_pratiques()` : Section des infos pratiques
- `create_cta_section()` : Section d'inscription

### Ajouter des champs personnalisés

1. Ajoutez une colonne dans votre base Notion
2. Modifiez `includes/class-notion-api.php` → méthode `parse_formations()`
3. Ajoutez le champ dans `includes/class-sync-manager.php` → méthode `sync_formation()`
4. Utilisez-le dans `generate_gutenberg_content()`

## Dépannage

### La synchronisation ne fonctionne pas

1. Vérifiez que l'intégration Notion a bien accès à votre base
2. Vérifiez que le Token et l'ID de base sont corrects
3. Consultez les logs pour voir les erreurs détaillées
4. Vérifiez que les noms des propriétés Notion correspondent exactement

### La meta box n'apparaît pas sur ma page

La meta box "Synchronisation Notion Formation" n'apparaît que sur les **Pages** WordPress (pas les articles). Vérifiez que vous êtes bien sur une page.

### Le contenu ne se met pas à jour

1. Vérifiez que la case **"Synchronisation automatique"** est cochée dans la meta box
2. Vérifiez que l'identifiant correspond bien à une formation dans Notion
3. Lancez une synchronisation manuelle globale depuis **Notion Sync** → **Paramètres**
4. Consultez les logs pour voir si des erreurs sont survenues

### Les images ne s'importent pas

Les images hébergées sur Notion ont des URLs temporaires. Le plugin télécharge automatiquement les images dans votre bibliothèque WordPress. Si cela échoue :

1. Vérifiez que WordPress a les permissions d'écriture sur `wp-content/uploads/`
2. Vérifiez que `allow_url_fopen` est activé dans PHP

### Le cron ne s'exécute pas

Si la synchronisation automatique ne fonctionne pas :

1. Vérifiez que le cron WordPress fonctionne : `wp cron event list`
2. Testez manuellement : `wp cron event run notion_wp_sync_cron`
3. Utilisez un plugin comme WP Crontrol pour debugger

## Sécurité

- ✅ Vérification des nonces sur toutes les actions
- ✅ Échappement de toutes les données affichées
- ✅ Vérification des permissions utilisateur
- ✅ Sanitization de toutes les entrées
- ✅ Protection contre l'accès direct aux fichiers

## Performance

- Le plugin stocke les formations dans une table dédiée pour un accès rapide
- Ne met à jour que les pages qui ont la synchronisation automatique activée
- Détection intelligente des changements (ne synchronise que si nécessaire)
- Pagination automatique pour les grandes bases Notion

## Support

Pour toute question ou problème :

1. Consultez les logs dans **Notion Sync** → **Logs**
2. Vérifiez la configuration de votre base Notion
3. Testez la connexion avec le bouton de test dans les paramètres

## Changelog

### Version 1.0.0 - 2025-01-27

- 🎉 Version initiale
- ✅ Synchronisation Notion → Pages WordPress
- ✅ Génération automatique de blocs Gutenberg
- ✅ Meta box pour associer identifiant Notion aux pages
- ✅ Interface d'administration
- ✅ Logs de synchronisation
- ✅ Synchronisation automatique (cron)
- ✅ Synchronisation manuelle globale ou par page

## Crédits

Développé pour **Insuffle Academy** par Claude Code.

## Licence

GPL v2 or later
