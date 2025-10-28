<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php bloginfo('description'); ?>">
    <?php wp_head(); ?>
    
    <!-- Script inline pour le menu - garantit que ça fonctionne -->
    <style>
        /* Styles inline pour garantir le fonctionnement */
        .nav-menu .sub-menu {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            background: #8E2183;
            min-width: 280px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.3);
            border-radius: 12px;
            padding: 15px 0;
            margin-top: 10px;
            list-style: none !important;
            z-index: 9999;
            border: 2px solid rgba(255, 212, 102, 0.3);
        }

        .nav-menu .menu-item-has-children:hover > .sub-menu {
            display: block;
            opacity: 1;
            visibility: visible;
        }

        .nav-menu .sub-menu li {
            margin: 0;
            padding: 0;
            list-style: none !important;
        }

        .nav-menu .sub-menu li::before,
        .nav-menu .sub-menu li::marker {
            display: none !important;
            content: none !important;
        }

        .nav-menu .sub-menu a {
            color: white !important;
            padding: 12px 25px 12px 45px !important;
            display: block;
            border-left: 3px solid transparent;
            position: relative;
        }

        .nav-menu .sub-menu a::before {
            content: "→";
            position: absolute;
            left: 20px;
            color: #FFD466;
            font-weight: bold;
            transition: transform 0.3s ease;
        }

        .nav-menu .sub-menu a:hover {
            background: rgba(255, 212, 102, 0.15);
            border-left-color: #FFD466;
            color: #FFD466 !important;
            padding-left: 50px !important;
        }

        .nav-menu .sub-menu a:hover::before {
            transform: translateX(5px);
        }
    </style>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- Navigation -->
<nav id="site-header">
    <div class="container nav-container">
        <?php
        // Logo
        if (has_custom_logo()) {
            the_custom_logo();
        } else {
            ?>
            <a href="<?php echo esc_url(home_url('/')); ?>">
                <img src="<?php echo get_template_directory_uri(); ?>/img/Logo-Insuffle-Academie.png" width="200" 
                     alt="<?php bloginfo('name'); ?>" 
                     class="nav-logo">
            </a>
            <?php
        }
        ?>
        
        <!-- Menu Navigation WordPress -->
        <?php
        wp_nav_menu(array(
            'theme_location' => 'primary',
            'container'      => false,
            'menu_class'     => 'nav-menu',
            'walker'         => new Insuffle_Menu_Walker(),
            'fallback_cb'    => 'insuffle_fallback_menu',
        ));

        // Bouton CTA par défaut (paramétrable dans Apparence > Personnaliser > Bouton Menu)
        $cta_enable = get_theme_mod('insuffle_menu_cta_enable', true);
        $cta_text = get_theme_mod('insuffle_menu_cta_text', 'Demande de devis');
        $cta_url = get_theme_mod('insuffle_menu_cta_url', '/#contact');

        if ($cta_enable && $cta_text && $cta_url) : ?>
            <a href="<?php echo esc_url($cta_url); ?>" class="nav-cta nav-cta-default">
                <?php echo esc_html($cta_text); ?>
            </a>
        <?php endif; ?>

        <!-- Bouton hamburger pour mobile -->
        <button class="mobile-menu-toggle" aria-label="Menu mobile" onclick="toggleMobileMenu()">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </div>
</nav>

<!-- Script JavaScript inline pour garantir le fonctionnement -->
<script>
// Toggle menu mobile
function toggleMobileMenu() {
    const toggle = document.querySelector('.mobile-menu-toggle');
    const menu = document.querySelector('.nav-menu');
    
    if (toggle && menu) {
        toggle.classList.toggle('active');
        menu.classList.toggle('active');
        document.body.classList.toggle('menu-open');
    }
}

// Gestion du sous-menu mobile
document.addEventListener('DOMContentLoaded', function() {
    const menuItems = document.querySelectorAll('.menu-item-has-children > a');
    
    menuItems.forEach(function(item) {
        item.addEventListener('click', function(e) {
            if (window.innerWidth <= 992) {
                e.preventDefault();
                const parent = this.parentElement;
                parent.classList.toggle('submenu-open');
                
                // Fermer les autres sous-menus
                document.querySelectorAll('.menu-item-has-children').forEach(function(otherItem) {
                    if (otherItem !== parent) {
                        otherItem.classList.remove('submenu-open');
                    }
                });
            }
        });
    });
    
    // Fermer le menu en cliquant en dehors
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.nav-container')) {
            const toggle = document.querySelector('.mobile-menu-toggle');
            const menu = document.querySelector('.nav-menu');
            
            if (toggle) toggle.classList.remove('active');
            if (menu) menu.classList.remove('active');
            document.body.classList.remove('menu-open');
        }
    });
});
</script>

<main id="main-content">