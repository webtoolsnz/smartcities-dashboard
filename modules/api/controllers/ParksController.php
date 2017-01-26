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

use yii\web\Controller;

class ParksController extends Controller
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

    public function actionArea()
    {
        $data = [
            'parks' => [
                ['type' => 'Regional Park', 'count' => 150, 'area' => 75000, 'units' => 'm2', 'percentage' => 75],
                ['type' => 'Sports Park', 'count' => 40, 'area' => 25000, 'units' => 'm2', 'percentage' => 25],
            ]
        ];
        return json_encode($data);
    }
}
