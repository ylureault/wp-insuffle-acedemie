/**
 * Animations and Scroll Effects
 *
 * @package Insuffle_Academy
 */

(function() {
    'use strict';

    // Animation au scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, observerOptions);

    // Observer tous les éléments avec la classe fade-in-up
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.fade-in-up').forEach((element) => {
            observer.observe(element);
        });
    });

    // Smooth scroll pour les ancres
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    });

    // Toggle FAQ
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.faq-question').forEach(question => {
            question.addEventListener('click', () => {
                const answer = question.nextElementSibling;
                const icon = question.querySelector('.faq-icon');

                // Toggle answer visibility
                if (answer.style.display === 'block') {
                    answer.style.display = 'none';
                    icon.textContent = '+';
                } else {
                    // Close all other answers
                    document.querySelectorAll('.faq-answer').forEach(a => a.style.display = 'none');
                    document.querySelectorAll('.faq-icon').forEach(i => i.textContent = '+');

                    answer.style.display = 'block';
                    icon.textContent = '−';
                }
            });
        });
    });

    // Parallax effect on scroll (optional enhancement)
    let scrollPosition = 0;
    window.addEventListener('scroll', function() {
        scrollPosition = window.pageYOffset;

        const hero = document.querySelector('.hero');
        if (hero) {
            hero.style.backgroundPositionY = scrollPosition * 0.5 + 'px';
        }
    });

})();
