<?php

//Begin Really Simple SSL session cookie settings
@ini_set('session.cookie_httponly', true);
@ini_set('session.cookie_secure', true);
@ini_set('session.use_only_cookies', true);
//END Really Simple SSL

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

/* Password JWT */

define('JWT_AUTH_SECRET_KEY', 'Los elefantes son rosados');

// ** Database settings - You can get this info from your web host ** //

/** The name of the database for WordPress */

define( 'DB_NAME', 'bitnami_wordpress' );


/** Database username */

define( 'DB_USER', 'bn_wordpress' );


/** Database password */

define( 'DB_PASSWORD', 'd7bbb93e65f812bd6b3b18a4cdaaa9a62623171a888b56a4ffce91c872a866c6' );


/** Database hostname */

define( 'DB_HOST', 'localhost:3306' );


/** Database charset to use in creating database tables. */

define( 'DB_CHARSET', 'utf8' );


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

define( 'AUTH_KEY',         'n/pwKdN,Nm~OPK7tQ0VjxPAg$g}VI&OG6kv{e}]5VI0 K@N)2;_7fi&;df__tS_5' );

define( 'SECURE_AUTH_KEY',  'p&ru1,w*{o2q>Xf:X4T8c~p(0V`roaE;*)=)njiB)yKVx<S:N9SJgTXOI!t]b$Hk' );

define( 'LOGGED_IN_KEY',    '6nBDBY&kf2_h^N-:G[4y@^Dz)dQ(ZY6z4[%yt@bmQw!td6RBcOO4=+{KFpCi?9O3' );

define( 'NONCE_KEY',        'M7HerSyzj)`D~EvI&Z@dq^v6mY~14qF6MJaWm=Vw8/e2J8!alb<BUCd<g;0CQlAu' );

define( 'AUTH_SALT',        '/u6@aqby?;F*Rv^?a9L6 ?7/I7Jl0R{NjQ?JkbW;z{HRp, b@4+.z %@%b?F]/e+' );

define( 'SECURE_AUTH_SALT', '~8ZhN=?zAa%GyyfEPvsoO]@pKEVa!dxh5nA-WhF`Lvcp)mJDVD.=,WG]3]KV*#gi' );

define( 'LOGGED_IN_SALT',   'W(m$2Skp2R`lpYzRg1,b@.AV~`Ek[]vu0F{fU0BYMdDGC@PlS>PN)Pg|[bdDMtj4' );

define( 'NONCE_SALT',       'mj_U<([L-_[g.RxB7c~nb)Mzr)D0S#:[^7*,w7brk N)km5nN@b%>|CTtY=k&xDA' );


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

define( 'WP_DEBUG', true );


/* Add any custom values between this line and the "stop editing" line. */




define( 'FS_METHOD', 'direct' );
/**
 * The WP_SITEURL and WP_HOME options are configured to access from any hostname or IP address.
 * If you want to access only from an specific domain, you can modify them. For example:
 *  define('WP_HOME','https://example.com');
 *  define('WP_SITEURL','https://example.com');
 *
 */
if ( defined( 'WP_CLI' ) ) {
	$_SERVER['HTTP_HOST'] = '127.0.0.1';
}

define('WP_HOME','https://' . $_SERVER['HTTP_HOST'] . '/' );
define('WP_SITEURL','https://' . $_SERVER['HTTP_HOST'] . '/' );
define( 'WP_AUTO_UPDATE_CORE', 'minor' );
/* That's all, stop editing! Happy publishing. */


/** Absolute path to the WordPress directory. */

if ( ! defined( 'ABSPATH' ) ) {

	define( 'ABSPATH', __DIR__ . '/' );

}


/** Sets up WordPress vars and included files. */

require_once ABSPATH . 'wp-settings.php';

/**
 * Disable pingback.ping xmlrpc method to prevent WordPress from participating in DDoS attacks
 * More info at: https://docs.bitnami.com/general/apps/wordpress/troubleshooting/xmlrpc-and-pingback/
 */
if ( !defined( 'WP_CLI' ) ) {
	// remove x-pingback HTTP header
	add_filter("wp_headers", function($headers) {
		unset($headers["X-Pingback"]);
		return $headers;
	});
	// disable pingbacks
	add_filter( "xmlrpc_methods", function( $methods ) {
		unset( $methods["pingback.ping"] );
		return $methods;
	});
}