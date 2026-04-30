<?php
/**
 * Plugin Name: Xtreme Off-Road 4x4 Tanger - Main Plugin
 * Description: Main plugin for Xtreme Off-Road 4x4 Tanger website
 * Version: 1.0.0
 * Author: Xtreme Team
 * Author URI: https://xtremeoffroad4x4-tanger.com
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: xtreme-plugin
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

// Define plugin constants
define('XTREME_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('XTREME_PLUGIN_URL', plugin_dir_url(__FILE__));

/**
 * Main plugin class
 */
class Xtreme_Offroad_Main_Plugin {

    /**
     * Constructor
     */
    public function __construct() {
        $this->init();
    }

    /**
     * Initialize the plugin
     */
    public function init() {
        // Add admin menu
        add_action('admin_menu', array($this, 'add_admin_menu'));
        
        // Register custom post types
        add_action('init', array($this, 'register_custom_post_types'));
        
        // Register custom taxonomies
        add_action('init', array($this, 'register_custom_taxonomies'));
        
        // Add shortcodes
        add_action('init', array($this, 'register_shortcodes'));
        
        // Add custom widgets
        add_action('widgets_init', array($this, 'register_widgets'));
        
        // Add custom CSS and JS
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
        
        // Add AJAX handlers
        add_action('wp_ajax_xtreme_contact_form', array($this, 'handle_contact_form'));
        add_action('wp_ajax_nopriv_xtreme_contact_form', array($this, 'handle_contact_form'));
        
        // Add email handlers
        add_action('wp_mail_failed', array($this, 'handle_mail_failure'));
    }

    /**
     * Add admin menu
     */
    public function add_admin_menu() {
        add_menu_page(
            'Xtreme Settings',
            'Xtreme Settings',
            'manage_options',
            'xtreme-settings',
            array($this, 'render_settings_page'),
            'dashicons-wrench',
            30
        );
    }

