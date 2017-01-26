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


class WeatherController extends Controller
{
    public function actionCredits() {
        return '{
            "credits" : [
                {
                    "key" : "data",
                    "value" : "none"
                }
            ]
        }';
    }

    public function actionIndex()
    {
        $expiration = 60*30;
        $cachePrefix = 'api.weather.christchurch';
        $cache = Yii::$app->cache;

        $metserviceApi = '';
        $nowApi = '';

        $cacheData = $cache->get($cachePrefix . '.forecast');
        if ($cacheData) {
            $data = $cacheData;
        } else {
            $body = file_get_contents(Yii::$app->basePath . '/data/localForecastchristchurch.txt');
            $data = $this->processData(json_decode($body)->days);
            $cache->set($cachePrefix . '.forecast', $data, $expiration);
        }

        $nowCacheData = $cache->get($cachePrefix . '.now');
        if (false && $nowCacheData) {
            $data['today'][0]->now = $cacheData;
        } else {
            $body = file_get_contents(Yii::$app->basePath . '/data/localObs_christchurch.txt');
            $data['today'][0]->now = json_decode($body);
            $cache->set($cachePrefix . '.now', json_decode($body), $expiration);
        }
        return json_encode($data);
    }

    private function processData($rawData) {
        $i = 0;
        foreach ($rawData as &$day) {
            $day->fcast = strtolower(preg_replace('/[^a-z]/i', '', $day->forecastWord));
            $day->abbr = substr($day->dow, 0, 3);
            $day->cadence = ($i++ % 2 == 0) ? 'even' : 'odd';
        }
        $today = array_splice($rawData, 0, 1);
        $nextFiveDays = array_splice($rawData, 0, 5);
        return [
            'today' => $today,
            'days' => $nextFiveDays
        ];
    }
}
