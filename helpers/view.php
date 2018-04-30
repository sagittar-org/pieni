<?php
// Model
function mod($name)
{
	return g("models.{$name}");
}

// Load model
function load_model($class, $name)
{
	if (!isset($GLOBALS['models'][$name])) {
		require_once fallback([g('packages'), ['models'], ["{$class}.php"]]);
		$GLOBALS['models'][$name] = (new ReflectionClass(basename($class)))->newInstanceArgs(array_slice(func_get_args(), 2));
	}
}

function benchmark($label = null)
{
	static $microtime;

	$last_microtime = $microtime;
	$microtime = microtime(true);
	if ($label !== null) {
		e([$label, number_format(($microtime - $last_microtime) * 1000).'ms']);
	}
}

// Library
function lib($name)
{
	return g("libraries.{$name}");
}

// Load library
function load_library($class, $name, $params = [])
{
	if (!isset($GLOBALS['libraries'][$name])) {
		load_class($class);
		$GLOBALS['libraries'][$name] = (new ReflectionClass(basename($class)))->newInstanceArgs(array_slice(func_get_args(), 2));
	}
}

// Load class
function load_class($class)
{
	require_once fallback([g('packages'), ['src'], ["{$class}.php"]]);
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

// Redirect
function redirect($uri)
{
	header('Location: '.href($uri, true));
	exit;
}
