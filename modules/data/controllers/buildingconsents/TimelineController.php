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


namespace app\modules\data\controllers\buildingconsents;

use Yii;

use app\helpers\ExcelHelper;
use app\helpers\DataHelper;

use yii\web\Controller;


class TimelineController extends Controller
{
    public static function getTimeline($year=null) {
        $dataFile = new ExcelHelper(Yii::$app->basePath . '/data/ccc_smart_cities_data.xlsx');
        $dataColumns = $dataFile->getColumns(['A' => 'yyyy-mm-dd'], 'E', 'F', 'J', 'K');

        $data = [
            'Commercial' => [],
            'Residential' => []
        ];

        $commercialData = DataHelper::summingAggregator();
        $residentialData = DataHelper::summingAggregator();

        foreach ($dataColumns as $row => $cell) {
            if (strpos($cell['F'], $year) === false) {
                continue;
            }
            $sort = $cell['A'];
            $label = substr($cell['E'], 0, 3);
            $commercialData->add($label, $cell['J'], $sort);
            $residentialData->add($label, $cell['K'], $sort);
        }

        foreach ($commercialData->totals() as $key => $value) {
            $data['Commercial'][] = [
                'label' => $key,
                'value' => $value
            ];
        }

        foreach ($residentialData->totals() as $key => $value) {
            $data['Residential'][] = [
                'label' => $key,
                'value' => $value
            ];
        }

        return $data;
    }
}