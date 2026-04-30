<?php
/**
 * WordPress Configuration for Xtreme Off-Road 4x4 Tanger
 */

// ** Database settings **
define('DB_NAME', 'xtreme4x4_db');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_HOST', '127.0.0.1');
define('DB_CHARSET', 'utf8mb4');
define('DB_COLLATE', 'utf8mb4_unicode_ci');

/**#@+
 * Authentication Unique Keys and Salts.
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 */
define('AUTH_KEY',         '~|]s%WDtc,.}3M)O@w|@w|CG<#K+|hJ+_WWP*|t]_+ON`e&_l, N4o_~q');
define('SECURE_AUTH_KEY',  'GE{YDa?r{>]eE-sj|%C#-+c|L(ZcENl|2n,o|j-$-`}42*w=4#j&c|K');
define('LOGGED_IN_KEY',    'kyM~5X&Hf}:6+[uo|Jx-5H|e|I#_+bC|i|`=R|D+_,O|dtSYC|`{_#|K');
define('NONCE_KEY',        'FM|_*uk|,6|L|R_|z|r|4|Z|8|3|W|h|J|9|2|0|1|5|7|8|K|');
define('AUTH_SALT',        '%|d|*|p|5|h|G|1|l|5|h|O|4|2|1|3|5|7|8|K|');
define('SECURE_AUTH_SALT', '|S|*|p|5|h|G|1|l|5|h|O|4|2|1|3|5|7|8|K|');
define('LOGGED_IN_SALT',   '~|]|s|%|W|d|t|s|3|M|)|O|@|w||@|w||C|G|#|K|+|h|J|+|_|W|W|*|t|]|_|+|O|N|`|e|&|_|l|,| |N|4|o|_|~|q|');
define('NONCE_SALT',       '|F|M||_*|u|k||,|6||L||R|_||z||r||4||Z||8||3||W||h||J||9||2||0||1||5||7||8||K|');

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
define('WP_DEBUG_DISPLAY', false);

/**
 * Force HTTPS in production
 */
define('FORCE_SSL_ADMIN', false); // Set to true in production with SSL

/**
 * Disable file editing for security
 */
define('DISALLOW_FILE_EDIT', true);

/**
 * Set WordPress installation path
 */
define('WP_HOME', 'http://localhost/xtream4x4');
define('WP_SITEURL', 'http://localhost/xtream4x4');

/**
 * Set content directory
 */
define('WP_CONTENT_DIR', '/var/www/html/xtream4x4/wp-content');
define('WP_CONTENT_URL', 'http://localhost/xtream4x4/wp-content');

/**
 * Set upload directory
 */
define('UPLOADS', 'wp-content/uploads');

/**
 * Set language
 */
define('WPLANG', 'fr_FR');

/**
 * Set timezone
 */
date_default_timezone_set('Africa/Casablanca');

/**
 * Set environment
 */
define('WP_ENVIRONMENT_TYPE', 'development');

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