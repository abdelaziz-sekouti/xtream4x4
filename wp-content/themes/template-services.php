<?php
/**
 * Services page template
 */

get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
        
        <?php xtreme_display_hero_section(); ?>
        
        <section class="services-section">
            <div class="section-title">
                <h2>Nos Services</h2>
                <p>Spécialistes en réparation et entretien 4x4 à Tanger</p>
            </div>
            
            <div class="services-grid">
                <?php
                $services = xtreme_get_services();
                foreach ($services as $service):
                    ?>
                    <div class="service-card">
                        <div class="service-icon">⚙️</div>
                        <h3><?php echo esc_html($service['title']); ?></h3>
                        <p><?php echo esc_html($service['description']); ?></p>
                        <div class="service-price"><?php echo esc_html($service['price']); ?></div>
                        <div class="service-duration"><?php echo esc_html($service['duration']); ?></div>
                        <a href="#<?php echo esc_attr($service['id']); ?>" class="learn-more">En savoir plus</a>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
        
        <section class="services-details">
            <div class="container">
                <?php
                $services = xtreme_get_services();
                foreach ($services as $service):
                    ?>
                    <div id="<?php echo esc_attr($service['id']); ?>" class="service-details">
                        <h3><?php echo esc_html($service['title']); ?></h3>
                        <p><?php echo esc_html($service['description']); ?></p>
                        <p><strong>Prix:</strong> <?php echo esc_html($service['price']); ?></p>
                        <p><strong>Durée:</strong> <?php echo esc_html($service['duration']); ?></p>
                        <a href="#" class="book-service">Réserver ce service</a>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
        
    </main>
</div>

<?php get_footer(); ?>