<?php

// Vendor Autoloader
require_once (VENDOR_PATH . 'autoloader.php');
\Vendors\Autoloader::setIncludePath(VENDOR_PATH);
\Vendors\Autoloader::register();

// Import Site configuration
$site_cfg = parse_ini_file(APP_PATH . 'config/config.ini', TRUE);

// Slim Configuration
\Slim\Slim::registerAutoloader();

// Twig Configuration
\Slim\Extras\Views\Twig::$twigDirectory = VENDOR_PATH . 'Twig';
\Slim\Extras\Views\Twig::$twigOptions = array("debug" => true);
if (is_writable(ROOT_PATH . 'cache')) {
	\Slim\Extras\Views\Twig::$twigOptions['cache'] = ROOT_PATH . 'cache';
}

// Setup $app
$app = new \Slim\Slim( array(
	'templates.path' => APP_PATH . 'views/', 
	'debug' => false, 
	'view' => new \Slim\Extras\Views\Twig(), 
	'cookies.secret_key' => md5($site_cfg['website']['secret']), 
	'log.enabled' => false, 
	'log.writer' => new \Slim\Extras\Log\DateTimeFileWriter( array(
		'path' => ROOT_PATH . 'logs', 
		'name_format' => 'Y-m-d', 
		'message_format' => '%label% - %date% - %message%'
	))
));

// Set our app name
$app -> setName($site_cfg['website']['name']);

// Template Globals
$twig = $app->view()->getEnvironment();
$twig->addGlobal('SITE_NAME', $site_cfg['website']['name']);
$twig->addGlobal('SITE_VER', $site_cfg['website']['version']);
$twig->addGlobal('SITE_AUTHOR', $site_cfg['website']['author']);
if(isset($site_cfg['website']['ua_id'])) {
	$twig->addGlobal('GOOGLE_UA_ID', $site_cfg['website']['ua_id']);
}

// Load Controllers
if(!is_dir(APP_PATH . 'controllers/'))
	throw new Exception('Invalid controller path: ' . APP_PATH . 'controllers/');
if ($cdh = opendir(APP_PATH . 'controllers')) {
    while (false !== ($file = readdir($cdh))) {
        if ($file != "." && $file != "..") {
			require_once(APP_PATH . 'controllers/' . $file);
        }
    }
    closedir($cdh);
}

$app -> run();
