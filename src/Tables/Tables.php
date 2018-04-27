<?php
class Tables
{
	public function __construct($drivers)
	{
		$this->drivers = $drivers;
	}

	public function get($name, $cache = false)
	{
		if ($cache === true) {
			return $this->drivers[0]->get($this->columns, $name);
		}
		foreach ($this->drivers as $driver) {
			$times[] = $driver->time($name);
		}
		if (max($times) === false) {
			$data = $this->default($name);
		} else {
			foreach ($this->drivers as $i => $driver) {
				if ($times[$i] === max($times)) {
					$data = $this->drivers[$i]->get($this->columns, $name);
					break;
				}
			}
		}
		$this->put($name, $data);
		return $data;
	}

	private function put($name, $data)
	{
		foreach ($this->drivers as $driver) {
			$driver->put($this->columns, $name, $data);
		}
	}
}
