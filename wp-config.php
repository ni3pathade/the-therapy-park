<?php
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
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wellness_pro_db' );

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
define('AUTH_KEY',         'H=v2tY`KzgDl-W:(-H/jDA/W8QKlM0a9pj+Gv{X<eVQ8o_tORL>m-:TKZreH%l9G');
define('SECURE_AUTH_KEY',  'O$$socbf8rB&1S|Ru`6Q)gS741f|+aZ:J<ZQb)ZP8;KV}Z(~=Y.>MO&-; u^xP{<');
define('LOGGED_IN_KEY',    'o?QPWf]WiHfsty1+ &1clrlBP+Ee}%a_Gn5{fR1,Jqdca0aa||M! HDcfr@+J43#');
define('NONCE_KEY',        'Y<9FLg?XK:p%TQc9bnYE^BRiWr+9G/(]!EDF |~21 .&K9@u-Nxmx|]?,e0-$~<{');
define('AUTH_SALT',        'mpUgg/8qY<HwB{T]b<svaMcl<j=M`HSX-~8^TJ<Nu`r78/!lPvONJDf#.-X6!>6=');
define('SECURE_AUTH_SALT', '1JQ6x+=_dio0AI9pBFtG]!`wCYT8~_`_66C$*vc?jM]jj2a-+D2K:K+jUCQEs7LE');
define('LOGGED_IN_SALT',   '$H[QxP)8j6exXF2Qs%,5G0g=&Tg>?W8SSkVPd3og#oQ/aF>@4RK|sJt+B51Hv>O@');
define('NONCE_SALT',       'yAxpsgS:/2fo^Nl%HbITm`h@a0QZ&ppWKkRjYj$I;.i)6Co7LZ]J/kIQp-.Vl6$]');

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
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
