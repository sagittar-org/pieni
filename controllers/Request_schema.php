<?php
class Request_schema
{
	public function index($name)
	{
		load_helper('tables');
		load_library('Db', 'db', 'localhost', 'root', '', 'sakila');
		instantiate_database_schema_handler(lib('db'));
		instantiate_application_schema_handler(lib('db'), lib('database_schema_handler'));
		instantiate_request_schema_handler(lib('database_schema_handler'), lib('application_schema_handler'));
		load_model('RequestSchemaModel', 'request_schema_model', lib('request_schema_handler'));
		$vars['columns'] = lib('request_schema_handler')->columns;
		$vars['data'] = mod('request_schema_model')->index($name);
		return $vars;
	}
}
