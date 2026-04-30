<?php
function xtreme_enqueue_scripts() {
    // Enqueue Google Fonts (Open Sans)
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap');
    
    // Enqueue Font Awesome
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css');
    
    // Enqueue theme stylesheet
    wp_enqueue_style('xtreme-style', get_stylesheet_uri());
    
    // Enqueue jQuery (WordPress bundled)
    wp_enqueue_script('jquery');
}
add_action('wp_enqueue_scripts', 'xtreme_enqueue_scripts');
?>
