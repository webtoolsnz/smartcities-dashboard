<?php
/**
 * This file is part of webtoolsnz\smartcities-dashboard
 *
 * @copyright Copyright (c) 2017 Webtools Ltd
 * @license http://opensource.org/licenses/MIT
 * @link https://github.com/webtoolsnz/smartcities-dashboard
 * @package webtoolsnz/smartcities-dashboard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */



namespace app\helpers;

use PHPExcel;
use PHPExcel_IOFactory;
use PHPExcel_Cell;
use PHPExcel_Cell_AdvancedValueBinder;
use PHPExcel_Style_NumberFormat;

class ExcelHelper
{
    protected $dataFile;

    public function __construct($path)
    {
        $this->dataFile = PHPExcel_IOFactory::load($path);
    }

    public function getColumn($col) {
        return new CellIterator($this->dataFile, $col);
    }

    public function getColumns() {
        return new MultiCellIterator($this->dataFile, true, func_get_args());
    }
}

class CellIterator implements \Iterator
{
    private $dataFile;
    private $highestRow;
    private $column;
    private $row;
    private $skipHeader;

    public function __construct($file, $col, $skipHeader = true)
    {
        $this->dataFile = $file;
        $this->column = $col;
        $this->skipHeader = $skipHeader;
        $this->row = $skipHeader ? 2 : 1;
        $this->highestRow = $this->dataFile->getActiveSheet()->getHighestDataRow($col);
    }

    public function current()
    {
        return $this->dataFile->getActiveSheet()->getCellByColumnAndRow($this->column, $this->row)->getValue();
    }

    public function key ()
    {
        return $this->column . $this->row;
    }

    public function next ()
    {
        ++$this->row;
    }

    public function rewind ()
    {
        $this->row = $this->skipHeader ? 2 : 1;
    }

    public function valid ()
    {
        return ($this->row <= $this->highestRow);
    }

}

class MultiCellIterator implements \Iterator
{
    private $dataFile;
    private $highestRow;
    private $columns;
    private $formats;
    private $row;
    private $skipHeader;

    public function __construct($file, $skipHeader = true, $cols)
    {
        $this->dataFile = $file;
        $this->columns = [];
        $this->formats = [];
        $this->skipHeader = $skipHeader;
        $this->row = $skipHeader ? 2 : 1;
        foreach ($cols as $col) {
            if (is_array($col)) {
                $key = array_keys($col)[0];
                $this->formats[$key] = $col[$key];
                $col = $key;
                $this->columns[] = $key;
            } else {
                $this->columns[] = $col;
            }
            $potentialRow = $this->dataFile->getActiveSheet()->getHighestDataRow($col);
            if (!isset($this->highestRow)) {
                $this->highestRow = $potentialRow;
            }
            $this->highestRow = min($potentialRow, $this->highestRow);
        }
    }

    public function current()
    {
        $cells = [];
        foreach ($this->columns as $column) {
            $sheet = $this->dataFile->getActiveSheet();
            $coords = '' . $column . $this->row;
            if (array_key_exists($column, $this->formats)) {
                PHPExcel_Cell::setValueBinder( new PHPExcel_Cell_AdvancedValueBinder() );
                $sheet->getStyle($coords)->getNumberFormat()->setFormatCode($this->formats[$column]);
                $cells[$column] = $sheet->getCell($coords)->getFormattedValue();
            } else {
                $cells[$column] = $sheet->getCell($coords)->getValue();
            }
        }
        return $cells;
    }

    public function key()
    {
        return $this->row;
    }

    public function next()
    {
        ++$this->row;
    }

    public function rewind()
    {
        $this->row = $this->skipHeader ? 2 : 1;
    }

    public function valid()
    {
        return ($this->row <= $this->highestRow);
    }

}