<?php
class RequestSchemaModel
{
	public function __construct($request_schema_handler)
	{
		$this->request_schema_handler = $request_schema_handler;
	}

	public function index($name)
	{
		return $this->request_schema_handler->get($name);
	}
}
