#!/bin/bash

##############################################################################
# Script de déploiement du thème Insuffle Academy
#
# Usage: ./deploy.sh [user@host] [chemin-distant]
# Exemple: ./deploy.sh user@manager-facilitateur.com sites/manager-facilitateur.com/wp-content/themes/
##############################################################################

set -e  # Arrêter en cas d'erreur

# Couleurs pour les messages
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Configuration
THEME_NAME="insuffle-academy"
LOCAL_THEME_PATH="wp-content/themes/${THEME_NAME}"
SSH_HOST="${1}"
REMOTE_PATH="${2}"

# Fonction pour afficher les messages
log_info() {
    echo -e "${GREEN}[INFO]${NC} $1"
}

log_warn() {
    echo -e "${YELLOW}[WARN]${NC} $1"
}

log_error() {
    echo -e "${RED}[ERROR]${NC} $1"
}

# Vérifier les arguments
if [ -z "$SSH_HOST" ] || [ -z "$REMOTE_PATH" ]; then
    log_error "Usage: $0 [user@host] [chemin-distant]"
    echo ""
    echo "Exemples:"
    echo "  $0 user@manager-facilitateur.com sites/manager-facilitateur.com/wp-content/themes/"
    echo "  $0 user@192.168.1.100 /var/www/html/wp-content/themes/"
    exit 1
fi

# Vérifier que le thème existe localement
if [ ! -d "$LOCAL_THEME_PATH" ]; then
    log_error "Le thème n'existe pas: $LOCAL_THEME_PATH"
    exit 1
fi

log_info "==================================================================="
log_info "Déploiement du thème Insuffle Academy"
log_info "==================================================================="
log_info "Thème local: $LOCAL_THEME_PATH"
log_info "Serveur SSH: $SSH_HOST"
log_info "Chemin distant: $REMOTE_PATH"
log_info "==================================================================="

# Demander confirmation
read -p "Continuer le déploiement? (y/n) " -n 1 -r
echo
if [[ ! $REPLY =~ ^[Yy]$ ]]; then
    log_warn "Déploiement annulé"
    exit 0
fi

# Créer une archive temporaire
log_info "Création de l'archive du thème..."
TEMP_DIR=$(mktemp -d)
ARCHIVE_NAME="${THEME_NAME}-$(date +%Y%m%d-%H%M%S).tar.gz"
ARCHIVE_PATH="${TEMP_DIR}/${ARCHIVE_NAME}"

tar -czf "$ARCHIVE_PATH" -C "wp-content/themes" "$THEME_NAME"
log_info "Archive créée: $ARCHIVE_PATH"

# Afficher la taille de l'archive
ARCHIVE_SIZE=$(du -h "$ARCHIVE_PATH" | cut -f1)
log_info "Taille de l'archive: $ARCHIVE_SIZE"

# Uploader l'archive
log_info "Upload de l'archive vers le serveur..."
scp "$ARCHIVE_PATH" "${SSH_HOST}:~/" || {
    log_error "Échec de l'upload"
    rm -rf "$TEMP_DIR"
    exit 1
}

log_info "Archive uploadée avec succès"

# Déployer sur le serveur
log_info "Déploiement sur le serveur..."
ssh "$SSH_HOST" << EOF
    set -e

    # Vérifier/créer le répertoire de destination
    mkdir -p "${REMOTE_PATH}"

    # Sauvegarder l'ancien thème si existe
    if [ -d "${REMOTE_PATH}${THEME_NAME}" ]; then
        echo "Sauvegarde de l'ancien thème..."
        mv "${REMOTE_PATH}${THEME_NAME}" "${REMOTE_PATH}${THEME_NAME}.backup-\$(date +%Y%m%d-%H%M%S)"
    fi

    # Extraire la nouvelle version
    echo "Extraction du nouveau thème..."
    tar -xzf "~/${ARCHIVE_NAME}" -C "${REMOTE_PATH}"

    # Définir les permissions
    echo "Configuration des permissions..."
    chmod -R 755 "${REMOTE_PATH}${THEME_NAME}"
    find "${REMOTE_PATH}${THEME_NAME}" -type f -exec chmod 644 {} \;

    # Nettoyer l'archive
    rm "~/${ARCHIVE_NAME}"

    echo "Déploiement terminé avec succès!"
EOF

# Nettoyer le fichier temporaire local
rm -rf "$TEMP_DIR"

log_info "==================================================================="
log_info "✅ Déploiement réussi!"
log_info "==================================================================="
log_info "Le thème a été déployé dans: ${REMOTE_PATH}${THEME_NAME}"
log_info ""
log_info "Prochaines étapes:"
log_info "1. Connectez-vous à votre administration WordPress"
log_info "2. Allez dans Apparence > Thèmes"
log_info "3. Activez le thème 'Insuffle Academy'"
log_info "==================================================================="
