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

class MissingDogsController extends Controller
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

    public function actionIndex()
    {
        $data = [
            'date' => '2016-11-16',
            'missing' => 55,
            'monthly_change' => '5% Increase'
        ];
        return json_encode($data);
    }
}
