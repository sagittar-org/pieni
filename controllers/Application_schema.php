<?php
class Application_schema
{
	public function index($name)
	{
		load_helper('tables');
		load_library('Db', 'db', 'localhost', 'root', '', 'sakila');
		instantiate_database_schema_handler(lib('db'));
		instantiate_application_schema_handler(lib('db'), lib('database_schema_handler'));
		load_model('ApplicationSchemaModel', 'application_schema_model', lib('application_schema_handler'));
		$vars['columns'] = lib('application_schema_handler')->columns;
		$vars['data'] = mod('application_schema_model')->index($name);
		return $vars;
	}
}
