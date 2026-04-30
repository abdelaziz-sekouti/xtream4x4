<?php
/**
 * Template Name: Front Page
 * Description: Template for the front page
 */

get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
        
        <?php
        // Hero Section
        if (function_exists('xtreme_display_hero_section')) {
            xtreme_display_hero_section();
        } else {
            ?>
            <section class="hero-section">
                <div class="hero-content">
                    <h1>Xtreme Off-Road 4x4 Tanger</h1>
                    <p class="tagline">Spécialiste en réparation et entretien 4x4 à Tanger</p>
                    <a href="#contact" class="cta-button">Contactez-nous</a>
                </div>
            </section>
            <?php
        }
        
        // Services Section
        if (function_exists('xtreme_display_services_section')) {
            xtreme_display_services_section();
        } else {
            ?>
            <section class="services-section">
                <div class="section-title">
                    <h2>Nos Services</h2>
                    <p>Spécialistes en réparation et entretien 4x4 à Tanger</p>
                </div>
                
                <div class="services-grid">
                    <div class="service-card">
                        <h3>Réparation 4x4</h3>
                        <p>Expertise en réparation et entretien de véhicules 4x4</p>
                        <a href="#" class="learn-more">En savoir plus</a>
                    </div>
                    <div class="service-card">
                        <h3>Entretien Préventif</h3>
                        <p>Entretien régulier pour garantir la performance</p>
                        <a href="#" class="learn-more">En savoir plus</a>
                    </div>
                </div>
            </section>
            <?php
        }
        
        // Reviews Section
        if (function_exists('xtreme_display_reviews_section')) {
            xtreme_display_reviews_section();
        }
        
        // Contact Section
        if (function_exists('xtreme_display_contact_section')) {
            xtreme_display_contact_section();
        }
        ?>
        
    </main><!-- #main -->
</div><!-- #primary -->

<?php get_footer(); ?>