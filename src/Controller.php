<?php
namespace pieni;

class Controller
{
	public function __construct()
	{
		$this->vars['nav_tables'] = array_keys(g('request_database')['tables']);
	}
}
