<?php
class TablesJson
{
	public function __construct($path)
	{
		$this->path = $path;
	}

	public function mtime($name)
	{
		return -1; //file_exists("$this->path}/{$name}.json") ? filemtime("{$this->path}/{$name}.json") : -1;
	}

	public function get($columns, $name)
	{
		return json_decode(file_get_contents("$this->path}/{$name}.json"), true);
	}

	public function put($columns, $name, $data)
	{
		@mkdir($this->path, 0755, true);
		return file_put_contents("{$this->path}/{$name}.json", json_encode($data, JSON_PRETTY_PRINT));
	}
}
