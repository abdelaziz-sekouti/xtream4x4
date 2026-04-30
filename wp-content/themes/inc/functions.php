<?php
/**
 * Custom functions for Xtreme theme
 */

/**
 * Custom logo support
 */
function xtreme_custom_logo_setup() {
    $defaults = array(
        'height'      => 60,
        'width'       => 200,
        'flex-height' => true,
        'flex-width'  => true,
        'header-text' => array( 'site-title', 'site-description' ),
    );
    
    add_theme_support('custom-logo', $defaults);
}

add_action('after_setup_theme', 'xtreme_custom_logo_setup');

/**
* Add custom image sizes
*/
function xtreme_custom_image_sizes() {
    add_image_size('service-thumbnail', 400, 300, true);
    add_image_size('service-large', 800, 600, true);
    add_image_size('hero-image', 1920, 1080, true);
}
add_action('after_setup_theme', 'xtreme_custom_image_sizes');

/**
* Add custom post types
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
}
add_action('init', 'xtreme_register_post_types');

/**
* Add custom taxonomies
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

/**
* Add custom widgets
*/
function xtreme_widgets_init() {
    // Service widget
    register_widget('Xtreme_Service_Widget');
    // Testimonial widget
    register_widget('Xtreme_Testimonial_Widget');
    // Contact widget
    register_widget('Xtreme_Contact_Widget');
}
add_action('widgets_init', 'xtreme_widgets_init');

/**
* Service widget
*/
class Xtreme_Service_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'xtreme_service_widget',
            __('Widget Service', 'xtreme'),
            array('description' => __('Affiche un service spécifique', 'xtreme'))
        );
    }
    
    public function widget($args, $instance) {
        $title = apply_filters('widget_title', $instance['title']);
        $service_id = $instance['service_id'];
        
        echo $args['before_widget'];
        if (!empty($title)) {
            echo $args['before_title'] . $title . $args['after_title'];
        }
        
        $service = get_post($service_id);
        if ($service) {
            echo '<div class="service-widget">';
            echo '<h3>' . get_the_title($service) . '</h3>';
            echo '<p>' . get_the_excerpt($service) . '</p>';
            echo '<a href="' . get_permalink($service) . '" class="read-more">En savoir plus</a>';
            echo '</div>';
        }
        
        echo $args['after_widget'];
    }
    
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('Nos Services', 'xtreme');
        $service_id = !empty($instance['service_id']) ? $instance['service_id'] : '';
        
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'xtreme'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('service_id'); ?>"><?php _e('Service:', 'xtreme'); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id('service_id'); ?>" name="<?php echo $this->get_field_name('service_id'); ?>">
                <?php
                $services = get_posts(array('post_type' => 'service', 'numberposts' => -1));
                foreach ($services as $service) {
                    echo '<option value="' . $service->ID . '" ' . selected($service_id, $service->ID, false) . '>' . $service->post_title . '</option>';
                }
                ?>
            </select>
        </p>
        <?php
    }
    
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        $instance['service_id'] = (!empty($new_instance['service_id'])) ? absint($new_instance['service_id']) : '';
        
        return $instance;
    }
}

