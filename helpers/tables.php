<?php
function instantiate_database_schema_handler($db)
{
	load_library('Tables/TablesJson', 'tables_json_database_schema', FCPATH.'/application/database_schemas');
	load_library('TablesDatabaseSchema', 'tables_database_schema', $db);
	load_library('Tables/Tables', 'database_schema_handler', [
		lib('tables_json_database_schema'),
		lib('tables_database_schema'),
	]);
}

function instantiate_aliases_handler($db, $database_schema_handler)
{
	load_library('Tables/TablesJson', 'tables_json_aliases', FCPATH.'/application');
	load_library('TablesAliases', 'tables_aliases', $db, $database_schema_handler);
	load_library('Tables/Tables', 'aliases_handler', [
		lib('tables_json_aliases'),
		lib('tables_aliases'),
	]);
}

function instantiate_application_schema_handler($db, $database_schema_handler)
{
	load_library('Tables/TablesJson', 'tables_json_application_schema', FCPATH.'/application/application_schemas');
	load_library('Tables/TablesExcel', 'tables_excel_application_schema', FCPATH.'/application/excel/application_schemas');
	load_library('Tables/TablesMysql', 'tables_mysql_application_schema', $db->database.'_application_schemas', $db);
	load_library('TablesApplicationSchema', 'tables_application_schema', $db, $database_schema_handler);
	load_library('Tables/Tables', 'application_schema_handler', [
		lib('tables_json_application_schema'),
		lib('tables_excel_application_schema'),
		lib('tables_mysql_application_schema'),
		lib('tables_application_schema'),
	]);
}
