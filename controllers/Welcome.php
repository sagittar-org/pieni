<?php
class Welcome
{
	public function index()
	{
		// Redirect to 'Get Started' page, if application directory does not exists
		if (!file_exists(FCPATH.'/application')) {
			redirect('welcome/get_started');
		}

		// Database
		load_library('Db', 'db', 'localhost', 'root', '', 'sakila');

		// Database schema handler
		load_library('Tables/TablesJson', 'tables_json_database_schema', FCPATH.'/application/database_schemas');
		load_library('TablesDatabaseSchema', 'tables_database_schema', lib('db'));
		load_library('Tables/Tables', 'database_schema_handler', [lib('tables_json_database_schema'), lib('tables_database_schema')]);

		// Database schema
		$tables = array_column(lib('db')->query("SELECT `TABLE_NAME` FROM `information_schema`.`TABLES` WHERE `TABLE_SCHEMA` = '".lib('db')->database."' AND `TABLE_TYPE` = 'BASE TABLE'")->fetch_all(), 0);
		foreach ($tables as $table) {
			$vars['database_schemas'][$table] = lib('database_schema_handler')->get($table);
		}

		// Application schema handler
		load_library('Tables/TablesJson', 'tables_json_application_schema', FCPATH.'/application/application_schemas');
		load_library('TablesApplicationSchema', 'tables_application_schema', lib('db'), lib('database_schema_handler'));
		load_library('Tables/Tables', 'application_schema_handler', [lib('tables_json_application_schema'), lib('tables_application_schema')]);

		// Application schema
		$tables = array_column(lib('db')->query("SELECT `TABLE_NAME` FROM `information_schema`.`TABLES` WHERE `TABLE_SCHEMA` = '".lib('db')->database."' AND `TABLE_TYPE` = 'BASE TABLE'")->fetch_all(), 0);
		foreach ($tables as $table) {
			$vars['application_schemas'][$table] = lib('application_schema_handler')->get($table);
		}

		return $vars;
	}

	public function get_started()
	{
	}

	public function start_hack()
	{
//		shell_exec('unzip -cq '.__DIR__.'/../misc/third_party/sakila/sakila.dump.zip | mysql -uroot');
		shell_exec('rm -r '.FCPATH.'/application');
		mkdir(FCPATH.'/application');
		load_library('Db', 'db', 'localhost', 'root', '', 'employees');

		// Database schema handler
		load_library('Tables/TablesJson', 'tables_json_database_schema', FCPATH.'/application/database_schemas');
		load_library('TablesDatabaseSchema', 'tables_database_schema', lib('db'));
		load_library('Tables/Tables', 'database_schema_handler', [lib('tables_json_database_schema'), lib('tables_database_schema')]);

		// Aliases handler
		load_library('Tables/TablesJson', 'tables_json_aliases', FCPATH.'/application');
		load_library('TablesAliases', 'tables_aliases', lib('db'), lib('database_schema_handler'));
		load_library('Tables/Tables', 'aliases_handler', [lib('tables_json_aliases'), lib('tables_aliases')]);

		// Application schema handler
		load_library('Tables/TablesJson', 'tables_json_application_schema', FCPATH.'/application/application_schemas');
		load_library('Tables/TablesExcel', 'tables_excel_application_schema', FCPATH.'/application/excel/application_schemas');
		load_library('TablesApplicationSchema', 'tables_application_schema', lib('db'), lib('database_schema_handler'));
		load_library('Tables/Tables', 'application_schema_handler', [lib('tables_json_application_schema'), lib('tables_excel_application_schema'), lib('tables_application_schema')]);

		// Get ER diagram (using Aliases / Database schema)
		foreach (lib('aliases_handler')->get('aliases')['scalars'] as $alias_key => $alias) {
			if ($alias['table'] !== $alias_key) continue;
			$nodes[] = "{$alias_key} [label=\"{$alias_key}\"];";
		}
		$nodes_str = implode("\n\t", $nodes);
		foreach (lib('aliases_handler')->get('aliases')['scalars'] as $alias_key => $alias) {
			if ($alias['table'] !== $alias_key) continue;
			foreach (lib('database_schema_handler')->get($alias['table'])['parents'] as $parent_key => $parent) {
				$edges[] = "{$parent['parent_table']} -> {$alias['table']} [arrowhead=\"crow\", label=\"{$parent_key}\", fontsize=10];";
			}
		}
		$edges_str = implode("\n\t", $edges);
		$dot = "digraph database_schema {\n\trankdir=LR;\n\t{$nodes_str}\n\t{$edges_str}\n\t}\n";
		@mkdir('application/public', 0755, true);
		file_put_contents(FCPATH.'/application/schema.dot', $dot);
		shell_exec('dot -Tsvg '.FCPATH.'/application/schema.dot > '.FCPATH.'/application/public/schema.svg');

		// Get application schemas
		$tables = array_column(lib('db')->query("SELECT `TABLE_NAME` FROM `information_schema`.`TABLES` WHERE `TABLE_SCHEMA` = '".lib('db')->database."' AND `TABLE_TYPE` = 'BASE TABLE'")->fetch_all(), 0);
		foreach ($tables as $table) {
			lib('application_schema_handler')->get($table);
		}

		redirect('welcome');
	}
}
