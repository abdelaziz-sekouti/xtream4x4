<?php
/**
 * Complete WordPress installation for Xtreme Off-Road 4x4 Tanger
 */

// Load WordPress
require_once('wp-config.php');

echo "Starting WordPress installation...\n";

// Check if already installed
if (is_blog_installed()) {
    echo "WordPress is already installed.\n";
    echo "Site URL: " . get_site_url() . "\n";
    echo "Admin URL: " . get_admin_url() . "\n";
    exit;
}

// Load upgrade functions
require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

// Installation parameters
$site_title = 'Xtreme Off-Road 4x4 Tanger';
$user_name = 'admin';
$user_email = 'admin@xtremeoffroad4x4-tanger.com';
$is_public = true;
$deprecated = '';
$user_password = 'password123';

// Run installation
wp_install($site_title, $user_name, $user_email, $is_public, $deprecated, $user_password);

echo "WordPress installed successfully!\n";
echo "Username: admin\n";
echo "Password: password123\n";
echo "Login at: " . get_site_url() . "/wp-login.php\n";

// Activate theme
switch_theme('xtreme-offroad');
echo "Theme activated: xtreme-offroad\n";

// Activate plugins
activate_plugin('xtreme-plugin/main-plugin.php');
echo "Plugin activated: xtreme-plugin\n";

echo "Installation complete!\n";
?>