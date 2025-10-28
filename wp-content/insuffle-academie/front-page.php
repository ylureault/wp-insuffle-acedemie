<?php
/**
 * Template Name: Page d'Accueil Insuffle
 */

get_header(); ?>

<style>
:root {
    --primary: #8E2183;
    --secondary: #FFD466;
    --accent: #FFC0CB;
    --light: #FFFFFF;
    --dark: #333333;
    --grey: #F5F5F5;
}

.hero {
    background-color: var(--primary);
    color: var(--light);
    padding: 100px 0 150px;
    position: relative;
    overflow: hidden;
}

.hero-content {
    display: flex;
    align-items: center;
    gap: 50px;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.hero-text {
    flex: 1;
}

.hero h1 {
    color: var(--light) !important;
    font-size: 4rem;
    font-weight: 800;
    margin-bottom: 30px;
    line-height: 1.1;
}

.hero h1 span {
    color: var(--secondary) !important;
    display: block;
}

.hero-subtitle {
    font-size: 1.8rem;
    margin-bottom: 20px;
    color: var(--secondary);
}

.hero p {
    font-size: 1.2rem;
    margin-bottom: 40px;
    max-width: 600px;
    color: var(--light);
}

.hero-image {
    flex: 1;
}

.hero-image img {
    max-width: 100%;
    border-radius: 20px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.3);
}

.btn {
    display: inline-block;
    background-color: var(--secondary);
    color: var(--primary);
    padding: 15px 40px;
    font-size: 1.2rem;
    font-weight: 600;
    text-decoration: none;
    border-radius: 50px;
    transition: all 0.3s ease;
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

.btn:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.3);
}

.about {
    padding: 100px 0;
    background-color: var(--light);
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.about-header {
    text-align: center;
    margin-bottom: 80px;
}

.section-subtitle {
    color: var(--primary);
    font-size: 1.2rem;
    font-weight: 600;
    margin-bottom: 10px;
    text-transform: uppercase;
    letter-spacing: 2px;
}

.section-title {
    font-size: 3.5rem;
    font-weight: 800;
    color: var(--primary);
    margin-bottom: 20px;
}

.section-description {
    font-size: 1.2rem;
    max-width: 800px;
    margin: 0 auto;
}

.approach-cards {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 30px;
    margin-bottom: 50px;
}

.approach-card {
    background-color: var(--grey);
    padding: 40px 30px;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    transition: all 0.3s ease;
}

.approach-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 40px rgba(0,0,0,0.1);
}

.approach-icon {
    font-size: 3rem;
    color: var(--primary);
    margin-bottom: 20px;
}

.approach-card h3 {
    font-size: 1.5rem;
    margin-bottom: 15px;
    color: var(--primary);
}

.formations {
    padding: 100px 0;
    background-color: var(--primary);
    color: var(--light);
}

.formations .section-title {
    color: var(--light);
}

.formations-cards {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 30px;
}

.formation-card {
    background-color: var(--light);
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    transition: all 0.3s ease;
    color: var(--dark);
}

.formation-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 40px rgba(0,0,0,0.3);
}

.formation-image {
    overflow: hidden;
    height: 200px;
    background: linear-gradient(135deg, var(--primary), var(--secondary));
}

.formation-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.formation-content {
    padding: 30px;
}

.formation-content h3 {
    font-size: 1.5rem;
    margin-bottom: 10px;
    color: var(--primary);
}

.formation-meta {
    display: flex;
    gap: 20px;
    margin-bottom: 15px;
    font-size: 0.9rem;
    color: #666;
}

.formation-links {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-top: 15px;
}

.download-link {
    display: inline-block;
    color: var(--primary);
    font-size: 0.95rem;
    text-decoration: none;
    text-align: center;
    transition: all 0.3s;
}

.download-link:hover {
    color: var(--secondary);
    text-decoration: underline;
}

.download-link::before {
    content: "📄 ";
    margin-right: 5px;
}

.testimonials {
    padding: 100px 0;
    background-color: var(--light);
}

.testimonials-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 30px;
}

.testimonial-card {
    background-color: var(--grey);
    padding: 40px 30px;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
}

.testimonial-quote {
    font-size: 1.2rem;
    line-height: 1.6;
    margin-bottom: 20px;
    font-style: italic;
    font-weight: 600;
    color: var(--primary);
}

.cta {
    padding: 100px 0;
    background-color: var(--primary);
    color: var(--light);
    text-align: center;
}

.cta .section-title {
    color: var(--light);
    margin-bottom: 30px;
}

.form-container {
    background-color: var(--light);
    border-radius: 20px;
    padding: 40px;
    max-width: 600px;
    margin: 0 auto;
    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
}

