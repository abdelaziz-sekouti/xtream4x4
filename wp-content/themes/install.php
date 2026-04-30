<?php
/**
 * Installation script for Xtreme Off-Road 4x4 Tanger theme
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Theme activation function
 */
function xtreme_theme_activate() {
    // Create default pages
    $default_pages = array(
        array(
            'post_title' => 'Services',
            'post_name' => 'services',
            'post_content' => '[services_list]',
            'post_status' => 'publish',
            'post_type' => 'page',
            'post_author' => 1
        ),
        array(
            'post_title' => 'À Propos',
            'post_name' => 'a-propos',
            'post_content' => '<h2>Nos Spécialistes</h2><p>Nous sommes une équipe de mécaniciens qualifiés spécialisés dans les véhicules 4x4.</p>',
            'post_status' => 'publish',
            'post_type' => 'page',
            'post_author' => 1
        ),
        array(
            'post_title' => 'Contact',
            'post_name' => 'contact',
            'post_content' => '[contact_form]',
            'post_status' => 'publish',
            'post_type' => 'page',
            'post_author' => 1
        )
    );

    foreach ($default_pages as $page) {
        $page_exists = get_page_by_path($page['post_name']);
        if (!$page_exists) {
            wp_insert_post($page);
        }
    }

    // Set front page
    $front_page = get_page_by_path('accueil');
    if ($front_page) {
        update_option('show_on_front', 'page');
        update_option('page_on_front', $front_page->ID);
    }

    // Create navigation menu
    $menu_name = 'Primary Menu';
    $menu_exists = wp_get_nav_menu_object($menu_name);

    if (!$menu_exists) {
        $menu_id = wp_create_nav_menu($menu_name);
        
        // Add menu items
        $menu_items = array(
            array(
                'menu-item-title' => 'Accueil',
                'menu-item-obj-type' => 'post_type',
                'menu-item-object' => 'page',
                'menu-item-object-id' => get_page_by_path('accueil')->ID,
                'menu-item-type' => 'post_type',
                'menu-item-status' => 'publish'
            ),
            array(
                'menu-item-title' => 'Services',
                'menu-item-obj-type' => 'post_type',
                'menu-item-object' => 'page',
                'menu-item-object-id' => get_page_by_path('services')->ID,
                'menu-item-type' => 'post_type',
                'menu-item-status' => 'publish'
            ),
            array(
                'menu-item-title' => 'À Propos',
                'menu-item-obj-type' => 'post_type',
                'menu-item-object' => 'page',
                'menu-item-object-id' => get_page_by_path('a-propos')->ID,
                'menu-item-type' => 'post_type',
                'menu-item-status' => 'publish'
            ),
            array(
                'menu-item-title' => 'Contact',
                'menu-item-obj-type' => 'post_type',
                'menu-item-object' => 'page',
                'menu-item-object-id' => get_page_by_path('contact')->ID,
                'menu-item-type' => 'post_type',
                'menu-item-status' => 'publish'
            )
        );

        foreach ($menu_items as $item) {
            wp_update_nav_menu_item($menu_id, 0, $item);
        }
    }

    // Assign menu to primary location
    $locations = get_theme_mod('nav_menu_locations');
    if ($locations) {
        $locations['primary'] = $menu_id;
        set_theme_mod('nav_menu_locations', $locations);
    }

    // Set reading settings
    update_option('posts_per_page', 10);
    update_option('show_on_front', 'page');
    update_option('page_on_front', get_page_by_path('accueil')->ID);
    update_option('page_for_posts', get_page_by_path('blog')->ID);

    // Set permalink structure
    global $wp_rewrite;
    $wp_rewrite->set_permalink_structure('/%postname%/');
    $wp_rewrite->flush_rules();

    // Set theme options
    update_option('xtreme_theme_options', array(
        'primary_color' => '#2c3e50',
        'secondary_color' => '#e67e22',
        'accent_color' => '#3498db',
        'site_phone' => '06 61 72 06 63',
        'site_address' => '47 Av. Yakoub El Mansour, al mansour, Tanger 90000',
        'site_email' => 'info@xtremeoffroad4x4-tanger.com',
        'site_instagram' => 'https://instagram.com'
    ));
}

/**
 * Theme deactivation function
 */
function xtreme_theme_deactivate() {
    // Cleanup tasks if needed
}

// Register activation and deactivation hooks
register_activation_hook(__FILE__, 'xtreme_theme_activate');
register_deactivation_hook(__FILE__, 'xtreme_theme_deactivate');