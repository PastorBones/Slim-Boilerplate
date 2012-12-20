<?php

/**
 * This file contains routes that control, setup, and load views found in views/home/
 */
 
$app->get('/', function () use ($app) {
	$app->render('home/index.html');
});