.form-container h3 {
    font-size: 1.5rem;
    margin-bottom: 20px;
    color: var(--primary);
    text-align: center;
}

.location {
    padding: 100px 0;
    text-align: center;
    background-color: var(--light);
}

@media (max-width: 992px) {
    .hero-content {
        flex-direction: column;
    }
    
    .approach-cards, .testimonials-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    .hero h1 {
        font-size: 3rem;
    }
    
    .section-title {
        font-size: 2.5rem;
    }
    
    .approach-cards, .testimonials-grid, .formations-cards {
        grid-template-columns: 1fr;
    }
}
</style>

<!-- Section Hero -->
<section class="hero">
    <div class="hero-content">
        <div class="hero-text">
            <div class="hero-subtitle">Organisme de formation</div>
            <h1>Libérez la puissance de <span>l'intelligence collective</span></h1>
            <p>Insuffle Académie vous forme aux techniques de facilitation et d'intelligence collective pour transformer vos réunions, stimuler la créativité de vos équipes et révolutionner votre façon de travailler ensemble.</p>
            
            <a href="#formations" class="btn">Découvrir nos formations</a>
        </div>
        <div class="hero-image">
            <img src="http://www.insuffle-academie.com/img/insuffle-academie-banner.PNG" alt="Formation facilitation et intelligence collective">
        </div>
    </div>
</section>

<!-- Section À propos -->
<section class="about" id="about">
    <div class="container">
        <div class="about-header">
            <div class="section-subtitle">Notre philosophie</div>
            <h2 class="section-title">L'intelligence collective au service de votre organisation</h2>
            <p class="section-description">Insuffle Académie est l'organisme de formation de la société Insuffle, cabinet de conseil spécialisé en facilitation et intelligence collective. Nous transformons la façon dont les organisations collaborent, innovent et prennent des décisions grâce à des méthodes participatives éprouvées.</p>
        </div>
        
        <div class="approach-cards">
            <div class="approach-card">
                <div class="approach-icon">🚀</div>
                <h3>Insuffle, cabinet de facilitation</h3>
                <p>Insuffle accompagne les organisations à travers la conception et l'animation d'ateliers collaboratifs, séminaires, et interventions en intelligence collective. Notre académie transmet ce savoir-faire unique aux professionnels souhaitant intégrer ces pratiques.</p>
            </div>
            
            <div class="approach-card">
                <div class="approach-icon">🧠</div>
                <h3>De l'expertise à la transmission</h3>
                <p>Nos formateurs sont avant tout des praticiens qui interviennent quotidiennement sur le terrain. Cette double casquette garantit des formations ancrées dans la réalité, avec des techniques immédiatement applicables dans votre contexte professionnel.</p>
            </div>
            
            <div class="approach-card">
                <div class="approach-icon">🤝</div>
                <h3>Une pédagogie immersive</h3>
                <p>Notre méthodologie d'apprentissage est basée sur l'expérimentation et la pratique. Nous créons des espaces d'apprentissage où les participants vivent l'intelligence collective plutôt que de simplement en parler.</p>
            </div>
        </div>
        
        <div class="about-cta" style="text-align: center;">
            <a href="#contact" class="btn">En savoir plus sur notre approche</a>
        </div>
    </div>
</section>

<!-- Section Formations -->
<section class="formations" id="formations">
    <div class="container">
        <div class="formations-header" style="text-align: center; margin-bottom: 60px;">
            <div class="section-subtitle" style="color: #FFD466;">Nos programmes</div>
            <h2 class="section-title">Formations en facilitation et intelligence collective</h2>
            <p class="section-description">Découvrez nos programmes de formation pour développer vos compétences en facilitation, animation de groupe et intelligence collective. Toutes nos formations sont disponibles en présentiel à Deauville ou à distance.</p>
        </div>
        
        <div class="formations-cards">
            <?php
            // Récupérer les formations (pages enfants de la page "Formations")
            $formations = insuffle_get_formations(array(
                'posts_per_page' => 6,
            ));
            
            if ($formations) :
                foreach ($formations as $formation) :
                    setup_postdata($formation);
                    
                    // Récupérer l'URL de la plaquette (champ personnalisé)
                    $plaquette_url = get_post_meta($formation->ID, 'plaquette_url', true);
            ?>
                <div class="formation-card">
                    <?php if (has_post_thumbnail($formation->ID)) : ?>
                        <div class="formation-image">
                            <?php echo get_the_post_thumbnail($formation->ID, 'formation-card'); ?>
                        </div>
                    <?php endif; ?>
                    
                    <div class="formation-content">
                        <h3><?php echo get_the_title($formation->ID); ?></h3>
                        
                        <?php if ($formation->post_excerpt) : ?>
                            <div class="formation-meta">
                                <span><?php echo esc_html($formation->post_excerpt); ?></span>
                            </div>
                        <?php endif; ?>
                        
                        <p><?php echo wp_trim_words(get_the_excerpt($formation->ID), 20); ?></p>
                        
                        <div class="formation-links">
                            <a href="<?php echo get_permalink($formation->ID); ?>" class="btn" style="width: 100%; text-align: center;">Voir le programme</a>
                            <?php if ($plaquette_url) : ?>
                                <a href="<?php echo esc_url($plaquette_url); ?>" class="download-link" target="_blank" rel="noopener">Télécharger la plaquette</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php
                endforeach;
                wp_reset_postdata();
            else :
            ?>
                <p style="color: white; text-align: center; width: 100%;">Aucune formation disponible pour le moment. Créez des pages enfants sous la page "Formations" pour les afficher ici.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Section Témoignages -->
