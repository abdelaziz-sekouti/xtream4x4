<?php
/**
 * Database schema for Xtreme Off-Road 4x4 Tanger
 */

// Database configuration
define('DB_NAME', 'xtreme4x4_db');
define('DB_USER', 'xtreme_user');
define('DB_PASSWORD', 'Xtreme2024!');
define('DB_HOST', 'localhost');
define('DB_CHARSET', 'utf8mb4');
define('DB_COLLATE', 'utf8mb4_unicode_ci');

// WordPress configuration
$table_prefix = 'wp_';

// Authentication keys and salts (generate new ones for production)
define('AUTH_KEY',         'put your unique phrase here');
define('SECURE_AUTH_KEY',  'put your unique phrase here');
define('LOGGED_IN_KEY',    'put your unique phrase here');
define('NONCE_KEY',        'put your unique phrase here');
define('AUTH_SALT',        'put your unique phrase here');
define('SECURE_AUTH_SALT', 'put your unique phrase here');
define('LOGGED_IN_SALT',   'put your unique phrase here');
define('NONCE_SALT',       'put your unique phrase here');

// WordPress settings
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', true);
define('FORCE_SSL_ADMIN', true);
define('DISALLOW_FILE_EDIT', true);

define('WP_HOME', 'https://xtremeoffroad4x4-tanger.com');
define('WP_SITEURL', 'https://xtremeoffroad4x4-tanger.com');

define('WP_CONTENT_DIR', '/var/www/html/xtream4x4/wp-content');
define('WP_CONTENT_URL', 'https://xtremeoffroad4x4-tanger.com/wp-content');
define('UPLOADS', 'wp-content/uploads');

define('COOKIE_DOMAIN', '.xtremeoffroad4x4-tanger.com');
define('WPLANG', 'fr_FR');
define('TIMEZONE', 'Africa/Casablanca');
define('WP_ENVIRONMENT_TYPE', 'production');
define('WP_AUTO_UPDATE_CORE', false);

// Custom database tables
define('XTREME_CONTACTS_TABLE', $table_prefix . 'contacts');
define('XTREME_BOOKINGS_TABLE', $table_prefix . 'bookings');
define('XTREME_TESTIMONIALS_TABLE', $table_prefix . 'testimonials');
define('XTREME_NEWSLETTER_TABLE', $table_prefix . 'newsletter_subscribers');
define('XTREME_SERVICES_TABLE', $table_prefix . 'services');
define('XTREME_TEAM_TABLE', $table_prefix . 'team_members');

/**
 * Create custom database tables
 */
function xtreme_create_database_tables() {
    global $wpdb;
    
    // Contacts table
    $charset_collate = $wpdb->get_charset_collate();
    
    $sql = "CREATE TABLE IF NOT EXISTS " . XTREME_CONTACTS_TABLE . " (
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
    
    // Bookings table
    $sql .= "CREATE TABLE IF NOT EXISTS " . XTREME_BOOKINGS_TABLE . " (
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
    
    // Testimonials table
    $sql .= "CREATE TABLE IF NOT EXISTS " . XTREME_TESTIMONIALS_TABLE . " (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        name varchar(255) NOT NULL,
        email varchar(255) NOT NULL,
        rating tinyint(1) NOT NULL,
        message text NOT NULL,
        approved tinyint(1) DEFAULT 0,
        created_at datetime DEFAULT '0000-00-00 00:00:00',
        PRIMARY KEY  (id)
    ) $charset_collate;";
    
    // Newsletter subscribers table
    $sql .= "CREATE TABLE IF NOT EXISTS " . XTREME_NEWSLETTER_TABLE . " (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        email varchar(255) NOT NULL,
        created_at datetime DEFAULT '0000-00-00 00:00:00',
        status varchar(50) DEFAULT 'active',
        PRIMARY KEY  (id),
        UNIQUE KEY email (email)
    ) $charset_collate;";
    
    // Services table
    $sql .= "CREATE TABLE IF NOT EXISTS " . XTREME_SERVICES_TABLE . " (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        title varchar(255) NOT NULL,
        description text NOT NULL,
        price varchar(100) NOT NULL,
        duration varchar(50) NOT NULL,
        image varchar(255) NOT NULL,
        featured tinyint(1) DEFAULT 0,
        created_at datetime DEFAULT '0000-00-00 00:00:00',
        PRIMARY KEY  (id)
    ) $charset_collate;";
    
    // Team members table
    $sql .= "CREATE TABLE IF NOT EXISTS " . XTREME_TEAM_TABLE . " (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        name varchar(255) NOT NULL,
        position varchar(255) NOT NULL,
        bio text NOT NULL,
        email varchar(255) NOT NULL,
        phone varchar(50) NOT NULL,
        image varchar(255) NOT NULL,
        created_at datetime DEFAULT '0000-00-00 00:00:00',
        PRIMARY KEY  (id)
    ) $charset_collate;";
    
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

