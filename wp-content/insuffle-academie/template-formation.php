<?php
/**
 * Template Name: Page Formation
 * Description: Template pour créer une page de formation
 */

get_header(); 

while (have_posts()) : the_post();
?>

<style>
:root {
    --primary: #8E2183;
    --secondary: #FFD466;
    --accent: #FFC0CB;
    --light: #FFFFFF;
    --dark: #333333;
    --grey: #F5F5F5;
}

/* Hero Formation */
.formation-hero {
    background: linear-gradient(135deg, rgba(142, 33, 131, 0.9) 0%, rgba(158, 49, 147, 0.9) 100%);
    color: white;
    padding: 100px 0 80px;
    position: relative;
    overflow: hidden;
    background-size: cover;
    color: var(--light);
    background-position: center;
    background-repeat: no-repeat;
}

/* Overlay sombre pour améliorer la lisibilité sur l'image */
.formation-hero::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(142, 33, 131, 0.85) 0%, rgba(158, 49, 147, 0.85) 100%);
    z-index: 1;
}

.formation-hero::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -10%;
    width: 600px;
    height: 600px;
    background: rgba(255, 212, 102, 0.1);
    border-radius: 50%;
    z-index: 1;
}

.formation-hero-content {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
    position: relative;
    z-index: 3;
        color: white;

}

.formation-breadcrumb {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 30px;
    font-size: 0.95rem;
}

.formation-breadcrumb a {
    color: var(--secondary);
    text-decoration: none;
}

.formation-breadcrumb a:hover {
    opacity: 0.8;
}

.formation-hero h1 {
    font-size: 3.5rem;
    font-weight: 800;
    margin-bottom: 20px;
    line-height: 1.1;
    color: white;
}

.formation-hero-excerpt {
    font-size: 1.3rem;
    opacity: 0.95;
    max-width: 800px;
}

/* Contenu de la formation */
.formation-content-wrapper {
    background: white;
    padding: 80px 0;
}

.formation-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

/* Styles pour les blocs WordPress/Gutenberg */
.formation-container .wp-block-heading {
    color: var(--primary);
    font-weight: 700;
    margin-top: 50px;
    margin-bottom: 25px;
}

.formation-container h1,
.formation-container .wp-block-heading.has-huge-font-size {
    font-size: 2.5rem;
    border-bottom: 3px solid var(--secondary);
    padding-bottom: 15px;
    margin-top: 0;
}

.formation-container h2 {
    font-size: 2rem;
    position: relative;
    padding-left: 25px;
}

.formation-container h2::before {
    content: '';
    position: absolute;
    left: 0;
    top: 50%;
    transform: translateY(-50%);
    width: 5px;
    height: 35px;
    background: var(--secondary);
    border-radius: 3px;
}

.formation-container h3 {
    font-size: 1.5rem;
    margin-top: 35px;
}

.formation-container h4 {
    font-size: 1.3rem;
    color: var(--dark);
    margin-top: 30px;
}

.formation-container p {
    font-size: 1.1rem;
    line-height: 1.8;
    margin-bottom: 20px;
    color: #555;
}

.formation-container ul,
.formation-container ol {
    margin: 20px 0;
    padding-left: 0;
}

.formation-container li {
    font-size: 1.1rem;
    line-height: 1.8;
    margin-bottom: 15px;
    color: #555;
}

.formation-container .wp-block-list:not(.has-background) li {
    position: relative;
    list-style: none;
    padding-left: 35px;
    margin-bottom: 12px;
}

.formation-container .wp-block-list:not(.has-background) li::before {
    content: '✓';
    position: absolute;
    left: 0;
    top: 2px;
    color: var(--primary);
    font-weight: bold;
    font-size: 1.2rem;
}

/* Blocs Cover (Hero des formations individuelles) */
.formation-container .wp-block-cover {
    margin: 0 0 40px 0;
    border-radius: 15px;
    overflow: hidden;
}

/* Blocs Colonnes */
.formation-container .wp-block-columns {
    margin: 40px 0;
    display: flex;
    gap: 30px;
    flex-wrap: wrap;
}

.formation-container .wp-block-column {
    background: var(--grey);
    padding: 30px;
    border-radius: 15px;
    flex: 1;
    min-width: 280px;
}

.formation-container .wp-block-columns.section-primary .wp-block-column,
.formation-container .section-primary .wp-block-column {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
}

