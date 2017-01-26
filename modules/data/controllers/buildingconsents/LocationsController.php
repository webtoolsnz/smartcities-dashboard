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


class LocationsController extends Controller
{
    public static function getLocations() {
        $data = [
            'markers' => [
                [
                    'lat' => '-43.514121',
                    'lng' => '172.637345',
                    'name' => 'Edgeware',
                    'desc' => '5 Building Consents in November 2016'
                ],
                [
                    'lat' => '-43.5441881',
                    'lng' => '172.6085173',
                    'name' => 'Addington',
                    'desc' => '9 Building Consents in November 2016'
                ],
                [
                    'lat' => '-43.5473101',
                    'lng' => '172.6771423',
                    'name' => 'Woolston',
                    'desc' => '4 Building Consents in November 2016'
                ]
            ]
        ];

        return $data;
    }
}