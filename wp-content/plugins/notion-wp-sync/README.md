# Notion WordPress Sync - Plugin de Synchronisation

## Description

Plugin WordPress qui synchronise automatiquement vos formations depuis une base de données Notion vers WordPress.

**Cas d'usage** : Vous gérez votre catalogue de formations dans Notion (votre source unique de vérité), et ce plugin les importe automatiquement dans WordPress avec un formatage Gutenberg professionnel.

## Fonctionnalités

- ✅ **Synchronisation bidirectionnelle** : Notion → WordPress
- ✅ **Génération automatique de blocs Gutenberg** formatés
- ✅ **Custom Post Type "Formation"** avec taxonomies
- ✅ **Synchronisation automatique** (cron toutes les heures)
- ✅ **Synchronisation manuelle** via l'interface admin
- ✅ **Gestion des images** (image à la une)
- ✅ **Logs détaillés** de toutes les opérations
- ✅ **Interface d'administration** intuitive
- ✅ **Détection des changements** (ne synchronise que si modifié)

## Structure des fichiers

```
notion-wp-sync/
├── notion-wp-sync.php              # Fichier principal du plugin
├── README.md                        # Cette documentation
├── includes/
│   ├── class-notion-api.php        # Gestion de l'API Notion
│   ├── class-formation-post-type.php # Custom Post Type Formation
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

1. Le plugin est déjà dans `wp-content/plugins/notion-wp-sync/`
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

## Configuration de votre base Notion

Votre base de données Notion doit contenir les propriétés suivantes :

| Nom de la propriété | Type Notion | Description | Obligatoire |
|---------------------|-------------|-------------|-------------|
| **Nom** | Title | Titre de la formation | ✓ |
| **Identifiant** | Rich Text | Code court (ex: SKE, FAC) | ✓ |
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
Nom: Facilit'Academy - Formation Facilitateur
Identifiant: FAC
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

### Synchronisation manuelle

1. Allez dans **Notion Sync** → **Paramètres**
2. Cliquez sur **Synchroniser maintenant**
3. Attendez quelques secondes
4. Les résultats s'affichent :
   - X formation(s) créée(s)
   - X formation(s) mise(s) à jour
   - X formation(s) ignorée(s)

### Synchronisation automatique

Si vous avez activé la synchronisation automatique dans les paramètres, le plugin vérifiera automatiquement toutes les heures s'il y a des changements dans Notion et les appliquera à WordPress.

### Consulter les logs

1. Allez dans **Notion Sync** → **Logs**
2. Vous verrez l'historique complet de toutes les synchronisations
3. Chaque ligne indique :
   - Date et heure
   - Action effectuée
   - Statut (succès/erreur)
   - ID Notion
   - ID du post WordPress
   - Message détaillé

### Voir vos formations

1. Allez dans **Formations** dans le menu WordPress
2. Vous verrez toutes vos formations synchronisées depuis Notion
3. Chaque formation a une metabox "Synchronisation Notion" indiquant :
   - L'ID Notion
   - La date de dernière synchronisation
   - Le statut de synchronisation

## Format du contenu généré

Le plugin génère automatiquement du contenu Gutenberg structuré avec :

- Section d'introduction (fond gris)
- Informations pratiques (durée, tarif, niveau)
- Objectifs pédagogiques
- Public cible
- Prérequis (fond gris)
- Programme détaillé
- Méthodes pédagogiques
- Section d'inscription (CTA avec boutons)

Tous les blocs sont formatés avec les classes CSS de votre thème (`section-grey`, `section-primary`, etc.).

## Personnalisation

### Modifier le template Gutenberg

Pour personnaliser le template des formations générées, modifiez les méthodes dans `includes/class-sync-manager.php` :

- `generate_gutenberg_content()` : Structure globale
- `create_info_pratiques()` : Section des infos pratiques
- `create_cta_section()` : Section d'inscription

### Ajouter des champs personnalisés

1. Ajoutez une colonne dans votre base Notion
2. Modifiez `includes/class-notion-api.php` → méthode `parse_formations()`
3. Ajoutez le champ dans `includes/class-sync-manager.php` → méthode `save_formation_meta()`

### Modifier le mapping des statuts

Dans `includes/class-sync-manager.php`, méthode `get_post_status()`, vous pouvez changer comment les statuts Notion sont convertis en statuts WordPress :

```php
private function get_post_status($notion_status) {
    $status_map = array(
        'Publié' => 'publish',
        'Brouillon' => 'draft',
        'En cours' => 'draft',
        'Archivé' => 'draft',
    );
    // Ajoutez vos propres mappings ici
}
```

## Dépannage

### La synchronisation ne fonctionne pas

1. Vérifiez que l'intégration Notion a bien accès à votre base
2. Vérifiez que le Token et l'ID de base sont corrects
3. Consultez les logs pour voir les erreurs détaillées
4. Vérifiez que les noms des propriétés Notion correspondent exactement

### Les images ne s'importent pas

Les images hébergées sur Notion ont des URLs temporaires. Le plugin télécharge automatiquement les images dans votre bibliothèque WordPress. Si cela échoue :

1. Vérifiez que WordPress a les permissions d'écriture sur `wp-content/uploads/`
2. Vérifiez que `allow_url_fopen` est activé dans PHP

### Le cron ne s'exécute pas

Si la synchronisation automatique ne fonctionne pas :

1. Vérifiez que le cron WordPress fonctionne : `wp cron event list`
2. Testez manuellement : `wp cron event run notion_wp_sync_cron`
3. Utilisez un plugin comme WP Crontrol pour debugger

### Erreur "Missing credentials"

Assurez-vous d'avoir bien sauvegardé le Token API et l'ID de base dans les paramètres du plugin.

## Sécurité

- ✅ Vérification des nonces sur toutes les actions
- ✅ Échappement de toutes les données affichées
- ✅ Vérification des permissions utilisateur
- ✅ Sanitization de toutes les entrées
- ✅ Protection contre l'accès direct aux fichiers

## Performance

- Le plugin ne synchronise que les formations modifiées (comparaison des timestamps)
- Pagination automatique pour les grandes bases Notion
- Cache des résultats API
- Logs automatiquement limités aux 100 dernières opérations dans les stats

## Support

Pour toute question ou problème :

1. Consultez les logs dans **Notion Sync** → **Logs**
2. Vérifiez la configuration de votre base Notion
3. Testez la connexion avec le bouton de test dans les paramètres

## Changelog

### Version 1.0.0 - 2025-01-27

- 🎉 Version initiale
- ✅ Synchronisation Notion → WordPress
- ✅ Génération automatique de blocs Gutenberg
- ✅ Custom Post Type Formation
- ✅ Interface d'administration
- ✅ Logs de synchronisation
- ✅ Synchronisation automatique (cron)

## Crédits

Développé pour **Insuffle Academy** par Claude Code.

## Licence

GPL v2 or later
