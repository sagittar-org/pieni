<?php
class DbMysql extends Mysqli
{
	public function __construct($host, $user, $password, $database)
	{
		mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
		parent::__construct($host, $user, $password, $database);
		$this->database = $database;
	}

	public function query($query)
	{
		try {
			$result = parent::query($query);
		} catch (Exception $e) {
			$backtrace = debug_backtrace()[0];
			error_handler(E_USER_ERROR, "{$backtrace['function']}(".print_r($backtrace['args'], true)."): ".$e->getMessage(), $backtrace['file'], $backtrace['line']);
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
