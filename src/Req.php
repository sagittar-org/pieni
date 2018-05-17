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
		$filter_database = new \pieni\Sync\Handler('filter_database', [
			['\pieni\Sync\Json', ['path' => FCPATH.'/sync/json']],
			['\pieni\Sync\Excel', ['path' => FCPATH.'/sync/excel']],
			['\pieni\Proto\FilterDatabase', []],
		]);
		$this->request_database = $request_database = new \pieni\Sync\Handler('request_database', [
			['\pieni\Sync\Json', ['path' => FCPATH.'/sync/json']],
			['\pieni\Proto\RequestDatabase', ['actual_database' => $actual_database, 'application_database' => $application_database, 'filter_database' => $filter_database]],
		]);
		$actual_table = new \pieni\Sync\Handler('actual_table', [
			['\pieni\Sync\Json', ['path' => FCPATH.'/sync/json']],
			['\pieni\Proto\ActualTable', ['database' => $database, 'db' => g('db')]],
		]);
		$application_table = new \pieni\Sync\Handler('application_table', [
			['\pieni\Sync\Json', ['path' => FCPATH.'/sync/json']],
			['\pieni\Sync\Excel', ['path' => FCPATH.'/sync/excel']],
			['\pieni\Proto\ApplicationTable', ['config' => $config, 'actual_database' => $actual_database, 'actual_table' => $actual_table]],
		]);
		$filter_table = new \pieni\Sync\Handler('filter_table', [
			['\pieni\Sync\Json', ['path' => FCPATH.'/sync/json']],
			['\pieni\Sync\Excel', ['path' => FCPATH.'/sync/excel']],
			['\pieni\Proto\FilterTable', []],
		]);
		$GLOBALS['request_table'] = new \pieni\Sync\Handler('request_table', [
			['\pieni\Sync\Json', ['path' => FCPATH.'/sync/json']],
			['\pieni\Proto\RequestTable', ['request_database' => $request_database, 'actual_table' => $actual_table, 'application_table' => $application_table, 'filter_table' => $filter_table]],
		]);
	}

	public function request($path_info)
	{
		$params = ($path_info = trim($path_info, '/')) !== '' ? explode('/', $path_info) : [];
		$this->type = isset($params[0]) && $params[0] === 'api' ? array_shift($params) : 'view';
		$this->language = isset($params[0]) && in_array($params[0], array_slice(array_keys(g('config')['languages']), 1)) ? array_shift($params) : array_keys(g('config')['languages'])[0];
		$this->actor = isset($params[0]) && in_array($params[0], array_slice(array_keys(g('config')['actors']), 1)) ? array_shift($params) : array_keys(g('config')['actors'])[0];
		$GLOBALS['request_database'] = $this->request_database->get($this->actor);
		$this->class = isset($params[0]) ? array_shift($params) : 'welcome';
		$this->method = isset($params[0]) ? array_shift($params) : 'index';
		$this->params = $params;
		$files = [ucfirst($this->class).'.php'];
		if (in_array($this->class, array_keys(g('request_database')['tables'])) || in_array($this->class, array_keys(g('request_database')['references']))) {
			$files[] = 'Crud.php';
		}
		$fallback = Core::fallback([Core::g('packages'), ['controllers'], $files]);
		$actual_class = preg_replace('/\.php$/', '', basename($fallback));
		require_once $fallback;
		$controller = new $actual_class();
		$vars = call_user_func_array([$controller, $this->method], $this->params);
		return $vars;
	}

	public function response($vars)
	{
		if ($this->type === 'view') {
			$vars['class'] = $this->class;
			$vars['view'] = $this->method;
			Load::view('response', $vars, '', $this->class);
		} else {
			echo json_encode($vars, JSON_PRETTY_PRINT)."\n";
		}
	}
}
