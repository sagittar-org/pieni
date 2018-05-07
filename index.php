<?php
require_once 'vendor/autoload.php';
const FCPATH = __DIR__;
$packages = [
	FCPATH.'/application',
	FCPATH.'/vendor/pieni/con',
	FCPATH.'/vendor/pieni/pieni',
];
$req = new \pieni\Req();
$req->response($req->request(php_sapi_name() !== 'cli' ? $_SERVER['PATH_INFO'] : $argv[1]));
