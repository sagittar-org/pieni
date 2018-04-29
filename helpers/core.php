<?php
// Load view
function load_view($class, $name, $vars = [])
{
	require fallback([g('packages'), ['views'], [$class, 'crud', ''], ["{$name}.php"]]);
}

// Request
function request($path_info)
{
	set_error_handler('error_handler');
	require_once FCPATH.'/vendor/autoload.php';
	load_helper('view');
	$request['params'] = trim($path_info, '/') !== '' ? explode('/', trim($path_info, '/')) : [];
	$request['class'] = count($request['params']) > 0 ? array_shift($request['params']) : 'welcome';
	$request['method'] = count($request['params']) > 0 ? array_shift($request['params']) : 'index';
	load_controller(ucfirst($request['class']));
	$controller = new $request['class']($request);
	if (!method_exists($controller, $request['method'])) {
		trigger_error(json_encode(debug_backtrace()[0] + ['message' => "class '".ucfirst($request['class'])."' does not have a method '{$request['method']}'"]), E_USER_ERROR);
	}
	$vars = call_user_func_array([$controller, $request['method']], $request['params']);
	return $request + (is_array($vars) ? $vars : []);
}

// Load controller
function load_controller($class)
{
	require_once fallback([g('packages'), ['controllers'], ["{$class}.php", 'Crud.php']]);
}

// Load helper
function load_helper($name)
{
	require_once fallback([g('packages'), ['helpers'], ["{$name}.php"]]);
}

// Fallback
function fallback($array)
{
	foreach (cartesian($array) as $fallback) {
		if (file_exists($fallback)) {
			return $fallback;
		}
	}
	trigger_error(json_encode(debug_backtrace()[0] + ['message' => 'Fallback failed']), E_USER_ERROR);
	return false;
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

// Error handler
function error_handler($level, $message, $file, $line)
{
	if (($level & error_reporting()) === 0) return;
	$vars = json_decode($message, true);
	if ($level !== E_USER_ERROR || json_last_error() !== JSON_ERROR_NONE) {
		$vars = ['message' => $message, 'file' => $file, 'line' => $line];
	}
	if (function_exists('load_view')) {
		load_view('errors', 'template', $vars);
	} else {
		print_r($vars);
	}
	exit(1);
}

// Hyper link for public directory
function public_href($path, $return = false)
{
	$url = preg_replace('#^'.FCPATH.'/#', '', fallback([g('packages'), ["public/{$path}"]]));
	$package = preg_replace('#/public/.*#', '', $url);
	@mkdir('public/'.dirname($package), 0755, true);
	@symlink(str_repeat('../', substr_count($package, '/') + 1)."{$package}/public", "public/{$package}");
	$url = href('public/'.preg_replace('#public/#', '', $url), true);
	if ($return === true) {
		return $url;
	}
	echo $url;
}

// Hyper link
function href($path, $return = false)
{
	$url = '/'.trim(
		preg_replace('/index.php$/', '',
			preg_replace("#^{$_SERVER['DOCUMENT_ROOT']}#", '', $_SERVER['SCRIPT_FILENAME'])
		),'/'
	)."/{$path}";
	if ($return === true) {
		return $url;
	}
	echo $url;
}

// h
function h($str)
{
	echo htmlentities($str);
}
