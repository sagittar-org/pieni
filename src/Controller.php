<?php
namespace pieni;

class Controller
{
	public function __construct()
	{
		$this->config = new \pieni\Sync\Handler('config', [
			['\pieni\Sync\Json', ['path' => FCPATH.'/sync/json']],
			['\pieni\Sync\Excel', ['path' => FCPATH.'/sync/excel']],
			['\pieni\Proto\Config', []],
		]);
		$config = $this->config->get();
		$this->database = $config['db']['database']['value'];
		$this->db = new \mysqli($config['db']['host']['value'], $config['db']['user']['value'], $config['db']['password']['value']);
		$this->actual_database = new \pieni\Sync\Handler('actual_database', [
			['\pieni\Sync\Json', ['path' => FCPATH.'/sync/json']],
			['\pieni\Proto\ActualDatabase', ['database' => $this->database, 'db' => $this->db]],
		]);
		$this->application_database = new \pieni\Sync\Handler('application_database', [
			['\pieni\Sync\Json', ['path' => FCPATH.'/sync/json']],
			['\pieni\Sync\Excel', ['path' => FCPATH.'/sync/excel']],
			['\pieni\Proto\ApplicationDatabase', ['actual_database' => $this->actual_database]],
		]);
		$this->request_database = new \pieni\Sync\Handler('request_database', [
			['\pieni\Sync\Json', ['path' => FCPATH.'/sync/json']],
			['\pieni\Proto\RequestDatabase', ['actual_database' => $this->actual_database, 'application_database' => $this->application_database]],
		]);
		$this->actual_table = new \pieni\Sync\Handler('actual_table', [
			['\pieni\Sync\Json', ['path' => FCPATH.'/sync/json']],
			['\pieni\Proto\ActualTable', ['database' => $this->database, 'db' => $this->db]],
		]);
		$this->application_table = new \pieni\Sync\Handler('application_table', [
			['\pieni\Sync\Json', ['path' => FCPATH.'/sync/json']],
			['\pieni\Sync\Excel', ['path' => FCPATH.'/sync/excel']],
			['\pieni\Proto\ApplicationTable', ['actual_table' => $this->actual_table]],
		]);
		$this->request_table = new \pieni\Sync\Handler('request_table', [
			['\pieni\Sync\Json', ['path' => FCPATH.'/sync/json']],
			['\pieni\Proto\RequestTable', ['request_database' => $this->request_database, 'actual_table' => $this->actual_table, 'application_table' => $this->application_table]],
		]);
	}
}
