<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'kartingne' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

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
define( 'AUTH_KEY',         'V=7Yc)9eTO,QDy3[.6-CX;?,e0W[)9vpMC;~38T=Kf4IG,[3PFsyyAWJnn%d|!Y(' );
define( 'SECURE_AUTH_KEY',  '(6[M{Z{>c1N[;88}&1yR)fV0oeLD?7JEW`eJk$(|O9A.69?]@m~To/D(xK]2Dbf0' );
define( 'LOGGED_IN_KEY',    '/ q`3[|}$Fc(#C,N&iVlbPmH bn46GE1cxpiTT<XOkh2i+wnu9H@Cy$Fa@1,u[$q' );
define( 'NONCE_KEY',        '>1a;-7wRcYrS[yHnxRj?Iq1.G3W|ts)(Gm RH3rkw!&?cD-@[D(5b 5wnuTUXanZ' );
define( 'AUTH_SALT',        'tFN*I,R /~ZN|y@#!8eI{=kl3-#]Lv!lTuUxOljt/$9&YC5ERoMM@04Ui;V)n;y^' );
define( 'SECURE_AUTH_SALT', 'an~H}P-V8i9`<KFN^X}5=/HK)Zu$U*~`_xY=~]PZI#K+rv?x$B1FHR!#^Xk#!pi@' );
define( 'LOGGED_IN_SALT',   '(Z>->K8zlNSI^1EORwH{cKWz$u.&KEz9d[L5k8gk~Q$6)c#Zn-b9DXxrwD(sLx~,' );
define( 'NONCE_SALT',       '@5R-?3c,1V=HzU4q(M.x`9`SrMwS+Q/`5:yCLHh$E2KOh4$;aWFBr9ta|bM4HoLw' );

/**#@-*/

/**
 * WordPress database table prefix.
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

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
