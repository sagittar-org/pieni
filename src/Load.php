<?php
namespace pieni;

class Load
{
	public static function view($name, $vars = [], $indent = '', $class = '')
	{
		ob_start();
		require Core::fallback([Core::g('packages'), ['views'], [$class, ''], ["{$name}.php"]]);
		$result = ob_get_clean();
		echo $indent.str_replace("\n", "\n{$indent}", trim($result))."\n";
	}
}
