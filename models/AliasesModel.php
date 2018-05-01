<?php
class AliasesModel
{
	public function __construct($aliases_handler)
	{
		$this->aliases_handler = $aliases_handler;
	}

	public function index()
	{
		return $this->aliases_handler->get('aliases');
	}
}
