<?php
const FCPATH = __DIR__;
$packages = [
	FCPATH.'/application',
	FCPATH.'/vendor/pieni/pieni',
];
require_once FCPATH.'/vendor/pieni/pieni/helpers/core.php';

// Error handling
set_error_handler('error_handler');

// Start output buffer
ob_start();

// Request and Response
$vars = request(isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '/');
load_view($vars['class'], 'template', $vars);

// Flush output buffer
ob_end_flush();
