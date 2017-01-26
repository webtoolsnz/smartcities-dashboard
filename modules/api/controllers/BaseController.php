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

/**
 * Default controller for the `api` module
 */
class BaseController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function getCachedData($key, $expiration, $callback) {
        $cache = Yii::$app->cache;

        $cacheData = $cache->get($key);
        if ($cacheData) {
            $data = $cacheData;
        } else {
            $data = $callback();
            $cache->set($key, $data, $expiration);
        }
        return $data;
    }
}
