<?php
/**
 * Additional custom functions for Xtreme theme
 *
 * @package WordPress
 * @subpackage Xtreme_Offroad
 * @since 1.0.0
 */

/**
 * Add custom body classes
 */
function xtreme_body_classes($classes) {
    // Adds a class of group-blog to blogs with more than 1 published author.
    if (is_multi_author()) {
        $classes[] = 'group-blog';
    }

    // Adds a class of hfeed to non-singular pages.
    if (!is_singular()) {
        $classes[] = 'hfeed';
    }

    // Add a class if there is a custom header.
    if (has_header_image()) {
        $classes[] = 'has-header-image';
    }

    // Add class on front page
    if (is_front_page()) {
        $classes[] = 'home';
    }

    // Add class for services page
    if (is_page_template('template-services.php')) {
        $classes[] = 'services-page';
    }

    // Add class for contact page
    if (is_page_template('template-contact.php')) {
        $classes[] = 'contact-page';
    }

    return $classes;
}
add_filter('body_class', 'xtreme_body_classes');

/**
 * Add custom menu classes
 */
function xtreme_nav_menu_css_class($classes, $item) {
    $classes[] = 'menu-item';
    if ($item->current) {
        $classes[] = 'current-menu-item';
    }
    return $classes;
}
add_filter('nav_menu_css_class', 'xtreme_nav_menu_css_class', 10, 2);

/**
 * Add custom menu link attributes
 */
function xtreme_nav_menu_link_attributes($atts, $item, $args) {
    $atts['class'] = 'nav-link';
    return $atts;
}
add_filter('nav_menu_link_attributes', 'xtreme_nav_menu_link_attributes', 10, 3);

/**
 * Custom excerpt more
 */
function xtreme_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'xtreme_excerpt_more');

/**
 * Custom excerpt length
 */
function xtreme_excerpt_length($length) {
    return 25;
}
add_filter('excerpt_length', 'xtreme_excerpt_length');

/**
 * Add custom image sizes to media library
 */
function xtreme_add_image_sizes() {
    add_image_size('service-thumbnail', 400, 300, true);
    add_image_size('service-large', 800, 600, true);
    add_image_size('hero-image', 1920, 1080, true);
    add_image_size('team-member', 300, 300, true);
}
add_action('after_setup_theme', 'xtreme_add_image_sizes');

/**
 * Register custom widgets
 */
function xtreme_register_custom_widgets() {
    require XTHEME_DIR . '/widgets.php';
}
add_action('widgets_init', 'xtreme_register_custom_widgets', 20);

/**
 * Add shortcodes
 */
function xtreme_register_shortcodes() {
    require XTHEME_DIR . '/shortcodes.php';
}
add_action('init', 'xtreme_register_shortcodes');

/**
 * Add AJAX handlers
 */
function xtreme_register_ajax_handlers() {
    require XTHEME_DIR . '/ajax.php';
}
add_action('init', 'xtreme_register_ajax_handlers');

/**
 * Create database tables on theme activation
 */
function xtreme_activate_theme() {
    if (!function_exists('xtreme_create_database_tables')) {
        require XTHEME_DIR . '/database-config.php';
    }
    xtreme_create_database_tables();
}
add_action('after_switch_theme', 'xtreme_activate_theme');

/**
 * Handle contact form submission
 */
function xtreme_handle_contact_form() {
    check_ajax_referer('xtreme_contact_nonce', 'nonce');
    
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
add_action('wp_ajax_xtreme_contact_form', 'xtreme_handle_contact_form');
add_action('wp_ajax_nopriv_xtreme_contact_form', 'xtreme_handle_contact_form');

/**
 * Add custom meta boxes for services
 */
function xtreme_add_service_meta_boxes() {
    add_meta_box(
        'service_details',
        __('Service Details', 'xtreme'),
        'xtreme_service_meta_box_callback',
        'service',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'xtreme_add_service_meta_boxes');

/**
 * Service meta box callback
 */
function xtreme_service_meta_box_callback($post) {
    wp_nonce_field('xtreme_service_meta_box', 'xtreme_service_meta_box_nonce');
    
    $price = get_post_meta($post->ID, '_service_price', true);
    $duration = get_post_meta($post->ID, '_service_duration', true);
    ?>
    <p>
        <label for="service_price"><?php _e('Price', 'xtreme'); ?></label>
        <input type="text" id="service_price" name="service_price" value="<?php echo esc_attr($price); ?>" class="widefat">
    </p>
    <p>
        <label for="service_duration"><?php _e('Duration', 'xtreme'); ?></label>
        <input type="text" id="service_duration" name="service_duration" value="<?php echo esc_attr($duration); ?>" class="widefat">
    </p>
    <?php
}

/**
 * Save service meta box data
 */
function xtreme_save_service_meta_box_data($post_id) {
    if (!isset($_POST['xtreme_service_meta_box_nonce'])) {
        return;
    }

    if (!wp_verify_nonce($_POST['xtreme_service_meta_box_nonce'], 'xtreme_service_meta_box')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['service_price'])) {
        update_post_meta($post_id, '_service_price', sanitize_text_field($_POST['service_price']));
    }

    if (isset($_POST['service_duration'])) {
        update_post_meta($post_id, '_service_duration', sanitize_text_field($_POST['service_duration']));
    }
}
add_action('save_post_service', 'xtreme_save_service_meta_box_data');