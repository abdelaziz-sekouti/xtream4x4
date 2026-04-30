<?php
/**
 * Admin settings page for Xtreme theme
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add admin menu
 */
function xtreme_admin_menu() {
    add_menu_page(
        'Xtreme Settings',
        'Xtreme Settings',
        'manage_options',
        'xtreme-settings',
        'xtreme_settings_page',
        'dashicons-wrench',
        30
    );
    
    add_submenu_page(
        'xtreme-settings',
        'Theme Options',
        'Theme Options',
        'manage_options',
        'xtreme-settings',
        'xtreme_settings_page'
    );
    
    add_submenu_page(
        'xtreme-settings',
        'Services Management',
        'Services',
        'manage_options',
        'xtreme-services',
        'xtreme_services_page'
    );
    
    add_submenu_page(
        'xtreme-settings',
        'Testimonials Management',
        'Testimonials',
        'manage_options',
        'xtreme-testimonials',
        'xtreme_testimonials_page'
    );
}

add_action('admin_menu', 'xtreme_admin_menu');

/**
 * Settings page content
 */
function xtreme_settings_page() {
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
 * Services management page
 */
function xtreme_services_page() {
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
 * Testimonials management page
 */
function xtreme_testimonials_page() {
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