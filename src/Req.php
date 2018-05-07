<?php
namespace pieni;

class Req
{
	public function __construct()
	{
		$GLOBALS['config'] = (new \pieni\Sync\Handler('config', [
			['\pieni\Sync\Json', ['path' => FCPATH.'/sync/json']],
			['\pieni\Sync\Excel', ['path' => FCPATH.'/sync/excel']],
			['\pieni\Proto\Config', []],
		]))->get();
	}

	public function request($path_info)
	{
		$params = ($path_info = trim($path_info, '/')) !== '' ? explode('/', $path_info) : [];
		$this->type = isset($params[0]) && $params[0] === 'api' ? array_shift($params) : 'view';
		$this->actor = isset($params[0]) && in_array($params[0], array_slice(array_keys(\pieni\Core::g('config')['actors']), 1)) ? array_shift($params) : array_keys(\pieni\Core::g('config')['actors'])[0];
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
