<?php
/**
 * Custom widgets for Xtreme theme
 *
 * @package WordPress
 * @subpackage Xtreme_Off_Road
 * @since 1.0.0
 */

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
 * Services widget
 */
class Xtreme_Services_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'xtreme_services_widget',
            __('Widget Services', 'xtreme'),
            array('description' => __('Affiche les services récents', 'xtreme'))
        );
    }
    
    public function widget($args, $instance) {
        $title = apply_filters('widget_title', $instance['title']);
        $number = !empty($instance['number']) ? absint($instance['number']) : 3;
        
        echo $args['before_widget'];
        if (!empty($title)) {
            echo $args['before_title'] . $title . $args['after_title'];
        }
        
        $args = array(
            'post_type' => 'service',
            'posts_per_page' => $number,
            'orderby' => 'date',
            'order' => 'DESC'
        );
        
        $services = new WP_Query($args);
        
        if ($services->have_posts()) {
            echo '<div class="services-widget">';
            while ($services->have_posts()) {
                $services->the_post();
                echo '<div class="service-item">';
                echo '<h4><a href="' . get_permalink() . '">' . get_the_title() . '</a></h4>';
                echo '<p>' . get_the_excerpt() . '</p>';
                echo '</div>';
            }
            echo '</div>';
        }
        
        wp_reset_postdata();
        
        echo $args['after_widget'];
    }
    
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('Services', 'xtreme');
        $number = !empty($instance['number']) ? absint($instance['number']) : 3;
        
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'xtreme'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of services to show:', 'xtreme'); ?></label>
            <input class="tiny-text" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="number" step="1" min="1" value="<?php echo esc_attr($number); ?>" size="3">
        </p>
        <?php
    }
    
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        $instance['number'] = (!empty($new_instance['number'])) ? absint($new_instance['number']) : 3;
        
        return $instance;
    }
}

/**
 * Social widget
 */
class Xtreme_Social_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'xtreme_social_widget',
            __('Widget Social', 'xtreme'),
            array('description' => __('Affiche les liens sociaux', 'xtreme'))
        );
    }
    
    public function widget($args, $instance) {
        $title = apply_filters('widget_title', $instance['title']);
        
        echo $args['before_widget'];
        if (!empty($title)) {
            echo $args['before_title'] . $title . $args['after_title'];
        }
        
        echo '<div class="social-widget">';
        echo '<div class="social-links">';
        echo '<a href="https://facebook.com" target="_blank" rel="noopener"><i class="fab fa-facebook-f"></i></a>';
        echo '<a href="https://twitter.com" target="_blank" rel="noopener"><i class="fab fa-twitter"></i></a>';
        echo '<a href="https://instagram.com" target="_blank" rel="noopener"><i class="fab fa-instagram"></i></a>';
        echo '<a href="https://linkedin.com" target="_blank" rel="noopener"><i class="fab fa-linkedin-in"></i></a>';
        echo '</div>';
        echo '</div>';
        
        echo $args['after_widget'];
    }
    
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('Réseaux Sociaux', 'xtreme');
        
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
 * Register widgets
 */
function xtreme_register_widgets() {
    register_widget('Xtreme_Contact_Widget');
    register_widget('Xtreme_Services_Widget');
    register_widget('Xtreme_Social_Widget');
}
add_action('widgets_init', 'xtreme_register_widgets');