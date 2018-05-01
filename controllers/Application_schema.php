<?php
class Application_schema
{
	public function index($name)
	{
		load_helper('tables');
		instantiate_config_handler();
		load_library('Db', 'db', lib('config_handler')->get('core')['db']);
		instantiate_database_schema_handler(lib('db'));
		instantiate_application_schema_handler(lib('db'), lib('database_schema_handler'));
		load_model('ApplicationSchemaModel', 'application_schema_model', lib('application_schema_handler'));
		$vars['columns'] = lib('application_schema_handler')->columns;
		$vars['data'] = mod('application_schema_model')->index($name);
		return $vars;
	}
}
