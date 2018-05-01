<?php
class Db extends Mysqli
{
	public function __construct($config)
	{
		parent::__construct($config['host'], $config['user'], $config['password'], $config['database']);
		$this->database = $config['database'];
	}

	public function query($query)
	{
		$result = parent::query($query);
		if ($result === false) {
			trigger_error(json_encode(debug_backtrace()[0] + ['message' => $this->error]), E_USER_ERROR);
		}
		return $result;
	}

	public function hashes($query, $primary_keys, $unset_primary_keys = false)
	{
		$hashes = [];
		foreach ($this->query($query)->fetch_all(MYSQLI_ASSOC) as $row) {
			$keys = [];
			foreach ($primary_keys as $primary_key) {
				$keys[] = $row[$primary_key];
				if ($unset_primary_keys === true) {
					unset($row[$primary_key]);
				}
			}
			$hashes[implode(',', $keys)] = $row;
		}
		return $hashes;
	}

	public function value($query)
	{
		return ['value' => $this->query($query)->fetch_array()[0]];
	}
}
