<?php

/**
 * Constants migrated from bee_config.php
 * to this file for when a system update or fix needs to be performed,
 * the database credentials are not exposed or accidentally modified in the process,
 * as well as the basepath and other constants that require special configuration in production
 */
define('IS_LOCAL', in_array($_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1']));
define('BASEPATH', IS_LOCAL ? '/' : '____PRODUCTION_BASEPATH___'); // Must be changed to your project path in production and development
define('IS_DEMO', false);

// Settings for production or real server connection
define('DB_ENGINE', 'mysql');
define('DB_HOST', 'localhost');
define('DB_NAME', '___REMOTE DB___');
define('DB_USER', '___REMOTE DB___');
define('DB_PASS', '___REMOTE DB___');
define('DB_CHARSET', '___REMOTE CHARTSET___');

/** Extra constants to be used */

// For future use of Gmaps or similar implementation
define('GMAPS', '__TOKEN__');

// Cookie names for user authentication
// the value can be changed when using
// multiple Bee instances for different projects and cookies don't cause issues due to repeated names
define('AUTH_TKN_NAME', 'bee__cookie_tkn');
define('AUTH_ID_NAME', 'bee__cookie_id');

// Salt used to add security to password hashing or similar depending on required use
define('AUTH_SALT', 'BeeFramework<3');

// In case of online payment implementation to define if working with payment gateways in sandbox/test or production mode
define('SANDBOX', false); // live or sandbox
