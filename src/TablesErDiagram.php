<?php
class TablesErDiagram
{
	public $columns = [
		'scalars' => [
			'value',
		],
	];

	public function __construct($database_schema_handler, $aliases_handler)
	{
		$this->database_schema_handler = $database_schema_handler;
		$this->aliases_handler = $aliases_handler;
	}

	public function mtime($name)
	{
		return 0;
	}

	public function get($columns, $name)
	{
		foreach ($this->aliases_handler->get('aliases')['scalars'] as $alias_key => $alias) {
			if ($alias['table'] !== $alias_key) continue;
			$nodes[] = "{$alias_key} [label=\"{$alias_key}\"];";
		}
		$nodes_str = implode("\n\t", $nodes);
		foreach ($this->aliases_handler->get('aliases')['scalars'] as $alias_key => $alias) {
			if ($alias['table'] !== $alias_key) continue;
			foreach ($this->database_schema_handler->get($alias['table'])['parents'] as $parent_key => $parent) {
				$edges[] = "{$parent['parent_table']} -> {$alias['table']} [arrowhead=\"crow\", label=\"{$parent_key}\", fontsize=10];";
			}
		}
		$edges_str = implode("\n\t", $edges);
		$data['scalars']['er_diagram'] = "digraph {$name} {\n\trankdir=LR;\n\t{$nodes_str}\n\t{$edges_str}\n}\n";
		return $data;
	}

	public function put($columns, $name, $data)
	{
	}
}
