<?php
/**
 * Shortcodes for Xtreme theme
 */

// Services list shortcode
function xtreme_services_list_shortcode($atts) {
    $atts = shortcode_atts(array(
        'category' => '',
        'limit' => -1,
        'columns' => 2,
    ), $atts);

    $args = array(
        'post_type' => 'service',
        'posts_per_page' => $atts['limit'],
        'orderby' => 'menu_order',
        'order' => 'ASC',
    );

    if ($atts['category']) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'service_category',
                'field' => 'slug',
                'terms' => $atts['category'],
            ),
        );
    }

    $services = new WP_Query($args);
    $output = '<div class="services-list shortcode-services columns-' . esc_attr($atts['columns']) . '">';
    
    if ($services->have_posts()) {
        while ($services->have_posts()) {
            $services->the_post();
            $price = get_post_meta(get_the_ID(), '_service_price', true);
            $duration = get_post_meta(get_the_ID(), '_service_duration', true);
            
            $output .= '<div class="service-item">';
            $output .= '<h3>' . get_the_title() . '</h3>';
            $output .= '<div class="service-excerpt">' . get_the_excerpt() . '</div>';
            
            if ($price || $duration) {
                $output .= '<div class="service-meta">';
                if ($price) $output .= '<span class="service-price">' . esc_html($price) . '</span>';
                if ($duration) $output .= '<span class="service-duration">' . esc_html($duration) . '</span>';
                $output .= '</div>';
            }
            
            $output .= '<a href="' . get_permalink() . '" class="btn btn-primary">En savoir plus</a>';
            $output .= '</div>';
        }
    }
    
    $output .= '</div>';
    wp_reset_postdata();
    
    return $output;
}
add_shortcode('services_list', 'xtreme_services_list_shortcode');

// Testimonials slider shortcode
function xtreme_testimonials_slider_shortcode($atts) {
    $atts = shortcode_atts(array(
        'limit' => 3,
        'autoplay' => true,
        'interval' => 5000,
    ), $atts);

    $args = array(
        'post_type' => 'testimonial',
        'posts_per_page' => $atts['limit'],
        'orderby' => 'date',
        'order' => 'DESC',
    );

    $testimonials = new WP_Query($args);
    $output = '<div class="testimonials-slider">';
    
    if ($testimonials->have_posts()) {
        $output .= '<div class="testimonials-container">';
        while ($testimonials->have_posts()) {
            $testimonials->the_post();
            $rating = get_post_meta(get_the_ID(), '_testimonial_rating', true);
            $name = get_the_title();
            $text = get_the_content();
            
            $output .= '<div class="testimonial-item">';
            $output .= '<div class="testimonial-rating">' . str_repeat('★', intval($rating)) . '</div>';
            $output .= '<div class="testimonial-text">"' . $text . '"</div>';
            $output .= '<div class="testimonial-author">' . $name . '</div>';
            $output .= '</div>';
        }
        $output .= '</div>';
        
        if ($atts['autoplay']) {
            $output .= '<div class="testimonials-controls">';
            $output .= '<button class="prev-btn">‹</button>';
            $output .= '<button class="next-btn">›</button>';
            $output .= '</div>';
        }
    }
    
    $output .= '</div>';
    wp_reset_postdata();
    
    return $output;
}
add_shortcode('testimonials_slider', 'xtreme_testimonials_slider_shortcode');

