<?php
class TablesMysql
{
	public function __construct($database, $db)
	{
		$this->database = $database;
		$this->db = $db;
	}

	public function time($name)
	{
		return strtotime($this->db->query("SELECT MAX(`UPDATE_TIME`) FROM `information_schema`.`TABLES` WHERE `TABLE_SCHEMA` = '{$this->database}-{$name}'")->fetch_array()[0]);
	}

	public function get($columns, $name)
	{
		foreach (array_keys($columns) as $table) {
			$data[$table] = [];
			$result = $this->db->query("SELECT `key`, `".(implode('`, `', $columns[$table]))."` FROM `{$this->database}-{$name}`.`{$table}` ORDER BY `id` ASC");
			while (($row = $result->fetch_assoc()) !== null) {
				$key = array_shift($row);
				$data[$table][$key] = $row;
			}
		}
		return $data;
	}

	public function put($columns, $name, $data)
	{
		$this->db->query("DROP DATABASE IF EXISTS `{$this->database}-{$name}`");
		$this->db->query("CREATE DATABASE `{$this->database}-{$name}`");
		foreach (array_keys($columns) as $table) {
			$rows = $data[$table];
			$column_defs = '';
			foreach ($columns[$table] as $c => $column) {
				$column_defs .= ", `{$column}` text NOT NULL";
			}
			$this->db->query("CREATE TABLE `{$this->database}-{$name}`.`{$table}` (`id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT, `key` varchar(255) NOT NULL UNIQUE{$column_defs});");
			foreach ($rows as $key => $row) {
				$field_defs = '';
				foreach ($row as $c => $field) {
					$field_defs .= ", '{$field}'";
				}
				$this->db->query("INSERT INTO `{$this->database}-{$name}`.`{$table}` (`key`, `".(implode('`, `', $columns[$table]))."`) VALUES ('{$key}'{$field_defs});");
			}
		}
	}
}
