<?php
// Show variables
function e($vars)
{
	echo "<pre>\n";
	var_export($vars);
	echo "</pre>\n";
	ob_end_flush();
	ob_start();
}

// Global valiables
function g($path)
{
	$path = explode('.', $path);
	$g = $GLOBALS;
	foreach ($path as $key) {
		if (!isset($g[$key])) {
			return null;
		}
		$g = $g[$key];
	}
	return $g;
}

// Cartesian
function cartesian($array)
{
	$shift = array_shift($array);
	foreach ($shift as $value) {
		if (count($array) > 0) {
			foreach (cartesian($array) as $return) {
				$row = "{$value}/{$return}";
				$cartesian[] = '/'.trim(preg_replace('/\/+/', '/', $row), '/');
			}
		} else {
			$row = $value;
			$cartesian[] = $row;
		}
	}
	return $cartesian;
}

// Fallback
function fallback($array)
{
	foreach (cartesian($array) as $fallback) {
		if (file_exists($fallback)) {
			return $fallback;
		}
	}
	if (error_reporting() !== 0) {
		$backtrace = debug_backtrace()[1];
		error_handler(E_USER_ERROR, "{$backtrace['function']}(".print_r($backtrace['args'], true)."): File not found", $backtrace['file'], $backtrace['line']);
	}
	return null;
}

// Error handler
function error_handler($errno, $errstr, $errfile, $errline)
{
	if (error_reporting() === 0) return;
	ob_end_clean();
	$vars = ['class' => 'errors', 'method' => 'index', 'errno' => $errno, 'errstr' => $errstr, 'errfile' => $errfile, 'errline' => $errline];
	load_view('errors', 'template', $vars);
	exit(1);
}

// Request
function request($path_info)
{
	require_once 'vendor/autoload.php';
	load_helper('view');
	$params = trim($path_info, '/') !== '' ? explode('/', trim($path_info, '/')) : [];
	$class = count($params) > 0 ? array_shift($params) : 'welcome';
	$method = count($params) > 0 ? array_shift($params) : 'index';
	load_controller(ucfirst($class));
	$controller = new $class();
	if (!method_exists($controller, $method)) {
		$backtrace = debug_backtrace()[0];
		error_handler(E_USER_ERROR, "{$backtrace['function']}('{$path_info}'): class '".ucfirst($class)."' does not have a method '{$method}'", $backtrace['file'], $backtrace['line']);
	}
	$vars = call_user_func_array([$controller, $method], $params);
	return ['class' => $class, 'method' => $method] + (is_array($vars) ? $vars : []);
}

// Load controller
function load_controller($class)
{
	require_once fallback([g('packages'), ['controllers'], ["{$class}.php", 'crud.php']]);
}

// Load view
function load_view($class, $name, $vars = [])
{
	require fallback([g('packages'), ['views'], [$class, 'crud', ''], ["{$name}.php"]]);
}

// Load helper
function load_helper($name)
{
	require_once fallback([g('packages'), ['helpers'], ["{$name}.php"]]);
}

// Load class
function load_class($class)
{
	require_once fallback([g('packages'), ['src'], ["{$class}.php"]]);
}