// Contact form shortcode
function xtreme_contact_form_shortcode($atts) {
    $atts = shortcode_atts(array(
        'title' => 'Contactez-nous',
        'email' => get_option('admin_email'),
        'subject' => 'Message depuis le site Xtreme Off-Road',
    ), $atts);

    ob_start();
    ?>
    <div class="contact-form-shortcode">
        <h3><?php echo esc_html($atts['title']); ?></h3>
        <form id="shortcode-contact-form" class="contact-form" action="#" method="POST">
            <div class="form-group">
                <label for="name">Votre nom</label>
                <input type="text" id="name" name="name" required>
            </div>
            
            <div class="form-group">
                <label for="email">Votre email</label>
                <input type="email" id="email" name="email" required>
            </div>
            
            <div class="form-group">
                <label for="phone">Votre téléphone</label>
                <input type="tel" id="phone" name="phone">
            </div>
            
            <div class="form-group">
                <label for="subject">Sujet</label>
                <select id="subject" name="subject" required>
                    <option value="">Choisissez un sujet</option>
                    <option value="service">Service</option>
                    <option value="devis">Devis</option>
                    <option value="urgence">Urgence</option>
                    <option value="autre">Autre</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="message">Votre message</label>
                <textarea id="message" name="message" rows="5" required></textarea>
            </div>
            
            <button type="submit" class="btn btn-primary">Envoyer</button>
        </form>
        <div class="form-message"></div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('contact_form', 'xtreme_contact_form_shortcode);

// Business hours shortcode
function xtreme_business_hours_shortcode($atts) {
    $atts = shortcode_atts(array(
        'title' => 'Horaires d\'ouverture',
        'monday' => '10:00 - 18:00',
        'tuesday' => '10:00 - 18:00',
        'wednesday' => '10:00 - 18:00',
        'thursday' => '10:00 - 18:00',
        'friday' => '10:00 - 18:00',
        'saturday' => '10:00 - 16:00',
        'sunday' => 'Fermé',
    ), $atts);

    ob_start();
    ?>
    <div class="business-hours-shortcode">
        <h3><?php echo esc_html($atts['title']); ?></h3>
        <div class="hours-grid">
            <div class="hours-item">
                <span class="day">Lundi:</span>
                <span class="time"><?php echo esc_html($atts['monday']); ?></span>
            </div>
            <div class="hours-item">
                <span class="day">Mardi:</span>
                <span class="time"><?php echo esc_html($atts['tuesday']); ?></span>
            </div>
            <div class="hours-item">
                <span class="day">Mercredi:</span>
                <span class="time"><?php echo esc_html($atts['wednesday']); ?></span>
            </div>
            <div class="hours-item">
                <span class="day">Jeudi:</span>
                <span class="time"><?php echo esc_html($atts['thursday']); ?></span>
            </div>
            <div class="hours-item">
                <span class="day">Vendredi:</span>
                <span class="time"><?php echo esc_html($atts['friday']); ?></span>
            </div>
            <div class="hours-item">
                <span class="day">Samedi:</span>
                <span class="time"><?php echo esc_html($atts['saturday']); ?></span>
            </div>
            <div class="hours-item">
                <span class="day">Dimanche:</span>
                <span class="time"><?php echo esc_html($atts['sunday']); ?></span>
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('business_hours', 'xtreme_business_hours_shortcode');

// Hero section shortcode
function xtreme_hero_section_shortcode($atts) {
    $atts = shortcode_atts(array(
        'title' => 'Xtreme Off-Road 4x4 Tanger',
        'subtitle' => 'Spécialiste en réparation et entretien 4x4 à Tanger',
        'background' => '',
        'button_text' => 'Contactez-nous',
        'button_link' => '#contact',
    ), $atts);

    ob_start();
    ?>
    <section class="hero-section-shortcode" <?php if ($atts['background']) echo 'style="background-image: url(' . esc_url($atts['background']) . ')"'; ?>>
        <div class="hero-content">
            <h1><?php echo esc_html($atts['title']); ?></h1>
            <p class="subtitle"><?php echo esc_html($atts['subtitle']); ?></p>
            <a href="<?php echo esc_url($atts['button_link']); ?>" class="btn btn-primary"><?php echo esc_html($atts['button_text']); ?></a>
        </div>
    </section>
    <?php
    return ob_get_clean();
}
add_shortcode('xtreme_hero_section', 'xtreme_hero_section_shortcode);

// Gallery shortcode
function xtreme_gallery_shortcode($atts) {
    $atts = shortcode_atts(array(
        'ids' => '',
        'columns' => 3,
        'size' => 'medium',
    ), $atts);

    if (empty($atts['ids'])) {
        return '<div class="gallery-shortcode">Aucune image spécifiée</div>';
    }

    $image_ids = explode(',', $atts['ids']);
    $output = '<div class="gallery-shortcode columns-' . esc_attr($atts['columns']) . '">';
    
    foreach ($image_ids as $id) {
        $id = intval($id);
        if ($id) {
            $output .= '<div class="gallery-item">';
            $output .= wp_get_attachment_image($id, $atts['size']);
            $output .= '</div>';
        }
    }
    
    $output .= '</div>';
    return $output;
}
add_shortcode('xtreme_gallery', 'xtreme_gallery_shortcode);

// Team members shortcode
function xtreme_team_shortcode($atts) {
    $atts = shortcode_atts(array(
        'limit' => 4,
        'columns' => 2,
    ), $atts);

    $args = array(
        'post_type' => 'team_member',
        'posts_per_page' => $atts['limit'],
        'orderby' => 'menu_order',
        'order' => 'ASC',
    );

    $team_members = new WP_Query($args);
    $output = '<div class="team-shortcode columns-' . esc_attr($atts['columns']) . '">';
    
    if ($team_members->have_posts()) {
        while ($team_members->have_posts()) {
            $team_members->the_post();
            $position = get_post_meta(get_the_ID(), '_team_position', true);
            $email = get_post_meta(get_the_ID(), '_team_email', true);
            
            $output .= '<div class="team-item">';
            $output .= '<div class="team-image">' . get_the_post_thumbnail() . '</div>';
            $output .= '<h3>' . get_the_title() . '</h3>';
            if ($position) $output .= '<div class="team-position">' . esc_html($position) . '</div>';
            if ($email) $output .= '<div class="team-email">' . esc_html($email) . '</div>';
            $output .= '</div>';
        }
    }
    
    $output .= '</div>';
    wp_reset_postdata();
    
    return $output;
}
add_shortcode('team_members', 'xtreme_team_shortcode);