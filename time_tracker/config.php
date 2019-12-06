<?php
/** The name of the database for WordPress */
//define('DB_NAME', 'life2atz_tracker');
define('DB_NAME', 'flance_v3');


/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
		$uri = 'https://';
	} else {
		$uri = 'http://';
	}
	$uri .= $_SERVER['HTTP_HOST']."/time_tracker/";

define('WEB', $uri);
define('WEB_MED', $uri.'mediafile/');
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');
if ( !defined('MEDPATH') )
	define('MEDPATH',ABSPATH.'mediafile/');

?>
