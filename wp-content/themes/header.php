<?php
/**
 * Header template
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    
    <div id="page" class="site">
        <!-- Header -->
        <header id="masthead" class="site-header">
            <div class="header-container">
                <div class="logo">
                    <a href="<?php echo esc_url(home_url('/')); ?>">
                        <h1><?php echo esc_html(xtreme_get_site_title()); ?></h1>
                    </a>
                </div>
                
                <nav id="site-navigation" class="main-navigation">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'menu_class' => 'nav-menu',
                        'fallback_cb' => 'wp_page_menu'
                    ));
                    ?>
                </nav>
                
                <div class="contact-info">
                    <span class="phone"><?php echo esc_html(xtreme_get_phone_number()); ?></span>
                    <span class="location"><?php echo esc_html(xtreme_get_address()); ?></span>
                </div>
            </div>
        </header>

        <div id="content" class="site-content">
            <?php if (have_posts()) : ?>
                <?php while (have_posts()) : the_post(); ?>
                    <?php get_template_part('template-parts/content', get_post_format()); ?>
                <?php endwhile; ?>
            <?php else : ?>
                <?php get_template_part('template-parts/content', 'none'); ?>
            <?php endif; ?>
        </div>

        <footer id="colophon" class="site-footer">
            <div class="footer-container">
                <div class="footer-business-info">
                    <h3><?php echo esc_html(xtreme_get_site_title()); ?></h3>
                    <p><?php echo esc_html(xtreme_get_address()); ?></p>
                    <p><?php echo esc_html(xtreme_get_phone_number()); ?></p>
                    <p>Spécialiste en réparation et entretien 4x4</p>
                </div>
                
                <div class="footer-links">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'footer',
                        'menu_class' => 'footer-menu',
                        'fallback_cb' => false
                    ));
                    ?>
                </div>
                
                <div class="footer-social">
                    <a href="<?php echo esc_url(xtreme_get_instagram_url()); ?>" target="_blank" rel="noopener">Instagram</a>
                </div>
            </div>
            
            <div class="copyright">
                <p>&copy; <?php echo date('Y'); ?> <?php echo esc_html(xtreme_get_site_title()); ?>. Tous droits réservés.</p>
            </div>
        </footer>
    </div>

    <?php wp_footer(); ?>
</body>
</html>