/* Blocs Quote */
.formation-container blockquote,
.formation-container .wp-block-quote {
    background: linear-gradient(135deg, var(--grey) 0%, #fff 100%);
    border-left: 5px solid var(--primary);
    padding: 30px 35px;
    margin: 40px 0;
    border-radius: 15px;
    font-style: italic;
    font-size: 1.2rem;
    color: #666;
    box-shadow: 0 5px 20px rgba(0,0,0,0.05);
}

.formation-container .wp-block-quote.is-style-large {
    font-size: 1.3rem;
    padding: 35px 40px;
}

.formation-container .wp-block-quote p {
    color: var(--primary);
    font-weight: 500;
    margin-bottom: 20px;
}

.formation-container .wp-block-quote cite {
    color: var(--dark);
    font-weight: 600;
    font-style: normal;
    display: block;
    margin-top: 15px;
    font-size: 1rem;
}

.formation-container .wp-block-quote cite::before {
    content: '— ';
    color: var(--primary);
}

/* Blocs Groupe avec classes personnalisées */
.formation-container .section-grey {
    background: var(--grey);
    padding: 50px;
    border-radius: 20px;
    margin: 50px 0;
    box-shadow: 0 5px 20px rgba(0,0,0,0.05);
}

.formation-container .section-primary {
    background: linear-gradient(135deg, var(--primary) 0%, #9e3193 100%);
    color: white;
    padding: 50px;
    border-radius: 20px;
    margin: 50px 0;
    box-shadow: 0 10px 30px rgba(142, 33, 131, 0.3);
}

.formation-container .section-primary h2,
.formation-container .section-primary h3,
.formation-container .section-primary h4 {
    color: white;
}

.formation-container .section-primary h2::before {
    background: var(--secondary);
}

.formation-container .section-primary p {
    color: white;
    opacity: 0.95;
}

.formation-container .section-primary .wp-block-list li {
    color: white;
}

.formation-container .section-primary .wp-block-list li::before {
    color: var(--secondary);
}

/* Boutons */
.formation-container .wp-block-button {
    margin: 20px 10px;
}

.formation-container .wp-block-button__link {
    background: var(--secondary);
    color: var(--primary);
    padding: 15px 40px;
    font-size: 1.1rem;
    font-weight: 600;
    border-radius: 50px;
    text-decoration: none;
    display: inline-block;
    transition: all 0.3s;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    border: 2px solid var(--secondary);
}

.formation-container .wp-block-button__link:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.2);
}

.formation-container .wp-block-button.is-style-outline .wp-block-button__link {
    background: transparent;
    color: var(--primary);
    border: 2px solid var(--primary);
}

.formation-container .wp-block-button.is-style-outline .wp-block-button__link:hover {
    background: var(--primary);
    color: white;
}

.formation-container .wp-block-buttons {
    margin: 30px 0;
}

.formation-container .wp-block-buttons.is-content-justification-center {
    justify-content: center;
    display: flex;
    flex-wrap: wrap;
}

/* Images */
.formation-container .wp-block-image {
    margin: 30px 0;
}

.formation-container .wp-block-image img {
    border-radius: 10px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

/* Spacer */
.formation-container .wp-block-spacer {
    display: block;
}

/* Tableaux */
.formation-container table,
.formation-container .wp-block-table {
    width: 100%;
    border-collapse: collapse;
    margin: 30px 0;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    border-radius: 10px;
    overflow: hidden;
}

.formation-container th {
    background: var(--primary);
    color: white;
    padding: 15px;
    text-align: left;
    font-weight: 600;
}

.formation-container td {
    padding: 15px;
    border-bottom: 1px solid #eee;
}

.formation-container tr:hover {
    background: var(--grey);
}

/* Classes utilitaires */
.formation-container .text-center,
.formation-container .has-text-align-center {
    text-align: center;
}

.formation-container .p-3 {
    padding: 30px;
}

/* Responsive */
@media (max-width: 992px) {
    .formation-hero h1 {
        font-size: 2.5rem;
    }
    
    .formation-container .wp-block-columns {
        flex-direction: column;
    }
    
    .formation-container .wp-block-column {
        min-width: 100%;
    }
    
    .formation-container .section-grey,
    .formation-container .section-primary {
        padding: 40px 30px;
    }
}

@media (max-width: 768px) {
    .formation-hero {
        padding: 80px 0 60px;
    }
    
    .formation-hero h1 {
        font-size: 2rem;
    }
    
    .formation-hero-excerpt {
        font-size: 1.1rem;
    }
    
    .formation-content-wrapper {
        padding: 60px 0;
    }
    
    .formation-container h1 {
        font-size: 2rem;
    }
    
    .formation-container h2 {
        font-size: 1.6rem;
    }
    
    .formation-container h3 {
        font-size: 1.3rem;
    }
    
    .formation-container .wp-block-button__link {
        padding: 12px 30px;
        font-size: 1rem;
    }
    
    .formation-container .section-grey,
    .formation-container .section-primary {
        padding: 30px 20px;
        margin: 30px 0;
    }
    
    .formation-container .wp-block-quote {
        padding: 25px 20px;
        font-size: 1.1rem;
    }
}

/* Styles pour améliorer le rendu des sections */
.formation-container > *:first-child {
    margin-top: 0;
}

.formation-container > *:last-child {
    margin-bottom: 0;
}
</style>

<!-- Hero de la page -->
<?php
// Récupérer l'image à la une
$featured_image_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
$hero_style = '';
if ($featured_image_url) {
    $hero_style = 'style="background-image: url(' . esc_url($featured_image_url) . ');"';
}
?>
<section class="formation-hero" <?php echo $hero_style; ?>>
    <div class="formation-hero-content">
        <nav class="formation-breadcrumb">
            <a href="<?php echo home_url(); ?>">Accueil</a>
            <span>›</span>
            <a href="<?php echo home_url('/formations'); ?>">Formations</a>
            <span>›</span>
            <span><?php the_title(); ?></span>
        </nav>
        
        <h1><?php the_title(); ?></h1>
        
        <?php if (has_excerpt()) : ?>
            <div class="formation-hero-excerpt">
                <?php the_excerpt(); ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Contenu de la page -->
<section class="formation-content-wrapper">
    <div class="formation-container">
        <?php the_content(); ?>
    </div>
</section>

<?php endwhile; ?>

<?php get_footer(); ?>