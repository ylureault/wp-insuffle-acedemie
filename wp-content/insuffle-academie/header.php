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
            background: white;
            min-width: 280px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            border-radius: 12px;
            padding: 15px 0;
            margin-top: 10px;
            list-style: none !important;
            z-index: 9999;
        }
        
        .nav-menu .menu-item-has-children:hover > .sub-menu {
            display: block;
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
            color: #8E2183 !important;
            padding: 12px 25px !important;
            display: block;
            border-left: 3px solid transparent;
        }
        
        .nav-menu .sub-menu a:hover {
            background: #f5f5f5;
            border-left-color: #FFD466;
            padding-left: 30px !important;
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
        
        <!-- Menu Navigation -->
        <ul class="nav-menu">
            <li><a href="<?php echo home_url('/#about'); ?>">Notre approche</a></li>
            
            <!-- Menu Formations avec sous-menu -->
            <li class="menu-item-has-children">
                <a href="<?php echo home_url('/#formations'); ?>">Formations ▾</a>
                <ul class="sub-menu">
                    <?php
                    // Récupérer les formations
                    $formations_page = get_page_by_path('formations');
                    
                    if ($formations_page) {
                        // Récupérer les pages enfants de "Formations"
                        $formations = get_pages(array(
                            'child_of' => $formations_page->ID,
                            'parent' => $formations_page->ID,
                            'sort_column' => 'menu_order, post_title',
                            'sort_order' => 'ASC'
                        ));
                        
                        if ($formations) {
                            foreach ($formations as $formation) {
                                echo '<li><a href="' . get_permalink($formation->ID) . '">' . esc_html($formation->post_title) . '</a></li>';
                            }
                        } else {
                            echo '<li><a href="' . get_permalink($formations_page->ID) . '">Voir toutes les formations</a></li>';
                        }
                    } else {
                        // Si pas de page Formations, chercher toutes les pages avec "formation" dans le titre
                        $all_pages = get_pages(array(
                            'sort_column' => 'post_title',
                            'sort_order' => 'ASC'
                        ));
                        
                        $has_formations = false;
                        foreach ($all_pages as $page) {
                            if (stripos($page->post_title, 'formation') !== false && $page->post_parent == 0) {
                                echo '<li><a href="' . get_permalink($page->ID) . '">' . esc_html($page->post_title) . '</a></li>';
                                $has_formations = true;
                            }
                        }
                        
                        if (!$has_formations) {
                            echo '<li><a href="' . home_url('/#formations') . '">Voir nos formations</a></li>';
                        }
                    }
                    ?>
                </ul>
            </li>
            
            <li><a href="<?php echo home_url('/blog/'); ?>">Blog</a></li>
            <li><a href="<?php echo home_url('/#testimonials'); ?>">Témoignages</a></li>
            <li><a href="<?php echo home_url('/#contact'); ?>">Contact</a></li>
            <li><a href="<?php echo home_url('/#contact'); ?>" class="nav-cta">Demande de devis</a></li>
        </ul>
        
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