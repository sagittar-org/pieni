<?php
class DatabaseSchemaModel
{
	public function __construct($database_schema_handler)
	{
		$this->database_schema_handler = $database_schema_handler;
	}

	public function index($name)
	{
		return $this->database_schema_handler->get($name);
	}
}
