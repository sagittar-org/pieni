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
		load_library('Tables/TablesJson', 'tables_json', FCPATH.'/application/database_schemas');
		load_library('TablesDatabaseSchema', 'tables_database_schema', lib('db'));
		load_library('Tables/Tables', 'database_schema_handler', [lib('tables_json'), lib('tables_database_schema')]);
		load_library('TablesAliases', 'aliases_schema', lib('db'), lib('database_schema_handler'));
		load_library('Tables/Tables', 'aliases_handler', [lib('tables_json'), lib('tables_database_schema')]);


		$tables = array_column(lib('db')->query("SELECT `TABLE_NAME` FROM `information_schema`.`TABLES` WHERE `TABLE_SCHEMA` = '".lib('db')->database."' AND `TABLE_TYPE` = 'BASE TABLE'")->fetch_all(), 0);
		foreach ($tables as $table) {
			lib('database_schema_handler')->get($table);
		}

//		redirect('welcome');
		exit;
	}
}
