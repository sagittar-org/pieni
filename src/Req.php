<?php
namespace pieni;

class Req
{
	public function __construct()
	{
		$config = new \pieni\Sync\Handler('config', [
			['\pieni\Sync\Json', ['path' => FCPATH.'/sync/json']],
			['\pieni\Sync\Excel', ['path' => FCPATH.'/sync/excel']],
			['\pieni\Proto\Config', []],
		]);
		$GLOBALS['config'] = $config->get();
		$database = $GLOBALS['config']['db']['database']['value'];
		$GLOBALS['db'] = new \mysqli($GLOBALS['config']['db']['host']['value'], $GLOBALS['config']['db']['user']['value'], $GLOBALS['config']['db']['password']['value'], $database);
		$actual_database = new \pieni\Sync\Handler('actual_database', [
			['\pieni\Sync\Json', ['path' => FCPATH.'/sync/json']],
			['\pieni\Proto\ActualDatabase', ['database' => $database, 'db' => g('db')]],
		]);
		$application_database = new \pieni\Sync\Handler('application_database', [
			['\pieni\Sync\Json', ['path' => FCPATH.'/sync/json']],
			['\pieni\Sync\Excel', ['path' => FCPATH.'/sync/excel']],
			['\pieni\Proto\ApplicationDatabase', ['actual_database' => $actual_database]],
		]);
		$this->request_database = new \pieni\Sync\Handler('request_database', [
			['\pieni\Sync\Json', ['path' => FCPATH.'/sync/json']],
			['\pieni\Proto\RequestDatabase', ['application_database' => $application_database]],
		]);
		$actual_table = new \pieni\Sync\Handler('actual_table', [
			['\pieni\Sync\Json', ['path' => FCPATH.'/sync/json']],
			['\pieni\Proto\ActualTable', ['database' => $database, 'db' => g('db')]],
		]);
		$application_table = new \pieni\Sync\Handler('application_table', [
			['\pieni\Sync\Json', ['path' => FCPATH.'/sync/json']],
			['\pieni\Sync\Excel', ['path' => FCPATH.'/sync/excel']],
			['\pieni\Proto\ApplicationTable', ['actual_table' => $actual_table]],
		]);
		$GLOBALS['request_table'] = new \pieni\Sync\Handler('request_table', [
			['\pieni\Sync\Json', ['path' => FCPATH.'/sync/json']],
			['\pieni\Proto\RequestTable', ['request_database' => $this->request_database, 'application_table' => $application_table]],
		]);
	}

	public function request($path_info)
	{
		$params = ($path_info = trim($path_info, '/')) !== '' ? explode('/', $path_info) : [];
		$this->type = isset($params[0]) && $params[0] === 'api' ? array_shift($params) : 'view';
		$this->actor = isset($params[0]) && in_array($params[0], array_slice(array_keys(g('config')['actors']), 1)) ? array_shift($params) : array_keys(g('config')['actors'])[0];
		$GLOBALS['request_database'] = $this->request_database->get($this->actor);
		$this->class = isset($params[0]) ? array_shift($params) : 'welcome';
		$this->method = isset($params[0]) ? array_shift($params) : 'index';
		$this->params = $params;
		require_once Core::fallback([Core::g('packages'), ['controllers/'.ucfirst($this->class).'.php']]);
		$controller = new $this->class();
		$vars = call_user_func_array([$controller, $this->method], $this->params);
		return $vars;
	}

	public function response($vars)
	{
		if ($this->type === 'view') {
			$vars['view'] = "{$this->class}/{$this->method}";
			Load::view('response', $vars, '', $this->class);
		} else {
			echo json_encode($vars, JSON_PRETTY_PRINT)."\n";
		}
	}
}
