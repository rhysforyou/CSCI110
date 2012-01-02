<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wordpress');

/** MySQL database username */
define('DB_USER', 'rpowell');

/** MySQL database password */
define('DB_PASSWORD', 'floopthepig');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY',         '+zYE/#wJUTM,nRC8ne`7;/<_P27LC-f0vCDo=uV/-U&s@p@Y+wv%M)Ldl*@C;B|[');
define('SECURE_AUTH_KEY',  '!}yXh=Nwh)+HjppiU8rYHD[%VpNx*`?P(c7j7N}?,-Z+eu8ir<1jce.Q`r/6!G=M');
define('LOGGED_IN_KEY',    '$-H7|J|;qS9_8 (z`=f9unMfG1H?%O3)L~W>xo4~p8 e+)^%z}Q9XNBWYx?/i)`c');
define('NONCE_KEY',        '!n{>40ohFTIT*I}|~&aLe5,hA&qkj>tr![ze6:/g4avv@xz@s&8p^Dsh3A#r[US_');
define('AUTH_SALT',        ';}1!N>(T/C_jPC6]hcOsXOl:jg9LonHcF>k:7$}OV{4SSeU>GJETqIqX([D,0(=|');
define('SECURE_AUTH_SALT', 'We0pf|Wns2%P(m?H34h>&;KbTH-+^R|=oxZ7}>+yA#Kr0-c+I|ruvsIuJa:OtmX3');
define('LOGGED_IN_SALT',   'G/(A e|^6L&;PBI>MI7L-GraPuOh2r-swUM!K9)bRKU<+uY[p;#q9z<:f,|Xa#]>');
define('NONCE_SALT',       'ygWpKaxui.E_4B#Am~Sk Y)+N_[lkQfXMJ0p.+vl&&_@8|GJw)^tC~v3nvv<JIb ');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
