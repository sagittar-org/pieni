<?php
namespace pieni;

class View
{
	public static function r($expr)
	{
		echo "<pre>\n";
		print_r($expr);
		echo "</pre>\n";
	}

	public static function e($expr)
	{
		echo "<pre>\n";
		var_export($expr);
		echo "</pre>\n";
	}

	public static function pub($path, $return = false)
	{
		$url = preg_replace('#^'.FCPATH.'/#', '', Core::fallback([Core::g('packages'), ["public/{$path}"]]));
		$package = preg_replace('#/public/.*#', '', $url);
		@mkdir('public/'.dirname($package), 0755, true);
		@symlink(str_repeat('../', substr_count($package, '/') + 1)."{$package}/public", "public/{$package}");
		$url = self::href('public/'.preg_replace('#public/#', '', $url), true);
		if ($return === true) {
			return $url;
		}
		echo $url;
	}

	public static function href($path, $return = false)
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

	public static function h($str)
	{
		echo htmlentities($str, ENT_QUOTES);
	}
}
