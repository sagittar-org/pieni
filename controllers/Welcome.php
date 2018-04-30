<?php
class Welcome
{
	public function index()
	{
		// Redirect to 'Get Started' page, if application directory does not exists
		if (!file_exists(FCPATH.'/application')) {
			redirect('welcome/get_started');
		}
		return ['message' => 'Welcome'];
	}

	public function get_started()
	{
	}

	public function start_hack()
	{
//		shell_exec('unzip -cq '.__DIR__.'/../misc/third_party/sakila/sakila.dump.zip | mysql -uroot');
		shell_exec('rm -r '.FCPATH.'/application');
		mkdir(FCPATH.'/application');
		load_library('Db', 'db', 'localhost', 'root', '', 'sakila');

		// Database schema handler
		load_library('Tables/TablesJson', 'tables_json_database_schema', FCPATH.'/application/database_schemas');
		load_library('TablesDatabaseSchema', 'tables_database_schema', lib('db'));
		load_library('Tables/Tables', 'database_schema_handler', [lib('tables_json_database_schema'), lib('tables_database_schema')]);

		// Aliases handler
		load_library('Tables/TablesJson', 'tables_json_aliases', FCPATH.'/application');
		load_library('TablesAliases', 'tables_aliases', lib('db'), lib('database_schema_handler'));
		load_library('Tables/Tables', 'aliases_handler', [lib('tables_json_aliases'), lib('tables_aliases')]);

		lib('aliases_handler')->get('aliases');

//		redirect('welcome');
		exit;
	}
}
