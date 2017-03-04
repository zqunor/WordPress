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
define('DB_NAME', 'blog');

/** MySQL database username */
define('DB_USER', 'zqunor');

/** MySQL database password */
define('DB_PASSWORD', 'zqunor@zqblogs.com');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

define('WPLANG','zh_CN');
/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '*]Xrxn<u ikv_:Z,?h#<_`jwb{uX#/a!atG)^9ek$$*&OMe(qcm-Ba_pxIXp?bi:');
define('SECURE_AUTH_KEY',  'wI|rP6nw{-z+h%&oE3:}|a-,1=m09n4(4~yTRqCfX!`epBRr|I5$;V.%$>N.t,r5');
define('LOGGED_IN_KEY',    '^emGFSk(}#(eM;^`]-BeTfNag3C/^7biO_-`-x?WyuG3[{T0Vw%]BDI_uCWdUKhu');
define('NONCE_KEY',        '!QDLU0.;+}l*9mv9k2(5dn1$|WV*>j>9B9ZI&q[pHB=!1qqq3]G$q%!U;f.56S~~');
define('AUTH_SALT',        'wY$ j@:c8_IyY=}jR[k5+?VQz;xa2FQ]M?Nn1>Jl(@bhFfBJEkU!$Zmn-Xt@_;6(');
define('SECURE_AUTH_SALT', 'nUL<N:x0!H#eK75B_hwU>`<];NufRE/YupjhlVG)SG]c1(@g~!%e>J/Im%0yjK`o');
define('LOGGED_IN_SALT',   '^[E>Gkq3L+g5t0)<HH` /LpS3^=dzKA:IkT/DF<zR/:{.$8KOZh](1{&v(ya/p[L');
define('NONCE_SALT',       'mr{0]$,cz`8PIGp0SMGTX#s!xl;f`$3I [G/o5+fb!uk=+u9!~Xsuw}Xb;w6LZ>g');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'zqblogs_';

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
