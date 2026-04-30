<?php
/**
 * Services page template
 */

get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
        
        <header class="entry-header">
            <h1 class="entry-title">Nos Services</h1>
        </header>
        
        <div class="entry-content">
            <p class="section-description">Nous sommes spécialisés dans la réparation et l'entretien de véhicules 4x4 à Tanger.</p>
            
            <div class="services-grid">
                <?php
                $services = xtreme_get_services();
                foreach ($services as $service):
                    ?>
                    <div class="service-card">
                        <h3><?php echo esc_html($service['title']); ?></h3>
                        <p><?php echo esc_html($service['description']); ?></p>
                        <div class="service-meta">
                            <span class="service-price"><?php echo esc_html($service['price']); ?></span>
                            <span class="service-duration"><?php echo esc_html($service['duration']); ?></span>
                        </div>
                        <a href="#<?php echo esc_attr($service['id']); ?>" class="learn-more">En savoir plus</a>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <div class="services-details">
                <?php foreach ($services as $service): ?>
                    <div id="<?php echo esc_attr($service['id']); ?>" class="service-details">
                        <h3><?php echo esc_html($service['title']); ?></h3>
                        <p><?php echo esc_html($service['description']); ?></p>
                        <p><strong>Prix:</strong> <?php echo esc_html($service['price']); ?></p>
                        <p><strong>Durée:</strong> <?php echo esc_html($service['duration']); ?></p>
                        <a href="#" class="btn btn-primary book-service">Réserver ce service</a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        
    </main><!-- #main -->
</div><!-- #primary -->

<?php get_footer(); ?>