<?php
class TablesAliases
{
	public function __construct($db)
	{
		$this->db = $db;
	}

	public function mtime($name)
	{
		return time();
	}

	public function get($name)
	{
		$tables = array_column($this->db->query("SELECT `TABLE_NAME` FROM `information_schema`.`TABLES` WHERE `TABLE_SCHEMA` = '{$this->db->database}' AND `TABLE_TYPE` = 'BASE TABLE'")->fetch_all(), 0);
		foreach ($tables as $table) {
			require fallback([g('packages'), ["schemas/database_schema/{$table}.php"]]);
			$aliases[$table] = ['table' => $table];
			foreach ($database_schema['parents'] as $parent_key => $parent) {
				$aliases[$parent_key] = ['table' => $table];
			}
		}
		return $aliases;
	}

	public function put($name, $data)
	{
	}
}
