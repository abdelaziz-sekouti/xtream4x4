<?php
/**
 * AJAX handlers for Xtreme theme
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Handle contact form submission
function xtreme_handle_contact_form() {
    check_ajax_referer('xtreme_contact_nonce', 'nonce');
    
    if (!isset($_POST['name']) || !isset($_POST['email']) || !isset($_POST['message'])) {
        wp_send_json_error(array('message' => 'Champs requis manquants'));
    }
    
    $name = sanitize_text_field($_POST['name']);
    $email = sanitize_email($_POST['email']);
    $phone = sanitize_text_field($_POST['phone']);
    $subject = sanitize_text_field($_POST['subject']);
    $message = sanitize_textarea_field($_POST['message']);
    
    // Validate email
    if (!is_email($email)) {
        wp_send_json_error(array('message' => 'Email invalide'));
    }
    
    // Prepare email content
    $to = get_option('admin_email');
    $email_subject = 'Nouveau message depuis le site Xtreme Off-Road 4x4';
    $email_body = "Nom: $name\n";
    $email_body .= "Email: $email\n";
    $email_body .= "Téléphone: $phone\n";
    $email_body .= "Sujet: $subject\n";
    $email_body .= "Message:\n$message\n";
    
    $headers = array('Content-Type: text/plain; charset=UTF-8');
    
    // Send email
    $sent = wp_mail($to, $email_subject, $email_body, $headers);
    
    if ($sent) {
        // Save to database
        global $wpdb;
        $table = $wpdb->prefix . 'contacts';
        
        $wpdb->insert($table, array(
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'subject' => $subject,
            'message' => $message,
            'created_at' => current_time('mysql'),
            'status' => 'new'
        ));
        
        wp_send_json_success(array('message' => 'Message envoyé avec succès'));
    } else {
        wp_send_json_error(array('message' => 'Erreur lors de l\'envoi du message'));
    }
}
add_action('wp_ajax_xtreme_contact_form', 'xtreme_handle_contact_form');
add_action('wp_ajax_nopriv_xtreme_contact_form', 'xtreme_handle_contact_form');

// Handle booking form submission
function xtreme_handle_booking_form() {
    check_ajax_referer('xtreme_booking_nonce', 'nonce');
    
    if (!isset($_POST['customer_name']) || !isset($_POST['customer_email']) || !isset($_POST['preferred_date'])) {
        wp_send_json_error(array('message' => 'Champs requis manquants'));
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
        wp_send_json_error(array('message' => 'Email invalide'));
    }
    
    // Prepare email content
    $to = get_option('admin_email');
    $email_subject = 'Nouvelle réservation de service - ' . $customer_name;
    $email_body = "Nom: $customer_name\n";
    $email_body .= "Email: $customer_email\n";
    $email_body .= "Téléphone: $customer_phone\n";
    $email_body .= "Véhicule: $vehicle_make $vehicle_model ($vehicle_year)\n";
    $email_body .= "Type de service: $service_type\n";
    $email_body .= "Urgence: $urgency\n";
    $email_body .= "Date préférée: $preferred_date\n";
    $email_body .= "Heure préférée: $preferred_time\n";
    $email_body .= "Problème:\n$vehicle_problem\n";
    
    $headers = array('Content-Type: text/plain; charset=UTF-8');
    
    // Send email
    $sent = wp_mail($to, $email_subject, $email_body, $headers);
    
    if ($sent) {
        // Save to database
        global $wpdb;
        $table = $wpdb->prefix . 'bookings';
        
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
        
        wp_send_json_success(array('message' => 'Réservation envoyée avec succès'));
    } else {
        wp_send_json_error(array('message' => 'Erreur lors de l\'envoi de la réservation'));
    }
}
add_action('wp_ajax_xtreme_booking_form', 'xtreme_handle_booking_form');
add_action('wp_ajax_nopriv_xtreme_booking_form', 'xtreme_handle_booking_form');

// Handle testimonial submission
function xtreme_handle_testimonial_submission() {
    check_ajax_referer('xtreme_testimonial_nonce', 'nonce');
    
    if (!isset($_POST['name']) || !isset($_POST['email']) || !isset($_POST['rating']) || !isset($_POST['message'])) {
        wp_send_json_error(array('message' => 'Champs requis manquants'));
    }
    
    $name = sanitize_text_field($_POST['name']);
    $email = sanitize_email($_POST['email']);
    $rating = intval($_POST['rating']);
    $message = sanitize_textarea_field($_POST['message']);
    
    // Validate rating
    if ($rating < 1 || $rating > 5) {
        wp_send_json_error(array('message' => 'Note invalide'));
    }
    
    // Save to database
    global $wpdb;
    $table = $wpdb->prefix . 'testimonials';
    
    $wpdb->insert($table, array(
        'name' => $name,
        'email' => $email,
        'rating' => $rating,
        'message' => $message,
        'approved' => 0,
        'created_at' => current_time('mysql')
    ));
    
    wp_send_json_success(array('message' => 'Témoignage soumis avec succès'));
}
add_action('wp_ajax_xtreme_testimonial_submission', 'xtreme_handle_testimonial_submission');
add_action('wp_ajax_nopriv_xtreme_testimonial_submission', 'xtreme_handle_testimonial_submission');

// Handle search functionality
function xtreme_handle_search() {
    check_ajax_referer('xtreme_search_nonce', 'nonce');
    
    if (!isset($_POST['search_term'])) {
        wp_send_json_error(array('message' => 'Terme de recherche manquant'));
    }
    
    $search_term = sanitize_text_field($_POST['search_term']);
    
    if (empty($search_term)) {
        wp_send_json_error(array('message' => 'Terme de recherche vide'));
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
add_action('wp_ajax_xtreme_search', 'xtreme_handle_search');
add_action('wp_ajax_nopriv_xtreme_search', 'xtreme_handle_search');

// Handle newsletter subscription
function xtreme_handle_newsletter_subscription() {
    check_ajax_referer('xtreme_newsletter_nonce', 'nonce');
    
    if (!isset($_POST['email'])) {
        wp_send_json_error(array('message' => 'Email manquant'));
    }
    
    $email = sanitize_email($_POST['email']);
    
    if (!is_email($email)) {
        wp_send_json_error(array('message' => 'Email invalide'));
    }
    
    // Check if email already exists
    global $wpdb;
    $table = $wpdb->prefix . 'newsletter_subscribers';
    
    $existing = $wpdb->get_var($wpdb->prepare("SELECT id FROM $table WHERE email = %s", $email));
    
    if ($existing) {
        wp_send_json_error(array('message' => 'Cet email est déjà abonné'));
    }
    
    // Add to database
    $wpdb->insert($table, array(
        'email' => $email,
        'created_at' => current_time('mysql'),
        'status' => 'active'
    ));
    
    // Send welcome email
    $subject = 'Bienvenue chez Xtreme Off-Road 4x4 Tanger!';
    $message = "Merci de vous être abonné à notre newsletter!\n\nVous recevrez bientôt nos dernières offres et actualités.";
    
    wp_mail($email, $subject, $message);
    
    wp_send_json_success(array('message' => 'Abonnement réussi'));
}
add_action('wp_ajax_xtreme_newsletter_subscription', 'xtreme_handle_newsletter_subscription');
add_action('wp_ajax_nopriv_xtreme_newsletter_subscription', 'xtreme_handle_newsletter_subscription');