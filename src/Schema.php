<?php
class Schema extends Tables
{
	protected $columns = [
		'departments' => ['dept_name'],
		'employees' => ['birth_date', 'first_name', 'last_name', 'gender', 'hire_date'],
		'dept_emp' => ['from_date', 'to_date'],
	];

	protected function default($name)
	{
		return [
			'departments' => [
				'd009' => [
					'dept_name' => 'Customer Service',
				],
				'd005' => [
					'dept_name' => 'Development'
				],
			],
			'employees' => [
				'10001' => [
					'birth_date' => '1953-09-02',
					'first_name' => 'Georgi',
					'last_name' => 'Facello',
					'gender' => 'M',
					'hire_date' => '1986-06-26',
				],
				'10002' => [
					'birth_date' => '1964-06-02',
					'first_name' => 'Bezalel',
					'last_name' => 'Simmel',
					'gender' => 'F',
					'hire_date' => '1985-11-21'
				],
			],
			'dept_emp' => [
			],
		];
	}
}
