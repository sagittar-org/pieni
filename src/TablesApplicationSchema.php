<?php
class TablesApplicationSchema
{
	public $columns = [
		'scalars' => [
			'value',
		],
		'primary_keys' => [
		],
		'children' => [
		],
		'parents' => [
			'column',
			'parent_table',
			'parent_column',
			'update_rule',
			'delete_rule',
		],
		'columns' => [
			'type',
			'nullable',
			'default',
			'extra',
			'comment',
		],
		'join' => [
			'table',
			'on',
		],
		'append' => [
			'expr',
			'after',
		],
		'hidden' => [
		],
	];

	public function __construct($db, $database_schema_handler)
	{
		$this->db = $db;
		$this->database_schema_handler = $database_schema_handler;
	}

	public function mtime($name)
	{
		return -1;
	}

	public function get($columns, $name)
	{
		$database_schema = $this->database_schema_handler->get($name);
		$data = $database_schema;
		$data['scalars']['display'] = ['value' => "`_alias_`.`".array_keys($database_schema['columns'])[0].'`'];
		foreach ($database_schema['columns'] as $column_key => $column) {
			if (!in_array($column_key, array_keys($database_schema['primary_keys'])) && preg_match('/char/', $column['type'])) {
				$data['scalars']['display'] = ['value' => "`_alias_`.`{$column_key}`"];
				break;
			}
		}
		$data['join'] = [];
		$data['append'] = [];
		$data['hidden'] = [];
		foreach ($database_schema['parents'] as $parent_key => $parent) {
			$data['join'][$parent_key] = ['table' => $parent['parent_table'], 'on' => "`{$parent_key}`.`{$parent['parent_column']}` = `{$name}`.`{$parent['column']}`"];
			$data['append'][$parent_key] = ['expr' => '', 'after' => $parent['column']];
			$data['hidden'][$parent['column']] = [];
		}
		return $data;
	}

	public function put($columns, $name, $data)
	{
	}
}
