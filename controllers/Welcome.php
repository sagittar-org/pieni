<?php
class Welcome extends \pieni\Controller
{
	public function index()
	{
		$vars['nav_tables'] = array_keys($this->request_database->get(\pieni\Core::g('req')->actor)['tables']);
		return $vars;
	}
}
