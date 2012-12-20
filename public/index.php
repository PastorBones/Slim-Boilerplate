<?php

/* Set our script root paths */
$webroot = 'http://' . $_SERVER['HTTP_HOST'] . str_replace("\\", "/", dirname(getenv("SCRIPT_NAME")));
$webroot .= ($webroot[strlen($webroot) - 1] != '/') ? '/' : '';
define('WS_ROOT', $webroot);

define('ROOT_PATH', realpath(str_replace("\\", "/", realpath(dirname(__FILE__))) . '/../') . '/');
define('VENDOR_PATH', ROOT_PATH . 'vendor/');
define('PUBLIC_PATH', ROOT_PATH . 'public/');
define('APP_PATH', ROOT_PATH . 'app/');

require_once(APP_PATH . 'bootstrap.php');
