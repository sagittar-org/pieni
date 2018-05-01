<?php
class Aliases
{
	public function index()
	{
		load_helper('tables');
		load_library('Db', 'db', 'localhost', 'root', '', 'sakila');
		instantiate_database_schema_handler(lib('db'));
		instantiate_aliases_handler(lib('db'), lib('database_schema_handler'));
		load_model('AliasesModel', 'aliases_model', lib('aliases_handler'));
		$vars['columns'] = lib('aliases_handler')->columns;
		$vars['data'] = mod('aliases_model')->index();
		return $vars;
	}
}
