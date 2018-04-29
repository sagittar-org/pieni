<?php
// Library
function lib($name)
{
	return g("libraries.{$name}");
}

// Load library
function load_library($class, $name = null, $params = [])
{
	if ($name === null) {
		$name = $class;
	}
	if (!isset($GLOBALS['libraries'][$name])) {
		load_class($class);
		$GLOBALS['libraries'][$name] = (new ReflectionClass($class))->newInstanceArgs(array_slice(func_get_args(), 2));
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
