<?php
/**
 * Footer template
 */
?>
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