/**
 * Customizer Live Preview
 *
 * @package Insuffle_Academy
 */

(function($) {
    'use strict';

    // Site title
    wp.customize('blogname', function(value) {
        value.bind(function(newval) {
            $('.nav-logo span:last-child').text(newval);
        });
    });

    // Site description
    wp.customize('blogdescription', function(value) {
        value.bind(function(newval) {
            $('.site-description').text(newval);
        });
    });

    // Logo Emoji
    wp.customize('insuffle_logo_emoji', function(value) {
        value.bind(function(newval) {
            $('.nav-logo span:first-child').text(newval);
        });
    });

    // Urgence Banner visibility
    wp.customize('insuffle_show_urgence_banner', function(value) {
        value.bind(function(newval) {
            if (newval) {
                $('.urgence-banner').show();
            } else {
                $('.urgence-banner').hide();
            }
        });
    });

    // Urgence Banner text
    wp.customize('insuffle_urgence_text', function(value) {
        value.bind(function(newval) {
            $('.urgence-banner').html(newval);
        });
    });

})(jQuery);
