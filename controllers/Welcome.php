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
//		shell_exec('mysql -uroot < '.__DIR__.'/../misc/third_party/sakila/sakila.dump');
		shell_exec('rm -r '.FCPATH.'/application');
		mkdir(FCPATH.'/application');
		mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
		load_class('DbMysql');
		load_class('Tables/TablesJson');
		load_class('Tables/TablesExcel');
		load_class('Tables/TablesMysql');
		load_class('Tables/Tables');
		load_class('DatabaseSchema');
		$database_schema = new DatabaseSchema([
			new TablesJson(FCPATH.'/application/database_schemas/json'),
			new TablesExcel(FCPATH.'/application/database_schemas/excel'),
			new TablesMysql('tables', new Mysqli('localhost', 'root', ''))
		], new DbMysql('localhost', 'root', '', 'employees'));
		var_dump($database_schema->get('departments', false));
exit;
//		redirect('welcome');
	}
}
