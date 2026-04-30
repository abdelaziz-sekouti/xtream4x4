<?php
/**
 * Database tables creation for Xtreme theme
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Create custom tables
 */
function xtreme_create_tables() {
    global $wpdb;
    
    // Contacts table
    $contacts_table = $wpdb->prefix . 'contacts';
    $charset_collate = $wpdb->get_charset_collate();
    
    if ($wpdb->get_var("SHOW TABLES LIKE '$contacts_table'") != $contacts_table) {
        $sql = "CREATE TABLE $contacts_table (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            name varchar(255) NOT NULL,
            email varchar(255) NOT NULL,
            phone varchar(50) NOT NULL,
            subject varchar(255) NOT NULL,
            message text NOT NULL,
            created_at datetime DEFAULT '0000-00-00 00:00:00',
            status varchar(50) DEFAULT 'new',
            PRIMARY KEY  (id)
        ) $charset_collate;";
        
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
    
    // Bookings table
    $bookings_table = $wpdb->prefix . 'bookings';
    
    if ($wpdb->get_var("SHOW TABLES LIKE '$bookings_table'") != $bookings_table) {
        $sql = "CREATE TABLE $bookings_table (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            customer_name varchar(255) NOT NULL,
            customer_email varchar(255) NOT NULL,
            customer_phone varchar(50) NOT NULL,
            vehicle_make varchar(255) NOT NULL,
            vehicle_model varchar(255) NOT NULL,
            vehicle_year varchar(4) NOT NULL,
            service_type varchar(100) NOT NULL,
            urgency varchar(50) NOT NULL,
            preferred_date date NOT NULL,
            preferred_time varchar(10) NOT NULL,
            vehicle_problem text,
            status varchar(50) DEFAULT 'pending',
            created_at datetime DEFAULT '0000-00-00 00:00:00',
            PRIMARY KEY  (id)
        ) $charset_collate;";
        
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
    
    // Testimonials table
    $testimonials_table = $wpdb->prefix . 'testimonials';
    
    if ($wpdb->get_var("SHOW TABLES LIKE '$testimonials_table'") != $testimonials_table) {
        $sql = "CREATE TABLE $testimonials_table (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            name varchar(255) NOT NULL,
            email varchar(255) NOT NULL,
            rating tinyint(1) NOT NULL,
            message text NOT NULL,
            approved tinyint(1) DEFAULT 0,
            created_at datetime DEFAULT '0000-00-00 00:00:00',
            PRIMARY KEY  (id)
        ) $charset_collate;";
        
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
    
    // Newsletter subscribers table
    $newsletter_table = $wpdb->prefix . 'newsletter_subscribers';
    
    if ($wpdb->get_var("SHOW TABLES LIKE '$newsletter_table'") != $newsletter_table) {
        $sql = "CREATE TABLE $newsletter_table (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            email varchar(255) NOT NULL,
            created_at datetime DEFAULT '0000-00-00 00:00:00',
            status varchar(50) DEFAULT 'active',
            PRIMARY KEY  (id),
            UNIQUE KEY email (email)
        ) $charset_collate;";
        
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
}

/**
 * Insert sample data
 */
function xtreme_insert_sample_data() {
    global $wpdb;
    
    // Sample contacts
    $contacts = array(
        array(
            'name' => 'Client Test 1',
            'email' => 'client1@example.com',
            'phone' => '0612345678',
            'subject' => 'Question sur les services',
            'message' => 'Je voudrais savoir si vous réparez les véhicules 4x4.',
            'created_at' => current_time('mysql'),
            'status' => 'resolved'
        ),
        array(
            'name' => 'Client Test 2',
            'email' => 'client2@example.com',
            'phone' => '0612345679',
            'subject' => 'Demande de devis',
            'message' => 'Je cherche un devis pour un entretien complet.',
            'created_at' => current_time('mysql'),
            'status' => 'new'
        )
    );
    
    foreach ($contacts as $contact) {
        $wpdb->insert($wpdb->prefix . 'contacts', $contact);
    }
    
    // Sample testimonials
    $testimonials = array(
        array(
            'name' => 'Fayçal Touhami',
            'email' => 'faycal@example.com',
            'rating' => 5,
            'message' => 'Ils sont pros en conduite 4x4, bien fait!',
            'approved' => 1,
            'created_at' => date('Y-m-d H:i:s', strtotime('-4 months'))
        ),
        array(
            'name' => 'Aya Rahmani',
            'email' => 'aya@example.com',
            'rating' => 5,
            'message' => 'Excellent travail!',
            'approved' => 1,
            'created_at' => date('Y-m-d H:i:s', strtotime('-3 months'))
        )
    );
    
    foreach ($testimonials as $testimonial) {
        $wpdb->insert($wpdb->prefix . 'testimonials', $testimonial);
    }
    
    // Sample newsletter subscribers
    $subscribers = array(
        array(
            'email' => 'subscriber1@example.com',
            'created_at' => current_time('mysql'),
            'status' => 'active'
        ),
        array(
            'email' => 'subscriber2@example.com',
            'created_at' => current_time('mysql'),
            'status' => 'active'
        )
    );
    
    foreach ($subscribers as $subscriber) {
        $wpdb->insert($wpdb->prefix . 'newsletter_subscribers', $subscriber);
    }
}

/**
 * Initialize database on theme activation
 */
function xtreme_initialize_database() {
    xtreme_create_tables();
    xtreme_insert_sample_data();
}

// Register activation hook
register_activation_hook(__FILE__, 'xtreme_initialize_database');

// Create tables on theme activation
add_action('after_setup_theme', 'xtreme_create_tables');