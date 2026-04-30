<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title('|', true, 'right'); ?></title>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <!-- Top Bar -->
    <div class="top-bar">
        <div class="top-bar-left">
            <a href="tel:+212661145645"><i class="fas fa-phone"></i> +212 (0) 661 145 645</a>
            <a href="tel:+212524355558"><i class="fas fa-phone"></i> +212 (0) 524 355 558</a>
            <a href="mailto:xtreme4x4@yahoo.fr"><i class="fas fa-envelope"></i> xtreme4x4@yahoo.fr</a>
        </div>
        <div class="top-bar-right">
            <a href="#login" class="login-link"><i class="fas fa-user"></i> Connexion</a>
            <span style="color: #555;">|</span>
            <a href="<?php echo home_url('/en'); ?>">
                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAALCAMAAABBPP0LAAAAmVBMVEViZsViZMJiYrf9gnL8eWrlYkjgYkjZYkj8/PujwPybvPz4+PetraBEgfo+fvo3efkydfkqcvj8Y2T8UlL8Q0P8MzP9k4Hz8/Lu7u4DdPj9/VrKysI9fPoDc/EAZ7z7IiLHYkjp6ekCcOTk5OIASbfY/v21takAJrT5Dg6sYkjc3Nn94t2RkYD+y8KeYkjs/v7l5fz0dF22YkjWvcOLAAAAgElEQVR4AR2KNULFQBgGZ5J13KGGKvc/Cw1uPe62eb9+Jr1EUBFHSgxxjP2Eca6AfUSfVlUfBvm1Ui1bqafctqMndNkXpb01h5TLx4b6TIXgwOCHfjv+/Pz+5vPRw7txGWT2h6yO0/GaYltIp5PT1dEpLNPL/SdWjYjAAZtvRPgHJX4Xio+DSrkAAAAASUVORK5CYII=" alt="English" class="eng-flag">
            </a>
        </div>
    </div>

    <!-- Main Header -->
    <header>
        <a href="<?php echo home_url(); ?>">
            <img src="https://atraxion-4x4-maroc.com/wp-content/uploads/2025/08/logo.svg" alt="Xtreme Off-Road 4x4 Tanger" class="logo">
        </a>
        <nav>
            <a href="<?php echo home_url('/programmes-packages'); ?>">Nos Packages</a>
            <a href="<?php echo home_url('/location-equipement'); ?>">Location</a>
            <a href="<?php echo home_url('/preparation-mecanique'); ?>">Préparation</a>
            <a href="<?php echo home_url('/formations'); ?>">Formation</a>
            <a href="<?php echo home_url('/a-propos'); ?>">À Propos</a>
            <a href="<?php echo home_url('/contact'); ?>">Contact</a>
        </nav>
    </header>
