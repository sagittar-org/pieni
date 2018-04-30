<?php
class Database_schema
{
	public function index($name)
	{
		load_helper('tables');
		load_library('Db', 'db', 'localhost', 'root', '', 'sakila');
		instantiate_database_schema_handler(lib('db'));
		load_model('DatabaseSchemaModel', 'database_schema_model', lib('db'), lib('database_schema_handler'));
		$vars['data'] = mod('database_schema_model')->index($name);
		return $vars;
	}
}
