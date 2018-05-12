<?php
namespace pieni;

class Core
{
	public static function fallback($array, $error = true)
	{
		foreach (self::cartesian($array) as $fallback) {
			if (file_exists($fallback)) {
				return $fallback;
			}
		}
		if ($error === true) {
			$backtrace = debug_backtrace()[2];
			trigger_error("Fallback failed in {$backtrace['file']} on line {$backtrace['line']} <pre>".print_r(debug_backtrace()[0]['args'][0], true)."</pre>", E_USER_ERROR);
		}
		return null;
	}

	public static function cartesian($array)
	{
		$shift = array_shift($array);
		foreach ($shift as $value) {
			if (count($array) > 0) {
				foreach (self::cartesian($array) as $return) {
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

	public static function g($path)
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
}
