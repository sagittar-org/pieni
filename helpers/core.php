<?php
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
	$errors = [1 => 'ERROR', 2 => 'WARNING', 4 => 'PARSE', 8 => 'NOTICE', 16 => 'CORE_ERROR', 32 => 'CORE_WARNING', 64 => 'COMPILE_ERROR', 128 => 'COMPILE_WARNING', 256 => 'USER_ERROR', 512 => 'USER_WARNING', 1024 => 'USER_NOTICE', 2048 => 'STRICT', 4096 => 'RECOVERABLE_ERROR', 8192 => 'DEPRECATED', 16384 => 'USER_DEPRECATED'];
	echo "<pre><b>{$errors[$errno]}</b>: {$errstr} in <b>{$errfile}</b> on line <b>{$errline}</b></pre>";
	exit(1);
}

// Request
function request($path_info)
{
	$params = trim($path_info, '/') !== '' ? explode('/', trim($path_info, '/')) : [];
	$class = count($params) > 0 ? array_shift($params) : 'welcome';
	require_once fallback([g('packages'), ['controllers'], [ucfirst($class).'.php', 'crud.php']]);
	$method = count($params) > 0 ? array_shift($method) : 'index';
	$controller = new $class();
	return ['class' => $class, 'method' => $method] + call_user_func_array([$controller, $method], $params);
}

// Load view
function load_view($class, $name, $vars)
{
	require_once fallback([g('packages'), ['views'], [$class, 'crud', ''], ["{$name}.php"]]);
}
