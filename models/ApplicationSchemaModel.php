<?php
class ApplicationSchemaModel
{
	public function __construct($application_schema_handler)
	{
		$this->application_schema_handler = $application_schema_handler;
	}

	public function index($name)
	{
		return $this->application_schema_handler->get($name);
	}
}
