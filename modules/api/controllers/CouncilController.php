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

class CouncilController extends Controller
{
    public function actionCredits() {
        return '{
            "credits" : [
                {
                    "key" : "dummy data",
                    "value" : "no"
                }
            ]
        }';
    }

    public function actionSpending()
    {
        $data = [
            'spending' => [
                ['type' => 'Sewerage collection, treatment and disposal', 'percentage' => 47.11],
                ['type' => 'Roads and footpaths ', 'percentage' => 26.88],
                ['type' => 'Stormwater drainage', 'percentage' => 8.32],
                ['type' => 'Water supply', 'percentage' => 6.2],
                ['type' => 'Other groups of activities', 'percentage' => 5.36],
                ['type' => 'Arts and culture (including libraries) ', 'percentage' => 3.68],
                ['type' => 'Transport', 'percentage' => 2.45],
            ]
        ];
        return json_encode($data);
    }
}
