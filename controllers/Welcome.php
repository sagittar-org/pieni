<?php
class Welcome
{
	public function __construct()
	{
	}

	public function index()
	{
		// Redirect to 'Get Started' page, if application directory does not exists
		if (!file_exists(FCPATH.'/application')) {
			redirect('welcome/get_started');
		}

		load_helper('tables');

		// Instantiate config handler
		instantiate_config_handler();

		// Instantiate database handler
		load_library('Db', 'db', lib('config_handler')->get('core')['db']);

		// Instantiate database schema handler
		instantiate_database_schema_handler(lib('db'));

		// Instantiate aliases handler
		instantiate_aliases_handler(lib('db'), lib('database_schema_handler'));

		// Instantiate ER diagram handler
		instantiate_er_diagram_handler(lib('database_schema_handler'), lib('aliases_handler'));

		// Instantiate application schema handler
		instantiate_application_schema_handler(lib('db'), lib('database_schema_handler'));

		// Instantiate request schema handler
		instantiate_request_schema_handler(lib('database_schema_handler'), lib('application_schema_handler'));

		$vars['database_schema_columns'] = lib('database_schema_handler')->columns;
		$vars['aliases_columns'] = lib('aliases_handler')->columns;
		$vars['application_schema_columns'] = lib('application_schema_handler')->columns;
		$vars['request_schema_columns'] = lib('request_schema_handler')->columns;
		return $vars;
	}

	public function get_started()
	{
	}

	public function start_hack()
	{
		shell_exec('unzip -cq '.__DIR__.'/../misc/third_party/sakila/sakila.dump.zip | mysql -uroot');
		shell_exec('rm -r '.FCPATH.'/application');
		mkdir(FCPATH.'/application');

		load_helper('tables');

		// Instantiate config handler
		instantiate_config_handler([
			'host' => 'localhost',
			'user' => 'root',
			'password' => '',
			'database' => 'sakila',
		]);

		// Instantiate database handler
		load_library('Db', 'db', lib('config_handler')->get('core')['db']);

		// Instantiate database schema handler
		instantiate_database_schema_handler(lib('db'));

		// Instantiate aliases handler
		instantiate_aliases_handler(lib('db'), lib('database_schema_handler'));

		// Instantiate ER diagram handler
		instantiate_er_diagram_handler(lib('database_schema_handler'), lib('aliases_handler'));

		// Instantiate application schema handler
		instantiate_application_schema_handler(lib('db'), lib('database_schema_handler'));

		// Instantiate request schema handler
		instantiate_request_schema_handler(lib('database_schema_handler'), lib('application_schema_handler'));

		// Get ER diagram (using Aliases / Database schema)
		lib('er_diagram_handler')->get('er_diagram');

		// Get application schemas
		$tables = array_column(lib('db')->query("SELECT `TABLE_NAME` FROM `information_schema`.`TABLES` WHERE `TABLE_SCHEMA` = '".lib('db')->database."' AND `TABLE_TYPE` = 'BASE TABLE'")->fetch_all(), 0);
		foreach ($tables as $table) {
			lib('application_schema_handler')->get($table);
		}

		redirect('welcome');
	}
}
