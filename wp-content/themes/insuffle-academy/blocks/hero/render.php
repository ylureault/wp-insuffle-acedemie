<?php
/**
 * Hero Block - Server-side Render
 *
 * @package Insuffle_Academy
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Extract attributes
$emoji                = isset( $attributes['emoji'] ) ? esc_html( $attributes['emoji'] ) : '🎮';
$badge                = isset( $attributes['badge'] ) ? esc_html( $attributes['badge'] ) : '';
$title                = isset( $attributes['title'] ) ? esc_html( $attributes['title'] ) : '';
$subtitle             = isset( $attributes['subtitle'] ) ? esc_html( $attributes['subtitle'] ) : '';
$description          = isset( $attributes['description'] ) ? esc_html( $attributes['description'] ) : '';
$primary_button_text  = isset( $attributes['primaryButtonText'] ) ? esc_html( $attributes['primaryButtonText'] ) : '';
$primary_button_url   = isset( $attributes['primaryButtonUrl'] ) ? esc_url( $attributes['primaryButtonUrl'] ) : '#';
$secondary_button_text = isset( $attributes['secondaryButtonText'] ) ? esc_html( $attributes['secondaryButtonText'] ) : '';
$secondary_button_url  = isset( $attributes['secondaryButtonUrl'] ) ? esc_url( $attributes['secondaryButtonUrl'] ) : '#';
$show_stats           = isset( $attributes['showStats'] ) ? $attributes['showStats'] : true;

$wrapper_attributes = get_block_wrapper_attributes( array( 'class' => 'hero' ) );
?>

<section <?php echo $wrapper_attributes; ?>>
    <div class="container">
        <div class="hero-content">
            <?php if ( ! empty( $badge ) ) : ?>
                <div class="hero-badge"><?php echo $badge; ?></div>
            <?php endif; ?>

            <?php if ( ! empty( $emoji ) ) : ?>
                <span class="hero-emoji"><?php echo $emoji; ?></span>
            <?php endif; ?>

            <?php if ( ! empty( $title ) ) : ?>
                <h1><?php echo nl2br( $title ); ?></h1>
            <?php endif; ?>

            <?php if ( ! empty( $subtitle ) ) : ?>
                <p class="hero-subtitle"><?php echo $subtitle; ?></p>
            <?php endif; ?>

            <?php if ( ! empty( $description ) ) : ?>
                <p class="hero-description"><?php echo $description; ?></p>
            <?php endif; ?>

            <?php if ( ! empty( $primary_button_text ) || ! empty( $secondary_button_text ) ) : ?>
                <div class="hero-cta-group">
                    <?php if ( ! empty( $primary_button_text ) ) : ?>
                        <a href="<?php echo $primary_button_url; ?>" class="btn btn-primary">
                            <?php echo $primary_button_text; ?>
                        </a>
                    <?php endif; ?>

                    <?php if ( ! empty( $secondary_button_text ) ) : ?>
                        <a href="<?php echo $secondary_button_url; ?>" class="btn btn-secondary">
                            <?php echo $secondary_button_text; ?>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <?php if ( $show_stats ) : ?>
                <div class="hero-stats">
                    <div class="stat">
                        <span class="stat-number">96%</span>
                        <span class="stat-label"><?php esc_html_e( 'Satisfaction', 'insuffle-academy' ); ?></span>
                    </div>
                    <div class="stat">
                        <span class="stat-number">6</span>
                        <span class="stat-label"><?php esc_html_e( 'Badges Légendaires', 'insuffle-academy' ); ?></span>
                    </div>
                    <div class="stat">
                        <span class="stat-number">2</span>
                        <span class="stat-label"><?php esc_html_e( 'Jours Intenses', 'insuffle-academy' ); ?></span>
                    </div>
                    <div class="stat">
                        <span class="stat-number">78%</span>
                        <span class="stat-label"><?php esc_html_e( 'Animent dès le mois suivant', 'insuffle-academy' ); ?></span>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
