<?php
/**
 * Test script for Xtreme Off-Road 4x4 Tanger WordPress installation
 */

// Load WordPress
require_once('wp-config.php');

echo "Testing WordPress installation...\n";

// Check database connection
global $wpdb;

if ($wpdb->ready) {
    echo "Database connection: OK\n";
    echo "Database name: " . DB_NAME . "\n";
    echo "Table prefix: " . $table_prefix . "\n";
    
    // Check if tables exist
    $tables = $wpdb->get_col("SHOW TABLES LIKE '{$table_prefix}%'");
    
    if (empty($tables)) {
        echo "No WordPress tables found. Running installation...\n";
        
        // Run WordPress installation
        require_once('wp-admin/includes/upgrade.php');
        
        // Create the main site
        $site_title = 'Xtreme Off-Road 4x4 Tanger';
        $user_name = 'admin';
        $user_email = 'admin@xtremeoffroad4x4-tanger.com';
        $is_public = true;
        $deprecated = '';
        $user_password = 'password123';
        
        wp_install($site_title, $user_name, $user_email, $is_public, $deprecated, $user_password);
        
        echo "WordPress installed successfully!\n";
        echo "Username: admin\n";
        echo "Password: password123\n";
        echo "Login at: /wp-login.php\n";
    } else {
        echo "Found " . count($tables) . " tables:\n";
        foreach ($tables as $table) {
            echo "- $table\n";
        }
    }
} else {
    echo "Database connection failed.\n";
    echo "Error: " . $wpdb->last_error . "\n";
}

echo "\nTest complete.\n";
?>