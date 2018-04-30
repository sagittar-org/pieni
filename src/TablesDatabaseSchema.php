<?php
class TablesDatabaseSchema
{
	public $columns = [
		'scalars' => [
			'comment',
			'create_time',
			'update_time',
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
	];

	public function __construct($db)
	{
		$this->db = $db;
	}

	public function mtime($name)
	{
		return strtotime($this->db->value("
			SELECT
				`CREATE_TIME`
			FROM
				`information_schema`.`TABLES`
			WHERE
				`TABLE_SCHEMA` = '{$this->db->database}' AND
				`TABLE_NAME` = '{$name}'
		")['value']);
	}

	public function get($columns, $name)
	{
		$data['scalars']['comment'] = $this->db->value("
			SELECT
				`TABLE_COMMENT`
			FROM
				`information_schema`.`TABLES`
			WHERE
				`TABLE_SCHEMA` = '{$this->db->database}' AND
				`TABLE_NAME` = '{$name}'
		");
		$data['scalars']['create_time'] = $this->db->value("
			SELECT
				`CREATE_TIME`
			FROM
				`information_schema`.`TABLES`
			WHERE
				`TABLE_SCHEMA` = '{$this->db->database}' AND
				`TABLE_NAME` = '{$name}'
		");
		$data['scalars']['update_time'] = $this->db->value("
			SELECT
				`UPDATE_TIME`
			FROM
				`information_schema`.`TABLES`
			WHERE
				`TABLE_SCHEMA` = '{$this->db->database}' AND
				`TABLE_NAME` = '{$name}'
		");
		$data['primary_keys'] = $this->db->hashes("
			SELECT
				`COLUMN_NAME`
			FROM
				`information_schema`.`COLUMNS`
			WHERE
				`TABLE_SCHEMA` = '{$this->db->database}' AND
				`TABLE_NAME` = '{$name}' AND
				`COLUMN_KEY` = 'PRI'
			ORDER BY
				`ORDINAL_POSITION` ASC
		", ['COLUMN_NAME'], true);
		$data['children'] = $this->db->hashes("
			SELECT
				`CONSTRAINT_NAME`
			FROM
				`information_schema`.`REFERENTIAL_CONSTRAINTS`
			NATURAL JOIN
				`information_schema`.`KEY_COLUMN_USAGE`
			WHERE
				`TABLE_SCHEMA` = '{$this->db->database}' AND
				`REFERENCED_TABLE_NAME` = '{$name}'
			ORDER BY
				`TABLE_NAME` ASC,
				`ORDINAL_POSITION` ASC
		", ['CONSTRAINT_NAME'], true);
		$data['parents'] = $this->db->hashes("
			SELECT
				`CONSTRAINT_NAME`,
				`COLUMN_NAME` AS `column`,
				`REFERENCED_TABLE_NAME` AS `parent_table`,
				`REFERENCED_COLUMN_NAME` AS `parent_column`,
				`UPDATE_RULE` AS `update_rule`,
				`DELETE_RULE` AS `delete_rule`
			FROM
				`information_schema`.`REFERENTIAL_CONSTRAINTS`
			NATURAL JOIN
				`information_schema`.`KEY_COLUMN_USAGE`
			WHERE
				`TABLE_SCHEMA` = '{$this->db->database}' AND
				`TABLE_NAME` = '{$name}'
			ORDER BY
				`ORDINAL_POSITION` ASC
		", ['CONSTRAINT_NAME'], true);
		$data['columns'] = $this->db->hashes("
			SELECT
				`COLUMN_NAME`,
				`COLUMN_TYPE` AS `type`,
				`IS_NULLABLE` AS `nullable`,
				IFNULL(`COLUMN_DEFAULT`, 'NULL') AS `default`,
				`EXTRA` AS `extra`,
				`COLUMN_COMMENT` AS `comment`
			FROM
				`information_schema`.`COLUMNS`
			WHERE
				`TABLE_SCHEMA` = '{$this->db->database}' AND
				`TABLE_NAME` = '{$name}'
			ORDER BY
				`ORDINAL_POSITION` ASC
		", ['COLUMN_NAME'], true);
		return $data;
	}

	public function put($columns, $name, $data)
	{
	}
}
