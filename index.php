<?php
// Define packages
const FCPATH = __DIR__;
$packages = [
	FCPATH.'/application',
	FCPATH.'/vendor/pieni/pieni',
];

// Load core helper
require_once FCPATH.'/vendor/pieni/pieni/helpers/core.php';

// Request and response
response(request(isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '/'));
