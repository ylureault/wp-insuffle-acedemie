jQuery(document).ready(function($) {
    // Synchronisation manuelle
    $('#notion-sync-manual').on('click', function(e) {
        e.preventDefault();

        var $button = $(this);
        var $result = $('#sync-result');

        // Désactiver le bouton et afficher le loader
        $button.prop('disabled', true).addClass('loading');
        $result.html('<div class="notice notice-info"><p>Synchronisation en cours...</p></div>');

        // Effectuer la requête AJAX
        $.ajax({
            url: notionSyncAjax.ajax_url,
            type: 'POST',
            data: {
                action: 'notion_sync_manual',
                nonce: notionSyncAjax.nonce
            },
            success: function(response) {
                if (response.success) {
                    var results = response.data.results;
                    var message = '<div class="notice notice-success"><p><strong>Synchronisation terminée !</strong></p>';
                    message += '<ul>';
                    message += '<li>' + results.created + ' formation(s) créée(s)</li>';
                    message += '<li>' + results.updated + ' formation(s) mise(s) à jour</li>';
                    message += '<li>' + results.skipped + ' formation(s) ignorée(s)</li>';
                    if (results.errors > 0) {
                        message += '<li style="color: red;">' + results.errors + ' erreur(s)</li>';
                    }
                    message += '</ul></div>';
                    $result.html(message);

                    // Recharger la page après 3 secondes pour mettre à jour les stats
                    setTimeout(function() {
                        location.reload();
                    }, 3000);
                } else {
                    $result.html('<div class="notice notice-error"><p>Erreur : ' + response.data.message + '</p></div>');
                }
            },
            error: function() {
                $result.html('<div class="notice notice-error"><p>Erreur de connexion au serveur</p></div>');
            },
            complete: function() {
                // Réactiver le bouton
                $button.prop('disabled', false).removeClass('loading');
            }
        });
    });
});
