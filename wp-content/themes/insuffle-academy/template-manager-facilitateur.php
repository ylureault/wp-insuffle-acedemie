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
    <title><?php wp_title( '|', true, 'right' ); ?><?php bloginfo( 'name' ); ?></title>
    <?php wp_head(); ?>
    <style>
        /* Fix pour le menu responsive */
        @media (max-width: 1100px) {
            .nav-menu {
                gap: 12px !important;
                font-size: 0.85rem;
            }
            .nav-cta {
                padding: 10px 18px !important;
                font-size: 0.8rem !important;
            }
        }
        @media (max-width: 768px) {
            .nav-menu {
                flex-wrap: wrap;
                justify-content: center;
                gap: 8px !important;
            }
            .nav-container {
                flex-direction: column !important;
                gap: 15px;
            }
            .nav-logo {
                font-size: 1.1rem !important;
            }
        }
    </style>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- Navigation -->
<nav style="background: linear-gradient(135deg, var(--primary) 0%, var(--game-purple) 100%); position: sticky; top: 0; z-index: 1000; box-shadow: 0 4px 20px rgba(0,0,0,0.2);">
    <div class="container">
        <div class="nav-container" style="display: flex; justify-content: space-between; align-items: center; padding: 15px 0; flex-wrap: wrap;">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="nav-logo" style="font-size: 1.3rem; color: var(--light); font-weight: 800; text-decoration: none; display: flex; align-items: center; gap: 10px;">
                <span>🧭</span>
                <span>MANAGER FACILITATEUR</span>
            </a>
            <ul class="nav-menu" style="display: flex; list-style: none; gap: 18px; align-items: center; margin: 0; padding: 0; flex-wrap: wrap;">
                <li><a href="#boussole" style="color: var(--light); text-decoration: none; font-weight: 600; font-size: 0.95rem;">La Boussole 4C</a></li>
                <li><a href="#benefices" style="color: var(--light); text-decoration: none; font-weight: 600; font-size: 0.95rem;">Bénéfices</a></li>
                <li><a href="#programme" style="color: var(--light); text-decoration: none; font-weight: 600; font-size: 0.95rem;">Programme</a></li>
                <li><a href="#contact" class="nav-cta" style="background: linear-gradient(135deg, var(--game-gold) 0%, var(--game-orange) 100%); color: var(--dark) !important; padding: 10px 22px; border-radius: 50px; font-weight: 800; text-decoration: none; white-space: nowrap; font-size: 0.9rem;">📬 ME TENIR INFORMÉ·E</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<section class="hero">
    <div class="container">
        <div class="hero-content">
            <div class="hero-badge">🧭 FORMATION MANAGER FACILITATEUR PAR INSUFFLE ACADÉMIE</div>
            <span class="hero-emoji">🧭</span>
            <h1>MANAGER FACILITATEUR<br>Du Leadership Directif à la Facilitation Transformante</h1>
            <p class="hero-subtitle">Orientez sans imposer. Révélez sans contrôler.</p>
            <p class="hero-description">
                Passez d'un management qui contrôle à un leadership qui facilite. Apprenez à guider votre équipe vers l'autonomie et la performance collective grâce à la Boussole 4C et la démarche Voir, Désirer, Construire, Transformer.
            </p>

            <div class="hero-cta-group">
                <a href="#contact" class="btn btn-primary">✉️ REJOINDRE LA LISTE D'ATTENTE</a>
                <a href="#boussole" class="btn btn-secondary">🧭 DÉCOUVRIR LA BOUSSOLE 4C</a>
            </div>
        </div>
    </div>
</section>

