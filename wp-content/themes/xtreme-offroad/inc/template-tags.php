<?php
/**
 * Custom template tags for Xtreme theme
 *
 * @package WordPress
 * @subpackage Xtreme_Offroad
 * @since 1.0.0
 */

if (!function_exists('xtreme_posted_on')) :
    /**
     * Prints HTML with meta information for the current post-date/time.
     */
    function xtreme_posted_on() {
        $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
        if (get_the_time('U') !== get_the_modified_time('U')) {
            $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
        }

        $time_string = sprintf(
            $time_string,
            esc_attr(get_the_date(DATE_W3C)),
            esc_html(get_the_date()),
            esc_attr(get_the_modified_date(DATE_W3C)),
            esc_html(get_the_modified_date())
        );

        printf(
            '<span class="posted-on">%1$s<a href="%2$s" rel="bookmark">%3$s</a></span>',
            xtreme_time_link(),
            esc_url(get_permalink()),
            $time_string
        );
    }
endif;

if (!function_exists('xtreme_time_link')) :
    /**
     * Gets a nicely formatted string for the published date.
     */
    function xtreme_time_link() {
        $time_string = '<a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date published updated" datetime="%3$s">%4$s</time></a>';

        $time_string = sprintf(
            $time_string,
            esc_url(get_permalink()),
            get_the_time(),
            esc_attr(get_the_date(DATE_W3C)),
            esc_html(get_the_date())
        );

        return $time_string;
    }
endif;

if (!function_exists('xtreme_posted_by')) :
    /**
     * Prints HTML with meta information about theme author.
     */
    function xtreme_posted_by() {
        printf(
            '<span class="byline"><span class="author vcard"><span class="screen-reader-text">%1$s</span><a class="url fn n" href="%2$s">%3$s</a></span></span>',
            _x('Author', 'Used before post author name.', 'xtreme'),
            esc_url(get_author_posts_url(get_the_author_meta('ID'))),
            esc_html(get_the_author())
        );
    }
endif;

if (!function_exists('xtreme_entry_footer')) :
    /**
     * Prints HTML with meta information for the categories, tags and comments.
     */
    function xtreme_entry_footer() {
        // Hide category and tag text for pages.
        if ('post' === get_post_type()) {
            /* translators: used between list items, there is a space after the comma */
            $categories_list = get_the_category_list(__(', ', 'xtreme'));
            if ($categories_list) {
                printf('<span class="cat-links">%1$s<span class="screen-reader-text">%2$s</span>%3$s</span>', 
                    xtreme_icon_svg('archive', 16),
                    _x('Categories', 'Used before category names.', 'xtreme'),
                    $categories_list
                );
            }

            /* translators: used between list items, there is a space after the comma */
            $tags_list = get_the_tag_list('', __(', ', 'xtreme'));
            if ($tags_list) {
                printf('<span class="tags-links">%1$s<span class="screen-reader-text">%2$s</span>%3$s</span>', 
                    xtreme_icon_svg('tag', 16),
                    _x('Tags', 'Used before tag names.', 'xtreme'),
                    $tags_list
                );
            }
        }

        if (!is_single() && !post_password_required() && (comments_open() || get_comments_number())) {
            echo '<span class="comments-link">';
            comments_popup_link(
                sprintf(
                    /* translators: %s: post title */
                    __('Leave a comment<span class="screen-reader-text"> on %s</span>', 'xtreme'),
                    get_the_title()
                )
            );
            echo '</span>';
        }

        edit_post_link(
            sprintf(
                /* translators: %s: Name of current post */
                __('Edit<span class="screen-reader-text"> "%s"</span>', 'xtreme'),
                get_the_title()
            ),
            '<span class="edit-link">',
            '</span>'
        );
    }
endif;

/**
 * Returns an SVG icon.
 */
