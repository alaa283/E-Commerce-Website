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
define( 'DB_NAME', 'wordpress_3' );

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
define( 'AUTH_KEY',         '273s{h,d;`3:_cg9wznBW0!D0#?7*1w<uo*0}LF.5PrXs_r@)`A/%+EzO|=1(eOE' );
define( 'SECURE_AUTH_KEY',  'fSB(>AW%U>m/Y&~Ux $~(Pqlzj]:x<A>)FbRbec$v6pL/7P;HV}taxo P28|7L*E' );
define( 'LOGGED_IN_KEY',    ':Q+(d?#K@B/aJR{P.e4].2ZTk;}aXZeJ*TG+Wx]9gOANdzw)VDS7*zCdy:2xR819' );
define( 'NONCE_KEY',        '4Y4c!=kq!:8<NU22g@_nqZwTdQ3wd[VXk<=&wXE{-X!A_+JQDwn+c*hz{[F>)?>i' );
define( 'AUTH_SALT',        'Z=)[m_0ad<?oJ]~_d=r#|{Wx`D)x**([8!6MyriagFarA4JZfwSsYq]Lb;K&O.6&' );
define( 'SECURE_AUTH_SALT', '&0(LZZi)p1l~PFh@zy aIf|ti$ |;vy7cl43o9xwy*T7}_>r,B$1L<N.bibXA8^_' );
define( 'LOGGED_IN_SALT',   '[kK<{)tIYLWQ=!J2UCu M:)IO_D?8Wfpqw?~}S9t9VTWFl/w0!q0NE|q*v[=2xET' );
define( 'NONCE_SALT',       'O,1{/::TucN%!/.=lYbr31/!O)!!=O,+s(b4)72e_@%^H?RR1Bw*_ M9jwCSJ;}{' );

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
