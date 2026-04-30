<?php
/**
 * WooCommerce compatibility for Xtreme theme
 *
 * @package WordPress
 * @subpackage Xtreme_Offroad
 * @since 1.0.0
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

// WooCommerce wrappers
remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

function xtreme_woocommerce_wrapper_start() {
    echo '<main id="main" class="site-main woocommerce-main">';
}
add_action('woocommerce_before_main_content', 'xtreme_woocommerce_wrapper_start', 10);

function xtreme_woocommerce_wrapper_end() {
    echo '</main>';
}
add_action('woocommerce_after_main_content', 'xtreme_woocommerce_wrapper_end', 10);

// Remove WooCommerce breadcrumbs
remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);

// Enqueue WooCommerce styles
function xtreme_woocommerce_css() {
    wp_enqueue_style('xtreme-woocommerce', get_template_directory_uri() . '/css/woocommerce.css', array(), '1.0.0');
}
add_action('wp_enqueue_scripts', 'xtreme_woocommerce_css');

/**
 * Customize WooCommerce product display
 */
function xtreme_woocommerce_product_thumbnails_columns() {
    return 4;
}
add_filter('woocommerce_product_thumbnails_columns', 'xtreme_woocommerce_product_thumbnails_columns');

function xtreme_woocommerce_loop_add_to_cart_link($html, $product) {
    $html = sprintf('<a href="%s" data-quantity="%s" class="%s" %s>%s</a>',
        esc_url($product->add_to_cart_url()),
        esc_attr(isset($args['quantity']) ? $args['quantity'] : 1),
        esc_attr(isset($args['class']) ? $args['class'] : 'button'),
        isset($args['attributes']) ? wc_implode_html_attributes($args['attributes']) : '',
        esc_html($product->add_to_cart_text())
    );
    return $html;
}
add_filter('woocommerce_loop_add_to_cart_link', 'xtreme_woocommerce_loop_add_to_cart_link', 10, 2);

/**
 * Customize WooCommerce checkout fields
 */
function xtreme_woocommerce_checkout_fields($fields) {
    // Add custom fields
    $fields['billing']['billing_phone']['class'] = array('form-row-wide');
    $fields['shipping']['shipping_phone'] = array(
        'label'     => __('Phone', 'xtreme'),
        'placeholder' => _x('Phone', 'placeholder', 'xtreme'),
        'required'  => false,
        'class'     => array('form-row-wide'),
        'clear'     => true
    );
    
    return $fields;
}
add_filter('woocommerce_checkout_fields', 'xtreme_woocommerce_checkout_fields');

/**
 * Customize WooCommerce emails
 */
function xtreme_woocommerce_email_styles($css) {
    $css .= '
        .email-header {
            background-color: #2c3e50;
            color: white;
            padding: 2rem;
            text-align: center;
        }
        
        .email-header h1 {
            margin: 0;
            font-size: 2rem;
            color: white;
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
    ';
    return $css;
}
add_filter('woocommerce_email_styles', 'xtreme_woocommerce_email_styles');

/**
 * Add custom order status for services
 */
function xtreme_woocommerce_register_order_status() {
    register_post_status('wc-service-scheduled', array(
        'label'                     => __('Service Scheduled', 'xtreme'),
        'public'                    => true,
        'exclude_from_search'       => false,
        'show_in_admin_all_list'    => true,
        'show_in_admin_status_list' => true,
        'label_count'               => _n_noop('Service Scheduled <span class="count">(%s)</span>', 'Service Scheduled <span class="count">(%s)</span>', 'xtreme')
    ));
}
add_action('init', 'xtreme_woocommerce_register_order_status');

function xtreme_woocommerce_add_order_statuses($order_statuses) {
    $order_statuses['wc-service-scheduled'] = __('Service Scheduled', 'xtreme');
    return $order_statuses;
}
add_filter('wc_order_statuses', 'xtreme_woocommerce_add_order_statuses');

/**
 * Customize WooCommerce cart messages
 */
function xtreme_woocommerce_add_to_cart_message($message, $product_id) {
    $message = sprintf(__('"%s" has been added to your cart.', 'xtreme'), get_the_title($product_id));
    return $message;
}
add_filter('wc_add_to_cart_message_html', 'xtreme_woocommerce_add_to_cart_message', 10, 2);

/**
 * Customize WooCommerce product tabs
 */
function xtreme_woocommerce_product_tabs($tabs) {
    // Remove the description tab
    // unset($tabs['description']);
    
    // Rename the description tab
    if (isset($tabs['description'])) {
        $tabs['description']['title'] = __('Service Details', 'xtreme');
    }
    
    // Add custom tab for service information
    $tabs['service_info'] = array(
        'title'    => __('Service Information', 'xtreme'),
        'priority' => 50,
        'callback' => 'xtreme_woocommerce_service_info_tab'
    );
    
    return $tabs;
}
add_filter('woocommerce_product_tabs', 'xtreme_woocommerce_product_tabs');

function xtreme_woocommerce_service_info_tab() {
    echo '<h2>' . __('Service Information', 'xtreme') . '</h2>';
    echo '<p>' . __('Our 4x4 repair and maintenance services include professional diagnostics, engine repair, and preventive maintenance.', 'xtreme') . '</p>';
}

/**
 * Customize WooCommerce related products
 */
function xtreme_woocommerce_output_related_products_args($args) {
    $args['posts_per_page'] = 3;
    $args['columns'] = 3;
    $args['orderby'] = 'rand';
    return $args;
}
add_filter('woocommerce_output_related_products_args', 'xtreme_woocommerce_output_related_products_args');

/**
 * Add custom data to order emails
 */
function xtreme_woocommerce_email_order_meta_fields($fields, $sent_to_admin, $order) {
    $fields['service_date'] = array(
        'label' => __('Service Date', 'xtreme'),
        'value' => get_post_meta($order->get_id(), '_service_date', true)
    );
    
    $fields['vehicle_model'] = array(
        'label' => __('Vehicle Model', 'xtreme'),
        'value' => get_post_meta($order->get_id(), '_vehicle_model', true)
    );
    
    return $fields;
}
add_filter('woocommerce_email_order_meta_fields', 'xtreme_woocommerce_email_order_meta_fields', 10, 3);