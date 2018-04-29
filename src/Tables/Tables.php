<?php
class Tables
{
	public function __construct($drivers)
	{
		$this->drivers = $drivers;
	}

	public function get($name, $first = false)
	{
		if ($first === true) {
			return $this->drivers[0]->get($name);
		}
		$latest = ['index' => -1, 'mtime' => -1];
		foreach ($this->drivers as $index => $driver) {
			if (($mtime = $driver->mtime($name)) > $latest['mtime']) {
				$latest = ['index' => $index, 'mtime' => $mtime];
			}
		}
		$data = $this->drivers[$latest['index']]->get($name);
		foreach ($this->drivers as $driver) {
			$driver->put($name, $data);
		}
		return $data;
	}
}
