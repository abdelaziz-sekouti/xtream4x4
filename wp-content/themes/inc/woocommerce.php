<?php
/**
 * WooCommerce compatibility for Xtreme theme
 */

// WooCommerce setup
function xtreme_woocommerce_setup() {
    // Add theme support for WooCommerce
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
}

add_action('after_setup_theme', 'xtreme_woocommerce_setup');

// WooCommerce CSS
function xtreme_woocommerce_css() {
    wp_enqueue_style('xtreme-woocommerce', get_template_directory_uri() . '/css/woocommerce.css', array(), '1.0.0');
}

add_action('wp_enqueue_scripts', 'xtreme_woocommerce_css');

// WooCommerce wrappers
remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

function xtreme_woocommerce_wrapper_start() {
    echo '<main id="main" class="site-main woocommerce-main">';
}

function xtreme_woocommerce_wrapper_end() {
    echo '</main>';
}

add_action('woocommerce_before_main_content', 'xtreme_woocommerce_wrapper_start', 10);
add_action('woocommerce_after_main_content', 'xtreme_woocommerce_wrapper_end', 10);

// Remove WooCommerce breadcrumbs
remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);

// Add WooCommerce custom styles
function xtreme_woocommerce_custom_styles() {
    ?>
    <style>
        /* WooCommerce custom styles */
        .woocommerce .product {
            margin-bottom: 2rem;
        }
        
        .woocommerce .product .price {
            color: #e67e22;
            font-weight: 600;
        }
        
        .woocommerce .button {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 1rem 2rem;
            border-radius: 5px;
            font-weight: 500;
            transition: background-color 0.3s ease;
        }
        
        .woocommerce .button:hover {
            background-color: #2980b9;
        }
        
        .woocommerce .single-product .product_title {
            color: #2c3e50;
        }
        
        .woocommerce .cart-collaterals {
            background-color: #f8f9fa;
            padding: 2rem;
            border-radius: 10px;
            margin-top: 2rem;
        }
        
        .woocommerce .form-row label {
            font-weight: 500;
            color: #2c3e50;
        }
        
        .woocommerce .form-row input,
        .woocommerce .form-row textarea {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 0.75rem;
        }
        
        .woocommerce .form-row input:focus,
        .woocommerce .form-row textarea:focus {
            border-color: #3498db;
            outline: none;
        }
        
        .woocommerce .entry-summary .price {
            font-size: 1.5rem;
            color: #e67e22;
        }
        
        .woocommerce .entry-summary .stock {
            margin-top: 1rem;
        }
        
        .woocommerce .entry-summary .in-stock {
            color: #27ae60;
        }
        
        .woocommerce .entry-summary .out-of-stock {
            color: #e74c3c;
        }
        
        .woocommerce .product_meta a {
            color: #3498db;
            text-decoration: none;
        }
        
        .woocommerce .product_meta a:hover {
            color: #2980b9;
        }
        
        .woocommerce .woocommerce-breadcrumb {
            background-color: #ecf0f1;
            padding: 1rem;
            border-radius: 5px;
            margin-bottom: 2rem;
        }
        
        .woocommerce .woocommerce-breadcrumb a {
            color: #3498db;
            text-decoration: none;
        }
        
        .woocommerce .woocommerce-breadcrumb a:hover {
            color: #2980b9;
        }
        
        .woocommerce .woocommerce-error,
        .woocommerce .woocommerce-info,
        .woocommerce .woocommerce-message {
            padding: 1rem;
            border-radius: 5px;
            margin-bottom: 1rem;
        }
        
        .woocommerce .woocommerce-error {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
        }
        
        .woocommerce .woocommerce-info {
            background-color: #d1ecf1;
            border: 1px solid #bee5eb;
            color: #0c5460;
        }
        
        .woocommerce .woocommerce-message {
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
        }
        
        .woocommerce .wc-forward {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 5px;
            font-weight: 500;
            transition: background-color 0.3s ease;
        }
        
        .woocommerce .wc-forward:hover {
            background-color: #2980b9;
        }
        
        .woocommerce .quantity .qty {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 0.75rem;
            width: 80px;
        }
        
        .woocommerce .product .quantity {
            margin-bottom: 1rem;
        }
        
        .woocommerce .product .single_add_to_cart_button {
            background-color: #e67e22;
            color: white;
            border: none;
            padding: 1rem 2rem;
            border-radius: 5px;
            font-weight: 500;
            transition: background-color 0.3s ease;
        }
        
        .woocommerce .product .single_add_to_cart_button:hover {
            background-color: #d35400;
        }
        
        /* Mobile responsive */
        @media (max-width: 768px) {
            .woocommerce .product .entry-summary {
                margin-top: 1rem;
            }
            
            .woocommerce .wc-forward {
                width: 100%;
                margin-bottom: 1rem;
            }
        }
    </style>
    <?php
}

add_action('wp_head', 'xtreme_woocommerce_custom_styles');

// WooCommerce page templates
function xtreme_woocommerce_page_templates() {
    // Add custom page templates for WooCommerce
    $page_templates = array(
        'template-services.php' => 'Services Page',
        'template-contact.php' => 'Contact Page',
        'template-booking.php' => 'Booking Page'
    );
    
    return $page_templates;
}

add_filter('theme_page_templates', 'xtreme_woocommerce_page_templates');

// WooCommerce custom checkout fields
function xtreme_woocommerce_custom_checkout_fields($fields) {
    // Add custom fields to checkout
    $fields['billing']['billing_custom_field'] = array(
        'type' => 'text',
        'label' => 'Custom Field',
        'placeholder' => _x('Custom Field', 'placeholder', 'xtreme'),
        'required' => false,
        'class' => array('form-row-wide'),
        'priority' => 20
    );
    
    return $fields;
}

add_filter('woocommerce_checkout_fields', 'xtreme_woocommerce_custom_checkout_fields');

// WooCommerce custom email templates
function xtreme_woocommerce_custom_email_styles() {
    ?>
    <style>
        /* Custom email styles */
        .email-header {
            background-color: #2c3e50;
            color: white;
            padding: 2rem;
            text-align: center;
        }
        
        .email-header h1 {
            margin: 0;
            font-size: 2rem;
        }
        
        .email-content {
            padding: 2rem;
        }
        
        .email-footer {
            background-color: #ecf0f1;
            padding: 1rem;
            text-align: center;
            margin-top: 2rem;
        }
        
        .email-button {
            background-color: #e67e22;
            color: white;
            padding: 1rem 2rem;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            margin: 1rem 0;
        }
        
        .email-button:hover {
            background-color: #d35400;
        }
    </style>
    <?php
}

add_action('woocommerce_email_styles', 'xtreme_woocommerce_custom_email_styles');

// WooCommerce custom order status
function xtreme_woocommerce_custom_order_status() {
    // Add custom order status
    register_post_status('wc-custom-status', array(
        'label' => __('Custom Status', 'xtreme'),
        'public' => true,
        'exclude_from_search' => false,
        'show_in_admin_all_list' => true,
        'show_in_admin_status_list' => true,
        'label_count' => _n_noop('Custom Status <span class="count">(%s)</span>', 'Custom Status <span class="count">(%s)</span>', 'xtreme')
    ));
}

add_action('init', 'xtreme_woocommerce_custom_order_status');