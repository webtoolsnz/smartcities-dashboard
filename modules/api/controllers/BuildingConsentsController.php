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


namespace app\modules\api\controllers;

use app\helpers\FunctionalHelper;
use app\modules\data\controllers\buildingconsents\TimelineController;
use app\modules\data\controllers\buildingconsents\LocationsController;


class BuildingConsentsController extends BaseController
{
    public function actionCredits() {
        return '{
            "credits" : [
                {
                    "key" : "dummy data",
                    "value" : "yes"
                }
            ]
        }';
    }

    public function actionIssued()
    {
        $data = [
            'total' => 7601,
            'as_of' => '29 Nov 2015 - 29 Nov 2016',
            'components' => [
                ['key' => 'Residential dwellings', 'value' => 1700],
                ['key' => 'Amendments', 'value' => 1800],
                ['key' => 'Burners', 'value' => 890],
                //['key' => 'Residential alterations / additions and accessory buildings', 'value' => 777],
                ['key' => 'Residential alterations / additions', 'value' => 777],
                ['key' => 'Commercial', 'value' => 420],
                ['key' => 'Residential multi-unit dwellings', 'value' => 467],
                ['key' => 'Minor Works', 'value' => 888],
            ]
        ];
        return json_encode($data);
    }

    public function actionTimeline($year=null)
    {
        if (!$year) {
            $year = date('Y');
        }

        $expiration = 60*30;
        $cachePrefix = 'api.building-consents.timeline.' . $year;

        $dataFunction = function($year) {
            return TimelineController::getTimeline($year);
        };
        $data = $this->getCachedData($cachePrefix, $expiration, FunctionalHelper::curry($dataFunction, $year));

        return json_encode($data);
    }

    public function actionLocations()
    {
        $dataFunction = function() {
            return LocationsController::getLocations();
        };
        $data = $this->getCachedData('api.building-consents.locations', 30*60, $dataFunction);

        return json_encode($data);
    }

    public function actionValues()
    {
        $data = [
            "date_range" => "November 2016",
            "data" => [
                [
                    "sector" => "Commercial",
                    "value" => "$16,100,000",
                    "movement" => "up",
                ],
                [
                    "sector" => "Residential",
                    "value" => "$6,600,900",
                    "movement" => "down",
                ]
            ]
        ];

        return json_encode($data);
    }

    public function actionFees()
    {
        $data = [
            "date_range" => "November 2016",
            "data" => [
                [
                    "sector" => "Commercial",
                    "value" => "$62,000",
                    "movement" => "up",
                ],
                [
                    "sector" => "Residential",
                    "value" => "$86,100",
                    "movement" => "down",
                ]
            ]
        ];

        return json_encode($data);
    }
}
