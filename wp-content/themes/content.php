<?php
/**
 * Content pages for Xtreme theme
 */

// Create sample content
function xtreme_create_sample_content() {
    // Pages
    $pages = array(
        array(
            'post_title' => 'Accueil',
            'post_name' => 'accueil',
            'post_content' => '
                [xtreme_hero_section]
                
                [services_list limit="4"]
                
                [testimonials_slider limit="2"]
                
                [contact_form]
            ',
            'post_status' => 'publish',
            'post_type' => 'page',
            'post_author' => 1
        ),
        array(
            'post_title' => 'Services',
            'post_name' => 'services',
            'post_content' => '
                <h2>Nos Services</h2>
                <p>Nous sommes spécialisés dans la réparation et l\'entretien de véhicules 4x4 à Tanger.</p>
                
                [services_list]
            ',
            'post_status' => 'publish',
            'post_type' => 'page',
            'post_author' => 1
        ),
        array(
            'post_title' => 'À Propos',
            'post_name' => 'a-propos',
            'post_content' => '
                <h2>Nos Spécialistes</h2>
                <p>Nous sommes une équipe de mécaniciens qualifiés spécialisés dans les véhicules 4x4.</p>
                
                <h3>Notre Mission</h3>
                <p>Fournir des services de réparation et d\'entretien de haute qualité pour tous les types de véhicules 4x4.</p>
                
                <h3>Notre Expertise</h3>
                <ul>
                    <li>Réparation moteur 4x4</li>
                    <li>Entretien complet</li>
                    <li>Diagnostic électronique</li>
                    <li>Installation d\'accessoires</li>
                </ul>
            ',
            'post_status' => 'publish',
            'post_type' => 'page',
            'post_author' => 1
        ),
        array(
            'post_title' => 'Contact',
            'post_name' => 'contact',
            'post_content' => '
                <h2>Contactez-nous</h2>
                <p>Nous sommes à votre disposition pour toutes vos questions et besoins en réparation 4x4.</p>
                
                [contact_form]
                
                [business_hours]
            ',
            'post_status' => 'publish',
            'post_type' => 'page',
            'post_author' => 1
        )
    );

    foreach ($pages as $page) {
        $page_exists = get_page_by_path($page['post_name']);
        if (!$page_exists) {
            $page_id = wp_insert_post($page);
            
            // Set featured image for pages
            if ($page_id && has_post_thumbnail($page_id)) {
                set_post_thumbnail($page_id, get_attachment_by_title('Page Image'));
            }
        }
    }

    // Sample posts
    $posts = array(
        array(
            'post_title' => 'Guide d\'entretien 4x4',
            'post_content' => '
                <h2>Guide d\'entretien 4x4</h2>
                <p>L\'entretien régulier de votre véhicule 4x4 est essentiel pour sa performance et sa longévité.</p>
                
                <h3>Contrôle des liquides</h3>
                <p>Vérifiez régulièrement le niveau d\'huile, de liquide de refroidissement et de frein.</p>
                
                <h3>Pneus</h3>
                <p>Contrôlez la pression des pneus et l\'usure régulièrement. Les pneus 4x4 nécessitent une attention particulière.</p>
            ',
            'post_status' => 'publish',
            'post_type' => 'post',
            'post_author' => 1
        ),
        array(
            'post_title' => 'Réparation moteur courant',
            'post_content' => '
                <h2>Problèmes moteur courants</h2>
                <p>Voici les problèmes moteur les plus courants sur les véhicules 4x4 et comment les résoudre.</p>
                
                <h3>Surchauffe</h3>
                <p>Une surchauffe peut être causée par un problème de thermostat ou de liquide de refroidissement.</p>
                
                <h3>Bruit anormal</h3>
                <p>Les bruits anormaux peuvent indiquer un problème de paliers, de courroies ou de système d\'admission.</p>
            ',
            'post_status' => 'publish',
            'post_type' => 'post',
            'post_author' => 1
        )
    );

    foreach ($posts as $post) {
        $post_exists = get_page_by_path($post['post_name']);
        if (!$post_exists) {
            wp_insert_post($post);
        }
    }
}

// Initialize content on theme activation
add_action('after_setup_theme', 'xtreme_create_sample_content');