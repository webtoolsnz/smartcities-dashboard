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


namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Dash;
use yii\web\HttpException;

/**
 * Class DashController
 * @package app\controllers
 */
class DashController extends Controller
{
    /**
     * @var string
     */
    public $layout = 'blank';

    public function actions()
    {
        return [
            'error' => ['class' => 'yii\web\ErrorAction'],
        ];
    }

    /**
     * @throws HttpException
     */
    public function actionIndex()
    {
        $user = Yii::$app->user;
        $dashes = Dash::find()->where(['status' => Dash::STATUS_ACTIVE])->all();

        return $this->render('index', ['user' => $user, 'dashes' => $dashes]);
    }

    public function actionView($slug)
    {
        $user = Yii::$app->user;
        $dashes = Dash::find()->where(['status' => Dash::STATUS_ACTIVE])->all();
        /* @var $dashes Dash[] */
        /* @var $currentDash Dash */
        $currentDash = Dash::find()->where(['status' => Dash::STATUS_ACTIVE])->andWhere(['slug' => $slug])->one();

        if (empty($currentDash)) {
            Yii::$app->view->theme->topMenuItems = [[
                'label' => '<span class="fa fa-dashboard"></span> Dashboards',
                'url' => ['/'],
                'encode' => false,
            ]];
            throw new \yii\web\NotFoundHttpException('Dashboard not found. It may have been deleted.');
        }

        return $this->render('dash', ['user' => $user, 'dashes' => $dashes, 'currentDash' => $currentDash]);
    }
}
