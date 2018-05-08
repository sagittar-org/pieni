<?php
function get_hash($result, $primary_keys)
{
	while ($row = $result->fetch_assoc()) {
		$keys = [];
		foreach ($primary_keys as $primary_key) {
			$keys[] = $row[$primary_key];
		}
		$hash[implode(',', $keys)] = $row;
	}
	return $hash;
}

function where_str($where_data, $indent = '')
{
	foreach ($where_data as $key => $value) {
		$where_arr[] = "`{$key}` = '{$value}'";
	}
	$where_str = implode(" AND\n", $where_arr);
	$where_str = $indent.str_replace("\n", "\n{$indent}", trim($where_str));
	return $where_str;
}

class Crud extends \pieni\Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->alias = g('req')->class;
		$this->table = in_array($this->alias, array_keys(g('request_database')['tables'])) ? $this->alias : g('request_database')['references'][$this->alias]['table'];
		$this->request_table = g('request_table')->get(g('req')->actor.'.'.g('req')->class.'.'.g('req')->method);
	}

	public function index()
	{
		if (g('req')->type === 'view') {
			$this->vars['alias'] = $this->alias;
			$this->vars['request_table'] = $this->request_table;
			$this->vars['elm_id'] = __FUNCTION__."-{$this->vars['alias']}";
			return $this->vars;
		}
		$query = "
SELECT
	*
FROM `{$this->table}` AS `{$this->alias}`
LIMIT 10
		";
		$this->vars['data'] = get_hash(g('db')->query($query), array_keys($this->request_table['primary_keys']));
		return $this->vars;
	}

	public function view($id)
	{
		if (g('req')->type === 'view') {
			$this->vars['alias'] = $this->alias;
			$this->vars['request_table'] = $this->request_table;
			$this->vars['elm_id'] = __FUNCTION__."-{$this->vars['alias']}";
			$this->vars['id'] = $id;
			return $this->vars;
		}
		$where_data = array_combine(array_keys($this->request_table['primary_keys']), explode(',', $id));
		$where_str = where_str($where_data, "\t");
		$query = "
SELECT
	*
FROM `{$this->table}` AS `{$this->alias}`
WHERE
{$where_str}
";
		$this->vars['data'] = g('db')->query($query)->fetch_assoc();
		return $this->vars;
	}
}
