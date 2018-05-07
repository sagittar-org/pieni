<?php
function g($path)
{
	return \pieni\Core::g($path);
}

function r($expr)
{
	\pieni\View::r($expr);
}

function e($expr)
{
	\pieni\View::e($expr);
}

function pub($path, $return = false)
{
	\pieni\View::pub($path, $return);
}

function href($path, $return = false)
{
	\pieni\View::href($path, $return);
}

function h($str)
{
	\pieni\View::h($str);
}

function load_view($name, $vars = [], $indent = '', $class = '')
{
	\pieni\Load::view($name, $vars, $indent, $class);
}
