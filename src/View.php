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
		$url = '/'.trim(
			preg_replace('/index.php$/', '',
				preg_replace("#^{$_SERVER['DOCUMENT_ROOT']}#", '', $_SERVER['SCRIPT_FILENAME'])
			),'/'
		).'/public/'.preg_replace('#public/#', '', $url);
		$url = preg_replace('#/+#', '/', $url);
		if ($return === true) {
			return $url;
		}
		echo $url;
	}

	public static function href($path, $params = [], $return = false)
	{
		$type = isset($params['type']) ? $params['type'] : g('req')->type;
		$language = isset($params['language']) ? $params['language'] : g('req')->language;
		$actor = isset($params['actor']) ? $params['actor'] : g('req')->actor;
		if ($type === 'view') {
			$type = '';
		}
		if ($language === array_keys(g('config')['languages'])[0]) {
			$language = '';
		}
		if ($actor === array_keys(g('config')['actors'])[0]) {
			$actor = '';
		}
		$path = implode('/', [$type, $language, $actor, $path]);
		$url = '/'.trim(
			preg_replace('/index.php$/', '',
				preg_replace("#^{$_SERVER['DOCUMENT_ROOT']}#", '', $_SERVER['SCRIPT_FILENAME'])
			),'/'
		)."/{$path}";
		$url = preg_replace('#/+#', '/', $url);
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