function xtreme_icon_svg($icon, $size = 24) {
    return '<svg class="icon icon-' . esc_attr($icon) . '" width="' . esc_attr($size) . '" height="' . esc_attr($size) . '" aria-hidden="true" role="img"> <use href="#icon-' . esc_attr($icon) . '"></use> </svg>';
}

/**
 * Get the site title
 */
function xtreme_get_site_title() {
    return get_bloginfo('name');
}

/**
 * Get the site tagline
 */
function xtreme_get_site_tagline() {
    return get_bloginfo('description');
}

/**
 * Get the phone number
 */
function xtreme_get_phone_number() {
    return '06 61 72 06 63';
}

/**
 * Get the business address
 */
function xtreme_get_address() {
    return '47 Av. Yakoub El Mansour, al mansour, Tanger 90000';
}

/**
 * Get the Instagram URL
 */
function xtreme_get_instagram_url() {
    return 'https://instagram.com';
}

/**
 * Get business hours
 */
function xtreme_get_business_hours() {
    return array(
        'Wednesday' => '10:00 - 18:00',
        'Thursday' => '10:00 - 18:00',
        'Friday' => '10:00 - 18:00',
        'Saturday' => '10:00 - 16:00',
        'Sunday' => 'Closed'
    );
}

/**
 * Display the hero section
 */
function xtreme_display_hero_section() {
    ?>
    <section class="hero-section">
        <div class="hero-content">
            <h1><?php echo esc_html(xtreme_get_site_title()); ?></h1>
            <p class="tagline"><?php echo esc_html(xtreme_get_site_tagline()); ?></p>
            <a href="#contact" class="cta-button">Contactez-nous</a>
        </div>
    </section>
    <?php
}

/**
 * Display services section
 */
function xtreme_display_services_section() {
    $services = array(
        array(
            'title' => 'Réparation 4x4',
            'icon' => '⚙️',
            'description' => 'Expertise en réparation et entretien de véhicules 4x4 avec des mécaniciens qualifiés.',
            'link' => '#reparation'
        ),
        array(
            'title' => 'Entretien Préventif',
            'icon' => '🔧',
            'description' => 'Entretien régulier pour garantir la performance et la longévité de votre véhicule.',
            'link' => '#entretien'
        ),
        array(
            'title' => 'Diagnostic',
            'icon' => '🔍',
            'description' => 'Diagnostic avancé pour identifier et résoudre les problèmes techniques.',
            'link' => '#diagnostic'
        ),
        array(
            'title' => 'Pièces Détachées',
            'icon' => '🛠️',
            'description' => 'Pièces détachées originales et de qualité pour tous types de 4x4.',
            'link' => '#pieces'
        )
    );
    
    ?>
    <section class="services-section">
        <div class="section-title">
            <h2>Nos Services</h2>
            <p>Spécialistes en réparation et entretien 4x4 à Tanger</p>
        </div>
        <div class="services-grid">
            <?php foreach ($services as $service): ?>
                <div class="service-card">
                    <div class="service-icon"><?php echo esc_html($service['icon']); ?></div>
                    <h3><?php echo esc_html($service['title']); ?></h3>
                    <p><?php echo esc_html($service['description']); ?></p>
                    <a href="<?php echo esc_url($service['link']); ?>" class="learn-more">En savoir plus</a>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
    <?php
}

/**
 * Display reviews section
 */
