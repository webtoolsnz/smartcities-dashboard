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

use Yii;
use yii\web\Controller;
use GuzzleHttp\Client;


class KiteController extends Controller
{
    public function behaviors()
    {
        return [
            'corsFilter' => [
                'class' => \yii\filters\Cors::className(),
                'cors' => [
                    'Origin' => ['*'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $expiration = 60*60;
        $cachePrefix = 'api.kite';
        $cache = Yii::$app->cache;

        $kiteApi = '';

        $cacheData = $cache->get($cachePrefix);
        if ($cacheData) {
            $data = $cacheData;
        } else {
            $client = new Client();
            $response = $client->get($kiteApi);
            $body = $response->getBody();
            $data = json_decode($body);
            $cache->set($cachePrefix, $data, $expiration);
        }
        return json_encode($data);
    }

    public function actionLocations()
    {
        $data = [
            'markers' => [
                ["name" => "Kite 1",                        "lat" => -43.8100425,             "lng" => 172.96332940000002,],
                ["name" => "Kite 2",                        "lat" => -43.5122822,             "lng" => 172.69785609999997,],
                ["name" => "Kite 3",                    "lat" => -43.4894632,             "lng" => 172.58677690000002,],
                ["name" => "Kite 4",            "lat" => -43.5382477,             "lng" => 172.64003920000005,],
                ["name" => "Kite 5",          "lat" => -43.52503366647045,      "lng" => 172.635697619574,],
                ["name" => "Kite 6",               "lat" => -43.62638526764924,      "lng" => 172.74048398108982,],
                ["name" => "Kite 7",                     "lat" => -43.51377964438659,      "lng" => 172.59094516959226,],
                ["name" => "Kite 8",                        "lat" => -43.544733822426984,     "lng" => 172.5233243306884,],
                ["name" => "Kite 9",                       "lat" => -43.53267437780561,      "lng" => 172.67606462485355,],
                ["name" => "Kite 10",                  "lat" => -43.7805517,             "lng" => 172.77813809999998,],
                ["name" => "Kite 11",                     "lat" => -43.60258524910379,      "lng" => 172.7207104653229,],
                ["name" => "Kite 12",                        "lat" => -43.5320544,             "lng" => 172.63622540000006,],
                ["name" => "Kite 13",                  "lat" => -43.507026585933026,     "lng" => 172.72910501744389,],
                ["name" => "Kite 14",                              "lat" => -43.49419041016871,      "lng" => 172.6070864509262,],
                ["name" => "Kite 15",                       "lat" => -43.481759,              "lng" => 172.70699969999998,],
                ["name" => "Kite 16",                     "lat" => -43.47744119266485,      "lng" => 172.61662970614316,],
                ["name" => "Kite 17",                       "lat" => -43.50513951970527,      "lng" => 172.66294997297666,],
                ["name" => "Kite 18",                       "lat" => -43.56136966293645,      "lng" => 172.6379706375733,],
                ["name" => "Kite 19",                         "lat" => -43.55637409399257,      "lng" => 172.6181724601105,],
                ["name" => "Kite 20",                      "lat" => -43.5816721,             "lng" => 172.5693387,],
                ["name" => "Kite 21",             "lat" => -43.5358429,             "lng" => 172.56357000000003,],
                ["name" => "Kite 22",               "lat" => -43.8100425,             "lng" => 172.96332940000002,],
            ]
        ];

        return json_encode($data);
    }
}
