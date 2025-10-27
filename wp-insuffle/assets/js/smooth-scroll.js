/**
 * Smooth Scroll Polyfill for older browsers
 *
 * @package WP_Insuffle
 * @version 1.0.0
 */

(function() {
    'use strict';

    // Feature detection
    if (!('scrollBehavior' in document.documentElement.style)) {
        // Polyfill smooth scrolling for older browsers
        const smoothScrollPolyfill = function() {
            const duration = 500;

            const easeInOutQuad = function(t, b, c, d) {
                t /= d / 2;
                if (t < 1) return c / 2 * t * t + b;
                t--;
                return -c / 2 * (t * (t - 2) - 1) + b;
            };

            const scrollTo = function(to, duration) {
                const start = window.pageYOffset;
                const change = to - start;
                const startTime = performance.now();

                const animateScroll = function(currentTime) {
                    const elapsed = currentTime - startTime;
                    const newPosition = easeInOutQuad(elapsed, start, change, duration);

                    window.scrollTo(0, newPosition);

                    if (elapsed < duration) {
                        requestAnimationFrame(animateScroll);
                    }
                };

                requestAnimationFrame(animateScroll);
            };

            // Override native scrollTo
            const originalScrollTo = window.scrollTo;
            window.scrollTo = function(x, y) {
                if (typeof x === 'object' && x.behavior === 'smooth') {
                    scrollTo(x.top, duration);
                } else {
                    originalScrollTo.call(window, x, y);
                }
            };
        };

        smoothScrollPolyfill();
    }
})();