/**
 * Insert sample data into database
 */
function xtreme_insert_sample_data() {
    global $wpdb;
    
    // Sample services
    $services = array(
        array(
            'title' => 'Réparation Moteur 4x4',
            'description' => 'Réparation complète du moteur, diagnostic électronique, remplacement de pièces usées.',
            'price' => 'À partir de 1500 DH',
            'duration' => '1-3 jours',
            'image' => '/images/engine-repair.jpg',
            'featured' => 1
        ),
        array(
            'title' => 'Entretien Complet',
            'description' => 'Entretien préventif complet, changement d\'huile, filtres, freins, suspension.',
            'price' => 'À partir de 800 DH',
            'duration' => '1 journée',
            'image' => '/images/full-maintenance.jpg',
            'featured' => 1
        ),
        array(
            'title' => 'Diagnostic Électronique',
            'description' => 'Diagnostic avancé avec outils professionnels, identification des pannes.',
            'price' => '500 DH',
            'duration' => '2-3 heures',
            'image' => '/images/diagnostic.jpg',
            'featured' => 1
        ),
        array(
            'title' => 'Installation Accessoires',
            'description' => 'Installation de barres de toit, winches, phares LED, pare-chocs renforcés.',
            'price' => 'À partir de 300 DH',
            'duration' => '3-6 heures',
            'image' => '/images/accessories.jpg',
            'featured' => 1
        )
    );
    
    foreach ($services as $service) {
        $wpdb->insert(XTREME_SERVICES_TABLE, $service);
    }
    
    // Sample team members
    $team_members = array(
        array(
            'name' => 'Ahmed Benali',
            'position' => 'Mécanicien Principal',
            'bio' => '15 ans d\'expérience dans la réparation de véhicules 4x4. Spécialiste en moteurs diesel.',
            'email' => 'ahmed@xtremeoffroad4x4-tanger.com',
            'phone' => '06 61 72 06 63',
            'image' => '/images/ahmed.jpg'
        ),
        array(
            'name' => 'Sarah Martinez',
            'position' => 'Directrice Technique',
            'bio' => 'Ingénieure mécanique avec spécialisation en véhicules tout-terrain.',
            'email' => 'sarah@xtremeoffroad4x4-tanger.com',
            'phone' => '06 61 72 06 64',
            'image' => '/images/sarah.jpg'
        ),
        array(
            'name' => 'Mohammed El Alaoui',
            'position' => 'Technicien Électronique',
            'bio' => 'Expert en diagnostic électronique et systèmes électroniques de véhicules.',
            'email' => 'mohammed@xtremeoffroad4x4-tanger.com',
            'phone' => '06 61 72 06 65',
            'image' => '/images/mohammed.jpg'
        )
    );
    
    foreach ($team_members as $member) {
        $wpdb->insert(XTREME_TEAM_TABLE, $member);
    }
    
    // Sample testimonials
    $testimonials = array(
        array(
            'name' => 'Fayçal Touhami',
            'email' => 'faycal@example.com',
            'rating' => 5,
            'message' => 'Ils sont pros en conduite 4x4, bien fait! 👏👏👏👏',
            'approved' => 1,
            'created_at' => date('Y-m-d H:i:s', strtotime('-4 months'))
        ),
        array(
            'name' => 'Aya Rahmani',
            'email' => 'aya@example.com',
            'rating' => 5,
            'message' => 'Excellent travail, 👍🏻👍🏻👍🏻',
            'approved' => 1,
            'created_at' => date('Y-m-d H:i:s', strtotime('-3 months'))
        )
    );
    
    foreach ($testimonials as $testimonial) {
        $wpdb->insert(XTREME_TESTIMONIALS_TABLE, $testimonial);
    }
}

/**
 * Initialize database on theme activation
 */
function xtreme_initialize_database() {
    xtreme_create_database_tables();
    xtreme_insert_sample_data();
}

// Register activation hook
register_activation_hook(__FILE__, 'xtreme_initialize_database');

// Create tables on theme activation
add_action('after_setup_theme', 'xtreme_create_database_tables');