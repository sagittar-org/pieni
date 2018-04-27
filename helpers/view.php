<?php
// h
function h($str)
{
	echo htmlentities($str);
}

// Redirect
function redirect($uri)
{
	header('Location: '.href($uri, true));
	exit;
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
