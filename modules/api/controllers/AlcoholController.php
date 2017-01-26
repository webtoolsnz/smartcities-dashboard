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


class AlcoholController extends BaseController
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

    public function actionTimeline()
    {
        $data = [
            "Received" => [
                ["label" => "Jan", "value" => 23],
                ["label" => "Feb", "value" => 16],
                ["label" => "Mar", "value" => 20],
                ["label" => "Apr", "value" => 25],
                ["label" => "May", "value" => 19],
                ["label" => "Jun", "value" => 12],
                ["label" => "Jul", "value" => 12],
                ["label" => "Aug", "value" => 15],
                ["label" => "Sep", "value" => 17],
                ["label" => "Oct", "value" => 22],
                ["label" => "Nov", "value" => 28],
                ["label" => "Dec", "value" => 34],
            ]
        ];
        return json_encode($data);
    }
}
