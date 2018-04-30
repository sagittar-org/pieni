<?php
class TablesAliases
{
	public function __construct($db, $database_schema_handler)
	{
		$this->db = $db;
		$this->database_schema_handler = $database_schema_handler;
	}

	public function mtime($name)
	{
		$mtime = 0;
		$tables = array_column($this->db->query("SELECT `TABLE_NAME` FROM `information_schema`.`TABLES` WHERE `TABLE_SCHEMA` = '{$this->db->database}' AND `TABLE_TYPE` = 'BASE TABLE'")->fetch_all(), 0);
		foreach ($tables as $table) {
			$mtime = max($mtime, $this->database_schema_handler->mtime($table));
		}
		return $mtime;
	}

	public function get($name)
	{
		$tables = array_column($this->db->query("SELECT `TABLE_NAME` FROM `information_schema`.`TABLES` WHERE `TABLE_SCHEMA` = '{$this->db->database}' AND `TABLE_TYPE` = 'BASE TABLE'")->fetch_all(), 0);
		foreach ($tables as $table) {
			$database_schema = $this->database_schema_handler->get($table);
			$data[$table] = ['table' => $table];
			foreach ($database_schema['parents'] as $parent_key => $parent) {
				$data[$parent_key] = ['table' => $table];
			}
		}
		return $data;
	}

	public function put($name, $data)
	{
	}
}