<!-- Annonce 2026 -->
<section id="annonce" style="background: linear-gradient(135deg, var(--game-blue) 0%, #1976d2 100%); color: var(--light); padding: 60px 0; text-align: center; position: relative; overflow: hidden;">
    <div class="container">
        <div style="position: relative; z-index: 2;">
            <h2 style="font-size: 2.8rem; font-weight: 900; margin-bottom: 25px; text-shadow: 2px 2px 4px rgba(0,0,0,0.2);">🧭 La Formation Manager Facilitateur revient en 2026 !</h2>
            <p style="font-size: 1.4rem; max-width: 900px; margin: 0 auto 20px; line-height: 1.9; font-weight: 600;">
                <strong style="color: var(--game-gold);">Insuffle Académie</strong> vous propose cette formation transformante pour développer un leadership collaboratif basé sur la Boussole 4C.
            </p>
            <p style="font-size: 1.2rem; max-width: 850px; margin: 0 auto 35px; line-height: 1.8; opacity: 0.95;">
                Suite à une année de développement et d'amélioration continue, nous relançons cette formation exceptionnelle en <strong>2026</strong>.
                Un parcours de <strong>3 jours + 1 jour de consolidation (J+45)</strong> pour transformer durablement votre posture managériale.
            </p>
            <div style="margin-bottom: 35px; padding: 25px; background: rgba(255,255,255,0.15); border-radius: 15px; max-width: 700px; margin-left: auto; margin-right: auto; backdrop-filter: blur(10px);">
                <p style="font-size: 1.1rem; margin: 0; font-weight: 600;">
                    🧭 Boussole 4C — Le cadre de clarté<br>
                    🎯 Démarche Voir, Désirer, Construire, Transformer<br>
                    💪 Pédagogie Tête-Corps-Cœur éprouvée
                </p>
            </div>
            <a href="#contact" class="btn btn-primary" style="background: white; color: var(--game-blue); font-size: 1.2rem; padding: 18px 45px; box-shadow: 0 8px 30px rgba(255,255,255,0.3);">
                ✉️ REJOINDRE LA LISTE D'ATTENTE 2026
            </a>
        </div>
    </div>
</section>

<!-- La Boussole 4C -->
<section id="boussole" style="padding: 100px 0; background: var(--grey);">
    <div class="container">
        <div class="section-subtitle">LA MÉTHODE</div>
        <h2 class="section-title">La Boussole 4C — Le Cadre de Clarté</h2>

        <div style="max-width: 900px; margin: 0 auto 60px; text-align: center;">
            <p style="font-size: 1.3rem; line-height: 1.9; color: #555;">
                La <strong>Boussole 4C</strong> structure chaque accompagnement. Elle garde les organisations en équilibre entre vision, réalisme et mouvement.
            </p>
        </div>

        <div class="why-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 30px;">
            <div class="why-card fade-in-up">
                <span class="why-icon">🧭</span>
                <h3 class="why-title" style="color: var(--primary);">CAP</h3>
                <p style="margin-bottom: 15px; color: #666; font-weight: 600; font-size: 1.05rem;">Quelle direction sert encore le collectif ?</p>
                <p class="why-description">
                    <strong>Objectif :</strong> Donner la boussole commune. Clarifier le cap qui guide toutes les décisions et donne du sens à l'action collective.
                </p>
            </div>

            <div class="why-card fade-in-up">
                <span class="why-icon">🛡️</span>
                <h3 class="why-title" style="color: var(--primary);">CONTRAINTES</h3>
                <p style="margin-bottom: 15px; color: #666; font-weight: 600; font-size: 1.05rem;">Qu'est-ce qu'on refuse de franchir ?</p>
                <p class="why-description">
                    <strong>Objectif :</strong> Définir les lignes rouges. Poser les limites claires qui protègent l'intégrité du projet et l'équilibre de l'équipe.
                </p>
            </div>

            <div class="why-card fade-in-up">
                <span class="why-icon">⚡</span>
                <h3 class="why-title" style="color: var(--primary);">CAPACITÉS</h3>
                <p style="margin-bottom: 15px; color: #666; font-weight: 600; font-size: 1.05rem;">De quoi disposons-nous vraiment ?</p>
                <p class="why-description">
                    <strong>Objectif :</strong> Identifier les leviers concrets. S'appuyer sur les ressources, compétences et forces réelles à disposition.
                </p>
            </div>

            <div class="why-card fade-in-up">
                <span class="why-icon">⏱️</span>
                <h3 class="why-title" style="color: var(--primary);">CADENCE</h3>
                <p style="margin-bottom: 15px; color: #666; font-weight: 600; font-size: 1.05rem;">À quel rythme décidons-nous ?</p>
                <p class="why-description">
                    <strong>Objectif :</strong> Installer la respiration juste. Trouver le tempo qui permet d'avancer sans s'épuiser, de décider sans précipitation.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- La Démarche -->
