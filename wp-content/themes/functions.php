<?php
/**
 * Theme setup and initialization
 */

// Exit if accessed directly
defined('ABSPATH') || exit;

// Theme constants
define('XTHEME_DIR', get_template_directory());
define('XTHEME_URI', get_template_directory_uri());

// Theme setup
function xtreme_theme_setup() {
    
    // Add support for post formats
    add_theme_support('post-formats', array(
        'aside', 'image', 'video', 'quote', 'link'
    ));
    
    // Add support for post thumbnails
    add_theme_support('post-thumbnails');
    set_post_thumbnail_size(825, 510, true);
    
    // Add support for HTML5 markup
    add_theme_support('html5', array(
        'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
    ));
    
    // Add support for title tag
    add_theme_support('title-tag');
    
    // Add support for automatic feed links
    add_theme_support('automatic-feed-links');
    
    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'xtreme'),
        'footer' => __('Footer Menu', 'xtreme')
    ));
    
    // Add theme support for WooCommerce
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
    
    // Add custom image sizes
    add_image_size('service-thumbnail', 400, 300, true);
    add_image_size('service-large', 800, 600, true);
    add_image_size('hero-image', 1920, 1080, true);
    
    // Load theme text domain
    load_theme_textdomain('xtreme', XTHEME_DIR . '/languages');
    
    // Register widget areas
    register_sidebar(array(
        'name' => __('Sidebar', 'xtreme'),
        'id' => 'sidebar-1',
        'description' => __('Add widgets here to appear in your sidebar.', 'xtreme'),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
    
    // Register additional widget areas
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
add_action('after_setup_theme', 'xtreme_theme_setup');

// Enqueue scripts and styles
function xtreme_enqueue_scripts() {
    
    // Google Fonts
    wp_enqueue_style('xtreme-fonts', 'https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Open+Sans:wght@300;400;500;600;700&display=swap');
    
    // Theme styles
    wp_enqueue_style('xtreme-style', get_template_directory_uri() . '/style.css', array(), '1.0.0');
    
    // Theme scripts
    wp_enqueue_script('xtreme-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '1.0.0', true);
    
    // Comment reply script
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'xtreme_enqueue_scripts');

// Custom template tags
require_once XTHEME_DIR . '/inc/template-tags.php';

// Custom functions
require_once XTHEME_DIR . '/inc/functions.php';

// Customizer
require_once XTHEME_DIR . '/inc/customizer.php';

// WooCommerce compatibility
require_once XTHEME_DIR . '/inc/woocommerce.php';