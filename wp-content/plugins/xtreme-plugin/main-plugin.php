<?php
/**
 * Plugin Name: Xtreme Off-Road 4x4 Tanger - Main Plugin
 * Description: Main plugin for Xtreme Off-Road 4x4 Tanger website. Provides additional functionality like custom post types, shortcodes, and AJAX handlers.
 * Version: 1.0.0
 * Author: Xtreme Team
 * Author URI: http://localhost/xtream4x4
 * License: GPL v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: xtreme-plugin
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    exit;
}

// Define plugin constants
define('XTR_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('XTR_PLUGIN_URI', plugin_dir_url(__FILE__));

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
        
        add_action('wp_ajax_xtreme_booking_form', array($this, 'handle_booking_form'));
        add_action('wp_ajax_nopriv_xtreme_booking_form', array($this, 'handle_booking_form'));
        
        add_action('wp_ajax_xtreme_testimonial_submission', array($this, 'handle_testimonial_submission'));
        add_action('wp_ajax_nopriv_xtreme_testimonial_submission', array($this, 'handle_testimonial_submission'));
        
        add_action('wp_ajax_xtreme_search', array($this, 'handle_search'));
        add_action('wp_ajax_nopriv_xtreme_search', array($this, 'handle_search'));
        
        add_action('wp_ajax_xtreme_newsletter_subscription', array($this, 'handle_newsletter_subscription'));
        add_action('wp_ajax_nopriv_xtreme_newsletter_subscription', array($this, 'handle_newsletter_subscription'));
        
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
        
        add_submenu_page(
            'xtreme-settings',
            'Theme Options',
            'Theme Options',
            'manage_options',
            'xtreme-settings',
            array($this, 'render_settings_page')
        );
        
        add_submenu_page(
            'xtreme-settings',
            'Services Management',
            'Services',
            'manage_options',
            'xtreme-services',
            array($this, 'render_services_page')
        );
        
        add_submenu_page(
            'xtreme-settings',
            'Testimonials Management',
            'Testimonials',
            'manage_options',
            'xtreme-testimonials',
            array($this, 'render_testimonials_page')
        );
    }

    /**
     * Render settings page
     */
    public function render_settings_page() {
        if (!current_user_can('manage_options')) {
            return;
        }
        
        // Save settings
        if (isset($_POST['xtreme_save_settings'])) {
            update_option('xtreme_theme_options', array(
                'primary_color' => sanitize_hex_color($_POST['primary_color']),
                'secondary_color' => sanitize_hex_color($_POST['secondary_color']),
                'accent_color' => sanitize_hex_color($_POST['accent_color']),
                'site_phone' => sanitize_text_field($_POST['site_phone']),
                'site_address' => sanitize_text_field($_POST['site_address']),
                'site_email' => sanitize_email($_POST['site_email']),
                'site_instagram' => esc_url_raw($_POST['site_instagram']),
                'google_maps_url' => esc_url_raw($_POST['google_maps_url']),
                'business_hours' => json_encode(array(
                    'monday' => sanitize_text_field($_POST['hours_monday']),
                    'tuesday' => sanitize_text_field($_POST['hours_tuesday']),
                    'wednesday' => sanitize_text_field($_POST['hours_wednesday']),
                    'thursday' => sanitize_text_field($_POST['hours_thursday']),
                    'friday' => sanitize_text_field($_POST['hours_friday']),
                    'saturday' => sanitize_text_field($_POST['hours_saturday']),
                    'sunday' => sanitize_text_field($_POST['hours_sunday'])
                ))
            ));
            
            echo '<div class="notice notice-success is-dismissible"><p>Settings saved successfully!</p></div>';
        }
        
        // Get current settings
        $options = get_option('xtreme_theme_options', array());
        $primary_color = isset($options['primary_color']) ? $options['primary_color'] : '#2c3e50';
        $secondary_color = isset($options['secondary_color']) ? $options['secondary_color'] : '#e67e22';
        $accent_color = isset($options['accent_color']) ? $options['accent_color'] : '#3498db';
        $site_phone = isset($options['site_phone']) ? $options['site_phone'] : '06 61 72 06 63';
        $site_address = isset($options['site_address']) ? $options['site_address'] : '47 Av. Yakoub El Mansour, al mansour, Tanger 90000';
        $site_email = isset($options['site_email']) ? $options['site_email'] : 'info@xtremeoffroad4x4-tanger.com';
        $site_instagram = isset($options['site_instagram']) ? $options['site_instagram'] : 'https://instagram.com';
        $google_maps_url = isset($options['google_maps_url']) ? $options['google_maps_url'] : '';
        $business_hours = isset($options['business_hours']) ? json_decode($options['business_hours'], true) : array();
        
        ?>
        <div class="wrap">
            <h1>Xtreme Off-Road 4x4 Tanger Settings</h1>
            
            <form method="post" action="">
                <?php wp_nonce_field('xtreme_settings_nonce', '_wpnonce_xtreme_settings'); ?>
                
                <h2>Theme Options</h2>
                
                <table class="form-table">
                    <tr>
                        <th scope="row">Primary Color</th>
                        <td>
                            <input type="color" name="primary_color" value="<?php echo esc_attr($primary_color); ?>" class="regular-text">
                            <p class="description">Main color for headers and important elements</p>
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row">Secondary Color</th>
                        <td>
                            <input type="color" name="secondary_color" value="<?php echo esc_attr($secondary_color); ?>" class="regular-text">
                            <p class="description">Accent color for buttons and highlights</p>
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row">Accent Color</th>
                        <td>
                            <input type="color" name="accent_color" value="<?php echo esc_attr($accent_color); ?>" class="regular-text">
                            <p class="description">Color for links and secondary elements</p>
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row">Site Phone</th>
                        <td>
                            <input type="text" name="site_phone" value="<?php echo esc_attr($site_phone); ?>" class="regular-text">
                            <p class="description">Main phone number</p>
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row">Site Address</th>
                        <td>
                            <input type="text" name="site_address" value="<?php echo esc_attr($site_address); ?>" class="regular-text">
                            <p class="description">Business address</p>
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row">Site Email</th>
                        <td>
                            <input type="email" name="site_email" value="<?php echo esc_attr($site_email); ?>" class="regular-text">
                            <p class="description">Main contact email</p>
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row">Instagram URL</th>
                        <td>
                            <input type="url" name="site_instagram" value="<?php echo esc_attr($site_instagram); ?>" class="regular-text">
                            <p class="description">Instagram profile URL</p>
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row">Google Maps URL</th>
                        <td>
                            <input type="url" name="google_maps_url" value="<?php echo esc_attr($google_maps_url); ?>" class="regular-text">
                            <p class="description">Google Maps embed URL</p>
                        </td>
                    </tr>
                </table>
                
                <h2>Business Hours</h2>
                
                <table class="form-table">
                    <tr>
                        <th scope="row">Monday</th>
                        <td>
                            <input type="text" name="hours_monday" value="<?php echo esc_attr($business_hours['monday'] ?? ''); ?>" class="regular-text">
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row">Tuesday</th>
                        <td>
                            <input type="text" name="hours_tuesday" value="<?php echo esc_attr($business_hours['tuesday'] ?? ''); ?>" class="regular-text">
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row">Wednesday</th>
                        <td>
                            <input type="text" name="hours_wednesday" value="<?php echo esc_attr($business_hours['wednesday'] ?? ''); ?>" class="regular-text">
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row">Thursday</th>
                        <td>
                            <input type="text" name="hours_thursday" value="<?php echo esc_attr($business_hours['thursday'] ?? ''); ?>" class="regular-text">
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row">Friday</th>
                        <td>
                            <input type="text" name="hours_friday" value="<?php echo esc_attr($business_hours['friday'] ?? ''); ?>" class="regular-text">
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row">Saturday</th>
                        <td>
                            <input type="text" name="hours_saturday" value="<?php echo esc_attr($business_hours['saturday'] ?? ''); ?>" class="regular-text">
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row">Sunday</th>
                        <td>
                            <input type="text" name="hours_sunday" value="<?php echo esc_attr($business_hours['sunday'] ?? ''); ?>" class="regular-text">
                        </td>
                    </tr>
                </table>
                
                <?php submit_button('Save Settings', 'primary', 'xtreme_save_settings'); ?>
            </form>
        </div>
        <?php
    }

    /**
     * Render services page
     */
    public function render_services_page() {
        if (!current_user_can('manage_options')) {
            return;
        }
        
        // Handle form submission
        if (isset($_POST['add_service']) && isset($_POST['service_title'])) {
            $post_id = wp_insert_post(array(
                'post_title' => sanitize_text_field($_POST['service_title']),
                'post_content' => wpautop(sanitize_textarea_field($_POST['service_description'])),
                'post_status' => 'publish',
                'post_type' => 'service'
            ));
            
            if ($post_id) {
                update_post_meta($post_id, '_service_price', sanitize_text_field($_POST['service_price']));
                update_post_meta($post_id, '_service_duration', sanitize_text_field($_POST['service_duration']));
                echo '<div class="notice notice-success is-dismissible"><p>Service added successfully!</p></div>';
            }
        }
        
        // Display services list
        $args = array(
            'post_type' => 'service',
            'posts_per_page' => -1,
            'orderby' => 'title',
            'order' => 'ASC'
        );
        
        $services = new WP_Query($args);
        ?>
        <div class="wrap">
            <h1>Services Management</h1>
            
            <h2>Add New Service</h2>
            <form method="post" action="">
                <table class="form-table">
                    <tr>
                        <th scope="row">Service Title</th>
                        <td>
                            <input type="text" name="service_title" class="regular-text" required>
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row">Service Description</th>
                        <td>
                            <textarea name="service_description" rows="5" class="large-text" required></textarea>
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row">Price</th>
                        <td>
                            <input type="text" name="service_price" class="regular-text" placeholder="e.g., À partir de 1500 DH">
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row">Duration</th>
                        <td>
                            <input type="text" name="service_duration" class="regular-text" placeholder="e.g., 1-3 jours">
                        </td>
                    </tr>
                </table>
                
                <?php submit_button('Add Service', 'primary', 'add_service'); ?>
            </form>
            
            <h2>Existing Services</h2>
            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Price</th>
                        <th>Duration</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($services->have_posts()): while ($services->have_posts()): $services->the_post(); ?>
                        <tr>
                            <td><?php the_title(); ?></td>
                            <td><?php echo esc_html(get_post_meta(get_the_ID(), '_service_price', true)); ?></td>
                            <td><?php echo esc_html(get_post_meta(get_the_ID(), '_service_duration', true)); ?></td>
                            <td>
                                <a href="<?php echo esc_url(get_edit_post_link()); ?>">Edit</a> | 
                                <a href="<?php echo esc_url(get_permalink()); ?>">View</a> | 
                                <a href="#" onclick="return confirm('Are you sure?');">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; endif; ?>
                </tbody>
            </table>
        </div>
        <?php
    }

    /**
     * Render testimonials page
     */
    public function render_testimonials_page() {
        if (!current_user_can('manage_options')) {
            return;
        }
        
        // Handle form submission
        if (isset($_POST['add_testimonial']) && isset($_POST['testimonial_name'])) {
            $post_id = wp_insert_post(array(
                'post_title' => sanitize_text_field($_POST['testimonial_name']),
                'post_content' => wpautop(sanitize_textarea_field($_POST['testimonial_text'])),
                'post_status' => 'publish',
                'post_type' => 'testimonial'
            ));
            
            if ($post_id) {
                update_post_meta($post_id, '_testimonial_rating', intval($_POST['testimonial_rating']));
                update_post_meta($post_id, '_testimonial_email', sanitize_email($_POST['testimonial_email']));
                echo '<div class="notice notice-success is-dismissible"><p>Testimonial added successfully!</p></div>';
            }
        }
        
        // Display testimonials list
        $args = array(
            'post_type' => 'testimonial',
            'posts_per_page' => -1,
            'orderby' => 'title',
            'order' => 'ASC'
        );
        
        $testimonials = new WP_Query($args);
        ?>
        <div class="wrap">
            <h1>Testimonials Management</h1>
            
            <h2>Add New Testimonial</h2>
            <form method="post" action="">
                <table class="form-table">
                    <tr>
                        <th scope="row">Customer Name</th>
                        <td>
                            <input type="text" name="testimonial_name" class="regular-text" required>
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row">Email</th>
                        <td>
                            <input type="email" name="testimonial_email" class="regular-text" required>
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row">Rating</th>
                        <td>
                            <select name="testimonial_rating" required>
                                <option value="1">1 Star</option>
                                <option value="2">2 Stars</option>
                                <option value="3">3 Stars</option>
                                <option value="4">4 Stars</option>
                                <option value="5">5 Stars</option>
                            </select>
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row">Testimonial Text</th>
                        <td>
                            <textarea name="testimonial_text" rows="5" class="large-text" required></textarea>
                        </td>
                    </tr>
                </table>
                
                <?php submit_button('Add Testimonial', 'primary', 'add_testimonial'); ?>
            </form>
            
            <h2>Existing Testimonials</h2>
            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Rating</th>
                        <th>Excerpt</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($testimonials->have_posts()): while ($testimonials->have_posts()): $testimonials->the_post(); ?>
                        <tr>
                            <td><?php the_title(); ?></td>
                            <td><?php echo str_repeat('★', intval(get_post_meta(get_the_ID(), '_testimonial_rating', true))); ?></td>
                            <td><?php echo esc_html(get_the_excerpt()); ?></td>
                            <td>
                                <a href="<?php echo esc_url(get_edit_post_link()); ?>">Edit</a> | 
                                <a href="<?php echo esc_url(get_permalink()); ?>">View</a> | 
                                <a href="#" onclick="return confirm('Are you sure?');">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; endif; ?>
                </tbody>
            </table>
        </div>
        <?php
    }

    /**
     * Register custom post types
     */
    public function register_custom_post_types() {
        // Services post type
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

        // Testimonials post type
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

        // Team members post type
        register_post_type('team_member', array(
            'labels' => array(
                'name' => __('Équipe', 'xtreme-plugin'),
                'singular_name' => __('Membre', 'xtreme-plugin'),
                'menu_name' => __('Équipe', 'xtreme-plugin'),
                'name_admin_bar' => __('Membre', 'xtreme-plugin'),
            ),
            'public' => true,
            'has_archive' => true,
            'menu_icon' => 'dashicons-groups',
            'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
            'rewrite' => array('slug' => 'equipe'),
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
        // These are handled by the theme's shortcodes.php file
    }

    /**
     * Register custom widgets
     */
    public function register_widgets() {
        // These are handled by the theme's widgets.php file
    }

    /**
     * Enqueue scripts and styles
     */
    public function enqueue_scripts() {
        // Main plugin CSS
        wp_enqueue_style('xtreme-plugin-style', XTR_PLUGIN_URI . 'css/xtreme-plugin.css', array(), '1.0.0');
        
        // Main plugin JS
        wp_enqueue_script('xtreme-plugin-script', XTR_PLUGIN_URI . 'js/xtreme-plugin.js', array('jquery'), '1.0.0', true);
        
        // Localize script for AJAX
        wp_localize_script('xtreme-plugin-script', 'xtreme_ajax', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('xtreme_nonce')
        ));
    }

    /**
     * Handle contact form submission
     */
    public function handle_contact_form() {
        check_ajax_referer('xtreme_nonce', 'nonce');
        
        if (!isset($_POST['name']) || !isset($_POST['email']) || !isset($_POST['message'])) {
            wp_send_json_error(array('message' => 'Missing required fields'));
        }
        
        $name = sanitize_text_field($_POST['name']);
        $email = sanitize_email($_POST['email']);
        $phone = sanitize_text_field($_POST['phone']);
        $subject = sanitize_text_field($_POST['subject']);
        $message = sanitize_textarea_field($_POST['message']);
        
        // Validate email
        if (!is_email($email)) {
            wp_send_json_error(array('message' => 'Invalid email'));
        }
        
        // Prepare email content
        $to = get_option('admin_email');
        $email_subject = 'New message from Xtreme Off-Road 4x4 Website';
        $email_body = "Name: $name\n";
        $email_body .= "Email: $email\n";
        $email_body .= "Phone: $phone\n";
        $email_body .= "Subject: $subject\n";
        $email_body .= "Message:\n$message\n";
        
        $headers = array('Content-Type: text/plain; charset=UTF-8');
        
        // Send email
        $sent = wp_mail($to, $email_subject, $email_body, $headers);
        
        if ($sent) {
            // Save to database
            global $wpdb;
            $table = $wpdb->prefix . 'contacts';
            
            if ($wpdb->get_var("SHOW TABLES LIKE '$table'") == $table) {
                $wpdb->insert($table, array(
                    'name' => $name,
                    'email' => $email,
                    'phone' => $phone,
                    'subject' => $subject,
                    'message' => $message,
                    'created_at' => current_time('mysql'),
                    'status' => 'new'
                ));
            }
            
            wp_send_json_success(array('message' => 'Message sent successfully'));
        } else {
            wp_send_json_error(array('message' => 'Error sending message'));
        }
    }

    /**
     * Handle booking form submission
     */
    public function handle_booking_form() {
        check_ajax_referer('xtreme_nonce', 'nonce');
        
        if (!isset($_POST['customer_name']) || !isset($_POST['customer_email']) || !isset($_POST['preferred_date'])) {
            wp_send_json_error(array('message' => 'Missing required fields'));
        }
        
        $customer_name = sanitize_text_field($_POST['customer_name']);
        $customer_email = sanitize_email($_POST['customer_email']);
        $customer_phone = sanitize_text_field($_POST['customer_phone']);
        $vehicle_make = sanitize_text_field($_POST['vehicle_make']);
        $vehicle_model = sanitize_text_field($_POST['vehicle_model']);
        $vehicle_year = sanitize_text_field($_POST['vehicle_year']);
        $service_type = sanitize_text_field($_POST['service_type']);
        $urgency = sanitize_text_field($_POST['urgency']);
        $preferred_date = sanitize_text_field($_POST['preferred_date']);
        $preferred_time = sanitize_text_field($_POST['preferred_time']);
        $vehicle_problem = sanitize_textarea_field($_POST['vehicle_problem']);
        
        // Validate email
        if (!is_email($customer_email)) {
            wp_send_json_error(array('message' => 'Invalid email'));
        }
        
        // Prepare email content
        $to = get_option('admin_email');
        $email_subject = 'New service booking - ' . $customer_name;
        $email_body = "Name: $customer_name\n";
        $email_body .= "Email: $customer_email\n";
        $email_body .= "Phone: $customer_phone\n";
        $email_body .= "Vehicle: $vehicle_make $vehicle_model ($vehicle_year)\n";
        $email_body .= "Service Type: $service_type\n";
        $email_body .= "Urgency: $urgency\n";
        $email_body .= "Preferred Date: $preferred_date\n";
        $email_body .= "Preferred Time: $preferred_time\n";
        $email_body .= "Problem:\n$vehicle_problem\n";
        
        $headers = array('Content-Type: text/plain; charset=UTF-8');
        
        // Send email
        $sent = wp_mail($to, $email_subject, $email_body, $headers);
        
        if ($sent) {
            // Save to database
            global $wpdb;
            $table = $wpdb->prefix . 'bookings';
            
            if ($wpdb->get_var("SHOW TABLES LIKE '$table'") == $table) {
                $wpdb->insert($table, array(
                    'customer_name' => $customer_name,
                    'customer_email' => $customer_email,
                    'customer_phone' => $customer_phone,
                    'vehicle_make' => $vehicle_make,
                    'vehicle_model' => $vehicle_model,
                    'vehicle_year' => $vehicle_year,
                    'service_type' => $service_type,
                    'urgency' => $urgency,
                    'preferred_date' => $preferred_date,
                    'preferred_time' => $preferred_time,
                    'vehicle_problem' => $vehicle_problem,
                    'status' => 'pending',
                    'created_at' => current_time('mysql')
                ));
            }
            
            wp_send_json_success(array('message' => 'Booking sent successfully'));
        } else {
            wp_send_json_error(array('message' => 'Error sending booking'));
        }
    }

    /**
     * Handle testimonial submission
     */
    public function handle_testimonial_submission() {
        check_ajax_referer('xtreme_nonce', 'nonce');
        
        if (!isset($_POST['name']) || !isset($_POST['email']) || !isset($_POST['rating']) || !isset($_POST['message'])) {
            wp_send_json_error(array('message' => 'Missing required fields'));
        }
        
        $name = sanitize_text_field($_POST['name']);
        $email = sanitize_email($_POST['email']);
        $rating = intval($_POST['rating']);
        $message = sanitize_textarea_field($_POST['message']);
        
        // Validate rating
        if ($rating < 1 || $rating > 5) {
            wp_send_json_error(array('message' => 'Invalid rating'));
        }
        
        // Save to database
        global $wpdb;
        $table = $wpdb->prefix . 'testimonials';
        
        if ($wpdb->get_var("SHOW TABLES LIKE '$table'") == $table) {
            $wpdb->insert($table, array(
                'name' => $name,
                'email' => $email,
                'rating' => $rating,
                'message' => $message,
                'approved' => 0,
                'created_at' => current_time('mysql')
            ));
        }
        
        wp_send_json_success(array('message' => 'Testimonial submitted successfully'));
    }

    /**
     * Handle search functionality
     */
    public function handle_search() {
        check_ajax_referer('xtreme_nonce', 'nonce');
        
        if (!isset($_POST['search_term'])) {
            wp_send_json_error(array('message' => 'Search term missing'));
        }
        
        $search_term = sanitize_text_field($_POST['search_term']);
        
        if (empty($search_term)) {
            wp_send_json_error(array('message' => 'Empty search term'));
        }
        
        // Search in posts and pages
        $args = array(
            's' => $search_term,
            'post_type' => array('post', 'page', 'service'),
            'posts_per_page' => 10,
            'orderby' => 'relevance',
            'order' => 'DESC'
        );
        
        $search_results = new WP_Query($args);
        $results = array();
        
        if ($search_results->have_posts()) {
            while ($search_results->have_posts()) {
                $search_results->the_post();
                $results[] = array(
                    'title' => get_the_title(),
                    'link' => get_permalink(),
                    'excerpt' => get_the_excerpt(),
                    'type' => get_post_type(),
                    'type_label' => get_post_type_object(get_post_type())->labels->singular_name
                );
            }
        }
        
        wp_reset_postdata();
        
        wp_send_json_success(array('results' => $results));
    }

    /**
     * Handle newsletter subscription
     */
    public function handle_newsletter_subscription() {
        check_ajax_referer('xtreme_nonce', 'nonce');
        
        if (!isset($_POST['email'])) {
            wp_send_json_error(array('message' => 'Email missing'));
        }
        
        $email = sanitize_email($_POST['email']);
        
        if (!is_email($email)) {
            wp_send_json_error(array('message' => 'Invalid email'));
        }
        
        // Check if email already exists
        global $wpdb;
        $table = $wpdb->prefix . 'newsletter_subscribers';
        
        if ($wpdb->get_var("SHOW TABLES LIKE '$table'") == $table) {
            $existing = $wpdb->get_var($wpdb->prepare("SELECT id FROM $table WHERE email = %s", $email));
            
            if ($existing) {
                wp_send_json_error(array('message' => 'This email is already subscribed'));
            }
            
            // Add to database
            $wpdb->insert($table, array(
                'email' => $email,
                'created_at' => current_time('mysql'),
                'status' => 'active'
            ));
        }
        
        // Send welcome email
        $subject = 'Welcome to Xtreme Off-Road 4x4 Tanger!';
        $message = "Thank you for subscribing to our newsletter!\n\nYou will receive our latest offers and updates soon.";
        
        wp_mail($email, $subject, $message);
        
        wp_send_json_success(array('message' => 'Subscription successful'));
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