<section style="padding: 100px 0; background: linear-gradient(135deg, var(--dark) 0%, #1a1a2e 100%); color: var(--light);">
    <div class="container">
        <div class="section-subtitle" style="color: var(--game-gold);">LA DÉMARCHE INSUFFLE</div>
        <h2 class="section-title" style="color: var(--light);">Voir, Désirer, Construire, Transformer</h2>

        <div style="max-width: 900px; margin: 0 auto 60px; text-align: center;">
            <p style="font-size: 1.3rem; line-height: 1.9; opacity: 0.95;">
                C'est la colonne vertébrale d'Insuffle. Une approche vivante, structurée, profondément humaine.
            </p>
        </div>

        <div class="why-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 35px;">
            <div class="badge-card fade-in-up" style="background: rgba(156, 39, 176, 0.2); border: 2px solid rgba(255, 215, 0, 0.3);">
                <div class="badge-header">
                    <span class="badge-icon">👁️</span>
                    <h3 class="badge-name">1️⃣ VOIR</h3>
                </div>
                <p style="opacity: 0.95; line-height: 1.8;">
                    Observer le réel sans filtre. Identifier les forces, les tensions, les zones d'ombre. Pas d'audit, pas de diagnostic stérile : une photo lucide. <strong>Parce que ce qu'on nomme, on peut le transformer.</strong>
                </p>
            </div>

            <div class="badge-card fade-in-up" style="background: rgba(156, 39, 176, 0.2); border: 2px solid rgba(255, 215, 0, 0.3);">
                <div class="badge-header">
                    <span class="badge-icon">✨</span>
                    <h3 class="badge-name">2️⃣ DÉSIRER</h3>
                </div>
                <p style="opacity: 0.95; line-height: 1.8;">
                    Formuler ensemble la phrase-boussole : ce cap clair, désirable, qui redonne de la direction et de la cohésion. C'est la mise en mots du sens collectif. <strong>Elle devient la référence commune à toutes les décisions.</strong>
                </p>
            </div>

            <div class="badge-card fade-in-up" style="background: rgba(156, 39, 176, 0.2); border: 2px solid rgba(255, 215, 0, 0.3);">
                <div class="badge-header">
                    <span class="badge-icon">🔨</span>
                    <h3 class="badge-name">3️⃣ CONSTRUIRE</h3>
                </div>
                <p style="opacity: 0.95; line-height: 1.8;">
                    Transformer cette intention en actions tangibles : micro-expérimentations, projets pilotes, alliances nouvelles. Construire, c'est donner corps au désir. <strong>Pas un plan d'action figé, mais un cadre d'expérimentation lucide.</strong>
                </p>
            </div>

            <div class="badge-card fade-in-up" style="background: rgba(156, 39, 176, 0.2); border: 2px solid rgba(255, 215, 0, 0.3);">
                <div class="badge-header">
                    <span class="badge-icon">🔄</span>
                    <h3 class="badge-name">4️⃣ TRANSFORMER</h3>
                </div>
                <p style="opacity: 0.95; line-height: 1.8;">
                    Installer une cadence vivante : apprendre, ajuster, décider. C'est ici que la stratégie devient un mouvement collectif et non un document figé. <strong>La transformation n'est pas un événement, c'est un rythme à vivre.</strong>
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Section Bénéfices -->
<section id="benefices" style="padding: 100px 0;">
    <div class="container">
        <div class="section-subtitle">LES BÉNÉFICES</div>
        <h2 class="section-title">Ce Que Vous Allez Transformer</h2>
        <p class="section-description">
            La formation Manager Facilitateur ne vous apprend pas seulement des techniques. Elle transforme votre posture, votre impact et les résultats de votre équipe.
        </p>

        <div class="why-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 35px; margin-top: 60px;">
            <div class="why-card fade-in-up">
                <span class="why-icon">📈</span>
                <h3 class="why-title">Performance Durable</h3>
                <p class="why-description">
                    Vos équipes deviennent plus performantes sur le long terme car elles sont engagées, autonomes et créatives. Les résultats ne reposent plus uniquement sur vous.
                </p>
            </div>

            <div class="why-card fade-in-up">
                <span class="why-icon">🔥</span>
                <h3 class="why-title">Engagement Renforcé</h3>
                <p class="why-description">
                    Quand les collaborateurs participent aux décisions et co-construisent les solutions, leur engagement explose. Ils deviennent acteurs, pas exécutants.
                </p>
            </div>

            <div class="why-card fade-in-up">
                <span class="why-icon">💡</span>
                <h3 class="why-title">Innovation et Créativité</h3>
                <p class="why-description">
                    En libérant l'intelligence collective, vous accédez à une source infinie d'idées et de solutions que vous n'auriez jamais trouvées seul·e.
                </p>
            </div>

            <div class="why-card fade-in-up">
                <span class="why-icon">🌟</span>
                <h3 class="why-title">Leadership Reconnu</h3>
                <p class="why-description">
                    Vous devenez le manager que tout le monde veut avoir. Votre réputation et votre impact grandissent dans l'organisation.
                </p>
            </div>

            <div class="why-card fade-in-up">
                <span class="why-icon">😌</span>
                <h3 class="why-title">Moins de Stress, Plus de Sens</h3>
                <p class="why-description">
                    Lâchez le contrôle, gagnez en sérénité. Vous n'êtes plus seul·e à porter la charge. Votre rôle devient plus gratifiant et moins épuisant.
                </p>
            </div>

            <div class="why-card fade-in-up">
                <span class="why-icon">🎯</span>
                <h3 class="why-title">Compétences Concrètes</h3>
                <p class="why-description">
                    Vous repartez avec 30+ outils et techniques immédiatement applicables dans votre quotidien managérial. Pas que de la théorie, de l'action.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Programme détaillé -->
