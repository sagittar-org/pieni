<?php
class TablesConfig
{
	public $columns = [
		'db' => [
			'value',
		],
	];

	public function __construct($db)
	{
		$this->db = $db;
	}

	public function mtime($name)
	{
		return 0;
	}

	public function get($columns, $name)
	{
		$data['db'] = $this->db;
		return $data;
	}

	public function put($columns, $name, $data)
	{
	}
}
