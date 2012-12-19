<?php

/* Set our script root paths */
$webroot = 'http://' . $_SERVER['HTTP_HOST'] . str_replace("\\", "/", dirname(getenv("SCRIPT_NAME")));
$webroot .= ($webroot[strlen($webroot) - 1] != '/') ? '/' : '';
define('WS_ROOT', $webroot);

define('ROOT_PATH', realpath(str_replace("\\", "/", realpath(dirname(__FILE__))) . '/../') . '/');
define('VENDOR_PATH', ROOT_PATH . 'vendors/');
define('PUBLIC_PATH', ROOT_PATH . 'public/');
define('VIEW_PATH', ROOT_PATH . 'templates/');

require_once(ROOT_PATH . 'bootstrap.php');
