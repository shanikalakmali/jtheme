<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link https://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'jtheme');

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
define('AUTH_KEY',         '+DLK9=gOZR|>o}Q*`CUyK<rD+![}X=H,nJ1#q!Q?OE[yJ5MiH2W%}#yzGA5=?Y=V');
define('SECURE_AUTH_KEY',  'nYHr2jlD#G?O%y}4~1S{x%$`jk$D#lgM%~&~iKXRdsN?Z=,,&kiy%gK[>[59x@9?');
define('LOGGED_IN_KEY',    'd.,)qHb9,S{my{BSCY`<Sw{3,cLNj{gWQ2O(cT2xLiY=e1FRZA@=Fyz1zc5L%?f=');
define('NONCE_KEY',        'RREW{u:*Q8W0uG$QD[S/ye>_6vdK++R!EboG>i<xk>/9>[&}bZlD>[oAtmS]7y;D');
define('AUTH_SALT',        '`>mNr#Z-4y<]Sgn*Cx^mwg.>kqRJ@e%>f4YG=_NI<PVa]1kj7 9hd_{!;Q(N|TD)');
define('SECURE_AUTH_SALT', '-LRWNSKiy+NSy.>j`y}pNfnMS(1p~L&:{_SU<9p;%yX~C{ Z6pqsJVsGlld.JW9x');
define('LOGGED_IN_SALT',   'WAn?l&?~%mm}(|tR*H=@t}yu@*NY;./}A/:ryryHEtrMtMsRlHB6HNVoB5nWgZ:e');
define('NONCE_SALT',       'MyQ$v4oG$r%e50Bc9l`cLCjsx&}h*jQ2T^fWO|uq)EUWIoj*QH}VOgQaspfQt@TH');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
