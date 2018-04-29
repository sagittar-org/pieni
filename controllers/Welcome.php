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
//		shell_exec('unzip -cq '.__DIR__.'/../misc/third_party/sakila/sakila.dump.zip | mysql -uroot');
		shell_exec('rm -r '.FCPATH.'/application');
		mkdir(FCPATH.'/application');
		load_library('Db', 'db', 'localhost', 'root', '', 'sakila');
		load_library('Tables/TablesJson', 'tables_json', FCPATH);
		load_library('TablesAliases', 'tables_aliases', lib('db'));
		load_library('Tables/Tables', 'aliases_handler', [lib('tables_json'), lib('tables_aliases')]);
		$aliases = lib('aliases_handler')->get('aliases');
		e($aliases);
//		redirect('welcome');
		exit;
	}
}