    /**
     * Render settings page
     */
    public function render_settings_page() {
        ?>
        <div class="wrap">
            <h1><?php esc_html_e('Xtreme Off-Road 4x4 Tanger Settings', 'xtreme-plugin'); ?></h1>
            
            <form method="post" action="options.php">
                <?php
                settings_fields('xtreme_settings_group');
                do_settings_sections('xtreme-settings');
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register custom post types
     */
    public function register_custom_post_types() {
        // Services CPT
        register_post_type('service', array(
            'labels' => array(
                'name' => __('Services', 'xtreme-plugin'),
                'singular_name' => __('Service', 'xtreme-plugin'),
                'menu_name' => __('Services', 'xtreme-plugin'),
                'name_admin_bar' => __('Service', 'xtreme-plugin'),
            ),
            'public' => true,
            'has_archive' => true,
            'menu_icon' => 'dashicons-wrench',
            'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
            'rewrite' => array('slug' => 'services'),
            'show_in_rest' => true,
        ));

        // Testimonials CPT
        register_post_type('testimonial', array(
            'labels' => array(
                'name' => __('Avis', 'xtreme-plugin'),
                'singular_name' => __('Avis', 'xtreme-plugin'),
                'menu_name' => __('Avis Clients', 'xtreme-plugin'),
                'name_admin_bar' => __('Avis', 'xtreme-plugin'),
            ),
            'public' => true,
            'has_archive' => true,
            'menu_icon' => 'dashicons-format-quote',
            'supports' => array('title', 'editor', 'thumbnail'),
            'rewrite' => array('slug' => 'avis'),
            'show_in_rest' => true,
        ));

        // Gallery CPT
        register_post_type('gallery', array(
            'labels' => array(
                'name' => __('Galerie', 'xtreme-plugin'),
                'singular_name' => __('Image', 'xtreme-plugin'),
                'menu_name' => __('Galerie', 'xtreme-plugin'),
                'name_admin_bar' => __('Image', 'xtreme-plugin'),
            ),
            'public' => true,
            'has_archive' => true,
            'menu_icon' => 'dashicons-images',
            'supports' => array('title', 'editor', 'thumbnail'),
            'rewrite' => array('slug' => 'galerie'),
            'show_in_rest' => true,
        ));
    }

    /**
     * Register custom taxonomies
     */
    public function register_custom_taxonomies() {
        // Service categories
        register_taxonomy('service_category', array('service'), array(
            'hierarchical' => true,
            'labels' => array(
                'name' => __('Catégories de Service', 'xtreme-plugin'),
                'singular_name' => __('Catégorie', 'xtreme-plugin'),
            ),
            'show_admin_column' => true,
            'show_in_rest' => true,
            'rewrite' => array('slug' => 'categorie-service'),
        ));
    }

    /**
     * Register shortcodes
     */
    public function register_shortcodes() {
        add_shortcode('services_list', array($this, 'services_list_shortcode'));
        add_shortcode('testimonials_slider', array($this, 'testimonials_slider_shortcode'));
        add_shortcode('contact_form', array($this, 'contact_form_shortcode'));
        add_shortcode('business_hours', array($this, 'business_hours_shortcode'));
    }

    /**
     * Services list shortcode
     */
    public function services_list_shortcode($atts) {
        $atts = shortcode_atts(array(
            'category' => '',
            'limit' => -1,
        ), $atts);

        $args = array(
            'post_type' => 'service',
            'posts_per_page' => $atts['limit'],
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
        $output = '<div class="services-list-shortcode">';

        if ($services->have_posts()) {
            while ($services->have_posts()) {
                $services->the_post();
                $output .= '<div class="service-item">';
                $output .= '<h3>' . get_the_title() . '</h3>';
                $output .= '<p>' . get_the_excerpt() . '</p>';
                $output .= '<a href="' . get_permalink() . '" class="read-more">En savoir plus</a>';
                $output .= '</div>';
            }
        }

        $output .= '</div>';
        wp_reset_postdata();

        return $output;
    }

    /**
     * Testimonials slider shortcode
     */
    public function testimonials_slider_shortcode($atts) {
        $atts = shortcode_atts(array(
            'limit' => 3,
        ), $atts);

        $args = array(
            'post_type' => 'testimonial',
            'posts_per_page' => $atts['limit'],
        );

        $testimonials = new WP_Query($args);
        $output = '<div class="testimonials-slider">';

        if ($testimonials->have_posts()) {
            while ($testimonials->have_posts()) {
                $testimonials->the_post();
                $output .= '<div class="testimonial-item">';
                $output .= '<blockquote>' . get_the_content() . '</blockquote>';
                $output .= '<cite>' . get_the_title() . '</cite>';
                $output .= '</div>';
            }
        }

        $output .= '</div>';
        wp_reset_postdata();

        return $output;
    }

    /**
     * Contact form shortcode
     */
    public function contact_form_shortcode($atts) {
        $atts = shortcode_atts(array(
            'title' => 'Contactez-nous',
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
                    <label for="message">Votre message</label>
                    <textarea id="message" name="message" rows="5" required></textarea>
                </div>
                
                <button type="submit" class="submit-button">Envoyer</button>
            </form>
            <div class="form-message"></div>
        </div>
        <?php
        return ob_get_clean();
    }

    /**
     * Business hours shortcode
     */
    public function business_hours_shortcode($atts) {
        $atts = shortcode_atts(array(
            'title' => 'Horaires d\'ouverture',
        ), $atts);

        $hours = array(
            'Wednesday' => '10:00 - 18:00',
            'Thursday' => '10:00 - 18:00',
            'Friday' => '10:00 - 18:00',
            'Saturday' => '10:00 - 16:00',
            'Sunday' => 'Fermé'
        );

        ob_start();
        ?>
        <div class="business-hours-shortcode">
            <h3><?php echo esc_html($atts['title']); ?></h3>
            <ul class="hours-list">
                <?php foreach ($hours as $day => $time): ?>
                    <li><?php echo esc_html($day); ?>: <?php echo esc_html($time); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php
        return ob_get_clean();
    }

    /**
     * Register custom widgets
     */
    public function register_widgets() {
        register_widget('Xtreme_Contact_Widget');
        register_widget('Xtreme_Services_Widget');
        register_widget('Xtreme_Social_Widget');
    }

    /**
     * Enqueue scripts and styles
     */
    public function enqueue_scripts() {
        // Main plugin CSS
        wp_enqueue_style('xtreme-plugin-style', XTREME_PLUGIN_URL . 'css/xtreme-plugin.css', array(), '1.0.0');
        
        // Main plugin JS
        wp_enqueue_script('xtreme-plugin-script', XTREME_PLUGIN_URL . 'js/xtreme-plugin.js', array('jquery'), '1.0.0', true);
    }

    /**
     * Handle contact form
     */
    public function handle_contact_form() {
        if (!isset($_POST['name']) || !isset($_POST['email']) || !isset($_POST['message'])) {
            wp_send_json_error(array('message' => 'Missing required fields'));
        }

        $name = sanitize_text_field($_POST['name']);
        $email = sanitize_email($_POST['email']);
        $phone = sanitize_text_field($_POST['phone']);
        $message = sanitize_textarea_field($_POST['message']);

        $to = get_option('admin_email');
        $subject = 'Nouveau message depuis le site Xtreme Off-Road 4x4';
        $body = "Nom: $name\nEmail: $email\nTéléphone: $phone\n\nMessage:\n$message";

        $headers = array('Content-Type: text/plain; charset=UTF-8');

        $sent = wp_mail($to, $subject, $body, $headers);

        if ($sent) {
            wp_send_json_success(array('message' => 'Message envoyé avec succès'));
        } else {
            wp_send_json_error(array('message' => 'Erreur lors de l\'envoi du message'));
        }
    }

    /**
     * Handle mail failure
     */
    public function handle_mail_failure($wp_error) {
        error_log('Mail failed: ' . $wp_error->get_error_message());
    }
}

// Initialize the plugin
new Xtreme_Offroad_Main_Plugin();