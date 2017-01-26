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


class EventsController extends Controller
{
    public function actionCredits() {
        return '{
            "credits" : [
                {
                    "key" : "url",
                    "value" : ""
                }
            ]
        }';
    }

    public function actionIndex()
    {
        $expiration = 60*60;
        $cachePrefix = 'api.events.';
        $cache = Yii::$app->cache;

        $eventCategories = [
            ['name' => 'Music', 'slug' => 'music', 'params' => '"pagetype":"category","categoryslug":"music"'],
            ['name' => 'Markets', 'slug' => 'markets', 'params' => '"pagetype":"category","categoryslug":"markets"'],
            ['name' => 'Sport', 'slug' => 'sport', 'params' => '"pagetype":"category","categoryslug":"sport"'],
            ['name' => 'Free', 'slug' => 'free', 'params' => '"pagetype":"free"'],
            ['name' => 'Exhibitions', 'slug' => 'exhibitions', 'params' => '"pagetype":"category","categoryslug":"exhibitions"'],
        ];

        $bethereApi = '';

        $data = [];

        foreach ($eventCategories as $eventCategory) {
            $cacheData = $cache->get($cachePrefix . $eventCategory['slug']);
            if ($cacheData) {
                $data[$eventCategory['slug']] = $cacheData;
            } else {
                $client = new Client();
                $postData = '{"offset":0,"page":1,'.$eventCategory['params'] . '}';
                $response = $client->post($bethereApi, ['body' => $postData]);
                $body = $response->getBody();
                $data[$eventCategory['slug']] = json_decode($body)->events;
                $cache->set($cachePrefix . $eventCategory['slug'], json_decode($body)->events, $expiration);
            }
        }
        return json_encode($data);
    }
}
