<?php
class Aliases
{
	public function index()
	{
		load_helper('tables');
		instantiate_config_handler();
		load_library('Db', 'db', lib('config_handler')->get('core')['db']);
		instantiate_database_schema_handler(lib('db'));
		instantiate_aliases_handler(lib('db'), lib('database_schema_handler'));
		load_model('AliasesModel', 'aliases_model', lib('aliases_handler'));
		$vars['columns'] = lib('aliases_handler')->columns;
		$vars['data'] = mod('aliases_model')->index();
		return $vars;
	}
}
