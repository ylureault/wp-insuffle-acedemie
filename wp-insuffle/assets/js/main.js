/**
 * WP Insuffle Main JavaScript
 *
 * @package WP_Insuffle
 * @version 1.0.0
 */

(function($) {
    'use strict';

    // Mobile Menu Toggle
    function initMobileMenu() {
        const menuToggle = document.querySelector('.mobile-menu-toggle');
        const menu = document.querySelector('.main-menu');

        if (menuToggle && menu) {
            menuToggle.addEventListener('click', function() {
                const isExpanded = this.getAttribute('aria-expanded') === 'true';

                this.setAttribute('aria-expanded', !isExpanded);
                menu.classList.toggle('is-active');

                // Change icon
                const icon = this.querySelector('.menu-icon');
                if (icon) {
                    icon.textContent = menu.classList.contains('is-active') ? '✕' : '☰';
                }
            });

            // Close menu when clicking outside
            document.addEventListener('click', function(event) {
                if (!event.target.closest('.site-navigation')) {
                    menu.classList.remove('is-active');
                    menuToggle.setAttribute('aria-expanded', 'false');
                    const icon = menuToggle.querySelector('.menu-icon');
                    if (icon) {
                        icon.textContent = '☰';
                    }
                }
            });

            // Close menu on window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth > 968) {
                    menu.classList.remove('is-active');
                    menuToggle.setAttribute('aria-expanded', 'false');
                }
            });
        }
    }

    // Smooth Scroll for Anchor Links
    function initSmoothScroll() {
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const href = this.getAttribute('href');

                // Skip if it's just "#"
                if (href === '#') {
                    return;
                }

                const target = document.querySelector(href);

                if (target) {
                    e.preventDefault();

                    const headerOffset = document.querySelector('.site-header') ?
                        document.querySelector('.site-header').offsetHeight : 0;
                    const elementPosition = target.getBoundingClientRect().top;
                    const offsetPosition = elementPosition + window.pageYOffset - headerOffset - 20;

                    window.scrollTo({
                        top: offsetPosition,
                        behavior: 'smooth'
                    });

                    // Update URL without jumping
                    history.pushState(null, null, href);
                }
            });
        });
    }

    // Sticky Header on Scroll
    function initStickyHeader() {
        const header = document.querySelector('.site-header');

        if (header) {
            let lastScroll = 0;

            window.addEventListener('scroll', function() {
                const currentScroll = window.pageYOffset;

                if (currentScroll <= 0) {
                    header.classList.remove('scroll-up');
                    return;
                }

                if (currentScroll > lastScroll && !header.classList.contains('scroll-down')) {
                    // Scroll Down
                    header.classList.remove('scroll-up');
                    header.classList.add('scroll-down');
                } else if (currentScroll < lastScroll && header.classList.contains('scroll-down')) {
                    // Scroll Up
                    header.classList.remove('scroll-down');
                    header.classList.add('scroll-up');
                }

                lastScroll = currentScroll;
            });
        }
    }

    // Back to Top Button
    function initBackToTop() {
        // Create button if it doesn't exist
        if (!document.querySelector('.back-to-top')) {
            const button = document.createElement('button');
            button.className = 'back-to-top';
            button.innerHTML = '↑';
            button.setAttribute('aria-label', 'Retour en haut');
            document.body.appendChild(button);
        }

        const backToTop = document.querySelector('.back-to-top');

        if (backToTop) {
            // Show/hide button based on scroll
            window.addEventListener('scroll', function() {
                if (window.pageYOffset > 300) {
                    backToTop.classList.add('show');
                } else {
                    backToTop.classList.remove('show');
                }
            });

            // Scroll to top on click
            backToTop.addEventListener('click', function() {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
        }
    }

    // Initialize animations on scroll (if elements have animation classes)
    function initScrollAnimations() {
        const animatedElements = document.querySelectorAll('.animate-on-scroll');

        if (animatedElements.length > 0 && 'IntersectionObserver' in window) {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animated');
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            });

            animatedElements.forEach(el => observer.observe(el));
        }
    }

    // External Links (open in new tab)
    function initExternalLinks() {
        const links = document.querySelectorAll('a[href^="http"]');

        links.forEach(link => {
            const currentDomain = window.location.hostname;
            const linkDomain = new URL(link.href).hostname;

            if (currentDomain !== linkDomain) {
                link.setAttribute('target', '_blank');
                link.setAttribute('rel', 'noopener noreferrer');
            }
        });
    }

    // Lazy Load Images (if not using a plugin)
    function initLazyLoad() {
        if ('loading' in HTMLImageElement.prototype) {
            // Native lazy loading is supported
            const images = document.querySelectorAll('img[loading="lazy"]');
            images.forEach(img => {
                if (img.dataset.src) {
                    img.src = img.dataset.src;
                }
            });
        } else {
            // Fallback for browsers that don't support lazy loading
            if ('IntersectionObserver' in window) {
                const imageObserver = new IntersectionObserver((entries, observer) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const img = entry.target;
                            if (img.dataset.src) {
                                img.src = img.dataset.src;
                                img.classList.remove('lazy');
                                imageObserver.unobserve(img);
                            }
                        }
                    });
                });

                const images = document.querySelectorAll('img.lazy');
                images.forEach(img => imageObserver.observe(img));
            }
        }
    }

    // WordPress Comment Form Enhancement
    function initCommentForm() {
        const commentForm = document.querySelector('#commentform');

        if (commentForm) {
            // Add classes for styling
            const inputs = commentForm.querySelectorAll('input[type="text"], input[type="email"], input[type="url"], textarea');
            inputs.forEach(input => {
                input.classList.add('form-control');
            });

            const submit = commentForm.querySelector('input[type="submit"]');
            if (submit) {
                submit.classList.add('btn');
            }
        }
    }

    // Contact Form 7 Success Handler
    function initCF7Handler() {
        document.addEventListener('wpcf7mailsent', function(event) {
            // Scroll to response message
            const responseOutput = event.target.querySelector('.wpcf7-response-output');
            if (responseOutput) {
                responseOutput.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }, false);
    }

    // Initialize all functions when DOM is ready
    function init() {
        initMobileMenu();
        initSmoothScroll();
        initStickyHeader();
        initBackToTop();
        initScrollAnimations();
        initExternalLinks();
        initLazyLoad();
        initCommentForm();
        initCF7Handler();
    }

    // Run on DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

})(jQuery);
