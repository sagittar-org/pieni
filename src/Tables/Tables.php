<?php
class Tables
{
	public function __construct($drivers)
	{
		$this->drivers = $drivers;
		$this->columns = end($drivers)->columns;
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
			$mtimes[$index] = $mtime;
		}
		$data = $this->drivers[$latest['index']]->get($this->columns, $name);
		foreach ($this->drivers as $index => $driver) {
			if ($mtimes[$index] >= $latest['mtime']) continue;
			$driver->put($this->columns, $name, $data);
		}
		return $data;
	}
}
