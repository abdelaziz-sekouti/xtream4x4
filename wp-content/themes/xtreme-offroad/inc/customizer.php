<?php
/**
 * Customizer settings for Xtreme theme
 *
 * @package WordPress
 * @subpackage Xtreme_Offroad
 * @since 1.0.0
 */

function xtreme_customize_register($wp_customize) {
    // Site identity section
    $wp_customize->add_section('xtreme_site_identity', array(
        'title' => __('Identité du site', 'xtreme'),
        'priority' => 30,
    ));
    
    // Logo
    $wp_customize->add_setting('custom_logo', array(
        'default' => '',
        'transport' => 'refresh',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'custom_logo', array(
        'label' => __('Logo', 'xtreme'),
        'section' => 'xtreme_site_identity',
        'settings' => 'custom_logo',
    )));
    
    // Tagline
    $wp_customize->add_setting('xtreme_tagline', array(
        'default' => 'Spécialiste en réparation et entretien 4x4 à Tanger',
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('xtreme_tagline', array(
        'label' => __('Slogan du site', 'xtreme'),
        'section' => 'xtreme_site_identity',
        'type' => 'text',
    ));
    
    // Colors section
    $wp_customize->add_section('xtreme_colors', array(
        'title' => __('Couleurs du thème', 'xtreme'),
        'priority' => 35,
    ));
    
    // Primary color
    $wp_customize->add_setting('xtreme_primary_color', array(
        'default' => '#2c3e50',
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'xtreme_primary_color', array(
        'label' => __('Couleur principale', 'xtreme'),
        'section' => 'xtreme_colors',
        'settings' => 'xtreme_primary_color',
    )));
    
    // Secondary color
    $wp_customize->add_setting('xtreme_secondary_color', array(
        'default' => '#e67e22',
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'xtreme_secondary_color', array(
        'label' => __('Couleur secondaire', 'xtreme'),
        'section' => 'xtreme_colors',
        'settings' => 'xtreme_secondary_color',
    )));
    
    // Accent color
    $wp_customize->add_setting('xtreme_accent_color', array(
        'default' => '#3498db',
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'xtreme_accent_color', array(
        'label' => __('Couleur d\'accent', 'xtreme'),
        'section' => 'xtreme_colors',
        'settings' => 'xtreme_accent_color',
    )));
    
    // Contact information section
    $wp_customize->add_section('xtreme_contact_info', array(
        'title' => __('Informations de contact', 'xtreme'),
        'priority' => 40,
    ));
    
    // Phone number
    $wp_customize->add_setting('xtreme_phone', array(
        'default' => '06 61 72 06 63',
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('xtreme_phone', array(
        'label' => __('Numéro de téléphone', 'xtreme'),
        'section' => 'xtreme_contact_info',
        'type' => 'text',
    ));
    
    // Address
    $wp_customize->add_setting('xtreme_address', array(
        'default' => '47 Av. Yakoub El Mansour, al mansour, Tanger 90000',
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('xtreme_address', array(
        'label' => __('Adresse', 'xtreme'),
        'section' => 'xtreme_contact_info',
        'type' => 'text',
    ));
    
    // Email
    $wp_customize->add_setting('xtreme_email', array(
        'default' => 'info@xtremeoffroad4x4-tanger.com',
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_email',
    ));
    
    $wp_customize->add_control('xtreme_email', array(
        'label' => __('Email', 'xtreme'),
        'section' => 'xtreme_contact_info',
        'type' => 'email',
    ));
    
    // Instagram URL
    $wp_customize->add_setting('xtreme_instagram', array(
        'default' => 'https://instagram.com',
        'transport' => 'refresh',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control('xtreme_instagram', array(
        'label' => __('Instagram URL', 'xtreme'),
        'section' => 'xtreme_contact_info',
        'type' => 'url',
    ));
    
    // Business hours section
    $wp_customize->add_section('xtreme_business_hours', array(
        'title' => __('Horaires d\'ouverture', 'xtreme'),
        'priority' => 45,
    ));
    
    // Business hours
    $days = array('monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday');
    
    foreach ($days as $day) {
        $wp_customize->add_setting("xtreme_hours_$day", array(
            'default' => '',
            'transport' => 'refresh',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        
        $wp_customize->add_control("xtreme_hours_$day", array(
            'label' => ucfirst($day),
            'section' => 'xtreme_business_hours',
            'type' => 'text',
        ));
    }
    
    // Hero section section
    $wp_customize->add_section('xtreme_hero_section', array(
        'title' => __('Section héros', 'xtreme'),
        'priority' => 50,
    ));
    
    // Hero background image
    $wp_customize->add_setting('xtreme_hero_bg', array(
        'default' => '',
        'transport' => 'refresh',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'xtreme_hero_bg', array(
        'label' => __('Image de fond', 'xtreme'),
        'section' => 'xtreme_hero_section',
        'settings' => 'xtreme_hero_bg',
    )));
    
    // Hero title
    $wp_customize->add_setting('xtreme_hero_title', array(
        'default' => 'Xtreme Off-Road 4x4 Tanger',
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('xtreme_hero_title', array(
        'label' => __('Titre principal', 'xtreme'),
        'section' => 'xtreme_hero_section',
        'type' => 'text',
    ));
    
    // Hero subtitle
    $wp_customize->add_setting('xtreme_hero_subtitle', array(
        'default' => 'Spécialiste en réparation et entretien 4x4 à Tanger',
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('xtreme_hero_subtitle', array(
        'label' => __('Sous-titre', 'xtreme'),
        'section' => 'xtreme_hero_section',
        'type' => 'text',
    ));
    
    // Social links section
    $wp_customize->add_section('xtreme_social_links', array(
        'title' => __('Liens sociaux', 'xtreme'),
        'priority' => 55,
    ));
    
    // Facebook URL
    $wp_customize->add_setting('xtreme_facebook', array(
        'default' => '#',
        'transport' => 'refresh',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control('xtreme_facebook', array(
        'label' => __('Facebook URL', 'xtreme'),
        'section' => 'xtreme_social_links',
        'type' => 'url',
    ));
    
    // Twitter URL
    $wp_customize->add_setting('xtreme_twitter', array(
        'default' => '#',
        'transport' => 'refresh',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control('xtreme_twitter', array(
        'label' => __('Twitter URL', 'xtreme'),
        'section' => 'xtreme_social_links',
        'type' => 'url',
    ));
    
    // Google Maps URL
    $wp_customize->add_setting('xtreme_google_maps', array(
        'default' => '#',
        'transport' => 'refresh',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control('xtreme_google_maps', array(
        'label' => __('Google Maps URL', 'xtreme'),
        'section' => 'xtreme_social_links',
        'type' => 'url',
    ));
}

add_action('customize_register', 'xtreme_customize_register');

/**
 * Generate CSS from customizer settings
 */
function xtreme_customizer_css() {
    ?>
    <style>
        :root {
            --primary-color: <?php echo get_theme_mod('xtreme_primary_color', '#2c3e50'); ?>;
            --secondary-color: <?php echo get_theme_mod('xtreme_secondary_color', '#e67e22'); ?>;
            --accent-color: <?php echo get_theme_mod('xtreme_accent_color', '#3498db'); ?>;
        }
        
        .site-header {
            background-color: var(--primary-color);
        }
        
        .nav-menu a:hover {
            color: var(--secondary-color);
        }
        
        .hero-content h1 {
            color: var(--primary-color);
        }
        
        .cta-button {
            background-color: var(--secondary-color);
        }
        
        .cta-button:hover {
            background-color: <?php echo get_theme_mod('xtreme_secondary_color', '#e67e22'); ?>;
        }
        
        .service-card .learn-more {
            background-color: var(--accent-color);
        }
        
        .service-card .learn-more:hover {
            background-color: <?php echo get_theme_mod('xtreme_accent_color', '#3498db'); ?>;
        }
        
        .contact-form button {
            background-color: var(--secondary-color);
        }
        
        .contact-form button:hover {
            background-color: <?php echo get_theme_mod('xtreme_secondary_color', '#e67e22'); ?>;
        }
        
        .footer-business-info h3 {
            color: var(--accent-color);
        }
        
        .footer-menu a:hover {
            color: var(--accent-color);
        }
    </style>
    <?php
}

add_action('wp_head', 'xtreme_customizer_css');