/**
 * Customizer Live Preview
 *
 * @package WP_Insuffle
 * @version 1.0.0
 */

(function($) {
    'use strict';

    // Site title
    wp.customize('blogname', function(value) {
        value.bind(function(to) {
            $('.site-title a').text(to);
        });
    });

    // Site description
    wp.customize('blogdescription', function(value) {
        value.bind(function(to) {
            $('.site-description').text(to);
        });
    });

    // Header text color
    wp.customize('header_textcolor', function(value) {
        value.bind(function(to) {
            if ('blank' === to) {
                $('.site-title, .site-description').css({
                    'clip': 'rect(1px, 1px, 1px, 1px)',
                    'position': 'absolute'
                });
            } else {
                $('.site-title, .site-description').css({
                    'clip': 'auto',
                    'position': 'relative'
                });
                $('.site-title a, .site-description').css({
                    'color': to
                });
            }
        });
    });

    // Primary color
    wp.customize('insuffle_primary_color', function(value) {
        value.bind(function(to) {
            $('body').css('--insuffle-primary', to);
        });
    });

    // Secondary color
    wp.customize('insuffle_secondary_color', function(value) {
        value.bind(function(to) {
            $('body').css('--insuffle-secondary', to);
        });
    });

})(jQuery);