<section id="programme" class="badges-section" style="padding: 100px 0;">
    <div class="container">
        <div class="section-subtitle" style="color: var(--game-gold);">LE PARCOURS</div>
        <h2 class="section-title" style="color: var(--light);">Programme Détaillé sur 3 Jours + Consolidation (J+45)</h2>

        <div style="max-width: 850px; margin: 0 auto 60px; text-align: center;">
            <p style="font-size: 1.2rem; line-height: 1.8; color: rgba(255,255,255,0.9);">
                La formation suit la démarche <strong>Voir, Désirer, Construire, Transformer</strong> d'Insuffle Académie.
                Une approche <strong>Tête-Corps-Cœur</strong> avec <strong>70% de pratique</strong> et 30% de théorie.
            </p>
        </div>

        <!-- JOUR 1 -->
        <div class="badge-card fade-in-up" style="margin-bottom: 40px;">
            <div class="badge-header">
                <span class="badge-icon">👁️</span>
                <h3 class="badge-name">JOUR 1 : VOIR (9h-18h)</h3>
            </div>
            <p style="font-weight: 600; color: var(--game-gold); margin-bottom: 20px; font-size: 1.1rem;">"Observer le réel sans filtre"</p>

            <ul class="badge-skills">
                <li><strong>9h00 - 9h45 | Ouverture immersive :</strong> "La Réunion d'Enfer" - Vivez la pire réunion possible (jeu de rôle), débriefing, ice breaker, constitution des triades de co-développement</li>
                <li><strong>9h45 - 12h30 | Observer son management actuel :</strong> Auto-évaluation profil manager, cartographie forces/axes de développement, évolution du management (contrôleur → facilitateur), atelier "Croyances Limitantes vs Portantes", radiographie de mon équipe</li>
                <li><strong>14h00 - 17h30 | Introduction Boussole 4C :</strong> Comprendre les 4 axes (Cap, Contraintes, Capacités, Cadence), mapping de son équipe selon la Boussole, identifier tensions et zones d'ombre, partage en triades</li>
            </ul>
        </div>

        <!-- JOUR 2 -->
        <div class="badge-card fade-in-up" style="margin-bottom: 40px;">
            <div class="badge-header">
                <span class="badge-icon">✨</span>
                <h3 class="badge-name">JOUR 2 : DÉSIRER & CONSTRUIRE (9h-18h)</h3>
            </div>
            <p style="font-weight: 600; color: var(--game-gold); margin-bottom: 20px; font-size: 1.1rem;">"Formuler le cap et concevoir les leviers"</p>

            <ul class="badge-skills">
                <li><strong>9h00 - 10h30 | DÉSIRER - Formuler la phrase-boussole :</strong> Atelier "Dans 1 An, Mon Équipe au Top" (projection guidée), écriture créative du futur désiré, concept de Futur Désiré, formuler son cap managérial clair et désirable</li>
                <li><strong>10h45 - 12h30 | CAP - Donner la direction :</strong> Définir et communiquer une intention claire, transformer objectifs en cap inspirant, communiquer une direction claire en 3 minutes, feedback croisé en triade</li>
                <li><strong>14h00 - 15h30 | CONSTRUIRE - Les outils de facilitation :</strong> Les 3 modes de décision collective, démonstration live d'animation collaborative, 10 formats collaboratifs (World Café, 1-2-4-All...), pratique intense : chaque participant anime 10 min</li>
                <li><strong>15h45 - 17h30 | CAPACITÉS & CONTRAINTES :</strong> Identifier les leviers concrets de mon équipe, définir les lignes rouges (contraintes non négociables), le Questionnement Puissant, Matrice de Délégation Responsabilisante</li>
            </ul>
        </div>

        <!-- JOUR 3 -->
        <div class="badge-card fade-in-up" style="margin-bottom: 40px;">
            <div class="badge-header">
                <span class="badge-icon">🔄</span>
                <h3 class="badge-name">JOUR 3 : TRANSFORMER (9h-18h)</h3>
            </div>
            <p style="font-weight: 600; color: var(--game-gold); margin-bottom: 20px; font-size: 1.1rem;">"Installer une cadence vivante"</p>

            <ul class="badge-skills">
                <li><strong>9h00 - 10h30 | CADENCE - Trouver le rythme juste :</strong> À quel rythme décidons-nous ?, installer une respiration collective (rythmes de réunions, décisions, expérimentations), définir ma cadence managériale, Plan de Transformation 90 Jours</li>
                <li><strong>10h45 - 12h30 | Simulations Intensives :</strong> Chaque participant facilite une réunion complète (30 min) sur scénarios réalistes, le groupe joue l'équipe (avec résistances !), feedback à 360° (pairs + formateur), vidéo pour auto-analyse</li>
                <li><strong>14h00 - 15h30 | Gérer les Situations Difficiles :</strong> Les 7 Pièges du Manager Facilitateur, gestion des résistances et objections (jeux de rôle), techniques de régulation des dynamiques de groupe, co-développement en triades</li>
                <li><strong>15h45 - 17h30 | Clôture & Engagement :</strong> Rituel "Ce que j'ai transformé en moi", Contrat d'Expérimentation (mes 3 premiers ateliers à animer), Triades d'Accountability, Remise du Kit Manager Facilitateur, célébration</li>
            </ul>
        </div>

        <!-- JOUR +45 -->
        <div class="badge-card fade-in-up" style="border: 3px solid var(--game-gold);">
            <div class="badge-header">
                <span class="badge-icon">🔵</span>
                <h3 class="badge-name">JOUR +45 : CONSOLIDATION (9h-17h)</h3>
            </div>
            <p style="font-weight: 600; color: var(--game-gold); margin-bottom: 20px; font-size: 1.1rem;">"Ancrer durablement la transformation"</p>

            <ul class="badge-skills">
                <li><strong>9h00 - 12h00 | Retours d'Expérience Terrain :</strong> Tour de table "Ce qui a marché, ce qui a coincé", partage des expérimentations réalisées, atelier de Co-développement (3 managers présentent une problématique), ajustements et approfondissements sur mesure</li>
                <li><strong>14h00 - 17h00 | Consolidation Long Terme :</strong> Masterclass (approfondissement d'un axe de la Boussole 4C au choix), Plan d'Action 6 Mois, stratégie pour essaimer les pratiques dans l'organisation, rituel de clôture "Ma nouvelle identité managériale"</li>
            </ul>
        </div>

        <div style="text-align: center; margin-top: 60px; padding: 40px; background: rgba(255,255,255,0.1); border-radius: 20px; backdrop-filter: blur(10px);">
            <h3 style="font-size: 2rem; color: var(--game-gold); margin-bottom: 20px;">🎁 CE QUI EST INCLUS</h3>
            <div style="text-align: left; max-width: 700px; margin: 0 auto;">
                <ul class="badge-skills" style="font-size: 1.05rem;">
                    <li>4 jours de formation (3j + J+45) avec formateurs experts Insuffle</li>
                    <li>Kit Manager Facilitateur complet (carnet + 30 cartes-outils)</li>
                    <li>Certificat Manager Facilitateur officiel</li>
                    <li>Accès Communauté des Managers Facilitateurs</li>
                    <li>Co-développement mensuel gratuit post-formation</li>
                    <li>Ressources digitales actualisées en continu</li>
                    <li>Support formateurs pendant 6 mois</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- CTA Final -->
<section id="contact" class="final-cta-section">
    <div class="container">
        <div class="final-cta-content">
            <h2 class="final-cta-title">
                Prêt·e à Devenir<br>Manager Facilitateur ?
            </h2>
            <p class="final-cta-description">
                La formation revient en 2026 avec Insuffle Académie.<br>
                Rejoignez la liste d'attente pour être informé·e en priorité et bénéficier d'un accès anticipé.
            </p>

            <!-- Formulaire de contact iframe -->
            <div style="width: 100%; max-width: 100%; margin: 40px auto;">
                <iframe
                    src="https://www.insuffle-academie.com/widget.php"
                    style="width: 100%; height: 800px; border: none; border-radius: 20px; box-shadow: 0 10px 40px rgba(0,0,0,0.3);"
                    title="Formulaire de contact Manager Facilitateur"
                    loading="lazy"
                ></iframe>
            </div>

            <div style="margin-top: 50px; padding: 30px; background: rgba(255,255,255,0.1); border-radius: 20px; backdrop-filter: blur(10px);">
                <h4 style="font-size: 1.3rem; margin-bottom: 20px; color: var(--game-gold);">📞 Nous Contacter</h4>
                <p style="font-size: 1.1rem; margin-bottom: 10px;">
                    <strong>Email :</strong> contact@insuffle-academie.com
                </p>
                <p style="font-size: 1.1rem; margin-bottom: 10px;">
                    <strong>Téléphone :</strong> +33 9 80 80 89 62
                </p>
                <p style="font-size: 1.1rem;">
                    <strong>Adresse :</strong> 410 RUE DE LA PRINCESSE TROUBETSKOI, 14800 Deauville
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer>
    <div class="container">
        <div class="footer-content">
            <div class="footer-section">
                <h3>🧭 MANAGER FACILITATEUR</h3>
                <p style="opacity: 0.8; line-height: 1.8;">
                    La formation qui transforme les managers en leaders facilitateurs. Par Insuffle Académie, experts en intelligence collective et leadership transformationnel.
                </p>
            </div>

            <div class="footer-section">
                <h3>Insuffle Académie</h3>
                <p style="opacity: 0.8; line-height: 1.8;">
                    Formations en facilitation, intelligence collective et leadership. Nous formons les professionnels qui veulent transformer leur façon de travailler.
                </p>
            </div>

            <div class="footer-section">
                <h3>Nos Autres Formations</h3>
                <p style="opacity: 0.8; line-height: 1.8;">
                    🎮 FACILIT'ACADEMY - Formation Facilitateur<br>
                    ⚡ Électrochoc & Réanimation<br>
                    🏗️ Architecte du Futur Désiré
                </p>
            </div>
        </div>

        <div class="footer-bottom">
            <p>© <?php echo date('Y'); ?> Insuffle Académie - Tous droits réservés</p>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>

</body>
</html>
