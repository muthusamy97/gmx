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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'gyan_site_test' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '3Q8uxmomq5:9sa|2hZ*#1:kN8CFR;W1DMYtX5WV{2oSTdu7rGB1PF%e.sCrBV,d!' );
define( 'SECURE_AUTH_KEY',  '[)H)p%lai]{#()Q9,{6waP-?AO1m;W5KwRUgH6PCA:;hMK=UGl0]UeMBPvYH//(^' );
define( 'LOGGED_IN_KEY',    't%1< aM`v&)Juz0#;M|?y-=xsyBAF5/wg;5o!(kJf^^ !LXDk66d(8F$0oq,0Cct' );
define( 'NONCE_KEY',        'e;WQ=xXNB,S];QR3VTZm[ie{qPy8+(R.$(1n>1!$c%)B|+ge/h#}Q.#B{C HR673' );
define( 'AUTH_SALT',        ':S$hv7`t7BGMS6`]ZJ_,fn<}s~QC8_?zU?w(U@SoS_T4$|Vg1JV/hyk6K~&Mj0%H' );
define( 'SECURE_AUTH_SALT', 'EBn+K!&1Ec?019$_b~Z2r&5cU1>G+|R#n]]yY]y!W%6uTLcNWz,Dnn7~1OhF6YKx' );
define( 'LOGGED_IN_SALT',   '0IsNo9wYbyzIjx_wv5A72PcFl/)WzUF>B;`B_0:7Mb/#VKcUspv>U_=Hyicrqx+d' );
define( 'NONCE_SALT',       '/N1Od8O,8=+xRnw$M +Yw3nP cwtbnNQwFrwjsRb8jwwjVv{oe6*-pmMi9AMEh @' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
define('WP_ALLOW_REPAIR', true);