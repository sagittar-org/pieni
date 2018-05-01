<?php
class TablesSvg
{
	public function __construct($path)
	{
		$this->path = $path;
	}

	public function mtime($name)
	{
		return file_exists("{$this->path}/{$name}.svg") ? filemtime("{$this->path}/{$name}.svg") : -1;
	}

	public function get($columns, $name)
	{
	}

	public function put($columns, $name, $data)
	{
		@mkdir($this->path, 0755, true);




		return file_put_contents("{$this->path}/{$name}.svg", shell_exec("echo '{$data['scalars']['er_diagram']}' | dot -Tsvg"));
	}
}
