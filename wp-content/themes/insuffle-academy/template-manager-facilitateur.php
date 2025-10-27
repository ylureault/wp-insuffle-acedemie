<?php
/**
 * Template Name: Manager Facilitateur - Page de Vente
 * Template Post Type: page
 *
 * @package Insuffle_Academy
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php wp_head(); ?>

    <style>
        /* Override pour cette page spécifique */
        #page {
            background: var(--light);
        }

        .site-content {
            padding: 0 !important;
        }
    </style>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">

    <!-- Navigation -->
    <nav style="background: linear-gradient(135deg, var(--primary) 0%, var(--game-purple) 100%); position: sticky; top: 0; z-index: 1000; box-shadow: 0 4px 20px rgba(0,0,0,0.2);">
        <div class="container">
            <div class="nav-container" style="display: flex; justify-content: space-between; align-items: center; padding: 15px 0;">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="nav-logo" style="font-size: 1.5rem; color: var(--light); font-weight: 800; text-decoration: none; display: flex; align-items: center; gap: 10px;">
                    <span>🎯</span>
                    <span>MANAGER FACILITATEUR</span>
                </a>
                <ul class="nav-menu" style="display: flex; list-style: none; gap: 30px; align-items: center;">
                    <li><a href="#pourquoi" style="color: var(--light); text-decoration: none; font-weight: 600;">Pourquoi ?</a></li>
                    <li><a href="#competences" style="color: var(--light); text-decoration: none; font-weight: 600;">Compétences</a></li>
                    <li><a href="#transformation" style="color: var(--light); text-decoration: none; font-weight: 600;">Transformation</a></li>
                    <li><a href="#temoignages" style="color: var(--light); text-decoration: none; font-weight: 600;">Témoignages</a></li>
                    <li><a href="#contact" class="nav-cta" style="background: linear-gradient(135deg, var(--game-gold) 0%, var(--game-orange) 100%); color: var(--dark) !important; padding: 12px 30px; border-radius: 50px; font-weight: 800; text-decoration: none;">📬 ME TENIR INFORMÉ·E</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div id="content" class="site-content">

        <!-- Hero Section -->
        <section class="hero">
            <div class="container">
                <div class="hero-content">
                    <div class="hero-badge">🏆 LA FORMATION QUI RÉVOLUTIONNE LE MANAGEMENT</div>
                    <span class="hero-emoji">🎯</span>
                    <h1>MANAGER FACILITATEUR<br>Le Leadership de Demain</h1>
                    <p class="hero-subtitle">Ne gérez plus vos équipes. Libérez leur potentiel.</p>
                    <p class="hero-description">
                        Et si vous passiez du "manager qui contrôle" au "leader qui facilite" ? Découvrez comment transformer radicalement votre approche du management en développant l'intelligence collective, la collaboration et la performance durable de vos équipes.
                    </p>

                    <div class="hero-cta-group">
                        <a href="#annonce" class="btn btn-primary">🚀 RETOUR EN 2026</a>
                        <a href="#pourquoi" class="btn btn-secondary">✨ DÉCOUVRIR</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Annonce 2026 -->
        <section id="annonce" style="background: linear-gradient(135deg, var(--game-blue) 0%, #1976d2 100%); color: var(--light); padding: 40px 0; text-align: center; position: relative; overflow: hidden;">
            <div class="container">
                <div style="position: relative; z-index: 2;">
                    <h2 style="font-size: 2.5rem; font-weight: 900; margin-bottom: 20px;">📅 La formation revient en 2026 !</h2>
                    <p style="font-size: 1.3rem; max-width: 800px; margin: 0 auto 30px; line-height: 1.8;">
                        Suite au succès des éditions précédentes et pour garantir la meilleure qualité d'accompagnement,
                        nous reprenons cette formation exceptionnelle en <strong>2026</strong>.
                        Inscrivez-vous à notre liste d'attente pour être informé·e en priorité des prochaines dates et bénéficier d'un accès anticipé.
                    </p>
                    <a href="#contact" class="btn btn-primary" style="background: white; color: var(--game-blue);">
                        ✉️ REJOINDRE LA LISTE D'ATTENTE
                    </a>
                </div>
            </div>
        </section>

        <!-- Section Pourquoi -->
        <section id="pourquoi" style="padding: 100px 0;">
            <div class="container">
                <div class="section-subtitle">POURQUOI MANAGER FACILITATEUR ?</div>
                <h2 class="section-title">Parce Que Le Management Traditionnel Ne Fonctionne Plus</h2>
                <p class="section-description">
                    Dans un monde complexe et incertain, les équipes ont besoin de managers qui libèrent l'intelligence collective, pas qui contrôlent. Devenez celui ou celle qui transforme.
                </p>

                <div class="why-grid" style="margin-top: 60px;">
                    <div class="why-card fade-in-up">
                        <span class="why-icon">🔥</span>
                        <h3 class="why-title">Du Contrôle à l'Autonomie</h3>
                        <p class="why-description">
                            Apprenez à faire confiance et à responsabiliser vos équipes. Passez de "je décide pour eux" à "je crée les conditions pour qu'ils décident". L'autonomie libère la créativité et l'engagement.
                        </p>
                    </div>

                    <div class="why-card fade-in-up">
                        <span class="why-icon">🤝</span>
                        <h3 class="why-title">De l'Individualisme au Collectif</h3>
                        <p class="why-description">
                            Développez l'intelligence collective de votre équipe. Apprenez à animer des ateliers collaboratifs, à faire émerger les solutions du groupe, et à transformer les tensions en opportunités.
                        </p>
                    </div>

                    <div class="why-card fade-in-up">
                        <span class="why-icon">💡</span>
                        <h3 class="why-title">Du Sachant au Facilitateur</h3>
                        <p class="why-description">
                            Vous n'avez plus besoin d'avoir toutes les réponses. Posez les bonnes questions, créez les espaces de réflexion, et laissez l'expertise émerger de votre équipe. C'est ça, le vrai leadership.
                        </p>
                    </div>

                    <div class="why-card fade-in-up">
                        <span class="why-icon">🎯</span>
                        <h3 class="why-title">Des Résultats Concrets</h3>
                        <p class="why-description">
                            Performance durable, engagement renforcé, créativité décuplée, turnover réduit. Les équipes managées avec une posture de facilitation surperforment. Et ça se mesure.
                        </p>
                    </div>

                    <div class="why-card fade-in-up">
                        <span class="why-icon">🌱</span>
                        <h3 class="why-title">Un Leadership Incarné</h3>
                        <p class="why-description">
                            Plus qu'une formation, c'est une transformation personnelle. Développez votre présence, votre écoute, votre capacité à tenir un cadre bienveillant et exigeant. Devenez le leader que vous auriez aimé avoir.
                        </p>
                    </div>

                    <div class="why-card fade-in-up">
                        <span class="why-icon">⚡</span>
                        <h3 class="why-title">Approche Expérientielle</h3>
                        <p class="why-description">
                            80% de pratique, 20% de théorie. Vous vivez la facilitation avant de la pratiquer. Des mises en situation réelles, des feedbacks constructifs, un apprentissage par le corps et les émotions.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Section Compétences -->
        <section id="competences" class="badges-section">
            <div class="container">
                <div class="section-subtitle" style="color: var(--game-gold);">LES COMPÉTENCES CLÉS</div>
                <h2 class="section-title" style="color: var(--light);">Ce Que Vous Allez Développer</h2>
                <p class="section-description" style="color: rgba(255,255,255,0.9);">
                    Un manager facilitateur maîtrise un ensemble de compétences qui transforment radicalement sa façon de manager. Voici ce que vous allez acquérir.
                </p>

                <div class="badges-grid">
                    <div class="badge-card fade-in-up">
                        <div class="badge-header">
                            <span class="badge-icon">👂</span>
                            <h3 class="badge-name">Écoute Active & Questions Puissantes</h3>
                        </div>
                        <ul class="badge-skills">
                            <li>Pratiquer l'écoute générative</li>
                            <li>Poser des questions qui ouvrent</li>
                            <li>Reformuler pour faire émerger le sens</li>
                            <li>Créer un espace de parole authentique</li>
                        </ul>
                    </div>

                    <div class="badge-card fade-in-up">
                        <div class="badge-header">
                            <span class="badge-icon">🎨</span>
                            <h3 class="badge-name">Animation de Réunions Collaboratives</h3>
                        </div>
                        <ul class="badge-skills">
                            <li>Designer des ateliers participatifs</li>
                            <li>Animer un World Café, un 1-2-4-All</li>
                            <li>Faciliter une prise de décision collective</li>
                            <li>Créer l'engagement dès les premières minutes</li>
                        </ul>
                    </div>

                    <div class="badge-card fade-in-up">
                        <div class="badge-header">
                            <span class="badge-icon">🛡️</span>
                            <h3 class="badge-name">Gestion des Dynamiques de Groupe</h3>
                        </div>
                        <ul class="badge-skills">
                            <li>Réguler les tensions et les conflits</li>
                            <li>Gérer les résistances avec bienveillance</li>
                            <li>Donner la parole aux introvertis</li>
                            <li>Canaliser l'énergie du groupe</li>
                        </ul>
                    </div>

                    <div class="badge-card fade-in-up">
                        <div class="badge-header">
                            <span class="badge-icon">🌊</span>
                            <h3 class="badge-name">Posture de Leader Facilitateur</h3>
                        </div>
                        <ul class="badge-skills">
                            <li>Incarner la neutralité bienveillante</li>
                            <li>Développer sa présence et son ancrage</li>
                            <li>S'adapter avec agilité à l'inattendu</li>
                            <li>Créer la sécurité psychologique</li>
                        </ul>
                    </div>

                    <div class="badge-card fade-in-up">
                        <div class="badge-header">
                            <span class="badge-icon">🗺️</span>
                            <h3 class="badge-name">Intelligence Collective</h3>
                        </div>
                        <ul class="badge-skills">
                            <li>Faire émerger la créativité collective</li>
                            <li>Co-construire des solutions innovantes</li>
                            <li>Transformer la diversité en richesse</li>
                            <li>Accompagner le changement avec le collectif</li>
                        </ul>
                    </div>

                    <div class="badge-card fade-in-up">
                        <div class="badge-header">
                            <span class="badge-icon">🎯</span>
                            <h3 class="badge-name">Cadre & Intention</h3>
                        </div>
                        <ul class="badge-skills">
                            <li>Poser un cadre clair et sécurisant</li>
                            <li>Définir une intention puissante</li>
                            <li>Créer des règles du jeu engageantes</li>
                            <li>Allier bienveillance et exigence</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <!-- Section Transformation -->
        <section id="transformation" style="padding: 100px 0;">
            <div class="container">
                <div class="section-subtitle">LA TRANSFORMATION</div>
                <h2 class="section-title">Avant / Après Manager Facilitateur</h2>
                <p class="section-description">
                    Ce n'est pas juste une formation. C'est une transformation profonde de votre façon d'être manager.
                </p>

                <div class="why-grid" style="margin-top: 60px; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));">
                    <div class="why-card">
                        <h3 class="why-title">❌ AVANT : Manager Contrôleur</h3>
                        <ul class="badge-skills">
                            <li style="color: #666; opacity: 0.8;">Réunions interminables et improductives</li>
                            <li style="color: #666; opacity: 0.8;">Décisions prises seul·e dans son coin</li>
                            <li style="color: #666; opacity: 0.8;">Équipe passive qui attend les ordres</li>
                            <li style="color: #666; opacity: 0.8;">Burn-out du manager surchargé</li>
                            <li style="color: #666; opacity: 0.8;">Créativité et engagement en berne</li>
                        </ul>
                    </div>

                    <div class="why-card">
                        <h3 class="why-title">✅ APRÈS : Manager Facilitateur</h3>
                        <ul class="badge-skills">
                            <li>Réunions dynamiques et créatives</li>
                            <li>Décisions co-construites et portées par tous</li>
                            <li>Équipe autonome et responsable</li>
                            <li>Manager serein et inspirant</li>
                            <li>Innovation et engagement au rendez-vous</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <!-- Section Témoignages -->
        <section id="temoignages" class="testimonials-section">
            <div class="container">
                <div class="section-subtitle">ILS L'ONT VÉCU</div>
                <h2 class="section-title">Ce Qu'en Disent Les Managers</h2>
                <p class="section-description">
                    Des transformations authentiques, des résultats mesurables.
                </p>

                <div class="testimonials-grid">
                    <div class="testimonial-card fade-in-up">
                        <div class="testimonial-stars">⭐⭐⭐⭐⭐</div>
                        <p class="testimonial-text">
                            "J'ai complètement changé ma façon de manager. Mes réunions d'équipe sont devenues des moments de co-création incroyables. Mon équipe est plus engagée, plus créative, et moi je suis moins stressé. C'est magique."
                        </p>
                        <div class="testimonial-author">
                            <div class="testimonial-avatar">PM</div>
                            <div class="testimonial-info">
                                <div class="testimonial-name">Pierre Moreau</div>
                                <div class="testimonial-role">Manager IT, 15 personnes</div>
                            </div>
                        </div>
                    </div>

                    <div class="testimonial-card fade-in-up">
                        <div class="testimonial-stars">⭐⭐⭐⭐⭐</div>
                        <p class="testimonial-text">
                            "Cette formation m'a transformée. J'ai arrêté de vouloir tout contrôler et j'ai commencé à faire confiance. Résultat : mes collaborateurs prennent des initiatives, proposent des solutions que je n'aurais jamais imaginées. Un game changer total."
                        </p>
                        <div class="testimonial-author">
                            <div class="testimonial-avatar">SB</div>
                            <div class="testimonial-info">
                                <div class="testimonial-name">Sophie Bernard</div>
                                <div class="testimonial-role">Directrice Marketing</div>
                            </div>
                        </div>
                    </div>

                    <div class="testimonial-card fade-in-up">
                        <div class="testimonial-stars">⭐⭐⭐⭐⭐</div>
                        <p class="testimonial-text">
                            "J'étais sceptique au début. Mais après avoir testé les outils sur mon équipe, les résultats sont là : +40% d'engagement, turnover divisé par 2, et une ambiance de travail incroyable. C'est l'investissement le plus rentable que j'ai fait."
                        </p>
                        <div class="testimonial-author">
                            <div class="testimonial-avatar">LT</div>
                            <div class="testimonial-info">
                                <div class="testimonial-name">Laurent Thomas</div>
                                <div class="testimonial-role">Directeur d'Agence</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Final -->
        <section id="contact" class="final-cta-section">
            <div class="container">
                <div class="final-cta-content">
                    <h2 class="final-cta-title">
                        Prêt·e à Révolutionner<br>Votre Management ?
                    </h2>
                    <p class="final-cta-description">
                        La formation Manager Facilitateur revient en 2026.<br>
                        Rejoignez la liste d'attente pour être informé·e en priorité et bénéficier d'un accès anticipé.
                    </p>

                    <div style="margin-bottom: 50px;">
                        <a href="mailto:contact@insuffle-academie.com?subject=Liste d'attente Manager Facilitateur 2026" class="btn btn-primary" style="font-size: 1.3rem; padding: 22px 60px; margin: 0 10px 15px;">
                            ✉️ REJOINDRE LA LISTE D'ATTENTE
                        </a>
                        <br>
                        <a href="mailto:contact@insuffle-academie.com?subject=Question sur Manager Facilitateur" class="btn btn-secondary" style="font-size: 1.1rem; padding: 18px 40px; margin: 0 10px;">
                            💬 POSER UNE QUESTION
                        </a>
                    </div>

                    <div style="background: rgba(255,255,255,0.1); padding: 30px; border-radius: 20px; backdrop-filter: blur(10px); max-width: 600px; margin: 0 auto;">
                        <h4 style="font-size: 1.3rem; margin-bottom: 20px; color: var(--game-gold);">📞 Nous Contacter</h4>
                        <p style="font-size: 1.1rem; margin-bottom: 10px;">
                            <strong>Email :</strong> <?php echo esc_html( get_theme_mod( 'insuffle_contact_email', 'contact@insuffle-academie.com' ) ); ?>
                        </p>
                        <p style="font-size: 1.1rem; margin-bottom: 10px;">
                            <strong>Téléphone :</strong> <?php echo esc_html( get_theme_mod( 'insuffle_contact_phone', '+33 9 80 80 89 62' ) ); ?>
                        </p>
                        <p style="font-size: 1.1rem;">
                            <strong>Site Web :</strong> <a href="<?php echo esc_url( get_theme_mod( 'insuffle_website_url', 'https://insuffle-academie.com' ) ); ?>" style="color: var(--game-gold); text-decoration: underline;">insuffle-academie.com</a>
                        </p>
                    </div>
                </div>
            </div>
        </section>

    </div><!-- #content -->

    <?php get_footer(); ?>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