/**
* Testimonial widget
*/
class Xtreme_Testimonial_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'xtreme_testimonial_widget',
            __('Widget Témoignage', 'xtreme'),
            array('description' => __('Affiche un témoignage client', 'xtreme'))
        );
    }
    
    public function widget($args, $instance) {
        $title = apply_filters('widget_title', $instance['title']);
        $testimonial_id = $instance['testimonial_id'];
        
        echo $args['before_widget'];
        if (!empty($title)) {
            echo $args['before_title'] . $title . $args['after_title'];
        }
        
        $testimonial = get_post($testimonial_id);
        if ($testimonial) {
            echo '<div class="testimonial-widget">';
            echo '<blockquote>' . get_the_excerpt($testimonial) . '</blockquote>';
            echo '<cite>' . get_the_title($testimonial) . '</cite>';
            echo '</div>';
        }
        
        echo $args['after_widget'];
    }
    
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('Témoignages', 'xtreme');
        $testimonial_id = !empty($instance['testimonial_id']) ? $instance['testimonial_id'] : '';
        
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'xtreme'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('testimonial_id'); ?>"><?php _e('Témoignage:', 'xtreme'); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id('testimonial_id'); ?>" name="<?php echo $this->get_field_name('testimonial_id'); ?>">
                <?php
                $testimonials = get_posts(array('post_type' => 'testimonial', 'numberposts' => -1));
                foreach ($testimonials as $testimonial) {
                    echo '<option value="' . $testimonial->ID . '" ' . selected($testimonial_id, $testimonial->ID, false) . '>' . $testimonial->post_title . '</option>';
                }
                ?>
            </select>
        </p>
        <?php
    }
    
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        $instance['testimonial_id'] = (!empty($new_instance['testimonial_id'])) ? absint($new_instance['testimonial_id']) : '';
        
        return $instance;
    }
}

/**
* Contact widget
*/
class Xtreme_Contact_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'xtreme_contact_widget',
            __('Widget Contact', 'xtreme'),
            array('description' => __('Affiche les informations de contact', 'xtreme'))
        );
    }
    
    public function widget($args, $instance) {
        $title = apply_filters('widget_title', $instance['title']);
        
        echo $args['before_widget'];
        if (!empty($title)) {
            echo $args['before_title'] . $title . $args['after_title'];
        }
        
        echo '<div class="contact-widget">';
        echo '<p><strong>Adresse:</strong> 47 Av. Yakoub El Mansour, al mansour, Tanger 90000</p>';
        echo '<p><strong>Téléphone:</strong> 06 61 72 06 63</p>';
        echo '<p><strong>Email:</strong> info@xtremeoffroad4x4-tanger.com</p>';
        echo '<p><strong>Instagram:</strong> @xtremeoffroad4x4_tanger</p>';
        echo '</div>';
        
        echo $args['after_widget'];
    }
    
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('Contact', 'xtreme');
        
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'xtreme'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <?php
    }
    
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        
        return $instance;
    }
}

/**
* Add custom CSS classes to body
*/
function xtreme_body_classes($classes) {
    if (is_front_page()) {
        $classes[] = 'home';
    }
    if (is_page_template('template-services.php')) {
        $classes[] = 'services-page';
    }
    if (is_page_template('template-contact.php')) {
        $classes[] = 'contact-page';
    }
    
    return $classes;
}
add_filter('body_class', 'xtreme_body_classes');

/**
* Add custom menu classes
*/
function xtreme_nav_menu_css_class($classes, $item) {
    $classes[] = 'menu-item';
    if ($item->current) {
        $classes[] = 'current-menu-item';
    }
    return $classes;
}
add_filter('nav_menu_css_class', 'xtreme_nav_menu_css_class', 10, 2);

/**
* Add custom menu link attributes
*/
function xtreme_nav_menu_link_attributes($atts, $item, $args) {
    $atts['class'] = 'nav-link';
    return $atts;
}
add_filter('nav_menu_link_attributes', 'xtreme_nav_menu_link_attributes', 10, 3);

/**
* Custom excerpt more
*/
function xtreme_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'xtreme_excerpt_more');

/**
* Custom excerpt length
*/
function xtreme_excerpt_length($length) {
    return 25;
}
add_filter('excerpt_length', 'xtreme_excerpt_length');

/**
* Add custom image size to media library
*/
function xtreme_add_image_sizes() {
    add_image_size('service-thumbnail', 400, 300, true);
    add_image_size('service-large', 800, 600, true);
    add_image_size('hero-image', 1920, 1080, true);
}
add_action('after_setup_theme', 'xtreme_add_image_sizes');