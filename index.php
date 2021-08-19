<?php
// Version
define('VERSION', '3.0.3.7');

// Configuration
if (is_file('config.php')) {
	require_once('config.php');
}
error_reporting(0);
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);

// Install
if (!defined('DIR_APPLICATION')) {
	header('Location: install/index.php');
	exit;
}

// Startup
require_once(DIR_SYSTEM . 'startup.php');

start('catalog');