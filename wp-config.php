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
define( 'DB_NAME', 'cut-link' );

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
define( 'AUTH_KEY',         'WOAg-1 q(k8Am<=*H/ 2g`*]T:k=@]FHDk,;J~a2cf|BJicK-2CC}Js/W-|EEsg)' );
define( 'SECURE_AUTH_KEY',  '&4p}8)yy__p~FyT8QK*`[ss<BjH2u:Vf}@3D9A65|opT|b8 GaB>a)mt}sO(%diu' );
define( 'LOGGED_IN_KEY',    'bt9{]$}*wct_2]^jPsvI/d?(hP$1rj]tC][FRvw:+%>jd^{@z:AuRmcEa?qR}Mmk' );
define( 'NONCE_KEY',        'zcr_DN;PM^WhqgcmM#0vIvf>27b[zoNX0<-P!eM)9B0>rfXC[k<=<4p/7>Vf8fXN' );
define( 'AUTH_SALT',        ')MyE>X^UlL0b6$DvIFM@H&=nDL}wMJ#!)K!M0y`GqtF(>EF:E}9BcvM~vdupk;zJ' );
define( 'SECURE_AUTH_SALT', '1XP|vcRV%gzCD/AK8HnIyIW~^)Nl^V[2))4yC:[a!C$?o~TOy3,|69e<>5SiRQl.' );
define( 'LOGGED_IN_SALT',   'k48F$fss0{.[}*I%+B$ONKd{7u9`sfwak pI.7>,ea%o5~Io/nx>kxUFkV8ny|`.' );
define( 'NONCE_SALT',       'i-/{YR~h GdA^o{NKfKAUyW}]vd(lu(>u2hOo74p;{#Rfj;d&>%~e}T60n;DG}qQ' );

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
