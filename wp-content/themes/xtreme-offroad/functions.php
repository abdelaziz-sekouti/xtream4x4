<?php
/**
 * Xtreme Off-Road 4x4 Tanger - Theme Functions
 */

// Exit if accessed directly
defined('ABSPATH') || exit;

// Theme constants
define('XTHEME_DIR', get_template_directory());
define('XTHEME_URI', get_template_directory_uri());

/**
 * Xtreme Off-Road 4x4 Tanger - Theme Functions
 */

// Exit if accessed directly
defined('ABSPATH') || exit;

/**
 * Theme setup
 */
function xtreme_theme_setup() {
    
    // Add default posts and comments RSS feed links to head.
    add_theme_support('automatic-feed-links');
    
    // Let WordPress manage the document title.
    add_theme_support('title-tag');
    
    // Enable support for Post Thumbnails on posts and pages.
    add_theme_support('post-thumbnails');
    set_post_thumbnail_size(825, 510, true);
    
    // Add custom image sizes
    add_image_size('service-thumbnail', 400, 300, true);
    add_image_size('service-large', 800, 600, true);
    add_image_size('hero-image', 1920, 1080, true);
    add_image_size('team-member', 300, 300, true);
    
    // Switch default core markup to output valid HTML5.
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
    
    // Add theme support for selective refresh for widgets.
    add_theme_support('customize-selective-refresh-widgets');
    
    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'xtreme'),
        'footer' => __('Footer Menu', 'xtreme')
    ));
    
    // Add custom logo support
    add_theme_support('custom-logo', array(
        'height' => 60,
        'width' => 200,
        'flex-height' => true,
        'flex-width' => true,
    ));
    
    // Add support for WooCommerce
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
    
    // Load theme text domain
    load_theme_textdomain('xtreme', XTHEME_DIR . '/languages');
}
add_action('after_setup_theme', 'xtreme_theme_setup');

/**
 * Register widget areas
 */
function xtreme_widgets_init() {
    register_sidebar(array(
        'name' => __('Sidebar', 'xtreme'),
        'id' => 'sidebar-1',
        'description' => __('Add widgets here to appear in your sidebar.', 'xtreme'),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
    
    register_sidebar(array(
        'name' => __('Footer Widget Area 1', 'xtreme'),
        'id' => 'footer-1',
        'description' => __('Appears in the footer section.', 'xtreme'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
    
    register_sidebar(array(
        'name' => __('Footer Widget Area 2', 'xtreme'),
        'id' => 'footer-2',
        'description' => __('Appears in the footer section.', 'xtreme'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
}
add_action('widgets_init', 'xtreme_widgets_init');

/**
 * Enqueue scripts and styles
 */
function xtreme_enqueue_scripts() {
    // Google Fonts
    wp_enqueue_style('xtreme-fonts', 'https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Open+Sans:wght@300;400;500;600;700&display=swap');
    
    // Theme stylesheet
    wp_enqueue_style('xtreme-style', get_stylesheet_uri(), array(), '1.0.0');
    
    // WooCommerce styles
    if (class_exists('WooCommerce')) {
        wp_enqueue_style('xtreme-woocommerce', XTHEME_URI . '/css/woocommerce.css', array(), '1.0.0');
    }
    
    // Navigation script
    wp_enqueue_script('xtreme-navigation', XTHEME_URI . '/js/navigation.js', array('jquery'), '1.0.0', true);
    
    // Comment reply script
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
    add_action('wp_enqueue_scripts', 'xtreme_enqueue_scripts');
 
/**
 * Custom template tags
 */
// require get_template_directory() . '/inc/template-tags.php';
 
/**
 * Custom functions
 */
// require get_template_directory() . '/inc/functions.php';  // This is the same file, no need to include
 
/**
 * Customizer additions
 */
// require get_template_directory() . '/inc/customizer.php';
 
/**
 * WooCommerce compatibility
 */
// if (class_exists('WooCommerce')) {
//     require get_template_directory() . '/inc/woocommerce.php';
// }

/**
 * Register custom post types
 */
function xtreme_register_post_types() {
    // Services post type
    register_post_type('service', array(
        'labels' => array(
            'name' => __('Services', 'xtreme'),
            'singular_name' => __('Service', 'xtreme'),
            'menu_name' => __('Services', 'xtreme'),
            'name_admin_bar' => __('Service', 'xtreme'),
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
            'name' => __('Avis', 'xtreme'),
            'singular_name' => __('Avis', 'xtreme'),
            'menu_name' => __('Avis Clients', 'xtreme'),
            'name_admin_bar' => __('Avis', 'xtreme'),
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
            'name' => __('Équipe', 'xtreme'),
            'singular_name' => __('Membre', 'xtreme'),
            'menu_name' => __('Équipe', 'xtreme'),
            'name_admin_bar' => __('Membre', 'xtreme'),
        ),
        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-groups',
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'rewrite' => array('slug' => 'equipe'),
        'show_in_rest' => true,
    ));
}
add_action('init', 'xtreme_register_post_types');

/**
 * Register custom taxonomies
 */
function xtreme_register_taxonomies() {
    // Service categories
    register_taxonomy('service_category', array('service'), array(
        'hierarchical' => true,
        'labels' => array(
            'name' => __('Catégories de Service', 'xtreme'),
            'singular_name' => __('Catégorie', 'xtreme'),
        ),
        'show_admin_column' => true,
        'show_in_rest' => true,
        'rewrite' => array('slug' => 'categorie-service'),
    ));
}
add_action('init', 'xtreme_register_taxonomies');