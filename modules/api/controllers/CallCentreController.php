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
use app\modules\data\controllers\callcentre\TimelineController;


class CallCentreController extends BaseController
{
    public function actionCredits() {
        return '{
            "credits" : [
                {
                    "key" : "Timeline Source",
                    "value" : "Excel spreadsheet supplied by CCC"
                }
                {
                    "key" : "Breakdown Source",
                    "value" : "Dummy data"
                }
            ]
        }';
    }

    public function actionTimeline($year=null)
    {
        if (!$year) {
            $year = date('Y');
        }

        $expiration = 60*30;
        $cachePrefix = 'api.call-centre.timeline.' . $year;

        $dataFunction = function($year) {
            return TimelineController::getTimeline($year);
        };
        $data = $this->getCachedData($cachePrefix, $expiration, FunctionalHelper::curry($dataFunction, $year));

        return json_encode($data);
    }

    public function actionItBreakdown()
    {
        $data = [
            'as_of' => '29 Nov 2015 - 29 Nov 2016',
            'components' => [
                ['key' => 'Password reset', 'value' => 1897],
                ['key' => 'Upgrades', 'value' => 750],
                ['key' => 'Other', 'value' => 3206],
            ]
        ];
        return json_encode($data);
    }
}
