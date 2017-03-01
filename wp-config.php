<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'ttg');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '6vjXS&0[RNFZe>ayaeA/v$L@q>W%Mu[}j]1xc%Z(N4+(C:zX8l]$KceHmD${,XTc');
define('SECURE_AUTH_KEY',  'Cc:p%9S,05tfv)]C@FErF8M.P8%houG.A]}f7d?&]D)W9&4VgW+$VyG I}?9|u5D');
define('LOGGED_IN_KEY',    'DhyYop#/>Wrt4PPHyzxikkf0i$;{6fg.~L?s}|t*nx>iOO#J-TW8=$&Up%|U8W6e');
define('NONCE_KEY',        '6~k}&@b52`ez*)>F,v_}^M&V&xqYaWAZ}]~o=cdY>>ss|)M7+1L;Kard>!FeoCs7');
define('AUTH_SALT',        '2YxQH%r{i0L!po8q^.xAvZZ/iv:~R@TGP8jQ)TJ4d,hcg$<Ydr7VTviQ!t-Li&:t');
define('SECURE_AUTH_SALT', 'W$hi/d=&yW_1H)q3ozDNB:|2)vyz2<9$z2N@wxNoIV9>/3m+V,aOI$~Nnld[Tgy.');
define('LOGGED_IN_SALT',   'KzW(=x#@M#>r?5z JOHL9n]7iD`dj<[a*z~4WwfL,Ahz <:</%eUU{~*!N%B>[ff');
define('NONCE_SALT',       ')2EBmT56EX)W6GhbA|[ tmgN@Es,DC[%<}K/A84Cf.sG6uaX|r,Ef8D8LHlyzjm0');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
