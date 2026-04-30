<?php
/**
 * WordPress configuration file
 */

// ** Database settings **
define('DB_NAME', 'xtreme_offroad_db');
define('DB_USER', 'xtreme_user');
define('DB_PASSWORD', 'Xtreme2024!');
define('DB_HOST', 'localhost');
define('DB_CHARSET', 'utf8');
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 */
define('AUTH_KEY',         'put your unique phrase here');
define('SECURE_AUTH_KEY',  'put your unique phrase here');
define('LOGGED_IN_KEY',    'put your unique phrase here');
define('NONCE_KEY',        'put your unique phrase here');
define('AUTH_SALT',        'put your unique phrase here');
define('SECURE_AUTH_SALT', 'put your unique phrase here');
define('LOGGED_IN_SALT',   'put your unique phrase here');
define('NONCE_SALT',       'put your unique phrase here');

/**#@-*/

/**
 * WordPress Database Table prefix.
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 */
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', true);

/**
 * Force HTTPS in production
 */
define('FORCE_SSL_ADMIN', true);

/**
 * Disable file editing for security
 */
define('DISALLOW_FILE_EDIT', true);

/**
 * Set WordPress installation path
 */
define('WP_HOME', 'https://xtremeoffroad4x4-tanger.com');
define('WP_SITEURL', 'https://xtremeoffroad4x4-tanger.com');

/**
 * Set content directory
 */
define('WP_CONTENT_DIR', '/var/www/html/xtream4x4/wp-content');
define('WP_CONTENT_URL', 'https://xtremeoffroad4x4-tanger.com/wp-content');

/**
 * Set upload directory
 */
define('UPLOADS', 'wp-content/uploads');

/**
 * Set cookie domain
 */
define('COOKIE_DOMAIN', '.xtremeoffroad4x4-tanger.com');

/**
 * Set language
 */
define('WPLANG', 'fr_FR');

/**
 * Set timezone
 */
define('TIMEZONE', 'Africa/Casablanca');

/**
 * Set environment
 */
define('WP_ENVIRONMENT_TYPE', 'production');

/**
 * Disable auto updates
 */
define('WP_AUTO_UPDATE_CORE', false);

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if (!defined('ABSPATH')) {
    define('ABSPATH', dirname(__FILE__) . '/');
}

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');