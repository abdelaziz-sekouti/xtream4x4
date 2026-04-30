<?php
/**
 * The header for our theme.
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
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
                        <h1 class="site-title"><?php bloginfo('name'); ?></h1>
                    </a>
                </div>
                
                <nav id="site-navigation" class="main-navigation">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'menu_id' => 'primary-menu',
                        'menu_class' => 'nav-menu',
                        'fallback_cb' => 'wp_page_menu'
                    ));
                    ?>
                </nav>
                
                <div class="contact-info">
                    <span class="phone">06 61 72 06 63</span>
                    <span class="location">Tanger, Maroc</span>
                </div>
            </div>
        </header><!-- #masthead -->

        <div id="content" class="site-content">
