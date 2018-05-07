<?php
namespace pieni;

class Load
{
	public static function view($name, $vars = [], $indent = '', $class = null)
	{
		$classes = $class !== null ? [$class] : [];
		if (in_array(g('req')->class, array_keys(g('request_database')['tables'])) || in_array(g('req')->class, array_keys(g('request_database')['references']))) {
			$classes[] = 'crud';
		}
		$classes[] = '';
		ob_start();
		require Core::fallback([Core::g('packages'), ['views'], $classes, ["{$name}.php"]]);
		$result = ob_get_clean();
		echo $indent.str_replace("\n", "\n{$indent}", trim($result))."\n";
	}
}
