<?php
class TablesRequestSchema
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
		'columns' => [
			'type',
			'nullable',
			'default',
			'extra',
			'comment',
		],
		'hidden' => [
		],
	];

	public function __construct($database_schema_handler, $application_schema_handler)
	{
		$this->database_schema_handler = $database_schema_handler;
		$this->application_schema_handler = $application_schema_handler;
	}

	public function mtime($name)
	{
		return 0;
	}

	public function get($columns, $name)
	{
		$database_schema = $this->database_schema_handler->get($name);
		$application_schema = $this->application_schema_handler->get($name);
		$data['scalars'] = $application_schema['scalars'];
		$data['primary_keys'] = $database_schema['primary_keys'];
		$data['parents'] = $database_schema['parents'];
		$data['parents'] = $database_schema['parents'];
		$data['columns'] = $database_schema['columns'];
		$data['join'] = $application_schema['scalars'];
		$data['columns'] = $application_schema['scalars'];
		$data['hidden'] = $application_schema['scalars'];
		return $data;
	}

	public function put($columns, $name, $data)
	{
	}
}
