<?php
class TablesExcel
{
	public function __construct($path)
	{
		$this->path = $path;
	}

	public function mtime($name)
	{
		return -1; //file_exists("$this->path}/{$name}.xlsx") ? filemtime("{$this->path}/{$name}.xlsx") : -1;
	}

	public function get($columns, $name)
	{
		$spreadsheet = (new \PhpOffice\PhpSpreadsheet\Reader\Xlsx())->load("{$this->path}/{$name}.xlsx");
		foreach (array_keys($columns) as $table) {
			$data[$table] = [];
			$sheet = $spreadsheet->getSheetByName($table);
			for ($r = 2; ($row = $sheet->getCell('A'.$r)->getValue()) !== NULL; $r++) {
				foreach ($columns[$table] as $c => $column) {
					$data[$table][$row][$column] = (string) $sheet->getCellByColumnAndRow($c + 2, $r)->getValue();
				}
			}
		}
		return $data;
	}

	public function put($columns, $name, $data)
	{
		@mkdir($this->path, 0755, true);
		$spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
		$spreadsheet->removeSheetByIndex(0);
		foreach (array_keys($columns) as $table) {
			$rows = $data[$table];
			$sheet = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, $table);
			$spreadsheet->addSheet($sheet);
			$sheet->setCellValueByColumnAndRow(1, 1, 'key');
			foreach ($columns[$table] as $c => $column) {
				$sheet->setCellValueByColumnAndRow($c + 2, 1, $column);
			}
			$r = 2;
			foreach ($rows as $key => $row) {
				$sheet->setCellValueByColumnAndRow(1, $r, $key);
				foreach ($columns[$table] as $c => $column) {
					$sheet->setCellValueExplicitByColumnAndRow($c + 2, $r, $row[$column], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
				}
				$sheet->getRowDimension($r)->setRowHeight(-1);
				$r++;
			}
			for ($c = 1; $c <= count($columns[$table]) + 1; $c++) {
				$sheet->getColumnDimension(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($c))->setAutoSize(true);
			}
		}
		$spreadsheet->setActiveSheetIndex(0);
		(new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet))->save("{$this->path}/{$name}.xlsx");
	}
}
