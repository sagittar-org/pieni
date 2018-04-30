<?php
class Tables
{
	public function __construct($drivers, $columns = [])
	{
		$this->drivers = $drivers;
		$this->columns = $columns;
	}

	public function mtime($name)
	{
		$latest = ['index' => -1, 'mtime' => -1];
		foreach ($this->drivers as $index => $driver) {
			if (($mtime = $driver->mtime($name)) > $latest['mtime']) {
				$latest = ['index' => $index, 'mtime' => $mtime];
			}
		}
		return $latest['mtime'];
	}

	public function get($name, $first = false)
	{
		if ($first === true) {
			return $this->drivers[0]->get($this->columns, $name);
		}
		$latest = ['index' => -1, 'mtime' => -1];
		foreach ($this->drivers as $index => $driver) {
			if (($mtime = $driver->mtime($name)) > $latest['mtime']) {
				$latest = ['index' => $index, 'mtime' => $mtime];
			}
		}
		$data = $this->drivers[$latest['index']]->get($this->columns, $name);
		foreach ($this->drivers as $driver) {
			$driver->put($this->columns, $name, $data);
		}
		return $data;
	}
}