function xtreme_display_reviews_section() {
    $reviews = array(
        array(
            'name' => 'Fayçal Touhami',
            'rating' => 5,
            'text' => 'Ils sont pros en conduite 4x4, bien fait! 👏👏👏👏',
            'date' => 'Il y a 4 mois',
            'avatar' => '/images/avatar1.jpg'
        ),
        array(
            'name' => 'Aya Rahmani',
            'rating' => 5,
            'text' => 'Excellent travail, 👍🏻👍🏻👍🏻',
            'date' => 'Il y a 3 mois',
            'avatar' => '/images/avatar2.jpg'
        )
    );
    
    ?>
    <section class="reviews-section">
        <div class="section-title">
            <h2>Avis Clients</h2>
            <p>Notre satisfaction client est notre priorité</p>
        </div>
        <div class="rating-summary">
            <div class="rating-number">5.0</div>
            <div class="rating-stars">★★★★★</div>
            <div class="rating-count">(2 avis)</div>
        </div>
        <div class="reviews-grid">
            <?php foreach ($reviews as $review): ?>
                <div class="review-card">
                    <div class="review-header">
                        <img src="<?php echo esc_url($review['avatar']); ?>" alt="<?php echo esc_attr($review['name']); ?>" class="review-avatar">
                        <div class="review-info">
                            <h4><?php echo esc_html($review['name']); ?></h4>
                            <div class="rating">
                                <?php 
                                for ($i = 1; $i <= $review['rating']; $i++) {
                                    echo '★';
                                }
                                ?>
                            </div>
                            <small><?php echo esc_html($review['date']); ?></small>
                        </div>
                    </div>
                    <div class="review-text">
                        <?php echo esc_html($review['text']); ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
    <?php
}

/**
 * Display contact section
 */
function xtreme_display_contact_section() {
    $hours = xtreme_get_business_hours();
    
    ?>
    <section class="contact-section">
        <div class="contact-container">
            <div class="contact-info">
                <h3>Contactez-nous</h3>
                <p class="address"><?php echo esc_html(xtreme_get_address()); ?></p>
                <p class="phone"><?php echo esc_html(xtreme_get_phone_number()); ?></p>
                <p class="email">info@xtremeoffroad4x4-tanger.com</p>
                
                <h4>Horaires d'ouverture</h4>
                <ul class="hours-list">
                    <?php foreach ($hours as $day => $time): ?>
                        <li><?php echo esc_html($day); ?>: <?php echo esc_html($time); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            
            <form class="contact-form" action="#" method="POST">
                <h3>Envoyez un message</h3>
                <input type="text" name="name" placeholder="Votre nom" required>
                <input type="email" name="email" placeholder="Votre email" required>
                <input type="tel" name="phone" placeholder="Votre téléphone">
                <textarea name="message" placeholder="Votre message" rows="5" required></textarea>
                <button type="submit">Envoyer</button>
            </form>
        </div>
    </section>
    <?php
}

/**
 * Get all services
 */
function xtreme_get_services() {
    $services = array(
        array(
            'id' => 1,
            'title' => 'Réparation Moteur 4x4',
            'description' => 'Réparation complète du moteur, diagnostic électronique, remplacement de pièces usées.',
            'price' => 'À partir de 1500 DH',
            'duration' => '1-3 jours',
            'image' => '/images/engine-repair.jpg'
        ),
        array(
            'id' => 2,
            'title' => 'Entretien Complet',
            'description' => 'Entretien préventif complet, changement d\'huile, filtres, freins, suspension.',
            'price' => 'À partir de 800 DH',
            'duration' => '1 journée',
            'image' => '/images/full-maintenance.jpg'
        ),
        array(
            'id' => 3,
            'title' => 'Diagnostic Électronique',
            'description' => 'Diagnostic avancé avec outils professionnels, identification des pannes.',
            'price' => '500 DH',
            'duration' => '2-3 heures',
            'image' => '/images/diagnostic.jpg'
        ),
        array(
            'id' => 4,
            'title' => 'Installation Accessoires',
            'description' => 'Installation de barres de toit, winches, phares LED, pare-chocs renforcés.',
            'price' => 'À partir de 300 DH',
            'duration' => '3-6 heures',
            'image' => '/images/accessories.jpg'
        )
    );
    
    return $services;
}

/**
 * Display the homepage content
 */
function xtreme_display_homepage() {
    xtreme_display_hero_section();
    xtreme_display_services_section();
    xtreme_display_reviews_section();
    xtreme_display_contact_section();
}