<?php
// Define packages
const FCPATH = __DIR__;
$packages = [
	FCPATH.'/application',
	FCPATH.'/vendor/pieni/pieni',
];

// Load core helper
require_once FCPATH.'/vendor/pieni/pieni/helpers/core.php';

// Request
$vars = request(isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '/');

// Response
load_view(g('request.class'), 'template', $vars);
