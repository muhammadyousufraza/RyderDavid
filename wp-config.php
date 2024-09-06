<?php
define( 'WP_CACHE', true );





















/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'redcbltt_wp669' );

/** Database username */
define( 'DB_USER', 'redcbltt_wp669' );

/** Database password */
define( 'DB_PASSWORD', 'tq8T((-k2(y1[pS2' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'pkqrmlny0ajwjps2soqzekla5rsebrxz5fvotu0k1fnzrlnjgd9frxjgahqr9kcb' );
define( 'SECURE_AUTH_KEY',  'stsrg5s1oejot3vhjawxikitnne2yxalmcfd0wdz81yeywnge4ydfjegvczleqfg' );
define( 'LOGGED_IN_KEY',    'yqyrixy0oeevikicqsfde8ygain2gibljcxwvibpjhzkriarckdamgkwh008yfyc' );
define( 'NONCE_KEY',        'smxbdfpicqrulvvdzy7wf53rthozcezlqmtz1drmbdapxybwuibx6sbl7rswfwng' );
define( 'AUTH_SALT',        '6jq2qenzj8vo9ssy7wqe1va26hayk0e8mvgeiigexdcue5ade3hj6l3xibv9sggl' );
define( 'SECURE_AUTH_SALT', 'iildpmsif39ky0gjru4xurplutsszqlhmqfixrmurle1cs2dk7cwnmtl6isted97' );
define( 'LOGGED_IN_SALT',   'z7dvnnjla7mfakvcgtprzbamcfdrrsqaonhgnhrbqwhmcqlavab0elpgsmh1ka1c' );
define( 'NONCE_SALT',       'mnn9q2yxpxrdwazmymc4zwgqdxiwsax4a7q0v8rnycnbvcsibgefr59hevxea7ob' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wpmx_';

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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
