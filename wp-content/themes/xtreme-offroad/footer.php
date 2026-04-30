<?php
/**
 * The footer for our theme.
 */
?>
        </main><!-- #main -->
    </div><!-- #primary -->

    <footer id="colophon" class="site-footer">
        <div class="footer-container">
            <div class="footer-business-info">
                <h3>Xtreme Off-Road 4x4 Tanger</h3>
                <p>47 Av. Yakoub El Mansour, al mansour, Tanger 90000</p>
                <p>06 61 72 06 63</p>
                <p>Spécialiste en réparation et entretien 4x4</p>
            </div>
            
            <div class="footer-links">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'footer',
                    'menu_id' => 'footer-menu',
                    'menu_class' => 'footer-menu',
                    'fallback_cb' => false
                ));
                ?>
            </div>
            
            <div class="footer-social">
                <a href="https://instagram.com" target="_blank" rel="noopener">Instagram</a>
                <a href="https://facebook.com" target="_blank" rel="noopener">Facebook</a>
            </div>
        </div>
        
        <div class="copyright">
            <p>&copy; <?php echo date('Y'); ?> Xtreme Off-Road 4x4 Tanger. Tous droits réservés.</p>
        </div>
    </footer><!-- #colophon -->
    </div><!-- #page -->

    <?php wp_footer(); ?>
</body>
</html>