<section class="testimonials" id="testimonials">
    <div class="container">
        <div class="testimonials-header" style="text-align: center; margin-bottom: 60px;">
            <div class="section-subtitle">Ce qu'ils en disent</div>
            <h2 class="section-title">Témoignages de nos apprenants</h2>
            <p class="section-description">Découvrez les retours d'expérience de professionnels qui ont suivi nos formations en facilitation et intelligence collective.</p>
        </div>
        
        <div class="testimonials-grid">
            <div class="testimonial-card">
                <p class="testimonial-quote">"Très bonne formation avec beaucoup de pratique et de vrais résultats au bout des 2 jours !"</p>
                <p class="testimonial-author" style="font-weight: 600;">Andrea</p>
            </div>
            
            <div class="testimonial-card">
                <p class="testimonial-quote">"Formation bluffante avec un niveau ridicule on arrive à j+2 à des résultats extras. Merci et bravo"</p>
                <p class="testimonial-author" style="font-weight: 600;">Charlotte</p>
            </div>
            
            <div class="testimonial-card">
                <p class="testimonial-quote">"Excellente formation, ludique et intéressante. J'ai énormément appris."</p>
                <p class="testimonial-author" style="font-weight: 600;">Benjamin</p>
            </div>
        </div>
    </div>
</section>

<!-- Section CTA -->
<section class="cta" id="contact">
    <div class="container">
        <div class="cta-content">
            <div class="section-subtitle" style="color: #FFD466;">Contactez-nous</div>
            <h2 class="section-title">Prêt à révolutionner votre approche du collectif ?</h2>
            <p style="font-size: 1.2rem; margin-bottom: 40px;">Vous souhaitez obtenir plus d'informations sur nos formations, recevoir un devis personnalisé ou vous inscrire à notre prochaine session ? Remplissez le formulaire ci-dessous et nous vous répondrons dans les 24 heures.</p>
            
            <div class="form-container">
                <h3>Demande d'information</h3>
                <iframe data-tally-src="https://tally.so/embed/wgV2Q4?alignLeft=1&hideTitle=1&transparentBackground=1&dynamicHeight=1" loading="lazy" width="100%" height="200" frameborder="0" marginheight="0" marginwidth="0" title="Renseignements"></iframe>
                <script>var d=document,w="https://tally.so/widgets/embed.js",v=function(){"undefined"!=typeof Tally?Tally.loadEmbeds():d.querySelectorAll("iframe[data-tally-src]:not([src])").forEach((function(e){e.src=e.dataset.tallySrc}))};if("undefined"!=typeof Tally)v();else if(d.querySelector('script[src="'+w+'"]')==null){var s=d.createElement("script");s.src=w,s.onload=v,s.onerror=v,d.body.appendChild(s);}</script>
            </div>
        </div>
    </div>
</section>

<!-- Section Localisation -->
<section class="location">
    <div class="container">
        <div class="location-content">
            <div class="section-subtitle">Notre organisme de formation</div>
            <h2 class="section-title">Insuffle Académie à Deauville</h2>
            <p style="font-size: 1.2rem; margin-bottom: 30px;">Insuffle Académie est l'organisme de formation de la société Insuffle, cabinet spécialisé en facilitation et intelligence collective. Basé à Deauville en Normandie, nous proposons des formations qui permettent aux professionnels d'acquérir les compétences nécessaires pour révéler le potentiel des collectifs.</p>
            <p style="font-size: 1.2rem;">Nos espaces de formation sont accessibles depuis Paris (2h), Caen (45min) et Rouen (1h). Toutes nos formations sont également disponibles en format distanciel pour les participants ne pouvant pas se déplacer.</p>
        </div>
    </div>
</section>

<?php get_footer(); ?>