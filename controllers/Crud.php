<?php
class Crud extends \pieni\Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->request_table = g('request_table')->get(g('req')->actor.'.'.g('req')->class.'.'.g('req')->method);
		$this->table = g('req')->class;
	}

	public function index()
	{
		$query = "
			SELECT
				*
			FROM `{$this->table}`
			LIMIT 10
		";
		$this->vars['rows'] = g('db')->query($query)->fetch_all(MYSQLI_ASSOC);
		return $this->vars;
	}

	public function view($id)
	{
		return $this->vars;
	}
}
