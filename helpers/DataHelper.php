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


class DataHelper
{
    public static function summingAggregator()
    {
        return new DataAggregator();
    }
}

class DataAggregator
{
    private $dataStore;
    private $sortKeys;

    public function __construct()
    {
        $this->dataStore = [];
        $this->sortKeys = [];
    }

    public function add($key, $value, $sort = null)
    {
        if ($sort) {
            $this->sortKeys[$sort] = $key;
        } else {
            $this->sortKeys[$key] = $key;
        }
        $this->dataStore[$key][] = $value;
    }

    private function totalForKey($key)
    {
        $total = 0;
        foreach ($this->dataStore[$key] as $datum) {
            $total += intval($datum);
        }
        return $total;
    }

    public function totals()
    {
        ksort($this->sortKeys);
        $totals = [];
        foreach ($this->sortKeys as $key => $value) {
            $totals[$value] = $this->totalForKey($value);
        }
        return $totals;
    }


}