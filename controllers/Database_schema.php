<?php
class Database_schema
{
	public function index($name)
	{
		load_helper('tables');
		instantiate_config_handler();
		load_library('Db', 'db', lib('config_handler')->get('core')['db']);
		instantiate_database_schema_handler(lib('db'));
		load_model('DatabaseSchemaModel', 'database_schema_model', lib('database_schema_handler'));
		$vars['columns'] = lib('database_schema_handler')->columns;
		$vars['data'] = mod('database_schema_model')->index($name);
		return $vars;
	}
}
