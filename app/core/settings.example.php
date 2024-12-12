<?php

//////////////////////////////// 2021
//////////////////////////////// Joystick
//////////////////////////////// Bee-Framework

// Set the system timezone
date_default_timezone_set('Europe/Madrid');

define('PREPROS', false); // Enable when working with Prepros as local server
define('PORT', '8848'); // Default Prepros port < 2020

// Language
define('SITE_LANG', $this->lng);

// Application version
define('BEE_NAME', $this->framework); // Comes from Bee.php
define('BEE_VERSION', $this->version);   // Comes from Bee.php
define('SITE_NAME', 'Clavis');    // Site name
define('SITE_VERSION', '1.0.0');          // Site version

// Base path of our project
// This constant is now configured from the settings.php file
// define('BASEPATH'   , IS_LOCAL ? '/Bee-Framework/' : '____PRODUCTION_BASEPATH___');

// System salt
// define('AUTH_SALT'  , 'BeeFramework<3'); // Migrated

// Port and site URL
define('PROTOCOL', isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http"); // Detect if using HTTPS or HTTP
define('HOST', $_SERVER['HTTP_HOST'] === 'localhost' ? (PREPROS ? 'localhost:' . PORT : 'localhost') : $_SERVER['HTTP_HOST']); // Domain or host localhost.com yourdomain.com
define('REQUEST_URI', $_SERVER["REQUEST_URI"]); // Parameters and requested path
define('URL', PROTOCOL . '://' . HOST . BASEPATH); // Site URL
define('CUR_PAGE', PROTOCOL . '://' . HOST . REQUEST_URI); // Current URL including get parameters

// Directory and file paths
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', getcwd() . DS);

define('APP', ROOT . 'app' . DS);
define('CLASSES', APP . 'classes' . DS);
define('CONFIG', APP . 'config' . DS);
define('CONTROLLERS', APP . 'controllers' . DS);
define('FUNCTIONS', APP . 'functions' . DS);
define('MODELS', APP . 'models' . DS);
define('LOGS', APP . 'logs' . DS);

define('TEMPLATES', ROOT . 'templates' . DS);
define('INCLUDES', TEMPLATES . 'includes' . DS);
define('MODULES', TEMPLATES . 'modules' . DS);
define('VIEWS', TEMPLATES . 'views' . DS);

// Absolute resource and asset paths
define('IMAGES_PATH', ROOT . 'assets' . DS . 'images' . DS);

// URL-based file or asset paths
define('ASSETS', URL . 'assets/');
define('CSS', ASSETS . 'css/');
define('FAVICON', ASSETS . 'favicon/');
define('FONTS', ASSETS . 'fonts/');
define('IMAGES', ASSETS . 'images/');
define('JS', ASSETS . 'js/');
define('PLUGINS', ASSETS . 'plugins/');
define('UPLOADS', ROOT . 'assets' . DS . 'uploads' . DS);
define('UPLOADED', ASSETS . 'uploads/');

// Database credentials
// Settings for local or development connection
define('LDB_ENGINE', 'mysql');
define('LDB_HOST', 'clavis-mysql');
define('LDB_NAME', 'clavis_db');
define('LDB_USER', 'clavis_user');
define('LDB_PASS', 'clavis_pass');
define('LDB_CHARSET', 'utf8');

// Default controller / default method / default error controller
define('DEFAULT_CONTROLLER', 'home');
define('DEFAULT_ERROR_CONTROLLER', 'error');
define('DEFAULT_METHOD', 'index');

// Located in bee_config.php file
// define('DB_ENGINE'  , 'mysql');
// define('DB_HOST'    , 'localhost');
// define('DB_NAME'    , '___REMOTE DB___');
// define('DB_USER'    , '___REMOTE DB___');
// define('DB_PASS'    , '___REMOTE DB___');
// define('DB_CHARSET' , '___REMOTE CHARTSET___');